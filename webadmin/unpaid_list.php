<?php
// dues_report_print.php
// Lists all students with unpaid dues and paid dues, shows fee breakdowns, per-user subtotals,
// and per-category totals (Due, Hall, Electricity, Contingency) for both sections, with print view.

include("./inc/function.inc.php");
session_start();
require('./inc/constant.inc.php');
require('./inc/connection.inc.php');
require_once("./inc/smtp/class.phpmailer.php");
isAdmin();

// ------------------------------
// Configuration for UNPAID rows (paid rows are actuals from detail tables)
// ------------------------------
$HALL_FEE        = HALL_FEE;      // Taka
$ELECTRICITY_FEE = ELECTRICITY_FEE;     // Taka
$CONTINGENCY_FEE = CONTINGENCY_FEE;     // Taka

// Optional filter (e.g., by batch)
$batch_filter = isset($_GET['batch']) ? get_safe_value($_GET['batch']) : '';
$where_batch  = $batch_filter !== '' ? " AND u.batch = '".mysqli_real_escape_string($con, $batch_filter)."'" : "";

// ------------------------------
// UNPAID: monthly_bill where paid_status = '0'
// Columns expected: monthly_bill(user_id, month_id, year, amount, paid_status)
//                   users(id, name, roll, batch)
//                   month(id, name)
// ------------------------------
$unpaid_sql = "
    SELECT 
    u.id AS user_id,
    u.name,
    u.roll,
    u.batch,
    b.name AS batch_name,     -- batch name from lookup
    mb.month_id,
    mb.year,
    mb.amount AS due_amount,
    m.name AS month_name
FROM users u
JOIN monthly_bill mb 
  ON mb.user_id = u.id 
 AND mb.paid_status = '0'
LEFT JOIN month m 
  ON m.id = mb.month_id
LEFT JOIN batch b
  ON b.id = u.batch         -- users.batch references batch.id
WHERE 1=1 {$where_batch}    -- e.g., AND b.id = 5  or AND b.name = 'CE-23'
ORDER BY u.id, mb.year, mb.month_id;
";
$unpaid_res = mysqli_query($con, $unpaid_sql);

// ------------------------------
// Helpers
// ------------------------------
function group_by_user($res, $is_paid = false, $fees = []) {
    $data = [];
    if ($res && mysqli_num_rows($res) > 0) {
        while ($r = mysqli_fetch_assoc($res)) {
            $uid = $r['user_id'];
            if (!isset($data[$uid])) {
                $data[$uid] = [
                    'name'  => $r['name'],
                    'roll'  => $r['roll'],
                    'batch_name' => $r['batch_name'],
                    'rows'  => [],
                ];
            }
            if ($is_paid) {
                $due  = (float)$r['due_amount'];
                $hall = (float)$r['hall_fee'];
                $elec = (float)$r['electricity_fee'];
                $cont = (float)$r['contingency_fee'];
                $row_total = $due + $hall + $elec + $cont;
                $data[$uid]['rows'][] = [
                    'month_label' => $r['month_name'],
                    'due'         => $due,
                    'hall'        => $hall,
                    'elec'        => $elec,
                    'cont'        => $cont,
                    'total'       => $row_total,
                ];
            } else {
                $due  = (float)$r['due_amount'];
                $hall = (float)$fees['HALL_FEE'];
                $elec = (float)$fees['ELECTRICITY_FEE'];
                $cont = (float)$fees['CONTINGENCY_FEE'];
                $row_total = $due + $hall + $elec + $cont;
                $data[$uid]['rows'][] = [
                    'month_label' => $r['month_name'] . ' ' . $r['year'],
                    'due'         => $due,
                    'hall'        => $hall,
                    'elec'        => $elec,
                    'cont'        => $cont,
                    'total'       => $row_total,
                ];
            }
        }
    }
    return $data;
}

function sum_user_total($rows) {
    $sum = 0;
    foreach ($rows as $r) $sum += (float)$r['total'];
    return $sum;
}

// Group results
$unpaid_grouped = group_by_user($unpaid_res, false, [
    'HALL_FEE'        => $HALL_FEE,
    'ELECTRICITY_FEE' => $ELECTRICITY_FEE,
    'CONTINGENCY_FEE' => $CONTINGENCY_FEE,
]);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dues Report - <?php echo HALL_NAME; ?></title>
<style>
    :root { --fg:#000; --hl:#b7b4b4; }
    body { font-family: Arial, Helvetica, sans-serif; color: var(--fg); }
    .toolbar { margin: 12px 0; display:flex; gap:8px; align-items:center; }
    .btn { padding:8px 14px; background:#1976d2; color:#fff; border:0; border-radius:4px; cursor:pointer; }
    .btn:active { transform: translateY(1px); }
    .w100 { width:100%; border-collapse: collapse; }
    .b1 { border:1px solid #000; }
    .p { padding: 6px 10px; }
    .tc { text-align:center; }
    .tr { text-align:right; }
    .th { background: var(--hl); text-align:center; }
    .secTitle { font-size:18px; font-weight:700; margin: 18px 0 8px; }
    .muted { color:#555; font-size:12px; }
    .money { text-align:right; white-space: nowrap; }
    .header { text-align:center; }
    .header img { height:70px; }
    @media print {
        .toolbar { display:none; }
        body { margin: 0.5in; }
        .pagebreak { page-break-before: always; }
    }
</style>
</head>
<body>

<div class="toolbar">
    <form method="get" action="">
        <label>Batch:</label>
        <input type="text" name="batch" value="<?php echo htmlspecialchars($batch_filter); ?>" />
        <button class="btn" type="submit">Filter</button>
    </form>
    <button class="btn" onclick="window.print()">Print</button>
</div>

<div class="header">
    <img src="<?php echo LOGO; ?>" alt="logo"><br>
    <div style="font-size:22px;font-weight:700;"><?php echo HALL_NAME; ?></div>
    <div class="muted"><?php echo WEBSITE; ?> | Tel: <?php echo TEL; ?> | Email: <?php echo EMAIL; ?></div>
</div>

<?php
// ================= UNPAID SECTION =================
$u_due_total   = 0.0;
$u_hall_total  = 0.0;
$u_elec_total  = 0.0;
$u_cont_total  = 0.0;
$u_grand_total = 0.0;
?>
<div class="secTitle">Unpaid Dues (with fees)</div>
<table class="w100">
    <tr>
        <td class="th b1 p">SL</td>
        <td class="th b1 p">Student</td>
        <td class="th b1 p">Roll</td>
        <td class="th b1 p">Batch</td>
        <td class="th b1 p">Month</td>
        <td class="th b1 p">Due</td>
        <td class="th b1 p">Hall</td>
        <td class="th b1 p">Electricity</td>
        <td class="th b1 p">Contingency</td>
        <td class="th b1 p">Total</td>
    </tr>
    <?php
    $sl = 1;
    $grand_unpaid = 0;
    if (!empty($unpaid_grouped)) {
        foreach ($unpaid_grouped as $uid => $info) {
            $rspan = max(1, count($info['rows']));
            $first = true;
            $user_total = sum_user_total($info['rows']);
            $grand_unpaid += $user_total;

            foreach ($info['rows'] as $row) {
                // accumulate per-row into UNPAID section totals
                $u_due_total  += (float)$row['due'];
                $u_hall_total += (float)$row['hall'];
                $u_elec_total += (float)$row['elec'];
                $u_cont_total += (float)$row['cont'];
                $u_grand_total += (float)$row['total'];

                echo "<tr>";
                if ($first) {
                    echo '<td class="b1 p tc" rowspan="'.$rspan.'">'.$sl.'</td>';
                    echo '<td class="b1 p" rowspan="'.$rspan.'">'.htmlspecialchars($info['name']).'</td>';
                    echo '<td class="b1 p" rowspan="'.$rspan.'">'.htmlspecialchars($info['roll']).'</td>';
                    echo '<td class="b1 p" rowspan="'.$rspan.'">'.htmlspecialchars($info['batch_name']).'</td>';
                    $first = false;
                }
                echo '<td class="b1 p tc">'.htmlspecialchars($row['month_label']).'</td>';
                echo '<td class="b1 p money">'.number_format($row['due'],2).'</td>';
                echo '<td class="b1 p money">'.number_format($row['hall'],2).'</td>';
                echo '<td class="b1 p money">'.number_format($row['elec'],2).'</td>';
                echo '<td class="b1 p money">'.number_format($row['cont'],2).'</td>';
                echo '<td class="b1 p money"><strong>'.number_format($row['total'],2).'</strong></td>';
                echo "</tr>";
            }
            echo '<tr><td class="b1 p tr" colspan="9"><em>'.$info['name'].' due</em></td><td class="b1 p money"><strong>'.number_format($user_total,2).'</strong></td></tr>';
            $sl++;
        }
    } else {
        echo '<tr><td class="b1 p tc" colspan="10">No unpaid dues found</td></tr>';
    }
    ?>
    <!-- Category totals for UNPAID -->
    <tr>
        <td class="b1 p tr" colspan="5"><strong>Category Totals (Unpaid)</strong></td>
        <td class="b1 p money"><strong><?php echo number_format($u_due_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($u_hall_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($u_elec_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($u_cont_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($u_grand_total,2); ?></strong></td>
    </tr>
    <!-- Grand total row for UNPAID -->
    <tr>
        <td class="b1 p tr" colspan="9"><strong>Unpaid Grand Total</strong></td>
        <td class="b1 p money"><strong><?php echo number_format($grand_unpaid,2); ?></strong></td>
    </tr>
</table>

<div class="pagebreak"></div>


<div class="muted" style="margin-top:10px;text-align:right;"><i><b>Developed By The Web Divers</b></i></div>

</body>
</html>

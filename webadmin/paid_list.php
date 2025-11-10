<?php
// dues_report_print.php
// Lists all students with unpaid dues and paid dues, shows fee breakdowns, per-user subtotals,
// and per-category totals (Due, Hall, Electricity, Contingency) for both sections, with print view.

session_start();
include("./inc/constant.inc.php");
include("./inc/connection.inc.php");
include("./inc/function.inc.php");

// ------------------------------
// Configuration for UNPAID rows (paid rows are actuals from detail tables)
// ------------------------------
$HALL_FEE        = 10;      // Taka
$ELECTRICITY_FEE = 100;     // Taka
$CONTINGENCY_FEE = 300;     // Taka

// Optional filter (e.g., by batch)
$batch_filter = isset($_GET['batch']) ? get_safe_value($_GET['batch']) : '';
$where_batch  = $batch_filter !== '' ? " AND u.batch = '".mysqli_real_escape_string($con, $batch_filter)."'" : "";

// ------------------------------
// UNPAID: monthly_bill where paid_status = '0'
// Columns expected: monthly_bill(user_id, month_id, year, amount, paid_status)
//                   users(id, name, roll, batch)
//                   month(id, name)
// ------------------------------

// ------------------------------
// PAID: monthly_payment_details joined with monthly_fee_details, contingency_fee_details
// Tables expected:
//   payments(id, user_id)
//   monthly_payment_details(user_id, payment_id, month_id, monthly_amount)
//   monthly_fee_details(user_id, payment_id, month_id, monthly_amount, fee_type=['hall_fee','electricity_fee'])
//   contingency_fee_details(user_id, payment_id, month_id, contingency_amount)
//   users(id, name, roll, batch)
//   month(id, name)
// ------------------------------
$paid_sql = "
    SELECT
    u.id AS user_id,
    u.name,
    u.roll,
    b.name AS batch_name,          -- batch name from batch table
    mpd.month_id,
    mo.name AS month_name,
    COALESCE(mpd.monthly_amount, 0) AS due_amount,
    COALESCE(SUM(CASE WHEN mfd.fee_type = 'hall_fee' THEN mfd.monthly_amount END), 0) AS hall_fee,
    COALESCE(SUM(CASE WHEN mfd.fee_type = 'electricity_fee' THEN mfd.monthly_amount END), 0) AS electricity_fee,
    COALESCE(cfd.contingency_amount, 0) AS contingency_fee
FROM users u
JOIN payments p
  ON p.user_id = u.id
JOIN monthly_payment_details mpd
  ON mpd.payment_id = p.id
 AND mpd.user_id = u.id
LEFT JOIN monthly_fee_details mfd
  ON mfd.payment_id = p.id
 AND mfd.month_id   = mpd.month_id
 AND mfd.user_id    = u.id
LEFT JOIN contingency_fee_details cfd
  ON cfd.payment_id = p.id
 AND cfd.month_id   = mpd.month_id
 AND cfd.user_id    = u.id
LEFT JOIN month mo
  ON mo.id = mpd.month_id
LEFT JOIN batch b
  ON b.id = u.batch                  -- assumes users.batch references batch.id
WHERE 1=1 {$where_batch}
GROUP BY 
  u.id, u.name, u.roll, b.name,
  mpd.month_id, mo.name, mpd.monthly_amount, cfd.contingency_amount
ORDER BY u.id, mpd.month_id
";
$paid_res = mysqli_query($con, $paid_sql);

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
$paid_grouped = group_by_user($paid_res, true);

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
// ================= PAID SECTION =================
$p_due_total   = 0.0;
$p_hall_total  = 0.0;
$p_elec_total  = 0.0;
$p_cont_total  = 0.0;
$p_grand_total = 0.0;
?>
<div class="secTitle">Paid Dues (from payment details)</div>
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
    $grand_paid = 0;
    if (!empty($paid_grouped)) {
        foreach ($paid_grouped as $uid => $info) {
            $rspan = max(1, count($info['rows']));
            $first = true;
            $user_total = sum_user_total($info['rows']);
            $grand_paid += $user_total;

            foreach ($info['rows'] as $row) {
                // accumulate per-row into PAID section totals
                $p_due_total  += (float)$row['due'];
                $p_hall_total += (float)$row['hall'];
                $p_elec_total += (float)$row['elec'];
                $p_cont_total += (float)$row['cont'];
                $p_grand_total += (float)$row['total'];

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
            echo '<tr><td class="b1 p tr" colspan="9"><em>'.$info['name'].' subtotal</em></td><td class="b1 p money"><strong>'.number_format($user_total,2).'</strong></td></tr>';
            $sl++;
        }
    } else {
        echo '<tr><td class="b1 p tc" colspan="10">No paid dues found</td></tr>';
    }
    ?>
    <!-- Category totals for PAID -->
    <tr>
        <td class="b1 p tr" colspan="5"><strong>Category Totals (Paid)</strong></td>
        <td class="b1 p money"><strong><?php echo number_format($p_due_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($p_hall_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($p_elec_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($p_cont_total,2); ?></strong></td>
        <td class="b1 p money"><strong><?php echo number_format($p_grand_total,2); ?></strong></td>
    </tr>
    <!-- Grand total row for PAID -->
    <tr>
        <td class="b1 p tr" colspan="9"><strong>Paid Grand Total</strong></td>
        <td class="b1 p money"><strong><?php echo number_format($grand_paid,2); ?></strong></td>
    </tr>
</table>

<div class="muted" style="margin-top:10px;text-align:right;"><i><b>Developed By The Web Divers</b></i></div>

</body>
</html>

<?php
// student_payments.php (self-contained demo-ready)
// Prints per-payment Due, Hall, Electricity, Contingency, Other Fees, and Total with method, txn, months.

// Debug on (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include("./inc/constant.inc.php");
include("./inc/connection.inc.php");
include("./inc/function.inc.php");

// Safe helper fallback
if (!function_exists('get_safe_value')) {
    function get_safe_value($str) {
        return htmlspecialchars(trim($str ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

// Accept id or default to a demo id (7)
$user_id = null;
if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
    $user_id = (int) get_safe_value($_GET['id']);
} else {
    $user_id = 7; // demo student id with full breakdown rows
}

// Fetch student info
$u_sql = "SELECT name, roll, batch, image FROM users WHERE id = {$user_id} LIMIT 1";
$u_res = mysqli_query($con, $u_sql);
$u = $u_res && mysqli_num_rows($u_res) ? mysqli_fetch_assoc($u_res) : ['name'=>'Unknown','roll'=>'-','batch'=>'-','image'=>''];

// Payments list (COALESCE supports underscore and legacy schemas)
$pay_sql = "
    SELECT 
        id,
        COALESCE(payment_type, paymenttype)    AS payment_type,
        COALESCE(tran_id, tranid)              AS tran_id,
        COALESCE(total_amount, totalamount)    AS total_amount,
        COALESCE(created_at, createdat)        AS created_at,
        COALESCE(paid_status, paidstatus)      AS paid_status
    FROM payments
    WHERE COALESCE(user_id, userid) = {$user_id}
    ORDER BY COALESCE(created_at, createdat) DESC, id DESC
";
$pay_res = mysqli_query($con, $pay_sql);

// Helper: months covered by a payment
function get_months_for_payment(mysqli $con, $payment_id) {
    // underscore first
    $q1 = "
        SELECT mo.name AS month_name
        FROM monthly_payment_details mpd
        LEFT JOIN month mo ON mo.id = mpd.month_id
        WHERE mpd.payment_id = {$payment_id}
        ORDER BY mpd.month_id
    ";
    $r1 = mysqli_query($con, $q1);
    $names = [];
    if ($r1 && mysqli_num_rows($r1) > 0) {
        while ($row = mysqli_fetch_assoc($r1)) $names[] = $row['month_name'];
        return implode(', ', $names);
    }
    // legacy fallback
    $q2 = "
        SELECT mo.name AS month_name
        FROM monthlypaymentdetails mpd
        LEFT JOIN month mo ON mo.id = mpd.monthid
        WHERE mpd.paymentid = {$payment_id}
        ORDER BY mpd.monthid
    ";
    $r2 = mysqli_query($con, $q2);
    if ($r2 && mysqli_num_rows($r2) > 0) {
        while ($row = mysqli_fetch_assoc($r2)) $names[] = $row['month_name'];
    }
    return implode(', ', $names);
}

// Helper: method label with gateway details (if any)
function method_label(mysqli $con, $payment_type, $tran_id) {
    $method = strtoupper((string)$payment_type);
    if (in_array(strtolower((string)$payment_type), ['sslcommerz','online','bkash','nagad'])) {
        $tran_id_esc = mysqli_real_escape_string($con, (string)$tran_id);
        $op = mysqli_query($con, "
            SELECT cardtype, trandate, cardissuer, valid
            FROM onlinepayment
            WHERE tranid = '{$tran_id_esc}'
            ORDER BY id DESC LIMIT 1
        ");
        if ($op && mysqli_num_rows($op) > 0) {
            $o = mysqli_fetch_assoc($op);
            $parts = [];
            if (!empty($o['cardtype']))  $parts[] = $o['cardtype'];
            if (!empty($o['cardissuer'])) $parts[] = $o['cardissuer'];
            if (!empty($o['valid']))      $parts[] = $o['valid'];
            if (!empty($o['trandate']))   $parts[] = $o['trandate'];
            $detail = implode(' | ', $parts);
            if ($detail) $method .= " ({$detail})";
        }
    }
    return $method;
}

// Helper: per-payment breakdown with schema fallback
function compute_breakdown(mysqli $con, int $payment_id, int $user_id): array {
    $due = $hall = $elec = $cont = $other = 0.0;

    // Due
    $q = "SELECT COALESCE(SUM(mpd.monthly_amount),0) AS s
          FROM monthly_payment_details mpd
          WHERE mpd.payment_id={$payment_id} AND mpd.user_id={$user_id}";
    $r = mysqli_query($con, $q);
    if ($r && ($row = mysqli_fetch_assoc($r))) {
        $due = (float)$row['s'];
    } else {
        $q = "SELECT COALESCE(SUM(mpd.monthlyamount),0) AS s
              FROM monthlypaymentdetails mpd
              WHERE mpd.paymentid={$payment_id} AND mpd.userid={$user_id}";
        $r = mysqli_query($con, $q);
        if ($r && ($row = mysqli_fetch_assoc($r))) $due = (float)$row['s'];
    }

    // Hall
    $q = "SELECT COALESCE(SUM(mfd.monthly_amount),0) AS s
          FROM monthly_fee_details mfd
          WHERE mfd.payment_id={$payment_id} AND mfd.user_id={$user_id} AND mfd.fee_type='hall_fee'";
    $r = mysqli_query($con, $q);
    if ($r && ($row = mysqli_fetch_assoc($r))) {
        $hall = (float)$row['s'];
    } else {
        $q = "SELECT COALESCE(SUM(mfd.monthlyamount),0) AS s
              FROM monthlyfeedetails mfd
              WHERE mfd.paymentid={$payment_id} AND mfd.userid={$user_id} AND mfd.feetype='hallfee'";
        $r = mysqli_query($con, $q);
        if ($r && ($row = mysqli_fetch_assoc($r))) $hall = (float)$row['s'];
    }

    // Electricity
    $q = "SELECT COALESCE(SUM(mfd.monthly_amount),0) AS s
          FROM monthly_fee_details mfd
          WHERE mfd.payment_id={$payment_id} AND mfd.user_id={$user_id} AND mfd.fee_type='electricity_fee'";
    $r = mysqli_query($con, $q);
    if ($r && ($row = mysqli_fetch_assoc($r))) {
        $elec = (float)$row['s'];
    } else {
        $q = "SELECT COALESCE(SUM(mfd.monthlyamount),0) AS s
              FROM monthlyfeedetails mfd
              WHERE mfd.paymentid={$payment_id} AND mfd.userid={$user_id} AND mfd.feetype='electricityfee'";
        $r = mysqli_query($con, $q);
        if ($r && ($row = mysqli_fetch_assoc($r))) $elec = (float)$row['s'];
    }

    // Contingency
    $q = "SELECT COALESCE(SUM(cfd.contingency_amount),0) AS s
          FROM contingency_fee_details cfd
          WHERE cfd.payment_id={$payment_id} AND cfd.user_id={$user_id}";
    $r = mysqli_query($con, $q);
    if ($r && ($row = mysqli_fetch_assoc($r))) {
        $cont = (float)$row['s'];
    } else {
        $q = "SELECT COALESCE(SUM(cfd.contingencyamount),0) AS s
              FROM contingencyfeedetails cfd
              WHERE cfd.paymentid={$payment_id} AND cfd.userid={$user_id}";
        $r = mysqli_query($con, $q);
        if ($r && ($row = mysqli_fetch_assoc($r))) $cont = (float)$row['s'];
    }

    // Other
    $q = "SELECT COALESCE(SUM(fd.fee_amount),0) AS s
          FROM fee_details fd
          WHERE fd.payment_id={$payment_id}";
    $r = mysqli_query($con, $q);
    if ($r && ($row = mysqli_fetch_assoc($r))) {
        $other = (float)$row['s'];
    } else {
        $q = "SELECT COALESCE(SUM(fd.feeamount),0) AS s
              FROM feedetails fd
              WHERE fd.paymentid={$payment_id}";
        $r = mysqli_query($con, $q);
        if ($r && ($row = mysqli_fetch_assoc($r))) $other = (float)$row['s'];
    }

    return ['due'=>$due, 'hall'=>$hall, 'elec'=>$elec, 'cont'=>$cont, 'other'=>$other];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Student Payment Details - <?php echo HALL_NAME; ?></title>
<style>
    :root { --fg:#000; --hl:#b7b4b4; }
    body { font-family: Arial, Helvetica, sans-serif; color: var(--fg); }
    .toolbar { margin: 12px 0; display:flex; gap:8px; align-items:center; }
    .btn { padding:8px 14px; background:#1976d2; color:#fff; border:0; border-radius:4px; cursor:pointer; }
    .btn:active { transform: translateY(1px); }
    .w100 { width:100%; border-collapse: collapse; }
    .b1 { border:1px solid #000; }
    .p { padding:8px 10px; }
    .tc { text-align:center; }
    .tr { text-align:right; }
    .th { background: var(--hl); text-align:center; }
    .muted { color:#555; font-size:12px; }
    .money { text-align:right; white-space: nowrap; }
    .header { display:flex; align-items:center; gap:16px; margin-bottom:12px; }
    .header img { height:70px; border-radius:4px; object-fit:cover; }
    @media print { .toolbar { display:none; } body { margin: 0.5in; } }
</style>
</head>
<body>

<div class="toolbar">
    <form method="get" action="">
        <label>Student ID:</label>
        <input type="number" name="id" value="<?php echo (int)$user_id; ?>" min="1" style="width:100px">
        <button class="btn" type="submit">Load</button>
    </form>
    <button class="btn" onclick="window.print()">Print</button>
</div>

<div class="header">
    <img src="<?php echo STUDENT_IMAGE . ($u['image'] ?? ''); ?>" alt="student">
    <div>
        <div style="font-size:20px;font-weight:700;"><?php echo HALL_NAME; ?></div>
        <div class="muted"><?php echo WEBSITE; ?> | Tel: <?php echo TEL; ?> | Email: <?php echo EMAIL; ?></div>
    </div>
</div>

<table class="w100" style="margin-bottom:10px;">
    <tr>
        <td class="b1 p"><strong>Name:</strong> <?php echo htmlspecialchars($u['name'] ?? ''); ?></td>
        <td class="b1 p"><strong>Roll:</strong> <?php echo htmlspecialchars($u['roll'] ?? ''); ?></td>
        <td class="b1 p"><strong>Batch:</strong> <?php echo htmlspecialchars($u['batch'] ?? ''); ?></td>
    </tr>
</table>

<table class="w100">
    <tr>
        <td class="th b1 p">SL</td>
        <td class="th b1 p">Invoice #</td>
        <td class="th b1 p">Date/Time</td>
        <td class="th b1 p">Method</td>
        <td class="th b1 p">Transaction ID</td>
        <td class="th b1 p">Months Covered</td>
        <td class="th b1 p">Due</td>
        <td class="th b1 p">Hall</td>
        <td class="th b1 p">Electricity</td>
        <td class="th b1 p">Contingency</td>
        <td class="th b1 p">Other Fees</td>
        <td class="th b1 p">Amount (Taka)</td>
        <td class="th b1 p">Status</td>
    </tr>
    <?php
    $sl = 1;
    $sum_amount = 0.0;
    $sum_due = $sum_hall = $sum_elec = $sum_cont = $sum_other = 0.0;

    if ($pay_res && mysqli_num_rows($pay_res) > 0) {
        while ($p = mysqli_fetch_assoc($pay_res)) {
            $inv     = (int)$p['id'];
            $amount  = (float)$p['total_amount'];
            $sum_amount += $amount;

            $created = (string)$p['created_at'];
            $created_label = (is_numeric($created) ? date("d M Y h:i A", (int)$created) : htmlspecialchars($created));

            $method  = method_label($con, $p['payment_type'], $p['tran_id']);
            $months  = get_months_for_payment($con, $inv);
            $status  = ((int)$p['paid_status'] === 1) ? 'PAID' : 'UNPAID';

            $bd = compute_breakdown($con, $inv, $user_id);
            $sum_due   += $bd['due'];
            $sum_hall  += $bd['hall'];
            $sum_elec  += $bd['elec'];
            $sum_cont  += $bd['cont'];
            $sum_other += $bd['other'];

            echo "<tr>";
            echo '<td class="b1 p tc">'.($sl++).'</td>';
            echo '<td class="b1 p tc">#'.$inv.'</td>';
            echo '<td class="b1 p tc">'.$created_label.'</td>';
            echo '<td class="b1 p">'.htmlspecialchars($method).'</td>';
            echo '<td class="b1 p">'.htmlspecialchars($p['tran_id']).'</td>';
            echo '<td class="b1 p">'.($months ? htmlspecialchars($months) : '-').'</td>';
            echo '<td class="b1 p money">'.number_format($bd['due'],2).'</td>';
            echo '<td class="b1 p money">'.number_format($bd['hall'],2).'</td>';
            echo '<td class="b1 p money">'.number_format($bd['elec'],2).'</td>';
            echo '<td class="b1 p money">'.number_format($bd['cont'],2).'</td>';
            echo '<td class="b1 p money">'.number_format($bd['other'],2).'</td>';
            echo '<td class="b1 p money">'.number_format($amount,2).'</td>';
            echo '<td class="b1 p tc">'.$status.'</td>';
            echo "</tr>";
        }
        echo '<tr>
                <td class="b1 p tr" colspan="6"><strong>Category Totals</strong></td>
                <td class="b1 p money"><strong>'.number_format($sum_due,2).'</strong></td>
                <td class="b1 p money"><strong>'.number_format($sum_hall,2).'</strong></td>
                <td class="b1 p money"><strong>'.number_format($sum_elec,2).'</strong></td>
                <td class="b1 p money"><strong>'.number_format($sum_cont,2).'</strong></td>
                <td class="b1 p money"><strong>'.number_format($sum_other,2).'</strong></td>
                <td class="b1 p money"><strong>'.number_format($sum_amount,2).'</strong></td>
                <td class="b1 p"></td>
              </tr>';
    } else {
        echo '<tr><td class="b1 p tc" colspan="13">No payments found for Student ID '.(int)$user_id.'</td></tr>';
    }
    ?>
</table>

<div class="muted" style="margin-top:10px;text-align:right;"><i><b>Developed By The Web Divers</b></i></div>

</body>
</html>

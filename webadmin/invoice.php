<?php
// invoice_print.php
// Printable invoice (HTML + print CSS) pulling monthly_payment_details, monthly_fee_details and contingency_fee_details

session_start();
include("./inc/constant.inc.php");
include("./inc/connection.inc.php");
include("./inc/function.inc.php");
require_once("./inc/phpqrcode/qrlib.php");

// Guard
if (!isset($_GET['id']) || $_GET['id'] === '') {
    $_SESSION['PERMISSION_ERROR'] = 1;
    redirect("index.php");
    exit;
}
$inv_hash = get_safe_value($_GET['id']);

// Fetch payment + user
$pay_sql = "
    SELECT 
        p.id AS payment_id,
        p.user_id,
        p.total_amount,
        p.created_at,
        u.name,
        u.roll,
        u.batch
    FROM payments p
    JOIN users u ON u.id = p.user_id
    WHERE MD5(p.id) = '$inv_hash'
    LIMIT 1
";
$pay_res = mysqli_query($con, $pay_sql);
if (!$pay_res || mysqli_num_rows($pay_res) === 0) {
    echo "No invoice data found";
    exit;
}
$pay = mysqli_fetch_assoc($pay_res);
$payment_id   = (int)$pay['payment_id'];
$user_id      = (int)$pay['user_id'];
$total_amount = (float)$pay['total_amount'];
$created_at   = (int)$pay['created_at'];

// QR code for verification
// $qr_path = __DIR__ . '/qrcode.png';
$qr_link = QR_CODE_ADDRESS . "invoice_print.php?id=" . $inv_hash;
// QRcode::png($qr_link, $qr_path);

// Amount in words (fallback if not present in includes)
if (!function_exists('numberTowords')) {
    function numberTowords($number) {
        // very small fallback; adjust as needed
        $fmt = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return ucwords($fmt->format($number));
    }
}

// Pull per-month lines: due, hall_fee, electricity_fee, contingency_fee
$lines_sql = "
    SELECT 
        m.name AS month_name,
        mpd.month_id,
        COALESCE(mpd.monthly_amount,0) AS due,
        COALESCE(SUM(CASE WHEN mfd.fee_type = 'hall_fee' THEN mfd.monthly_amount END),0) AS hall_fee,
        COALESCE(SUM(CASE WHEN mfd.fee_type = 'electricity_fee' THEN mfd.monthly_amount END),0) AS electricity_fee,
        COALESCE(cfd.contingency_amount,0) AS contingency_fee
    FROM monthly_payment_details mpd
    LEFT JOIN month m 
        ON m.id = mpd.month_id
    LEFT JOIN monthly_fee_details mfd 
        ON mfd.payment_id = mpd.payment_id 
       AND mfd.month_id   = mpd.month_id
    LEFT JOIN contingency_fee_details cfd
        ON cfd.payment_id = mpd.payment_id
       AND cfd.month_id   = mpd.month_id
    WHERE mpd.payment_id = {$payment_id}
    GROUP BY mpd.month_id, m.name, mpd.monthly_amount, cfd.contingency_amount
    ORDER BY mpd.month_id
";
$lines_res = mysqli_query($con, $lines_sql);

// Build HTML
function header_block($copyLabel, $qr_path, $pay, $created_at) {
    $hallTitle = HALL_NAME;
    $logo = LOGO;
    $tel = TEL;
    $email = EMAIL;
    $web = WEBSITE;
    $printed = date("d M Y h:i A", time());
    $created = date("d M Y h:i A", $created_at);
    $name = htmlspecialchars($pay['name']);
    $roll = htmlspecialchars($pay['roll']);
    $batch = htmlspecialchars($pay['batch']);
    $invno = (int)$pay['payment_id'];

    return '
    <table class="w100">
        <tr>
            <td class="tc" colspan="3">
                <img src="'.$logo.'" height="80" alt="logo"><br>
                <div class="title">'.$hallTitle.'</div>
                <div>Durgapur, Barisal</div>
                <div>Tel: '.$tel.' | Email: '.$email.'</div>
                <div>'.$web.'</div>
            </td>
        </tr>
        <tr><td colspan="3"><hr></td></tr>
        <tr>
            <td class="b1 p">Name: '.$name.'</td>
            <td class="tc" rowspan="3">
                <div class="copyTag">'.$copyLabel.'</div>
                <img src="qrcode.png" height="100" alt="qr"><br>
                <small>Scan QR to verify payment</small>
            </td>
            <td class="tr b1 p">Invoice No: #'.$invno.'</td>
        </tr>
        <tr>
            <td class="b1 p">Roll: '.$roll.'</td>
            <td class="tr b1 p">Created: '.$created.'</td>
        </tr>
        <tr>
            <td class="b1 p">Batch: '.$batch.'</td>
            <td class="tr b1 p">Printed On: '.$printed.'</td>
        </tr>
    </table>';
}

ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice - <?php echo HALL_NAME; ?></title>
<style>
    :root { --fg:#000; --muted:#666; --hl:#b7b4b4; }
    body { font-family: Arial, Helvetica, sans-serif; color: var(--fg); }
    .toolbar { margin: 12px 0; }
    .btn { padding:8px 14px; background:#1976d2; color:#fff; border:0; border-radius:4px; cursor:pointer; }
    .btn:active { transform: translateY(1px); }
    .title { font-size: 22px; font-weight: 700; }
    .copyTag { font-size: 14px; background: var(--hl); display:inline-block; padding:3px 8px; border-radius:3px; }
    .w100 { width:100%; border-collapse: collapse; }
    .b1 { border:1px solid #000; }
    .p { padding: 6px 10px; }
    .tc { text-align:center; }
    .tr { text-align:right; }
    .th { background: var(--hl); text-align:center; }
    .mt16 { margin-top:16px; }
    .mb8 { margin-bottom:8px; }
    .divider { margin: 18px 0; text-align:center; color: var(--muted); }
    .money { text-align:right; white-space: nowrap; }
    @media print {
        .toolbar { display:none; }
        body { margin: 0.5in; }
        .pagebreak { page-break-before: always; }
    }
</style>
</head>
<body>

<div class="toolbar">
    <button class="btn" onclick="window.print()">Print</button>
</div>

<?php
// Student copy
$qr_path="";
echo header_block("Student's Copy", $qr_path, $pay, $created_at);
?>

<table class="w100 mt16">
    <tr><td class="tc" colspan="7"><strong>Monthly Fees</strong></td></tr>
    <tr>
        <td class="th b1 p">SL</td>
        <td class="th b1 p">Month</td>
        <td class="th b1 p">Due (Taka)</td>
        <td class="th b1 p">Hall Fee (Taka)</td>
        <td class="th b1 p">Electricity (Taka)</td>
        <td class="th b1 p">Contingency (Taka)</td>
        <td class="th b1 p">Total (Taka)</td>
    </tr>
    <?php
    $sl = 1;
    $line_sum = 0.0;
    if ($lines_res && mysqli_num_rows($lines_res) > 0) {
        while ($ln = mysqli_fetch_assoc($lines_res)) {
            $due  = (float)$ln['due'];
            $hf   = (float)$ln['hall_fee'];
            $ef   = (float)$ln['electricity_fee'];
            $cf   = (float)$ln['contingency_fee'];
            $row_total = $due + $hf + $ef + $cf;
            $line_sum += $row_total;
            echo '<tr>
                <td class="b1 p tc">'.($sl++).'</td>
                <td class="b1 p tc">'.htmlspecialchars($ln['month_name']).' - '.date("y").'</td>
                <td class="b1 p money">'.number_format($due,2).'</td>
                <td class="b1 p money">'.number_format($hf,2).'</td>
                <td class="b1 p money">'.number_format($ef,2).'</td>
                <td class="b1 p money">'.number_format($cf,2).'</td>
                <td class="b1 p money"><strong>'.number_format($row_total,2).'</strong></td>
            </tr>';
        }
    } else {
        echo '<tr><td class="b1 p tc" colspan="7">No data found</td></tr>';
    }
    ?>
    <tr>
        <td class="b1 p tr" colspan="6"><strong>Invoice Total</strong></td>
        <td class="b1 p money"><strong><?php echo number_format($total_amount,2); ?></strong></td>
    </tr>
</table>

<div class="mb8">Amount in words (Taka): (<?php echo numberTowords(round($total_amount)); ?>)</div>
<div class="tr"><i><b>Developed By The Web Divers</b></i></div>

<div class="divider">------------------------------------ cut / file ------------------------------------</div>

<?php
// Office copy (rebuild lines cursor)
$lines_res2 = mysqli_query($con, $lines_sql);
echo header_block("Office Copy", $qr_path, $pay, $created_at);
?>

<table class="w100 mt16">
    <tr><td class="tc" colspan="7"><strong>Monthly Fees</strong></td></tr>
    <tr>
        <td class="th b1 p">SL</td>
        <td class="th b1 p">Month</td>
        <td class="th b1 p">Due (Taka)</td>
        <td class="th b1 p">Hall Fee (Taka)</td>
        <td class="th b1 p">Electricity (Taka)</td>
        <td class="th b1 p">Contingency (Taka)</td>
        <td class="th b1 p">Total (Taka)</td>
    </tr>
    <?php
    $sl = 1;
    if ($lines_res2 && mysqli_num_rows($lines_res2) > 0) {
        while ($ln = mysqli_fetch_assoc($lines_res2)) {
            $due  = (float)$ln['due'];
            $hf   = (float)$ln['hall_fee'];
            $ef   = (float)$ln['electricity_fee'];
            $cf   = (float)$ln['contingency_fee'];
            $row_total = $due + $hf + $ef + $cf;
            echo '<tr>
                <td class="b1 p tc">'.($sl++).'</td>
                <td class="b1 p tc">'.htmlspecialchars($ln['month_name']).' - '.date("y").'</td>
                <td class="b1 p money">'.number_format($due,2).'</td>
                <td class="b1 p money">'.number_format($hf,2).'</td>
                <td class="b1 p money">'.number_format($ef,2).'</td>
                <td class="b1 p money">'.number_format($cf,2).'</td>
                <td class="b1 p money"><strong>'.number_format($row_total,2).'</strong></td>
            </tr>';
        }
    } else {
        echo '<tr><td class="b1 p tc" colspan="7">No data found</td></tr>';
    }
    ?>
    <tr>
        <td class="b1 p tr" colspan="6"><strong>Invoice Total</strong></td>
        <td class="b1 p money"><strong><?php echo number_format($total_amount,2); ?></strong></td>
    </tr>
</table>

</body>
</html>
<?php
echo ob_get_clean();

// tidy up QR
if (file_exists($qr_path)) {
    // keep or unlink depending on your deployment policy
    // unlink($qr_path);
}

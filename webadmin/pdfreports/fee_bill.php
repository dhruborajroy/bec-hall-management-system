<?php
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');

// Inputs: optional ?year=YYYY&month=MM (e.g., 2025 & 11), defaults to current month
$year  = isset($_GET['year'])  ? (int)$_GET['year']  : (int)date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('n');

// Clamp to valid ranges
if ($year < 2022) { $year = (int)date('Y'); }
if ($month < 1 || $month > 12) { $month = (int)date('n'); }

// Compute month boundaries (Unix timestamps)
$startTs = (new DateTime(sprintf('%04d-%02d-01 00:00:00', $year, $month)))->getTimestamp();
$endTs   = (new DateTime(sprintf('%04d-%02d-01 23:59:59', $year, $month)))
             ->modify('last day of this month')
             ->getTimestamp();
$periodLabel = (new DateTime(sprintf('%04d-%02d-01', $year, $month)))->format('F Y');

// Fetch per-student collections for the month from monthly_fee_details joined to paid payments
$sql = "
  SELECT
    u.id,
    u.roll,
    u.name,
    SUM(CASE WHEN mfd.fee_type = 'hall_fee' THEN mfd.monthly_amount ELSE 0 END)       AS hall_fee,
    SUM(CASE WHEN mfd.fee_type = 'electricity_fee' THEN mfd.monthly_amount ELSE 0 END) AS electricity_fee,
    SUM(mfd.monthly_amount)                                                             AS total_fee
  FROM monthly_fee_details mfd
  INNER JOIN payments p ON p.id = mfd.payment_id AND p.paid_status = 1
  INNER JOIN users u     ON u.id = mfd.user_id
  WHERE mfd.added_on BETWEEN {$startTs} AND {$endTs}
  GROUP BY u.id, u.roll, u.name
  ORDER BY u.roll ASC
";
$res = mysqli_query($con, $sql);

// Compute grand totals
$grandHall = 0.0; $grandElec = 0.0; $grandTotal = 0.0;

// Header HTML
$html  = '<table width="100%">';
$html .= '
  <tr>
    <td align="center"></td>
    <td align="center" colspan="2">
      <strong><span style="font-size:25px">'.HALL_NAME.'</span></strong><br>'
      .ADDRESS.'<br>Tel: '.TEL.' | Email: '.EMAIL.'<br>'.WEBSITE.
    '</td>
  </tr>';
$html .= '<tr><td colspan="3"><hr></td></tr>';
$html .= '<tr><td colspan="3" align="center">Monthly Fee Collection ('.$periodLabel.')</td></tr>';
$html .= '<tr><td colspan="3"><hr></td></tr>';
$html .= '</table>';

// Table header
$html .= '<table width="100%" style="margin-top:10px;border-collapse:collapse">';
$html .= '<tr>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:10%">Roll</td>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:30%">Name</td>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:20%">Hall fee</td>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:20%">Electricity fee</td>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:20%">Total</td>';
$html .= '</tr>';

// Rows
if ($res && mysqli_num_rows($res) > 0) {
  while ($r = mysqli_fetch_assoc($res)) {
    $roll  = htmlspecialchars($r['roll'] ?? '', ENT_QUOTES, 'UTF-8');
    $name  = htmlspecialchars($r['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $hall  = (float)($r['hall_fee'] ?? 0);
    $elec  = (float)($r['electricity_fee'] ?? 0);
    $total = (float)($r['total_fee'] ?? 0);

    $grandHall  += $hall;
    $grandElec  += $elec;
    $grandTotal += $total;

    $html .= '<tr>';
    $html .= '<td style="border:1px solid black;text-align:center;">'.$roll.'</td>';
    $html .= '<td style="border:1px solid black;text-align:left;padding-left:8px">'.$name.'</td>';
    $html .= '<td style="border:1px solid black;text-align:right;padding-right:8px">'.number_format($hall,2).'</td>';
    $html .= '<td style="border:1px solid black;text-align:right;padding-right:8px">'.number_format($elec,2).'</td>';
    $html .= '<td style="border:1px solid black;text-align:right;padding-right:8px"><strong>'.number_format($total,2).'</strong></td>';
    $html .= '</tr>';
  }

  // Totals row
  $html .= '<tr>';
  $html .= '<td style="border:1px solid black;background-color:#b7b4b4;"></td>';
  $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:right;padding-right:8px"><strong>Grand totals</strong></td>';
  $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:right;padding-right:8px">'.number_format($grandHall,2).'</td>';
  $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:right;padding-right:8px">'.number_format($grandElec,2).'</td>';
  $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:right;padding-right:8px"><strong>'.number_format($grandTotal,2).'</strong></td>';
  $html .= '</tr>';

  $html .= '</table>';
} else {
  $html .= '<tr><td colspan="5" style="border:1px solid black;text-align:center;">No collections found for '.$periodLabel.'</td></tr></table>';
}

// Render PDF (landscape)
$mpdf = new \Mpdf\Mpdf([
  'format' => 'A4-L',
  'tempDir' => __DIR__ . '/custom/temp/dir/path',
  'default_font_size' => 12,
  'default_font' => 'FreeSerif',
  'margin_left' => 6,
  'margin_right' => 6,
  'margin_top' => 8,
  'margin_bottom' => 8,
]);

$mpdf->SetTitle('Monthly Fee Collection - '.$periodLabel);
$mpdf->SetFooter('Developed By The Web divers');
$mpdf->WriteHTML($html);
$file = time().'.pdf';
$mpdf->Output($file, 'I');

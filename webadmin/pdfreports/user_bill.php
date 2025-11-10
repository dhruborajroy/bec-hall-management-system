<?php
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');

/**
 * Parse incoming date string into a DateTime at the first day of its month.
 * Accepts 'Y-m-d', 'Y-m', or 'Y'.
 */
function parseToMonthStart(?string $s): ?DateTime {
    if (!$s) return null;

    $formats = ['Y-m-d', 'Y-m', 'Y'];
    foreach ($formats as $fmt) {
        $dt = DateTime::createFromFormat($fmt, $s);
        if ($dt instanceof DateTime) {
            return (new DateTime($dt->format('Y-m-01')));
        }
    }
    return null;
}

/**
 * Build an array of months between two DateTime (inclusive), with:
 * - ymInt => YYYYMM integer key
 * - label => 'M-Y' header
 */
function buildMonths(DateTime $start, DateTime $end): array {
    $start = (clone $start)->modify('first day of this month');
    $end   = (clone $end)->modify('first day of this month');

    $months = [];
    $cursor = clone $start;
    while ($cursor <= $end) {
        $months[] = [
            'ymInt' => intval($cursor->format('Ym')),
            'label' => $cursor->format('M-Y'),  // e.g., Jan-2025
        ];
        $cursor->modify('first day of next month');
    }
    return $months;
}

// Inputs: start_date & end_date (GET)
$yearNow = date("Y"); // default year reference
$defaultStart = new DateTime("$yearNow-01-01");
$defaultEnd   = new DateTime("$yearNow-12-01");

$startParam = $_GET['start_date'] ?? null;
$endParam   = $_GET['end_date'] ?? null;

$startDt = parseToMonthStart($startParam) ?? $defaultStart;
$endDt   = parseToMonthStart($endParam)   ?? $defaultEnd;

// Ensure start <= end
if ($startDt > $endDt) {
    $tmp = $startDt;
    $startDt = $endDt;
    $endDt = $tmp;
}

// Build months (inclusive)
$months = buildMonths($startDt, $endDt);

// Precompute integer keys for filtering in SQL
$startYm = intval($startDt->format('Ym'));
$endYm   = intval($endDt->format('Ym'));

// Fetch all users
$sql = "SELECT id, roll, name FROM users";
$res = mysqli_query($con, $sql);

// Header
$html  = '<table width="100%">';
$html .= '
    <tr>
        <td align="center">
            <!--- <img width="150" src="'.LOGO.'" width="100" height="100" /> --->
        </td>
        <td align="center" colspan="2">
            <strong><span style="font-size:25px">'.HALL_NAME.'</span></strong>
            <br>
            '.ADDRESS.'
            <br>
            Tel: '.TEL.' | Email: '.EMAIL.'
            <br>
            '.WEBSITE.'
        </td>
    </tr>';
$html .= '<tr><td colspan="3"><hr></td></tr>';
$html .= '<tr><td colspan="3" align="center">Monthly Bill chart for '
      . htmlspecialchars($startDt->format('M Y')) . ' to ' . htmlspecialchars($endDt->format('M Y'))
      . '</td></tr>';
$html .= '<tr><td colspan="3"><hr></td></tr>';
$html .= '</table>';

// Table header
$html .= '<table width="100%" style="margin-top:10px;border-collapse:collapse">';
$html .= '<tr>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:10%">Roll</td>';
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:20%">Name</td>';
// Distribute 60% across month columns, reserve 10% for Sum
$monthColWidth = max(3, floor(60 / max(1, count($months))));
foreach ($months as $m) {
    $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:'.$monthColWidth.'%">'.$m['label'].'</td>';
}
$html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;width:10%">Sum</td>';
$html .= '</tr>';

// Rows per user
if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $user_id = (int)$row['id'];

        // Dynamic pivot select parts per month in range (UNPAID only, matches displayed cells)
        $selectParts = [];
        foreach ($months as $m) {
            $ym = $m['ymInt'];
            $label = $m['label'];
            $selectParts[] = "SUM(CASE WHEN m.ym_key = $ym THEN m.amount ELSE 0 END) AS `$label`";
        }
        // Also compute the per-row grand unpaid sum for the range
        $selectParts[] = "SUM(m.amount) AS __ROW_UNPAID_SUM";

        // Per-user UNION ALL across both tables filtered to range (unpaid only)
        $userQuery = "
            SELECT
                ".implode(", ", $selectParts)."
            FROM (
                SELECT (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) AS ym_key, amount
                FROM monthly_bill
                WHERE paid_status != 1
                  AND user_id = $user_id
                  AND (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) BETWEEN $startYm AND $endYm
                UNION ALL
                SELECT (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) AS ym_key, amount
                FROM monthly_fee
                WHERE paid_status != 1
                  AND user_id = $user_id
                  AND (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) BETWEEN $startYm AND $endYm
            ) AS m
        ";

        $uRes = mysqli_query($con, $userQuery);
        $vals = $uRes ? mysqli_fetch_assoc($uRes) : null;

        $html .= '<tr>';
        $html .= '<td style="border:1px solid black;text-align:center;">'.htmlspecialchars($row['roll']).'</td>';
        $html .= '<td style="border:1px solid black;text-align:center;">'.htmlspecialchars($row['name']).'</td>';

        foreach ($months as $m) {
            $label = $m['label'];
            $v = isset($vals[$label]) && $vals[$label] !== null ? $vals[$label] : 0;
            $html .= '<td style="border:1px solid black;text-align:center;">'.$v.'</td>';
        }
        $rowSum = isset($vals['__ROW_UNPAID_SUM']) && $vals['__ROW_UNPAID_SUM'] !== null ? $vals['__ROW_UNPAID_SUM'] : 0;
        $html .= '<td style="border:1px solid black;text-align:center;">'.$rowSum.'</td>';
        $html .= '</tr>';
    }

    // Totals row across both tables for the same range (unpaid monthly + unpaid grand sum)
    $selectTotals = [];
    foreach ($months as $m) {
        $ym = $m['ymInt'];
        $label = $m['label'];
        $selectTotals[] = "SUM(CASE WHEN t.ym_key = $ym THEN t.amount ELSE 0 END) AS `$label`";
    }

    $totalsQuery = "
        SELECT
            ".implode(", ", $selectTotals).",
            SUM(t.amount) AS __GRAND_UNPAID_SUM
        FROM (
            SELECT (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) AS ym_key, amount
            FROM monthly_bill
            WHERE paid_status != 1
              AND (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) BETWEEN $startYm AND $endYm
            UNION ALL
            SELECT (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) AS ym_key, amount
            FROM monthly_fee
            WHERE paid_status != 1
              AND (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) BETWEEN $startYm AND $endYm
        ) AS t
    ";

    $tRes = mysqli_query($con, $totalsQuery);
    $totals = $tRes ? mysqli_fetch_assoc($tRes) : [];

    $html .= '<tr>';
    $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;"></td>';
    $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;">Total</td>';
    foreach ($months as $m) {
        $label = $m['label'];
        $tv = isset($totals[$label]) && $totals[$label] !== null ? $totals[$label] : 0;
        $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;">'.$tv.'</td>';
    }
    $grandUnpaid = isset($totals['__GRAND_UNPAID_SUM']) && $totals['__GRAND_UNPAID_SUM'] !== null ? $totals['__GRAND_UNPAID_SUM'] : 0;
    $html .= '<td style="border:1px solid black;background-color:#b7b4b4;text-align:center;">'.$grandUnpaid.'</td>';
    $html .= '</tr>';

    // Grand paid and unpaid summaries (single row with both figures)
    $grandPaidQuery = "
        SELECT SUM(x.amount) AS total_paid FROM (
            SELECT amount
            FROM monthly_bill
            WHERE paid_status = 1
              AND (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) BETWEEN $startYm AND $endYm
            UNION ALL
            SELECT amount
            FROM monthly_fee
            WHERE paid_status = 1
              AND (CAST(year AS UNSIGNED)*100 + CAST(month_id AS UNSIGNED)) BETWEEN $startYm AND $endYm
        ) AS x
    ";
    $gpRes = mysqli_query($con, $grandPaidQuery);
    $gpRow = $gpRes ? mysqli_fetch_assoc($gpRes) : ['total_paid' => 0];
    $grandPaid = $gpRow && $gpRow['total_paid'] !== null ? $gpRow['total_paid'] : 0;

    // Optional: you can reuse $grandUnpaid computed above

    // Render final summary row
    $html .= '<tr>';
    $html .= '<td style="border:1px solid black;background-color:#e0dfdf;text-align:center;"></td>';
    $html .= '<td style="border:1px solid black;background-color:#e0dfdf;text-align:center;">Paid/Unpaid summary</td>';
    $html .= '<td colspan="'.count($months).'" style="border:1px solid black;background-color:#e0dfdf;text-align:center;">Unpaid total: '.$grandUnpaid.' | Paid total: '.$grandPaid.'</td>';
    $html .= '<td style="border:1px solid black;background-color:#e0dfdf;text-align:center;"></td>';
    $html .= '</tr>';

    $html .= '</table>';
} else {
    $html .= '<tr><td colspan="'.(3 + max(1, count($months))).'" align="center">No data found</td></tr></table>';
}

// mPDF render (landscape)
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4-L',            // Landscape
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
    'margin_left' => 2,
    'margin_right' => 2,
    'margin_top' => 2,
    'margin_bottom' => 2,
]);

$mpdf->SetTitle('Monthly Bill chart: '.$startDt->format('M Y').' to '.$endDt->format('M Y'));
$mpdf->SetFooter('Developed By The Web divers');
$mpdf->WriteHTML($html);
$file = time().'.pdf';
$mpdf->Output($file, 'I');

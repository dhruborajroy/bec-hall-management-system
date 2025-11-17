<?php

include("./inc/function.inc.php");
session_start();
require('./inc/constant.inc.php');
require('./inc/connection.inc.php');
require_once("./inc/smtp/class.phpmailer.php");
isAdmin();

// Build default values for the inputs
$startInput = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
$endInput   = isset($_GET['end'])   ? $_GET['end']   : date('Y-m-t');
// Period
$start = isset($_GET['start']) ? strtotime($_GET['start'].' 00:00:00') : null;
$end   = isset($_GET['end'])   ? strtotime($_GET['end'].' 23:59:59') : null;
if (!$start || !$end) {
    $start = strtotime("first day of this month 00:00:00");
    $end   = strtotime("last day of this month 23:59:59");
}
$periodLabel = date('d M Y', $start).' - '.date('d M Y', $end);

// 1) Aggregate each table by user_id within the period
$dueByUser = $hallByUser = $elecByUser = $contByUser = [];

// Due
$q = "SELECT user_id, COALESCE(SUM(monthly_amount),0) AS s
      FROM monthly_payment_details
      WHERE added_on BETWEEN {$start} AND {$end}
      GROUP BY user_id";
$r = mysqli_query($con, $q);
while ($r && $row = mysqli_fetch_assoc($r)) $dueByUser[(int)$row['user_id']] = (float)$row['s'];

// Hall
$q = "SELECT user_id, COALESCE(SUM(monthly_amount),0) AS s
      FROM monthly_fee_details
      WHERE added_on BETWEEN {$start} AND {$end} AND fee_type='hall_fee'
      GROUP BY user_id";
$r = mysqli_query($con, $q);
while ($r && $row = mysqli_fetch_assoc($r)) $hallByUser[(int)$row['user_id']] = (float)$row['s'];

// Electricity
$q = "SELECT user_id, COALESCE(SUM(monthly_amount),0) AS s
      FROM monthly_fee_details
      WHERE added_on BETWEEN {$start} AND {$end} AND fee_type='electricity_fee'
      GROUP BY user_id";
$r = mysqli_query($con, $q);
while ($r && $row = mysqli_fetch_assoc($r)) $elecByUser[(int)$row['user_id']] = (float)$row['s'];

// Contingency
$q = "SELECT user_id, COALESCE(SUM(contingency_amount),0) AS s
      FROM contingency_fee_details
      WHERE added_on BETWEEN {$start} AND {$end}
      GROUP BY user_id";
$r = mysqli_query($con, $q);
while ($r && $row = mysqli_fetch_assoc($r)) $contByUser[(int)$row['user_id']] = (float)$row['s'];

// 2) Union of user_ids having any charge
$userIds = array_unique(array_merge(
    array_keys($dueByUser), array_keys($hallByUser),
    array_keys($elecByUser), array_keys($contByUser)
));
if (empty($userIds)) $userIds = [0]; // avoid IN () error

// 3) Fetch student details for those user_ids
$idList = implode(',', array_map('intval', $userIds));
$users = [];
$uRes = mysqli_query($con, "SELECT id, name, roll, batch FROM users WHERE id IN ($idList)");
while ($uRes && $u = mysqli_fetch_assoc($uRes)) $users[(int)$u['id']] = $u;

// 4) Compute grand totals
$g_due = $g_hall = $g_elec = $g_cont = $g_total = 0.0;

?>
<style>
.print-wrap { width:100%; }
.print-head { text-align:center; margin-bottom:10px; }
.table-print { width:100%; border-collapse:collapse; }
.table-print th, .table-print td { border:1px solid #000; padding:6px 8px; }
.table-print th { background:#b7b4b4; text-align:center; }
.t-right { text-align:right; }
.t-center { text-align:center; }
.nowrap { white-space:nowrap; }
@media print { .no-print { display:none; } body { margin:0.5in; font-family: Arial, Helvetica, sans-serif; } }

.filter-bar { display:flex; gap:10px; align-items:center; margin:10px 0; }
.filter-bar input[type="date"] { padding:6px 8px; }
.filter-bar button { padding:6px 10px; cursor:pointer; }
@media print { .no-print { display:none !important; } }
</style>
<div class="filter-bar no-print">
  <form method="get" action="" style="display:flex; gap:10px; align-items:center;">
    <label>Start:</label>
    <input type="date" name="start" value="<?php echo htmlspecialchars($startInput); ?>">
    <label>End:</label>
    <input type="date" name="end" value="<?php echo htmlspecialchars($endInput); ?>">
    <button type="submit">Apply</button>
    <button type="button" onclick="window.location.href=window.location.pathname">Reset</button>
    <button type="button" onclick="window.print()">Print</button>


    <!-- New: Today button -->
    <button type="button" id="btnToday">Today</button>
  </form>
</div>
<div class="print-wrap">
  <div class="print-head">
    <div style="font-size:20px;font-weight:700;"><?php echo HALL_NAME; ?></div>
    <div>Student-wise charges (<?php echo htmlspecialchars($periodLabel); ?>)</div>
  </div>

  <table class="table-print">
    <tr>
      <th>SL</th>
      <th>Name</th>
      <th>Roll</th>
      <th>Batch</th>
      <th class="t-right">Due</th>
      <th class="t-right">Hall</th>
      <th class="t-right">Electricity</th>
      <th class="t-right">Contingency</th>
      <th class="t-right">Student Total</th>
    </tr>
    <?php
    if (!empty($userIds) && !(count($userIds) === 1 && $userIds[0] === 0)) {
        $sl = 1;
        // Sort users by name for stable output
        uasort($users, function($a,$b){ return strcasecmp($a['name'] ?? '', $b['name'] ?? ''); });
        foreach ($users as $uid => $info) {
            $d = $dueByUser[$uid]  ?? 0.0;
            $h = $hallByUser[$uid] ?? 0.0;
            $e = $elecByUser[$uid] ?? 0.0;
            $c = $contByUser[$uid] ?? 0.0;
            $st = $d + $h + $e + $c;

            $g_due   += $d;
            $g_hall  += $h;
            $g_elec  += $e;
            $g_cont  += $c;
            $g_total += $st;

            echo '<tr>';
            echo '<td class="t-center">'.($sl++).'</td>';
            echo '<td>'.htmlspecialchars($info['name'] ?? '').'</td>';
            echo '<td class="nowrap">'.htmlspecialchars($info['roll'] ?? '').'</td>';
            echo '<td class="nowrap">'.htmlspecialchars($info['batch'] ?? '').'</td>';
            echo '<td class="t-right">'.number_format($d,2).'</td>';
            echo '<td class="t-right">'.number_format($h,2).'</td>';
            echo '<td class="t-right">'.number_format($e,2).'</td>';
            echo '<td class="t-right">'.number_format($c,2).'</td>';
            echo '<td class="t-right"><strong>'.number_format($st,2).'</strong></td>';
            echo '</tr>';
        }
        // Grand totals row
        echo '<tr>';
        echo '<th colspan="4" class="t-right">Grand Totals</th>';
        echo '<th class="t-right">'.number_format($g_due,2).'</th>';
        echo '<th class="t-right">'.number_format($g_hall,2).'</th>';
        echo '<th class="t-right">'.number_format($g_elec,2).'</th>';
        echo '<th class="t-right">'.number_format($g_cont,2).'</th>';
        echo '<th class="t-right">'.number_format($g_total,2).'</th>';
        echo '</tr>';
    } else {
        echo '<tr><td colspan="9" class="t-center">No data found for the selected period.</td></tr>';
    }
    ?>
  </table>

  <div class="no-print" style="margin-top:10px; text-align:right;">
    <button onclick="window.print()">Print</button>
  </div>
</div>

<div class="filter-bar no-print">
    <!-- New: Today button -->
    <button type="button" id="btnToday">Today</button>
  </form>
</div>

<script>
  // Format a Date as YYYY-MM-DD in local time
  function formatLocalYmd(d) {
    const y = d.getFullYear();
    const m = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${y}-${m}-${day}`;
  }

  document.getElementById('btnToday').addEventListener('click', function() {
    const form = document.querySelector('.filter-bar form');
    const today = formatLocalYmd(new Date()); // YYYY-MM-DD
    form.querySelector('input[name="start"]').value = today;
    form.querySelector('input[name="end"]').value = today;
    if (form.requestSubmit) { form.requestSubmit(); } else { form.submit(); }
  });
</script>

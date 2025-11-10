<?php 
include("header.php");

$name = "";
$roll = "";
$batch = "";

if (isset($_GET['id']) && $_GET['id'] != "" && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM users WHERE id='$id'");
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $roll = $row['roll'];
        $batch = $row['batch'];
    } else {
        $_SESSION['PERMISSION_ERROR'] = 1;
        redirect('index.php');
    }
} else {
    $_SESSION['PERMISSION_ERROR'] = 1;
    redirect('index.php');
}

if (isset($_POST['submit'])) {
    $user_id = get_safe_value($_GET['id']);
    $total_amount = $_POST['total_amount'];
    $time = time();
    $payment_type = 'cash';
    $tran_id = "becHall_" . uniqid();

    // Updated fixed fees
    $contingency_fee_per_month = 300; 
    $hall_fee_per_month = 10; 
    $electricity_fee_per_month = 100; 

    // Insert into payments
    $sql = "INSERT INTO `payments` (`user_id`,`payment_type`,`tran_id`,`total_amount`,`updated_at`,`created_at`,`paid_status`,`status`) 
            VALUES ('$user_id', '$payment_type','$tran_id','$total_amount', '', '$time', '1', '1')";
    mysqli_query($con, $sql);
    $payment_id = mysqli_insert_id($con);

    // Insert monthly payments + all additional fees
    if (isset($_POST['monthly_amount'])) {
        $count = count($_POST['monthly_amount']);
        for ($i = 0; $i < $count; $i++) {
            $month_id = get_safe_value($_POST['month_id'][$i]);
            $monthly_amount = get_safe_value($_POST['monthly_amount'][$i]);

            // main monthly bill
            mysqli_query($con, "INSERT INTO `monthly_payment_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`added_on`,`status`) 
                                VALUES ('$user_id','$payment_id','$month_id','$monthly_amount','$time','1')");

            // contingency
            mysqli_query($con, "INSERT INTO `contingency_fee_details` (`user_id`,`payment_id`,`month_id`,`contingency_amount`,`added_on`,`status`) 
                                VALUES ('$user_id','$payment_id','$month_id','$contingency_fee_per_month','$time','1')");

            // hall fee
            mysqli_query($con, "INSERT INTO `monthly_fee_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`fee_type`,`added_on`,`status`) 
                                VALUES ('$user_id','$payment_id','$month_id','$hall_fee_per_month','hall_fee','$time','1')");

            // electricity fee
            mysqli_query($con, "INSERT INTO `monthly_fee_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`fee_type`,`added_on`,`status`) 
                                VALUES ('$user_id','$payment_id','$month_id','$electricity_fee_per_month','electricity_fee','$time','1')");

            // mark as paid
            mysqli_query($con, "UPDATE monthly_bill SET paid_status='1' WHERE user_id='$user_id' AND month_id='$month_id'");
        }
    }

   $_SESSION['INSERT'] = 1;

   // sms section started
   // After $payment_id is created and details inserted

   // Fetch student contact and summary for SMS
   $u = mysqli_fetch_assoc(mysqli_query($con, "SELECT name, phoneNumber FROM users WHERE id='$user_id' LIMIT 1"));

   $months = [];
   $mq = mysqli_query($con, "
      SELECT mo.name AS month_name
      FROM monthly_payment_details mpd
      LEFT JOIN month mo ON mo.id = mpd.month_id
      WHERE mpd.payment_id = '$payment_id'
      ORDER BY mpd.month_id
   ");
   if ($mq && mysqli_num_rows($mq) > 0) {
      while ($mrow = mysqli_fetch_assoc($mq)) {
         $months[] = $mrow['month_name'];
      }
   }
   $months_label = !empty($months) ? implode(', ', $months) : 'Selected months';

   // Optional: compute category totals for quick SMS summary
   $sum_due = $sum_hall = $sum_elec = $sum_cont = 0.0;

   // Due
   $r = mysqli_query($con, "SELECT COALESCE(SUM(monthly_amount),0) s FROM monthly_payment_details WHERE payment_id='$payment_id' AND user_id='$user_id'");
   if ($r && ($row = mysqli_fetch_assoc($r))) $sum_due = (float)$row['s'];

   // Hall
   $r = mysqli_query($con, "SELECT COALESCE(SUM(monthly_amount),0) s FROM monthly_fee_details WHERE payment_id='$payment_id' AND user_id='$user_id' AND fee_type='hall_fee'");
   if ($r && ($row = mysqli_fetch_assoc($r))) $sum_hall = (float)$row['s'];

   // Electricity
   $r = mysqli_query($con, "SELECT COALESCE(SUM(monthly_amount),0) s FROM monthly_fee_details WHERE payment_id='$payment_id' AND user_id='$user_id' AND fee_type='electricity_fee'");
   if ($r && ($row = mysqli_fetch_assoc($r))) $sum_elec = (float)$row['s'];

   // Contingency
   $r = mysqli_query($con, "SELECT COALESCE(SUM(contingency_amount),0) s FROM contingency_fee_details WHERE payment_id='$payment_id' AND user_id='$user_id'");
   if ($r && ($row = mysqli_fetch_assoc($r))) $sum_cont = (float)$row['s'];

   // Final paid amount from payments (authoritative)
   $pay = mysqli_fetch_assoc(mysqli_query($con, "SELECT total_amount, tran_id, created_at FROM payments WHERE id='$payment_id' LIMIT 1"));
   $paid_total = isset($pay['total_amount']) ? (float)$pay['total_amount'] : ($sum_due + $sum_hall + $sum_elec + $sum_cont);
   $invoice_no = $payment_id;
   $tran_id    = $pay['tran_id'] ?? '';
   $created_on = !empty($pay['created_at']) && is_numeric($pay['created_at']) ? date('d M Y h:i A', (int)$pay['created_at']) : date('d M Y h:i A');

   // Compose SMS (keep concise)
   $student_name = $u['name'] ?? 'Student';
   $mask_name    = defined('HALL_NAME') ? HALL_NAME : 'BEC Hall';

   // English short
   echo $sms = "{$student_name}, Invoice #{$invoice_no}, Paid Tk ".number_format($paid_total,2)." for {$months_label}. Monthly Due: ".number_format($sum_due,2).", Hall: ".number_format($sum_hall,2).", Elec: ".number_format($sum_elec,2).", Cont: ".number_format($sum_cont,2).". Trx: {$tran_id}";

   // Alternative Bangla-friendly version (uncomment to use)
   // $bn_sms = "{$mask_name}: {$student_name}, ইনভয়েস #{$invoice_no} - মোট ".number_format($paid_total,2)." টাকা পরিশোধিত ({$months_label}). ডিউ ".number_format($sum_due,2).", হল ".number_format($sum_hall,2).", বিদ্যুৎ ".number_format($sum_elec,2).", কনটিনজেন্সি ".number_format($sum_cont,2).". Trx: {$tran_id}";

   // Choose recipient number: prefer user's phoneNumber; fallback to provided
   $recipient = !empty($u['phoneNumber']) ? $u['phoneNumber'] : "01705927257";

   // Send SMS (ensure you loaded bd_bulk_sms_send earlier)
   $sms_result = send_sms("01705927257",$sms);//$recipient

   // Optional: log result
   // mysqli_query($con, sprintf(
   //    "INSERT INTO sms_logs (user_id, payment_id, phone, message, provider_status, provider_response, created_at) VALUES ('%d','%d','%s','%s','%s','%s','%d')",
   //    (int)$user_id,
   //    (int)$payment_id,
   //    mysqli_real_escape_string($con, $recipient),
   //    mysqli_real_escape_string($con, $sms),
   //    mysqli_real_escape_string($con, (string)($sms_result['status'] ?? '')),
   //    mysqli_real_escape_string($con, (string)($sms_result['response'] ?? '')),
   //    time()
   // ));

   // sms section ended 
   redirect("./invoice.php?id=" . md5($payment_id));
}
?>

<div class="dashboard-content-one">
   <div class="breadcrumbs-area">
      <h3>Payment</h3>
      <ul>
         <li><a href="index.php">Home</a></li>
         <li>Payment Details</li>
      </ul>
   </div>

   <div class="card height-auto" >
      <div class="card-body">
         <form method="POST">
            <div class="single-info-details">
               <div class="info-table">
                  <div class="row col-md-12">
                     <table class="table text-nowrap" style="width: 100%;">
                        <tbody>
                           <tr><td>Name:</td><td class="font-medium text-dark-medium"><?php echo $name ?></td></tr>
                           <tr><td>Batch:</td><td class="font-medium text-dark-medium"><?php echo $batch ?></td></tr>
                           <tr><td>Roll:</td><td class="font-medium text-dark-medium"><?php echo $roll ?></td></tr>
                        </tbody>
                     </table>
                     <div class="d-flex justify-content-end">
                        <img src="<?php echo STUDENT_IMAGE . $row['image'] ?>" alt="student" height="150px" width="150px">
                     </div>
                  </div>

                  <hr>

<table class="table table-hover">
   <thead class="thead-dark">
      <tr>
         <th>#</th>
         <th>Month</th>
         <th>Due (৳)</th>
         <th>Hall Fee (৳)</th>
         <th>Electricity (৳)</th>
         <th>Contingency (৳)</th>
         <th><strong>Total (৳)</strong></th>
         <th>Status</th>
      </tr>
   </thead>
   <tbody>
      <?php 
      $sql = "SELECT * FROM monthly_bill WHERE user_id='$id' AND paid_status='0'";
      $res = mysqli_query($con, $sql);
      $contingency_fee_per_month = 300;
      $hall_fee = 10;
      $electricity_fee = 100;

      if (mysqli_num_rows($res) > 0) {
         $i = 1;
         while ($roww = mysqli_fetch_assoc($res)) { 
            $total_amount = $roww['amount'] + $contingency_fee_per_month + $hall_fee + $electricity_fee;
      ?>
            <tr>
               <td><input class="form-control" type="checkbox" value="<?php echo $i ?>" id="checkbox_<?php echo $i ?>" onchange="get_total(this.value)"></td>
               <td><?php echo date("F - y", strtotime($roww['year'] . "-" . $roww['month_id'])) ?></td>
               <td><input disabled type="hidden" id="month_<?php echo $i ?>" name="month_id[]" value="<?php echo $roww['month_id'] ?>"> 
                   <input disabled type="hidden" name="monthly_amount[]" value="<?php echo $roww['amount'] ?>" id="amount_<?php echo $i ?>" class="amount"> 
                   <?php echo number_format($roww['amount'], 2) ?>
               </td>
               <td><?php echo number_format($hall_fee, 2) ?></td>
               <td><?php echo number_format($electricity_fee, 2) ?></td>
               <td><?php echo number_format($contingency_fee_per_month, 2) ?></td>
               <td><strong><?php echo number_format($total_amount, 2) ?></strong></td>
               <td><button type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-red" style="padding: 3px 5px;">Unpaid</button></td>
            </tr>
      <?php 
            $i++; 
         } 
      } else { ?>
         <tr><td colspan="8" class="text-center">No due found</td></tr>
      <?php } ?>
   </tbody>
</table>

<hr>
<div class="row">
   <div class="col-xl-4"></div>
   <div class="col-xl-4">
      <label>Total amount (including all fees)</label>
      <input id="grant_total" style="background-color: #64ed4b;text-align:center;font-size:20px;" value="0" class="form-control" readonly name="total_amount">
   </div>
</div>
<hr>

<div class="row">
   <div class="col-xl-5"></div>
   <div class="col-xl-2">
      <button type="button" class="modal-trigger mt-2" data-toggle="modal" data-target="#standard-modal">Save</button>
   </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="standard-modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header"><h5 class="modal-title">Are You sure?</h5></div>
         <div class="modal-body">Do you want to Pay?</div>
         <div class="modal-footer">
            <button type="button" class="footer-btn bg-dark-low" data-dismiss="modal">Cancel</button>
            <button type="submit" id="submit" disabled class="modal-trigger" data-toggle="modal" data-target="#standard-modal" name="submit">Payment</button>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</form>
</div>

<?php include("footer.php")?>

<script>
function get_total(id) {
   let contingencyFee = 300;
   let hallFee = 10;
   let electricityFee = 100;
   let total = 0;
   let selectedCount = 0;

   if (document.getElementById("checkbox_" + id).checked == true) {
      jQuery('#amount_' + id).addClass('active_amount');
      jQuery('#amount_' + id).prop("disabled", false);
      jQuery('#month_' + id).prop("disabled", false);
      jQuery('#submit').prop("disabled", false);
   } else {
      jQuery('#amount_' + id).removeClass('active_amount');
      jQuery('#amount_' + id).prop("disabled", true);
      jQuery('#month_' + id).prop("disabled", true);
   }

   var amount = document.getElementsByClassName("active_amount");
   for (let i = 0; i < amount.length; i++) {
      total += parseFloat(amount[i].value);
      selectedCount++;
   }

   let grandTotal = total + selectedCount * (contingencyFee + hallFee + electricityFee);
   document.getElementById("grant_total").value = grandTotal.toFixed(2);
}
</script>

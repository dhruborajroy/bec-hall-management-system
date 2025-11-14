<?php 
include("header.php");
   
$id=$_SESSION['USER_ID'];


if (isset($_GET['month_id']) && $_GET['month_id'] != "" && $_GET['month_id'] > 0) {
      // Latest unpaid bill for this user and month, with user details
      $month_id = get_safe_value($_GET['month_id']);
      $sql = "
      SELECT 
         mb.month_id, mb.year, mb.amount, mb.paid_status,
         u.name, u.roll, u.batch, u.image
      FROM monthly_bill AS mb
      INNER JOIN users AS u ON u.id = mb.user_id
      WHERE mb.user_id = {$id}
         AND mb.month_id = '{$month_id}'
         AND mb.paid_status = '0'
      ORDER BY mb.year DESC, mb.id DESC
      LIMIT 1
      ";

      $bRes = mysqli_query($con, $sql);
      if ($bRes && mysqli_num_rows($bRes) > 0) {
         $rowBill = mysqli_fetch_assoc($bRes);

         // Fill your snapshot variables if needed
         $name  = $rowBill['name'] ?? $name ?? '';
         $roll  = $rowBill['roll'] ?? $roll ?? '';
         $batch = $rowBill['batch'] ?? $batch ?? '';
         $image = $rowBill['image'] ?? '';
      }else{
         $_SESSION['PERMISSION_ERROR'] = 1;
         redirect('index.php');
      }

      
      // Load the selected month’s unpaid bill (if any)
      $rowBill = null;
      if ($month_id !== null) {
         // Get the latest unpaid bill record for that month for this user
         $bRes = mysqli_query($con, "SELECT month_id, year, amount FROM monthly_bill WHERE user_id={$id} AND month_id='{$month_id}' AND paid_status='0' ORDER BY year DESC LIMIT 1");
         if ($bRes && mysqli_num_rows($bRes) > 0) {
            $rowBill = mysqli_fetch_assoc($bRes);
         }
      }
      
      // Derived display values
      $hall = HALL_FEE;
      $electricity = ELECTRICITY_FEE;
      $contingency = CONTINGENCY_FEE;
      
      $mn = '';
      $monthly_fee = 0.0;
      $total = 0.0;
      
      if ($rowBill) {
         $mn = date("F - y", strtotime(($rowBill['year'] ?? date('Y'))."-".($rowBill['month_id'] ?? '01')));
         $monthly_fee = (float)($rowBill['amount'] ?? 0);
         $total = $monthly_fee + $hall + $electricity + $contingency;
      } else {
         // If no specific month selected or no due found, show a placeholder row
         $mn = 'No due found';
         $monthly_fee = 0.0;
         $total = 0.0;
      }
      
}else{
      $_SESSION['PERMISSION_ERROR'] = 1;
      redirect('index.php');
}
   
   
?>
<div class="dashboard-content-one">
<!-- Breadcubs Area Start Here -->
<div class="breadcrumbs-area">
   <h3>Payment</h3>
   <ul>
      <li>
         <a href="index.php">Home</a>
      </li>
      <li>Payment Details</li>
   </ul>
</div>
<!-- Breadcubs Area End Here -->
<!-- Student Table Area Start Here -->
<div class="dashboard-content-one">
<div class="card height-auto">
   <div class="card-body">
      <div class="heading-layout1">
         <div class="item-title"></div>
      </div>
      <!-- Main content block (no nested form) -->
      <div class="single-info-details">
         <div class="item-content">
            <div class="info-table ">
               <div class="row">
                  <table class="table text-nowrap">
                     <tbody>
                        <tr>
                           <td>Name:</td>
                           <td class="font-medium text-dark-medium"><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                           <td>Batch :</td>
                           <td class="font-medium text-dark-medium"><?php echo htmlspecialchars($batch, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                           <td>Roll:</td>
                           <td class="font-medium text-dark-medium"><?php echo htmlspecialchars($roll, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                     </tbody>
                  </table>
                  <div class="d-flex justify-content-end">
                     <img src="<?php echo STUDENT_IMAGE . htmlspecialchars($rowUser['image'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" alt="student" height="150" width="150">
                  </div>
               </div>
               <hr>
               <div class="row g-3 align-items-start">
                  <!-- Left: Breakdown -->
                  <div class="col-12 col-lg-7">
                     <div class="card shadow-sm border-0">
                        <div class="card-body">
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Month</span>
                              <span class="fw-semibold"><?php echo htmlspecialchars($mn, ENT_QUOTES, 'UTF-8'); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Due</span>
                              <span>৳ <?php echo number_format($monthly_fee, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Hall fee</span>
                              <span>৳ <?php echo number_format($hall, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Electricity</span>
                              <span>৳ <?php echo number_format($electricity, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Contingency</span>
                              <span>৳ <?php echo number_format($contingency, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted"><b>Total amount</b></span>
                              <span><b>৳ <?php echo number_format($total, 2); ?></b></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Right: total + centered actions -->
                  <div class="col-12 col-lg-5">
                     <div class="card shadow-sm border-0 h-100">
                        <div class="card-body d-flex flex-column">
                           <div class="text-muted">Total amount</div>
                           <div class="display-5 fw-bold text-success my-2" style="letter-spacing:0.5px;">
                              ৳ <?php echo number_format($total_amount=$total, 2); ?>
                           </div>
                           <div class="text-muted">Transaction Charge</div>
                           <div class="display-5 fw-bold text-success my-2" style="letter-spacing:0.5px;">
                              ৳ <?php echo ceil(floatval($cashout=$total*BKASH_FEE)); ?>
                           </div>
                           <div class="text-muted">Amount+Fee+Bkash Charge</div>
                           <div class="display-5 fw-bold text-success my-2" style="letter-spacing:0.5px;">
                              ৳ <?php echo ceil(floatval($total_amount+$cashout))?>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xl-5"></div>
                  <div class="col-xl-5">
                     <?php if ($rowBill): ?>
                     <form method="POST" action="initiate_payment.php" class="d-inline">
                        <input type="hidden" name="confirm_month_id" value="<?php echo (int)$rowBill['month_id']; ?>">
                        <button type="submit" class="modal-trigger mt-2" style="gap:10px;">
                        <span>Proceed to bKash</span>
                        </button>
                     </form>
                     <?php endif; ?>
                     <!-- <button type="button" class="modal-trigger mt-2" data-toggle="modal" data-target="#standard-modal">Save</button> -->
                  </div>
               </div>
            </div>
         </div>
         <!-- End main block -->
      </div>
   </div>
</div>
<!-- Confirmation Modal (kept for parity; not tied to any nested form) -->
<div class="modal fade" id="standard-modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Are You sure?</h5>
         </div>
         <div class="modal-body">Do you want to Pay?</div>
         <div class="modal-footer">
            <button type="button" class="footer-btn bg-dark-low" data-dismiss="modal">Cancel</button>
            <button type="button" id="submit" class="modal-trigger" data-toggle="modal" data-target="#standard-modal" disabled>Payment</button>
         </div>
      </div>
   </div>
</div>
<!-- Student Table Area End Here -->
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
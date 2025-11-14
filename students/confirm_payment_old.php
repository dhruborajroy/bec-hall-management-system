<?php 
   include("header.php");
   
   // Assume $con, $id (logged-in user id) are defined
   $rowBill = null;
   $id=$uid;
   // Normalize input month_id as zero-padded string
   $month_id = isset($_GET['month_id']) && $_GET['month_id'] !== '' ? sprintf('%02d', (int)$_GET['month_id']) : null;
   
   if ($month_id !== null) {
       // Latest unpaid bill for this user and month, with user details
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
       }
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
   $HALL = 10.0;
   $ELECTRICITY = 100.0;
   $CONTINGENCY = 300.0;
   
   $mn = '';
   $base = 0.0;
   $total = 0.0;
   
   if ($rowBill) {
       $mn = date("F - y", strtotime(($rowBill['year'] ?? date('Y'))."-".($rowBill['month_id'] ?? '01')));
       $base = (float)($rowBill['amount'] ?? 0);
       $total = $base + $HALL + $ELECTRICITY + $CONTINGENCY;
   } else {
       // If no specific month selected or no due found, show a placeholder row
       $mn = 'No due found';
       $base = 0.0;
       $total = 0.0;
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
                              <span>৳ <?php echo number_format($base, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Hall fee</span>
                              <span>৳ <?php echo number_format($HALL, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2 border-bottom">
                              <span class="text-muted">Electricity</span>
                              <span>৳ <?php echo number_format($ELECTRICITY, 2); ?></span>
                           </div>
                           <div class="d-flex justify-content-between py-2">
                              <span class="text-muted">Contingency</span>
                              <span>৳ <?php echo number_format($CONTINGENCY, 2); ?></span>
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
                              ৳ <?php echo number_format($total, 2); ?>
                           </div>
                           <div class="small text-secondary">Includes Due, Hall, Electricity, and Contingency</div>
                           <div class="mt-auto">
                              <div class="d-flex justify-content-center gap-3 pt-3 flex-wrap">
                                 <a href="payment_page.php" class="btn btn-outline-secondary px-4">Back</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>


            <div class="row">
               <div class="col-xl-5"></div>
               <div class="col-xl-2">
                  <button type="button" class="modal-trigger mt-2" data-toggle="modal" data-target="#standard-modal">Save</button>
               </div>
            </div>
            
                  <div class="col-12 col-lg-7">
                  
                  <?php if ($rowBill): ?>
                      <form method="POST" action="initiate_payment.php" class="d-inline">
                        <input type="hidden" name="confirm_month_id" value="<?php echo (int)$rowBill['month_id']; ?>">
                        <button type="submit" class="btn btn-primary d-flex align-items-center px-4 py-2" style="gap:10px;">
                        <img src="data:image/png;base64,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" 
                            alt="bKash" style="height:26px; width:auto; display:block;">
                        <span>Proceed to bKash</span>
                        </button>
                      </form>
                    <?php endif; ?>
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
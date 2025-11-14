<?php 
include("header.php");
   $val_id="";
   $amount="";
   $card_type="";
   $tran_date="";
   $card_issuer="";
   $card_no="";
   $error="";
   $status="";
   $_GET['id']=$_SESSION['USER_ID'];
   if(isset($_GET['id']) && $_GET['id']!=""){
       $id=get_safe_value($_GET['id']);
       $res=mysqli_query($con,"select * from users where id='$id'");
       if(mysqli_num_rows($res)>0){
           $row=mysqli_fetch_assoc($res);
           $name=$row['name'];
           $roll=$row['roll'];
           $batch=$row['batch'];
           $email=$row['email'];
           $presentAddress=$row['presentAddress'];
           $permanentAddress=$row['permanentAddress'];
           $phoneNumber=$row['phoneNumber'];
           $email=$row['email'];
       }else{
            $_SESSION['PERMISSION_ERROR']=1;
            redirect('index.php');
       }
   }
   if (isset($_POST['submit'])) {
       $user_id = get_safe_value($_GET['id']);
       $total_amount = $_POST['total_amount'];
       $time = time();
       $payment_type = 'cash';
       $tran_id = "becHall_" . uniqid();
   
       // Updated fixed fees
       $contingency_fee_per_month = CONTINGENCY_FEE; 
       $hall_fee_per_month = HALL_FEE; 
       $electricity_fee_per_month = ELECTRICITY_FEE; 
   
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
<div class="card height-auto">
   <div class="card-body">
      <div class="heading-layout1">
         <div class="item-title">
            <!-- <h3>About Me</h3> -->
         </div>
      </div>
      <form method="POST">
         <div class="single-info-details">
            <div class="item-content">
               <div class="info-table ">
                  <div class="row">
                     <table class="table text-nowrap">
                        <tbody>
                           <tr>
                              <td>Name:</td>
                              <td class="font-medium text-dark-medium"><?php echo $name?></td>
                           </tr>
                           <tr>
                              <td>Batch :</td>
                              <td class="font-medium text-dark-medium"><?php echo $batch?></td>
                           </tr>
                           <tr>
                              <td>Roll:</td>
                              <td class="font-medium text-dark-medium"><?php echo $roll?></td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="d-flex justify-content-end">
                        <img src="<?php echo STUDENT_IMAGE.$row['image']?>" alt="teacher" height="150px" width="150px">
                     </div>
                  </div>
                  <hr>

            <table class="table table-hover"  style="width: 100%;">
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
                     $contingency_fee_per_month = CONTINGENCY_FEE;
                     $hall_fee = HALL_FEE;
                     $electricity_fee = ELECTRICITY_FEE;
                     
                     if (mysqli_num_rows($res) > 0) {
                        $i = 1;
                        while ($roww = mysqli_fetch_assoc($res)) { 
                           $total_amount = $roww['amount'] + $contingency_fee_per_month + $hall_fee + $electricity_fee;
                     ?>
                  <tr>
                     <td><?php echo $i ?></td>
                     <td><?php echo date("F - y", strtotime($roww['year'] . "-" . $roww['month_id'])) ?></td>
                     <td><input disabled type="hidden" id="month_<?php echo $i ?>" name="month_id[]" value="<?php echo $roww['month_id'] ?>"> 
                        <input disabled type="hidden" name="monthly_amount[]" value="<?php echo $roww['amount'] ?>" id="amount_<?php echo $i ?>" class="amount"> 
                        <?php echo number_format($roww['amount'], 2) ?>
                     </td>
                     <td><?php echo number_format($hall_fee, 2) ?></td>
                     <td><?php echo number_format($electricity_fee, 2) ?></td>
                     <td><?php echo number_format($contingency_fee_per_month, 2) ?></td>
                     <td><strong><?php echo number_format($total_amount, 2) ?></strong></td>
                     <td>
                        <a class="modal-trigger mt-2 text-white" href="confirm_payment.php?month_id=<?php echo $roww['month_id']?>">
                           Pay online
                        </a>
                     </td>
                  </tr>
                  <?php 
                     $i++; 
                     } 
                     } else { ?>
                  <tr>
                     <td colspan="8" class="text-center">No due found</td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
            </div>
         </div>
      </form>
      </div>
   </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="standard-modal" tabindex="-1" role="dialog" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Are You sure?</h5>
         </div>
         <div class="modal-body">Do you want to Pay?</div>
         <div class="modal-footer">
            <button type="button" class="footer-btn bg-dark-low" data-dismiss="modal">Cancel</button>
            <button type="submit" id="submit" disabled class="modal-trigger" data-toggle="modal" data-target="#standard-modal" name="submit">Payment</button>
         </div>
      </div>
   </div>
</div>
<!-- Student Table Area End Here -->
<?php include("footer.php")?>

<script>
   function get_total(id) {
      let contingencyFee = <?php echo CONTINGENCY_FEE?>;
      let hallFee = <?php echo HALL_FEE?>;
      let electricityFee = <?php echo ELECTRICITY_FEE?>;
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
<!-- Include SweetAlert2 (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Parse query params
  const params = new URLSearchParams(window.location.search);
  const bkashPaymentId = params.get('bkash_payment_id');
  const status = params.get('status');
  const paymentID = params.get('paymentID');

  // Helper to show alert with SweetAlert2
  function showPaymentAlert() {
    if (!status) return; // nothing to show if no status [web:14]

    // Build a readable message
    let title = 'Payment Status';
    let text = `Status: ${status}`;
    if (bkashPaymentId) text += `\nBkash Payment ID: ${bkashPaymentId}`;
    if (paymentID && paymentID !== bkashPaymentId) text += `\nPayment ID: ${paymentID}`;

    // Choose icon based on status
    let icon = 'info';
    if (status === 'success') icon = 'success';
    else if (status === 'cancel' || status === 'canceled' || status === 'failed') icon = 'error';

    // Show SweetAlert2
    Swal.fire({
      icon,
      title,
      text,
      confirmButtonText: 'OK'
    });
  }

  // Run after DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', showPaymentAlert);
  } else {
    showPaymentAlert();
  }
</script>

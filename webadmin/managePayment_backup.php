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
       $contingency_fee_per_month = 50; // set contingency per month (BDT 50)
   
       // Insert payment record
       $sql = "INSERT INTO `payments` (`user_id`,`payment_type`,`tran_id`,`total_amount`,`updated_at`,`created_at`,`paid_status`,`status`) 
               VALUES ('$user_id', '$payment_type','$tran_id','$total_amount', '', '$time', '1', '1')";
       mysqli_query($con, $sql);
       $payment_id = mysqli_insert_id($con);
   
       // Insert monthly payments + contingency fee
       if (isset($_POST['monthly_amount'])) {
           $monthly_amount_count = count($_POST['monthly_amount']);
           for ($i = 0; $i < $monthly_amount_count; $i++) {
               $monthly_amount = get_safe_value($_POST['monthly_amount'][$i]);
               $month_id = get_safe_value($_POST['month_id'][$i]);
   
               // Insert monthly payment record
               $sql1 = "INSERT INTO `monthly_payment_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`added_on`,`status`) 
                        VALUES ('$user_id', '$payment_id', '$month_id', '$monthly_amount', '$time','1')";
               mysqli_query($con, $sql1);
   
               // Insert contingency fee record
               $contingency_amount = $contingency_fee_per_month;
               $sql2 = "INSERT INTO `contingency_fee_details` (`user_id`,`payment_id`,`month_id`,`contingency_amount`,`added_on`,`status`) 
                        VALUES ('$user_id', '$payment_id', '$month_id', '$contingency_amount', '$time','1')";
               mysqli_query($con, $sql2);
   
               // Update monthly bill as paid
               mysqli_query($con, "UPDATE monthly_bill SET paid_status='1' WHERE user_id='$user_id' AND month_id='$month_id'");
           }
       }
   
       // Insert other monthly fees (if any)
       if (isset($_POST['monthly_fee_amount'])) {
           $monthly_fee_count = count($_POST['monthly_fee_amount']);
           for ($i = 0; $i < $monthly_fee_count; $i++) {
               $monthly_fee_amount = get_safe_value($_POST['monthly_fee_amount'][$i]);
               $fee_month_id = get_safe_value($_POST['fee_month_id'][$i]);
   
               $sql3 = "INSERT INTO `monthly_fee_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`added_on`,`status`) 
                        VALUES ('$user_id', '$payment_id', '$fee_month_id', '$monthly_fee_amount', '$time','1')";
               mysqli_query($con, $sql3);
   
               mysqli_query($con, "UPDATE monthly_fee SET paid_status='1' WHERE user_id='$user_id' AND month_id='$fee_month_id'");
           }
       }
   
       // Insert one-time fees (if any)
       if (isset($_POST['fee_amount'])) {
           $fee_count = count($_POST['fee_amount']);
           for ($i = 0; $i < $fee_count; $i++) {
               $fee_id = get_safe_value($_POST['fee_id'][$i]);
               $fee_amount = get_safe_value($_POST['fee_amount'][$i]);
               $sql4 = "INSERT INTO `fee_details` (`user_id`,`payment_id`,`fee_id`,`fee_amount`,`added_on`,`status`) 
                        VALUES ('$user_id','$payment_id','$fee_id','$fee_amount','$time','1')";
               mysqli_query($con, $sql4);
           }
       }
   
       $_SESSION['INSERT'] = 1;
       redirect("./invoice.php?id=" . md5($payment_id));
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
                  <table class="table table-hover" style="width: 100%;">
               <thead class="thead-dark">
                  <tr>
                     <th>#</th>
                     <th>Month</th>
                     <th>Due (৳)</th>
                     <th>Contingency (৳)</th>
                     <th>Status</th>
                  </tr>
               </thead>
               <tbody>
                  <?php 
                     $sqll = "SELECT * FROM monthly_bill WHERE user_id='$id' AND paid_status='0'";
                     $ress = mysqli_query($con, $sqll);
                     $contingency_fee_per_month = 50; // fixed contingency per month
                     
                     if (mysqli_num_rows($ress) > 0) {
                        $i = 1;
                        while ($roww = mysqli_fetch_assoc($ress)) { ?>
                  <tr>
                     <td>
                        <input class="form-control" type="checkbox" value="<?php echo $i ?>" id="checkbox_<?php echo $i ?>" onchange="get_total(this.value)">
                     </td>
                     <td><?php echo date("F - y", strtotime($roww['year'] . "-" . $roww['month_id'])) ?></td>
                     <td>
                        <input disabled type="hidden" id="month_<?php echo $i ?>" name="month_id[]" value="<?php echo $roww['month_id'] ?>"> 
                        <input disabled type="hidden" name="monthly_amount[]" value="<?php echo $roww['amount'] ?>" id="amount_<?php echo $i ?>" class="amount"> 
                        <?php echo number_format($roww['amount'], 2) ?>
                     </td>
                     <td>
                        <input type="hidden" class="contingency_fee" value="<?php echo $contingency_fee_per_month; ?>">
                        <?php echo number_format($contingency_fee_per_month, 2); ?>
                     </td>
                     <td>
                        <button type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-red" style="padding: 3px 5px;">Unpaid</button>
                     </td>
                  </tr>
                  <?php $i++; } 
                     } else { ?>
                  <tr>
                     <td colspan="5" class="text-center">No due found</td>
                  </tr>
                  <?php } ?>
               </tbody>
                  </table>
                  <hr>
                  <table class="table table-hover" style="width: 100%;">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Month</th>
                           <th scope="col">Due</th>
                           <th scope="col">Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $sqll="select * from monthly_fee where user_id='$id' and paid_status!=1";
                           $ress=mysqli_query($con,$sqll);
                           if(mysqli_num_rows($ress)>0){
                              $i=1;
                              while($roww=mysqli_fetch_assoc($ress)){
                           ?>
                        <tr>
                           <td>
                              <input class="form-control" type="checkbox"  value="<?php echo $i?>"  id="monthly_fee_checkbox_<?php echo $i?>"  onchange="get_montly_fee_total(this.value)">
                           </td>
                           <td><?php echo  date("F - y",strtotime($roww['year']."-".$roww['month_id']))  ?></td>
                           <td >
                              <input disabled type="hidden" id="fee_month_<?php echo $i?>" name="fee_month_id[]" value="<?php echo  $roww['month_id']?>" class="amount"> 
                              <input disabled type="hidden" name="monthly_fee_amount[]" value="<?php echo  $roww['amount']?>" class="amount" id="monthly_fee_amount_<?php echo $i?>"> 
                              <?php echo  $roww['amount']?>
                           </td>
                           <td>
                              <button  type="button" style="padding: 3px 5px;" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-red">Unpaid</button>
                           </td>
                        </tr>
                        <?php 
                           $i++;
                           } } else { ?>
                        <tr colspan="5">
                           <td  class="d-flex justify-content-center">No due found</td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                  <hr>
                  <hr>
                  <table class="table table-hover" style="width: 100%;">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">Select</th>
                           <th scope="col">Month</th>
                           <th scope="col">Due</th>
                           <th scope="col">Due</th>
                           <th scope="col">qty</th>
                           <!-- <th scope="col">Status</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $sqll="select * from fees where show_payment_page='1'";
                           $ress=mysqli_query($con,$sqll);
                           if(mysqli_num_rows($ress)>0){
                              $i=1;
                              while($roww=mysqli_fetch_assoc($ress)){
                           ?>
                        <tr>
                           <td>
                              <input class="form-control" type="checkbox" value="<?php echo $i?>"  id="fee_checkbox_<?php echo $i?>"  onchange="get_fee_total(this.value)">
                           </td>
                           <td>
                              <?php echo $roww['name']?>
                           </td>
                           <td>
                              <span style="margin-right: 10px;font-size: 35px;cursor: pointer;" onclick="minus('<?php echo $i?>')">-</span><span>
                              <input type="button" value="1" id="qty_<?php echo $i?>"></span>
                              <span onclick="plus('<?php echo $i?>')" style="margin-left: 10px;font-size: 25px;cursor: pointer;">+</span>
                           </td>
                           <td>
                              <?php echo  $roww['amount']?>
                           </td>
                           <td >
                              <input disabled type="hidden" name="fee_id[]" value="<?php echo  $roww['id']?>" class="amount" id="fee_id_<?php echo $i?>"> 
                              <input disabled type="text" style="text-align:center;font-size:20px;"  readonly name="fee_amount[]" value="<?php echo  $roww['amount']?>" class="amount" id="fee_amount_<?php echo $i?>"> 
                              <input type="hidden" id="fee_main_amount_<?php echo $i?>" value="<?php echo  $roww['amount']?>">
                           </td>
                        </tr>
                        <?php 
                           $i++;
                           } } else { ?>
                        <tr colspan="5">
                           <td  class="d-flex justify-content-center">No due found</td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                  <hr>
                  <div class="row">
                     <div class="col-xl-4 col-lg-8 col-4 form-group">
                     </div>
                     <div class="col-xl-4 col-lg-4 col-4 form-group">
                        <label>Total amount</label>
                        <input id="grant_total" style="background-color: #64ed4b;text-align:center;font-size:20px;" value="0" class="form-control" readonly name="total_amount">
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
                     <div class="col-xl-2 col-lg-2 col-12 form-group">
                        <button type="button" class="modal-trigger mt-2" data-toggle="modal"
                           data-target="#standard-modal">
                        Save
                        </button>
                     </div>
                     <!-- Modal -->
                     <div class="modal fade" id="standard-modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">Are You sure?</h5>
                              </div>
                              <div class="modal-body">
                                 Do you want to Pay?
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="footer-btn bg-dark-low"
                                    data-dismiss="modal">Cancel</button>
                                 <button type="submit" id="submit" disabled class="modal-trigger" data-toggle="modal"
                                    data-target="#standard-modal" name="submit">Payment</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-box">
                     <!-- Button trigger modal -->
                     <div class="row">
                        <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
                        <div class="col-xl-2 col-lg-2 col-12 form-group">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </form>
      </div>
   </div>
</div>
<!-- Student Table Area End Here -->
<?php include("footer.php")?>

<script>
   function get_total(id) {
      let contingencyFee = 50; // same as PHP variable
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
   
      let contingencyTotal = contingencyFee * selectedCount;
      let grandTotal = total + contingencyTotal;
   
      document.getElementById("grant_total").value = grandTotal.toFixed(2);
   }
</script>
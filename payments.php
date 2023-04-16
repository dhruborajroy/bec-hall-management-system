<?php 
include("header.php"); 
$val_id="";
$amount="";
$card_type="";
$tran_date="";
$card_issuer="";
$card_no="";
$error="";
$msg="";
$status="pending";
$createPayment['bkashURL']="";
$createPayment['message']="";
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   // redirect('index.php');
}
$user_id=$_SESSION['APPLICANT_ID'];
$sql="select * from `applicants` where id='".$_SESSION['APPLICANT_ID']."'";
$total_amount=round(intval(FORM_AMOUNT)*(1+SERVICE_CHARGE),2);
$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
if(isset($_GET['status'])){
   $status=get_safe_value($_GET['status']);
   if($status=='cancel'){
      $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "Payment has been cancelled by User.", "error")</script>';
   }
   if($status=='failure'){
      $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "OTP not valid", "error")</script>';
   }
   if($status=='success'){
      $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "Payment completed", "success")</script>';
   }
   if(isset($_GET['statusMessage'])){
      $status="Duplicate transection";
      $statusMessage=" Please try after sometime.";
      $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($status).'", "'.$statusMessage.'", "error")</script>';
   }
   if(isset($_GET['statusMessage']) && isset($_GET['status'])){
      $status=$_GET['status'];
      $statusMessage=$_GET['statusMessage'];
      $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($status).'", "'.$statusMessage.'", "error")</script>';
   }
   redirect("payments");
}
   if(isset($_POST['bkash'])){
   $amount=round($total_amount,2);
   $token=timeWiseTokenGeneartion();
   // pr($token);
   $user_data=array(
       'tran_id'=>uniqid("admission_"),
       'amount'=>$amount,
   );
   if(isset($token['id_token'])){
      $createPayment=createPayment($token['id_token'],$user_data);
      if(isset($createPayment['message'])){
         $msg= $createPayment['message'];
      }
      if(isset($createPayment['statusCode']) && $createPayment['statusCode']==000){
         $statusMessage=$createPayment['statusMessage'];
         $paymentID=$createPayment['paymentID'];
         $amount=$createPayment['amount'];
         $paymentCreateTime=$createPayment['paymentCreateTime'];
         $merchantInvoiceNumber=$createPayment['merchantInvoiceNumber'];
         $sql="INSERT INTO `bkash_online_payment` ( `tran_id`,`user_id`, `bkash_payment_id`,`customerMsisdn`,`trxID`,`amount`,`statusMessage`, `added_on`,`updated_on`,`status`) VALUES 
                                       ( '$merchantInvoiceNumber', '$user_id','$paymentID',  '',   '', '$amount', '','$paymentCreateTime', '', 'pending')";
         if(mysqli_query($con,$sql)){
            redirect($createPayment['bkashURL']);
            die;
         }else{
            $msg="Something Went Wrong";
         }
      }
   }else{
      $msg="Something Went Wrong";
   }
}
?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>
                     <div class="col-xl-9 col-md-8">
                     <div class="settings-widget profile-details">
                        <div class="settings-inner-blk p-0">
                           <div class="comman-space pb-0">
                              <?php echo $msg?>
                              <?php 
                              // $sql="select tran_id from bkash_online_payment where user_id='".$user_id."'";
                              // $res=mysqli_query($con,$sql);
                              // if(mysqli_num_rows($res)>!0){}else{
                              ?>
                              <!-- <form  method="post">
                              <div class="go-dashboard text-center ">
                                    <br>
                                    <button type="submit" name="bkash" >
                                       <img src="./assets/img/bkash.png" weight="100px" height="70px" alt="Bkash Payment" >
                                    </button>
                                    <!-- <button type="submit" name="sslcommerz" class="btn btn-primary">Pay Using Online Payment</button> 
                              </div>
                              </form> -->
                              <?php //}?>
                              <div class="settings-invoice-blk table-responsive comman-space pb-0">
                                 <h4 align="center">Payments</h4>
                                 <table class="table table-borderless mb-0">
                                    <thead>
                                       <tr>
                                          <th>Order id</th>
                                          <th>amount</th>
                                          <th>Date</th>
                                          <!-- <th>Payment ID</th> -->
                                          <th>TrxID</th>
                                          <th>Payment Details</th>
                                          <th>status</th>
                                          <th>Download</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $sql="select * from bkash_online_payment where user_id='".$_SESSION['APPLICANT_ID']."' and status!='pending' order by updated_on desc";
                                       $res=mysqli_query($con,$sql);
                                       if(mysqli_num_rows($res)>0){
                                       $i=1;
                                       while($row=mysqli_fetch_assoc($res)){
                                       ?>
                                       <tr>
                                          <td><a href="pdfreports/invoice?invoice_id=<?php echo $row['tran_id']?>" class="invoice-no">#<?php echo $row['tran_id']?></a></td>
                                          <td><?php echo $row['amount']?></td>
                                          <td><?php echo date("d M Y h:i A",$row['updated_on'])?></td>
                                          <!-- <td><?php //echo $row['bkash_payment_id']?></td> -->
                                          <td><?php echo $row['trxID']?></td>
                                          <?php if($row['status']=='Completed'){?>
                                             <td><span class="badge status-completed"><?php echo $row['status']?></span></td>
                                          <?php }else{?>
                                             <td><span class="badge status-due"><?php echo ucfirst($row['status'])?></span></td>
                                          <?php }?>
                                          <td><?php echo $row['statusMessage']?></td>
                                          <td><a href="pdfreports/invoice?invoice_id=<?php echo $row['tran_id']?>" class="btn-style"><i class="feather-download"></i></a></td>
                                       </tr>
                                       <?php 
                                          $i++;
                                          } } else { ?>
                                       <tr>
                                          <td colspan="5" align="center">No data found</td>
                                       </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- page content ended -->
               </div>
            </div>
         </div>
<?php 
include("footer.php");
if(isset($_SESSION['TOASTR_MSG'])){?>
   <script>
      toastrMsg('<?php echo $_SESSION['TOASTR_MSG']['type']?>',"<?php echo $_SESSION['TOASTR_MSG']['body']?>","<?php echo $_SESSION['TOASTR_MSG']['title']?>");
   </script>
<?php 
unset($_SESSION['TOASTR_MSG']);
}
if(isset($_SESSION['PAYMENT_ERROR'])){
   echo $_SESSION['PAYMENT_ERROR'];
   unset($_SESSION['PAYMENT_ERROR']);
}
?>
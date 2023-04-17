<?php 
include("header.php"); 
$val_id="";
$amount="";
$card_type="";
$tran_date="";
$card_issuer="";
$card_no="";
$error="";
$msg='<div class="alert alert-success">An SMS containing Username and password has been sent to your Phone Number. Please Save and use the password to log into your account.</div>';
$status="pending";
$createPayment['bkashURL']="";
$createPayment['message']="";
if(isset($_GET['bkash_payment_id']) && $_GET['bkash_payment_id']!==""){
   $bkash_payment_id=get_safe_value($_GET['bkash_payment_id']);
   $sql="select applicants.*,bkash_online_payment.bkash_payment_id from `applicants`,bkash_online_payment where bkash_online_payment.bkash_payment_id='$bkash_payment_id' and applicants.id=bkash_online_payment.user_id";
   $total_amount=round(intval(FORM_AMOUNT)*(1+SERVICE_CHARGE),2);
   $row=mysqli_fetch_assoc(mysqli_query($con,$sql));
   $first_name=$row['first_name'];
   $last_name=$row['last_name'];
   $f_name=$row['fName'];
   $fNid=$row['fNid'];
   $m_name=$row['mName'];
   $mNid=$row['mNid'];
   $phoneNumber=$row['phoneNumber'];
   $presentAddress=$row['presentAddress'];
   $permanentAddress=$row['permanentAddress'];
   $dob=$row['dob'];
   $gender=$row['gender'];
   $religion=$row['religion'];
   $birthId=$row['birthId'];
   $quota=$row['quota'];
   $bloodGroup=$row['bloodGroup'];
   $localGuardianName=$row['localGuardianName'];
   $localGuardianNid=$row['localGuardianNid'];
   $email=$row['email'];
   $image=$row['image'];
   $class=$row['class'];
   if(isset($_GET['status'])){
      $status=get_safe_value($_GET['status']);
      if($status=='cancel'){
         $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "Payment has been cancelled by User.", "error")</script>';
      }elseif($status=='failure'){
         $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "OTP not valid", "error")</script>';
      }elseif($status=='success'){
         $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "Payment completed", "success")</script>';
      }elseif(isset($_GET['statusMessage'])){
         $status="Duplicate transection";
         $statusMessage=" Please try after sometime.";
         $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($status).'", "'.$statusMessage.'", "error")</script>';
      }elseif(isset($_GET['statusMessage']) && isset($_GET['status'])){
         $status=$_GET['status'];
         $statusMessage=$_GET['statusMessage'];
         $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($status).'", "'.$statusMessage.'", "error")</script>';
      }
      // redirect("payments");

   }else{
      $_SESSION['TOASTR_MSG']=array(
         'type'=>'error',
         'body'=>'You don\'t have the permission to access the location!',
         'title'=>'Error',
      );
      redirect("index");
   }
}else{
   $_SESSION['TOASTR_MSG']=array(
      'type'=>'error',
      'body'=>'You don\'t have the permission to access the location!',
      'title'=>'Error',
   );
   // redirect("index");

}

?>
<div class="page-content instructor-page-content">
   <div class="container">
      <div class="row">
            <div class="col-xl-12 col-md-12">
            <div class="settings-widget profile-details">
               <div class="settings-inner-blk p-0">
                  <div class="comman-space pb-0">
                     <?php echo $msg?>
                     <div class="settings-invoice-blk table-responsive comman-space pb-0">
                        <h4 align="center">Payments</h4>
                        <table class="table table-borderless mb-0">
                           <thead>
                              <tr>
                                 <th>Order id</th>
                                 <th>amount</th>
                                 <th>Date</th>
                                 <th>TrxID</th>
                                 <th>Payment Details</th>
                                 <th>Download</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $payment_sql="select * from bkash_online_payment where user_id='".$row['id']."' and bkash_payment_id='$bkash_payment_id' and status!='pending' order by updated_on desc";
                              $payment_res=mysqli_query($con,$payment_sql);
                              if(mysqli_num_rows($payment_res)>0){
                              $i=1;
                              while($payment_row=mysqli_fetch_assoc($payment_res)){
                              ?>
                              <tr>
                                 <td><a href="pdfreports/invoice?invoice_id=<?php echo $payment_row['tran_id']?>" class="invoice-no">#<?php echo $payment_row['tran_id']?></a></td>
                                 <td><?php echo $payment_row['amount']?></td>
                                 <td><?php echo date("d M Y h:i A",$payment_row['updated_on'])?></td>
                                 <td><?php echo $payment_row['trxID']?></td>
                                 <?php 
                                 $status=$payment_row['status'];
                                 if($status=='Completed'){?>
                                    <td><span class="badge status-completed"><?php echo $status?></span></td>
                                 <?php }else{?>
                                    <td><span class="badge status-due"><?php echo ucfirst($status)?></span></td>
                                 <?php }?>
                                 <!-- <td><?php //echo $payment_row['statusMessage']?></td> -->
                                 <td><a href="pdfreports/invoice?invoice_id=<?php echo $payment_row['tran_id']?>" class="btn-style"><i class="feather-download"></i></a></td>
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

                     <section class="course-content checkout-widget">
                        <div class="container">
                           <div class="col-md-12">
                              <div class="settings-widget">
                                 <div class="settings-inner-blk p-0">
                                    <div class="sell-course-head comman-space">
                                       <h3 align="center">Basic Informations</h3>
                                       <table id="preview">
                                          <tbody>
                                             <tr>
                                                <td>First Name: </td>
                                                <td><?php echo $first_name?></td>
                                             </tr>
                                             <tr>
                                                <td>Last Name: </td>
                                                <td> <?php echo $last_name?></td>
                                             </tr>
                                             <tr>
                                                <td>Date of Birth: </td>
                                                <td><?php echo $dob?></td>
                                             </tr>
                                             <tr>
                                                <td>Gender</td>
                                                <td> <?php echo $gender?></td>
                                             </tr>
                                             <tr>
                                                <td>Email: </td>
                                                <td><?php echo $email?></td>
                                             </tr>
                                             <tr>
                                                <td>Phone Number: </td>
                                                <td><?php echo $phoneNumber?></td>
                                             </tr>
                                             <tr>
                                                <td>Payment Status: </td>
                                                   <?php if($status=='Completed'){?>
                                                      <td><span style="background: #159f46;font-size: 14px;padding: 7px 10px;font-weight: 400;border-radius: 5px;color: #fff;"><?php echo $status?></span></td>
                                                   <?php }else{?>
                                                      <td><span style="background: #e53935;font-size: 14px;padding: 7px 10px;font-weight: 400;border-radius: 5px;color: #fff;"><?php echo ucfirst($status)?></span></td>
                                                   <?php }?></td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-12">
                              <div class="settings-widget">
                                 <div class="settings-inner-blk p-0">
                                    <div class="sell-course-head comman-space">
                                       <h3 align="center">Admission Details</h3>
                                       <table id="preview">
                                          <tbody>
                                             <tr>
                                                <td>Class Name: </td>
                                                <td> <?php echo $class?></td>
                                             </tr>
                                             <tr>
                                                <td>Quota:  </td>
                                                <td><?php echo $quota?></td>
                                             </tr>
                                             <tr>
                                                <td>Blood Group: </td>
                                                <td>  <?php echo $bloodGroup?></td>
                                             </tr>
                                             <tr>
                                                <td>Religion: </td>
                                                <td>  <?php echo $religion?></td>
                                             </tr>
                                          </tbody>
                                       </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
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
<?php
   include("header.php");
   $display="";
   $class="1";
   $application_id="";
   $msg="";
   $first_name="d";
   $last_name="d";
   $f_name="d";
   $m_name="d";
   $phone_number="3".rand(111,999);
   $email="sd@fm.co".rand(111,999);
   $blood_group="A+";
   $present_address="s";
   $gender="Male";
   $permanent_address="d";
   $dob="30/11/2002";
   $quota="N/A";
   $password="m";
   $religion="Hinduism";
   $code="";
   $f_nid="s";
   $m_nid="s";
   $local_guardian_name="sd";
   $local_guardian_nid="s";
   $image="";
   $birthID="2344";
   $user_id="";
   if(isset($_POST['submit'])){
   	$application_id=ucfirst(get_safe_value($_POST['application_id']));
      $sql="select * from applicants where id='$application_id'";
      $res=mysqli_query($con,$sql);
      if(mysqli_num_rows($res)>0){
         $search=true;
         $row=mysqli_fetch_assoc($res);
         $first_name=$row['first_name'];
         $last_name=$row['last_name'];
         $f_name=$row['fName'];
         $fNid=$row['fNid'];
         $m_name=$row['mName'];
         $mNid=$row['mNid'];
         $phoneNumber=$row['phoneNumber'];
         $presentAddress=$row['presentAddress'];
         $permanentAddress=$row['permanentAddress'];
      }else{
         $_SESSION['TOASTR_MSG']=array(
            'type'=>'error',
            'body'=>'No Application Found.',
            'title'=>'Error',
         );
      }
   }
//Bkash Payment started
// $sql="select * from `applicants` where id='$application_id'";
// $row=mysqli_fetch_assoc(mysqli_query($con,$sql));
// if(isset($_GET['status'])){
//    $status=get_safe_value($_GET['status']);
//    if($status=='cancel'){
//       $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "Payment has been cancelled by User.", "error")</script>';
//    }elseif($status=='failure'){
//       $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "OTP not valid", "error")</script>';
//    }elseif($status=='success'){
//       $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($_GET['status']).'", "Payment completed", "success")</script>';
//    }elseif(isset($_GET['statusMessage'])){
//       $status="Duplicate transection";
//       $statusMessage=" Please try after sometime.";
//       $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($status).'", "'.$statusMessage.'", "error")</script>';
//    }elseif(isset($_GET['statusMessage']) && isset($_GET['status'])){
//       $status=$_GET['status'];
//       $statusMessage=$_GET['statusMessage'];
//       $_SESSION['PAYMENT_ERROR']='<script>swal("'.ucfirst($status).'", "'.$statusMessage.'", "error")</script>';
//    }
//    // redirect("payments");
// }

$total_amount=round(intval(FORM_AMOUNT)*(1+SERVICE_CHARGE),2);
if(isset($_POST['bkash'])){
   $amount=round($total_amount,2);
   $token=timeWiseTokenGeneartion();
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
         $application_id=ucfirst(get_safe_value($_POST['application_id']));
         if(mysqli_num_rows(mysqli_query($con,"select id from bkash_online_payment where user_id='$application_id' and status='pending'"))>0){
            $sql="update bkash_online_payment set tran_id='$merchantInvoiceNumber', bkash_payment_id='$paymentID', amount='$amount', added_on='$paymentCreateTime' where user_id='$application_id'";
               if(mysqli_query($con,$sql)){
               // echo $createPayment['bkashURL'];
               redirect($createPayment['bkashURL']);
               die;
            }else{
               $msg="Something Went Wrong";
            }
         }else{
            $sql="INSERT INTO `bkash_online_payment` ( `tran_id`,`user_id`, `bkash_payment_id`,`customerMsisdn`,`trxID`,`amount`,`statusMessage`, `added_on`,`updated_on`,`status`) VALUES 
                        ('$merchantInvoiceNumber', '$application_id','$paymentID',  '',   '', '$amount', '','$paymentCreateTime', '', 'pending')";
               if(mysqli_query($con,$sql)){
               redirect($createPayment['bkashURL']);
               die;
            }else{
               $msg="Something Went Wrong";
            }
         }
      }
   }else{
      $msg="Something Went Wrong";
   }
}
?>
<div class="breadcrumb-bar">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-12">
            <div class="breadcrumb-list">
               <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index">Home</a></li>
                     <li class="breadcrumb-item" aria-current="page">Pay Now</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>
</div>
<section class="course-content checkout-widget">
   <div class="container">
      <div class="col-md-12">
         <div class="settings-widget">
            <div class="settings-inner-blk p-0">
               <div class="sell-course-head comman-space">
                  <h3 align="center">Payment Complesion</h3>
                  <form method="POST" enctype="multipart/form-data">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label class="form-control-label">Application ID</label>
                              <input pattern="[a-zA-Z0-9-]+"  type="text" value="<?php echo $application_id?>" name="application_id" id="application_id"  class="form-control" placeholder="Enter your Application ID" required>
                           </div>
                        </div>
                        <div class="col-md-12">
                           <div class="settings-widget">
                              <div class="settings-inner-blk p-0">
                                 <div class="sell-course-head comman-space row">
                                       <div class="payment-btn" style="text-align:center;">
                                          <button name="submit" id="submit" class="btn btn-primary" type="submit">Search Application</button>
                                       </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php if(isset($search)){?>
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
                              <td>Application Id: </td>
                              <td><?php echo $application_id?></td>
                           </tr>
                           <tr>
                              <td>Email: </td>
                              <td><?php echo $email?></td>
                           </tr>
                           <tr>
                              <td>Phone Number: </td>
                              <td><?php echo $phoneNumber?></td>
                           </tr>
                        </tbody>
                     </table>
                  </form>
                  <?php }?>
                  <?php 
                  if(isset($search)){
                     if(isset($_POST['submit'])){
                        $application_id=ucfirst(get_safe_value($_POST['application_id']));
                        $sql="select bkash_online_payment.* from bkash_online_payment where user_id='$application_id'";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                           $payment_row=mysqli_fetch_assoc($res);
                           if($payment_row['status']=="Completed"){?>
                              <div class="payment-btn mt-3" style="text-align:center;">
                                 <button class="btn btn-success">Payment Completed </button>
                              </div>
                              <table id="preview" class="mt-3">
                                    <tr>
                                       <td>Receipt: </td>
                                       <td><a href="pdfreports/invoice?invoice_id=<?php echo $payment_row['tran_id']?>" class="invoice-no">#<?php echo $payment_row['tran_id']?></a></td>
                                    </tr>
                                    <tr>
                                       <td>Amount: </td>
                                       <td> <?php echo $payment_row['amount']?></td>
                                    </tr>
                                    <tr>
                                       <td>Paid On: </td>
                                       <td><?php echo date("d M Y h:i A",$payment_row['updated_on'])?></td>
                                    </tr>
                                    <tr>
                                       <td>Application Id: </td>
                                       <td><?php echo $application_id?></td>
                                    </tr>
                                    <tr>
                                       <td>Tran ID: </td>
                                       <td><?php echo $payment_row['trxID']?></td>
                                    </tr>
                                    <tr>
                                       <td>Status: </td>
                                       <?php 
                                       $status=$payment_row['status'];
                                       if($status=='Completed'){?>
                                          <td><button class="btn status-success"><?php echo $status?></button></td>
                                       <?php }else{?>
                                          <td><button class="btn status-warning"><?php echo ucfirst($status)?></button></td>
                                       <?php }?>
                                    </tr>
                                 </tbody>
                              </table>
                           <?php }else{?>
                              <div class="payment-btn" style="text-align:center;">
                                 <form  method="post">
                                    <div class="go-dashboard text-center">
                                          <div class="alert alert-warning mt-3">Without payment the application will not submitted properly.</div>
                                          <br>
                                          <input type="hidden" name="application_id" value="<?php echo $application_id?>">
                                          <button type="submit" name="bkash" class="btn btn-success">
                                             Pay & Submit Your application
                                             <img src="./assets/img/bkash.png" weight="100px" height="70px" alt="Bkash Payment" >
                                          </button>
                                    </div>
                                 </form>
                              </div>
                           <?php }
                        }else{//num row >0?>
                           <div class="payment-btn" style="text-align:center;">
                              <form  method="post">
                                 <div class="go-dashboard text-center">
                                       <div class="alert alert-warning mt-3">Without payment the application will not submitted properly.</div>
                                       <br>
                                       <input type="hidden" name="application_id" value="<?php echo $application_id?>">
                                       <button type="submit" name="bkash" class="btn btn-success">
                                          Pay & Submit Your application
                                          <img src="./assets/img/bkash.png" weight="100px" height="70px" alt="Bkash Payment" >
                                       </button>
                                 </div>
                              </form>
                           </div>
                        <?php }
                     }//submit ended
                  }//search ended
                  ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php include("footer.php");?>
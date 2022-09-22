<?php include("header.php"); 
   $val_id="";
   $amount="";
   $card_type="";
   $tran_date="";
   $card_issuer="";
   $card_no="";
   $error="";
   $msg="";
   $status="pending";
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}
$user_id=$_SESSION['APPLICANT_ID'];
$sql="select * from `applicants` where id='".$_SESSION['APPLICANT_ID']."'";
$total_amount=122;
$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
if (isset($_POST['sslcommerz'])){
   $ch = curl_init();
   $tran_id="admission_".uniqid();
   curl_setopt($ch, CURLOPT_URL, 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, "store_id=".STORE_ID."
                                          &store_passwd=".STORE_PASSWORD."
                                          &total_amount=".urlencode(round($total_amount,2))."&currency=BDT
                                          &tran_id=".$tran_id."
                                          &success_url=".FRONT_SITE_PATH."/success"."
                                          &fail_url=".FRONT_SITE_PATH."/failure"."
                                          &cancel_url=".FRONT_SITE_PATH."/cancel"."
                                          &cus_name=".$row['first_name']." ".$row['last_name']."
                                          &cus_email=".$row['email']."
                                          &cus_add1=".$row['presentAddress']."
                                          &cus_city=".$row['permanentAddress']."
                                          &cus_country=Bangladesh
                                          &ship_country=Bangladesh
                                          &shipping_method=air
                                          &ship_add1=".$row['presentAddress']."
                                          &product_name=Admission Payment
                                          &product_category=Admission payment
                                          &cus_phone=".$row['phoneNumber']."
                                          &ship_name=".$row['first_name']."
                                          &ship_add1 =".$row['presentAddress']."
                                          &ship_city=".$row['permanentAddress']."
                                          &ship_state=".$row['permanentAddress']."
                                          &ship_postcode=1000
                                          &product_profile=c"
                                 );
   $headers = array();
   $headers[] = 'Content-Type: application/x-www-form-urlencoded';
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   $result = curl_exec($ch);
   if (curl_errno($ch)) {
      $msg='Error: No internet connection'; // . curl_error($ch); 
   }
   curl_close($ch);
   $result=json_decode($result,TRUE);
   // pr($result);
   if(isset($result['status']) && $result['status']=="SUCCESS"){
      $id=uniqid("admission_");
      $time=time();
      $sql="INSERT INTO `online_payment`(`id`,`tran_id`,`user_id`, `val_id`, `amount`, `card_type`, `tran_date`, `card_issuer`, `card_no`, `error`, `added_on`, `updated_on`, `status`) VALUES 
                                          ('$id','$tran_id','$user_id','$val_id','$amount','$card_type','$tran_date','$card_issuer','$card_no','$error','$time','','$status')";
      mysqli_query($con,$sql);
      redirect($result['GatewayPageURL']);
   }else{
      $msg="Something Went wrong. Please your internet connection";
   }
}
if (isset($_POST['bkash'])){
}
?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>
                     <div class="col-xl-9 col-md-8">
                     <div class="settings-widget profile-details">
                        <div class="settings-inner-blk p-0">
                           <div class="profile-heading row">
                              <div class="row">
                                 <h3>Payments</h3>
                              </div>
                              <!-- <p>You can find all of your order Invoices.</p> -->
                           </div>
                           <div class="comman-space pb-0">
                              <form  method="post">
                              <div class="go-dashboard text-center ">
                                    <?php echo $msg?>
                                    <br>
                                    <button type="submit" name="bkash" class="btn btn-primary">Pay Using Bkash</button>
                                    <button type="submit" name="sslcommerz" class="btn btn-primary">Pay Using Online Payment</button>
                              </div>
                              </form>
                              <div class="settings-invoice-blk table-responsive comman-space pb-0">
                                 <h4 align="center">Payments</h4>
                                 <table class="table table-borderless mb-0">
                                    <thead>
                                       <tr>
                                          <th>order id</th>
                                          <th>date</th>
                                          <th>amount</th>
                                          <th>status</th>
                                          <!-- <th>&nbsp;</th> -->
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       $sql="select * from online_payment where user_id='".$_SESSION['APPLICANT_ID']."' and status!='pending'";
                                       $res=mysqli_query($con,$sql);
                                       if(mysqli_num_rows($res)>0){
                                       $i=1;
                                       while($row=mysqli_fetch_assoc($res)){
                                       ?>
                                       <tr>
                                          <td><a href="#" class="invoice-no">#<?php echo $row['id']?></a></td>
                                          <td><?php echo $row['tran_date']?></td>
                                          <td><?php echo $row['amount']?></td>
                                          <?php if($row['status']=='VALID'){?>
                                             <td><span class="badge status-completed">Completed</span></td>
                                          <?php }else{?>
                                             <td><span class="badge status-due">Due</span></td>
                                          <?php }?>
                                          <!-- <td><a href="javascript:;" class="btn-style"><i class="feather-download"></i></a></td> -->
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
<?php include("footer.php")?>

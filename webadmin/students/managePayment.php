<?php 
include("header.php");
   $name="";
   $roll="";
   $batch="";
   $_GET['id']=1;
   if(isset($_GET['id']) && $_GET['id']!=""){
       $id=get_safe_value($_GET['id']);
       $res=mysqli_query($con,"select * from users where id='$id'");
       if(mysqli_num_rows($res)>0){
           $row=mysqli_fetch_assoc($res);
           $name=$row['name'];
           $roll=$row['roll'];
           $batch=$row['batch'];
       }else{
            $_SESSION['PERMISSION_ERROR']=1;
            redirect('index.php');
       }
   }
   if(isset($_POST['submit']) ){
      $user_id=get_safe_value($_GET['id']);
      $month_id=$_POST['month_id'];
      $total_amount=$_POST['total_amount'];
      $time=time();
      $payment_type='sslcommerz';
      $tran_id="becHall_".uniqid();

       $sql="INSERT INTO `payments` ( `user_id`,`payment_type`,`tran_id`,`total_amount`, `updated_at`, `created_at`,`paid_status`, `status`) VALUES 
                                    ( '$user_id', '$payment_type','$tran_id','$total_amount', '', '$time', '0', '1')";
       mysqli_query($con,$sql);
       $payment_id=mysqli_insert_id($con);
       if(isset($_POST['monthly_amount'])){
         $monthly_amount_count=count($_POST['monthly_amount']);
         for($i=0;$i<=($monthly_amount_count)-1;$i++){
            $month_id_counter=count($_POST['month_id']);
             for($i=0;$i<=($month_id_counter)-1;$i++){
                  $monthly_amount=get_safe_value($_POST['monthly_amount'][$i]);
                  $month_id=get_safe_value($_POST['month_id'][$i]);
                  $swl="INSERT INTO `monthly_payment_details` ( `user_id`, `payment_id`, `month_id`, `monthly_amount`,  `status`) VALUES 
                                                                 ('$user_id', '$payment_id', '$month_id', '$monthly_amount', '1')";
                  mysqli_query($con,$swl);
                  mysqli_query($con,"update monthly_bill set paid_status='1' where user_id='$user_id' and month_id='$month_id' ");
             }
         }
       }
       $_SESSION['INSERT']=1;
       if(isset($_POST['fee_amount'])){
         for($i=0;$i<=count($_POST['fee_amount'])-1;$i++){
            for($i=0;$i<=count($_POST['fee_id'])-1;$i++){
                  $fee_id=get_safe_value($_POST['fee_id'][$i]);
                  $fee_amount=get_safe_value($_POST['fee_amount'][$i]);;
                  $swl="INSERT INTO `fee_details` ( `user_id`, `payment_id`, `fee_id`, `fee_amount`,  `status`) VALUES 
                                                                  ('$user_id','$payment_id', '$fee_id', '$fee_amount', '1')";
                  mysqli_query($con,$swl);
            }
         }
      }
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "store_id=thedh60a231886b190
                                             &store_passwd=thedh60a231886b190@ssl
                                             &total_amount=".urlencode(round($total_amount,2))."&currency=BDT
                                             &tran_id=".$tran_id."
                                             &success_url=".FRONT_SITE_PATH."webadmin/students/success.php"."
                                             &fail_url=".FRONT_SITE_PATH."webadmin/students/failure.php"."
                                             &cancel_url=".FRONT_SITE_PATH."webadmin/students/cancel.php"."
                                             &cus_name=Customer Name
                                             &cus_email=cust@yahoo.com
                                             &cus_add1=Dhaka
                                             &cus_city=Dhaka
                                             &cus_country=Bangladesh
                                             &ship_country=Bangladesh
                                             &shipping_method=air
                                             &ship_add1=lal
                                             &product_name=dj
                                             &product_category=d
                                             &cus_phone=01711111111
                                             &ship_name=Customer Name
                                             &ship_add1 =Dhaka
                                             &ship_city=Dhaka
                                             &ship_state=Dhaka
                                             &ship_postcode=1000
                                             &product_profile=c"
                                    );
      $headers = array();
      $headers[] = 'Content-Type: application/x-www-form-urlencoded';
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      $result = curl_exec($ch);
      if (curl_errno($ch)) {
         echo 'Error:' . curl_error($ch);
      }
      curl_close($ch);
      $result=json_decode($result,TRUE);
      if(isset($result['status']) && $result['status']=="SUCCESS"){
         redirect($result['GatewayPageURL']);
      } 
      // redirect("./invoice.php?id=".$payment_id);
      die;
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
                           <th scope="col">#</th>
                           <th scope="col">Month</th>
                           <th scope="col">Due</th>
                           <th scope="col">Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $sqll="select * from monthly_bill where user_id='$id' and paid_status='0'";
                           $ress=mysqli_query($con,$sqll);
                           if(mysqli_num_rows($ress)>0){
                              $i=1;
                              while($roww=mysqli_fetch_assoc($ress)){
                           ?>
                        <tr>
                           <td>
                              <input type="checkbox" value="<?php echo $i?>"  id="checkbox_<?php echo $i?>"  onchange="get_total(this.value)">
                           </td>
                           <td><?php echo  date("F - y",strtotime($roww['year']."-".$roww['month_id']))  ?></td>
                           <td >
                              <input disabled type="hidden" id="month_<?php echo $i?>" name="month_id[]" value="<?php echo  $roww['month_id']?>" class="amount"> 
                              <input disabled type="hidden" name="monthly_amount[]" value="<?php echo  $roww['amount']?>" class="amount" id="amount_<?php echo $i?>"> 
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
                           <th scope="col">#</th>
                           <th scope="col">Month</th>
                           <th scope="col">Due</th>
                           <th scope="col">Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $sqll="select * from fees";
                           $ress=mysqli_query($con,$sqll);
                           if(mysqli_num_rows($ress)>0){
                              $i=1;
                              while($roww=mysqli_fetch_assoc($ress)){
                           ?>
                        <tr>
                           <td>
                              <input type="checkbox" value="<?php echo $i?>"  id="fee_checkbox_<?php echo $i?>"  onchange="get_fee_total(this.value)">
                           </td>
                           <td>
                              <?php echo $roww['name']?>
                           </td>
                           <td >
                              <input disabled type="hidden" name="fee_id[]" value="<?php echo  $roww['id']?>" class="amount" id="fee_id_<?php echo $i?>"> 
                              <input disabled type="hidden" name="fee_amount[]" value="<?php echo  $roww['amount']?>" class="amount" id="fee_amount_<?php echo $i?>"> 
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
                  <div class="row">
                     <div class="col-xl-4 col-lg-8 col-4 form-group">
                     </div>
                     <div class="col-xl-4 col-lg-4 col-4 form-group">
                        <label>Total amount</label>
                        <input id="grant_total" style="background-color: #64ed4b;text-align:center;font-size:20px;" value="0" class="form-control" readonly name="total_amount">
                     </div>
                  </div>
                  <hr>
                  <div class="modal-box">
                     <!-- Button trigger modal -->
                     <div class="row">
                        <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
                        <div class="col-xl-2 col-lg-2 col-12 form-group">
                           <button type="submit" id="submit" disabled class="modal-trigger" data-toggle="modal"
                              data-target="#standard-modal" name="submit">
                           Payment online
                           </button>
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
      if(document.getElementById("checkbox_"+id).checked==true){
         jQuery('#amount_'+id).addClass('active_amount');
         jQuery( '#amount_'+id ).prop( "disabled", false );
         jQuery( '#submit' ).prop( "disabled", false );
         jQuery( '#month_'+id ).prop( "disabled", false );
      }else if(document.getElementById("checkbox_"+id).checked==false){
         jQuery('#amount_'+id).removeClass('active_amount');
         jQuery( '#amount_'+id ).prop( "disabled", true );
         jQuery( '#month_'+id ).prop( "disabled", true );
      }
   	var total = 0;
   	var amount = document.getElementsByClassName("active_amount");
   	for (let i = 0; i < amount.length; i++) {
   		var total = total + parseFloat(amount[i].value);
   	}
      console.log(total);
      var grant_total=total;
      document.getElementById("grant_total").value = grant_total;
   }
   function get_fee_total(id){
      if(document.getElementById("fee_checkbox_"+id).checked==true){
         jQuery('#fee_amount_'+id).addClass('active_amount');
         jQuery( '#fee_amount_'+id ).prop( "disabled", false );
         jQuery( '#fee_id_'+id ).prop( "disabled", false );
         jQuery( '#submit' ).prop( "disabled", false );
         jQuery( '#month_'+id ).prop( "disabled", false );
      }else if(document.getElementById("fee_checkbox_"+id).checked==false){
         jQuery('#fee_amount_'+id).removeClass('active_amount');
         jQuery( '#fee_amount_'+id ).prop( "disabled", true );
         jQuery( '#fee_id_'+id ).prop( "disabled", true );
         jQuery( '#month_'+id ).prop( "disabled", true );
      }
   	var total = 0;
   	var amount = document.getElementsByClassName("active_amount");
   	for (let i = 0; i < amount.length; i++) {
   		var total = total + parseFloat(amount[i].value);
   	}
      console.log(total);
      var grant_total=total;
      document.getElementById("grant_total").value = grant_total.toFixed(2);
   }
</script>
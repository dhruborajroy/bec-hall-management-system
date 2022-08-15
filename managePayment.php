<?php 
   include("header.php");
   $name="";
   $roll="";
   $batch="";
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
       $monthly_amount=$_POST['monthly_amount'];
       $time=time();
      //  pr($_POST);
       $sql="INSERT INTO `payments` ( `user_id`,`total_amount`, `updated_at`, `created_at`,`paid_status`, `status`) VALUES ( '$user_id', '$total_amount', '', '$time', '1', '1')";
       mysqli_query($con,$sql);
       $payment_id=mysqli_insert_id($con);
       for($i=0;$i<=count($_POST['monthly_amount'])-1;$i++){
           for($i=0;$i<=count($_POST['month_id'])-1;$i++){
               $swl="INSERT INTO `monthly_payment_details` ( `user_id`, `payment_id`, `month_id`, `monthly_amount`,  `status`) VALUES 
                                                               ('$user_id', '$payment_id', '$month_id[$i]', '$monthly_amount[$i]', '1')";
               mysqli_query($con,$swl);
               mysqli_query($con,"update monthly_bill set paid_status='1' where user_id='$user_id' and month_id='$month_id[$i]' ");
           }
       }
       $_SESSION['INSERT']=1;
      //  for($i=0;$i<=count($_POST['fees_amount'])-1;$i++){
      //      for($i=0;$i<=count($_POST['fees_id'])-1;$i++){
      //          $swl="INSERT INTO `fee_details` ( `user_id`, `payment_id`, `fee_id`, `fee_amount`,  `status`) VALUES 
      //                                                          ('$user_id','$payment_id', '$fee_id[$i]', '$fee_amount[$i]', '1')";
      //          mysqli_query($con,$swl);
      //      }
      //  }
      redirect("./invoice.php?id=".$payment_id);
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
      <form method="POST" actsion="requests/submit.php">
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
                  <!-- <table class="table table-hover" style="width: 100%;">
                     <thead class="thead-dark">
                        <tr>
                           <th scope="col">#</th>
                           <th scope="col">Month</th>
                           <th scope="col">Due</th>
                           <th scope="col">Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <th scope="row"><input type="checkbox" value="1"  id="other_checkbox_1" name="amount" onchange="other_fees_total(this.value)"></th>
                           <td>February - 22</td>
                           <td>
                              <input type="hidden" value="2230" class="amount" id="other_amount_1"> 
                              2230
                           </td>
                           <td>
                              <button  type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-red">Unpaid</button>
                           </td>
                        </tr>-->
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
                           Payment
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
   function other_fees_total(id){
      var monthly_total=parseFloat(document.getElementById("grant_total").value);
      if(document.getElementById("other_checkbox_"+id).checked==true){
         jQuery('#other_amount_'+id).addClass('active_amount');
         jQuery( '#other_amount_'+id ).prop( "disabled", false );
      }else if(document.getElementById("other_checkbox_"+id).checked==false){
         jQuery('#other_amount_'+id).removeClass('active_amount');
         jQuery( '#other_amount_'+id ).prop( "disabled", true );
      }
      var total = 0;
      var amount = document.getElementsByClassName("active_amount");
      for (let i = 0; i < amount.length; i++) {
         var total = total + parseFloat(amount[i].value);
      }
      document.getElementById("grant_total").value = parseparseFloatInt(total)+parseFloat(monthly_total);
   }
</script>
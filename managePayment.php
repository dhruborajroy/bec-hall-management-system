<?php include("header.php");
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
           redirect('index.php');
       }
   }
   
   if(isset($_POST['submit']) ){
       $user_id=get_safe_value($_GET['id']);
       $month_id=$_POST['month_id'];
       $month_amount=$_POST['month_amount'];
       $fee_id=$_POST['fees_id'];
       $total_amount=$_POST['total_amount'];
       $fee_amount=$_POST['fees_amount'];
       $time=time();
       pr($_POST);
       $sql="INSERT INTO `payments` ( `user_id`,`total_amount`, `updated_at`, `created_at`, `status`) VALUES ( '$user_id', '$total_amount', '$time', '$time', '1')";
       mysqli_query($con,$sql);
       $payment_id=mysqli_insert_id($con);
       for($i=0;$i<=count($_POST['month_amount'])-1;$i++){
           for($i=0;$i<=count($_POST['month_id'])-1;$i++){
               $swl="INSERT INTO `monthly_payment_details` ( `user_id`, `payment_id`, `month_id`, `monthly_amount`,  `status`) VALUES 
                                                               ('$user_id', '$payment_id', '$month_id[$i]', '$month_amount[$i]', '1')";
               mysqli_query($con,$swl);
           }
       }
       for($i=0;$i<=count($_POST['fees_amount'])-1;$i++){
           for($i=0;$i<=count($_POST['fees_id'])-1;$i++){
               $swl="INSERT INTO `fee_details` ( `user_id`, `payment_id`, `fee_id`, `fee_amount`,  `status`) VALUES 
                                                               ('$user_id','$payment_id', '$fee_id[$i]', '$fee_amount[$i]', '1')";
               mysqli_query($con,$swl);
           }
       }
    //    redirect("./invoice.php?id=".$payment_id);
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
            <!-- <div class="item-img">
               <img src="img/figure/teacher.jpg" alt="teacher" height="150px" width="150px">
               </div> -->
            <div class="item-content">
               <div class="info-table ">
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
                        <!-- <tr>
                           <th scope="row"><input type="checkbox"></th>
                           <td>January - 22</td>
                           <td>2230</td>
                            <td>
                                <button type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-dark-pastel-green">Paid</button>
                            </td>
                        </tr> -->
                        <tr>
                           <th scope="row"><input type="checkbox" value="2230"  id="checkbox" name="amount" onchange="get_total(this.value)"></th>
                           <td>February - 22</td>
                           <td >
                           <input type="hidden" value="2230" class="amount"> 
                           2230
                           </td>
                           
                            <td>
                                <button  type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-red">Unpaid</button>
                            </td>
                        </tr>
                     </tbody>
                  </table>
                  <hr>
                  <!-- <div class="col-xl-12 col-lg-12 col-12 ">
                     <center>
                         <p class="header_payment">Monthly Payment</p>
                     </center>
                     </div>
                     <div class="col-xl-12 col-lg-12 col-12 form-group row" id="wrap">
                     <div class="col-xl-4 col-lg-4 col-12 form-group" id="my_box">
                         <label>Month *</label>
                         <select class="form-control disable_class" id="select_box_1"
                             onchange="getMonthlyData('1')" name="month_id[]" required>
                             <option value="">Please Select Month *</option>
                             <?php
                        $month_id=0;
                        $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
                        while($row=mysqli_fetch_assoc($res)){
                            if($row['id']==$month_id){
                                echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                            }else{
                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                            }                                                        
                        }
                        ?>
                         </select>
                     </div>
                     <div class="col-xl-4 col-lg-4 col-12 form-group">
                         <label>Due amount</label>
                         <input type="number" value="0" name="month_amount[]" id="number_1"
                             class="form-control amount" readonly>
                     </div>
                     <input type="hidden" id="box_count" value="1">
                     <input type="hidden" id="total_amount" value="0">
                     <input style="margin-top: 20px;margin-bottom: 15px;" type="button" id="submit"
                         value="Add More" class="btn-fill-lg font-normal text-light gradient-pastel-green"
                         onclick="add_more()">
                     </div>
                     <hr>
                     <div class="col-xl-12 col-lg-12 col-12 ">
                     <center>
                         <p class="header_payment">Fees</p>
                     </center>
                     </div>
                     <div class="col-xl-12 col-lg-12 col-12 form-group row" id="wrap_fees">
                     <div class="col-xl-4 col-lg-4 col-12 form-group" id="my_box_fees">
                         <input type="hidden" id="fees_count" value="1">
                         <label>Fees *</label>
                         <select class="form-control form-control-lg" id="fee_select_box_1"
                             onchange="getFeesData(1)" name="fees_id[]" required>
                             <option selected readonly>Please Select fees *</option>
                             <?php
                        $fees_id=0;
                        $res=mysqli_query($con,"SELECT * FROM `fees` where status='1'");
                        while($row=mysqli_fetch_assoc($res)){
                            if($row['id']==$fees_id){
                                echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                            }else{
                                echo "<option value=".$row['id'].">".$row['name']."</option>";
                            }                                                        
                        }
                        ?>
                         </select>
                     </div>
                     <input type="hidden" id="fee_total" value="0">
                     <input type="hidden" id="fees_box_count" value="1">
                     <div class="col-xl-4 col-lg-4 col-12 form-group">
                         <label>Due amount</label>
                         <input type="number" value="0" class="form-control fee_amount" id="fee_number_1"
                             name="fees_amount[]" readonly>
                     </div>
                     <input type="hidden" id="box_count" value="1">
                     <input style="margin-top: 20px;margin-bottom: 15px;" type="button" id="fees_submit"
                         value="Add More" class="btn-fill-lg font-normal text-light gradient-pastel-green"
                         onclick="add_more_fees()">
                     </div> -->
                  <div class="row">
                     <div class="col-xl-4 col-lg-8 col-4 form-group">
                     </div>
                     <div class="col-xl-4 col-lg-4 col-4 form-group">
                        <label>Total amount</label>
                        <input id="grant_total" value="0" class="form-control" readonly name="total_amount">
                     </div>
                  </div>
                  <hr>
                  <div class="modal-box">
                     <!-- Button trigger modal -->
                     <div class="row">
                        <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
                        <div class="col-xl-2 col-lg-2 col-12 form-group">
                           <button type="submit" class="modal-trigger" data-toggle="modal"
                              data-target="#standard-modal" name="submit">
                           Payment
                           </button>
                        </div>
                        <!-- <div class="col-xl-2 col-lg-2 col-12 form-group">
                           <button type="button" class="btn-fill-lmd radius-4 text-light bg-violet-blue"
                              onclick="reload()">
                           Reload
                           </button>
                        </div> -->
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
$(document).ready(function() {
});
   // Finding Total Amount
function get_total(value) {
    $(document).on('change', '#checkbox', function() {
        if(this.checked) {
            // alert(value);
            var total = 0;
            var amount = document.getElementsByClassName("amount");
            for (let i = 0; i < amount.length; i++) {
            	var total = total + parseInt(amount[i].value);
            }
        }
    });
    // alert(value);
	// var total = 0;
	// var amount = document.getElementsByClassName("amount");
	// for (let i = 0; i < amount.length; i++) {
	// 	var total = total + parseInt(amount[i].value);
	// }
    // console.log(total); 
    // var grant_total=total;
	// document.getElementById("grant_total").value = grant_total;
}

</script>
<script>
    /*
   // jQuery("#submit").hide();
   
   // Retriving  Fee Amount
   function getFeesData(id) {
       var fee_id = jQuery("#fee_select_box_" + id).val();
       jQuery.ajax({
           type: "post",
           url: "./requests/getMonthlyFee.php",
           data: "fee_id=" + fee_id,
           success: function(result) {
               result = result.trim()
               // alert(result);
               jQuery("#fee_number_" + id).val(result);
               get_total();
               // jQuery("#submit").show();
           }
       });
   }
   // Retriving Monthly Due Amount
   function getMonthlyData(id) {
       var month_id = jQuery("#select_box_" + id).val();
       jQuery.ajax({
           type: "post",
           url: "./requests/getMonthlyFee.php",
           data: "month_id=" + month_id,
           success: function(result) {
               // alert(result);
               result = result.trim()
               jQuery("#number_" + id).val(result);
               get_total();
               // jQuery("#submit").show();
           }
       });
   }
   // Adding more Monthly data
   function add_more() {
       var option_value = '<?php
      $month_id=0;
      $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
      while($row=mysqli_fetch_assoc($res)){
          if($row['id']==$month_id){
              echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
          }else{
              echo "<option value=".$row['id'].">".$row['name']."</option>";
          }                                                        
      }
      ?>';
       var box_count = jQuery("#box_count").val();
       // jQuery("#submit").hide();
       box_count++;
       // alert(box_count);
       jQuery("#box_count").val(box_count);
       jQuery("#wrap").append('<div class="col-xl-12 col-lg-12 col-12 form-group row" id="box_loop_' + box_count +
           '"><div class="col-xl-6 col-lg-6 col-12 form-group"><label>Month *</label><select required  name="month_id[]" id="select_box_' +
           box_count + '" onchange="getMonthlyData(' + box_count +
           ')" class="form-control disable_class"><option value="" selected readonly>Please Select Month *</option>' +
           option_value +
           '</select></div><div class="col-xl-4 col-lg-4 col-12 form-group"><label>Due amount</label><input type="number"  name="month_amount[]" id="number_' +
           box_count +
           '" value="0" class="form-control amount" readonly></div><div class="col-xl-2 col-lg-2 col-2 form-group"><input style="margin-top: 20px;" type="button" name="submit" id="submit" value="Remove" class="btn-fill-lmd text-light radius-4 bg-gradient-gplus"  onclick=remove_more("' +
           box_count + '")></div></div>'
       );
       get_total();
   }
   
   
   function remove_more(box_count) {
       jQuery("#box_loop_" + box_count).remove();
       var box_count = jQuery("#box_count").val();
       box_count--;
       jQuery("#box_count").val(box_count);
       get_total();
   }
   
   // Fee Datas
   
   
   function add_more_fees() {
       var option_value = '<?php
      $fees_id=0;
      $res=mysqli_query($con,"SELECT * FROM `fees` where status='1'");
      while($row=mysqli_fetch_assoc($res)){
          if($row['id']==$fees_id){
              echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
          }else{
              echo "<option value=".$row['id'].">".$row['name']."</option>";
          }                                                        
      }
      ?>';
       var fees_count = jQuery("#fees_count").val();
       fees_count++;
       jQuery("#fees_count").val(fees_count);
       jQuery("#wrap_fees").append('<div class="col-xl-12 col-lg-12 col-12 form-group row" id="fees_loop_' +
           fees_count +
           '"><div class="col-xl-6 col-lg-6 col-12 form-group"><label>Month *</label><select required name="fees_id[]" class="form-control" id="fee_select_box_' +
           fees_count + '" onclick="getFeesData(' + fees_count +
           ')"><option value="" selected readonly>Please Select Month *</option>' + option_value +
           '</select></div><div class="col-xl-4 col-lg-4 col-12 form-group"><label>Due amount</label><input name="fees_amount[]" type="number" value="0" id="fee_number_' +
           fees_count +
           '" class="form-control fee_amount" readonly></div><div class="col-xl-2 col-lg-2 col-2 form-group"><input style="margin-top: 20px;" type="button" name="submit" id="submit" value="Remove" class="btn-fill-lmd text-light radius-4 bg-gradient-gplus" onclick=remove_more_fees("' +
           fees_count + '")></div></div>'
       );
       get_total();
   }
   
   
   function remove_more_fees(fees_count) {
       jQuery("#fees_loop_" + fees_count).remove();
       var fees_count = jQuery("#fees_count").val();
       fees_count--;
       jQuery("#fees_count").val(fees_count);
   }
   
   
   // Finding Total Amount
//    function get_total() {
//        var total = 0;
//        var amount = document.getElementsByClassName("amount");
//        for (let i = 0; i < amount.length; i++) {
//            var total = total + parseInt(amount[i].value);
//        }
//        var fee_total = $("#fee_total").val();
//        var fee_amount = document.getElementsByClassName("fee_amount");
//        for (let i = 0; i < fee_amount.length; i++) {
//            var fee_total = parseInt(fee_total) + parseInt(fee_amount[i].value);
//        }
//        var grant_total = total + fee_total;
//        document.getElementById("grant_total").value = grant_total;
//    }
   
   // Reloading The page to start from the begineeing
   function reload() {
       location.reload();
   }
   */
</script>
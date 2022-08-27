<?php 
   include("header.php");
   $sql="select `role` from `users` where id='1'";
   $res=mysqli_query($con,$sql);
   $row=mysqli_fetch_assoc($res);
   if($row['role']!=2){
      $_SESSION['PERMISSION_ERROR']=true;
      redirect("index.php");
   }
   $roll="";
   $date="";
   $month="";
   $year="";
   if(isset($_POST['date'])){
      $date_time=get_safe_value($_POST['date']);
      $date_time=date_create_from_format("d/m/Y",$date_time);
      $date=date_format($date_time,"d");
      $month=date_format($date_time,"m");
      $year=date_format($date_time,"Y");
   }
   if(isset($_POST['submit']) ){
      $date_time=get_safe_value($_POST['date']);
      $date_time=date_create_from_format("d/m/Y",$date_time);
      $date=date_format($date_time,"d");
      $month=date_format($date_time,"m");
      $year=date_format($date_time,"Y");
      $time=time();
      $meal_sql="select `status` from `meal_table` where date_id='$date' and month_id='$month' and year='$year'";
      $meal_res=mysqli_query($con,$meal_sql);
      if(mysqli_num_rows($meal_res)>0){
         for($i=0;$i<=count($_POST['roll'])-1;$i++){
            for($i=0;$i<=count($_POST['meal_value'])-1;$i++){
               $meal_value= get_safe_value($_POST['meal_value'][$i]);
               $roll= get_safe_value($_POST['roll'][$i]);
               $meal_sql="select `status` from `meal_table` where date_id='$date' and month_id='$month' and year='$year' and roll='$roll'";
               $meal_res=mysqli_query($con,$meal_sql);
               if(mysqli_num_rows($meal_res)>0){
                  $swl="UPDATE `meal_table` SET `meal_value` = '$meal_value' WHERE `meal_table`.`roll` = '$roll' and date_id='$date' and month_id='$month' and year='$year'";
                  mysqli_query($con,$swl);
               }else{
                  $swl="INSERT INTO `meal_table` ( `roll`, `meal_value`, `date_id`, `month_id`, `year`,  `added_on`,`updated_on`, `status`) VALUES 
                                                      ( '$roll', '$meal_value', '$date', '$month','$year','$time','$time', '1')";
                  mysqli_query($con,$swl);
               }
            }
         }
         $_SESSION['UPDATE']=1;
      }else{
         for($i=0;$i<=count($_POST['roll'])-1;$i++){
            for($i=0;$i<=count($_POST['meal_value'])-1;$i++){
               $meal_value= get_safe_value($_POST['meal_value'][$i]);
               $roll= get_safe_value($_POST['roll'][$i]);
               $swl="INSERT INTO `meal_table` (   `roll`, `meal_value`, `date_id`, `month_id`, `year`,  `added_on`,`updated_on`, `status`) VALUES 
                                             ( '$roll', '$meal_value', '$date', '$month','$year','$time','$time', '1')";
               mysqli_query($con,$swl);
            }
         }
         $_SESSION['INSERT']=1;
      }
      // echo $swl;
       redirect('mealCheck.php');
   }
   
   
   ?>
<div class="dashboard-content-one">
<!-- Breadcubs Area Start Here -->
<div class="breadcrumbs-area">
   <h3>Students</h3>
   <ul>
      <li>
         <a href="index.php">Home</a>
      </li>
      <li>All Students</li>
   </ul>
</div>
<!-- Breadcubs Area End Here -->
<!-- Student Table Area Start Here -->
<div class="card height-auto">
   <div class="card-body">
      <div class="heading-layout1">
         <div class="item-title">
            <h3>Meal Data</h3>
         </div>
         <form action="./pdfreports/meal_status.php">
            <div class="row">
               <select name="month" class="select2">
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
               </select>
               <select name="year" class="select2">
                  <option value="2022">2022</option>
               </select>
               <input type="submit" value="Generate report">
            </div>
         </form>
      </div>
      <form method="post">
         <div class="row gutters-8">
            <?php 
               $sql="select * from users where meal_request_pending='1'";
               $res=mysqli_query($con,$sql);
               if(mysqli_num_rows($res)>0){?>
            You have to approve or reject all meal on off requests
            <?php }else{ 
                  if ($date!=="" && $month!=="") {?>
               <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                  <input type="text" onkeyup="myFunction()" placeholder="Search by Roll ..." class="form-control"
                     id="myInput">
               </div>
               <?php }?>
               <div class="col-xl-3 col-lg-6 col-12 form-group">
                  <input autocomplete="off" required type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker"
                     data-position='bottom right' name="date" value="<?php if($date!=""){echo $date.'/'.$month.'/'.$year;}?>">
               </div>
               <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                  <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Search</button>
               </div>
               <!-- <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                  <button onclick="reload()" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reload</button>
                  </div> -->
            </div>
            <div class="table-responsive">
               <?php
                  if ($date!=="" && $month!=="") {?>
               <table class="table display data-table text-nowrap">
                  <thead>
                     <tr>
                        <th>Roll</th>
                        <th>Name</th>
                        <th>Batch</th>
                        <th>Meal Status</th>
                        <th>Dept.</th>
                        <th><input type="number" id="number_value" min="0" onkeyup="checkAll()"></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody id="myTable">
                     <?php
                        $sql="select * from users where meal_status='1' order by id desc";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                     <tr>
                        <td><?php echo $row['roll']?></td>
                        <input type="hidden" name="roll[]" value="<?php echo $row['roll']?>">
                        <td><?php echo $row['name']?></td>
                        <td><?php echo $row['batch']?> batch</td>
                        <td>
                           <?php 
                              if($row['meal_status']=='1'){?>
                           <button type="button" class="btn-fill-md text-light bg-dark-pastel-green">On</button>                        
                           <?php }else if($row['meal_status']=='0'){?>
                           <button type="button" class="btn-fill-md radius-4 text-light bg-orange-red">Off</button>                        
                           <?php }else{
                              echo "Dining off";
                              }?>
                        </td>
                        <td>CE</td>
                        <td><input type="number" name="meal_value[]" class="number" value="<?php
                           $meal_sql="select * from `meal_table` where date_id='$date' and month_id='$month' and year='$year' and `meal_table`.roll=".$row['roll'];
                           $meal_res=mysqli_query($con,$meal_sql);
                           if(mysqli_num_rows($meal_res)>0){
                              $meal_row=mysqli_fetch_assoc($meal_res);
                              echo $meal_row['meal_value'];
                           };
                           ?>" required></td>
                     </tr>
                     <?php 
                        $i++;
                        } } else { ?>
                     <tr>
                        <td colspan="5">No data found</td>
                     </tr>
                     <?php } ?>
                  </tbody>
               </table>
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
                              Do you want to save the meal table?
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="footer-btn bg-dark-low"
                                 data-dismiss="modal">Cancel</button>
                              <button type="submit" name="submit" class="footer-btn bg-linkedin">Save</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } ?>
            <?php }?>
            <div class="row">
               <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
      </form>
      </div>
      </div>
   </div>
</div>
<!-- Student Table Area End Here -->
<?php include("footer.php")?>
<script>
   function checkAll() {
       var number = document.getElementsByClassName("number");
       var number_value = document.getElementById("number_value").value;
       for (let i = 0; i < number.length; i++) {
           number[i].value = number_value;
       }
   }
   function reload(){
      window.location.href="#";
   }
</script>
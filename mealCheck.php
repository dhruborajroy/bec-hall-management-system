<?php include("header.php");
   $roll="";
   $date="";
   $month="";
   $year="";
   if(isset($_GET['date'])){
       $date=get_safe_value($_GET['date']);
       $month=get_safe_value($_GET['month']);
       $year=get_safe_value($_GET['year']);
   }
   if(isset($_POST['submit']) ){
       $date=get_safe_value($_GET['date']);
       $month=get_safe_value($_GET['month']);
       $year=get_safe_value($_GET['year']);
       $time=time();
       $meal_sql="select `status` from `meal_table` where date_id='$date' and month_id='$month' and year='$year'";
       $meal_res=mysqli_query($con,$meal_sql);
       if(mysqli_num_rows($meal_res)>0){
           for($i=0;$i<=count($_POST['roll'])-1;$i++){
               for($i=0;$i<=count($_POST['meal_value'])-1;$i++){
                  $meal_value= get_safe_value($_POST['meal_value'][$i]);
                  $roll= get_safe_value($_POST['roll'][$i]);
                  $swl="UPDATE `meal_table` SET `meal_value` = '$meal_value' WHERE `meal_table`.`roll` = '$roll' and date_id='$date' and month_id='$month' and year='$year'";
                  mysqli_query($con,$swl);
               }
           }
       }else{
           for($i=0;$i<=count($_POST['roll'])-1;$i++){
               for($i=0;$i<=count($_POST['meal_value'])-1;$i++){
                  $meal_value= get_safe_value($_POST['meal_value'][$i]);
                  $roll= get_safe_value($_POST['roll'][$i]);
                  $roll= $_POST['roll'];
                  $swl="INSERT INTO `meal_table` ( `roll`, `meal_value`, `date_id`, `month_id`, `year`,  `added_on`,`updated_on`, `status`) VALUES 
                                                ( '$roll', '$meal_value', '$date', '$month','$year','$time','$time', '1')";
                  mysqli_query($con,$swl);
               }
           }
       }
       redirect('mealStatus.php');
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
         <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
               aria-expanded="false">...</a>
            <div class="dropdown-menu dropdown-menu-right">
               <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
               <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
               <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
            </div>
         </div>
      </div>
      <form>
         <div class="row gutters-8">
            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
               <label>Roll</label>
               <input type="text" onkeyup="myFunction()" placeholder="Search by Roll ..." class="form-control"
                  id="myInput">
            </div>
            <input type="hidden" name="year" id="" value="2022">
            <div class="col-xl-3 col-lg-6 col-12 form-group">
               <label>Select Month</label>
               <select class="form-control select2" name="month">
                  <option readonly>Select Month</option>
                  <?php
                     $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
                     while($row=mysqli_fetch_assoc($res)){
                         if($row['id']==$month){
                             echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                         }else{
                             echo "<option value=".$row['id'].">".$row['name']."</option>";
                         }                                                        
                     }
                     ?>
               </select>
            </div>
            <!-- <div class="col-xl-3 col-lg-6 col-12 form-group">
               <label>Date Of Birth *</label>
               <input type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker"
                   data-position='bottom right'>
               <i class="far fa-calendar-alt"></i>
               </div> -->
            <!-- <div class="col-xl-3 col-lg-6 col-12 form-group">
               <label>Select date</label>
               <select class="form-control select2" name="date">
                  <option readonly>Select Month</option>
                  <?php
                  //  $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
                  //  $last_date=cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
                  //  for($i=1;$i<=$month;$i++){
                  //      if($i==$month){
                  //          echo "<option selected='selected' value=".$i.">".$i."</option>";
                  //      }else{
                  //          echo "<option value=".$i.">".$i."</option>";
                  //      }                                                       
                  //  }
                   ?>
               </select>
               </div> -->
            <div class="col-xl-3 col-lg-6 col-12 form-group">
               <label>Select date</label>
               <select class="form-control select2" name="date">
                  <option readonly>Select date</option>
                  <?php 
                     $res=mysqli_query($con,"SELECT * FROM `date` where status='1'");
                     while($row=mysqli_fetch_assoc($res)){
                         if($row['id']==$date){
                             echo "<option selected='selected' value=".$row['id'].">".$row['date']."</option>";
                         }else{
                             echo "<option value=".$row['id'].">".$row['date']."</option>";
                         }                                                        
                     }
                     ?>
               </select>
            </div>
            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
               <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
            </div>
         </div>
      </form>
      <form class="mg-b-20" method="post">
         <div class="table-responsive">
            <?php if ($date!=="" && $month!=="") {?>
            <table class="table display data-table text-nowrap">
               <thead>
                  <tr>
                     <th>Roll</th>
                     <th>Name</th>
                     <th>Batch</th>
                     <th>Meal Status</th>
                     <th>Guest Meal</th>
                     <th>Dept.</th>
                     <th><input type="number" id="number_value" min="0" onkeyup="checkAll()"></th>
                     <th></th>
                  </tr>
               </thead>
               <tbody id="myTable">
                  <?php
                     $sql="select * from users order by id desc";
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
                     <td>
                        <button type="button" class="btn-fill-md text-dodger-blue border-dodger-blue">2</button>                        
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
   function checkAll() {
       var number = document.getElementsByClassName("number");
       var number_value = document.getElementById("number_value").value;
       for (let i = 0; i < number.length; i++) {
           number[i].value = number_value;
       }
   }
</script>
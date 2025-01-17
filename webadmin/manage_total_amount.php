<?php include("header.php");
$month="";
$year="";
if(isset($_GET['month']) && isset($_GET['year'])) {
    $display_none="";
	$month=get_safe_value($_GET['month']);
	$year=get_safe_value($_GET['year']);
}
if(isset($_POST['submit']) ){
   // pr($_POST);
   // die;
      $time=time();
      for($i=0;$i<=count($_POST['user_id'])-1;$i++){
         for($i=0;$i<=count($_POST['total_amount'])-1;$i++){
            $total_amount= get_safe_value($_POST['total_amount'][$i]);
            $user_id= get_safe_value($_POST['user_id'][$i]);
            $meal_sql="select * from `monthly_bill` where `monthly_bill`.`user_id` = '$user_id' and  month_id='$month' and year='$year'";
            $meal_res=mysqli_query($con,$meal_sql);
            if(mysqli_num_rows($meal_res)>0){
               $swl="UPDATE `monthly_bill` SET `amount` = '$total_amount' WHERE `monthly_bill`.`user_id` = '$user_id' and month_id='$month' and year='$year'";
               if(mysqli_query($con,$swl)){
                  //  redirect('mealCheck.php');
                  // echo $swl;
               }
            }else{
               $swwl="INSERT INTO `monthly_bill` ( `amount`, `user_id`, `month_id`,`year`, `paid_status`, `added_on`, `updated_on`, `status`) VALUES
               ('$total_amount', '$user_id', '$month','$year', '0', '$time', '', '1')";
               if(mysqli_query($con,$swwl)){
                  // redirect('mealCheck.php');
                  // echo $swwl;
               }
            }
         }
      }
}
?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Student Meal Chart</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Meal Chart</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row">
        <!-- Student Attendence Search Area Start Here -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <!-- <h3>Student Attendence</h3> -->
                        </div>
                    </div>
                    <form class="new-added-form">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Select Month</label>
                                <select class="form-control select2" name="month">
                                    <?php
                                        for ($month_id = 1; $month_id <= 12; $month_id++) {
                                          $monthName = date("F", mktime(0, 0, 0, $month_id, 1)); // Get the month name
                                          $formattedMonthId = sprintf("%02d", $month_id);
                                          $currentMonth = date("m"); // Get the current month number
                                          // Check if the current month matches the looped month
                                          $selected = ($formattedMonthId == $currentMonth) ? "selected" : "";
                                          echo "<option value=\"$formattedMonthId\" $selected>$monthName</option>";
                                       }  
                                        ?>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Select year</label>
                                <select class="select2" name="year" required>
                                    <?php
                                    $currentYear = date("Y"); // Get the current year
                                    for ($option_year = $currentYear; $option_year >= 2022; $option_year--) {
                                        echo "<option value=\"$option_year\">$option_year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit"
                                    class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Search</button>
                                <!-- <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Student Attendence Search Area End Here -->
        <!-- Student Attendence Area Start Here -->

      <form method="post">
        <?php if($month!="" && $year!=""){?>
            <div class="col-12 <?php echo $display_none?>">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Amount </h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                           <table class="table display data-table text-nowrap">
                              <thead>
                                 <tr>
                                    <th>Roll</th>
                                    <th>Name</th>
                                    <th>Batch</th>
                                    <th>Dept.</th>
                                    <th></th>
                                    <th></th>
                                 </tr>
                              </thead>
                              <tbody id="myTable">
                                 <?php
                                    $sql="select * from users where status='1' order by id desc";
                                    $res=mysqli_query($con,$sql);
                                    if(mysqli_num_rows($res)>0){
                                    $i=1;
                                    while($row=mysqli_fetch_assoc($res)){
                                    ?>
                                 <tr>
                                    <td><?php echo $row['roll']?></td>
                                    <input type="hidden" name="roll[]" value="<?php echo $row['roll']?>">
                                    <input type="hidden" name="user_id[]" value="<?php echo $row['id']?>">
                                    <td><?php echo $row['name']?></td>
                                    <td><?php echo $row['batch']?> batch</td>
                                    <td>CE</td>
                                    <td><input type="number" name="total_amount[]" class="number" value="<?php
                                       $meal_sql="select * from `monthly_bill` where month_id='$month' and year='$year' and `monthly_bill`.user_id=".$row['id'];
                                       $meal_res=mysqli_query($con,$meal_sql);
                                       if(mysqli_num_rows($meal_res)>0){
                                          $meal_row=mysqli_fetch_assoc($meal_res);
                                          if($meal_row['amount']!=''){
                                             $amount=floatval($meal_row['amount']);
                                          }else{
                                             $amount=0;
                                          }
                                          echo $amount;
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
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        <?php }?>
    </div>
    <!-- Student Attendence Area End Here -->
    <?php include("footer.php")?>
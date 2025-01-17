<?php 
   include("header.php");
   $sql="select `role` from `users` where id='1'";
   $res=mysqli_query($con,$sql);
   $row=mysqli_fetch_assoc($res);
   if($row['role']!=2){
    //   $_SESSION['PERMISSION_ERROR']=true;
    //   redirect("index.php");
    //   die;
   }
   $time=time();
   if(isset($_POST['submit']) ){
        for($i=0;$i<=count($_POST['user_id'])-1;$i++){
            $user_id= get_safe_value($_POST['user_id'][$i]);
            $monthly_amount= get_safe_value($_POST['monthly_amount']);
            $month_id= get_safe_value($_POST['month_id']);
            $year= get_safe_value($_POST['year']);
            $swl="SELECT status from `monthly_fee` WHERE month_id='$month_id' and monthly_fee.user_id='$user_id'";
            $ress=mysqli_query($con,$swl);
            if(mysqli_num_rows($ress)>0){
                $swwl="UPDATE `monthly_fee` SET `amount` = '$monthly_amount' ,`updated_on` = '$time' WHERE `monthly_fee`.`user_id` = '$user_id' and month_id='$month_id' and year='$year'";
                mysqli_query($con,$swwl);
            }else{
                $swwl="INSERT INTO `monthly_fee` ( `amount`, `user_id`, `month_id`,`year`, `paid_status`, `added_on`, `updated_on`, `status`) VALUES
                ('$monthly_amount', '$user_id', '$month_id','$year', '0', '$time', '', '1')";
                mysqli_query($con,$swwl);
            }
        }
        $swwwl="UPDATE `general_informations` SET `fee_added` = '$time'  WHERE `general_informations`.`id` = '1'";
        mysqli_query($con,$swwwl);
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
      <div class="heading-layout1 row">
         <div class="item-title">
            <h3>Meal Data</h3>
         </div>
         <form method="post">
            <div class="row">
               <select name="month_id" class="select2">
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
               <select name="year" class="select2">
                    <?php
                    $currentYear = date("Y"); // Get the current year
                    for ($option_year = $currentYear; $option_year >= 2022; $option_year--) {
                        echo "<option value=\"$option_year\">$option_year</option>";
                    }
                ?>
               </select>
               <input type="submit" value="Generate report">
            </div>
      </div>
         <div class="row gutters-8">
            <div class="table-responsive">
               <table class="table display data-table text-nowrap">
                  <thead>
                     <tr>
                        <th>Roll</th>
                        <th>Name</th>
                        <th>Batch</th>
                        <th>Meal Status</th>
                        <th>Dept.</th>
                        <th><input type="number" name="monthly_amount" id="number_value" min="0" onkeyup="checkAll()"></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody id="myTable">
                     <?php
                        $sql="select * from users where status='1'";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                     <tr>
                        <input type="hidden" name="user_id[]" value="<?php echo $row['id']?>">
                        <!-- <td><input type="number" name="monthly_amount" class="number" required></td> -->
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
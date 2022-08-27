<?php include("header.php");
$month="";
$year="";
if($row['role']!=2){
   $_SESSION['PERMISSION_ERROR']=true;
   redirect("index.php");
}
if(isset($_GET['month']) && isset($_GET['year'])) {
    $display_none="";
	$month=get_safe_value($_GET['month']);
	$year=get_safe_value($_GET['year']);
    $uid=$_SESSION['USER_ID'];
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
                                        $res=mysqli_query($con,"SELECT * FROM `month` where status='1'");
                                        while($row=mysqli_fetch_assoc($res)){
                                            if($row['id']==$month){
                                                echo "<option selected='selected' value=".$row['value'].">".$row['name']."</option>";
                                            }else{
                                                echo "<option value=".$row['value'].">".$row['name']."</option>";
                                            }                                                        
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Select year</label>
                                <select class="select2" name="year" required>
                                    <option value="2022">2022</option>
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
        <?php if($month!="" && $year!=""){?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Meal Chart- <?php echo $monthName = date('F', mktime(0, 0, 0, $month, 10));?> 2022</h3>
                            </div>
                            <div class="dropdown">
                                <a  href="mealStatusPrint.php" role="button">Go to print page</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table bs-table table-striped table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-left">Students</th>
                                        <?php 
                                        $last_date=cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
                                        for ($i=1; $i <= $last_date; $i++) {
                                            $a="";
                                            if($a<10){
                                                $a='0';
                                            } ?>
                                            <th><?php echo $a.$i?></th>
                                        <?php }?>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql="select * from users order by id desc";
                                    $res=mysqli_query($con,$sql);
                                    if(mysqli_num_rows($res)>0){
                                    $i=1;
                                    while($row=mysqli_fetch_assoc($res)){
                                    ?>
                                    <tr>
                                        <td class="text-left"><?php echo $row['name']?></td>
                                        <?php
                                        $total_meal=0;
                                        for ($i=01; $i <= $last_date; $i++) {
                                            $a="";
                                            if($a<10){
                                                $a='0';
                                            }
                                            $meal_sql="select * from `meal_table` where date_id='$a$i' and month_id='$month' and year='$year' and `meal_table`.roll=".$row['roll'];
                                            $meal_res=mysqli_query($con,$meal_sql);
                                            if(mysqli_num_rows($meal_res)>0){
                                                $meal_row=mysqli_fetch_assoc($meal_res);?>
                                                <td class="text-left"><?php 
                                                    echo $meal_value=$meal_row['meal_value'].'</td>';
                                                    $total_meal=intval($total_meal)+intval($meal_value);
                                            }else{
                                                echo '<td class="text-left">-</td>';
                                            }
                                            if($i==$last_date){
                                                echo '<td class="text-left">'.$total_meal.'</td>';
                                            }
                                        }
                                        ?>
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
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
    <!-- Student Attendence Area End Here -->
    <?php include("footer.php")?>
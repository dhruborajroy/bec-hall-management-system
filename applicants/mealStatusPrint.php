<?php 
   session_start();
   session_regenerate_id();
   require('../inc/constant.inc.php');
   require('../inc/connection.inc.php');
   require('../inc/function.inc.php');
   require_once("../inc/smtp/class.phpmailer.php");
//    isAdmin();
    // require('../vendor/autoload.php');
?>

<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BEC HALL | Developed by Dhrubo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="../css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="../css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="../fonts/flaticon.css">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="../css/fullcalendar.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="../css/animate.min.css">
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="../css/select2.min.css">
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="../css/jquery.dataTables.min.css">
    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="../css/datepicker.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="../css/toastr.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <style type="text/css" media="print">
        @media print {
            body * {
                visibility: hidden;
            }
            #attendance_table, #attendance_table * {
                visibility: visible;
            }
            #attendance_table {
                position: absolute;
                left: 0;
                top: 2;
                bottom: 1;
            }
        }
    </style>
</head>

<?php 
$month="";
$year="";
if(isset($_GET['month']) && isset($_GET['year']) && ($_GET['month']>01) && ($_GET['month']<13)) {
    $display_none="";
	$month=get_safe_value($_GET['month']);
	$year=get_safe_value($_GET['year']);
}else{
    // $_SESSION['PERMISSION_ERROR']='1';
    // redirect("index.php");
    // die;
}
?>
<div class="dashboard-content-one ">
    <div class="row">
        <!-- Student Attendence Search Area Start Here -->
        <div class="col-12 d-print-none">
            <div class="card">
                <div class="card-body">
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
                                    <a href="index.php" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Go to home</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Student Attendence Search Area End Here -->
        <!-- Student Attendence Area Start Here -->
        <?php if($month!="" && $year!=""){?>
                <div class="card-body"  id="attendance_table">
                    <div class="heading-layout1 d-flex justify-content-center">
                        <div class="item-title">
                            <h3>Meal Chart- <?php echo $monthName = date('F', mktime(0, 0, 0, $month, 10));?> 2022</h3>
                        </div>
                    </div>
                        <table class="table table-bordered  bg-warning-o-10"  >
                            <thead>
                                <tr>
                                    <th class="text-left">Students</th>
                                    <?php 
                                    $last_date=cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
                                    for ($i=1; $i <= $last_date; $i++) {
                                        $a="";
                                        if($a<$i){
                                            $a='0';
                                        }  ?>
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
                                        if($i<10){
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
        <?php }?>
    </div>
    <?php include("footer.php")?>
    <script>
    </script>
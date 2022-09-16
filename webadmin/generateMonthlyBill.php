<?php 
include('./inc/connection.inc.php');
include('./inc/function.inc.php');
include('./inc/constant.inc.php');
session_start();
$meal_rate=getMealRate(date('m'));
$res=mysqli_query($con,'select * from users');
if(mysqli_num_rows($res)>0){
    while($row=mysqli_fetch_assoc($res)){
        $month_id=date('m');
        $year=date('Y');
        $total_meal=getTotalMeal($month_id,$row['roll']);
        if($total_meal>0){
            $time=time();
            $user_id=$row['id'];
            $swl="SELECT status from `monthly_bill` WHERE month_id='$month_id' AND user_id='$user_id'";
            $ress=mysqli_query($con,$swl);
            $total_amount=round((floatval($meal_rate))*floatval($total_meal),2);
            if(mysqli_num_rows($ress)>0){
                $swwl="UPDATE `monthly_bill` SET `amount` = '$total_amount' ,`updated_on` = '$time' WHERE `monthly_bill`.`user_id` = '$user_id' and month_id='$month_id' and year='$year'";
                mysqli_query($con,$swwl);
            }else{
                $swwl="INSERT INTO `monthly_bill` ( `amount`, `user_id`, `month_id`,`year`, `paid_status`, `added_on`, `updated_on`, `status`) VALUES
                ('$total_amount', '$user_id', '$month_id','$year', '0', '$time', '', '1')";
                mysqli_query($con,$swwl);
            }
            $swwwl="UPDATE `general_informations` SET `last_bill_generated` = '$time'  WHERE `general_informations`.`id` = '1'";
            mysqli_query($con,$swwwl);
        }
        $_SESSION['UPDATE']=1;
    }
    redirect("monthlyPayment.php");
}
?>
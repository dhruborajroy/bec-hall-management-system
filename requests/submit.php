<?php
echo "<pre>";
print_r($_POST);
// die;
$con=mysqli_connect('localhost','root','','bec_hall');
if(isset($_POST['submit']) ){
    $month_id=$_POST['month_id'];
    $month_amount=$_POST['month_amount'];
    $fee_id=$_POST['fees_id'];
    $fee_amount=$_POST['fees_amount'];
    for($i=0;$i<=count($_POST['month_amount'])-1;$i++){
        for($i=0;$i<=count($_POST['month_id'])-1;$i++){
            $swl="INSERT INTO `monthly_payment_details` ( `user_id`, `payment_id`, `month_id`, `monthly_amount`,  `status`) VALUES 
                                                            ('2', '1', '$month_id[$i]', '$month_amount[$i]', '1')";
            mysqli_query($con,$swl);
        }
    }
    for($i=0;$i<=count($_POST['fees_amount'])-1;$i++){
        for($i=0;$i<=count($_POST['fees_id'])-1;$i++){
            $swl="INSERT INTO `fee_details` ( `user_id`, `payment_id`, `fee_id`, `fee_amount`,  `status`) VALUES 
                                                            ('2', '1', '$fee_id[$i]', '$fee_amount[$i]', '1')";
            mysqli_query($con,$swl);
        }
    }
}
<?php
echo "<pre>";
print_r($_POST);
/*
$start=$date

*/
// include('../inc/connection.inc.php');
// include('../inc/function.inc.php');

$con=mysqli_connect('localhost','root','','bec_hall');


$roll="";
$date="";
if(isset($_POST['submit']) ){
    $date=$_POST['date'];
    $time=time();
    // echo count($_POST['roll']);
    for($i=0;$i<=count($_POST['roll'])-1;$i++){
        for($i=0;$i<=count($_POST['meal_value'])-1;$i++){
            $meal_value= $_POST['meal_value'];
            $roll= $_POST['roll'];
            echo $swl="INSERT INTO `meal_table` ( `roll`, `meal_value`, `date`, `added_on`,`updated_on`, `status`) VALUES ( '$roll[$i]', '$meal_value[$i]', '$date', '$time','$time', '1')";
            mysqli_query($con,$swl);
        }
    }
}
// INSERT INTO `meal_table` (`id`, `roll`, `date`, `date`, `status`) VALUES (NULL, '', '', '', '')

?>
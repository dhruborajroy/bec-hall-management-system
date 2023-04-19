<?php 
session_start();
session_regenerate_id();
include('../inc/function.inc.php');
include('../inc/connection.inc.php');
include('../inc/constant.inc.php');
require_once("../inc/smtp/class.phpmailer.php");
$msg="";
// if(isset($_SESSION['ADMIN_LOGIN'])){
//     redirect('index.php');
// }
// if(isset($_POST['submit'])){
   	// $password=get_safe_value($_POST['password']);
   	$sql="SELECT mark.* ,sum(mark) as total, RANK() OVER(ORDER BY sum(mark) DESC,mark desc,id desc) as `rank` FROM mark group by exam_roll";
	$res=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($res)){
        // pr($row);
        $rank=$row['rank'];
        $exam_roll=$row['exam_roll'];
        $rank_sql="update applicants set merit='$rank' where examRoll='$exam_roll'";
        mysqli_query($con,$rank_sql);
    }
// }
?>
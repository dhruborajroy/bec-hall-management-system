<?php 
session_start();
session_regenerate_id();
include("./inc/connection.inc.php");
include("./inc/function.inc.php");
include("./inc/constant.inc.php");
$val_id="";
$tran_id=$_POST['tran_id'];
$amount=$_POST['amount'];
$card_type=$_POST['card_type'];
$tran_date=$_POST['tran_date'];
$card_issuer=$_POST['card_issuer'];
$card_no=$_POST['card_no'];
$error=$_POST['error'];
$status=$_POST['status'];
if(isset($_POST['status'])){
    $sql="INSERT INTO `online_payment`(`tran_id`, `val_id`, `amount`, `card_type`, `tran_date`, `card_issuer`, `card_no`, `error`, `status`) VALUES 
                                            ('$tran_id','$val_id','$amount','$card_type','$tran_date','$card_issuer','$card_no','$error','$status')";   
    if ($status=="FAILED") {
        if(!isset($_SESSION['USER_LOGIN'])){
            $ssqls="select * from applicants where id='$user_id'";
            $resss=mysqli_query($con,$ssqls);
            $rows=mysqli_fetch_assoc($resss);
            $_SESSION['USER_LOGIN']=true;
            $_SESSION['USER_ID']=$rows['id'];
            $_SESSION['USER_ROLL']=$rows['roll'];
            $_SESSION['USER_NAME']=$rows['first_name'];
        }
    }
    mysqli_query($con,$sql);
    prx($_POST);
}
?>
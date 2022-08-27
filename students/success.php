<?php
session_start();
session_regenerate_id();
include("../webadmin/inc/connection.inc.php");
include("../webadmin/inc/function.inc.php");
include("../webadmin/inc/constant.inc.php");
if(!isset($_POST['tran_id'])){
    $_SESSION['PERMISSION_ERROR']='1';
    redirect("index.php");
}else{
    $tran_id=get_safe_value($_POST['tran_id']);
    echo $ssql="select * from online_payment where tran_id='$tran_id'";
    $res=mysqli_query($con,$ssql);
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $user_id=$row['user_id'];
        if(!isset($_SESSION['USER_LOGIN'])){
            $_SESSION['USER_LOGIN']=true;
            $_SESSION['USER_ID']=$row['id'];
            $_SESSION['USER_ROLL']=$row['roll'];
            $_SESSION['USER_NAME']=$row['name'];
        }
        $val_id=$_POST['val_id'];
        $amount=$_POST['amount'];
        $card_type=$_POST['card_type'];
        $tran_date=$_POST['tran_date'];
        $card_issuer=$_POST['card_issuer'];
        $card_no=$_POST['card_no'];
        $error=$_POST['error'];
        $status=$_POST['status'];
        if(isset($_POST['status'])){
            if ($status=="VALID") {
                echo $sql="UPDATE `online_payment` SET `val_id`='$val_id',`amount`='$amount',`card_type`='$card_type',`tran_date`='$tran_date',`card_issuer`='$card_issuer',`card_no`='$card_no',`error`='$error',`status`='$status' WHERE `tran_id`='$tran_id'";
                mysqli_query($con,$sql);
                echo $swl="update `payments` set `paid_status`='1' where `tran_id`='$tran_id'";
                mysqli_query($con,$swl);
                // redirect("../invoice.php?id=".$row['id']);
            }
        }
    }else{
        $_SESSION['PERMISSION_ERROR']='1';
        redirect("index.php");
    }
}
?>
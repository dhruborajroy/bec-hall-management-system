<?php 
include("header.php");
$tran_id=$_POST['tran_id'];
$val_id=$_POST['val_id'];
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
    if ($status=="VALID") {
        $swl="update `payments` set `paid_status`='1' where `tran_id`='$tran_id'";
        mysqli_query($con,$swl);
    }
    mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc(mysqli_query($con,"select id from payments where tran_id='$tran_id'"));
    redirect("../invoice.php?id=".$row['id']);
}
?>
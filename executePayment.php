<?php 
session_start();
session_regenerate_id();
require("./inc/connection.inc.php");
require("./inc/constant.inc.php");
require("./inc/function.inc.php");
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}
$time=time();
if(isset($_GET['paymentID']) && $_GET['paymentID']!="" && isset($_GET['status']) && $_GET['status']!="" ){
    $paymentID=get_safe_value($_GET['paymentID']);
    $status=get_safe_value($_GET['status']);
    if($status=="success"){
        $sql="select id_token from bkash_credentials where id='1' limit 1";
        $res=mysqli_query($con,$sql);
        $row=mysqli_fetch_assoc($res);
        if(mysqli_num_rows(mysqli_query($con,"select * from bkash_online_payment where bkash_payment_id='$paymentID'"))){
            echo $paymentID=$_GET['paymentID'];
            $_SESSION['ERROR']="Payment has been complited earlier.";
            redirect("payments.php");
        }else{
            $execute=executePayment($_GET['paymentID'],$row['id_token']);
            if(isset($execute['statusCode']) && $execute['statusCode']==000){
                $statusMessage=$execute['statusMessage'];
                $paymentID=$execute['paymentID'];
                $payerReference=$execute['payerReference'];
                $customerMsisdn=$execute['customerMsisdn'];
                $trxID=$execute['trxID'];
                $amount=$execute['amount'];
                $transactionStatus=$execute['transactionStatus'];
                $paymentExecuteTime=$execute['paymentExecuteTime'];
                $merchantInvoiceNumber=$execute['merchantInvoiceNumber'];
                $sql="update bkash_online_payment set customerMsisdn='$customerMsisdn', trxID='$trxID', status='$transactionStatus', updated_on='$time' where bkash_payment_id='$paymentID' and tran_id='$merchantInvoiceNumber'";
                $res=mysqli_query($con,$sql);
                // redirect("payments");
            }else{
                $paymentID=$_GET['paymentID'];
                $statusMessage=$execute['statusMessage'];
                $sql="update bkash_online_payment set status='Failed', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
                $res=mysqli_query($con,$sql);
                $statusMessage=$execute['statusMessage'];
                // redirect("payments");
            }
            pr($execute);
        }
    }elseif($status=="cancel"){
                redirect("payments?id=".$_GET['status']);
        // echo '<script>swal("'.$_GET['status'].'", "'.$_GET['status'].'", "error")</script>';
    }else{
        // echo '<script>swal("'.$_GET['status'].'", "'.$_GET['status'].'", "error")</script>';
    }
}
// echo $sql;
?>
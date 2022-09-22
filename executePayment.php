<?php
include("../functions.php");
if(isset($_GET['paymentID']) && $_GET['paymentID']!="" && isset($_GET['status']) && $_GET['status']!="" ){
    $sql="select id_token from bkash_credentials where id='1' limit 1";
    $res=mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($res);
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
        $sql="update online_payment set customerMsisdn='$customerMsisdn', trxID='$trxID' ,transactionStatus='$transactionStatus' where bkash_payment_id='$paymentID' and tran_id='$merchantInvoiceNumber'";
        $res=mysqli_query($con,$sql);
    }else{
        $paymentID=$_GET['paymentID'];
        $statusMessage=$execute['statusMessage'];
        $sql="update online_payment set transactionStatus='Failed', statusMessage='$statusMessage' where bkash_payment_id='$paymentID'";
        $res=mysqli_query($con,$sql);
        $statusMessage=$execute['statusMessage'];
    }
    pr($execute);
}
echo $sql;
?>
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
$statusMessage="";
if(isset($_GET['paymentID']) && $_GET['paymentID']!="" && isset($_GET['status']) && $_GET['status']!="" ){
    $paymentID=get_safe_value($_GET['paymentID']);
    $status=get_safe_value($_GET['status']);
    if($status=="success"){
            $token=timeWiseTokenGeneartion();
            $execute=executePayment($paymentID,$token['id_token']);
            // prx($execute);
            $statusMessage=$execute['statusMessage'];
            if($statusMessage=='Successful'){
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
                    $sql="update bkash_online_payment set customerMsisdn='$customerMsisdn', statusMessage='$statusMessage',trxID='$trxID', status='$transactionStatus', updated_on='$time' where bkash_payment_id='$paymentID' and tran_id='$merchantInvoiceNumber'";
                    if(mysqli_query($con,$sql)){
                        redirect("payments?status=success");
                    }else{
                        echo "Sql error";
                    }
                }else{
                    $paymentID=$_GET['paymentID'];
                    $sql="update bkash_online_payment set status='Failed', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
                    $statusMessage=$execute['statusMessage'];
                    if(mysqli_query($con,$sql)){
                        redirect("payments?statusMessage=".$statusMessage);
                    }
                }
                // pr($execute);
            }elseif(isset($execute['statusCode']) && $execute['statusCode']==2023){
                if($execute['statusCode']==2023){
                    $status="Insufficient Funds";
                    // $statusMessage="Insufficient Funds";
                }
                $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
                if(mysqli_query($con,$sql)){                
                    redirect("payments?status=".$status."&statusMessage=".$execute['statusMessage']);
                }
            }else{
                if($execute['statusCode']==2029){
                    $status="Duplicate";
                }
                $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
                if(mysqli_query($con,$sql)){                
                    redirect("payments?status=".$status."&statusMessage=".$execute['statusMessage']);
                }
            }
    }elseif($status=="cancel"){
        $statusMessage="Payment canceled by user.";
        $sql="update bkash_online_payment set status='".$status."', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
        if(mysqli_query($con,$sql)){
            redirect("payments?status=".$status."&paymentID=".$paymentID);
        }
    }elseif($status=="failure"){
        $statusMessage="OTP was not valid";
        $sql="update bkash_online_payment set status='".$status."', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
        if(mysqli_query($con,$sql)){
            redirect("payments?status=".$status."&paymentID=".$paymentID);
        }
    }
    // else{
    //     $sql="update bkash_online_payment set status='".$status."', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
    //     if(mysqli_query($con,$sql)){
    //         redirect("payments?status=".$status."&paymentID=".$paymentID);
    //     }
    // }
}
// echo $sql;
?>
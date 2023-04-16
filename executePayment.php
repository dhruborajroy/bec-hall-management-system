<?php 
session_start();
// session_regenerate_id();
require("./inc/connection.inc.php");
require("./inc/constant.inc.php");
require("./inc/function.inc.php");
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
                $sql="update applicants,bkash_online_payment set applicants.final_submit='1' , bkash_online_payment.customerMsisdn='$customerMsisdn',  bkash_online_payment.statusMessage='$statusMessage', bkash_online_payment.trxID='$trxID',  bkash_online_payment.status='$transactionStatus',  bkash_online_payment.updated_on='$time' where  bkash_online_payment.bkash_payment_id='$paymentID' and  bkash_online_payment.tran_id='$merchantInvoiceNumber' and applicants.id= bkash_online_payment.user_id";
                // die;
                if(mysqli_query($con,$sql)){
                    redirect("payments_status?bkash_payment_id=".$paymentID."&status=success");
                }else{
                    echo "Sql error";
                }
            }else{
                $paymentID=$_GET['paymentID'];
                $sql="update applicants,bkash_online_payment set applicants.final_submit='1' , bkash_online_payment.status='Failed', bkash_online_payment.statusMessage='$statusMessage', bkash_online_payment.updated_on='$time' where bkash_online_payment.bkash_payment_id='$paymentID' and applicants.id=bkash_online_payment.user_id";
                $statusMessage=$execute['statusMessage'];
                if(mysqli_query($con,$sql)){
                    redirect("payments_status?bkash_payment_id=".$paymentID."&statusMessage=".$statusMessage);
                }
            }
            // pr($execute);
        }elseif(isset($execute['statusCode']) && $execute['statusCode']==2023){
            if($execute['statusCode']==2023){
                $status="Insufficient Funds";
            }
            $sql="update applicants,bkash_online_payment set applicants.final_submit='1' , bkash_online_payment.status='Failed', bkash_online_payment.statusMessage='$statusMessage', bkash_online_payment.updated_on='$time' where bkash_online_payment.bkash_payment_id='$paymentID' and applicants.id=bkash_online_payment.user_id";
            if(mysqli_query($con,$sql)){                
                redirect("payments_status?bkash_payment_id=".$paymentID."&status=".$status."&statusMessage=".$execute['statusMessage']);
            }
        }else{
            if($execute['statusCode']==2029){
                $status="Duplicate";
            }
            $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
            if(mysqli_query($con,$sql)){                
                redirect("payments_status?bkash_payment_id=".$paymentID."&status=".$status."&statusMessage=".$execute['statusMessage']);
            }
        }
    }elseif($status=="cancel"){
        $statusMessage="Payment canceled by user.";
        $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
        if(mysqli_query($con,$sql)){
            redirect("payments_status?bkash_payment_id=".$paymentID."&status=".$status."&paymentID=".$paymentID);
        }
    }elseif($status=="failure"){
        $statusMessage="OTP was not valid";
        $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
        if(mysqli_query($con,$sql)){
            redirect("payments_status?bkash_payment_id=".$paymentID."&status=".$status."&paymentID=".$paymentID);
        }
    }
    // else{
    //     $sql="update bkash_online_payment set status='".$status."', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
    //     if(mysqli_query($con,$sql)){
    //         redirect("payments_status?status=".$status."&paymentID=".$paymentID);
    //     }
    // }
}
// echo $sql;
?>
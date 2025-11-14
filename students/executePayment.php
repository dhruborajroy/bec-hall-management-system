<?php 
// echo "<pre>";

session_start();
// session_regenerate_id();
require('../webadmin/inc/constant.inc.php');
require('../webadmin/inc/connection.inc.php');
require('../webadmin/inc/function.inc.php');
require_once("../webadmin/inc/smtp/class.phpmailer.php");
include("../webadmin/inc/bkashFunctions.inc.php");
isUSER();

if(isset($_GET['paymentID']) && $_GET['paymentID']!="" && isset($_GET['status']) && $_GET['status']!="" ){
    $time=time();
    $statusMessage="";
    $paymentID=get_safe_value($_GET['paymentID']);
    $status=get_safe_value($_GET['status']);
    if($status=="success"){
        $token=timeWiseTokenGeneartion();
        $execute=executePayment($paymentID,$token['id_token']);
        // prx($execute);
        $statusMessage=$execute['statusMessage'];
        //demo
        // $statusMessage="Successful";
        // $execute['statusCode']=000;
        //demo end

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
                $sql="update bkash_online_payment set bkash_online_payment.customerMsisdn='$customerMsisdn',  bkash_online_payment.statusMessage='$statusMessage', bkash_online_payment.trxID='$trxID',  bkash_online_payment.status='$transactionStatus',  bkash_online_payment.updated_on='$time' where  bkash_online_payment.bkash_payment_id='$paymentID' and  bkash_online_payment.tran_id='$merchantInvoiceNumber'";
                // die;



                if(mysqli_query($con,$sql)){
                    $user_id=$_SESSION['USER_ID'];
                    $payment_type = 'bkash';
                    $tran_id = "becHall_" . uniqid();



                    // Updated fixed fees
                    $contingency_fee_per_month = CONTINGENCY_FEE; 
                    $hall_fee_per_month = HALL_FEE; 
                    $electricity_fee_per_month = ELECTRICITY_FEE;
                    //INSERting total amount without bkash fee
                    $total_amount=$amount-intval(BKASH_FEE*$amount);
                    // Insert into payments
                    $sql = "INSERT INTO `payments` (`user_id`,`payment_type`,`tran_id`,`total_amount`,`updated_at`,`created_at`,`paid_status`,`status`) 
                            VALUES ('$user_id', '$payment_type','$tran_id','$total_amount', '', '$time', '1', '1')";
                    mysqli_query($con, $sql);
                    $payment_id = mysqli_insert_id($con);
                        
                    // main monthly bill
                    $month_sql="SELECT month_id from bkash_online_payment WHERE bkash_payment_id='$paymentID' limit 1";
                    $month_row=mysqli_fetch_assoc(mysqli_query($con,$month_sql));
                    $month_id=$month_row['month_id'];
                    $month_fee_sql="SELECT amount FROM `monthly_bill` WHERE month_id='$month_id' and user_id='$user_id' and paid_status='0' limit 1";
                    $month_fee_row=mysqli_fetch_assoc(mysqli_query($con,$month_fee_sql));
                    $month_fee_amount=$month_fee_row['amount'];
                    mysqli_query($con, "INSERT INTO `monthly_payment_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`added_on`,`status`) 
                                        VALUES ('$user_id','$payment_id','$month_id','$month_fee_amount','$time','1')");
        
                    // contingency
                    mysqli_query($con, "INSERT INTO `contingency_fee_details` (`user_id`,`payment_id`,`month_id`,`contingency_amount`,`added_on`,`status`) 
                                        VALUES ('$user_id','$payment_id','$month_id','$contingency_fee_per_month','$time','1')");
        
                    // hall fee
                    mysqli_query($con, "INSERT INTO `monthly_fee_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`fee_type`,`added_on`,`status`) 
                                        VALUES ('$user_id','$payment_id','$month_id','$hall_fee_per_month','hall_fee','$time','1')");
        
                    // electricity fee
                    mysqli_query($con, "INSERT INTO `monthly_fee_details` (`user_id`,`payment_id`,`month_id`,`monthly_amount`,`fee_type`,`added_on`,`status`) 
                                        VALUES ('$user_id','$payment_id','$month_id','$electricity_fee_per_month','electricity_fee','$time','1')");
        
                    // mark as paid
                    mysqli_query($con, "UPDATE monthly_bill SET paid_status='1' WHERE user_id='$user_id' AND month_id='$month_id'");
                
                            
                    // sms section started
                    // After $payment_id is created and details inserted
                    
                    // Fetch student contact and summary for SMS
                    $u = mysqli_fetch_assoc(mysqli_query($con, "SELECT name, phoneNumber FROM users WHERE id='$user_id' LIMIT 1"));
                    
                    $months = [];
                    $mq = mysqli_query($con, "
                        SELECT mo.name AS month_name
                        FROM monthly_payment_details mpd
                        LEFT JOIN month mo ON mo.id = mpd.month_id
                        WHERE mpd.payment_id = '$payment_id'
                        ORDER BY mpd.month_id
                    ");
                    if ($mq && mysqli_num_rows($mq) > 0) {
                        while ($mrow = mysqli_fetch_assoc($mq)) {
                            $months[] = $mrow['month_name'];
                        }
                    }
                    $months_label = !empty($months) ? implode(', ', $months) : 'Selected months';
                    
                    // Optional: compute category totals for quick SMS summary
                    $sum_due = $sum_hall = $sum_elec = $sum_cont = 0.0;
                    
                    // Due
                    $r = mysqli_query($con, "SELECT COALESCE(SUM(monthly_amount),0) s FROM monthly_payment_details WHERE payment_id='$payment_id' AND user_id='$user_id'");
                    if ($r && ($row = mysqli_fetch_assoc($r))) $sum_due = (float)$row['s'];
                    
                    // Hall
                    $r = mysqli_query($con, "SELECT COALESCE(SUM(monthly_amount),0) s FROM monthly_fee_details WHERE payment_id='$payment_id' AND user_id='$user_id' AND fee_type='hall_fee'");
                    if ($r && ($row = mysqli_fetch_assoc($r))) $sum_hall = (float)$row['s'];
                    
                    // Electricity
                    $r = mysqli_query($con, "SELECT COALESCE(SUM(monthly_amount),0) s FROM monthly_fee_details WHERE payment_id='$payment_id' AND user_id='$user_id' AND fee_type='electricity_fee'");
                    if ($r && ($row = mysqli_fetch_assoc($r))) $sum_elec = (float)$row['s'];
                    
                    // Contingency
                    $r = mysqli_query($con, "SELECT COALESCE(SUM(contingency_amount),0) s FROM contingency_fee_details WHERE payment_id='$payment_id' AND user_id='$user_id'");
                    if ($r && ($row = mysqli_fetch_assoc($r))) $sum_cont = (float)$row['s'];
                    
                    // Final paid amount from payments (authoritative)
                    $pay = mysqli_fetch_assoc(mysqli_query($con, "SELECT total_amount, tran_id, created_at FROM payments WHERE id='$payment_id' LIMIT 1"));
                    $paid_total = isset($pay['total_amount']) ? (float)$pay['total_amount'] : ($sum_due + $sum_hall + $sum_elec + $sum_cont);
                    $invoice_no = $payment_id;
                    $tran_id    = $pay['tran_id'] ?? '';
                    $created_on = !empty($pay['created_at']) && is_numeric($pay['created_at']) ? date('d M Y h:i A', (int)$pay['created_at']) : date('d M Y h:i A');
                    
                    // Compose SMS (keep concise)
                    $student_name = $u['name'] ?? 'Student';
                    $mask_name    = defined('HALL_NAME') ? HALL_NAME : 'BEC Hall';
                    
                    // English short
                    echo $sms = "{$student_name}, Invoice #{$invoice_no}, Paid Tk ".number_format($paid_total,2)." for {$months_label}. Monthly Due: ".number_format($sum_due,2).", Hall: ".number_format($sum_hall,2).", Elec: ".number_format($sum_elec,2).", Cont: ".number_format($sum_cont,2).". Trx: {$tran_id}";
                    
                    // Alternative Bangla-friendly version (uncomment to use)
                    // $bn_sms = "{$mask_name}: {$student_name}, ইনভয়েস #{$invoice_no} - মোট ".number_format($paid_total,2)." টাকা পরিশোধিত ({$months_label}). ডিউ ".number_format($sum_due,2).", হল ".number_format($sum_hall,2).", বিদ্যুৎ ".number_format($sum_elec,2).", কনটিনজেন্সি ".number_format($sum_cont,2).". Trx: {$tran_id}";
                    
                    // Choose recipient number: prefer user's phoneNumber; fallback to provided
                    $recipient = !empty($u['phoneNumber']) ? $u['phoneNumber'] : "01705927257";
                    
                    // Send SMS (ensure you loaded bd_bulk_sms_send earlier)
                    $sms_result = send_sms("01705927257",$sms);//$recipient
                    
                    // Optional: log result
                    // mysqli_query($con, sprintf(
                    //    "INSERT INTO sms_logs (user_id, payment_id, phone, message, provider_status, provider_response, created_at) VALUES ('%d','%d','%s','%s','%s','%s','%d')",
                    //    (int)$user_id,
                    //    (int)$payment_id,
                    //    mysqli_real_escape_string($con, $recipient),
                    //    mysqli_real_escape_string($con, $sms),
                    //    mysqli_real_escape_string($con, (string)($sms_result['status'] ?? '')),
                    //    mysqli_real_escape_string($con, (string)($sms_result['response'] ?? '')),
                    //    time()
                    // ));
                    
                    // sms section ended 
                    // redirect("./invoice.php?id=" . md5($payment_id));
                    
                    redirect("managePayment.php?bkash_payment_id=".$paymentID."&status=success");
                }else{
                    echo $sql;
                }
            }else{
                $paymentID=$_GET['paymentID'];
                $sql="update bkash_online_payment set bkash_online_payment.status='Failed', bkash_online_payment.statusMessage='$statusMessage', bkash_online_payment.updated_on='$time' where bkash_online_payment.bkash_payment_id='$paymentID'";
                $statusMessage=$execute['statusMessage'];
                if(mysqli_query($con,$sql)){
                    redirect("managePayment.php?bkash_payment_id=".$paymentID."&statusMessage=".$statusMessage);
                }
            }
            // pr($execute);
        }elseif(isset($execute['statusCode']) && $execute['statusCode']==2023){
            if($execute['statusCode']==2023){
                $status="Insufficient Funds";
            }
            $sql="update bkash_online_payment set bkash_online_payment.status='Failed', bkash_online_payment.statusMessage='$statusMessage', bkash_online_payment.updated_on='$time' where bkash_online_payment.bkash_payment_id='$paymentID'";
            if(mysqli_query($con,$sql)){                
                redirect("managePayment.php?bkash_payment_id=".$paymentID."&status=".$status."&statusMessage=".$execute['statusMessage']);
            }
        }else{
            if($execute['statusCode']==2029){
                $status="Duplicate";
            }
            $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
            if(mysqli_query($con,$sql)){                
                redirect("managePayment.php?bkash_payment_id=".$paymentID."&status=".$status."&statusMessage=".$execute['statusMessage']);
            }
        }
    }elseif($status=="cancel"){
        $statusMessage="Payment canceled by user.";
        $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
        if(mysqli_query($con,$sql)){
            redirect("managePayment.php?bkash_payment_id=".$paymentID."&status=".$status."&paymentID=".$paymentID);
        }
    }elseif($status=="failure"){
        $statusMessage="Someting Went Wrong. Payment Failed.";
        $sql="update bkash_online_payment set status='$status', statusMessage='$statusMessage', updated_on='$time' where bkash_payment_id='$paymentID'";
        if(mysqli_query($con,$sql)){
            redirect("managePayment.php?bkash_payment_id=".$paymentID."&status=".$status."&paymentID=".$paymentID);
        }
    }
    echo $sql;
}
?>
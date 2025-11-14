<?php 
session_start();
// session_regenerate_id();
require('../webadmin/inc/constant.inc.php');
require('../webadmin/inc/connection.inc.php');
require('../webadmin/inc/function.inc.php');
require_once("../webadmin/inc/smtp/class.phpmailer.php");
include("../webadmin/inc/bkashFunctions.inc.php");
isUSER();



// Assume $con, $id (logged-in user id) are defined
$rowBill = null;
$id=$_SESSION['USER_ID'];
// Normalize input month_id as zero-padded string
$month_id = isset($_POST['confirm_month_id']) && $_POST['confirm_month_id'] !== '' ? sprintf('%02d', (int)$_POST['confirm_month_id']) : null;

if ($month_id !== null) {
    // Latest unpaid bill for this user and month, with user details
    $sql = "
      SELECT 
        mb.month_id, mb.year, mb.amount, mb.paid_status,
        u.name, u.roll, u.batch, u.image
      FROM monthly_bill AS mb
      INNER JOIN users AS u ON u.id = mb.user_id
      WHERE mb.user_id = {$id}
        AND mb.month_id = '{$month_id}'
        AND mb.paid_status = '0'
      ORDER BY mb.year DESC, mb.id DESC
      LIMIT 1
    ";

    $bRes = mysqli_query($con, $sql);
    if ($bRes && mysqli_num_rows($bRes) > 0) {
        $rowBill = mysqli_fetch_assoc($bRes);

        // Fill your snapshot variables if needed
        $name  = $rowBill['name'] ?? $name ?? '';
        $roll  = $rowBill['roll'] ?? $roll ?? '';
        $batch = $rowBill['batch'] ?? $batch ?? '';
        $image = $rowBill['image'] ?? '';
    }
}


// Load the selected month’s unpaid bill (if any)
$rowBill = null;
if ($month_id !== null) {
    // Get the latest unpaid bill record for that month for this user
    "SELECT month_id, year, amount FROM monthly_bill WHERE user_id={$id} AND month_id='{$month_id}' AND paid_status='0' ORDER BY year DESC LIMIT 1";
    $bRes = mysqli_query($con, "SELECT month_id, year, amount FROM monthly_bill WHERE user_id={$id} AND month_id='{$month_id}' AND paid_status='0' ORDER BY year DESC LIMIT 1");
    if ($bRes && mysqli_num_rows($bRes) > 0) {
        $rowBill = mysqli_fetch_assoc($bRes);
    }
}

// Derived display values
$HALL = HALL_FEE;
$ELECTRICITY = CONTINGENCY_FEE;
$CONTINGENCY = ELECTRICITY_FEE;

$mn = '';
$monthly_fee = 0.0;
$total = 0.0;

if ($rowBill) {
    $mn = date("F - y", strtotime(($rowBill['year'] ?? date('Y'))."-".($rowBill['month_id'] ?? '01')));
    $monthly_fee = (float)($rowBill['amount'] ?? 0);
    $total = $monthly_fee + $HALL + $ELECTRICITY + $CONTINGENCY;
    if($total>0){
        // echo $total;
        //Bkash Payment started
        $error="";
        $msg="";
        $total_amount=$total;
            
        $token=timeWiseTokenGeneartion();
        // print_r($token);

        // die;
        //Bkash Payment started
        $error="";
        $msg="";
        $createPayment['bkashURL']="http://localhost/bkash/";
        $createPayment['message']="";


        $total_amount=ceil(floatval($total_amount*(1+BKASH_FEE)));

        $token=timeWiseTokenGeneartion();
        $user_data=array(
            'tran_id'=>uniqid(),
            'amount'=>round($total_amount,2),
        );
        if(isset($token['id_token'])){
            $id=uniqid();
            $createPayment=createPayment($token['id_token'],$user_data);
                // print_r($createPayment);
                if(isset($createPayment['statusCode']) && $createPayment['statusCode']==000){
                    // echo "<br>";
                    // echo $createPayment['bkashURL'];
                    if(isset($createPayment['message'])){
                    $msg= $createPayment['message'];
                    }
                    if(isset($createPayment['statusCode']) && $createPayment['statusCode']==000){
                        $statusMessage=$createPayment['statusMessage'];
                        $paymentID=$createPayment['paymentID'];
                        $amount=$createPayment['amount'];
                        $paymentCreateTime=$createPayment['paymentCreateTime'];
                        $merchantInvoiceNumber=$createPayment['merchantInvoiceNumber'];
                        $bkash_charge=intval($amount*BKASH_FEE);
                        // echo "<br>";
                        $sql="INSERT INTO `bkash_online_payment` ( `tran_id`,`user_id`,`month_id`,  `bkash_payment_id`,`customerMsisdn`,`trxID`,`amount`,`bkash_charge`,`statusMessage`, `added_on`,`updated_on`,`status`) VALUES 
                                                ( '$merchantInvoiceNumber', '$id','$month_id','$paymentID',  '',   '', '$amount','$bkash_charge', '','$paymentCreateTime', '', 'pending')";
                        if(mysqli_query($con,$sql)){
                            echo $msg1="Redirecting to Bkash Payment Gateway";
                            redirect($createPayment['bkashURL']);
                            die;
                        }else{
                            // echo $sql;
                            $_SESSION['TOASTR_MSG']=array(
                            'type'=>'error',
                            'body'=>'Something went wrong!',
                            'title'=>'Error',
                            );
                        }
                    }
                }else{
                    $createPayment['statusCode'];
                    $createPayment['statusMessage'];
                }
        }
    }
} else {
    // If no specific month selected or no due found, show a placeholder row
    $mn = 'No due found';
    $monthly_fee = 0.0;
    $total = 0.0;
}
?>

You are redirecting to the bkash payment gateway please wait... <br>
Please Don't close your browser.
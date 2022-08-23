<?php 
include("header.php");
echo "<pre>";
print_r($_POST);
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
        $swl="update payments set paid_status=1 where tran_id='$tran_id'";
        mysqli_query($con,$swl);
    }
    mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc(mysqli_query($con,"select id from payments where tran_id='$tran_id'"));
    redirect("../invoice.php?id=".$row['id']);
}
?>
<!-- [tran_id] => becHall_6303ab7b587aa
    [val_id] => 2208222216320PRVbmNDYGAMNUa
    [amount] => 5870.00
    [card_type] => NAGAD-Nagad
    [store_amount] => 5723.25
    [card_no] => 
    [bank_tran_id] => 2208222216320iyH4oRqHOsHgKW
    [status] => VALID
    [tran_date] => 2022-08-22 22:16:21
    [error] => 
    [currency] => BDT
    [card_issuer] => Nagad
    [card_brand] => MOBILEBANKING
    [card_sub_brand] => Classic
    [card_issuer_country] => Bangladesh
    [card_issuer_country_code] => BD
    [store_id] => thedh60a231886b190
    [verify_sign] => 5a1662cc02aa0ad2c98743690a02db01
    [verify_key] => amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d
    [verify_sign_sha2] => b72ff6b07c4db20c47fd1ca712222efb795c2ffb029dfea2a3db2a5a450b27b5
    [currency_type] => BDT
    [currency_amount] => 5870.00
    [currency_rate] => 1.0000
    [base_fair] => 0.00
    [value_a] => 
    [value_b] => 
    [value_c] => 
    [value_d] => 
    [subscription_id] => 
    [risk_level] => 0
    [risk_title] => Safe -->

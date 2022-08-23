<?php
$tran_id="becHall_".uniqid();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "store_id=thedh60a231886b190
                                        &store_passwd=thedh60a231886b190@ssl
                                        &total_amount=".urlencode(91)."&currency=BDT
                                        &tran_id=".$tran_id."
                                        &success_url=http://localhost/lalc/html/bus/dashboard/success.php
                                        &fail_url=http://localhost/lalc/html/bus/dashboard/fail.php
                                        &cancel_url=http://localhost/lalc/html/bus/dashboard/cancel.php
                                        &cus_name=Customer Name
                                        &cus_email=cust@yahoo.com
                                        &cus_add1=Dhaka
                                        &cus_city=Dhaka
                                        &cus_country=Bangladesh
                                        &ship_country=Bangladesh
                                        &shipping_method=air
                                        &ship_add1=lal
                                        &product_name=dj
                                        &product_category=d
                                        &cus_phone=01711111111
                                        &ship_name=Customer Name
                                        &ship_add1 =Dhaka
                                        &ship_city=Dhaka
                                        &ship_state=Dhaka
                                        &ship_postcode=1000
                                        &product_profile=c"
                                );
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$result=json_decode($result,TRUE);
echo "<pre>";
print_r($result);
<?php


// Bkash Test Constants
define("APP_KEY","4f6o0cjiki2rfm34kfdadl1eqq");
define("APP_SECRET","2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b");
define("USERNAME","sandboxTokenizedUser02");
define("PASSWORD","sandboxTokenizedUser02@12345");
define("BASE_URL",'https://tokenized.sandbox.bka.sh/v1.2.0-beta');
//Bkash live credentials


// Bkash Functions Starts here

/*
"Numbers": {
        "Numbers": " 01770618575", locked
        "Number1": " 01929918378", duplicate
        "Number2": " 01770618576", locked
        "Number3": " 01877722345", Insufficient Balance
        "Number4": " 01619777282", locked
        "Number5": " 01619777283", duplicate
        "Insufficient": "01823074817",
        "Debit Block": "01823074818"
    },
    "otp":"123456",
    "pin":"12121"
*/

function timeWiseTokenGeneartion(){
    global $con;
    $sql="select time from bkash_credentials where id='1' limit 1";
    $res=mysqli_query($con,$sql);
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $time=$row['time'];
        if($time==""){
            $time=0;
        }
        if((time()-$time)>00){
            $time=time();
            $data=grandToken();
            $id_token=$data['id_token'];
            $refresh_token=$data['refresh_token'];
            $sql="update bkash_credentials set id_token='$id_token', refresh_token='$refresh_token',  time='$time'  where id='1'";
            $res=mysqli_query($con,$sql);
        }
        $sql="select * from bkash_credentials where id='1' limit 1";
        $res=mysqli_query($con,$sql);
        $row=mysqli_fetch_assoc($res);
        $data=array(
            'id_token'=>$row['id_token'],
            'refresh_token'=>$row['refresh_token'],
            'time'=>$time,
        );
        return $data;
    }else{
        return "error";
    }
}

function grandToken(){
    $request_data = array(
        'app_key'=>APP_KEY,
        'app_secret'=>APP_SECRET
    );  
    $url = curl_init(BASE_URL.'/tokenized/checkout/token/grant');
    $request_data_json=json_encode($request_data);
    $header = array(
        'Content-Type:application/json',
        'username:'.USERNAME,               
        'password:'.PASSWORD
    );
    curl_setopt($url,CURLOPT_HTTPHEADER, $header);
    curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url,CURLOPT_POSTFIELDS, $request_data_json);
    curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $data=curl_exec($url);
    if (curl_errno($url)) {
        echo 'Error:' . curl_error($url);
    }
    curl_close($url);
    $data=json_decode($data,true);
    // echo "<pre>";
    return $data;
}


function refreshToken($refresh_token){
    $request_data = array(
        'app_key'=>APP_KEY,
        'app_secret'=>APP_SECRET,
        'refresh_token'=>$refresh_token,
    );  
    $url = curl_init(BASE_URL.'/tokenized/checkout/token/refresh');
    $request_data_json = json_encode($request_data);
    $header = array(
        'Content-Type:application/json',
        'username:'.USERNAME,               
        'password:'.PASSWORD
    );
    curl_setopt($url,CURLOPT_HTTPHEADER, $header);
    curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url,CURLOPT_POSTFIELDS, $request_data_json);
    curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $data=curl_exec($url);
    if (curl_errno($url)) {
        echo 'Error:' . curl_error($url);
    }
    curl_close($url);
    $data=json_decode($data,true);
    return $data;
}

function createPayment($id_token,$user_data){
    $callbackURL=trim(FRONT_SITE_PATH.'students/executePayment.php');
    $requestbody = array(
        'mode' => '0011',
        'amount' => $user_data['amount'],
        'currency' => 'BDT',
        'intent' => 'sale',
        'payerReference' => '01929918378',
        'merchantInvoiceNumber' => $user_data['tran_id'],
        'callbackURL' => $callbackURL
    );
    $url = curl_init(BASE_URL.'/tokenized/checkout/create');
    $requestbodyJson = json_encode($requestbody);
    $header = array(
        'Content-Type:application/json',
        'Authorization: ' . $id_token,
        'X-APP-Key:'. APP_KEY
    );
    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $data = curl_exec($url);
    if (curl_errno($url)) {
       $data=  curl_error($url); 
    }
    curl_close($url);
    $_SESSION['CREATE']=$data;
    $data = json_decode($data,true);
    return $data;
}

function executePayment($paymentID,$id_token){
    $post_token = array(
        'paymentID' => $paymentID
    );
    $url = curl_init(BASE_URL.'/tokenized/checkout/execute');       
    $posttoken = json_encode($post_token);
    $header = array(
        'Content-Type:application/json',
        'Authorization:' . $id_token,
        'X-APP-Key:'.APP_KEY
    );
    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $data = curl_exec($url);
    curl_close($url);
    $data = json_decode($data,true);
    return $data;
}
function queryPayment($paymentID,$id_token){
    $requestbody = array(
        'paymentID' => $paymentID
    );
    $requestbodyJson = json_encode($requestbody);
    $url=curl_init(BASE_URL.'/tokenized/checkout/payment/status');
    $header=array(
        'Content-Type:application/json',
        'authorization:'.$id_token,
        'x-app-key:'.APP_KEY
    );    
    curl_setopt($url,CURLOPT_HTTPHEADER, $header);
    curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
    curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
    $data = curl_exec($url);
    $_SESSION['EXECUTE']=$data;
    curl_close($url);
    $data = json_decode($data,true);
    return $data;
}

function refundPayment($id_token,$trxID,$data){
    $callbackURL='http://thewebdivers.com/';
    $requestbody = array(
        'paymentID' => $data['paymentID'],
        'amount'=>$data['amount'],
        'trxID'=>$trxID, //pass tran id
        'sku'=>$data['sku'],
        'reason'=>$data['reason'],
    );
    $requestbodyJson = json_encode($requestbody);
    // die;
    $url = curl_init(BASE_URL.'/tokenized/checkout/payment/refund');
    $header = array(
        'Content-Type:application/json',
        'Authorization: ' . $id_token,
        'X-APP-Key:'.APP_KEY
    );
    // die;
    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $data = curl_exec($url);
    curl_close($url);
    $data = json_decode($data,true);
    return $data;
}

function refundStatus($id_token,$trxID,$data){
    $header = array(
        'Content-Type:application/json',
        'Authorization: ' . $id_token,
        'X-APP-Key:'.APP_KEY
    );
    $requestbody = array(
        'paymentID' => $data['paymentID'],
        'trxID'=>$trxID, //pass tran id
    );
    $requestbodyJson = json_encode($requestbody);
    $url = curl_init(BASE_URL.'/tokenized/checkout/payment/refund');
    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $data = curl_exec($url);
    curl_close($url);
    $data = json_decode($data,true);
    return $data;
}

function searchTransection($tran_id,$id_token){
    $requestbody = array(
        'trxID' => $tran_id
    );
    $requestbodyJson = json_encode($requestbody);
    $url=curl_init(BASE_URL.'/tokenized/checkout/general/searchTransaction');
    $header=array(
        'Content-Type:application/json',
        'authorization:'.$id_token,
        'x-app-key:'.APP_KEY
    );    
    curl_setopt($url,CURLOPT_HTTPHEADER, $header);
    curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
    curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
    $result=curl_exec($url);
    curl_close($url);
    $result = json_decode($result,true);
    return $result;  
}
?>
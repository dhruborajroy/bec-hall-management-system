<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($str){
	global $con;
	$str=mysqli_real_escape_string($con,$str);
	return $str;
}
function redirect($link){
	?>
<script>
window.location.href = '<?php echo $link?>';
</script>
<?php
	die();
}

function send_email($email,$html,$subject,$attachment=""){
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="hackerdhrubo99@gmail.com";
	$mail->Password="dxnhfotcvjcozaex";
    $mail->setFrom('hackerdhrubo99@gmail.com', 'Dhrubo');
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject=$subject;
	if($attachment!=""){
		$mail->addAttachment($attachment);
	}
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		return "done";
	}else{
		return "error";
	}
}
function sendLoginEmail($email){
	$html="";	
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$result=curl_exec($ch);
	$result=json_decode($result,1);
	// echo "<pre>";
	// print_r($result);
	$html="";
	if($result['status']=='success'){
		$html.='New Login information. '.date("F j, Y \a\t h:i:s A").' <br>Country: '.$result["country"].'<br>'.'<b>Ip Address: '.$result["query"].'</b><br> Zip: '.$result["zip"].'<br> City: '.$result["city"].'<br> Isp: '.$result["isp"].'<br> Region Name: '.$result["regionName"].'<br> ';
		include("inc/browserDetection.php");
		$Browser = new foroco\BrowserDetection();
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$result = $Browser->getAll($useragent);
		foreach ($result as $key => $value) {
			$key=str_replace("_", " ", $key);
			$html.=ucfirst($key).'= '.ucfirst($value).'<br> ';
			
		}
	}
	send_email($email,$html,"Login Information ".date('F j, Y \at h:i:s A'));
}
function rand_str(){
	$str=str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz");
	return $str=substr($str,0,15);
	
}

function maskEmail($email, $minLength =1, $maxLength = 10, $mask = "***") {
    $atPos = strrpos($email, "@");
    $name = substr($email, 0, $atPos);
    $len = strlen($name);
    $domain = substr($email, $atPos);

    if (($len / 2) < $maxLength) $maxLength = ($len / 2);

    $shortenedEmail = (($len > $minLength) ? substr($name, 0, $maxLength) : "");
    return  "{$shortenedEmail}{$mask}{$domain}";
}

function get_content($URL){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $URL);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function vailidatePayment($tran_id){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, "https://sandbox.sslcommerz.com/validator/api/merchantTransIDvalidationAPI.php?tran_id='$tran_id'&store_id=".STORE_ID."&store_passwd=".STORE_PASSWORD."&format=json");
	$data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
	curl_close($ch);
	$data=json_decode($data,1);
	return $data;
}

  
function isAdmin(){
	if(!isset($_SESSION['ADMIN_LOGIN'])){
	?>
<script>
window.location.href = './login.php';
</script>
<?php
	}
}
function isUSER(){
	if(!isset($_SESSION['USER_LOGIN'])){
	?>
<script>
window.location.href = './login.php';
</script>
<?php
	}
}
function getUsers(){
	global $con;
	$sql="SELECT count(DISTINCT id) as number FROM users ";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['number'];
	}
} 
function getPayments(){
	global $con;
	$sql="SELECT count(DISTINCT id) as number FROM payment";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['number'];
	}
} 
function getTotalPayments(){
	global $con;
	$sql="SELECT sum(amount) as number FROM payment";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['number'];
	}
} 
function gettotalstudent(){
	global $con;
	$sql="SELECT count(DISTINCT id) as student FROM applicants";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['student'];
	}
}
function send_email_using_tamplate($name,$otp){
	$tamplate= "email.php";
	$file_content=file_get_contents("../email.php");
	$array=array(
		"{YOUR_NAME}"=>$name,
		"{OTP_NUMBER}"=>$otp,
	);
	$keys = array_keys($array);
	$values = array_values($array);
	return str_replace($keys, $values, $file_content);
}

function getBetweenDates($startDate, $endDate){
	$rangArray = [];
	$startDate = strtotime($startDate);
	$endDate = strtotime($endDate);
	for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
											
		$date = date('d', $currentDate);
		$rangArray[] = $date;
	}
	return $rangArray;
}

function get_time_ago($time){
    $time_difference = time() - $time;
    if( $time_difference < 1 ){ 
		return 'less than 1 second ago'; 
	}
    $condition = array( 
				12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second',
    );
    foreach( $condition as $secs => $str ){
        $d = $time_difference / $secs;
        if( $d >= 1 ){
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
        }
    }
}

function getTotalMarks($exam_roll){
	global $con;
	$sql="SELECT SUM(mark) as total_marks FROM mark  where exam_roll='$exam_roll'";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['total_marks'];
	}
}
function getTotalMeal($month_id,$roll=""){
	global $con;
	$additional_sql="";
	if($roll!=""){
		$additional_sql=" and roll='$roll'";
	}
	$sql="SELECT SUM(meal_value) as total_meal FROM meal_table WHERE month_id='$month_id' $additional_sql";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['total_meal'];
	}
}

function getMealRate($month_id){
	$getTotalMeal=getTotalMeal($month_id);
	if($getTotalMeal!=0){
		return floatval(getTotalExpense($month_id)/getTotalMeal($month_id));
	}else{
		return "0";
	}
}

function addOrdinalNumberSuffix($num) {
    if (!in_array(($num % 100),array(11,12,13))){
      switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'<sup>st</sup>';
        case 2:  return $num.'<sup>nd</sup>';
        case 3:  return $num.'<sup>rd</sup>';
      }
    }
    return $num.'<sup>th</sup>';
}

function numberTowords($num){
    $ones = array(
        0 => "ZERO",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN",
        "014" => "FOURTEEN"
    );
    $tens = array(
        0 => "ZERO",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY",
        4 => "FORTY",
        5 => "FIFTY",
        6 => "SIXTY",
        7 => "SEVENTY",
        8 => "EIGHTY",
        9 => "NINETY"
    );
    $hundreds  = array(
        "HUNDRED",
        "THOUSAND",
        "MILLION",
        "BILLION",
        "TRILLION",
        "QUARDRILLION"
    );
    /*limit t quadrillion */
    $num       = number_format($num, 2, ".", ",");
    $num_arr   = explode(".", $num);
    $wholenum  = $num_arr[0];
    $decnum    = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr, 1);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {
        
        while (substr($i, 0, 1) == "0")
            $i = substr($i, 1, 5);
        if ($i < 20) {
            /* echo "getting:".$i; */
            $rettxt .= $ones[$i];
        } elseif ($i < 100) {
            if (substr($i, 0, 1) != "0")
                $rettxt .= $tens[substr($i, 0, 1)];
            if (substr($i, 1, 1) != "0")
                $rettxt .= " " . $ones[substr($i, 1, 1)];
        } else {
            if (substr($i, 0, 1) != "0")
                $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
            if (substr($i, 1, 1) != "0")
                $rettxt .= " " . $tens[substr($i, 1, 1)];
            if (substr($i, 2, 1) != "0")
                $rettxt .= " " . $ones[substr($i, 2, 1)];
        }
        if ($key > 0) {
            $rettxt .= " " . $hundreds[$key] . " ";
        }
    }
    if ($decnum > 0) {
        $rettxt .= " and ";
        if ($decnum < 20) {
            $rettxt .= $ones[$decnum];
        } elseif ($decnum < 100) {
            $rettxt .= $tens[substr($decnum, 0, 1)];
            $rettxt .= " " . $ones[substr($decnum, 1, 1)];
        }
    }
    return $rettxt;
}
function csrf(){
	$csrf_token=md5(uniqid(rand()));
	$_SESSION['csrf_token']=$csrf_token;
	return $_SESSION['csrf_token'];
}
function form_csrf(){
	$csrf_token=csrf();
	$html='<input type="hidden" name="csrf_token" id="csrf_token"
	value="'.$csrf_token.'">';
	return $html;
}

/*
"Numbers": {
        "Numbers": " 01770618575",
        "Number1": " 01929918378",
        "Number2": " 01770618576",
        "Number3": " 01877722345",
        "Number4": " 01619777282",
        "Number5": " 01619777283",
        "Insufficient": "01823074817",
        "Debit Block": "01823074818"
    },
    "otp":"123456",
    "pin":"12121"
*/
// Bkash Functions Starts here
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
        if((time()-$time)>3600){
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
    $callbackURL=FRONT_SITE_PATH.'/executePayment.php';
    $requestbody = array(
        'mode' => '0011',
        'amount' => $user_data['amount'],
        'currency' => 'BDT',
        'intent' => 'sale',
        'payerReference' => '01770618575',
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
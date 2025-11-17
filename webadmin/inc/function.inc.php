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
	$mail->Password="tximmqdsawlljymb";
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
function check_sms($token){
    $url = "https://api.bdbulksms.net/g_api.php?token=$token&balance&expiry&rate&tokensms&totalsms&monthlysms&tokenmonthlysms&json";
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $smsresult = curl_exec($ch);
    //Result
    $smsresult=json_decode($smsresult,1);
    // print_r($smsresult=json_decode($smsresult,1));
    return $smsresult[0]['response'];
    //Error Display
    curl_error($ch);
}

function send_sms($to, string $message): array{
    $token="513900504017582214400b569e316a2c126d7990b1a24eecc435"; //real
    //$token="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; //sandbox
    // Normalize recipients
    if (is_array($to)) {
        $to = implode(',', array_map('trim', $to));
    } else {
        $to = implode(',', array_filter(array_map('trim', explode(',', (string)$to))));
    }

    if ($to === '' || $message === '' || $token === '') {
        return [
            'success'  => false,
            'status'   => null,
            'response' => null,
            'error'    => 'Missing to/message/token'
        ];
    }

    $data = [
        'to'      => $to,
        'message' => $message,
        'token'   => $token,
    ];
    $timeout = 15;
    $verifyTls = true;
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => "https://api.bdbulksms.net/api.php?json",
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => '',
        CURLOPT_CONNECTTIMEOUT => $timeout,
        CURLOPT_TIMEOUT        => $timeout,
        CURLOPT_SSL_VERIFYHOST => $verifyTls ? 2 : 0,
        CURLOPT_SSL_VERIFYPEER => $verifyTls ? 1 : 0,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Accept: application/json',
        ],
    ]);

    $response = curl_exec($ch);
    $error    = curl_error($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'success'  => ($error === '' && $status >= 200 && $status < 300),
        'status'   => $status ?: null,
        'response' => $response ?: null,
        'error'    => $error ?: null,
    ];
}



function getTotalAmount($user_id="",$type='0'){
    global $con;
    $add_sql="";
    if($user_id!==""){
        $add_sql=" user_id='$user_id' AND ";
    }
    $sql = "
        SELECT 
            SUM(amount) AS base_total,
            COUNT(*) AS month_count
        FROM monthly_bill  WHERE $add_sql
         paid_status='$type'
    ";

    $res = mysqli_query($con, $sql);
    $data = mysqli_fetch_assoc($res);
    $base_total = $data['base_total'];      // sum of amount column
    $month_count = $data['month_count'];    // total unpaid months
    // fixed fees
    $contingency = CONTINGENCY_FEE;
    $hall = HALL_FEE;
    $electricity = ELECTRICITY_FEE;
    // calculate total fees
    $total_fees = ($contingency + $hall + $electricity) * $month_count;
    // final total due
    $total_due = $base_total + $total_fees;
    // show in dashboard
    return $total_due;
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

function getTotalPaymentsToday($start="",$end=""){
	global $con;
	$add_sql="";
	if($start!="" && $end!=""){
		$add_sql=" WHERE monthly_payment_details.added_on and fee_details.added_on  between $start and $end";
	}else{
		$start=strtotime("first day of this month 00:00:00");
		$end=strtotime("last day of this month 23:59:59");
		$add_sql=" WHERE monthly_payment_details.added_on and fee_details.added_on  between $start and $end";
	}
	echo $sql="SELECT SUM(monthly_payment_details.monthly_amount + fee_details.fee_amount) AS number FROM monthly_payment_details JOIN fee_details ON fee_details.payment_id = monthly_payment_details.id $add_sql";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  if($row['number']!=""){
		return $row['number'];
	  }else{
		return 0;
	  }
	}
} 

function getTotalFromPaymentDetails($start = null, $end = null) {
    global $con;
    if (!$start || !$end) {
        $start = strtotime("first day of this month 00:00:00");
        $end   = strtotime("last day of this month 23:59:59");
    }
    $start = (int)$start; $end = (int)$end;

    // Sum monthly due
    $due = [];
    $q = "SELECT payment_id, COALESCE(SUM(monthly_amount),0) AS s
          FROM monthly_payment_details
          WHERE added_on BETWEEN {$start} AND {$end}
          GROUP BY payment_id";
    $r = mysqli_query($con, $q);
    while ($r && $row = mysqli_fetch_assoc($r)) $due[(int)$row['payment_id']] = (float)$row['s'];

    // Sum monthly fees (hall, electricity)
    $mfees = [];
    $q = "SELECT payment_id, COALESCE(SUM(monthly_amount),0) AS s
          FROM monthly_fee_details
          WHERE added_on BETWEEN {$start} AND {$end}
          GROUP BY payment_id";
    $r = mysqli_query($con, $q);
    while ($r && $row = mysqli_fetch_assoc($r)) $mfees[(int)$row['payment_id']] = (float)$row['s'];

    // Sum contingency
    $cont = [];
    $q = "SELECT payment_id, COALESCE(SUM(contingency_amount),0) AS s
          FROM contingency_fee_details
          WHERE added_on BETWEEN {$start} AND {$end}
          GROUP BY payment_id";
    $r = mysqli_query($con, $q);
    while ($r && $row = mysqli_fetch_assoc($r)) $cont[(int)$row['payment_id']] = (float)$row['s'];

    // Union payment ids and add components per payment
    $ids = array_unique(array_merge(array_keys($due), array_keys($mfees), array_keys($cont)));
    $total = 0.0;
    foreach ($ids as $pid) {
        $total += ($due[$pid] ?? 0) + ($mfees[$pid] ?? 0) + ($cont[$pid] ?? 0);
    }
    return $total;
}

function gettotalstudent(){
	global $con;
	$sql="SELECT count(DISTINCT id) as student FROM users";
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

function getTotalExpense($month_id){
	global $con;
	$sql="SELECT SUM(amount) as total_expense FROM expense WHERE month='$month_id'";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['total_expense'];
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
?>
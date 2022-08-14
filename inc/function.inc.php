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

function send_email($email,$html,$subject){
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="hackerdhrubo99@gmail.com";
	$mail->Password="ndajzzubicqfbcih";
    $mail->setFrom('hackerdhrubo99@gmail.com', 'Dhrubo');
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject=$subject;
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		//echo "done";
	}else{
		//echo "Error occur";
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
	if($result['status']=='success'){
		$html='New Login information. '.date("F j, Y \a\t h:i:s A").' <br>Country: '.$result["country"].'<br>'.'<b>Ip Address: '.$result["query"].'</b><br> Zip: '.$result["zip"].'<br> City: '.$result["city"].'<br> Isp: '.$result["isp"].'<br> Region Name: '.$result["regionName"];
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
	$sql="SELECT count(DISTINCT id) as student FROM users";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['student'];
	}
}
function getTotalExpense(){
	global $con;
	$sql="SELECT SUM(amount) as total_expense FROM expense WHERE month='".date("m",time())."'";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['total_expense'];
	}
}
function getTotalMeal(){
	global $con;
	$sql="SELECT SUM(meal_value) as total_meal FROM meal_table WHERE month_id='".date("m",time())."'";
	$res=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($res)){
	  return $row['total_meal'];
	}
}

function send_email_using_tamplate($name,$otp){
	$tamplate= "./email.php";
	$file_content=file_get_contents($tamplate);
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
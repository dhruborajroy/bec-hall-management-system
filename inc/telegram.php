<?php
$input=file_get_contents('php://input');
$data=json_decode($input);
$uname=$data->message->from->first_name;
$chat_id=$data->message->chat->id;
$text=$data->message->text;


if($text=='/start'){
	$msg="Welcome $uname. %0APlease enter your roll number";
}else{
    if($text=="200130"){
		$msg="Dear <b>Dhruboraj Roy </b>. Room:  <b>407 </b>, Batch: 04. %0A
		Total Meal On: <b>23</b>, Meal Rate: <b>94</b> %0A 
		Total Bill:  <b>2162 taka  </b>%0A
		%0A
		Your Due: 
		February- <b>2962 Taka  </b>%0A
		March- <b>2262 Taka  </b>";
	}else{
		$msg="This is a demo bot. Please Enter 200130 as your roll number";
	}
}
$url="https://api.telegram.org/bot5316674209:AAHOJ7x4EY3dusCF7uT4MIhV-md0S3luxfU/sendMessage?text=$msg&chat_id=$chat_id&parse_mode=html";
file_get_contents($url);
?>
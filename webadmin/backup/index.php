<?php
include_once('Mysqldump/Mysqldump.php');
include('smtp/PHPMailerAutoload.php');
$dump = new Ifsnop\Mysqldump\Mysqldump('mysql:host=localhost;dbname=puja', 'root', '');
$f=date('d-m-Y');
$dump->start("sql_dump/$f.sql");

$mail=new PHPMailer(true);
$mail->isSMTP();
$mail->Host="smtp.gmail.com";
$mail->Port=587;
$mail->SMTPSecure="tls";
$mail->SMTPAuth=true;
$mail->Username="hackerdhrubo99@gmail.com";
$mail->Password="ndajzzubicqfbcih";
// $mail->SetFrom("EMAIL");
$mail->addAddress('dhruborajroy3@gmail.com');
$mail->IsHTML(true);
$mail->Subject="Website Backup ".$f;
$mail->Body="Website Backup";
$mail->AddAttachment("sql_dump/$f.sql");
$mail->SMTPOptions=array('ssl'=>array(
	'verify_peer'=>false,
	'verify_peer_name'=>false,
	'allow_self_signed'=>false
));
if($mail->send()){
	//echo "Please check your email id for password";
}else{
	//echo "Error occur";
}
?>
<?php
define('NAME','Get Admitted Online');
define('TAGLINE','Get Admitted Online');
define('EMAIL','contact@thewebdivers.com');
define('FRONT_SITE_PATH','http://localhost/admission/');
define('STORE_ID',"thewe630883975551e");
define('STORE_PASSWORD',"thewe630883975551e@ssl");
define('STUDENT_IMAGE',FRONT_SITE_PATH."media/users/");
define('UPLOAD_APPLICANT_IMAGE',$_SERVER['DOCUMENT_ROOT']."/admission/media/users/");
define('UPLOAD_STUDENT_IMAGE',$_SERVER['DOCUMENT_ROOT']."/admission/media/users/");
// Bkash Test Constants
define("APP_KEY","4f6o0cjiki2rfm34kfdadl1eqq");
define("APP_SECRET","2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b");
define("USERNAME","sandboxTokenizedUser02");
define("PASSWORD","sandboxTokenizedUser02@12345");
define("BASE_URL",'https://tokenized.sandbox.bka.sh/v1.2.0-beta');
define("FORM_AMOUNT",100);
define("SERVICE_CHARGE",.24);
//Bkash live credentials

$curStr=$_SERVER['REQUEST_URI'];
$curArr=explode('/',$curStr);
$cur_path=$curArr[count($curArr)-1];
$dashboard_active="";
$payments_active="";
$profile_active="";

if($cur_path=='' || $cur_path=='dashboard'){
	$dashboard_active="active";
}elseif($cur_path=='' || $cur_path=='payments'){
	$payments_active="active";
}elseif($cur_path=='' || $cur_path=='profile'){
	$profile_active="active";
}else{

}
?>
<?php
define('NAME','Get Admitted Online');
define('TAGLINE','Get Admitted Online');
define('EMAIL','contact@thewebdivers.com');
define('FRONT_SITE_PATH','http://localhost/admission/');
define('STORE_ID',"thewe630883975551e");
define('STORE_PASSWORD',"thewe630883975551e@ssl");
define('STUDENT_IMAGE',FRONT_SITE_PATH."media/users/");
define('UPLOAD_STUDENT_IMAGE',$_SERVER['DOCUMENT_ROOT']."/admission/media/users/");
// Bkash Constants
define("APP_KEY","4f6o0cjiki2rfm34kfdadl1eqq");
define("APP_SECRET","2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b");
define("USERNAME","sandboxTokenizedUser02");
define("PASSWORD","sandboxTokenizedUser02@12345");
define("BASE_URL",'https://tokenized.sandbox.bka.sh/v1.2.0-beta');

$curStr=$_SERVER['REQUEST_URI'];
$curArr=explode('/',$curStr);
$cur_path=$curArr[count($curArr)-1];
$page_title='';
$mark_entry='';
$mark_sub_entry='';
$read_mark_entry="";
$read_mark_sub_entry="";

// if($cur_path=='' || $cur_path=='index.php'){
// 	$page_title='Dashboard';
// 	$index_active="menu-active";
// }elseif($cur_path=='class.php'){
// 	$page_title='Manage Class';
// 	$manage_class='sub-group-active';
// 	$class_menu_active='menu-active';
// }elseif($cur_path=='manageClass.php'){
// 	$page_title='Manage Class';
// 	$manage_class='sub-group-active';
// 	$manage_class_menu_active='menu-active';
// }elseif($cur_path=='applications.php' ){
// 	$page_title='Manage Applications';
// 	$application_group_active="sub-group-active";
// 	$application_sub_group_active="menu-active";
// }elseif($cur_path=='manageStudentProfile.php'){
// 	$page_title='Manage Applications';
// 	$application_group_active="sub-group-active";
// 	$manage_application_sub_group_active="menu-active";
// }elseif($cur_path=='payments.php' ){
// 	$page_title='Payments';
// 	$payment_group_active="sub-group-active";
// 	$payment_menu_active="menu-active";
// }elseif($cur_path=='users.php' ){
// 	$page_title='Users';
// 	$users_group_active="sub-group-active";
// 	$users_menu_active="menu-active";
// }elseif($cur_path=='markEntry.php' || $cur_path=='markEntry.php?classId=4' || $cur_path=='markEntry.php?classId=3'){
// 	$page_title='Mark Entry';
// 	$mark_entry='sub-group-active';
// 	$mark_sub_entry='menu-active';
// }elseif($cur_path=='marks.php'){
// 	$page_title='Mark Entry';
// 	$read_mark_entry='sub-group-active';
// 	$read_mark_sub_entry='menu-active';
// }elseif($cur_path=='login.php' ){
// 	$page_title='Login';
// }elseif($cur_path=='register.php' ){
// 	$page_title='Register';
// }elseif($cur_path=='verifyEmail.php' ){
// 	$page_title='Verify Email';
// }elseif($cur_path=='studentDetails.php'){
// 	$page_title='Student Details';
// }
?>
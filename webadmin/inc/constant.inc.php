<?php
define('HALL_NAME','Barishal Engineering College Hall');
define('ADDRESS','Durgapur, Barisal');
define('LOGO','Durgapur, Barisal');
define('WEBSITE','http://hall.bec.edu.bd/');
define('TEL',' +00 000 000 0000');
define('EMAIL','contact@thewebdivers.com');
define('FRONT_SITE_PATH','http://192.168.0.104/hall/');
define('STORE_ID',"thewe630883975551e");
define('STORE_PASSWORD',"thewe630883975551e@ssl");
define('STUDENT_IMAGE',FRONT_SITE_PATH."webadmin/media/users/");
// define('UPLOAD_STUDENT_IMAGE',$_SERVER['DOCUMENT_ROOT']."/hall/media/users/");/Users/dhrubo/Desktop
define('UPLOAD_STUDENT_IMAGE',"/Users/dhrubo/Desktop");
define('QR_CODE_ADDRESS',"http://192.168.0.104/hall/webadmin/");
define('HALL_FEE',0);
define('CONTINGENCY_FEE',00);
define('ELECTRICITY_FEE',00);
define('BKASH_FEE',0/1000);

// $manage_class='';
// $manage_class_menu_active='';
// $payment_group_active="";
// $payment_menu_active="";
// $class_menu_active='';
// $index_active="";
// $application_group_active="";
// $application_sub_group_active="";
// $manage_application_sub_group_active="";
// $users_group_active="";
// $users_menu_active="";
// //////variables
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
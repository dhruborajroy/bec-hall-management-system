<?php
define('SITE_NAME','Admission');
define('FRONT_SITE_PATH','http://127.0.0.1/bec-hall/');
define('STORE_ID',"dhrub5f103f94cd3e4");
define('STORE_PASSWORD',"dhrub5f103f94cd3e4@ssl");
define('STUDENT_IMAGE',FRONT_SITE_PATH."/media/users/");
define('UPLOAD_STUDENT_IMAGE',$_SERVER['DOCUMENT_ROOT']."/bec-hall/media/users/");

$manage_class='';
$manage_class_menu_active='';
$payment_group_active="";
$payment_menu_active="";
$class_menu_active='';
$index_active="";
$application_group_active="";
$application_sub_group_active="";
$manage_application_sub_group_active="";
$users_group_active="";
$users_menu_active="";
//////variables
$curStr=$_SERVER['REQUEST_URI'];
$curArr=explode('/',$curStr);
$cur_path=$curArr[count($curArr)-1];
$page_title='';
$mark_entry='';
$mark_sub_entry='';
$read_mark_entry="";
$read_mark_sub_entry="";

if($cur_path=='' || $cur_path=='index.php'){
	$page_title='Dashboard';
	$index_active="menu-active";
}elseif($cur_path=='class.php'){
	$page_title='Manage Class';
	$manage_class='sub-group-active';
	$class_menu_active='menu-active';
}elseif($cur_path=='manageClass.php'){
	$page_title='Manage Class';
	$manage_class='sub-group-active';
	$manage_class_menu_active='menu-active';
}elseif($cur_path=='applications.php' ){
	$page_title='Manage Applications';
	$application_group_active="sub-group-active";
	$application_sub_group_active="menu-active";
}elseif($cur_path=='manageStudentProfile.php'){
	$page_title='Manage Applications';
	$application_group_active="sub-group-active";
	$manage_application_sub_group_active="menu-active";
}elseif($cur_path=='payments.php' ){
	$page_title='Payments';
	$payment_group_active="sub-group-active";
	$payment_menu_active="menu-active";
}elseif($cur_path=='users.php' ){
	$page_title='Users';
	$users_group_active="sub-group-active";
	$users_menu_active="menu-active";
}elseif($cur_path=='markEntry.php' || $cur_path=='markEntry.php?classId=4' || $cur_path=='markEntry.php?classId=3'){
	$page_title='Mark Entry';
	$mark_entry='sub-group-active';
	$mark_sub_entry='menu-active';
}elseif($cur_path=='marks.php'){
	$page_title='Mark Entry';
	$read_mark_entry='sub-group-active';
	$read_mark_sub_entry='menu-active';
}elseif($cur_path=='login.php' ){
	$page_title='Login';
}elseif($cur_path=='register.php' ){
	$page_title='Register';
}elseif($cur_path=='verifyEmail.php' ){
	$page_title='Verify Email';
}elseif($cur_path=='studentDetails.php'){
	$page_title='Student Details';
}
?>
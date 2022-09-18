<?php 
session_start();
session_regenerate_id();
// include('./inc/connection.inc.php');
// include('./inc/constant.inc.php');
include('./inc/function.inc.php');
// isUSER();
unset($_SESSION['APPLICANT_LOGIN']);
unset($_SESSION['APPLICANT_ID']);
redirect('login.php');
?>
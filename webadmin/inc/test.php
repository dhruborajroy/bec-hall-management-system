<?php
include("./constant.inc.php");
include("./connection.inc.php");
include("./function.inc.php");
require_once("./smtp/class.phpmailer.php");
echo $last_date=cal_days_in_month(CAL_GREGORIAN, '08', date('Y'));
$date=getdate();
echo $date['mday'];
echo "<pre>";
print_r(getdate());
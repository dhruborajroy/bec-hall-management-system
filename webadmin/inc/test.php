<?php
include("./constant.inc.php");
include("./connection.inc.php");
include("./function.inc.php");
require_once("./smtp/class.phpmailer.php");
send_email("Dhruborajroy3@gmail.com",send_email_using_tamplate("Dhrubo","1122","2"),"Subject"); 
die;  
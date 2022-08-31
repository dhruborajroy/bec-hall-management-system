<?php
include("./constant.inc.php");
include("./connection.inc.php");
include("./function.inc.php");
require_once("./smtp/class.phpmailer.php");
// $salt="dsckndkn";
// $hash=password_hash($salt."123Dhrubo",PASSWORD_DEFAULT);

// echo password_verify($salt."123Dhrubo",$hash);
//SELECT (SELECT sum(amount) FROM monthly_bill WHERE month_id = '07') AS july, (SELECT sum(amount) FROM monthly_bill WHERE month_id = '08') AS august;
//SELECT (SELECT sum(amount) FROM monthly_bill WHERE month_id = '07' AND user_id=1) AS july, (SELECT sum(amount) FROM monthly_bill WHERE month_id = '08' and user_id=1) AS august;

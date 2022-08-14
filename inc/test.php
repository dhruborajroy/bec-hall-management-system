<?php
// SELECT SUM(meal_value) FROM meal_table WHERE month_id='1' AND roll='200129'
// SELECT SUM(meal_value) FROM `meal_table` WHERE month_id=1;
// echo $time=strtotime("15-08-2022")."<br>";
// echo date('d-M-Y',mktime($time))."<br>";

$date=date_create_from_format("d/m/Y","15/08/2022");
echo date_format($date,"d");
echo date_format($date,"m");
echo date_format($date,"Y");
?>

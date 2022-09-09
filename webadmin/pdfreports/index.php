<?php
include("../inc/browserDetection.php");
$Browser = new foroco\BrowserDetection();
$useragent = $_SERVER['HTTP_USER_AGENT'];
$result = $Browser->getAll($useragent);
foreach ($result as $key => $value) {
    echo ucfirst($key).'= '.ucfirst($value).'<br> ';
}

?>
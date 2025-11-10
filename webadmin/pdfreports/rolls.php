<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');

// Load your JSON data
$jsonData = file_get_contents('data.json');
$numbers = json_decode($jsonData, true);

$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12   ,
    'default_font' => 'FreeSerif',
	'margin_left' => 2,
	'margin_right' => 2,
	'margin_top' => 2,
	'margin_bottom' => 2,
]);

$html = '<style>body{font-family: sans-serif; font-size:10pt;} .num-col{width: 10%; display:inline-block;}</style>';

$counter = 0;
foreach ($numbers as $number) {
    $html .= "<span class='num-col'>$number</span>";

    $counter++;
    if ($counter % 10 === 0) {
        $html .= "<br>";
    }
}

$mpdf->WriteHTML($html);
$mpdf->SetFooter('{PAGENO}');
$mpdf->Output('output.pdf', 'I'); // 'I' for browser preview
?>
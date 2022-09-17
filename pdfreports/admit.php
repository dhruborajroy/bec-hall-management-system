<?php
session_start();
include("../inc/connection.inc.php");
include("../inc/constant.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
$html="";
$html.='<table class="table" width="100%" style="border: 1px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td align="center">                    
             <img width="150" src="../assets/img/logo.svg" width="100" /> 
        </td>
        <td  align="center" colspan="2">
            <strong><span style="font-size:25px">'.NAME.'</span></strong>
            <br>
            <span style="font-size:25px;text-align:left">Sylhet Engineering College</span>
        </td>
        <td align="center">                    
             <img width="150" src="../assets/img/logo.svg" width="100" /> 
        </td>
    </tr>';
$html.="</table>";

$html.='<table class="table" width="100%" >';
$html.='
    <tr>
        <td align="center">                    
             Admit Card
        </td>
    </tr>';
$html.="</table>";
$html.='<table class="table" width="100%" style="padding:20px;border: 1px solid black;border-collapse: collapse;">';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:20px;padding-left:20px;">                    
        Roll
    </td>
    <td align="left"  style="padding-top:20px;padding-left:20px;">                    
        : 20023
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        Applicant\'s Name
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Dhrubo
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        Father\'s Name
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Debendra Nath
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        Mother\'s Name
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Malati Roy
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        HSC Roll
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : 229409
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        HSC Board
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Dinajpur
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        HSC Passing year
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : 2020
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        Question Type
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : English
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        Quota
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : None
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="250px"  style="padding-top:0px;padding-left:20px;">                    
        Exam Date & Time
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : 20 July 2020
    </td>
</tr>';
$html.="</table>";
// echo $html;
$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
	'margin_left' => 5,
	'margin_right' => 5,
	'margin_top' => 2,
	'margin_bottom' => 10,
]);
$mpdf->SetTitle('Students list');
$mpdf->SetFooter('Students list | Developed By The Web divers | {PAGENO}');
$mpdf->WriteHTML($html);
$file=time().'.pdf';
$mpdf->output($file,'I');
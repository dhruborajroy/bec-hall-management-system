<?php
session_start();
include("../inc/connection.inc.php");
include("../inc/constant.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../inc/vendor/autoload.php');
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
            <span style="font-size:25px;text-align:left"><b>Sylhet Engineering College</b></span>
        </td>
        <td align="center">                    
             <img width="150" src="../assets/img/logo.svg" width="100" /> 
        </td>
    </tr>';
$html.="</table>";

$html.='<table class="table" width="100%" >';
$html.='
    <tr>
        <td align="center" style="font-size:20px">                    
             <b>Admit Card</b>
        </td>
    </tr>';
$html.="</table>";
$html.='<table class="table" width="100%" style="padding:20px;border: 1px solid black;border-collapse: collapse;">';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="center"  >                    
    </td>
    <td align="center">                    
    </td>
    <td align="center" rowspan="8" style="padding-top:10px;padding-left:20px;" >                    
        <img width="150" src="../assets/img/user/user11.jpg" /> 
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:10px;padding-left:20px;padding-right:20px;">                    
        Roll
    </td>
    <td align="left"  style="padding-top:20px;padding-left:20px;">                    
        : 20023
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        Applicant\'s Name
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Dhrubo
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        Father\'s Name
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Debendra Nath
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        Mother\'s Name
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Malati Roy
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        HSC Roll
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : 229409
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        HSC Board
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : Dinajpur
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        HSC Passing year
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : 2020
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        Question Type
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : English
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        Quota
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : None
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="left" width="150px"  style="padding-top:0px;padding-left:20px;">                    
        Exam Date & Time
    </td>
    <td align="left"  style="padding-top:0px;padding-left:20px;">                    
        : 20 July 2020
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px" >
    <td align="left" width="150px" colspan="2" style="padding-top:20px;padding-bottom:10px;padding-left:20px;">                    
        <img width="150" src="../assets/img/logo.svg" width="300" height="80" /> 
    </td>
</tr>';
$html.='
<tr style="padding:120px;margin:120px" colspan="2">
    <td align="left" width="150px"  style="padding-top:20px;padding-bottom:20px;padding-left:20px;">                    
       Applicants Signature
    </td>
</tr>';
$html.="</table>";

$html.='<table class="table" width="100%" style="border: 0px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td align="left" style="padding-top:5px;padding-bottom:5px;padding-left:20px;">
            Print Date: '.date("d M Y h:i A").'
        </td>
    </tr>';
$html.="</table>";


$html.='<table class="table" width="100%" style="border: 1px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td align="center">
            General Instructions
            <br>
            01 Bring printed copy of this admit card in the examination hall.
            02 Students must have to bring his/her original copy of HSC registration card into the exam hall otherwise he/she will not be able to sit for the exam. Result will
            be published at www.butex.edu.bd and University Notice Boards.
        </td>
    </tr>';
$html.="</table>";

$html.='<table class="table" width="100%" style="border: 0px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td align="right" style="padding-top:20px;padding-bottom:20px;padding-right:20px;">
            <img width="150" src="../assets/img/logo.svg" /> 
            <br>
        </td>
    </tr>';
$html.="</table>";

$html.='<table class="table" width="100%" style="border: 1px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td align="center">
            2021-'.date("Y").' © Sylhet Engineering College
        </td>
    </tr>';
$html.="</table>";
// echo $html;
$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
	'margin_left' => 15,
	'margin_right' => 15,
	'margin_top' => 17,
	'margin_bottom' => 20,
]);
$mpdf->SetTitle('Admit Card');
$mpdf->SetFooter('|| Developed By The Web Divers');
$mpdf->WriteHTML($html);
$file="Admit_".time().'.pdf';
$mpdf->output($file,'I');
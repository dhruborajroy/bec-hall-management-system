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

$html.='<table class="table" width="100%" style="background-color: #fff;margin-top:10px;">';
$html.='
    <tr>
        <td align="center" style="font-size:20px">                    
             <b>Invoice</b>
        </td>
    </tr>';
$html.="</table>";
$html.='<table class="table" width="100%" style="background-color: #fff;margin-top:10px;border: 1px solid black;border-collapse: collapse;">';
// $html.='
//     <tr >
//         <td align="Left"  style="padding-top:10px;padding-left:20px;">
//            Invoice From
//            <br>
//            John Doe
//            806 Twin Willow Lane, Old Forge,
//            Newyork, USA
//         </td>
//         <td align="Right" colspan=""  style="padding-top:10px;padding-left:20px;">
//          Invoice To
//          <br>
//          John Doe
//          806 Twin Willow Lane, Old Forge,
//          Newyork, USA
//         </td>
//     </tr>';
$html.='
<tr style="padding:120px;margin:120px">
    <td align="center"  >                    
    </td>
    <td align="center">                    
    </td>
    <td align="center" rowspan="5" style="padding-top:20px;" >                    
        <img width="150px" height="150px" src="../assets/img/user/user11.jpg" /> 
    </td>
</tr>';
    $html.='
    <tr>
        <td align="Left" style="padding-top:5px;padding-left:20px;">
         Name: Dhruboraj Roy
        </td>
    </tr>';
    $html.='
    <tr>
        <td align="Left" style="padding-top:5px;padding-left:20px;">
        Father\'s name: Debendra Nath
        </td>
    </tr>';
    $html.='
    <tr>
        <td align="Left" style="padding-top:10px;padding-left:20px;">
        Mother\'s name: Debendra Nath
        </td>
    </tr>';
    $html.='
    <tr>
        <td align="Left" style="padding-top:10px;padding-left:20px;padding-bottom:10px;">
        Email: Dhruborjaroy@fmail.cnm
        </td>
    </tr>';
    $html.='
    <tr>
        <td align="Left" style="padding-top:10px;padding-left:20px;padding-bottom:10px;">
        Email: Dhruborjaroy@fmail.cnm
        </td>
    </tr>';
    $html.='
    <tr>
        <td align="Left" style="padding-top:10px;padding-left:20px;padding-bottom:10px;">
        Email: Dhruborjaroy@fmail.cnm
        </td>
    </tr>';
$html.="</table>";


$html.='<table class="table" width="100%" style="margin-top:50px;border: 1px solid black;border-collapse: collapse;">';
$html.='
    <tr>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;background-color: #e3dfdf;">
      SL No
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;background-color: #e3dfdf;">
       Description
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;background-color: #e3dfdf;">
         Form fee
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;background-color: #e3dfdf;">
         Service Charge
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;background-color: #e3dfdf;">
       Total
      </td>
    </tr>';
    $html.='
    <tr>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">
         1
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">
       Admission Fee
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">
       100
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">
       25
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">
       125
      </td>
    </tr>';
    $html.='
    <tr>
      <td colspan="4" style="border: 1px solid black;border-collapse: collapse;text-align:Right;">
         Total
      </td>
      <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">
       125
      </td>
    </tr>';
$html.="</table>";

$html.='<table class="table" width="100%" style="margin-top:20px;border: 0px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td style="font-size:12px" align="left">                    
            Generated On: '.date("d M Y h:i A").'
        </td>
    </tr>';
$html.="</table>";

$html.='<table class="table" width="100%" style="margin-top:50px;border: 1px solid black;border-collapse: collapse;">';
$html.='
    <tr>
        <td style="font-size:12px" align="left">                    
            <span align="left">This is computer generated invoice. No signature is required</span>
        </td>
        <td align="right" style="font-size:12px">              
            <span >Developed by The Web Divers</span>
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
$mpdf->SetTitle('Invoice');
$mpdf->showWatermarkImage=true;
// $mpdf->SetWatermarkImage("../assets/img/paid.png",.5,'D','F');
$mpdf->SetFooter('|| Developed By The Web Divers');
$mpdf->WriteHTML($html);
$mpdf->Image('../assets/img/du_logo.png', 140, 75, 30, 30, 'png', '', true, true);
$file="Invoice_".time().'.pdf';
$mpdf->output($file,'I');
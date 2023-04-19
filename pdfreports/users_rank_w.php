<?php
session_start();
include("../inc/connection.inc.php");
include("../inc/constant.inc.php");
include("../inc/function.inc.php");


if(!isset($_SESSION['APPLICANT_ID'])){
    // $_SESSION['TOASTR_MSG']=array(
    //     'type'=>'error',
    //     'body'=>'You don\'t have the permission to access the location!',
    //     'title'=>'Error',
    // );
    // redirect("../index");
}
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

$html.='<table class="table" width="100%" >';
$html.='<tr>
        <td width="5px" style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;"></td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Picture</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Exam Roll</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Name</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Roll</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Father\'s Name</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Rank</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Phone</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">email</td>
    </tr>';
    $sql="select * from applicants order by merit ";
    $res=mysqli_query($con,$sql);
    if(mysqli_num_rows($res)>0){
        $i=1;
        while($row=mysqli_fetch_assoc($res)){
            // the while loop

            $html.='<tr>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;"><img src="'.STUDENT_IMAGE.$row['image'].'" style="border-radius:60px" height="100px" weight="100px"></td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['examRoll'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['first_name'].' '.$row['last_name'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['roll'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['fName'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['merit'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['phoneNumber'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.maskEmail($row['email']).'</td>
            </tr>';
            $i++;
        } 
        //IF condition ended
    } else {
        $html.='
        <tr>
        <td colspan="8" align="center">No data found</td>
        </tr>';
    }//else ended
$html.='</table>';
    echo $html;
$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
	'margin_left' => 15,
	'margin_right' => 15,
	'margin_top' => 17,
	'margin_bottom' => 20,
]);
// $mpdf->SetTitle('Admit Card');
// $mpdf->SetFooter('|| Developed By The Web Divers');
// $mpdf->WriteHTML($html);
// $file="Rank_".time().'.pdf';
// $mpdf->output($file,'I');
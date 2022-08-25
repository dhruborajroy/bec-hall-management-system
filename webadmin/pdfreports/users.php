<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
if (isset($_GET['batch_id']) && $_GET['batch_id']!="") {
    $batch_id=get_safe_value($_GET['batch_id']);
}else{
    // $_SESSION['PERMISSION_ERROR']=1;
    // redirect("index.php");
}
$html='<table class="table" width="100%">';
$html.='
    <tr>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center">                    
        <img width="150" src="./img/logo.jpg" width="100" height="100" />
    </td>
    <td  align="center" colspan="3">
    <strong><span style="font-size:25px">'.HALL_NAME.'</span></strong>
    <br>
    '.ADDRESS.'
    <br>
    Tel: '.TEL.' | Email: '.EMAIL.'
    <br>
    '.WEBSITE.'
    </td>
</tr>';
$html.='<tr><td colspan="7"><hr></td></tr>';
$html.='<tr>
        <td width="5px" style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Roll</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Name</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Father\'s Name</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Mother\'s Name</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Phone</td>
        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Batch</td>
    </tr>';
    $additional_sql="";
    if($batch_id!=""){
        $additional_sql=" and batch.id='$batch_id'";
    }
    $sql="select users.*, batch.name batch_name from users,batch where users.batch=batch.id $additional_sql";
    $res=mysqli_query($con,$sql);
    if(mysqli_num_rows($res)>0){
        $i=1;
        while($row=mysqli_fetch_assoc($res)){
            // the while loop
            $html.='<tr>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['roll'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['fName'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['mName'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['phoneNumber'].'</td>
            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['batch_name'].'</td>
            </tr>';
            $i++;
        } 
        //IF condition ended
    } else {
        $html.='
        <tr>
        <td colspan="3" align="center">No data found</td>
        </tr>';
    }//else ended
$html.='</table>';

$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif'
]);
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Students list');
$mpdf->SetFooter('Students list | Developed By The Web divers | {PAGENO}');
// $mpdf->SetHeader('Document Title | Center Text | {PAGENO}');
$file=time().'.pdf';
$mpdf->output($file,'I');
// $mpdf->output($file,'F');
// send_email("orinkarmaker03@gmail.com","Invoice","Skm",$file);
// send_email("azadahammed52@gmail.com","Invoice","Skm",$file);
// send_email("dhruborajroy3@gmail.com","Invoice","Skm",$file);
// unlink($file);
//D
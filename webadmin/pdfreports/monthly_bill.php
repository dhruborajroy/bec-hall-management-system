<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
if (isset($_GET['month_id']) && $_GET['month_id']!="") {
    $month_id=get_safe_value($_GET['month_id']);
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    // redirect("index.php");
}
$sql="select amount from monthly_bill where month_id='$month_id'";
$res=mysqli_query($con,$sql);
$html="";
if(mysqli_num_rows($res)>0){
    $html='<table class="table" width="100%">';
    $html.='
        <tr>
            <td align="center">                    
            <!--- <img width="150" src="'.LOGO.'" width="100" height="100" /> --->
            </td>
            <td  align="center" colspan="2">
            <strong><span style="font-size:25px">'.HALL_NAME.'</span></strong>
            <br>
            '.ADDRESS.'
            <br>
            Tel: '.TEL.' | Email: '.EMAIL.'
            <br>
            '.WEBSITE.'
            </td>
        </tr>';
	    $html.='<tr><td colspan="3"><hr></td></tr>';
	    $html.='<tr><td colspan="3" align="center">Monthly Bill chart for July-22</td></tr>';
	    $html.='<tr><td colspan="3"><hr></td></tr>';
        $html.='<tr>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Fee details</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
            </tr>';
            $sql="select monthly_bill.*,users.name from monthly_bill,users where monthly_bill.user_id=users.id and monthly_bill.month_id='$month_id'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                $i=1;
                while($row=mysqli_fetch_assoc($res)){
                    // the while loop
                    $html.='<tr>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['amount'].'</td>
                    </tr>';
                    $i++;
                } 
                //IF condition ended
            } else {
                $html.='
                <tr>
                <td colspan="3" align="center">No data found</td>
                </tr>';
            }
	    $html.='</table>';
}else{
    $html.="No data found";
}

$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif'
]);
$mpdf->SetTitle('Monthly Bill chart for '.date('F - Y'));
$mpdf->SetFooter('Monthly Bill chart for '.date('F-y').'| Developed By The Web divers | {PAGENO}');
$mpdf->WriteHTML($html);
$file=time().'.pdf';
$mpdf->output($file,'I');
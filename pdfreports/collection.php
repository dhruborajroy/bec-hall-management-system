<?php
session_start();
include("../inc/connection.inc.php");
include("../inc/constant.inc.php");
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
    $html='<table class="table" width="100%" style="margin-top:10px">';
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
        $html.='<table>';
        $html.='<tr>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Date</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
            </tr>';
        $last_date=cal_days_in_month(CAL_GREGORIAN, $month_id, date('Y'));
        for ($i=1; $i <= $last_date; $i++) {
            $a="";
            if($i<10){
                $a="0";
            }
            $sql="SELECT sum(total_amount) as total_amount FROM `payments` where   created_at between ".strtotime($i.'-'.$month_id.'-'.date('Y').' 00:00:00')." and ".strtotime($i.'-'.$month_id.'-'.date('Y').' 23:59:59')."";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
                    $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>';
                        $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.date('d-M Y',strtotime($i.'-'.$month_id.'-'.date('Y'))).'</td>';
                        if($row['total_amount']>0){
                            $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.round($row['total_amount'],2).' </td>';
                            $amount=intval($amount)+round($row['total_amount'],2);
                        }else{
                            $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;"> 0.00 </td>';
                        }
                    $html.='</tr>';
                }
            }else{
                $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">No data found</td>';
            }
        }
        $html.='
        <tr style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">
            <td colspan="2" align="right">Total</td>
            <td  align="center">'.$amount.' Taka</td>
        </tr>';
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
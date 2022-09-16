<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
if (isset($_GET['month']) && $_GET['month']!="" && isset($_GET['year']) && $_GET['year']!="") {
    // $month_id=get_safe_value($_GET['id']);
	$month=get_safe_value($_GET['month']);
	$year=get_safe_value($_GET['year']);
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    // redirect("index.php");
}
// $sql="select amount from monthly_bill where month_id='$month_id'";
// $res=mysqli_query($con,$sql);
// $html="";
// if(mysqli_num_rows($res)>0){
    $html='<table class="table" width="100%">';
    $html.='
        <tr>
            <td align="center"  colspan="3">                    
                <!--- <img width="150" src="'.LOGO.'" width="100" height="100" /> --->
            </td>
            <td  align="center" colspan="30">
            <strong><span style="font-size:25px">'.HALL_NAME.'</span></strong>
            <br>
            '.ADDRESS.'
            <br>
            Tel: '.TEL.' | Email: '.EMAIL.'
            <br>
            '.WEBSITE.'
            </td>
        </tr>';
	    $html.='<tr><td colspan="34"><hr></td></tr>';
    $html.='<tr>
            <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Roll</td>';
            $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Name</td>';
            $last_date=cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
            for ($i=1; $i <= $last_date; $i++) {
                $a="";
                if($i<10){
                    $a='0';
                }
                $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">'.$a.$i.'</td>';
            }
            $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Total</td>';
            $html.'=</tr>';
            $sql="select * from users order by id desc";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                    $i=1;
                    while($row=mysqli_fetch_assoc($res)){
                        // the while loop
                        $html.='<tr>';
                        $html.='<td width="70px" style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['roll'].'</td>';
                        $html.='<td width="170px" style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>';
                        $total_meal=0;
                        for ($i=01; $i <= $last_date; $i++) {
                            $a="";
                            if($i<10){
                                $a='0';
                            }
                            $meal_sql="select * from `meal_table` where date_id='$a$i' and month_id='$month' and year='$year' and `meal_table`.roll=".$row['roll'];
                            $meal_res=mysqli_query($con,$meal_sql);
                            if(mysqli_num_rows($meal_res)>0){
                                $meal_row=mysqli_fetch_assoc($meal_res);
                                $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$meal_value=$meal_row['meal_value'].'</td>';
                                $total_meal=intval($total_meal)+intval($meal_value);
                            }else{
                                $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">-</td>';
                            }
                            if($i==$last_date){
                                $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$total_meal.'</td>';
                            }
                        }
                    $html.='</tr>';
                    $i++;
                }//IF condition ended
            } else {
                $html.='
                <tr>
                <td colspan="3" align="center">No data found</td>
                </tr>';
            }//else ended
	    $html.='</table>';
// }else{
//     $html.="No data found";
// }

$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
    'mode' => 'utf-8',
    'format' => 'A4-L',
    'orientation' => 'L',
]);
$mpdf->SetTitle('Monthly Bill chart for '.date('F - Y'));
$mpdf->SetFooter('Monthly Bill chart for '.date('F-y').'| Developed By The Web divers | {PAGENO} of {nbpg} ');
$mpdf->WriteHTML($html);
$file=time().'.pdf';
$mpdf->output($file,'I');
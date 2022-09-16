<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
$month_id="";
$year="";
if (isset($_GET['month_id']) && $_GET['month_id']!="" && isset($_GET['year']) && $_GET['year']!="" ) {
    $month_id=get_safe_value($_GET['month_id']);
    $year=get_safe_value($_GET['year']);
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    // redirect("index.php");
}
$sql="select amount from monthly_bill where month_id='$month_id' and year='$year'";
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
	    $html.='<tr><td colspan="3" align="center">Expense list for '.$monthName = date('F - Y', mktime(0, 0, 0, $month_id, 10, $year)).'</td></tr>';
	    $html.='<tr><td colspan="3"><hr></td></tr>';
        $html.='<tr>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
            </tr>';
            $sql="SELECT SUM(amount) as amount, expense_category.name from expense, expense_category WHERE expense.expense_category_id=expense_category.id AND expense.month='$month_id' group by expense_category.id";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                $i=1;
                $total=0;
                while($row=mysqli_fetch_assoc($res)){
                    // the while loop
                    $html.='
                    <tr>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['amount'].' Taka</td>
                    </tr>';
                    $i++;
                    $amount=intval($amount)+intval($row['amount']);
                }
        	    $html.='
                <tr style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">
                    <td colspan="2" align="right">Total</td>
                    <td  align="center">'.$amount.' Taka</td>
                </tr>';

                //IF condition ended
            } else {
                $html.='
                <tr>
                <td colspan="3" align="center">No data found</td>
                </tr>';
            }//else ended
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
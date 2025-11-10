<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
if (isset($_GET['month_id']) && $_GET['month_id']!="" && isset($_GET['year']) && $_GET['year']!="") {
    $month_id=get_safe_value($_GET['month_id']);
    $year=get_safe_value($_GET['year']);
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    // redirect("index.php");
}
$sql="select amount from monthly_bill where month_id='$month_id' and year='$year'";
$res=mysqli_query($con,$sql);
$html="";
$sum_paid = 0.0;
$sum_unpaid = 0.0;

if(mysqli_num_rows($res)>0){
    $html='<table class="table" width="100%">';
    $html.='
        <tr>
            <td align="center">                    
            <!--- <img width="150" src="'.LOGO.'" width="100" height="100" /> --->
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
	    $html.='<tr><td colspan="4"><hr></td></tr>';
	    $html.='<tr><td colspan="4" align="center">Monthly Bill chart for '.$month_name=date('F',mktime(0, 0, 0, $month_id, 10)).'-'.$year.'</td></tr>';
	    $html.='<tr><td colspan="4"><hr></td></tr>';
        // $html.='<tr>
        //         <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
        //         <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Fee details</td>
        //         <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
        //     </tr>';
        //     $sql="select monthly_bill.*,users.name from monthly_bill,users where monthly_bill.user_id=users.id and monthly_bill.month_id='$month_id' and year='$year'";
        //     $res=mysqli_query($con,$sql);
        //     if(mysqli_num_rows($res)>0){
        //         $i=1;
        //         while($row=mysqli_fetch_assoc($res)){
        //             // the while loop
        //             $html.='<tr>
        //             <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
        //             <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>
        //             <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['amount'].'</td>
        //             </tr>';
        //             $i++;
        //         } 
        //         //IF condition ended
        //     } else {
        //         $html.='
        //         <tr>
        //         <td colspan="3" align="center">No data found</td>
        //         </tr>';
        //     }
        // ...
            $html .= '<tr>
                <td style="border:1px solid #000;background-color:#b7b4b4;text-align:center;">Id</td>
                <td style="border:1px solid #000;background-color:#b7b4b4;text-align:center;">Student</td>
                <td style="border:1px solid #000;background-color:#b7b4b4;text-align:center;">Amount</td>
                <td style="border:1px solid #000;background-color:#b7b4b4;text-align:center;">Status</td>
            </tr>';

            $sql = "SELECT mb.user_id, mb.amount, mb.paid_status, u.name
                    FROM monthly_bill mb
                    JOIN users u ON u.id = mb.user_id
                    WHERE mb.month_id = '$month_id' AND mb.year = '$year'
                    ORDER BY u.name ASC";
            $res = mysqli_query($con, $sql);

            if ($res && mysqli_num_rows($res) > 0) {
                $i = 1;
                while ($row = mysqli_fetch_assoc($res)) {
                    
                    $isPaid = (int)$row['paid_status'] === 1;
                    $badgeBg = $isPaid ? '#2e7d32' : '#c62828';
                    $badgeTx = '#ffffff';
                    $badgeTxT = $isPaid ? 'Paid' : 'Unpaid';
                    //paid and unpaid calculations
                    $amt = (float)$row['amount'];
                    if ($isPaid) {
                        $sum_paid += $amt;
                    } else {
                        $sum_unpaid += $amt;
                    }

                    $html .= '<tr>
                        <td style="border:1px solid #000;text-align:center;">'.$i.'</td>
                        <td style="border:1px solid #000;text-align:center;">'.htmlspecialchars($row['name']).'</td>
                        <td style="border:1px solid #000;text-align:center;">'.number_format((float)$row['amount'],2).'</td>
                        <td style="border:1px solid #000;text-align:center;">
                           '.$badgeTxT.'
                        </td>
                    </tr>';
                    // Totals footer
                    $i++;
                }
            $grand = $sum_paid + $sum_unpaid;

            $html .= '
                <tr><td colspan="4"><hr></td></tr>
                <tr>
                    <td colspan="2" style="border:1px solid #000;text-align:right;"><strong>Total Paid</strong></td>
                    <td colspan="2" style="border:1px solid #000;text-align:center;"><strong>'.number_format($sum_paid,2).'</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:1px solid #000;text-align:right;"><strong>Total Unpaid</strong></td>
                    <td colspan="2" style="border:1px solid #000;text-align:center;"><strong>'.number_format($sum_unpaid,2).'</strong></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:1px solid #000;text-align:right;"><strong>Grand Total</strong></td>
                    <td colspan="2" style="border:1px solid #000;text-align:center;"><strong>'.number_format($grand,2).'</strong></td>
                </tr>
            ';
            } else {
                $html .= '<tr>
                    <td colspan="4" align="center" style="border:1px solid #000;">No data found</td>
                </tr>';
            }
            // ...

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
<?php
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
// if (isset($_GET['user_id']) && $_GET['user_id']!="") {
//     $user_id=get_safe_value($_GET['user_id']);
// }
// else{
//     $_SESSION['PERMISSION_ERROR']=1;
//     redirect("index.php");
// }
$sql="SELECT * from users";
$res=mysqli_query($con,$sql);
    $html='<table  width="100%">';
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
            $html.='<tr><td colspan="3" align="center">Monthly Bill chart for '.date("Y").'</td></tr>';
            $html.='<tr><td colspan="3"><hr></td></tr>';
        $html.='</table>';
            //header ended
            $html.='<table  width="100%" style="margin-top:10px">';
            $html.='<tr>
                    <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;width:10%">Roll</td>';
                    $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;width:20%">Name</td>';
                    for ($i=1; $i <= 12; $i++) {
                        $month_name=date('M',mktime(0, 0, 0, $i, 10));
                        $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;width:8%">'.$month_name.'</td>';
                    }
            $html.='</tr>';
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
                $user_id=$row['id'];
                $sqll="SELECT ";
                for ($i=1; $i <= 12; $i++) {
                    $a="";
                    if($i<10){
                        $a="0";
                    }

                    
                    // echo $sqll.="(SELECT SUM(amount) FROM monthly_bill WHERE paid_status != 1 AND month_id = '$a$i' AND user_id = '$user_id') + (SELECT SUM(amount) FROM monthly_fee WHERE paid_status != 1 AND month_id = '$a$i' AND user_id = '$user_id') AS ".date('F',mktime(0, 0, 0, $i, 10) );
                    // $sqll.= "SELECT CASE WHEN mb.paid_status != 1 AND mf.paid_status != 1 THEN COALESCE(mb.amount, 0) + COALESCE(mf.amount, 0) WHEN mb.paid_status != 1 THEN mb.amount WHEN mf.paid_status != 1 THEN mf.amount ELSE 0 END AS ".date('F',mktime(0, 0, 0, $i, 10)." FROM monthly_bill mb LEFT JOIN monthly_fee mf ON mb.user_id = mf.user_id AND mb.month_id = mf.month_id AND mb.year = mf.year WHERE mb.user_id = '$user_id' AND mb.month_id = '$a$i' ";
                    // $sqll.="(SELECT sum(amount) FROM monthly_bill WHERE  monthly_bill.paid_status!=1 and month_id = '$a$i' and user_id='$user_id') AS ".date('F',mktime(0, 0, 0, $i, 10) );
                    if($i<12){
                        $sqll.=",";
                    }
                    $monthName = date('F', mktime(0, 0, 0, $i, 10)); 
                    $query = "SELECT 
                        CASE
                            WHEN mb.paid_status != 1 AND mf.paid_status != 1 THEN COALESCE(mb.amount, 0) + COALESCE(mf.amount, 0)
                            WHEN mb.paid_status != 1 THEN mb.amount
                            WHEN mf.paid_status != 1 THEN mf.amount
                            ELSE 0
                        END AS `$monthName`
                    FROM 
                        monthly_bill mb
                    LEFT JOIN 
                        monthly_fee mf 
                    ON 
                        mb.user_id = mf.user_id 
                        AND mb.month_id = mf.month_id 
                        AND mb.year = mf.year
                    WHERE 
                        mb.user_id = '$user_id'
                        AND mb.month_id = '$a$i';
                    ";

                }
                $ress=mysqli_query($con,$query);
                if(mysqli_num_rows($ress)>0){
                    $ids=1;
                    while($rows=mysqli_fetch_assoc($ress)){
                        // the while loop
                        $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['roll'].'</td>';
                        $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>';
                        for ($i=1; $i <= 12; $i++) {
                            $month_name=date('F',mktime(0, 0, 0, $i, 10));
                            $html.='<td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$rows[$month_name].'</td>';
                        }
                        $html.='</tr>';
                        $ids++;
                    }
                    //IF condition ended
                    $ids++;
                } else {
                    $html.='
                    <tr>
                    <td colspan="3" align="center">No data found</td>
                    </tr>';
                }
    }
    $html.='<tr>';
    $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;width:9%"></td>';
    $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;width:20%">Total</td>';
    
    for ($i=1; $i <= 12; $i++) {
        $a="";
        if($i<10){
            $a="0";
        }

        // $sum_swl="SELECT sum(monthly_bill.amount+monthly_fee.amount) as amount from monthly_bill,monthly_fee WHERE monthly_bill.paid_status='0' and monthly_fee.paid_status='0' and monthly_bill.month_id='$a$i' and monthly_fee.month_id='$a$i' and monthly_bill.year='".date("Y")."' and monthly_bill.year='".date("Y")."'";
       
        // $sum_swl="SELECT SUM(b.amount + f.amount) AS amount FROM monthly_bill b JOIN monthly_fee f ON b.user_id = f.user_id AND b.month_id = f.month_id AND b.year = f.year WHERE b.paid_status = '0' AND f.paid_status = '0' AND b.month_id = '$a$i' AND b.year = '".date("Y")."'";
        $sum_swl="SELECT sum(monthly_bill.amount) as amount from monthly_bill WHERE monthly_bill.paid_status='0' and monthly_bill.month_id='$a$i' and monthly_bill.year='".date("Y")."'";
        
        
        $sum_ress=mysqli_query($con,$sum_swl);
        if(mysqli_num_rows($sum_ress)>0){
            while($sum_rows=mysqli_fetch_assoc($sum_ress)){
                $html.='<td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;width:8%">'.$sum_rows['amount'].'</td>';
            }
        }
        $html.='</tr>';
    }
    $html.='</table>';
}else{
    $html.="";
}

$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12   ,
    'default_font' => 'FreeSerif',
	'margin_left' => 2,
	'margin_right' => 2,
	'margin_top' => 2,
	'margin_bottom' => 2,
]);
$mpdf->SetTitle('Monthly Bill chart for '.date("Y"));
$mpdf->SetFooter('Developed By The Web divers');
$mpdf->WriteHTML($html);
$file=time().'.pdf';
$mpdf->output($file,'I');
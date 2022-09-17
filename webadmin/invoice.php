<?php
include("./inc/function.inc.php");
session_start();
include("./inc/constant.inc.php");
include("./inc/connection.inc.php");
require_once("./inc/smtp/class.phpmailer.php");
if (isset($_GET['id']) && $_GET['id']!="") {
    $invoice_id=get_safe_value($_GET['id']);
        if(isset($_GET['send_email']) && $_GET['send_email']=='true'){
    }
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    redirect("index.php");
}
require('vendor/autoload.php');
$invoice_id=$_GET['id'];
$sql="select total_amount from payments where id='$invoice_id'";
$res=mysqli_query($con,$sql);
$html="";
if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);
    $total_amount=$row['total_amount'];
    $html='<table class="table" width="100%" style="">';
    $html.='
        <tr>
            <td align="center">                    
                <img width="150" src="./img/logo.jpg" width="100" height="100" />
            </td>
            <td  align="center" colspan="2">
                <strong><span style="font-size:25px">Barisal Engineering College Hall</span></strong>
                <br>
                Durgapur, Barisal
                <br>
                Tel: +00 000 000 0000 | Email: becians2017@gmail.com
                <br>
                http://www.barisal-eng.edu.bd/
            </td>
        </tr>';
        $html.='
            <tr><td colspan="3"><hr></td></tr>
            <tr width="100%">
            </tr>';
            $sql="select users.id,users.name,users.batch,users.dept_id,users.class_roll,depts.id,depts.name as dept_name, payments.id,payments.user_id,payments.created_at from users,depts, payments where users.id=payments.user_id and users.dept_id=depts.id and payments.id='$invoice_id'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
            $html.='
                <tr width="100%">
                    <td  style="border: 1px solid black;border-collapse: collapse;padding-left: 20px;">
                        Name : '.$row["name"].'
                    </td>
                    <td rowspan="3" align="center" >   
                        <span style="font-size:20px; background-color: #b7b4b4">Student\'s Copy</span><br>
                        <img width="150" src="https://chart.googleapis.com/chart?cht=qr&chs=500x500&chl='.FRONT_SITE_PATH.'/webadmin/invoice.php?id='.$invoice_id.'&choe=UTF-8"  width="100" height="100" />
                        <br>Scan QR to verify Payment
                    </td>
                    <td style="text-align:right;border: 1px solid black;border-collapse: collapse;" >
                        Invoice No: #'.$invoice_id.'
                    </td>
                </tr>';
                $html.='
                    <tr width="100%">
                        <td  style="border: 1px solid black;border-collapse: collapse;padding-left: 20px;">
                        Roll : '.$row["class_roll"].'
                        </td>
                        <td style="text-align:right;border: 1px solid black;border-collapse: collapse;" >
                            Created: #'.date("d M Y h:i A",$row["created_at"]).'
                        </td>
                    </tr>';
                    $html.='
                        <tr width="100%">
                            <td style="border: 1px solid black;border-collapse: collapse;padding-left: 20px;" >
                            Dept. : '.$row["dept_name"].'
                            </td>
                            <td style="text-align:right;border: 1px solid black;border-collapse: collapse;" >
                                Printed On: #'.date("d M Y h:i A",time()).'
                            </td>
                        </tr>';
                    } //if ended
                }//while ended
                $html.='
                <tr>
                    <td colspan="3" align="center" style="font-size:20px;border: 0px solid black;border-collapse: collapse;text-align:center;">
                        <span >Monthly Fees</span>
                    </td>
                </tr>';
                $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Fee details</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
                    </tr>';
                    $sql="select payments.*,monthly_payment_details.*,month.id,month.name from payments,monthly_payment_details,month where month.id=monthly_payment_details.month_id and monthly_payment_details.payment_id=payments.id and payments.id='$invoice_id'";
                    $res=mysqli_query($con,$sql);
                    if(mysqli_num_rows($res)>0){
                    $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                            $html.='<tr>
                            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name']." - ".date("y",time()).'</td>
                            <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['monthly_amount'].'</td>
                            </tr>';
                            $total_amount=$row['total_amount'];    
                            $i++;
                        } //while loop ended
                    } else {
                        $html.='
                        <tr>
                            <td colspan="3" align="center" style="border: 1px solid black;border-collapse: collapse;text-align:center;">No data found</td>
                        </tr>';
                    }
                $html.='
                <tr>
                    <td colspan="3" align="center" style="font-size:20px;border: 1px solid black;border-collapse: collapse;text-align:center;">
                        <span >Other Fees</span>
                    </td>
                </tr>';
                $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Fee details</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
                    </tr>';
                $sql="SELECT `fees`.* , fee_details.*,payments.* from payments,fees,fee_details WHERE fees.id=fee_details.fee_id and payments.id=fee_details.payment_id and payments.id='$invoice_id'";
                $res=mysqli_query($con,$sql);
                if(mysqli_num_rows($res)>0){
                    $i=1;
                    while($row=mysqli_fetch_assoc($res)){
                        $html.='
                            <tr>
                                <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                                <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name']." - ".date("y",time()).'</td>
                                <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['fee_amount'].' </td>
                            </tr>';            
                        $i++;       
                        // the while codes
                    } 
                } else {
                    $html.='
                    <tr>
                        <td colspan="3" align="center" style="border: 1px solid black;border-collapse: collapse;text-align:center;">No data found</td>
                    </tr>';
                }
                    $html.='
                    <tr>
                        <td colspan="2" align="right" style="border: 1px solid black;border-collapse: collapse;">Total: </td>
                        <td style="border: 1px solid black;border-collapse: collapse;" align="center">'.$total_amount .' Taka</td>
                    </tr>';
                $html.='
                <tr>
                   <td colspan="3" align="left" style="font-size:13.5px;" >Amount in words (Taka) : ('.numberTowords($total_amount).')</td>
                </tr>';
                $html.='
                <tr>
                    <td colspan="3" style="padding-top:0px;font-size:12px;" align="right"><i><b>Developed By The Web divers</b></i></td>
                </tr>';
                $html.='
                <tr>
                    <td colspan="3" style="padding-top:0px;font-size:20px;" align="center">---------------------------------------------------------------------------------------------</td>
                </tr>';
                $html.='
                    <tr width="100%">
                    </tr>';
                    $sql="select users.id,users.name,users.batch,users.dept_id,users.class_roll,depts.id,depts.name as dept_name, payments.id,payments.user_id,payments.created_at from users,depts, payments where users.id=payments.user_id and users.dept_id=depts.id and payments.id='$invoice_id'";
                    $res=mysqli_query($con,$sql);
                    if(mysqli_num_rows($res)>0){
                        while($row=mysqli_fetch_assoc($res)){
                    $html.='
                        <tr width="100%">
                            <td  style="border: 1px solid black;border-collapse: collapse;padding-left: 20px;">
                                Name : '.$row["name"].'
                            </td>
                            <td rowspan="3" align="center" >   
                                <span style="font-size:10px; background-color: #b7b4b4">Office Copy</span><br>
                                <img width="150" src="https://chart.googleapis.com/chart?cht=qr&chs=500x500&chl='.FRONT_SITE_PATH.'/invoice.php?id='.$invoice_id.'&choe=UTF-8"  width="70" height="70" />
                            </td>
                            <td style="text-align:right;border: 1px solid black;border-collapse: collapse;" >
                                Invoice No: #'.$invoice_id.'
                            </td>
                        </tr>';
                        $html.='
                            <tr width="100%">
                                <td  style="border: 1px solid black;border-collapse: collapse;padding-left: 20px;">
                                Roll : '.$row["class_roll"].'
                                </td>
                                <td style="text-align:right;border: 1px solid black;border-collapse: collapse;" >
                                    Created: #'.date("d M Y h:i A",$row["created_at"]).'
                                </td>
                            </tr>';
                            $html.='
                                <tr width="100%">
                                    <td style="border: 1px solid black;border-collapse: collapse;padding-left: 20px;" >
                                    Dept. : '.$row["dept_name"].'
                                    </td>
                                    <td style="text-align:right;border: 1px solid black;border-collapse: collapse;" >
                                        Printed On: #'.date("d M Y h:i A",time()).'
                                    </td>
                                </tr>';
                            } //if ended
                        }//while ended
                $html.='
                <tr>
                    <td colspan="3" align="center" style="font-size:20px;border: 0px solid black;border-collapse: collapse;text-align:center;">
                        <span >Monthly Fees</span>
                    </td>
                </tr>';
                $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Fee details</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
                    </tr>';
                    $sql="select payments.*,monthly_payment_details.*,month.id,month.name from payments,monthly_payment_details,month where month.id=monthly_payment_details.month_id and monthly_payment_details.payment_id=payments.id and payments.id='$invoice_id'";
                    $res=mysqli_query($con,$sql);
                    if(mysqli_num_rows($res)>0){
                    $i=1;
                    while($row=mysqli_fetch_assoc($res)){
                        $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name']." - ".date("y",time()).'</td>
                        <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['monthly_amount'].'</td>
                        </tr>';
                        $i++;    
                                // the while codes
                    } 
                } else {
                    $html.='
                    <tr>
                       <td colspan="3" align="center">No data found</td>
                    </tr>';
                }
                $html.='
                <tr>
                    <td colspan="3" align="center" style="font-size:20px;border: 1px solid black;border-collapse: collapse;text-align:center;">
                        <span >Other Fees</span>
                    </td>
                </tr>';
                $html.='<tr>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Fee details</td>
                        <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Amount</td>
                    </tr>';
                $sql="SELECT `fees`.* , fee_details.*,payments.* from payments,fees,fee_details WHERE fees.id=fee_details.fee_id and payments.id=fee_details.payment_id and payments.id='$invoice_id'";
                $res=mysqli_query($con,$sql);
                if(mysqli_num_rows($res)>0){
                    $i=1;
                    while($row=mysqli_fetch_assoc($res)){
                        $html.='<tr >
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name']." - ".date("y",time()).'</td>
                                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['fee_amount'].' Taka </td>
                                </tr>';            
                                $i++;       
                                // the while codes
                    } 
                } else {
                    $html.='
                    <tr>
                        <td colspan="3" align="center">No data found</td>
                    </tr>';
                }
                $html.='
                <tr>
                    <td colspan="2" align="right" style="border: 1px solid black;border-collapse: collapse;">Total: </td>
                    <td style="border: 1px solid black;border-collapse: collapse;" align="center">'.$total_amount .' Taka</td>
                </tr>';
                        
	    $html.='</table>';
}else{
    $html.="No data found";
}
$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
	'margin_left' => 20,
	'margin_right' => 20,
	'margin_top' => 2,
	'margin_bottom' => 10,
]);
$mpdf->SetCreator('Dhrubo');
$mpdf->SetAuthor('Dhrubo');
$mpdf->SetTitle('Invoice of Barisal Engineering College Hall Payment');
$mpdf->SetFooter('Developed By The Web divers');
$mpdf->watermarkImageAlpha = 0.1;
$mpdf->WriteHTML($html);
$file=time().'.pdf';
$mpdf->output($file,'I');
// $mpdf->output($file,'D');
send_email("dhruborajroy3@gmail.com","Invoice","Invoice of Payment ".$file,'media/'.$file);
unlink($file);
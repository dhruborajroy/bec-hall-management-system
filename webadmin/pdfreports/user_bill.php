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
$html="";
if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);
    $html='<table  width="100%">';
    $html.='
        <tr>
            <td align="center">                    
                <img width="150" src="./img/logo.jpg" width="100" height="100" />
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
	    $html.='</table>';
	    $html.='<table  width="100%" style="margin-top:10px">';
        $html.='<tr>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Id</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">Name</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">July</td>
                <td style="border: 1px solid black;border-collapse: collapse;background-color: #b7b4b4;text-align:center;">August</td>
            </tr>';
            $user_id=$row['id'];
            for ($i=0; $i <= 12; $i++) {
                $sqll="SELECT (SELECT sum(amount) FROM monthly_bill WHERE month_id = '$i'  and user_id='$user_id') AS july, (SELECT sum(amount) FROM monthly_bill WHERE month_id = '08' and user_id='$user_id') AS august";
            }
                $ress=mysqli_query($con,$sqll);
            if(mysqli_num_rows($ress)>0){
                $i=1;
                while($rows=mysqli_fetch_assoc($ress)){
                    // the while loop
                    $html.='<tr>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$i.'</td>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$row['name'].'</td>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$rows['july'].'</td>
                    <td style="border: 1px solid black;border-collapse: collapse;text-align:center;">'.$rows['august'].'</td>
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
    $html.="";
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
$mpdf->SetTitle('Notice Barisal Engineering College Hall');
$mpdf->SetFooter('Developed By The Web divers');
$mpdf->WriteHTML($html.$sql);
$file=time().'.pdf';
$mpdf->output($file,'I');
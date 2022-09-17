<?php
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
if (isset($_GET['notice_id']) && $_GET['notice_id']!="") {
    $notice_id=get_safe_value($_GET['notice_id']);
}else{
    $_SESSION['PERMISSION_ERROR']=1;
    redirect("index.php");
}
$sql="select * from `notice` where id='$notice_id'";
$res=mysqli_query($con,$sql);
$html="";
if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);
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
        $html.='
            <tr>
                <td align="left" colspan="3" style="height:4">                    
                    <hr>
                </td>
            </tr>';
            $html.='
                <tr>
                    <td align="left">                    
                        স্মারক নং: '.$row['reference'].'
                    </td>
                    <td  align="center">
                    </td>
                    <td  align="center">
                        তারিখ: '.date("d M Y ",($row['added_on'])).'
                    </td>
                </tr>';
                $html.='
                    <tr>
                        <td align="left" colspan="3" align="center" style="padding-top:30px">                    
                        <u style="font-size:35px">'.$row['title'].'</u>
                        </td>
                    </tr>';
                    $html.='
                        <tr >
                            <td align="left" colspan="3" align="center" style="padding-top:10px">                    
                                <p>'.$row['details'].'</p>
                            </td>
                        </tr>';
            $html.='
            <tr>
                <td align="left">                    
                    
                </td>
                <td  align="center">
                </td>
                <td  align="center" style="padding-top:100px">
                <img  src="../img/signature.svg" width="100" height="50" />
                <span style="font-style:30px">
                    <br>
                        <span style="font-size:20px">এম. রহমান </span>
                    <br>
                    হল প্রভোস্ট, অপরাজেয় একাত্তর হল
                    <br>
                    বরিশাল ইঞ্জিনিয়ারিং কলেজ
                </span>
                </td>
            </tr>';
                        
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
$mpdf->WriteHTML($html);
$file=time().'.pdf';
$mpdf->output($file,'I');
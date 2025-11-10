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
                <td align="left" colspan="6" style="height:6px">                    
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



            // Main Body 

            $html.='
            <tr>
                <td align="left" colspan="6" style="font-size:20px">
                    অত্র কলেজের সিভিল/ইইই বিভাগের ছাত্র/ছাত্রী ধ্রুবরাজ রায়, ঢাবি রেজিঃ ৮৬২, শিক্ষাবর্ষ ২০২০-২০২১ এর সকল একাডেমিক কার্যক্রম শেষ হওয়া 
                </td>
            </tr>';     



            $sql="SELECT * FROM `depts_lab_list`";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
                $i=1;
                while($row=mysqli_fetch_assoc($res)){

            $html.='
            <tr align="center">
                <td  colspan="6" align="center" style="font-size:25px">
                    <u>'.$row['name_bn'].'</u>
                </td>
            </tr>';
                        $html.='
                        <tr style="border:1px;">
                            <td align="left" style="table-border:10px;">
                                ক্রমিক
                            </td>
                            <td align="left" >
                                বিভাগ/সপ
                            </td>
                            <td align="left" >
                                দেনা-পাওনা তথ্য
                            </td>
                            <td align="left" >
                                ভারপ্রাপ্ত কর্মকর্তার স্বাক্ষর
                            </td>
                            <td align="left" >
                                ওয়ার্কশপ সুপার/সপ ইনচার্জের স্বাক্ষর
                            </td>
                            <td align="left" >
                                বিভাগীয় প্রধানের স্বাক্ষর
                            </td>
                        </tr>';

                    $lab_sql="SELECT * FROM `lab_list` where dept_id='".$row['id']."'";
                    $lab_res=mysqli_query($con,$lab_sql);
                    $lab_count=mysqli_num_rows($lab_res);
                    if($lab_count>0){
                        $i=1;
                        while($lab_row=mysqli_fetch_assoc($lab_res)){
                        $html.='
                        <tr>
                            <td align="left" >
                                '.$i.'
                            </td>
                            <td align="left" width="40%">
                                '.$lab_row['name'].'
                            </td>
                            <td align="left" >
                                
                            </td>
                            <td align="left" >
                            </td>
                            <td align="left" >
                            </td>
                            <td align="left" rowspan'.$lab_count.'>

                            </td>
                        </tr>';
                        $i++;
                    } 
                    //IF condition ended
                } else {
                    $html.='
                    <tr>
                    <td colspan="8" align="center"></td>
                    </tr>';
                }//else ended
                $i++;
            } 
            //IF condition ended
        } else {
            $html.='
            <tr>
            <td colspan="8" align="center"></td>
            </tr>';
        }//else ended

        $html.='
        <tr >
            <td align="right" colspan="6" style="font-size:20px;padding-top:70px">
                তাঁর নিকট থেকে ___________________ টাকা পাওয়া/ফেরত দেয়া হলো। 
            </td>
        </tr>';
        $html.='
        <tr >
        </tr>';
        $html.='
        <tr >
            <td align="center" colspan="2" style="font-size:20px;padding-top:70px">
                কোষাধ্যক্ষ
            </td>
            <td align="center" colspan="4" style="font-size:20px;padding-top:70px">
                হিসাবরক্ষক
            </td>
        </tr>';
        $html.='
        <tr >
            <td align="center" colspan="6" style="font-size:20px;padding-top:70px"> 
            উপরোক্ত তথ্যের প্রেক্ষিতে তাকে ছাড়পত্র প্রদানের নির্দেশ প্রদান করা হলো। 
            </td>
        </tr>';

        // Main body ended
        
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
// echo $html;
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
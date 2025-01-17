<?php
session_start();
include("../inc/constant.inc.php");
include("../inc/connection.inc.php");
include("../inc/function.inc.php");
require_once("../inc/smtp/class.phpmailer.php");
require('../vendor/autoload.php');
$html='';
$html.='
<style>
#customers {
   font-family: Arial, Helvetica, sans-serif;
   border-collapse: collapse;
   width: 100%;
}

#customers td, #customers th {
   border: 1px solid #ddd;
   padding: 2px;
   width: 50%;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
padding-top: 1px;
padding-bottom: 1px;
text-align: left;
background-color: #04AA6D;
color: white;
}

#title {
   font-family: Arial, Helvetica, sans-serif;
   border-collapse: collapse;
   width: 100%;
   font-size:20px;
   margin-top:20px;
}
#image{
   border-radius: 15px;
   width: 80%;
   max-width: 150px;
   max-height: 150px;
   box-shadow: 0 10px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) !important;
}
#new-page{
   margin-top:90px
}
#heading{
   width:100% !important;
}
</style>';

$res=mysqli_query($con,"select * from users");
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>0){
    while( $row=mysqli_fetch_assoc($res)){
        $name=$row['name'];
        $class_roll=$row['class_roll'];
        $fname=$row['fName'];
        $fOccupation=$row['fOccupation'];
        $mname=$row['mName'];
        $mOccupation=$row['mOccupation'];
        $phoneNumber=$row['phoneNumber'];
        $presentAddress=$row['presentAddress'];
        $permanentAddress=$row['permanentAddress'];
        $dob=$row['dob'];
        $gender=$row['gender'];
        $religion=$row['religion'];
        $ffQuata=$row['ffQuata'];
        $bloodGroup=$row['bloodGroup'];
        $merit=$row['merit'];
        $block=$row['block'];
        $legalGuardianName=$row['legalGuardianName'];
        $legalGuardianRelation=$row['legalGuardianRelation'];
        $image=$row['image'];
        $email=$row['email'];
        $dept_id=$row['dept_id'];
        $room_number=$row['room_number'];
        $examRoll=$row['examRoll'];
        $batch=$row['batch'];

        // start
        // $html.='<table width="100%"  id="new-page">
        // <tr>
        //    <td align="center" style="font-size:36px">'.NAME_BANGLA.'</td>
        // </tr>
        // <tr>
        //    <td align="center" style="font-size:22px;">
        //       '.ADDRESS_BANGLA.'
        //    </td>
        // </tr>
        // <tr>
        //    <td style="font-size:22px" align="center">'.ADDITIONAL_INFO.'</td>
        // </tr>
        // <tr>
        //    <td ><hr></td>
        // </tr>
        // </table>';
        // $html.='<table width="100%">
        // <tr>
        //    <td align="left"><img id="heading" src="../assets/img/heading.png" alt="preview image"></td>
        // </tr>
        // </table>';
        $html.='<table width="100%">
        <tr>
        <td align="center"><img id="image" src="../media/users/'.$image.'" alt="preview image" width="100px" height="100px"></td>
        </tr>
        </table>';
        $html.='<table width="100%">
        <tr>
        <td align="center" id="title">Applicant\'s Info</td>
        </tr>
        </table>';
        $html.='<table id="customers" class="mt-5">
        <tbody>
            <tr>
                <td>Name: </td>
                <td>'.$name.'</td>
        </tbody>
        </table>';
        $html.='<table width="100%">
        <tr>
        <td align="center" id="title">Admission Details</td>
        </tr>
        </table>';
        $html.='<table id="customers">
        <tbody>
            <tr>
                <td>Class Name: </td>
                <td>'.$class.'</td>
            </tr>
            <tr>
                <td>Quota:  </td>
                <td>'.$quota.'</td>
            </tr>
            <tr>
                <td>Blood Group: </td>
                <td>'.$bloodGroup.'</td>
            </tr>
            <tr>
                <td>Religion: </td>
                <td>'.$religion.'</td>
            </tr>
        </tbody>
        </table>';
        // end
    }
}else{
    $html="skn";
}
// echo $html;
$mpdf=new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/custom/temp/dir/path',
    'default_font_size' => 12,
    'default_font' => 'FreeSerif',
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 10,
	'margin_bottom' => 10,
]);
$mpdf->SetTitle('Student Details');
$mpdf->SetFooter('|| Developed By The Web Divers');
$mpdf->SetProtection(array('print'), '', 'MyPassword');
$mpdf->WriteHTML($html);
$file="Student_Details_".time().'.pdf';
$mpdf->output($file,'I');
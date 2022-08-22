<?php 
include("./connection.inc.php");
include("./function.inc.php");
if (isset($_GET['id']) && $_GET['id']!="") {
    $invoice_id=get_safe_value($_GET['id']);
    // $sql="select * from payments where id ='$invoice_id'";
    // $res=mysqli_query($con,$sql);
    // if(mysqli_num_rows($res)>!0){
    //     redirect("index.php");
    // }
}else{
   //  redirect("index.php");
}
?>
<table style="box-sizing:border-box; border:1px solid #c8c8c8;" width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td height="100" colspan="2" align="center">
         <img src="logo.jpg" width="219" height="60" />      
         <hr />
      </td>
   </tr>
   <tr>
      <td height="31" colspan="2" style="padding-left:10px; font-size:20px; font-family:Verdana, Geneva, sans-serif;"><strong>INVOICE</strong></td>
   </tr>
                            <?php
                                 $total_amount="";
                                $sql="select users.id,users.name,users.batch,users.dept_id,users.roll,depts.id,depts.name as dept_name, payments.id,payments.user_id from users,depts, payments where users.id=payments.user_id and users.dept_id=depts.id and payments.id='$invoice_id'";
                                // echo $sql="select users.*,depts.id,depts.name as dept_name,payments.* from users,payments,depts where users.id=payments.user_id and depts.id=users.dept_id and payments.id=$invoice_id";
                                $res=mysqli_query($con,$sql);
                                if(mysqli_num_rows($res)>0){
                                while($row=mysqli_fetch_assoc($res)){
                                ?>
   <tr>
      <td width="61%" height="28">
         <table style="box-sizing:border-box; border:1px solid #c8c8c8; margin:10px;" width="90%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td  width="25%" height="25" style="padding-left:10px; font-family:Verdana, Geneva, sans-serif; border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; font-size:14px;"><strong>Name </strong></td>
               <td width="75%" style="padding-left:10px; font-family:Verdana, Geneva, sans-serif; border-bottom:1px solid #c8c8c8;  font-size:14px;"><?php echo $row['name']?></td>
                              <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $row['total_amount'];?>">
            </tr>
            <tr>
               <td height="25" style="padding-left:10px; font-family:Verdana, Geneva, sans-serif; border-right:1px solid #c8c8c8;  font-size:14px;"><strong>Roll</strong></td>
               <td style="padding-left:10px; font-family:Verdana, Geneva, sans-serif;  font-size:14px;"><?php echo $row['roll']?></td>
            </tr>
            <tr>
               <td height="25" style="padding-left:10px; font-family:Verdana, Geneva, sans-serif; border-right:1px solid #c8c8c8; border-top:1px solid #c8c8c8;  font-size:14px;"><strong>Mobile</strong></td>
               <td style="padding-left:10px; font-family:Verdana, Geneva, sans-serif; border-top:1px solid #c8c8c8;  font-size:14px;">+91-88888888888</td>
            </tr>
         </table>
      </td>
      <td width="39%" align="right">
         <table style="box-sizing:border-box; border:1px solid #c8c8c8; margin:10px;" width="80%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td height="25" align="right" style="padding-right:10px; font-family:Verdana, Geneva, sans-serif; border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; font-size:14px;"><strong>Order ID</strong> : #3DRT567</td>
            </tr>
            <tr>
               <td height="25" align="right" style="padding-right:10px; font-family:Verdana, Geneva, sans-serif; border-right:1px solid #c8c8c8;  font-size:14px;"><strong>Created </strong> : #<?php echo date("d M Y h:i A",time());?></td>
            </tr>
         </table>
      </td>
   </tr>
   <?php }}?>
   <tr>
      <td height="28" colspan="2"> </td>
   </tr>
   <tr>
      <td style="padding:10px;" height="28" colspan="2">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td width="13%" height="28" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-left:#c8c8c8 1px solid; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>S.N</strong></td>
               <td width="22%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>DESCRIPTION </strong></td>
               <td width="26%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>AMOUNT</strong></td>
               <!-- <td width="20%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>QUATITY</strong></td> -->
               <!-- <td width="19%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>TOTAL AMOUNT</strong></td> -->
            </tr>
            <?php
            $sql="select payments.*,monthly_payment_details.*,month.id,month.name from payments,monthly_payment_details,month where month.id=monthly_payment_details.month_id and monthly_payment_details.payment_id=payments.id and payments.id='$invoice_id'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
            while($row=mysqli_fetch_assoc($res)){
            ?>
            <tr>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-left:#c8c8c8 1px solid" height="28" align="center">1</td>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center"><?php echo $row['name']." - ".date("y",time())?></td>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center"><span class="amount"><?php echo $row['monthly_amount']?></span> Taka</td>
               <!-- <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center">1</td> -->
               <!-- <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center">500</td> -->
            </tr>
            <?php 
            } } else { //redirect("index.php") ?>
               <tr>
                   <td colspan="5" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center">No data found</td>
               </tr>
               <?php } ?>

         </table>
      </td>
   </tr>
   <tr>
      <td style="padding:10px;" height="28" colspan="2">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td width="13%" height="28" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-left:#c8c8c8 1px solid; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>S.N</strong></td>
               <td width="22%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>DESCRIPTION </strong></td>
               <td width="26%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>AMOUNT</strong></td>
               <!-- <td width="20%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>QUATITY</strong></td> -->
               <!-- <td width="19%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:#c8c8c8 1px solid; font-family:Verdana, Geneva, sans-serif; font-size:13px;"><strong>TOTAL AMOUNT</strong></td> -->
            </tr>
            <?php
            $sql="SELECT `fees`.* , fee_details.*,payments.* from payments,fees,fee_details WHERE fees.id=fee_details.fee_id and payments.id=fee_details.payment_id and payments.id='$invoice_id'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
            $i=1;
            while($row=mysqli_fetch_assoc($res)){
            ?>
            <tr>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-left:#c8c8c8 1px solid" height="28" align="center">1</td>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center"><?php echo $row['name']." - ".date("y",time())?></td>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center"><span class="amount"><?php echo $row['fee_amount']?></span> Taka</td>
               <!-- <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center">1</td> -->
               <!-- <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center">500</td> -->
            </tr>
            <?php 
            } } else { //redirect("index.php") ?>
               <tr>
                   <td colspan="5" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;" align="center">No data found</td>
               </tr>
               <?php } ?>
         </table>
      </td>
   </tr>
   <tr>
      <td style="padding:10px;" height="28"> </td>
      <td style="padding:10px;" height="28">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:1px solid #c8c8c8; border-left:1px solid #c8c8c8; font-family:Verdana, Geneva, sans-serif; font-size:13px; padding-left:10px;" width="51%" height="29"><strong>Total Amount</strong></td>
               <td width="49%" align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-top:1px solid #c8c8c8;">6000</td>
            </tr>
            <tr>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-left:1px solid #c8c8c8; font-family:Verdana, Geneva, sans-serif; font-size:13px; padding-left:10px;" height="29"><strong>GST </strong></td>
               <td align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;">200</td>
            </tr>
            <tr>
               <td style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8; border-left:1px solid #c8c8c8; font-family:Verdana, Geneva, sans-serif; font-size:13px; padding-left:10px;" height="29"><strong>Total Amount</strong></td>
               <td align="center" style="border-bottom:1px solid #c8c8c8; border-right:1px solid #c8c8c8;"><span id="grant_total"></span></td>
            </tr>
         </table>
      </td>
   </tr>
   <tr>
      <td height="28" colspan="2"> </td>
   </tr>
   <tr>
      <td style="font-family:Verdana, Geneva, sans-serif; font-size:13px;" height="28" colspan="2" align="center">
         <strong>Company Name</strong>
         <br>
         ABC AREA
         <br>
         Tel: +00 000 000 0000 | Email: info@companyname.com
         <br>
         Company Registered in Country Name. Company Reg. 12121212.
         <br>
         VAT Registration No. 021021021 | ATOL No. 1234
      </td>
   </tr>
   <tr>
      <td height="28" colspan="2"> </td>
   </tr>
</table>
<script>
window.addEventListener('load', function() {
    window.print();
});
var total = 0;
var amount = document.getElementsByClassName("amount");
for (let i = 0; i < amount.length; i++) {
    var total = total + parseInt(amount[i].innerHTML);
}
console.log(total);
document.getElementById("grant_total").innerHTML = total;
</script>
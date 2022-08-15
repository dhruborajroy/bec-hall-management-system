<?php 
include("./inc/connection.inc.php");
include("./inc/function.inc.php");
if (isset($_GET['id']) && $_GET['id']!="") {
    $invoice_id=get_safe_value($_GET['id']);
    // $sql="select * from payments where id ='$invoice_id'";
    // $res=mysqli_query($con,$sql);
    // if(mysqli_num_rows($res)>!0){
    //     redirect("index.php");
    // }
}else{
    redirect("index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>BEC Invoice</title>
    <link rel="stylesheet" href="./css/invoice.css">
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="./hall/img/invoiceLogo.png" style="width: 100%; height:150px" />
                                <!-- max-width: 300px -->
                            </td>
                            <td>
                                Invoice ID #: <?php echo $invoice_id?><br />
                                Created: <?php echo date("d M Y h:i A",time());?><br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>

                            <?php
                                $sql="select users.id,users.name,users.batch,users.dept_id,users.roll,depts.id,depts.name as dept_name, payments.id,payments.user_id from users,depts, payments where users.id=payments.user_id and users.dept_id=depts.id and payments.id='$invoice_id'";
                                // echo $sql="select users.*,depts.id,depts.name as dept_name,payments.* from users,payments,depts where users.id=payments.user_id and depts.id=users.dept_id and payments.id=$invoice_id";
                                $res=mysqli_query($con,$sql);
                                if(mysqli_num_rows($res)>0){
                                while($row=mysqli_fetch_assoc($res)){
                                ?>
                            <td>
                                <b>Name : </b> <?php echo $row['name']?><br>
                                <b>ID : </b> <?php echo $row['roll']?><br>
                                <b>Dept : </b><?php echo $row['dept_name']?><br>
                                <b>Barch : </b> <?php echo $row['batch']?><sup>th</sup> Bath

                            </td>
                            <?php }}?>
                            <td>
                                <img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=https://localhost/bec-hall/invoice.php?id=<?php echo $invoice_id?>"
                                    alt="QR Code" height="150px" width="150px">
                                <br>
                                <!-- https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=https://localhost/bec-hall/invoice.php -->
                                <p style="margin-top: -25px;">Scan Qr Code to verify Payment</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Monthly Payment</td>
                <td>Price</td>
            </tr>
            <?php
            $sql="select payments.*,monthly_payment_details.*,month.id,month.name from payments,monthly_payment_details,month where month.id=monthly_payment_details.month_id and monthly_payment_details.payment_id=payments.id and payments.id='$invoice_id'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
            while($row=mysqli_fetch_assoc($res)){
            ?>
            <tr class="item">
                <td><?php echo $row['name']." - ".date("y",time())?></td>
                <td><span class="amount"><?php echo $row['monthly_amount']?></span> Taka</td>
            </tr>
            <?php 
            } } else { //redirect("index.php") ?>
            <tr>
                <td colspan="5">No data found</td>
            </tr>
            <?php } ?>
            <tr class="heading">
                <td>Fee Payment</td>
                <td>Price</td>
            </tr>
            <?php 
            $sql="SELECT `fees`.* , fee_details.*,payments.* from payments,fees,fee_details WHERE fees.id=fee_details.fee_id and payments.id=fee_details.payment_id and payments.id='$invoice_id'";
            $res=mysqli_query($con,$sql);
            if(mysqli_num_rows($res)>0){
            $i=1;
            while($row=mysqli_fetch_assoc($res)){
            ?>
            <tr class="item">
                <td><?php echo $row['name']." - ".date("y",time())?></td>
                <td><span class="amount"><?php echo $row['fee_amount']?></span> Taka</td>
            </tr>
            <?php 
            $i++;
            } } else { ?>
            <tr>
                <td colspan="5">No data found</td>
            </tr>
            <?php } ?>
            <tr class="total">
                <td></td>
                <td><b>Total:</b> <span id="grant_total"></span> Taka</td>
            </tr>
        </table>
    </div>
</body>

</html>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
window.addEventListener('load', function() {
    window.print();
})

var total = 0;
var amount = document.getElementsByClassName("amount");
for (let i = 0; i < amount.length; i++) {
    var total = total + parseInt(amount[i].innerHTML);
}
console.log(total);
document.getElementById("grant_total").innerHTML = total;
</script>
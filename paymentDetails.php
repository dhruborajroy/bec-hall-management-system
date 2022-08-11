<?php 
include('header.php');
if (isset($_GET['id']) && $_GET['id']!="") {
    $invoice_id=get_safe_value($_GET['id']);
    // $sql="select * from payments where id ='$invoice_id'";
    // $res=mysqli_query($con,$sql);
    // if(mysqli_num_rows($res)>!0){
    //     redirect("index.php");
    // }
}else{
    // redirect("index.php");
}
?>
<!-- Page Area Start Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <!-- <h3>Parents</h3>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>All Buses</li>
            </ul> -->
    </div>
    <!-- Breadcubs Area End Here -->

    <div class="card height-auto">
        <div class="card-body">
            <table class="table  table-striped" cellpadding="0" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="thead-dark">
                        <td>Monthly Payment</td>
                        <td>Price</td>
                    </tr>
                </thead>
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
            </table>
            <table class="table  table-striped" cellpadding="0" cellspacing="0">
                <thead class="thead-dark">
                    <tr class="thead-dark">
                        <td>Fee Payment</td>
                        <td>Price</td>
                    </tr>
                </thead>
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
            </table>

        </div>
    </div>

    <?php include('footer.php');?>
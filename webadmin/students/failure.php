<?php 
include("header.php");
$val_id="";
$tran_id=$_POST['tran_id'];
$amount=$_POST['amount'];
$card_type=$_POST['card_type'];
$tran_date=$_POST['tran_date'];
$card_issuer=$_POST['card_issuer'];
$card_no=$_POST['card_no'];
$error=$_POST['error'];
$status=$_POST['status'];
if(isset($_POST['status'])){
    $sql="INSERT INTO `online_payment`(`tran_id`, `val_id`, `amount`, `card_type`, `tran_date`, `card_issuer`, `card_no`, `error`, `status`) VALUES 
                                            ('$tran_id','$val_id','$amount','$card_type','$tran_date','$card_issuer','$card_no','$error','$status')";   
    if ($status=="FAILED") {
        $swl="update `payments` set `paid_status`='0' where `tran_id`='$tran_id'";
        mysqli_query($con,$swl);
    }
    mysqli_query($con,$sql);
}
?>

<!-- Page Area Start Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Dining Committee</h3>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>Dining Committee</li>
            </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Students Data</h3>
                </div>
            </div>
            <form class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <input type="text" placeholder="Search by ID/ Name/ Number ..." class="form-control"
                            id="myInput">
                    </div>
                </div>
            </form>
            <div class="table-responsive">
            </div>
        </div>
    </div>
    <!-- Teacher Table Area End Here -->
<?php include('footer.php')?>
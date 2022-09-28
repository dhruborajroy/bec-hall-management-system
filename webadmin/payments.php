<?php 
include('header.php');
if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
	$type=get_safe_value($_GET['type']);
	$id=get_safe_value($_GET['id']);
	// if($type=='delete'){
	// 	mysqli_query($con,"delete from applicants where id='$id'");
	// 	redirect('bus.php');
	// }
	if($type=='active' || $type=='deactive'){
		$status=1;
		if($type=='deactive'){
			$status=0;
		}
		mysqli_query($con,"update payments set status='$status' where id='$id'");
        $_SESSION['UPDATE']=1;
        redirect('./payments.php');
	}

}
$sql="select bkash_online_payment.*, applicants.first_name, applicants.last_name  from bkash_online_payment,applicants where bkash_online_payment.user_id=applicants.id";
$res=mysqli_query($con,$sql);
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
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Students Data</h3>
                </div>
                <div class="dropdown show">
                    <a class="dropdown-toggle" href="../pdf/list.php" aria-expanded="true">Generate PDF</a>
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
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Order ID</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>TrxID</th>
                            <th>Status</th>
                            <th>Refund</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                    <?php if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                        <tr role="row" class="odd">
                            <td class="sorting_1 dtr-control"><?php echo $i?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['tran_id']?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['first_name']." ".$row['last_name']?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['amount']?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['trxID']?></td>
                            <?php if($row['status']=="Completed"){?>
                                <td class="dtr-control badge badge-pill badge-success d-block mg-t-8"><?php echo $row['status']?></td>
                            <?php }elseif($row['status']=="Failed"){?>
                                <td class="badge badge-pill badge-danger d-block mg-t-8"><?php echo $row['status']?></td>
                            <?php }else{?>
                                <td class="badge badge-pill badge-warning d-block mg-t-8"><?php echo $row['status']?></td>
                            <?php }?>
                            <?php if($row['status']=="Completed"){?>
                                <td ><a class="dtr-control badge badge-pill badge-success d-block mg-t-8" href="refundPayment?payment_id=<?php echo $row['tran_id']?>" class="invoice-no">Refund</a></td>
                            <?php }else{?>
                                <td><span  class="badge badge-pill badge-warning d-block mg-t-8"><?php echo $row['statusMessage']?></span></td>
                            <?php }?>
                                
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
    </div>
    <!-- Teacher Table Area End Here -->
    <?php include('footer.php');?>
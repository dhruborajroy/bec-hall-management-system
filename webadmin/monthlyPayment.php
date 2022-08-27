<?php include('header.php');
if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
	$type=get_safe_value($_GET['type']);
	$id=get_safe_value($_GET['id']);
	if($type=='delete'){
		mysqli_query($con,"delete from monthly_bill where id='$id'");
		redirect('monthlyPayment.php');
	}
	if($type=='active' || $type=='deactive'){
		$status=1;
		if($type=='deactive'){
			$status=0;
		}
        $_SESSION['UPDATE']=1;
		mysqli_query($con,"update monthly_bill set status='$status' where id='$id'");
        redirect('./monthlyPayment.php');
	}
}
$sql="select monthly_bill.*, users.name, users.id as uid from monthly_bill, users where monthly_bill.user_id=users.id order by id desc;";
$res=mysqli_query($con,$sql);
?>
<!-- Page Area Start Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Fee</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Fees</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Fees Data</h3>
                </div>
                <?php
                $last_date=cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                $date=getdate();
                if($date['mday']==$last_date){
                ?>
                <div class="dropdown show">
                    <button type="button" class="">Last generated <?php $reos=mysqli_query($con,"select * from general_informations"); if(mysqli_num_rows($reos)>0){ $rowww=mysqli_fetch_assoc($reos); echo date("d-M-Y h:i:s",$rowww['last_bill_generated']);}?></button>
                    <a href="generateMonthlyBill.php">
                        <button type="button" class="btn-fill-lmd  text-light shadow-dark-pastel-green bg-dark-pastel-green">Generate Monthly Bill</button>
                    </a>
                </div>
                <?php }?>
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
                            <th>Amount</th>
                            <th>Student</th>
                            <th>Month</th>
                            <th>Paid Status</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                        <tr role="row" class="odd">
                            <td class="sorting_1 dtr-control"><?php echo $i?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['amount']?> Taka</td>
                            <td class="sorting_1 dtr-control"><?php echo $row['name']?></td>
                            <td class="sorting_1 dtr-control"><?php echo date("F - y",strtotime($row['year']."-".$row['month_id']));?></td>
                            <td class="sorting_1 dtr-control">
                                <?php if($row['paid_status']==0){?>
                                    <a href="managePayment.php?id=<?php echo $row['uid']?>">
                                        <button type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-red">Unpaid</button>
                                    </a>
                                <?php }elseif($row['paid_status']==1){?>
                                    <!-- <a href="invoice.php?id=<?php //echo $row['id']?>"> -->
                                        <button type="button" class="btn-fill-lmd radius-30 text-light shadow-dodger-blue bg-dark-pastel-green">Paid</button>
                                    <!-- </a> -->
                                <?php }?>
                            </td>
                        </tr>
                        <?php 
                           $i++;
                           } } else { ?>
                        <tr>
                            <td colspan="5">No data found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Teacher Table Area End Here -->
    <?php include('footer.php');?>
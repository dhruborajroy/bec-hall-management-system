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
		// mysqli_query($con,"update users set status='$status' where id='$id'");
        redirect('./makePayments.php');
	}
}if($_GET['id']==0){
    $_SESSION['PERMISSION_ERROR']=1;
    redirect("index.php");
}
$sql="select * from users order by id desc";
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
                <div class="item-title">
                    <form action="./pdfreports/collection.php">
                    <div class="row">
                        <select name="month_id" class="select2">
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <input type="submit" value="Generate report">
                    </div>
                    </form>
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
                            <th>Name</th>
                            <th>Number</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                        <tr role="row" class="odd">
                            <td class="sorting_1 dtr-control"><?php echo $row['roll']?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['name']?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['phoneNumber']?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['email']?></td>
                            <td>

                                <div class="ui-btn-wrap">
                                    <ul>
                                        <li><a href="managePayment.php?id=<?php echo $row['id']?>"><button type="button"
                                                class="btn-fill-lmd  text-light shadow-dark-pastel-green bg-dark-pastel-green">Payment</button></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
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
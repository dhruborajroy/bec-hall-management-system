<?php include('header.php');
$uid=$_SESSION['USER_ID'];
$sql="select `role` from `users` where id='$uid'";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);
if($row['role']!=4){
    $_SESSION['PERMISSION_ERROR']=true;
    redirect("index.php");
}
if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
	$type=get_safe_value($_GET['type']);
	$id=get_safe_value($_GET['id']);
	// if($type=='delete'){
	// 	mysqli_query($con,"delete from depts where id='$id'");
	// 	redirect('bus.php');
	// }
	if($type=='active' || $type=='deactive'){
		$status=1;
		if($type=='deactive'){
			$status=0;
		}
		mysqli_query($con,"update expense set status='$status' where id='$id'");
        redirect('./expense.php');
	}

}
?>
<!-- Page Area Start Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <!-- <h3>Parents</h3>
            <ul>
                <li>
                    <a href="index-2.html">Home</a>
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
                    <h3>applicants Data</h3>
                </div>
                <div class="item-title">
                    <form action="../webadmin/pdfreports/expense.php">
                    <div class="row">
                        <select name="month_id">
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
                        <select name="year" >
                            <?php
                            for ($i=date("Y"); $i >=2021 ; $i--) { 
                            ?>  
                                <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php }?>
                        </select>
                        <input type="submit" value="Generate report">
                    </div>
                    </form>
                </div>
            </div>
            <form class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <input type="text" placeholder="Search by ID ..." class="form-control" id="myInput">
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Expense Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php
                        $sql="select expense.*,expense_category.name from expense,expense_category WHERE expense.expense_category_id=expense_category.id order by expense.date_id DeSC";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                        <tr role="row" class="odd">
                            <td class="sorting_1 dtr-control"><?php echo $i?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['amount']?> Taka</td>
                            <td class="sorting_1 dtr-control"><?php echo date("d-M Y",strtotime($row['date_id']."-".$row['month']."-".$row['year']))?></td>
                            <td class="sorting_1 dtr-control"><?php echo $row['name']?></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="flaticon-more-button-of-three-dots"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <!-- <a class="dropdown-item" href="#"><i
                                                class="fas fa-times text-orange-red"></i>Close</a> -->
                                        <a class="dropdown-item"
                                            href="manageExpense.php?id=<?php echo $row['id']?>"><i
                                                class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                        <!-- <a class="dropdown-item" href="#"><i
                                                class="fas fa-redo-alt text-orange-peel"></i>Refresh</a> -->
                                    </div>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Teacher Table Area End Here -->
    <?php include('footer.php');?>
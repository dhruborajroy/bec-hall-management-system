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
}
?>
<!-- Page Area Start Here -->
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Payments</h3>
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>Payments</li>
            </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Teacher Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>All Students' Data</h3>
                </div>
                <div class="item-title">
                    <a href="./pdfreports/user_bill.php">Generate Bill</a>
                    <form action="./pdfreports/monthly_bill.php">
                    <div class="row">
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Select Month</label>
                                <select class="form-control select2" name="month_id">
                                    <?php
                                        for ($month_id = 1; $month_id <= 12; $month_id++) {
                                            $monthName = date("F", mktime(0, 0, 0, $month_id, 1)); // Get the month name
                                            $formattedMonthId = sprintf("%02d", $month_id);
                                            $currentMonth = date("m"); // Get the current month number
                                            // Check if the current month matches the looped month
                                            $selected = ($formattedMonthId == $currentMonth) ? "selected" : "";
                                            echo "<option value=\"$formattedMonthId\" $selected>$monthName</option>";
                                        }  
                                        ?>
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label>Select year</label>
                                <select class="select2" name="year" required>
                                    <?php
                                    $currentYear = date("Y"); // Get the current year
                                    for ($option_year = $currentYear; $option_year >= 2022; $option_year--) {
                                        echo "<option value=\"$option_year\">$option_year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        <input type="submit" value="Generate report">
                    </div>
                    </form>
                </div>
            </div>
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
                        <?php   
                        $sql="select * from users order by id desc";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
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
<?php include("header.php");
$uid=$_SESSION['USER_ID'];
$sql="select `role` from `users` where id='$uid'";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);
if($row['role']!=2){
    $_SESSION['PERMISSION_ERROR']=true;
    redirect("index.php");
}
if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
	$type=get_safe_value($_GET['type']);
	$id=get_safe_value($_GET['id']);
	$current_meal_status=get_safe_value($_GET['current_meal_status']);
	if($type=='approve' || $type=='decline'){
		if($type=='approve'){
            if($current_meal_status==0){
                $meal_request_status=1;
            }elseif($current_meal_status==1){
                $meal_request_status=0;
            }
            $sql="update users set meal_status='$meal_request_status', meal_request_pending='0', meal_request_status='$current_meal_status'  where id='$id'";
            mysqli_query($con,$sql);
            redirect("mealOnOffRequests.php");
		}elseif($type=='decline'){
            if($current_meal_status==0){
                $meal_request_status=1;
            }elseif($current_meal_status==1){
                $meal_request_status=0;
            }
            $sql="update users set meal_status='$current_meal_status', meal_request_pending='0', meal_request_status='$meal_request_status'  where id='$id'";
            mysqli_query($con,$sql);
            redirect("mealOnOffRequests.php");
		}
	}
}
?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Students</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Meal On Off Requests</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Student Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Meal On Off Requests</h3>
                </div>
            </div>
            <form class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <input type="text" onkeyup="myFunction()" placeholder="Search by Roll ..." class="form-control"
                            id="myInput">
                    </div>
                    <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Roll</th>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Current Meal Status</th>
                            <th>Requested Meal Status</th>
                            <th>Dept.</th>
                            <th>
                                <div >
                                    <label class="form-check-label">status</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <?php 
                        $sql="SELECT * from users where meal_request_pending='1'";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                        <tr>
                            <td><?php echo $row['roll']?></td>
                            <td><?php echo $row['name']?></td>
                            <td><?php echo $row['batch']?></td>
                            <td><?php if($row['meal_status']==1){echo "On";}elseif($row['meal_status']==0){echo "Off";}?></td>
                            <td><?php if($row['meal_request_status']==1){echo "On";}elseif($row['meal_request_status']==0){echo "Off";}?></td>
                            <td><?php echo $row['dept_id']?></td>
                            <td>
                                <div class="ui-btn-wrap">
                                    <ul>
                                        <li>
                                            <a href="?id=<?php echo $row['id']?>&type=approve&current_meal_status=<?php echo $row['meal_status']?>">
                                                <button type="button"
                                                    class="btn-fill-lmd  text-light shadow-dark-pastel-green bg-dark-pastel-green">Approve</button>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="?id=<?php echo $row['id']?>&type=decline&current_meal_status=<?php echo $row['meal_status']?>">
                                                <button type="button"
                                                    class="btn-fill-xl  text-light shadow-orange-red bg-orange-red">Decline</button>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php 
                           $i++;
                           } } else { ?>
                        <tr>
                            <td colspan="7" align="center">No data found</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Student Table Area End Here -->
    <?php include("footer.php")?>

    <script>
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    </script>
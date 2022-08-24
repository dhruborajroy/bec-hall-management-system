<?php include("header.php");
$role_name="";
$value="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from `roles` where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $role_name=$row['role_name'];
        $value=$row['value'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
	$role_name=get_safe_value($_POST['role_name']);
	$value=get_safe_value($_POST['value']);
   if($id==''){
        $sql="INSERT INTO `roles` ( `role_name`, `value`,`status`) VALUES 
                                    ( '$role_name', '$value', '1')";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `roles` set  `role_name`='$role_name', `value`='$value'  where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    // echo $sql;
    // redirect('./role');
}

?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Admin Dashboard</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Admin</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row">
        <!-- Add Notice Area Start Here -->
        <div class="col-4-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Create A Notice</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <form id="validate" class="new-added-form" method="post">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Role Name</label>
                                <input type="text" required class="form-control" name="role_name" id="role_name"
                                    value="<?php echo $role_name?>">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Role Value</label>
                                <input type="text" required class="form-control" name="value" id="value"
                                    value="<?php echo $value?>">
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <input type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark"
                                    name="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Notice Area End Here -->
    </div>
    <?php include("footer.php")?>
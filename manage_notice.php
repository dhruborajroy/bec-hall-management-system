<?php include("header.php");
$title="";
$user_id="";
$details="";
$added_on="";
$id="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from `notice` where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $title=$row['title'];
        $details=$row['details'];
        $added_on=$row['added_on'];
    }else{
        redirect("index.php");
    }
}
if(isset($_POST['submit']) && isset($_POST['csrf_token']) ){
    if($_POST['csrf_token']!=$_SESSION['csrf_token']){
        // die("You don't have permission to access that location");
    }
    // pr($_POST);
	$title=get_safe_value($_POST['title']);
	$details=$_POST['details'];
    $user_id=$_SESSION['ADMIN_ID'];
    $added_on=time();
   if($id==''){
        $id=uniqid();
        
        $sql="INSERT INTO `notice` (`id`, `title`, `details`, `added_on`,`updated_on`, `user_id`, `status`) VALUES 
                                    ('$id', '$title', '$details', '$added_on', '','$user_id', '1')";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $updated_on=time();
        $sql="update `notice` set  `title`='$title', `details`='$details',`updated_on`='$updated_on' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    // echo $sql;
    redirect('./notices');
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
                    <form class="new-added-form validate" id="validate" method="post">
                        <?php echo form_csrf()?>
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Title</label>
                                <input type="text" placeholder="" class="form-control" name="title"
                                    value="<?php echo $title?>">
                            </div>
                            <div class="col-12-xxxl col-lg-12 col-12 form-group">
                                <label>Details</label>
                                <textarea type="text" placeholder="" class="form-control" name="details"
                                    id="editor"><?php echo $details?></textarea>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark"
                                    name="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Add Notice Area End Here -->
    </div>
    <?php include("footer.php")?>
<?php include("header.php");
$id="";
$name="";
$sub_code="";
$full_mark="";
$msg="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from `subjects` where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        $sub_code=$row['sub_code'];
        $full_mark=$row['full_mark'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
	$name=get_safe_value($_POST['name']);
	$sub_code=get_safe_value($_POST['sub_code']);
	$full_mark=$_POST['full_mark'];
   if($id==''){
        $sql="INSERT INTO `subjects` ( `name`, `sub_code`, `full_mark`, `status`) VALUES 
                                    ( '$name', '$sub_code','$full_mark', '1')";
        if(mysqli_query($con,$sql)){
            $_SESSION['INSERT']=1;
            $msg="Done";
        }else{
            $msg="Something Went wrong";
        }
    }else{
        $updated_on=time();
        $sql="update `subjects` set  `name`='$name', `sub_code`='$sub_code',`full_mark`='$full_mark' where id='$id'";
        if(mysqli_query($con,$sql)){
            $_SESSION['UPDATE']=1;
            $msg="Done";
        }else{
            $msg="Something Went wrong";
        }
    }
    // echo $sql;
    redirect('./subjects');
}

?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Notice board</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Notices </li>
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
                            <?php echo $msg?>
                        </div>
                    </div>
                    <form id="validate" class="new-added-form" method="post">
                        <div class="row">
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Reference No</label>
                                <input type="text" required placeholder="" class="form-control" name="name" id="name"
                                    value="<?php echo $name?>">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Subject Code</label>
                                <input type="text" required placeholder="" class="form-control" name="sub_code" id="sub_code"
                                    value="<?php echo $sub_code?>">
                            </div>
                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                <label>Full Mark</label>
                                <input type="text" required placeholder="" class="form-control" name="full_mark" id="full_mark"
                                    value="<?php echo $full_mark?>" min="0" max="100">
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
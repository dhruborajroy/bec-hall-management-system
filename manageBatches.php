<?php include('header.php');
$id="";
$numaric_value='';
$name='';
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from batch where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $numaric_value=$row['numaric_value'];
        $name=$row['name'];
    }else{
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
	$numaric_value=get_safe_value($_POST['numaric_value']);
	$name=get_safe_value($_POST['name']);
   if($id==''){
        $sql="INSERT INTO `batch` (`name`, `numaric_value`,`status`) VALUES ( '$name', '$numaric_value', 1)";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `batch` set  `name`='$name', `numaric_value`='$numaric_value' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    redirect('./batches.php');
}
?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
    </div>
    <!-- Breadcubs Area End Here -->

    <!-- Add Class Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add New Depertment</h3>
                </div>
            </div>
            <form class="new-added-form" method="post">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Batch Name *</label>
                        <input type="text" placeholder="Enter Batch name" value="<?php echo $name?>" name="name"
                            class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Numaric value of batch</label>
                        <input type="text" placeholder="Numaric value of batch" value="<?php echo $numaric_value?>"
                            name="numaric_value" class="form-control">
                    </div>
                    <div class="col-md-6 form-group"></div>
                    <div class="col-12 form-group mg-t-8">
                        <button name="submit" type="submit"
                            class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Class Area End Here -->
    <?php include('footer.php');?>
<?php include('header.php');
$id="";
$short_form='';
$name='';
if(isset($_GET['id']) && $_GET['id']>0 && $_GET['id']!=""){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from depts where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $short_form=$row['short_form'];
        $name=$row['name'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){  
    // pr($_POST);
	$short_form=get_safe_value($_POST['short_form']);
	$name=get_safe_value($_POST['name']);
   if($id==''){
        $sql="INSERT INTO `depts` (`name`, `short_form`,`status`) VALUES ( '$name', '$short_form', 1)";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `depts` set  `name`='$name', `short_form`='$short_form' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    redirect('./depts.php');
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
                        <label>Department Name *</label>
                        <input type="text" placeholder="Enter Department name" value="<?php echo $name?>"
                            name="name" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Short Form of Department</label>
                        <input type="text" placeholder="Enter value of Short Form"
                            value="<?php echo $short_form?>" name="short_form" class="form-control">
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
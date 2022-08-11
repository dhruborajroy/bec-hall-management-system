<?php include('header.php');
$id="";
$name='';
$amount='';
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	$row=mysqli_fetch_assoc(mysqli_query($con,"select * from fees where id='$id'"));
	$amount=$row['amount'];
	$name=$row['name'];
}
if(isset($_POST['submit'])){  
    // pr($_POST);
	$amount=get_safe_value($_POST['amount']);
	$name=get_safe_value($_POST['name']);
   if($id==''){
        $sql="INSERT INTO `fees` (`name`, `amount`,`status`) VALUES ( '$name', '$amount', 1)";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `fees` set  `name`='$name', `amount`='$amount' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    redirect('./fees.php');
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
                    <h3>Add New Fees</h3>
                </div>
            </div>
            <form class="new-added-form" method="post">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Fee's Name *</label>
                        <input type="text" placeholder="Enter fee's name" value="<?php echo $name?>" name="name"
                            class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Amount </label>
                        <input type="number" placeholder="Enter amount" value="<?php echo $amount?>" name="amount"
                            class="form-control">
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
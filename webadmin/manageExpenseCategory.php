<?php include('header.php');
$id="";
$name='';
$amount='';
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	$row=mysqli_fetch_assoc(mysqli_query($con,"select * from expense_category where id='$id'"));
	$name=$row['name'];
}
if(isset($_POST['submit'])){
	$name=get_safe_value($_POST['name']);
   if($id==''){
        $sql="INSERT INTO `expense_category` (`name`, `status`) VALUES ( '$name',  1)";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `expense_category` set  `name`='$name' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    // echo $sql;
    redirect('./expenseCategory.php');
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
            <form id="validate" class="new-added-form" method="post">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Expense category name *</label>
                        <input type="text" placeholder="Enter expense category name" value="<?php echo $name?>" name="name" id="name"
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
<?php include('header.php');
$id="";
$name='';
$show_payment_page="0";
$every_month="0";
$amount='';
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from fees where id='$id'");
    if(mysqli_num_rows($res)){
        $row=mysqli_fetch_assoc($res);
        $amount=$row['amount'];
        $name=$row['name'];
        $show_payment_page=$row['show_payment_page'];
        $every_month=$row['every_month'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect('index.php');
    }
}
if(isset($_POST['submit'])){  
    // prx($_POST);
	$amount=get_safe_value($_POST['amount']);
	$name=get_safe_value($_POST['name']);
    if(isset($_POST['every_month'])){
        $every_month=get_safe_value($_POST['every_month']);
        if($every_month=='on'){
            $every_month='1';
        }
    }else{
        $every_month='0';
    }
    if(isset($_POST['show_payment_page'])){
        $show_payment_page=get_safe_value($_POST['show_payment_page']);
        if($show_payment_page=='on'){
            $show_payment_page='1';
        }
    }else{
        $show_payment_page='0';
    }
   if($id==''){
        $sql="INSERT INTO `fees` (`name`, `amount`,`every_month`,`show_payment_page`,`status`) VALUES ( '$name', '$amount', '$every_month', '$show_payment_page', 1)";
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `fees` set  `name`='$name', `amount`='$amount' , `show_payment_page`='$show_payment_page' , `every_month`='$every_month' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
    }
    // echo $sql;
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
            <form id="validate" class="new-added-form" method="post">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Fee's Name *</label>
                        <input type="text" placeholder="Enter fee's name" value="<?php echo $name?>" name="name" id="name"
                            class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Amount </label>
                        <input type="number" placeholder="Enter amount" value="<?php echo $amount?>" name="amount" id="amount"
                            class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Add fee to every month </label>
                        <input type="checkbox" 
                            class="form-control" name="every_month"  <?php if($every_month==1){echo 'checked="checked"';}?>>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Add to payment page </label>
                        <input type="checkbox" 
                            class="form-control" name="show_payment_page" <?php if($show_payment_page==1){echo 'checked="checked"';}?>>
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
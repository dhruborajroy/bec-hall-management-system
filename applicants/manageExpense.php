<?php 
include('header.php');
$uid=$_SESSION['USER_ID'];
$sql="select `role` from `users` where id='$uid'";
$res=mysqli_query($con,$sql);
$row=mysqli_fetch_assoc($res);
if($row['role']!=4){
    $_SESSION['PERMISSION_ERROR']=true;
    redirect("index.php");
}
$id="";
$amount="";
$status=1;
$purchaser="";
$time="";
$date="";
$expense_category_id="";
$disabled="disabled";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from expense where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $date=$row['date'];
        $amount=$row['amount'];
        $expense_category_id=$row['expense_category_id'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
        die;
    }
}
if(isset($_POST['submit'])){
    // pr($_POST);
    // break;
    $date_time=get_safe_value($_POST['date']);
    $expense_category_id=get_safe_value($_POST['expense_category_id']);
    $date_time=date_create_from_format("d/m/Y",$date_time);
    $date_id=date_format($date_time,"d");
    $month=date_format($date_time,"m");
    $year=date_format($date_time,"Y");
	$amount=get_safe_value($_POST['amount']);
    $time=time();
    if($id==''){
        $sql="INSERT INTO `expense` (`date`,`date_id`,`month`,`year`, `amount`,`expense_category_id`,`added_on`,`updated_on`,`status`) VALUES ( '$time','$date_id','$month','$year', '$amount','$expense_category_id','$time','', 1)";
        mysqli_query($con,$sql);
        // $insert_id=mysqli_insert_id($con);
        // for($i=0;$i<=count($_POST['purchaser_roll'])-1;$i++){
        //     $purchaser=get_safe_value($_POST['purchaser_roll'][$i]);
        //     $sql="INSERT INTO `purchaser` ( `expense_id`, `user_id`, `status`) VALUES ( '$insert_id', '$purchaser', '1')";
        //     mysqli_query($con,$sql);
        // }
        $_SESSION['INSERT']=1;
    }else{
        // 
        $sql="update `expense` set `date`='$time', `expense_category_id`='$expense_category_id', `amount`='$amount',`updated_on`='$time' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
        // for($i=0;$i<=count($_POST['purchaser_roll'])-1;$i++){
        //     $purchaser=get_safe_value($_POST['purchaser_roll'][$i]);
        //     $sql="update `purchaser` set `user_id`='$purchaser' where expense_id='$id'";
        //     mysqli_query($con,$sql);
        //     // $_SESSION['UPDATE']=1;
        // }
    }
// $sql;
    redirect('./expense.php');
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
                    <h3>Add New expense</h3>
                </div>
            </div>
            <form class="new-added-form" method="post">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Amount *</label>
                        <input required type="number" placeholder="Enter amount" value="<?php echo $amount?>"
                            name="amount" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Expense Category *</label>
                        <select class="form-control select2" name="expense_category_id" required>
                            <!-- <option value="-1">Select Expense Category</option> -->
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `expense_category` where status='1'");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$expense_category_id){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                                }                                                        
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date of expense *</label>
                        <input required type="text" name="date" autocomplete="off" placeholder="dd/mm/yyyy" value="<?php if($date!=""){echo date('d/m/Y',$date);}?>" class="form-control air-datepicker">
                        <i class="far fa-calendar-alt"></i>
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
    <script>

function add_purchaser(id) {
    if(document.getElementById("checkbox_"+id).checked==true){
        jQuery( '#submit' ).prop( "disabled", false );
        jQuery( '#roll_'+id ).prop( "disabled", false );
    }else if(document.getElementById("checkbox_"+id).checked==false){
        jQuery( '#roll_'+id ).prop( "disabled", true );
    }
}
// function save(){
//     jQuery( '#submit' ).prop( "disabled", false );
// }
</script>
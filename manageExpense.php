<?php include('header.php');
$id="";
$amount="";
$status=1;
$purchaser="";
$time="";
$date="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from expense where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $date=$row['date'];
        $amount=$row['amount'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
    // pr($_POST);
    $date_time=get_safe_value($_POST['date']);
    $date_time=date_create_from_format("d/m/Y",$date_time);
    $date_id=date_format($date_time,"d");
    $month=date_format($date_time,"m");
    $year=date_format($date_time,"Y");
	$amount=get_safe_value($_POST['amount']);
    $time=time();
    if($id==''){
        $sql="INSERT INTO `expense` (`date`,`date_id`,`month`,`year`, `amount`,`added_on`,`updated_on`,`status`) VALUES ( '$time','$date_id','$month','$year', '$amount','$time','', 1)";
        mysqli_query($con,$sql);
        $insert_id=mysqli_insert_id($con);
        for($i=0;$i<=count($_POST['purchaser'])-1;$i++){
            $purchaser=get_safe_value($_POST['purchaser'][$i]);
            $sql="INSERT INTO `purchaser` ( `expense_id`, `user_id`, `status`) VALUES ( '$insert_id', '$purchaser', '1')";
            mysqli_query($con,$sql);
        }
        $_SESSION['INSERT']=1;
    }else{
        $sql="update `expense` set `date`='$time', `amount`='$amount',`updated_on`='$time' where id='$id'";
        mysqli_query($con,$sql);    
        $_SESSION['UPDATE']=1;
        for($i=0;$i<=count($_POST['purchaser'])-1;$i++){
            $purchaser=get_safe_value($_POST['purchaser'][$i]);
            $sql="update `purchaser` set `user_id`='$purchaser' where expense_id='$id'";
            mysqli_query($con,$sql);
        }
    }
    // echo $sql;
    // redirect('./expense.php');
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
                        <label>Purchaser *</label>
                        <select class="form-control select2"  multiple="multiple" name="purchaser[]">
                            <option>Select Purchaser</option>
                            <?php
                            // $except_id="";
                            // $res=mysqli_query($con,"SELECT users.id as uid, users.name,users.roll, expense.*, purchaser.*  from users, expense,purchaser WHERE expense.id=purchaser.expense_id AND purchaser.user_id=users.id and expense.id='$id'");
                            // while($row=mysqli_fetch_assoc($res)){
                            //         $except_id=$row['uid'];
                            //         echo "<option selected='selected' value=".$row['id'].">".$row['name']." (".$row['roll'].")</option>";                                                       
                            // }
                            ?>
                            <?php
                            $res=mysqli_query($con,"SELECT users.*  from users"); //where id not in ($except_id)");
                            while($row=mysqli_fetch_assoc($res)){
                                echo "<option  value=".$row['id'].">".$row['name']." (".$row['roll'].")</option>";                                                        
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
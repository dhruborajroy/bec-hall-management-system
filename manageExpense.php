<?php include('header.php');
$id="";
$amount="";
$status=1;
$purchaser="";
$date="";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from expense where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $date=$row['date'];
        $purchaser=$row['purchaser'];
        $amount=$row['amount'];
    }else{
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
    pr($_POST);
    $date=mktime(strtotime($_POST['date']));
	// $purchaser=get_safe_value($_POST['purchaser']);
	$amount=get_safe_value($_POST['amount']);
    $time=time();
    for($i=0;$i<=count($_POST['purchaser'])-1;$i++){
	    $purchaser=get_safe_value($_POST['purchaser'][$i]);
        if($id==''){
            $sql="INSERT INTO `expense` (`date`, `purchaser`, `amount`,`added_on`,`updated_on`,`status`) VALUES ( '$date', '$purchaser','$amount','$time','', 1)";
            //mysqli_query($con,$sql);
            $_SESSION['INSERT']=1;
        }else{
            $sql="update `expense` set `date`='$date', `amount`='$amount', `purchaser`='$purchaser', `updated_on`='$time' where id='$id'";
            //mysqli_query($con,$sql);    
            $_SESSION['UPDATE']=1;
        }
    }
    echo $sql;
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
                            $res=mysqli_query($con,"SELECT * FROM `users` where status='1'");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$purchaser){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']." (".$row['roll'].")</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['name']." (".$row['roll'].")</option>";
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
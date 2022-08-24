<?php include('header.php');
$id="";
$short_form='';
$name='';
if(isset($_GET['id']) && $_GET['id']>0 && $_GET['id']!=""){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from users where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $student_id=$row['id'];
        $role=$row['role'];
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect("index.php");
    }
}
if(isset($_POST['submit'])){
	$student_id=get_safe_value($_POST['student_id']);
	$role=get_safe_value($_POST['role']);
    if($id==''){
        $sql="update `users` set `role`='$role' where id='$student_id'";
    }else{
        $sql="update `users` set `role`='$role' where id='$student_id'";
    }
    // $sql;
    mysqli_query($con,$sql);
    $_SESSION['UPDATE']=1;
    redirect('./role.php');
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
                        <label>Student *</label>
                        <select class="form-control select2" name="student_id">
                            <option>Select student</option>
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `users` where status='1'");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$student_id){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']." (".$row['roll'].")"."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['name']." (".$row['roll'].")"."</option>";
                                }                                                        
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Freedom Fighter Quata *</label>
                        <select class="select2" name="role" required>
                            <option >Select Role </option>
                            <option value="2">Meal Checker </option>
                            <option value="3">Accountant </option>
                            <option value="4">Meal Auditor</option>
                            <option value="5">Manager </option>
                            <option value="6">Marketing Manager</option>
                        </select>
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
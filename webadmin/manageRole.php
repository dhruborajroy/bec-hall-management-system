<?php include('header.php');
$id="";
$role='';
$student_id='';
if(isset($_GET['id']) && $_GET['id']>0 && $_GET['id']!=""){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from users where id='$id'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        // echo "<pre>";
        // print_r($row);
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
    redirect('./userRole.php');
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
                    <h3>Appoint Role</h3>
                </div>
            </div>
            <form id="validate" class="new-added-form" method="post">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Student *</label>
                        <select class="form-control select2" name="student_id" id="student_id">
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
                        <label>Role *</label>
                        <select class="form-control select2" name="role" id="role">
                            <option>Select role</option>
                            <?php
                            $resss=mysqli_query($con,"SELECT * FROM `roles` where status='1'");
                            while($rowss=mysqli_fetch_assoc($resss)){
                                if($rowss['value']==$role){
                                    echo "<option selected='selected' value=".$rowss['value'].">".$rowss['role_name']."</option>";
                                }else{
                                    echo "<option value=".$rowss['value'].">".$rowss['role_name']."</option>";
                                }                                                        
                            }
                            ?>
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
<?php 
include("header.php");
$msg="";
$uid=$_SESSION['ADMIN_ID'];
$sql="select * from `admin` where id='$uid'";
$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
$email=$row['email'];
if(isset($_POST['submit'])){
	$current_password=get_safe_value($_POST['current_password']);
	$password=get_safe_value($_POST['password']);
    $sql="select * from admin where id=".$_SESSION['USER_ID'];
    $row=mysqli_fetch_assoc(mysqli_query($con,$sql));
    $verify=password_verify($current_password,$row['password']);
    if($verify==1){
        $password=password_hash($password,PASSWORD_DEFAULT);
        $sql="update `admin` set `password`='$password' where `email`='$email'";
        $res=mysqli_query($con,$sql);
        $_SESSION['UPDATE']=true;
        send_email($email,"Password Updated","Password Changed");
    }else{
        $msg="Please enter current password correctly";
    }
}
?>

<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Profile</h3>
        <!-- <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>All Students</li>
        </ul> -->
    </div>
    <!-- Breadcubs Area End Here -->
                <!-- Student Details Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>About Me</h3>
                                <br>
                                <?php echo $msg?>
                            </div>
                        </div>
                        <div class="single-info-details">
                            <div class="item-img">
                                <!-- <img src="img/figure/parents.jpg" alt="student"> -->
                                <img src="<?php echo STUDENT_IMAGE.$row['image']?>" alt="teacher" height="150px" width="150px">
                            </div>
                            <div class="item-content">
                                <div class="header-inline item-header">
                                    <h3 class="text-dark-medium font-medium"><?php echo $row['name']?></h3>
                                    <!-- <div class="header-elements">
                                        <ul>
                                            <li><a href="#"><i class="far fa-edit"></i></a></li>
                                            <li><a href="#"><i class="fas fa-print"></i></a></li>
                                            <li><a href="#"><i class="fas fa-download"></i></a></li>
                                        </ul>
                                    </div> -->
                                </div>
                                <!-- <p>Aliquam erat volutpat. Curabiene natis massa sedde lacu stiquen sodale 
                                word moun taiery.Aliquam erat volutpaturabiene natis massa sedde  sodale 
                                word moun taiery.</p> -->
                                <div class="info-table table-responsive">
                                    <table class="table text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td>Name:</td>
                                                <td class="font-medium text-dark-medium"><?php echo $row['name']?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone:</td>
                                                <td class="font-medium text-dark-medium"><?php echo $row['phoneNumber']?></td>
                                            </tr>
                                            <tr>
                                                <td>E-mail:</td>
                                                <td class="font-medium text-dark-medium"><?php echo $row['email']?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Change Password</h3>
                            </div>
                        </div>
                        <form id="validate" method="post">
                            <div class="col-xl-12 col-lg-12 col-12 form-group">
                                <div class="col-xl-12 col-lg-12 col-12 form-group">
                                    <label>Current Password *</label>
                                    <input required type="password" name="current_password" autocomplete="off" placeholder="Current Password" class="form-control">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-12 form-group">
                                    <label>New password *</label>
                                    <input required type="password" name="password" id="password" autocomplete="off" placeholder="New Password" class="form-control">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-12 form-group">
                                    <label>Confirm New password *</label>
                                    <input required type="password" name="cpassword" id="cpassword" autocomplete="off" placeholder="Confirm New Password" class="form-control">
                                </div>
                                <div class="col-12 form-group mg-t-8">
                                    <button name="submit" type="submit"
                                        class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Student Details Area End Here -->
    <?php include("footer.php")?>
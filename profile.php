<?php 
include("header.php"); 
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}
$uid=$_SESSION['APPLICANT_ID'];
$sql="select * from `applicants` where id='".$_SESSION['APPLICANT_ID']."'";
$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>
                  <!-- page content started -->
                  <div class="col-xl-9 col-md-8">
                     <div class="settings-widget profile-details">
                        <div class="settings-menu p-0">
                           <div class="profile-heading">
                              <h3>Profile Details</h3>
                              <p>You have full control to manage your own account setting.</p>
                           </div>
                           <div class="course-group mb-0 d-flex">
                              <div class="course-group-img d-flex align-items-center">
                                 <a href="instructor-profile.html"><img src="assets/img/user/user11.jpg" alt="" class="img-fluid"></a>
                                 <div class="course-name">
                                    <h4><a href="instructor-profile.html">Your avatar</a></h4>
                                    <p>PNG or JPG no bigger than 800px wide and tall.</p>
                                 </div>
                              </div>
                              <div class="profile-share d-flex align-items-center justify-content-center">
                                 <a href="javascript:;" class="btn btn-success">Update</a>
                              </div>
                           </div>
                           <div class="checkout-form personal-address add-course-info">
                              <div class="personal-info-head">
                                 <h4>Personal Details</h4>
                                 <p>Edit your personal information and address.</p>
                              </div>
                              <form action="#">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">First Name</label>
                                          <input type="text" class="form-control" value="<?php echo $row['first_name'];?>" placeholder="Enter your first Name">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Last Name</label>
                                          <input type="text" class="form-control" value="<?php echo $row['last_name'];?>" placeholder="Enter your last Name">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Phone</label>
                                          <input type="text" class="form-control" disabled readonly value="<?php echo $row['phoneNumber'];?>" placeholder="Enter your Phone">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Email</label>
                                          <input type="text" class="form-control" disabled  readonly value="<?php echo $row['email'];?>" placeholder="Enter your Email">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Birthday</label>
                                          <input type="text" class="form-control" placeholder="Birth of Date"  value="<?php echo $row['dob'];?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label"> Present Address</label>
                                          <input type="text" class="form-control"  value="<?php echo $row['presentAddress'];?>" placeholder="Address">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label"> Permanent Address</label>
                                          <input type="text" class="form-control" placeholder="Address"  value="<?php echo $row['permanentAddress'];?>">
                                       </div>
                                    </div>
                                    <div class="update-profile">
                                       <button type="button" class="btn btn-primary">Update Profile</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- page content ended -->
               </div>
            </div>
         </div>
<?php include("footer.php")?>

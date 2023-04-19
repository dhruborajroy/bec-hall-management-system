<?php 
include("header.php"); 
$msg="";
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}
$application_id=$_SESSION['APPLICANT_ID'];
$sql="SELECT * FROM `applicants` where id='$application_id'";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>0){
   $row=mysqli_fetch_assoc($res);
   $first_name=$row['first_name'];
   $last_name=$row['last_name'];
   $f_name=$row['fName'];
   $f_nid=$row['fNid'];
   $m_name=$row['mName'];
   $m_nid=$row['mNid'];
   $phoneNumber=$row['phoneNumber'];
   $present_address=$row['presentAddress'];
   $permanent_address=$row['permanentAddress'];
   $dob=$row['dob'];
   $gender=$row['gender'];
   $religion=$row['religion'];
   $birthId=$row['birthId'];
   $quota=$row['quota'];
   $blood_group=$row['bloodGroup'];
   $local_guardian_name=$row['localGuardianName'];
   $local_guardian_nid=$row['localGuardianNid'];
   $email=$row['email'];
   $image=$row['image'];
   // $password=$row['password'];
   $class=$row['class'];
}else{
   $_SESSION['TOASTR_MSG']=array(
      'type'=>'error',
      'body'=>'You don\'t have the permission to access the location!',
      'title'=>'Error',
   );
   redirect("index");
}
?>
      <div class="page-content instructor-page-content">
         <div class="container">
            <div class="row">
            <?php include("navbar.php")?>
               <!-- page content started -->
               <div class="col-xl-9 col-md-8">

<section class="course-content checkout-widget">
   <div class="container">
      <div class="col-md-12">
         <div class="settings-widget">
            <div class="settings-inner-blk p-0">
               <div class="sell-course-head comman-space">
                  <h3 align="center">Basic Informations</h3>
                  <form method="POST" enctype="multipart/form-data">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">First Name</label>
                              <input disabled type="text" value="<?php echo $first_name?>" name="first_name" id="first_name"  class="form-control" placeholder="Enter your first Name" required>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Last Name</label>
                              <input disabled type="text" value="<?php echo $last_name?>" name="last_name" id="last_name" class="form-control"  placeholder="Enter your last Name">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Date of Birth</label>
                              <input disabled type="text" autocomplete="off" name="dob" id="dob"  value="<?php echo $dob?>" class="form-control air-datepicker" placeholder="dd/mm/yyyy">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-label">Gender</label>
                              <select class="form-select select" name="gender" id="gender" >
                                 <option>Select Gender</option>
                                 <?php
                                    $data=[
                                          'name'=>[
                                             'Male',
                                             'Female',
                                             'Other',
                                          ]
                                       ];
                                    $count=count($data['name']);
                                    for($i=0;$i<$count;$i++){
                                       if($data['name'][$i]==$gender){
                                             echo "<option selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                       }else{
                                             echo "<option value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                       }                                                        
                                    }
                                    ?>
                              </select>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Phone Number</label>
                              <input disabled type="number" autocomplete="off" pattern="^(?:(?:\+|00)88|01)?(?:\d{11}|\d{13})$" title="Please enter correct format and length. ex: 017xxxxxx" name="phone_number"  value="<?php echo $phone_number?>" id="phone_number" class="form-control" placeholder="Phone Number">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Confirm Phone Number</label>
                              <input disabled type="number" autocomplete="off"  pattern="^(?:(?:\+|00)88|01)?(?:\d{11}|\d{13})$" title="Please enter correct format and length. ex: 017xxxxxx"  name="phone_number"  value="<?php echo $phone_number?>" id="phone_number" class="form-control" placeholder="Phone Number">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Email</label>
                              <input disabled type="email" autocomplete="off" name="email" id="email" value="<?php echo $email?>" class="form-control" placeholder="Email">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Birth Certificate Number</label>
                              <input disabled type="number" autocomplete="off" name="birthID" id="birthID" value="<?php echo $birthID?>" class="form-control" placeholder="Birth Certificate Number">
                           </div>
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="settings-widget">
            <div class="settings-inner-blk p-0">
               <div class="sell-course-head comman-space">
                  <h3 align="center">Admission Details</h3>
                     <div class="col-lg-12 row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <div class="form-group">
                                 <label class="form-control-label">Class</label>
                                 <input disabled type="number" autocomplete="off" pattern="^(?:(?:\+|00)88|01)?(?:\d{11}|\d{13})$" title="Please enter correct format and length. ex: 017xxxxxx" name="phone_number"  value="<?php echo $class?>" id="phone_number" class="form-control" placeholder="Phone Number">
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6">
                              <div class="form-group">
                                 <label class="form-label">Quota</label>
                                 <input disabled  value="<?php echo $quota?>" class="form-control" >
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="form-group">
                                 <label class="form-label">Blood Group</label>
                                    <input disabled  value="<?php echo $blood_group?>" class="form-control" >
                              </div>
                           </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-label">Gender</label>
                                 <input disabled  value="<?php echo $religion?>" class="form-control" >
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-md-12">
         <div class="settings-widget">
            <div class="settings-inner-blk p-0">
               <div class="sell-course-head comman-space">
                  <h3 align="center"> Gardian Details</h3>
                     <div class="col-lg-12 row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Father's Name</label>
                              <input disabled type="text" name="f_name"  value="<?php echo $f_name?>" id="f_name" class="form-control" placeholder="Enter your father's Name">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Father's NID</label>
                              <input disabled type="text" name="f_nid"  value="<?php echo $f_nid?>" id="f_nid" class="form-control" placeholder="Enter your father's NID number">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Mother's Name</label>
                              <input disabled type="text" name="m_name" value="<?php echo $m_name?>" id="m_name" class="form-control" placeholder="Enter your mother's Name">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Mother's NID</label>
                              <input disabled type="text" name="m_nid"  value="<?php echo $m_nid?>" id="m_nid" class="form-control" placeholder="Enter your mother's NID number">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Local Guardian's Name</label>
                              <input disabled type="text" name="local_guardian_name"  value="<?php echo $local_guardian_name?>" id="f_name" class="form-control" placeholder="Local Guardian's Name">
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label class="form-control-label">Local Guardian's NID</label>
                              <input disabled type="text" name="localGuardianNid"  value="<?php echo $local_guardian_nid?>" id="f_nid" class="form-control" placeholder="Local Guardian's NID">
                           </div>
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-md-12">
         <div class="settings-widget">
            <div class="settings-inner-blk p-0">
               <div class="sell-course-head comman-space">
                  <h3 align="center"> Address</h3>
                     <div class="col-lg-12 row">
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label class="form-control-label">Present Address</label>
                              <input disabled type="text" name="present_address" id="present_address"  value="<?php echo $present_address?>"class="form-control" placeholder="Present address">
                           </div>
                        </div>
                        <div class="col-lg-12">
                           <div class="form-group">
                              <label class="form-control-label">Permanent Address</label>
                              <input disabled type="text" name="permanent_address" id="permanent_address" value="<?php echo $permanent_address?>" class="form-control" placeholder="Permanent address">
                           </div>
                        </div>
                     </div>
               </div>
            </div>
         </div>
      </div>
         <div class="col-md-12">
            <div class="settings-widget">
               <div class="settings-inner-blk p-0">
                  <div class="sell-course-head comman-space row">
                     <h3 align="center">Applicant's Photo</h3>
                     <div class="row">
                        <div class="col-lg-6 error" id="result" align="center">
                           <p >Image Preview</p>
                           <img class="image-preview" src="./media/users/<?php echo $image?>"  alt="" srcset="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
               </div>
               <!-- page content ended -->
            </div>
         </div>
      </div>
   </form>
<?php 
include("footer.php");
if(isset($_SESSION['TOASTR_MSG'])){?>
   <script>
      toastrMsg('<?php echo $_SESSION['TOASTR_MSG']['type']?>',"<?php echo $_SESSION['TOASTR_MSG']['body']?>","<?php echo $_SESSION['TOASTR_MSG']['title']?>");
   </script>
<?php 
unset($_SESSION['TOASTR_MSG']);
}
?>

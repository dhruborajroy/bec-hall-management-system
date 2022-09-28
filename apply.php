<?php
include("header.php");
$display="";
$class="";
$id="";
$msg="";
$first_name="";
$last_name="";
$f_name="";
$m_name="";
$phone_number="";
$email="";
$blood_group="";
$present_address="";
$gender="";
$permanent_address="";
$dob="";
$quota="";
$password="";
$religion="";
$code="";
if(isset($_POST['submit'])){
	$first_name=ucfirst(get_safe_value($_POST['first_name']));
	$last_name=ucfirst(get_safe_value($_POST['last_name']));
	$f_name=ucfirst(get_safe_value($_POST['f_name']));
	$m_name=ucfirst(get_safe_value($_POST['m_name']));
	$phone_number=get_safe_value($_POST['phone_number']);
	$email=get_safe_value($_POST['email']);
	$present_address=get_safe_value($_POST['present_address']);
	$permanent_address=get_safe_value($_POST['permanent_address']);
	$gender=get_safe_value($_POST['gender']);
	$blood_group=get_safe_value($_POST['blood_group']);
	$dob=get_safe_value($_POST['dob']);
	$quota=get_safe_value($_POST['quota']);
	$password=get_safe_value($_POST['password']);
   $password=password_hash($password,PASSWORD_DEFAULT);
	$religion=get_safe_value($_POST['religion']);
   if(mysqli_num_rows(mysqli_query($con,"select id from applicants where phoneNumber='$phone_number'"))>0){
      $class='class="alert alert-danger"';
      $_SESSION['TOASTR_MSG']=array(
         'type'=>'error',
         'body'=>'Phone number is already added',
         'title'=>'Error',
      ); 
   }elseif(mysqli_num_rows(mysqli_query($con,"select id from applicants where email='$email'"))>0){
      $class='class="alert alert-danger"'; 
      $_SESSION['TOASTR_MSG']=array(
         'type'=>'error',
         'body'=>'Email is already added',
         'title'=>'Error',
      ); 
    //   $msg="Email is already added";
   }else{
      if($id==''){
         $info=getimagesize($_FILES['image']['tmp_name']);
         $width = $info[0];
         $height = $info[1];
         if(isset($info['mime'])){
             if($info['mime']=="image/jpeg"){
                 $img=imagecreatefromjpeg($_FILES['image']['tmp_name']);
             }elseif($info['mime']=="image/png"){
                 $img=imagecreatefrompng($_FILES['image']['tmp_name']);
             }else{
                  $_SESSION['TOASTR_MSG']=array(
                     'type'=>'error',
                     'body'=>'Only select jpg or png image',
                     'title'=>'Error',
                  );
             }
             if(isset($img)){
                 // if ($width > "300" || $height > "200"){
                 //     echo "Image dimension should be within 300X200";
                 // }
                 // else
                 if (($_FILES["image"]["size"] > 1000000)) {//2000000 = 2Mb
                     // $msg= "Image size exceeds 300 MB";
                     $_SESSION['TOASTR_MSG']=array(
                        'type'=>'error',
                        'body'=>'Image size exceeds 1 MB',
                        'title'=>'Error',
                     );
                 }else{
                     $id=uniqid();
                     $code=rand(111111,999999);
                     $roll=date('y').rand(1111,9999);
                     $image=time().'.jpg';
                     move_uploaded_file($_FILES['image']['tmp_name'],UPLOAD_STUDENT_IMAGE.$image);
                     $sql="INSERT INTO `applicants`(`id`, `first_name`,`last_name`, `roll`, `class_roll`, `fName`, `mName`, `phoneNumber`, `presentAddress`, `permanentAddress`, `dob`, `gender`, `religion`, `birthId`, `quota`, `bloodGroup`, `examRoll`, `merit`, `legalGuardianName`, `legalGuardianRelation`, `password`, `email`, `code`, `image`, `last_notification`,`final_submit`, `status`) 
                     VALUES ('$id','$first_name','$last_name','$roll','','$f_name','$m_name','$phone_number','$present_address','$permanent_address','$dob','$gender','$religion','','$quota','$blood_group','$roll','','','','$password','$email','$code','$image','','0','0')";
                     send_email($email,'Your account has been created. <a href="'.FRONT_SITE_PATH.'/verify?email='.$email.'&code='.$code.'">Verify Email</a>','Account Created');
                     if(mysqli_query($con,$sql)){
                        $_SESSION['TOASTR_MSG']=array(
                           'type'=>'success',
                           'body'=>'An Email has been sent to your '.$email.' account. Please Verify your email & login.',
                           'title'=>'Error',
                        );
                        $display='style="display:none;"';
                        // $class='class="alert alert-success"';
                        // $msg="An Email has been sent to your $email account. Please Verify your email & login.";
                        $_SESSION['INSERT']=1;
                     }
                     // redirect("users.php");
                 }
             }
         }else{
             $_SESSION['TOASTR_MSG']=array(
                'type'=>'success',
                'body'=>'Only select jpg or png image',
                'title'=>'Error',
             );
         }
      }
   }
}?>
<div class="breadcrumb-bar">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-12">
            <div class="breadcrumb-list">
               <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index">Home</a></li>
                     <li class="breadcrumb-item" aria-current="page">Apply</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>
</div>
<section class="course-content checkout-widget">
            <div class="container">
               <div class="row">
                  <div class="col-lg-1">
                  </div>
                     <div class="col-lg-10">
                        <div class="student-widget">
                           <div class="student-widget-group add-course-info">
                              <div class="cart-head">
                                    <h4>Applicant Form</h4>
                                 <center>
                                    <!-- <span <?php //echo $class?>><?php //echo $msg?></span> -->
                                 </center>
                              </div>
                              <div class="checkout-form" <?php echo $display?>>
                                 <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">First Name</label>
                                             <input type="text" value="<?php echo $first_name?>" name="first_name" id="first_name"  class="form-control" placeholder="Enter your first Name" required>
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Last Name</label>
                                             <input type="text" value="<?php echo $last_name?>" name="last_name" id="last_name" class="form-control"  placeholder="Enter your last Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="form-group">
                                             <label class="form-control-label">Photo</label>
                                             <input type="file" name="image"  accept="image/jpg" >   
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Father's Name</label>
                                             <input type="text" name="f_name"  value="<?php echo $f_name?>" id="f_name" class="form-control" placeholder="Enter your father's Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Mother's Name</label>
                                             <input type="text" name="m_name" value="<?php echo $m_name?>" id="m_name" class="form-control" placeholder="Enter your mother's Name">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Phone Number</label>
                                             <input type="number" name="phone_number"  value="<?php echo $phone_number?>" id="phone_number" class="form-control" placeholder="Phone Number">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Email</label>
                                             <input type="email" name="email" id="email" value="<?php echo $email?>" class="form-control" placeholder="Email">
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="form-group">
                                             <label class="form-control-label">Present Address</label>
                                             <input type="text" name="present_address" id="present_address"  value="<?php echo $present_address?>"class="form-control" placeholder="Present address">
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="form-group">
                                             <label class="form-control-label">Permanent Address</label>
                                             <input type="text" name="permanent_address" id="permanent_address" value="<?php echo $permanent_address?>" class="form-control" placeholder="Permanent address">
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
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
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label class="form-label">Blood Group</label>
                                             <select class="form-select select" name="blood_group" id="bloodgroup"  value="<?php echo $blood_group?>">
                                                <option>Select Bloodgroup</option>
                                                   <?php
                                                   $data=[
                                                      'name'=>[
                                                         'A+',
                                                         'A-',
                                                         'B+',
                                                         'B-',
                                                         'AB+',
                                                         'AB-',
                                                         'O+',
                                                         'O-',
                                                      ]
                                                   ];
                                                   $count=count($data['name']);
                                                   for($i=0;$i<$count;$i++){
                                                      if($data['name'][$i]==$blood_group){
                                                            echo "<option selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                                      }else{
                                                            echo "<option value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                                      }                                                        
                                                   }
                                                ?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="form-group">
                                             <label class="form-label">Religion</label>
                                             <select class="form-select select" name="religion" id="religion">
                                                <option>Select Religion</option>
                                                   <?php
                                                $data=[
                                                      'name'=>[
                                                            'Islam',
                                                            'Hinduism',
                                                            'Christian',
                                                            'Buddhism',
                                                            'Other',
                                                      ]
                                                   ];
                                                   $count=count($data['name']);
                                                   for($i=0;$i<$count;$i++){
                                                      if($data['name'][$i]==$religion){
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
                                             <label class="form-control-label">Date of Birth</label>
                                             <input type="date" name="dob" id="dob"  value="<?php echo $dob?>" class="form-control" placeholder="Date of birth">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-label">Quota</label>
                                             <select class="form-select select" name="quota" id="quota">
                                                <option>Select quota</option>
                                                   <?php
                                                   $religion="";
                                                   $data=[
                                                       'name'=>[
                                                           'N/A',
                                                           'FF',
                                                           'TR',
                                                           'DI',
                                                       ]
                                                   ];
                                                   $count=count($data['name']);
                                                   for($i=0;$i<$count;$i++){
                                                      if($data['name'][$i]==$quota){
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
                                             <label class="form-control-label">Password</label>
                                             <input type="password" name="password" id="password"  value="<?php echo $password?>" class="form-control" placeholder="Password">
                                          </div>
                                       </div>
                                       <div class="col-lg-6">
                                          <div class="form-group">
                                             <label class="form-control-label">Confirm Password</label>
                                             <input type="password" name="cpassword"  id="cpassword" class="form-control" placeholder="Confirm password">
                                          </div>
                                       </div>
                                       <div class="payment-btn" style="text-align:center;">
                                          <button name="submit" id="submit" class="btn btn-primary" type="submit">Submit</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                  </div>

               <div class="col-lg-1">
                  </div>
            </div>
         </section>
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

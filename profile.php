<?php 
include("header.php"); 
$msg="";
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index.php');
}
$uid=$_SESSION['APPLICANT_ID'];
$sql="select * from `applicants` where id='".$_SESSION['APPLICANT_ID']."'";
$row=mysqli_fetch_assoc(mysqli_query($con,$sql));
if(isset($_POST['submit'])){
   $first_name=get_safe_value($_POST['first_name']);
   $last_name=get_safe_value($_POST['last_name']);
   $presentAdddress=get_safe_value($_POST['presentAddress']);
   $permanentAdddress=get_safe_value($_POST['permanentAddress']);
   $legalGuardianName=get_safe_value($_POST['legalGuardianName']);
   $legalGuardianRelation=get_safe_value($_POST['legalGuardianRelation']);
   if(mysqli_query($con,"Update applicants set `first_name`='$first_name',`last_name`='$last_name', `presentAddress`='$presentAdddress',`permanentAddress`='$permanentAdddress' ,`legalGuardianName`='$legalGuardianName' ,`legalGuardianRelation`='$legalGuardianRelation' where id='$uid'")){
      // $msg="Updated";
      // splash_msg('success','Data updated','Updated');
      $_SESSION['TOASTR_MSG']=array(
         'type'=>'success',
         'body'=>'Data Updated',
         'title'=>'Updated',
      );
   }
}
?>
      <div class="page-content instructor-page-content">
         <div class="container">
            <div class="row">
            <?php include("navbar.php")?>
               <!-- page content started -->
               <div class="col-xl-9 col-md-8">
                  <div class="settings-widget profile-details">
                     <div class="settings-menu p-0">
                        </div>
                        <div class="checkout-form personal-address add-course-info">
                           <div class="personal-info-head">
                              <h4>Personal Details</h4>
                              <?php echo $msg?>
                           </div>
                           <form method="post">
                              <div class="row">
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label">First Name</label>
                                       <input type="text" class="form-control" name="first_name" value="<?php echo $row['first_name'];?>" placeholder="Enter your first Name">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label">Last Name</label>
                                       <input type="text" class="form-control" name="last_name"  value="<?php echo $row['last_name'];?>" placeholder="Enter your last Name">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label">Father's Name</label>
                                       <input type="text" class="form-control" name="fName"  value="<?php echo $row['fName'];?>" placeholder="Enter your last Name">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label">Mother's Name</label>
                                       <input type="text" class="form-control" name="mName"  value="<?php echo $row['fName'];?>" placeholder="Enter your last Name">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label">Phone</label>
                                       <input type="text" class="form-control" disabled readonly style="background-color: #fdd9d9;" value="<?php echo $row['phoneNumber'];?>" placeholder="Enter your Phone">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label">Email</label>
                                       <input type="text" class="form-control" disabled  readonly style="background-color: #fdd9d9;" value="<?php echo $row['email'];?>" placeholder="Enter your Email">
                                    </div>
                                 </div>
                                    <div class="col-lg-4">
                                       <div class="form-group">
                                          <label class="form-label">Gender</label>
                                          <select class="form-select select" name="gender" id="gender" >
                                             <option>Select Gender</option>
                                                <?php
                                                $gender=$row['gender'];
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
                                                   }                                                       
                                                }
                                             ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-4">
                                       <div class="form-group">
                                          <label class="form-label">Blood Group</label>
                                          <select readonly class="form-select select" name="blood_group" id="bloodgroup"  value="<?php echo $blood_group?>">
                                             <option>Select Bloodgroup</option>
                                                <?php
                                                $blood_group=$row['bloodGroup'];
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
                                                         echo "<option  selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
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
                                                $religion=$row['religion'];
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
                                                   }                                                       
                                                }
                                             ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Date of Birth</label>
                                          <input type="date" name="dob" id="dob"  value="<?php echo $row['dob']?>" class="form-control" placeholder="Date of birth">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-label">Quota</label>
                                          <select class="form-select select" name="quota" id="quota">
                                             <option>Select quota</option>
                                                <?php
                                                $quota=$row['quota'];
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
                                                   }                                                      
                                                }
                                             ?>
                                          </select>
                                       </div>
                                    </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label"> Present Address</label>
                                       <input type="text" class="form-control" name="presentAddress"   value="<?php echo $row['presentAddress'];?>" placeholder="Address">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="form-group">
                                       <label class="form-control-label"> Permanent Address</label>
                                       <input type="text" class="form-control" name="permanentAddress"  placeholder="Address"  value="<?php echo $row['permanentAddress'];?>">
                                    </div>
                                 </div>
                              </div>
                        </div>
                     </div>


                     <div class="col-md-12">
                     <div class="settings-widget">
                        <div class="settings-inner-blk p-0">
                           <div class="sell-course-head comman-space">
                              <h3>Local Gardian Details</h3>
                                 <div class="col-lg-12 row">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian's Name</label>
                                          <input type="text" class="form-control"  required name="legalGuardianName" value="<?php echo $row['legalGuardianName'];?>"  placeholder="legalGuardianName"  value="<?php echo $row['legalGuardianName'];?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian Relation</label>
                                          <input type="text" class="form-control" required name="legalGuardianRelation" value="<?php echo $row['legalGuardianRelation'];?>" placeholder="legalGuardianRelation"  value="<?php echo $row['legalGuardianRelation'];?>">
                                       </div>
                                    </div>
                                 </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button type="submit" name="submit"  class="btn btn-primary">Save & Exit</button>
                                    </div>
                                    <div class="col-lg-2">
                                       <a href="#" data-bs-toggle="modal" data-bs-target="#finalSubmit">
                                          <button type="submit" name="finalSubmit"  class="btn btn-primary">Final Submit</button>
                                       </a>
                                    </div>
                                    <div class="col-lg-4">
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
                              <h3>Local Gardian Details</h3>
                                 <div class="col-lg-12 row">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian's Name</label>
                                          <input type="text" class="form-control"  required name="legalGuardianName" value="<?php echo $row['legalGuardianName'];?>"  placeholder="legalGuardianName"  value="<?php echo $row['legalGuardianName'];?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian Relation</label>
                                          <input type="text" class="form-control" required name="legalGuardianRelation" value="<?php echo $row['legalGuardianRelation'];?>" placeholder="legalGuardianRelation"  value="<?php echo $row['legalGuardianRelation'];?>">
                                       </div>
                                    </div>
                                 </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button type="submit" name="submit"  class="btn btn-primary">Save & Exit</button>
                                    </div>
                                    <div class="col-lg-2">
                                       <a href="#" data-bs-toggle="modal" data-bs-target="#finalSubmit">
                                          <button type="submit" name="finalSubmit"  class="btn btn-primary">Final Submit</button>
                                       </a>
                                    </div>
                                    <div class="col-lg-4">
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
                              <h3>Local Gardian Details</h3>
                                 <div class="col-lg-12 row">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian's Name</label>
                                          <input type="text" class="form-control"  required name="legalGuardianName" value="<?php echo $row['legalGuardianName'];?>"  placeholder="legalGuardianName"  value="<?php echo $row['legalGuardianName'];?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian Relation</label>
                                          <input type="text" class="form-control" required name="legalGuardianRelation" value="<?php echo $row['legalGuardianRelation'];?>" placeholder="legalGuardianRelation"  value="<?php echo $row['legalGuardianRelation'];?>">
                                       </div>
                                    </div>
                                 </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button type="submit" name="submit"  class="btn btn-primary">Save & Exit</button>
                                    </div>
                                    <div class="col-lg-2">
                                       <a href="#" data-bs-toggle="modal" data-bs-target="#finalSubmit">
                                          <button type="submit" name="finalSubmit"  class="btn btn-primary">Final Submit</button>
                                       </a>
                                    </div>
                                    <div class="col-lg-4">
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
                              <h3>Local Gardian Details</h3>
                                 <div class="col-lg-12 row">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian's Name</label>
                                          <input type="text" class="form-control"  required name="legalGuardianName" value="<?php echo $row['legalGuardianName'];?>"  placeholder="legalGuardianName"  value="<?php echo $row['legalGuardianName'];?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian Relation</label>
                                          <input type="text" class="form-control" required name="legalGuardianRelation" value="<?php echo $row['legalGuardianRelation'];?>" placeholder="legalGuardianRelation"  value="<?php echo $row['legalGuardianRelation'];?>">
                                       </div>
                                    </div>
                                 </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button type="submit" name="submit"  class="btn btn-primary">Save & Exit</button>
                                    </div>
                                    <div class="col-lg-2">
                                       <a href="#" data-bs-toggle="modal" data-bs-target="#finalSubmit">
                                          <button type="submit" name="finalSubmit"  class="btn btn-primary">Final Submit</button>
                                       </a>
                                    </div>
                                    <div class="col-lg-4">
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
                              <h3>Local Gardian Details</h3>
                                 <div class="col-lg-12 row">
                                 <div class="row">
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian's Name</label>
                                          <input type="text" class="form-control"  required name="legalGuardianName" value="<?php echo $row['legalGuardianName'];?>"  placeholder="legalGuardianName"  value="<?php echo $row['legalGuardianName'];?>">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="form-group">
                                          <label class="form-control-label">Local Guardian Relation</label>
                                          <input type="text" class="form-control" required name="legalGuardianRelation" value="<?php echo $row['legalGuardianRelation'];?>" placeholder="legalGuardianRelation"  value="<?php echo $row['legalGuardianRelation'];?>">
                                       </div>
                                    </div>
                                 </div>
                                    <div class="col-lg-4">
                                    </div>
                                    <div class="col-lg-2">
                                          <button type="submit" name="submit"  class="btn btn-primary">Save & Exit</button>
                                    </div>
                                    <div class="col-lg-2">
                                       <a href="#" data-bs-toggle="modal" data-bs-target="#finalSubmit">
                                          <button type="submit" name="finalSubmit"  class="btn btn-primary">Final Submit</button>
                                       </a>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                 </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- page content ended -->
            </div>
         </div>
      </div>
      <div class="modal-styles modal fade" id="finalSubmit" tabindex="-1" aria-labelledby="finalSubmit" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Do you want final submit? 
                  </h5>
                  If you final submit this application you will not change the informations again.
                  <p></p>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-regular fa-circle-xmark"></i></button>
               </div>
               <div class="modal-footer me-auto d-flex justify-content-center">
                  <button name="submit" type="submit" class="btn btn-modal-style btn-theme">Submit</button>
                  <button type="button" class="btn btn-modal-style btn-cancel" data-bs-dismiss="modal">Close</button>
               </div>
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

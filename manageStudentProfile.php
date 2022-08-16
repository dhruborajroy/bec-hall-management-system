<?php 
include('header.php');
$id="";
$name='';
$fname='';
$fOccupation='';
$mname='';
$mOccupation='';
$phoneNumber='';
$presentAddress='';
$permanentAddress='';
$required='required';
$paymentStatus='';
$dob='';
$gender='';
$religion='';
$birthId='';
$bloodGroup='';
$examRoll='';
$legalGuardianName='';
$legalGuardianRelation='';
$image='';
$email='';
$merit='';
$batch='';
$deptId="";
if(isset($_GET['id']) && $_GET['id']!=""){
	$id=get_safe_value($_GET['id']);
    $res=mysqli_query($con,"select * from users where md5(id)='$id'");
	if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $name=$row['name'];
        $roll=$row['roll'];
        $fname=$row['fName'];
        $fOccupation=$row['fOccupation'];
        $mname=$row['mName'];
        $mOccupation=$row['mOccupation'];
        $phoneNumber=$row['phoneNumber'];
        $presentAddress=$row['presentAddress'];
        $permanentAddress=$row['permanentAddress'];
        $dob=$row['dob'];
        $gender=$row['gender'];
        $religion=$row['religion'];
        $birthId=$row['birthId'];
        $ffQuata=$row['ffQuata'];
        $bloodGroup=$row['bloodGroup'];
        $merit=$row['merit'];
        $legalGuardianName=$row['legalGuardianName'];
        $legalGuardianRelation=$row['legalGuardianRelation'];
        $image=$row['image'];
        $email=$row['email'];
        $dept_id=$row['dept_id'];
        $examRoll=$row['examRoll'];
        $batch=$row['batch'];
        $required='';
    }else{
        $_SESSION['PERMISSION_ERROR']=1;
        redirect('index.php');
    }
}
if(isset($_POST['submit'])){
	$name=get_safe_value($_POST['name']);
	$roll=get_safe_value($_POST['roll']);
	$fName=get_safe_value($_POST['fName']);
	$fOccupation=get_safe_value($_POST['fOccupation']);
	$mName=get_safe_value($_POST['mName']);
	$mOccupation=get_safe_value($_POST['mOccupation']);
	$phoneNumber=get_safe_value($_POST['phoneNumber']);
	$presentAddress=get_safe_value($_POST['presentAddress']);
	$permanentAddress=get_safe_value($_POST['permanentAddress']);
	$dob=get_safe_value($_POST['dob']);
	$gender=get_safe_value($_POST['gender']);
	$religion=get_safe_value($_POST['religion']);
	$birthId=get_safe_value($_POST['birthId']);
	$bloodGroup=get_safe_value($_POST['bloodGroup']);
	$examRoll=get_safe_value($_POST['examRoll']);
	$merit=get_safe_value($_POST['merit']);
	$legalGuardianName=get_safe_value($_POST['legalGuardianName']);
	$legalGuardianRelation=get_safe_value($_POST['legalGuardianRelation']);
	$email=get_safe_value($_POST['email']);
    $ffQuata=get_safe_value($_POST['ffQuata']);
    $dept_id=get_safe_value($_POST['dept_id']);
    $batch=get_safe_value($_POST['batch']);
    $time=time();
   if($id==''){
        $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],UPLOAD_STUDENT_IMAGE.$image);
        $sql="INSERT INTO `users` (`name`, `roll`,`fName`, `fOccupation`, `mName`, `mOccupation`, `phoneNumber`, `presentAddress`, `permanentAddress`, `dob`, `gender`, `religion`, `birthId`,`ffQuata`, `bloodGroup`,  `examRoll`, `merit`, `legalGuardianName`, `legalGuardianRelation`, `image`,`email`,`dept_id`,`batch`,`password`, `last_notification`,`meal_status`,`full_month_on`,`guest_meal`,`status`)
                                VALUES ( '$name', '$roll','$fName', '$fOccupation', '$mName', '$mOccupation', '$phoneNumber','$presentAddress','$permanentAddress','$dob','$gender','$religion','$birthId','$ffQuata','$bloodGroup','$examRoll','$merit', '$legalGuardianName','$legalGuardianRelation','$image','$email','$dept_id','$batch','12345678','$time',0,1, 0, 1)";
        
        mysqli_query($con,$sql);
        $_SESSION['INSERT']=1;
   }else{
        if($_FILES['image']['name']!=''){
            $image=rand(111111111,999999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],UPLOAD_STUDENT_IMAGE.$image);
            $sql="update `users` set  `name`='$name',`roll`='$roll', `fName`='$fName',`fOccupation`='$fOccupation',`mName`='$mName',`mOccupation`='$mOccupation',`phoneNumber`='$phoneNumber',`permanentAddress`='$permanentAddress',`dob`='$dob',`gender`='$gender',`religion`='$religion',`batch`='$batch',`birthId`='$birthId',`ffQuata`='$ffQuata',`bloodGroup`='$bloodGroup',`examRoll`='$examRoll',`merit`='$merit',`legalGuardianName`='$legalGuardianName',`legalGuardianRelation`='$legalGuardianRelation',`image`='$image', `email`='$email', `dept_id`='$dept_id'  where md5(id)='$id'";
            mysqli_query($con,$sql);
        }else{
            $sql="update `users` set  `name`='$name', `roll`='$roll',`fName`='$fName',`fOccupation`='$fOccupation',`mName`='$mName',`mOccupation`='$mOccupation',`phoneNumber`='$phoneNumber',`permanentAddress`='$permanentAddress',`dob`='$dob',`gender`='$gender',`religion`='$religion',`batch`='$batch',`birthId`='$birthId',`ffQuata`='$ffQuata',`bloodGroup`='$bloodGroup',`examRoll`='$examRoll',`merit`='$merit',`legalGuardianName`='$legalGuardianName',`legalGuardianRelation`='$legalGuardianRelation',`image`='$image', `email`='$email' , `dept_id`='$dept_id' where  md5(id)='$id'";
            mysqli_query($con,$sql);
        }
        $_SESSION['UPDATE']=1;
    }
    // echo $sql;
    redirect('./users.php');
}
?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Students</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Student Admit Form</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->

    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Manage Details</h3>
                </div>
            </div>
            <form class="new-added-form" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Student's Name *</label>
                        <input class="form-control" placeholder="Student's Name" name="name" id="name" type="text"
                            value="<?php echo $name?>" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Student's ID *</label>
                        <input class="form-control" placeholder="Student's ID" name="roll" id="roll" type="number"
                            value="<?php echo $roll?>" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Father's Name *</label>
                        <input class="form-control" placeholder="Father's Name" autocomplete="off" name="fName"
                            value="<?php echo $fname?>" type="text" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Father's Occupation *</label>
                        <input class="form-control" placeholder="Father's Occupation" autocomplete="off"
                            name="fOccupation" value="<?php echo $fOccupation?>" type="text" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Mother's Name *</label>
                        <input class="form-control" placeholder="Mother's Name" autocomplete="off" name="mName"
                            type="text" required value="<?php echo $mname?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Mother's Occupation *</label>
                        <input class="form-control" placeholder="Mother's Occupation" autocomplete="off"
                            name="mOccupation" type="text" required value="<?php echo $mOccupation?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Phone Number *</label>
                        <input class="form-control" placeholder="Phone Number" autocomplete="off" name="phoneNumber"
                            type="tel" required value="<?php echo $phoneNumber?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Email *</label>
                        <input class="form-control" placeholder="Email" autocomplete="off" name="email" type="email"
                            required value="<?php echo $email?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Present Address*</label>
                        <input class="form-control" placeholder="Present Address" autocomplete="off"
                            name="presentAddress" type="text" required value="<?php echo $presentAddress?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Permanent Address *</label>
                        <input class="form-control" placeholder="Permanent Address" autocomplete="off"
                            name="permanentAddress" type="text" required value="<?php echo $presentAddress?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date of Birth *</label>
                        <input name="dob" value="<?php echo $dob?>" type="text" placeholder="dd/mm/yyyy"
                            class="form-control air-datepicker" data-position="bottom right" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Birth certificate Id number *</label>
                        <input class="form-control" placeholder="Birth certificate Id number" autocomplete="off"
                            name="birthId" type="number" required value="<?php echo $birthId?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Gender *</label>
                        <select class="select2" name="gender" required>
                            <option>Please Select Gender </option>
                            <?php
                        $data=[
                                'name'=>[
                                    'Male',
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
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Blood Group *</label>
                        <select class="form-control select2" name="bloodGroup">
                            <option>Select Blood Group</option>
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
                                if($data['name'][$i]==$bloodGroup){
                                    echo "<option selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                }else{
                                    echo "<option value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                }                                                        
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Religion *</label>
                        <select class="select2" name="religion" required>
                            <option>Please Select Religion </option>
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
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Dept *</label>
                        <select class="form-control select2" name="dept_id">
                            <option>Select Depertment</option>
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `depts` where status='1'");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$dept_id){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                                }                                                        
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Batch *</label>
                        <select class="form-control select2" name="batch">
                            <option>Select Batch</option>
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `batch` where status='1'");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$batch){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                                }                                                        
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Freedom Fighter Quata *</label>
                        <select class="select2" name="ffQuata" required>
                            <option>Please Select ffQuata </option>
                            <?php
                            $data=[
                                'name'=>[
                                    'Yes',
                                    'No',
                                ]
                            ];
                            $count=count($data['name']);
                            for($i=0;$i<$count;$i++){
                                if($data['name'][$i]==$ffQuata){
                                    echo "<option selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                }else{
                                    echo "<option value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                }                                                        
                            }                                       
                        ?>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Exam Roll</label>
                        <input class="form-control" placeholder="Last Exam roll" autocomplete="off" name="examRoll"
                            type="text" required value="<?php echo $examRoll?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Merit</label>
                        <input class="form-control" placeholder="Last Exam Result" autocomplete="off" name="merit"
                            type="text" required value="<?php echo $merit?>">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Legal Guardian Name</label>
                        <input class="form-control" placeholder="Legal Guardian Name" autocomplete="off"
                            name="legalGuardianName" type="text" value="<?php echo $legalGuardianName?>" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Legal Guardian Relation</label>
                        <input class="form-control" placeholder="Legal Guardian Relation" autocomplete="off"
                            name="legalGuardianRelation" type="text" required
                            value="<?php echo $legalGuardianRelation?>">
                    </div>
                    <div class="col-lg-6 col-12 form-group">
                        <div class="col-sm-12 img-body">
                            <div class="center">
                                <div class="form-input">
                                    <div class="preview">
                                        <img id="file_ip_1-preview" <?php if($image!=''){
                                                    echo 'src="'.STUDENT_IMAGE.$image.'"';}
                                                    ?> style="width:200px;height: 200px">
                                    </div>
                                    <label for="file_ip_1">Upload Image</label>
                                    <input type="file" name="image" id="file_ip_1" accept="image/*"
                                        onchange="showPreview(event);" <?php echo $required?>
                                        value="<?php echo $image?>">
                                </div>
                            </div>
                            <script type="text/javascript">
                            function showPreview(event) {
                                if (event.target.files.length > 0) {
                                    var src = URL.createObjectURL(event.target.files[0]);
                                    var preview = document.getElementById("file_ip_1-preview");
                                    preview.src = src;
                                    preview.style.display = "block";
                                }
                            }
                            </script>
                        </div>

                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" name="submit"
                            class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                        <!-- <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Admit Form Area End Here -->

    <?php include('footer.php');?>
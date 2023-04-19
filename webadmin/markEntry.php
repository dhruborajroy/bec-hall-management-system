<?php 
   include("header.php");
   $roll="";
   $exam_id="";
   $month="";
   $year="";
   $time=time();

   if(isset($_GET['exam']) && isset($_GET['year']) && isset($_GET['class']) && isset($_GET['subject']) ){
      $search=true;
      $year=get_safe_value($_GET['year']);
      $class_id=get_safe_value($_GET['class']);
      $subject=get_safe_value($_GET['subject']);
      $exam_id=get_safe_value($_GET['exam']);
      if($year==""){
         $_SESSION['TOASTR_MSG']=array(
            'type'=>'error',
            'body'=>'You don\'t have the permission to access the location!',
            'title'=>'Error',
         );
         redirect("markEntry");
      }elseif($class_id==""){
         $_SESSION['TOASTR_MSG']=array(
            'type'=>'error',
            'body'=>'You don\'t have the permission to access the location!',
            'title'=>'Error',
         );
         redirect("markEntry");
      }elseif($subject==""){
         $_SESSION['TOASTR_MSG']=array(
            'type'=>'error',
            'body'=>'You don\'t have the permission to access the location!',
            'title'=>'Error',
         );
         redirect("markEntry");
      }elseif($exam_id==""){
         $_SESSION['TOASTR_MSG']=array(
            'type'=>'error',
            'body'=>'You don\'t have the permission to access the location!',
            'title'=>'Error',
         );
         redirect("markEntry");
      }elseif($year==""){
         redirect("markEntry");
      }
   }else{

      $_SESSION['TOASTR_MSG']=array(
         'type'=>'error',
         'body'=>'You don\'t have the permission to access the location!',
         'title'=>'Error',
      );
      // redirect("markEntry");
   }
   
   if(isset($_POST['submit']) ){
      $year=get_safe_value($_POST['year']);
      $subject=get_safe_value($_POST['subject']);
      $class_id=get_safe_value($_POST['class']);
      $exam_id=get_safe_value($_POST['exam']);
      $meal_sql="select `mark` from `mark` where sub_id='$subject' and class_id='$class_id'";
      $meal_res=mysqli_query($con,$meal_sql);
      if(mysqli_num_rows($meal_res)>0){
         //update
         $roll_count=count($_POST['roll'])-1;
         $mark_count=count($_POST['mark'])-1;
         for($i=0;$i<=intval($roll_count);$i++){
            for($i=0;$i<=intval($mark_count);$i++){
               $mark= get_safe_value($_POST['mark'][$i]);
               $roll= get_safe_value($_POST['roll'][$i]);
               $meal_sql="select `mark` from `mark` where `exam_roll`='$roll' and `exam_id`='$exam_id' and `sub_id`='$subject'";
               $meal_res=mysqli_query($con,$meal_sql);
               if(mysqli_num_rows($meal_res)>0){
                  echo $swl="UPDATE `mark` SET `mark` = '$mark' WHERE `exam_roll` = '$roll' and class_id='$class_id' and exam_id='$exam_id' and sub_id='$subject' and year='$year'";
                  if(mysqli_query($con,$swl)){
                     // echo "Updated1";
                  }
               }else{
                  echo $swl="INSERT INTO `mark` ( `sub_id`, `exam_roll`, `class_id`, `mark`, `exam_id`, `added_on`,`updated_on`,`year`, `status`) VALUES 
                                                      ( '$subject', '$roll', '$class_id', '$mark','$exam_id','$time','','$year', '1')";
                  if(mysqli_query($con,$swl)){
                     // echo "Updated1";
                  }
               }
            }
         }
         $_SESSION['UPDATE']=1;
      }else{
         //insert
         $roll_count=count($_POST['roll'])-1;
         $mark_count=count($_POST['mark'])-1;
         for($i=0;$i<=intval($roll_count);$i++){
            for($i=0;$i<=intval($mark_count);$i++){
               $mark= get_safe_value($_POST['mark'][$i]);
               $roll= get_safe_value($_POST['roll'][$i]);
               echo $meal_sql="select `mark` from `mark` where `exam_roll`='$roll' and `exam_id`='$exam_id' and `sub_id`='$subject'";
               $meal_res=mysqli_query($con,$meal_sql);
               if(mysqli_num_rows($meal_res)>0){
                  echo $swl="UPDATE `mark` SET `mark` = '$mark' WHERE `exam_roll` = '$roll' and class_id='$class_id' and exam_id='$exam_id' and sub_id='$subject' and year='$year'";
                  if(mysqli_query($con,$swl)){
                     echo "Updated1";
                  }
               }else{
                  echo $swl="INSERT INTO `mark` ( `sub_id`, `exam_roll`, `class_id`, `mark`, `exam_id`, `added_on`,`updated_on`,`year`, `status`) VALUES 
                                                      ( '$subject', '$roll', '$class_id', '$mark','$exam_id','$time','','$year', '1')";
                  if(mysqli_query($con,$swl)){
                     echo "Updated1";
                  }
               }
            }
         }
      }
   
   }
   
   
   ?>
<div class="dashboard-content-one">
   <!-- Breadcubs Area Start Here -->
   <div class="breadcrumbs-area">
      <h3>Meal Maintenance</h3>
      <ul>
         <li>
            <a href="index.php">Home</a>
         </li>
         <li>Mark Entry</li>
      </ul>
   </div>
   <!-- Breadcubs Area End Here -->
   <!-- subject select Start Here -->
   <div class="card height-auto">
      <div class="card-body">
         <div class="heading-layout1">
            <div class="item-title">
            </div>
         </div>
         <div class="col-12">
            <form method="get">
               <div class="row">
                  <div class="col-3">
                     <select name="year" class="select2">
                        <option value="0" disabled selected>Select year</option>
                                 <?php
                                    $data=[
                                          'name'=>[
                                             '2023',
                                             '2022',
                                             '2021',
                                          ]
                                       ];
                                    $count=count($data['name']);
                                    for($i=0;$i<$count;$i++){
                                       if($data['name'][$i]==$year){
                                             echo "<option selected='selected' value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                       }else{
                                             echo "<option value=".$data['name'][$i].">".$data['name'][$i]."</option>";
                                       }                                                        
                                    }
                                    ?>
                     </select>
                  </div>
                  <div class="col-3">
                     <select name="exam" class="select2">
                        <option value="0" disabled selected>Select Exam</option>
                        <?php
                           $res=mysqli_query($con,"SELECT * FROM `exam` where status='1'");
                           while($row=mysqli_fetch_assoc($res)){
                              if($row['id']==$exam_id){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                              }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                              }                                                        
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-3">
                     <select name="class" class="select2">
                        <option value="0" disabled selected>Select Class</option>
                        <?php
                           $res=mysqli_query($con,"SELECT * FROM `class` where status='1'");
                           while($row=mysqli_fetch_assoc($res)){
                              if($row['id']==$class_id){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                              }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                              }                                                        
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-3">
                     <select name="subject" class="select2">
                        <option value="0" disabled selected>Select subject</option>
                        <?php
                           $res=mysqli_query($con,"SELECT * FROM `subjects` where status='1'");
                           while($row=mysqli_fetch_assoc($res)){
                              if($row['id']==$subject){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                              }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                              }                                                        
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-12 form-group mt-3">
                     <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" value="Search">Search</button>
                     <a class="btn-fill-lg bg-blue-dark btn-hover-yellow" href="markEntry">Reset</a>
                  </div>
                  <!-- <input type="submit" value="Search"> -->
               </div>
            </div>
         </form>
      </div>
   </div>
   <!-- subject select end Here -->
<?php if(isset($search)){?>
   <!-- mark entry start here -->
   <div class="card height-auto">
      <div class="card-body">
         <div class="heading-layout1">
            <div class="item-title">
            </div>
         </div>
         <form method="post">
            <table class="table mt-5">
               <thead>
                  <tr>
                     <th>Roll</th>
                     <th>Name</th>
                     <th>Exam Roll</th>
                     <th></th>
                     <!-- <input type="number" id="number" min="0" onkeyup="checkAll()"> -->
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $sql="select * from applicants where class='$class_id' order by id desc";
                     $res=mysqli_query($con,$sql);
                     if(mysqli_num_rows($res)>0){
                     $i=1;
                     while($row=mysqli_fetch_assoc($res)){
                     ?>
                  <tr>
                     <td><?php echo $row['roll']?></td>
                     <input type="hidden" name="year" value="<?php echo $year?>">
                     <input type="hidden" name="subject" value="<?php echo $subject?>">
                     <input type="hidden" name="class" value="<?php echo $class_id?>">
                     <input type="hidden" name="exam" value="<?php echo $exam_id?>">
                     <input type="hidden" name="roll[]" value="<?php echo $row['roll']?>">
                     <td><?php echo $row['first_name']?></td>
                     <td><?php echo $row['examRoll']?></td>
                     <td>
                     <div class="col-6">
                        <input class="mark-entry" id="number_value" type="text" name="mark[]"  value="<?php
                           $meal_sql="select * from `mark` where sub_id='$subject' and class_id='$class_id' and  `mark`.exam_roll=".$row['roll'];
                           $meal_res=mysqli_query($con,$meal_sql);
                           if(mysqli_num_rows($meal_res)>0){
                              $meal_row=mysqli_fetch_assoc($meal_res);
                              echo $meal_row['mark'];
                           };
                           ?>" required></td>
                     </div>   
                  </tr>
                  <?php 
                     $i++;
                     } } else { ?>
                  <tr>
                     <td colspan="5">No data found</td>
                  </tr>
                  <?php } ?>
               </tbody>
            </table>
            <div class="row">
               <div class="col-xl-5 col-lg-5 col-5 form-group"></div>
               <div class="col-xl-2 col-lg-2 col-12 form-group">
                  <button type="button" class="modal-trigger mt-2" data-toggle="modal"
                     data-target="#standard-modal">
                     Save
                  </button>
               </div>
               <!-- Modal -->
               <div class="modal fade" id="standard-modal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title">Are You sure?</h5>
                        </div>
                        <div class="modal-body">
                           Do you want to save the meal table?
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="footer-btn bg-dark-low"
                              data-dismiss="modal">Cancel</button>
                           <button type="submit" name="submit" class="footer-btn bg-linkedin">Save</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <!-- Mark Entry End Here -->
   <?php }?>
</div>
</div>
<?php include("footer.php")?>
<script>
   function checkAll() {
       var number = document.getElementsByClassName("number");
       var number_value = document.getElementById("number_value").value;
       for (let i = 0; i < number.length; i++) {
           number[i].value = number_value;
       }
   }
   function reload(){
      window.location.href="#";
   }
</script>
<?php include("header.php");
   $roll="";
   $exam_id="";
   $month="";
   $year="";
   if(isset($_POST['submit']) ){
      pr($_POST);
      $subjects=get_safe_value($_POST['subjects']);
      $class_id=get_safe_value($_POST['class']);
      $exam_id=get_safe_value($_POST['exam']);
      $meal_sql="select `mark` from `mark` where subject_id='$subjects' and class_id='$class_id'";
      $meal_res=mysqli_query($con,$meal_sql);
      if(mysqli_num_rows($meal_res)>0){
         //update
         $roll_count=count($_POST['roll']);
         $mark_count=count($_POST['mark']);
         for($i=0;$i<=intval($roll_count)-1;$i++){
            for($i=0;$i<=intval($mark_count)-1;$i++){
               $mark= get_safe_value($_POST['mark'][$i]);
               $roll= get_safe_value($_POST['roll'][$i]);
               echo $meal_sql="select `mark` from `mark` where `user_id`='$roll' and `exam_id`='$exam_id' and `sub_id`='$subjects'";
               $meal_res=mysqli_query($con,$meal_sql);
               if(mysqli_num_rows($meal_res)>0){
                  echo $swl="UPDATE `mark` SET `mark` = '$mark' WHERE `user_id` = '$roll' and class_id='$class_id' and exam_id='$exam_id' and year='$year'";
                  if(mysqli_query($con,$swl)){
                     echo "Updated1";
                  }
               }else{
                  echo $swl="INSERT INTO `mark` ( `sub_id`, `user_id`, `class_id`, `mark`, `exam_id`,  `added_on`,`updated_on`, `status`) VALUES 
                                                      ( '$roll', '$meal_value', '$date', '$month','$year','$time','$time', '1')";
                  if(mysqli_query($con,$swl)){
                     echo "Updated1";
                  }
               }
            }
         }
         $_SESSION['UPDATE']=1;
      }else{
         //insert
      }

   }
   
   
   ?>
<style>
   .input_class{
   width: 100%;
   padding: 12px 20px;
   margin: 8px 0;
   display: inline-block;
   border: 1px solid #ccc;
   border-radius: 4px;
   box-sizing: border-box;
   }
</style>
<div class="dashboard-content-one">
   <!-- Breadcubs Area Start Here -->
   <div class="breadcrumbs-area">
      <h3>Meal Maintenance</h3>
      <ul>
         <li>
            <a href="index.php">Home</a>
         </li>
         <li>Meal Maintenance</li>
      </ul>
   </div>
   <!-- Breadcubs Area End Here -->
   <!-- Student Table Area Start Here -->
   <div class="card height-auto">
      <div class="card-body">
         <div class="heading-layout1">
            <div class="item-title">
                  <div class="row">
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
                     <select name="subjects" class="select2">
                        <option value="0" disabled selected>Select subjects</option>
                            <?php
                            $res=mysqli_query($con,"SELECT * FROM `subjects` where status='1'");
                            while($row=mysqli_fetch_assoc($res)){
                                if($row['id']==$class_id){
                                    echo "<option selected='selected' value=".$row['id'].">".$row['name']."</option>";
                                }else{
                                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                                }                                                        
                            }
                            ?>
                     </select>
                     <input type="submit" value="Search">
                  </div>
            </div>
         </div>
         <form method="post">
            <table class="table display data-table text-nowrap">
               <thead>
                  <tr>
                     <th>Roll</th>
                     <th>Name</th>
                     <th>Batch</th>
                     <th>Meal Status</th>
                     <th><input type="number" id="number_value" min="0" onkeyup="checkAll()"></th>
                     <th></th>
                  </tr>
               </thead>
               <tbody id="myTable">
                  <?php
                     $sql="select * from applicants order by id desc";
                     $res=mysqli_query($con,$sql);
                     if(mysqli_num_rows($res)>0){
                     $i=1;
                     while($row=mysqli_fetch_assoc($res)){
                     ?>
                  <tr>
                     <td><?php echo $row['roll']?></td>
                     <input type="hidden" name="subjects" value="<?php echo $subjects?>">
                     <input type="hidden" name="class" value="<?php echo $class_id?>">
                     <input type="hidden" name="exam" value="<?php echo $exam_id?>">
                     <input type="hidden" name="roll[]" value="<?php echo $row['roll']?>">
                     <td><?php echo $row['first_name']?></td>
                     <td><?php echo $row['examRoll']?> batch</td>
                     <td>CE</td>
                     <td><input type="number" name="mark[]" style="input_class number" value="
                        <?php
                           // $meal_sql="select * from `meal_table` where date_id='$date' and month_id='$month' and year='$year' and `meal_table`.roll=".$row['roll'];
                           // $meal_res=mysqli_query($con,$meal_sql);
                           // if(mysqli_num_rows($meal_res)>0){
                           //    $meal_row=mysqli_fetch_assoc($meal_res);
                           //    echo $meal_row['meal_value'];
                           // };
                           ?>" required></td>
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
</div>
</div>
<!-- Student Table Area End Here -->
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
<?php 
include("header.php"); 
if(!isset($_SESSION['APPLICANT_LOGIN'])){
   redirect('index');
}?>
         <div class="page-content instructor-page-content">
            <div class="container">
               <div class="row">
               <?php include("navbar.php")?>
                  <div class="col-xl-9 col-lg-8 col-md-12">
                     <div class="row">
                        <div class="col-md-4 d-flex">
                           <div class="card instructor-card w-100">
                              <div class="card-body">
                                 <div class="instructor-inner">
                                    <h6>Merit</h6>
                                    <h4 class="instructor-text-success">
                                       <?php 
                                       $id=$_SESSION['APPLICANT_ID'];
                                       // SELECT mark.* ,sum(mark) as total, RANK() OVER(ORDER BY sum(mark) DESC) as `rank` FROM mark group by exam_roll;;
                                       $row=mysqli_fetch_assoc(mysqli_query($con,"select merit from applicants where id='$id'"));
                                       // pr($row);
                                       if($row['merit']!==""){
                                          echo addOrdinalNumberSuffix($row['merit']);
                                       }else{
                                          echo "Not published yet";
                                       }
                                       // SELECT *, ROW_NUMBER() OVER(ORDER BY mark) RowNumber FROM mark GROUP by exam_roll;
                                       // SELECT *,sum(mark) as total_mark FROM mark GROUP by exam_roll order by sum(mark) DESC,mark DESC;

                                       ?>
                                    </h4>
                                    <!-- <p>Earning this month</p> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 d-flex">
                           <div class="card instructor-card w-100">
                              <div class="card-body">
                                 <div class="instructor-inner">
                                    <h6>Marks</h6>
                                    <h4 class="instructor-text-info">
                                       <?php 
                                          // echo $exam_roll=$_SESSION['EXAM_ROLL'];
                                          // echo "<br>";
                                          echo $total_mark= getTotalMarks($_SESSION['EXAM_ROLL']);
                                       ?>
                                    </h4>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="settings-widget">
                              <div class="settings-inner-blk p-0">
                                 <div class="sell-course-head comman-space">
                                    <h3>Obtained Marks</h3>
                                 </div>
                                 <div class="comman-space pb-0">
                                    <div class="settings-tickets-blk course-instruct-blk table-responsive">
                                       <table class="table table-nowrap mb-0">
                                          <thead>
                                             <tr>
                                                <th>ID</th>
                                                <th>Subjets</th>
                                                <th>Marks</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php 
                                             $exam_roll=$_SESSION['EXAM_ROLL'];
                                             $sql="SELECT mark.mark,subjects.name FROM `mark`,subjects WHERE subjects.id=mark.sub_id and mark.exam_roll='$exam_roll'";
                                             $res=mysqli_query($con,$sql);
                                             if(mysqli_num_rows($res)>0){
                                             $i=1;
                                             // $total_mark=0;
                                             while($row=mysqli_fetch_assoc($res)){
                                             ?>
                                             <tr>
                                                <td><?php echo $i?></td>
                                                <td><?php echo $row['name']?></td>
                                                <td><?php echo $row['mark'];
                                                // $total_mark=$total_mark+$row['mark'];
                                                ?></td>
                                             </tr>
                                             <?php
                                                $i++;
                                                } } else { ?>
                                             <tr>
                                                <td colspan="5">No data found</td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                          <tfoot>
                                             <tr>
                                                <th colspan="2" align="right">Total Marks</th>
                                                <th><?php echo $total_mark?></th>
                                             </tr>
                                          </tfoot>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<?php include("footer.php")?>

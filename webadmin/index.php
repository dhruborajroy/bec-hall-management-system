<?php 
include('header.php');?>
<div class="dashboard-content-one">
<!-- Breadcubs Area Start Here -->
<div class="breadcrumbs-area">
   <h3>Admin Dashboard</h3>
   <ul>
      <li>
         <a href="index.php">Home</a>
      </li>
      <li>Admin</li>
   </ul>
</div>
<!-- Breadcubs Area End Here -->
<!-- Dashboard summery Start Here -->
<div class="row gutters-20">
   <div class="col-xl-3 col-sm-6 col-12">
      <div class="dashboard-summery-one mg-b-20">
         <div class="row align-items-center">
            <div class="col-6">
               <div class="item-icon bg-light-green ">
                  <!-- <i class="flaticon-classmates text-green"></i> -->
                  <img src="https://cdn-icons-png.flaticon.com/512/2784/2784461.png" alt="" srcset="">
               </div>
            </div>
            <div class="col-6">
               <div class="item-content">
                  <div class="item-title">Applicants</div>
                  <div class="item-number"><span class="counter" data-num="<?php echo $students=gettotalstudent()?>"><?php echo $students?></span></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dashboard summery End Here -->
<!-- Dashboard Content Start Here -->
<div class="row gutters-20">
   <div class="col-lg-12 col-xl-12 col-12-xxxl">
      <div class="card dashboard-card-six pd-b-20">
         <div class="card-body">
            <div class="heading-layout1 mg-b-17">
               <div class="item-title">
                  <h3>Notice Board</h3>
               </div>
            </div>
            <div class="notice-box-wrap">
               <?php 
                  $sql="select * from notice where status='1' order by added_on desc";
                  $res=mysqli_query($con,$sql);
                  if(mysqli_num_rows($res)>0){
                  $i=1;
                  while($row=mysqli_fetch_assoc($res)){
                  ?>
               <div class="notice-list">
                  <div class="post-date bg-orange text-color-black">
                     <?php echo date('d-M-Y h:i A',$row['added_on']);?>
                  </div>
                  <div class="post-date bg-skyblue text-color-black">
                     <?php echo get_time_ago(intval($row['added_on']));?>
                  </div>
                  <h6 class="notice-title"><a href="./pdfreports/notice.php?notice_id=<?php echo $row['id']?>"><?php echo $row['title']?></a></h6>
                  <div class="entry-meta"><?php echo $row['details']?></div>
               </div>
               <?php 
                  $i++;
                  } } else { ?>
               <tr>
                  <td colspan="5">No data found</td>
               </tr>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dashboard Content End Here -->
<?php include('footer.php');?>
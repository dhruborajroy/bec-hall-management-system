<?php include('header.php');?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Admin Dashboard</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Dashboard summery Start Here -->
    <div class="row">
        <!-- Summery Area Start Here -->

        <?php
        $uid=$_SESSION['USER_ID'];
        $sql="select `role` from `users` where id='$uid'";
        $res=mysqli_query($con,$sql);
        $row=mysqli_fetch_assoc($res);
        if($row['role']==2 || $row['role']==4){?>
            <div class="col-lg-4">
                <div class="dashboard-summery-one">
                    <div class="row">
                        <div class="col-6">
                            <div class="item-icon bg-light-magenta">
                                <i class="flaticon-shopping-list text-magenta"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-content">
                                <div class="item-title">Meal Amount</div>
                                <?php
                                $getTotalMeal=getTotalMeal(date("m"),$_SESSION['USER_ROLL']);
                                $getMealRate=round(getMealRate(date("m")),2);
                                $getTotalFee=round($getTotalMeal*$getMealRate,2);
                                ?>
                                <div class="item-number"><span class="counter" data-num="<?php echo $getTotalFee?>"><?php echo $getTotalFee?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php 
                }
                ?>
        <div class="col-lg-4">
            <div class="dashboard-summery-one">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-calendar text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Total Meal On</div>
                            <div class="item-number"><span class="counter" data-num="<?php 
                                $getTotalMeal=getTotalMeal(date("m"),$_SESSION['USER_ROLL']); echo $getTotalMeal."\">". $getTotalMeal?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if($row['role']==2 || $row['role']==4){?>
        <div class="col-lg-4">
            <div class="dashboard-summery-one">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon bg-light-yellow">
                            <i class="flaticon-percentage-discount text-orange"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">Meal Rate</div>
                            <div class="item-number"><span class="counter" data-num="<?php echo $getMealRate."\">". $getMealRate?></span></div>                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Summery Area End Here -->
        <?php }?>

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
                  <h6 class="notice-title"><a href="../webadmin/pdfreports/notice.php?notice_id=<?php echo $row['id']?>"><?php echo $row['title']?></a></h6>
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
    <?php include('footer.php');?>
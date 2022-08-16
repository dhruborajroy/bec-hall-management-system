<?php include('header.php');?>
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
                  <div class="item-title">Students</div>
                  <div class="item-number"><span class="counter" data-num="<?php echo $students=gettotalstudent()?>"><?php echo $students?></span></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-sm-6 col-12">
      <div class="dashboard-summery-one mg-b-20">
         <div class="row align-items-center">
            <div class="col-6">
               <div class="item-icon bg-light-yellow">
                  <video width="100" height="100" preload="none" style="background: transparent  url('https://cdn-icons-png.flaticon.com/512/6172/6172509.png') 50% 50% / fit no-repeat;" autoplay="autoplay" loop="true" muted="muted" playsinline="">
                     <source src="https://cdn-icons-mp4.flaticon.com/512/6172/6172509.mp4" type="video/mp4">
                  </video>
               </div>
            </div>
            <div class="col-6">
               <div class="item-content">
                  <div class="item-title">Expense</div>
                  <div class="item-number"><span class="counter" data-num="<?php echo $getTotalExpense=getTotalExpense(date("m",time()));?>"><?php echo $getTotalExpense?></span></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-sm-6 col-12">
      <div class="dashboard-summery-one mg-b-20">
         <div class="row align-items-center">
            <div class="col-6">
               <div class="item-icon bg-light-red">
                  <video width="100" height="100" preload="none" style="background: transparent  url('https://cdn-icons-png.flaticon.com/512/6569/6569129.png') 50% 50% / fit no-repeat;" autoplay="autoplay" loop="true" muted="muted" playsinline="">
                     <source src="https://cdn-icons-mp4.flaticon.com/512/6569/6569129.mp4" type="video/mp4">
                  </video>
               </div>
            </div>
            <div class="col-6">
               <div class="item-content">
                  <div class="item-title">Total Meal</div>
                  <div class="item-number"><span class="counter"
                     data-num="<?php echo $getTotalMeal=getTotalMeal(date("m"))?>"><?php echo $getTotalMeal?><span></span></span></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-xl-3 col-sm-6 col-12">
      <div class="dashboard-summery-one mg-b-20">
         <div class="row align-items-center">
            <div class="col-6">
               <div class="item-icon bg-light-blue">
                  <!-- <img src="https://cdn-icons-png.flaticon.com/512/7532/7532806.png" alt=""> -->
                  <!-- <video width="100" height="100" preload="none" style="background: transparent  url('https://cdn-icons-png.flaticon.com/512/7994/7994401.png') 50% 50% / fit no-repeat;" autoplay="autoplay" loop="true" muted="muted" playsinline="">
                     <source src="https://cdn-icons-mp4.flaticon.com/512/7994/7994401.mp4" type="video/mp4">
                     </video> -->
                  <video width="100" height="100" preload="none" style="background: transparent  url('https://cdn-icons-png.flaticon.com/512/8112/8112939.png') 50% 50% / fit no-repeat;" autoplay="autoplay" loop="true" muted="muted" playsinline="">
                     <source src="https://cdn-icons-mp4.flaticon.com/512/8112/8112939.mp4" type="video/mp4">
                  </video>
               </div>
            </div>
            <div class="col-6">
               <div class="item-content">
                  <div class="item-title">Current Meal Rate</div>
                  <div class="item-number"><span class="counter" data-num="<?php $meal_rate=getMealRate(date("m"));echo $meal_rate=round($meal_rate,2)?>"><?php echo $meal_rate?></span></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dashboard summery End Here -->
<!-- Dashboard Content Start Here -->
<div class="row gutters-20">
   <div class="col-12 col-xl-12 col-12-xxxl">
      <div class="card dashboard-card-two pd-b-20">
         <div class="card-body">
            <div class="heading-layout1">
               <div class="item-title">
                  <h3>Expenses</h3>
               </div>
            </div>
            <div class="expense-report">
               <!-- <div class="monthly-expense pseudo-bg-Aquamarine">
                  <div class="expense-date">Jan 2019</div>
                  <div class="expense-amount"><span>$</span> 15,000</div>
                  </div>
                  <div class="monthly-expense pseudo-bg-blue">
                  <div class="expense-date">Feb 2019</div>
                  <div class="expense-amount"><span>$</span> 10,000</div>
                  </div>
                  <div class="monthly-expense pseudo-bg-yellow">
                  <div class="expense-date">Mar 2019</div>
                  <div class="expense-amount"><span>$</span> 8,000</div>
                  </div> -->
            </div>
            <div class="expense-chart-wrap">
               <canvas id="expense-bar-chart" width="100" height="300"></canvas>
            </div>
         </div>
      </div>
   </div>
   <div class="col-lg-6 col-xl-6 col-12-xxxl">
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
                  <h6 class="notice-title"><a href="#"><?php echo $row['title']?></a></h6>
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
   <div class="col-lg-6 col-xl-6 col-12-xxxl">
      <div class="card dashboard-card-six">
         <div class="card-body">
            <div class="heading-layout1 mg-b-17">
               <div class="item-title">
                  <h3>Expense Category wise Pie chart</h3>
               </div>
            </div>
            <div class="col-lg-12 col-xl-12 col-12-xxxl">
               <div id="piechart"></div>
               <div>
                     <table>
                        <th>
                           <td>
                              Name
                           </td>
                           <td>
                              Amount
                           </td>
                        </th>
                        <?php 
                        $res=mysqli_query($con,"SELECT SUM(amount) as amount, expense_category.name from expense, expense_category WHERE expense.expense_category_id=expense_category.id group by expense_category.id");
                        if(mysqli_num_rows($res)>0){
                              while($row=mysqli_fetch_assoc($res)){?>
                                 <tr style="margin: 10px;padding:10px">
                                    <td>
                                       <?php echo $row['name']?>: 
                                    </td>
                                    <td style="padding-left: 10px;">
                                       <?php echo $row['amount']?> Taka
                                    </td>
                                 </tr>
                              <?php }
                        }else{
                           
                        }
                        ?>

                     </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dashboard Content End Here -->
<?php include('footer.php');?>
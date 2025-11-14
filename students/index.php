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
                            <div class="item-title">Total Unpaid Amount</div>
                            <div class="item-number"><span class="counter" data-num="<?php 
                                $getTotalAmount=getTotalAmount($_SESSION['USER_ID'],0); echo $getTotalAmount."\">". $getTotalAmount?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="item-title">Total Paid Amount</div>
                            <div class="item-number"><span class="counter" data-num="<?php 
                                $getTotalAmount=getTotalAmount($_SESSION['USER_ID'],1); echo $getTotalAmount."\">". $getTotalAmount?></span></div>
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
            </div>
            <div class="expense-chart-wrap">
               <canvas id="monthly_payment_chart" width="100" height="300"></canvas>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Dashboard Content End Here -->
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
<?php
$monthlyDue = [];
$monthLabels = [];

for ($i = 11; $i >= 0; $i--) {
    // Find month & year of each past month
    $timestamp = strtotime("-$i months");
    $month = date('m', $timestamp);
    $year  = date('Y', $timestamp);

    // Label for chart (e.g., Feb 2025 → "Feb")
    $monthLabels[] = date('M', $timestamp);

    $sql = "SELECT SUM(amount) AS base_total, COUNT(*) AS month_count 
            FROM monthly_bill 
            WHERE user_id = ".$_SESSION['USER_ID']."
            AND month_id = '$month'
            AND year = '$year'";

    $res = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($res);

    $base_total  = $row['base_total'] ?? 0;
    $month_count = $row['month_count'] ?? 0;

    // Fixed fees
    $conti = CONTINGENCY_FEE;
    $hall  = HALL_FEE;
    $elec  = ELECTRICITY_FEE;

    // Full total for this month
    $total_due = $base_total + ($month_count * ($conti + $hall + $elec));

    $monthlyDue[] = $total_due;
}
?>

<script>
(function ($) {

if ($("#monthly_payment_chart").length) {

    var barChartData = {
        labels: [<?php echo '"' . implode('","', $monthLabels) . '"'; ?>],

        datasets: [
            {
                label: "Total Monthly Due",
                backgroundColor: [
                    "#40dfcd", "#417dfc", "#ffaa01",
                    "#40dfcd", "#417dfc", "#ffaa01",
                    "#40dfcd", "#417dfc", "#ffaa01",
                    "#40dfcd", "#417dfc", "#ffaa01"
                ],
                data: [
                    <?php echo implode(",", array_map('floatval', $monthlyDue)); ?>
                ]
            }
        ]
    };

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 2000 },

        scales: {
            xAxes: [{
                display: true,
                gridLines: { display: false }
            }],
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                    stepSize: 5000,
                    callback: function (value) {
                        if (value >= 1000000) return value / 1000000 + "M";
                        if (value >= 1000) return value / 1000 + "k";
                        return value;
                    }
                },
                gridLines: { display: true }
            }]
        },

        legend: { display: true },
        tooltips: { enabled: true }
    };

    var ctx = $("#monthly_payment_chart").get(0).getContext("2d");
    new Chart(ctx, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    });
}

})(jQuery);
</script>

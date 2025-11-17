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
                  <div class="item-title">Full Month's Collection</div>
                  <div class="item-number"><span class="counter" data-num="<?php echo $getTotalPaymentsToday=getTotalFromPaymentDetails();?>"><?php echo $getTotalPaymentsToday?></span></div>
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
                  <div class="item-title">Today's Collection</div>
                  <div class="item-number"><span class="counter" data-num="<?php echo $getTotalPaymentsToday=getTotalFromPaymentDetails(strtotime("today 00:00"),strtotime("tomorrow 00:00") - 1);?>"><?php echo $getTotalPaymentsToday?></span></div>
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
                  <div class="item-title">Total Due</div>
                  <div class="item-number"><span class="counter" data-num="<?php echo $getTotalAmount=getTotalAmount();?>"><?php echo $getTotalAmount?></span></div>
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
                  <div class="item-title">Total SMS Balance</div>
                  <div class="item-number"><span class="counter"
                     data-num="<?php echo $getTotalSMS=check_sms("513900504017582214400b569e316a2c126d7990b1a24eecc435")?>"><?php echo $getTotalSMS?> TK<span></span></span></div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- <div class="col-xl-3 col-sm-6 col-12">
      <div class="dashboard-summery-one mg-b-20">
         <div class="row align-items-center">
            <div class="col-6">
               <div class="item-icon bg-light-blue">
                  <img src="https://cdn-icons-png.flaticon.com/512/7532/7532806.png" alt="">
                  <video width="100" height="100" preload="none" style="background: transparent  url('https://cdn-icons-png.flaticon.com/512/7994/7994401.png') 50% 50% / fit no-repeat;" autoplay="autoplay" loop="true" muted="muted" playsinline="">
                     <source src="https://cdn-icons-mp4.flaticon.com/512/7994/7994401.mp4" type="video/mp4">
                     </video>
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
   </div> -->
</div>
<!-- Dashboard summery End Here -->

<!-- Dashboard Content Start Here -->
<div class="row gutters-20">
   <div class="col-12 col-xl-12 col-12-xxxl">
      <div class="card dashboard-card-two pd-b-20">
         <div class="card-body">
            <div class="heading-layout1">
               <div class="item-title">
                  <h3>Monthly Due</h3>
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
            WHERE  month_id = '$month'
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
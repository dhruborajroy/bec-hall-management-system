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
                            $getTotalMeal=getTotalMeal(date("m"),'200129');
                            $getMealRate=round(getMealRate(date("m")),2);
                            $getTotalFee=round($getTotalMeal*$getMealRate,2);
                            ?>
                            <div class="item-number"><span class="counter" data-num="<?php echo $getTotalFee?>"><?php echo $getTotalFee?></span></div>
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
                            <div class="item-title">Total Meal On</div>
                            <div class="item-number"><span class="counter" data-num="<?php echo $getTotalMeal."\">". $getTotalMeal?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
    <?php include('footer.php');?>
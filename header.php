<?php 
   session_start();
   session_regenerate_id();
   require('./inc/constant.inc.php');
   require('./inc/connection.inc.php');
   require('./inc/function.inc.php');
   require_once("./inc/smtp/class.phpmailer.php");
?>
<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>BEC HALL | Developed by Dhrubo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="fonts/flaticon.css">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="css/select2.min.css">
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="css/jquery.dataTables.min.css">
    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="css/datepicker.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="css/summernote.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="css/toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/invoice.css">
    <!-- Modernize js -->
    <script src="js/modernizr-3.6.0.min.js"></script>
    <!-- editor -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.4.33/example1/colorbox.css" rel="stylesheet">
    <!-- include summernote css/js -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet"> -->
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <div id="wrapper" class="wrapper bg-ash">
        <!-- Header Menu Area Start Here -->
        <div class="navbar navbar-expand-md header-menu-one bg-light">
            <div class="nav-bar-header-one">
                <div class="header-logo">
                    <a href="index.php">
                        <img src="img/logo.png" alt="logo">
                    </a>
                </div>
                <div class="toggle-button sidebar-toggle">
                    <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="d-md-none mobile-nav-bar">
                <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
                    data-target="#mobile-navbar" aria-expanded="false">
                    <i class="far fa-arrow-alt-circle-down"></i>
                </button>
                <button type="button" class="navbar-toggler sidebar-toggle-mobile">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
                <ul class="navbar-nav">
                    <li class="navbar-item header-search-bar">
                        <div class="input-group stylish-input-group">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <!-- <span class="flaticon-search" aria-hidden="true"></span> -->
                                </button>
                            </span>
                            <!-- <input type="text" class="form-control" placeholder="Find Something . . ."> -->
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">
                                <h5 class="item-title">Dhrubo</h5>
                                <span>Admin</span>
                            </div>
                            <div class="admin-img">
                                <img src="img/figure/admin.jpg" alt="Admin">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">Welcome Dhrubo</h6>
                            </div>
                            <div class="item-content">
                                <ul class="settings-list">
                                    <li><a href="profile.php"><i class="flaticon-user"></i>My Profile</a></li>
                                    <li><a href="logout.php"><i class="flaticon-turn-off"></i>Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- <li class="navbar-item dropdown header-message">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="far fa-envelope"></i>
                            <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                            <span>5</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">05 Message</h6>
                            </div>
                            <div class="item-content">
                                <div class="media">
                                    <div class="item-img bg-skyblue author-online">
                                        <img src="img/figure/student11.png" alt="img">
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="item-title">
                                            <a href="#">
                                                <span class="item-name">Maria Zaman</span>
                                                <span class="item-time">18:30</span>
                                            </a>
                                        </div>
                                        <p>What is the reason of buy this item.
                                            Is it usefull for me.....</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> -->
                    <li class="navbar-item dropdown header-notification">
                        <?php 
                            // $sql="select notice.*,count(notice.id) as time from notice,users where notice.status='1' and notice.added_on  BETWEEN users.last_notification AND '".time()."'";
                            // $sql="select count(id) from notice where notice.added_on=";
                            if(isset($_SESSION['LAST_NOTIFICATION'])){
                                $session=$_SESSION['LAST_NOTIFICATION'];
                            }else{
                                $session=time();
                            }
                            $sql="select count(id) as number from notice where added_on between ".$session." AND '".time()."'";
                            $res=mysqli_query($con,$sql);
                            $counter=mysqli_fetch_assoc($res);
                            ?>

                        <a class="navbar-nav-link dropdown-toggle" onclick="read_notification('<?php echo time()?>')"
                            role="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-bell"></i>
                            <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                            <?php 
                                $number=$counter['number'];
                            if($number!=0){?>
                            <span id="counter">
                                <?php echo $number;?>
                            </span><?php } ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title"><?php echo $number?> unread Notifiacations</h6>
                            </div>
                            <?php 
                            $sql="select * from notice where status=1 order by added_on desc limit 5";
                            $res=mysqli_query($con,$sql);
                            if(mysqli_num_rows($res)>0){
                            $i=1;
                            while($row=mysqli_fetch_assoc($res)){
                            ?>
                            <div class="item-content">
                                <div class="media">
                                    <div class="item-icon bg-violet-blue">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                    <div class="media-body space-sm">
                                        <div class="post-title"><?php echo $row['title']?></div>
                                        <span><?php echo get_time_ago(intval($row['added_on']));?></span>
                                    </div>
                                </div>
                            </div>
                            <?php 
                           $i++;
                           } } else { ?>
                            <tr>
                                <td colspan="5">No data found</td>
                            </tr>
                            <?php } ?>
                        </div>
                    </li>
                    <li class="navbar-item dropdown header-language">
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
                <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="index.php"><img src="img/logo1.png" alt="logo"></a>
                    </div>
                </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php // echo  $index_active?>">
                            <i class="flaticon-dashboard"></i>
                            <!-- <img src="https://cdn-icons.flaticon.com/png/512/1991/premium/1991103.png?token=exp=1660534293~hmac=aeb4ee5cccf12d77eebb77e03a15741c" alt="dashboard-icon" srcset=""> -->
                            <span>Dashboard</span></a>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Users</span></a>
                            <ul class="nav sub-group-menu <?php // echo  $application_group_active?>">
                                <li class="nav-item">
                                    <a href="users.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Users</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manageStudentProfile.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new Application</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-money text-red"></i><span>Expenses</span></a>
                            <ul class="nav sub-group-menu <?php // echo  $application_group_active?>">
                                <li class="nav-item">
                                    <a href="expense.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Expenses</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manageExpense.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new Expenses</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="makePayment.php" class="nav-link <?php // echo  $index_active?>"><i
                                    class="flaticon-checklist"></i><span>Manage Payment</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="mealCheck.php" class="nav-link <?php // echo  $index_active?>"><i
                                    class="flaticon-shopping-list"></i><span>Meal Maintanance</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="mealStatus.php" class="nav-link <?php // echo  $index_active?>"><i
                                    class="flaticon-chat"></i><span>Meal Status</span></a>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-script"></i><span>Notices</span></a>
                            <ul class="nav sub-group-menu <?php // echo  $application_group_active?>">
                                <li class="nav-item">
                                    <a href="notices.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Notices</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manage_notice.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new notice</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="mealOnOffRequests.php" class="nav-link <?php // echo  $index_active?>"><i
                                    class="flaticon-menu-1"></i><span>Meal On Off Requests</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="monthlyPayment.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-planet-earth"></i><span>Monthly Payment</span></a>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-books"></i><span>Fees</span></a>
                            <ul class="nav sub-group-menu <?php // echo  $application_group_active?>">
                                <li class="nav-item">
                                    <a href="fees.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Fees</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manageFees.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new Fees</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-technological"></i><span>Expense Category</span></a>
                            <ul class="nav sub-group-menu <?php // echo  $application_group_active?>">
                                <li class="nav-item">
                                    <a href="expenseCategory.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Expense Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manageExpenseCategory.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new Expense Category</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="flaticon-open-book"></i><span>Departments and
                                    Batches</span></a>
                            <ul class="nav sub-group-menu <?php // echo  $application_group_active?>">
                                <li class="nav-item">
                                    <a href="depts.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Departments</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manageDepts.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new Department</a>
                                </li>
                                <li class="nav-item">
                                    <a href="batches.php"
                                        class="nav-link <?php // echo  $application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>All
                                        Batches</a>
                                </li>
                                <li class="nav-item">
                                    <a href="manageBatches.php"
                                        class="nav-link <?php // echo  $manage_application_sub_group_active?>"><i
                                            class="fas fa-angle-right"></i>Add new Batch</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sidebar Area End Here -->
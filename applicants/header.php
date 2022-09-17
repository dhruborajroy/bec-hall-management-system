<?php 
   session_start();
   session_regenerate_id();
   require('../webadmin/inc/constant.inc.php');
   require('../webadmin/inc/connection.inc.php');
   require('../webadmin/inc/function.inc.php');
   require_once("../webadmin/inc/smtp/class.phpmailer.php");
   isUSER();
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
    <link rel="stylesheet" href="../webadmin/css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="../webadmin/css/main.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../webadmin/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../webadmin/css/all.min.css">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="../webadmin/fonts/flaticon.css">
    <!-- Full Calender CSS -->
    <link rel="stylesheet" href="../webadmin/css/fullcalendar.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="../webadmin/css/animate.min.css">
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="../webadmin/css/select2.min.css">
    <!-- Data Table CSS -->
    <link rel="stylesheet" href="../webadmin/css/jquery.dataTables.min.css">
    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="../webadmin/css/datepicker.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="../webadmin/css/toastr.min.css">
    <link rel="stylesheet" href="../webadmin/css/style.css">
    <!-- Modernize js -->
    <script src="../js/modernizr-3.6.0.min.js"></script>
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
                        <img src="../webadmin/img/logo.png" alt="logo" width="170px">
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
                <?php 
                $uid=$_SESSION['USER_ID']; 
                $sql="select * from users where id='$uid'";
                $row=mysqli_fetch_assoc(mysqli_query($con,$sql));
                ?>
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">
                                <h5 class="item-title"><?php echo $row['name']?></h5>
                                <span>Student</span>
                            </div>
                            <div class="admin-img">
                                <img src="<?php echo STUDENT_IMAGE.$row['image']?>" alt="user photo" width="50px" height="50px">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">Welcome <?php echo $row['name']?></h6>
                            </div>
                            <div class="item-content">
                                <ul class="settings-list">
                                    <li><a href="profile.php"><i class="flaticon-user"></i>My Profile</a></li>
                                    <li><a href="logout.php"><i class="flaticon-turn-off"></i>Log Out</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="navbar-item dropdown header-notification">
                        <?php 
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
                                    <a href="../webadmin/pdfreports/notice.php?notice_id=<?php echo $row['id']?>">
                                    <div class="media-body space-sm">
                                        <div class="post-title"><?php echo $row['title']?></div>
                                        <span><?php echo get_time_ago(intval($row['added_on']));?></span>
                                    </div>
                                    </a>
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
                        <a href="index.php"><img src="../img/logo1.png" alt="logo"></a>
                    </div>
                </div>
                <div class="sidebar-menu-content">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                        </li>
                        <?php 
                        $sql="select `role` from `users` where id='$uid'";
                        $res=mysqli_query($con,$sql);
                        $row=mysqli_fetch_assoc($res);
                        if($row['role']==2){?>
                            <li class="nav-item">
                                <a href="mealCheck.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Meal Maintance</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="mealStatus.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Meal Status</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="mealOnOffRequests.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>meal On Off Requests</span></a>
                            </li>
                        <?php }?>
                        <?php
                        if($row['role']==3){?>
                            <li class="nav-item">
                                <a href="mealAudit.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Audit</span></a>
                            </li>
                        <?php }?>
                        <?php
                        if($row['role']==4){?>
                            <li class="nav-item">
                                <a href="expense.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Expense</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="manageExpense.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Add new expense</span></a>
                            </li>
                        <?php }?>
                        <li class="nav-item">
                            <a href="managePayment.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Pay online</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="mealOnOffReq2.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Meal On Off Request</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="mealOnOffReq.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Guest Meal On Off Request</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="complaint_box.php" class="nav-link <?php // echo  $index_active?>"><i class="flaticon-dashboard"></i><span>Complaint Box</span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sidebar Area End Here -->
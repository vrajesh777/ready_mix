<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv=X-UA-Compatible content="IE=9;IE=10;IE=11;IE=Edge,chrome=1">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=320, height=device-height" />
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo e(Config::get('app.project.title')); ?> | <?php echo e($page_title ?? ''); ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('/')); ?>images/icon.jpg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/bootstrap.min.css')); ?>">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/fontawesome-v5.7.2-pro.min.css')); ?>">

    <!-- Bootstrap dataTables CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/datatables/dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/css/datatables/responsive.dataTables.min.css')); ?>">

    <!-- Bootstrap DatePicker CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/bootstrap-datepicker.min.css')); ?>">

    <!--font style-->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&amp;display=swap" rel="stylesheet">


    <!-- Chart CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/morris.css')); ?>">
   

    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/theme-settings.css')); ?>">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/select2.min.css')); ?>">

    <!-- Notifications CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/notifications.min.css')); ?>">

    <!-- jQuery -->
    <script src="<?php echo e(asset('/js/jquery-3.5.0.min.js')); ?>"></script>

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/sweetalert.min.css')); ?>">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/style.css')); ?>">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('/css/loader.css')); ?>">
     <?php if(\App::getLocale() == 'ar'): ?>
     <link rel="stylesheet" href="<?php echo e(asset('/css/rtl.css')); ?>">
     <?php endif; ?>
     <link rel="stylesheet" href="<?php echo e(asset('/css/print.css')); ?>">

</head>
    <body id="skin-color" class="skin-color inter">
        <!-- Main Wrapper -->
        <div class="main-wrapper">
        
            <!-- Header -->
            <div class="header main-header" id="heading">
            
                <!-- Logo -->
                <div class="header-left">
                    <a href="<?php echo e(url('/')); ?>" class="logo">
                        <img src="<?php echo e(asset('/')); ?>images/logo1.png" alt="<?php echo e(Config::get('app.project.title')); ?>" class="sidebar-logo">
                        <img src="<?php echo e(asset('/')); ?>images/s-logo.png" alt="<?php echo e(Config::get('app.project.title')); ?>" class="mini-sidebar-logo">
                    </a>
                </div>
                <!-- /Logo -->

                <a id="toggle_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>

                <style type="text/css">
                    .head-attend-wrap .btn { margin: 10px;position: absolute; }
                </style>

                <div class="head-attend-wrap" id="attend_div">
                    <?php if(isset($arr_login_user['is_check_in']) && $arr_login_user['is_check_in'] == '1'): ?>
                        <button class="btn btn-danger btn-attend" value="check_out"><?php echo e(trans('admin.check_out')); ?> <i class="fa fa-clock"></i></button>
                        <span class="currTime"></span>
                    <?php elseif(isset($arr_login_user['is_check_in']) && $arr_login_user['is_check_in'] == '0'): ?>
                        <button class="btn btn-success btn-attend" value="check_in"><?php echo e(trans('admin.check_in')); ?> <i class="fa fa-clock"></i></button>
                    <?php endif; ?>
                </div>
            


                <!-- Header Title -->
                
                <!-- /Header Title -->
                
                <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fal fa-bars"></i></a>
                
                <!-- Header Menu -->
                <ul class="nav user-menu">
                
                    <!-- Search -->
                    <li class="nav-item">
                        
                    </li>
                    <!-- /Search -->
                
                    <!-- Flag -->
                   
                    <li class="nav-item dropdown has-arrow flag-nav">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                            <?php
                             $locale = Session::get('locale');
                            ?>
                            <?php if($locale=='en'): ?>
                            <img src="<?php echo e(asset('/')); ?>images/us.png" alt="" height="20"> <span><?php echo e(trans('admin.english')); ?></span>
                            <?php else: ?>
                            <img src="<?php echo e(asset('/')); ?>images/sa.png" alt="" height="20"> <span><?php echo e(trans('admin.arebic')); ?></span>

                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?php echo e(url('/')); ?>/set-locale/en" class="dropdown-item">
                                <img hre src="<?php echo e(asset('/')); ?>images/us.png" alt="" height="16"> English
                            </a>
                            <a href="<?php echo e(url('/')); ?>/set-locale/ar" class="dropdown-item">
                                <img src="<?php echo e(asset('/')); ?>images/sa.png" alt="" height="16"> Arabic
                            </a>
                        </div>
                    </li>
                    <!-- /Flag -->
                
                    <!-- Notifications -->
                    
                    <!-- /Notifications -->
                    
                    <!-- Message Notifications -->
                    
                    <!-- /Message Notifications -->

                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img src="<?php echo e(asset('/')); ?>images/default.png" alt="">
                            <span class="status online"></span></span>
                            <span><?php echo e($arr_login_user['first_name'] ?? ''); ?> <?php echo e($arr_login_user['last_name'] ?? ''); ?></span>
                        </a>
                        <div class="dropdown-menu">
                            
                            <a class="dropdown-item" href="<?php echo e(url('/logout')); ?>">Logout</a>
                        </div>
                    </li>
                </ul>
                <!-- /Header Menu -->
                
                <!-- Mobile Menu -->
                <div class="dropdown mobile-user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fal fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="profile.html">My Profile</a>
                        <a class="dropdown-item" href="settings.html">Settings</a>
                        <a class="dropdown-item" href="<?php echo e(url('/logout')); ?>">Logout</a>
                    </div>
                </div>
                <!-- /Mobile Menu -->
                
            </div>
            <!-- /Header --><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/layout/_header.blade.php ENDPATH**/ ?>
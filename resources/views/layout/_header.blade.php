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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ Config::get('app.project.title') }} | {{ $page_title ?? '' }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}images/icon.jpg">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('/css/fontawesome-v5.7.2-pro.min.css') }}">

    <!-- Bootstrap dataTables CSS -->
    <link rel="stylesheet" href="{{ asset('/css/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/datatables/responsive.dataTables.min.css') }}">

    <!-- Bootstrap DatePicker CSS -->
    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.min.css') }}">

    <!--font style-->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&amp;display=swap" rel="stylesheet">


    <!-- Chart CSS -->
    <link rel="stylesheet" href="{{ asset('/css/morris.css') }}">
   

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('/css/theme-settings.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('/css/select2.min.css') }}">

    <!-- Notifications CSS -->
    <link rel="stylesheet" href="{{ asset('/css/notifications.min.css') }}">

    <!-- jQuery -->
    <script src="{{ asset('/js/jquery-3.5.0.min.js') }}"></script>

    <!-- Sweet Alert -->
    <link rel="stylesheet" href="{{ asset('/css/sweetalert.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('/css/loader.css') }}">
     @if(\App::getLocale() == 'ar')
     <link rel="stylesheet" href="{{ asset('/css/rtl.css') }}">
     @endif
     <link rel="stylesheet" href="{{ asset('/css/print.css') }}">

</head>
    <body id="skin-color" class="skin-color inter">
        <!-- Main Wrapper -->
        <div class="main-wrapper">
        
            <!-- Header -->
            <div class="header main-header" id="heading">
            
                <!-- Logo -->
                <div class="header-left">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset('/') }}images/logo1.png" alt="{{ Config::get('app.project.title') }}" class="sidebar-logo">
                        <img src="{{ asset('/') }}images/s-logo.png" alt="{{ Config::get('app.project.title') }}" class="mini-sidebar-logo">
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
                    @if(isset($arr_login_user['is_check_in']) && $arr_login_user['is_check_in'] == '1')
                        <button class="btn btn-danger btn-attend" value="check_out">{{ trans('admin.check_out') }} <i class="fa fa-clock"></i></button>
                        <span class="currTime"></span>
                    @elseif(isset($arr_login_user['is_check_in']) && $arr_login_user['is_check_in'] == '0')
                        <button class="btn btn-success btn-attend" value="check_in">{{ trans('admin.check_in') }} <i class="fa fa-clock"></i></button>
                    @endif
                </div>
            


                <!-- Header Title -->
                {{-- <div class="page-title-box">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fal fa-search"></i>
                       </a>
                        <form action="https://crms-html.dreamguystech.com/light/search.html">
                            <input class="form-control" type="text" placeholder="Search here">
                            <button class="btn" type="submit"><i class="fal fa-search"></i></button>
                        </form>
                    </div>
                </div> --}}
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
                            @if($locale=='en')
                            <img src="{{ asset('/') }}images/us.png" alt="" height="20"> <span>{{ trans('admin.english') }}</span>
                            @else
                            <img src="{{ asset('/') }}images/sa.png" alt="" height="20"> <span>{{ trans('admin.arebic') }}</span>

                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ url('/') }}/set-locale/en" class="dropdown-item">
                                <img hre src="{{ asset('/') }}images/us.png" alt="" height="16"> English
                            </a>
                            <a href="{{ url('/') }}/set-locale/ar" class="dropdown-item">
                                <img src="{{ asset('/') }}images/sa.png" alt="" height="16"> Arabic
                            </a>
                        </div>
                    </li>
                    <!-- /Flag -->
                
                    <!-- Notifications -->
                    {{-- <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="fal fa-bell "></i> <span class="badge badge-pill">3</span>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Notifications</span>
                                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list">
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ asset('/') }}images/avatar-02.jpg">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                                    <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ asset('/') }}images/avatar-03.jpg">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                                    <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ asset('/') }}images/avatar-06.jpg">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                                    <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ asset('/') }}images/avatar-17.jpg">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                                    <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="activities.html">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="{{ asset('/') }}images/avatar-13.jpg">
                                                </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                                    <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="activities.html">View all Notifications</a>
                            </div>
                        </div>
                    </li> --}}
                    <!-- /Notifications -->
                    
                    <!-- Message Notifications -->
                    {{-- <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <i class="fal fa-comment "></i> <span class="badge badge-pill">8</span>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span class="notification-title">Messages</span>
                                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                            </div>
                            <div class="noti-content">
                                <ul class="notification-list">
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ asset('/') }}images/avatar-09.jpg">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">Richard Miles </span>
                                                    <span class="message-time">12:28 AM</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ asset('/') }}images/avatar-02.jpg">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">John Doe</span>
                                                    <span class="message-time">6 Mar</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ asset('/') }}images/avatar-03.jpg">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author"> Tarah Shropshire </span>
                                                    <span class="message-time">5 Mar</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ asset('/') }}images/avatar-05.jpg">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author">Mike Litorus</span>
                                                    <span class="message-time">3 Mar</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification-message">
                                        <a href="#">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar">
                                                        <img alt="" src="{{ asset('/') }}images/avatar-08.jpg">
                                                    </span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author"> Catherine Manseau </span>
                                                    <span class="message-time">27 Feb</span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="#">View all Messages</a>
                            </div>
                        </div>
                    </li> --}}
                    <!-- /Message Notifications -->

                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img src="{{ asset('/') }}images/default.png" alt="">
                            <span class="status online"></span></span>
                            <span>{{ $arr_login_user['first_name'] ?? '' }} {{ $arr_login_user['last_name'] ?? '' }}</span>
                        </a>
                        <div class="dropdown-menu">
                            {{-- <a class="dropdown-item" href="profile.html">My Profile</a>
                            <a class="dropdown-item" href="settings.html">Settings</a> --}}
                            <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
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
                        <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                    </div>
                </div>
                <!-- /Mobile Menu -->
                
            </div>
            <!-- /Header -->
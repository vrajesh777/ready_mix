<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(Config::get('app.project.title')); ?> | <?php echo e($page_title ?? ''); ?></title>
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('/images/favicon.png')); ?>">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('/css/bootstrap.min.css')); ?>">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('/css/fontawesome-v5.7.2-pro.min.css')); ?>">

        <!--font style-->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&display=swap" rel="stylesheet">

		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('/css/style.css')); ?>">

        <!-- jQuery -->
        <script src="<?php echo e(asset('/js/jquery-3.5.0.min.js')); ?>"></script>

    </head>
    <body class="account-page">

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="account-content">

                <div class="container"><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/auth/_header.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="">
		<meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ Config::get('app.project.title') }} | {{ $page_title ?? '' }}</title>
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.png') }}">

		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('/css/fontawesome-v5.7.2-pro.min.css') }}">

        <!--font style-->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&display=swap" rel="stylesheet">

		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

        <!-- jQuery -->
        <script src="{{ asset('/js/jquery-3.5.0.min.js') }}"></script>

    </head>
    <body class="account-page">

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <div class="account-content">

                <div class="container">
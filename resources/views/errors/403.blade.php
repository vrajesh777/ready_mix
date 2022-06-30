<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="CRMS - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Error 403 | {{ Config::get('app.project.title') }}</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/') }}images/icon.jpg">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('/css') }}/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('/css') }}/font-awesome.min.css">

        <!--font style-->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&display=swap" rel="stylesheet">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('/css') }}/style.css">

    </head>
    <body class="error-page">
		<!-- Main Wrapper -->
        <div class="main-wrapper text-center">
			
			<div class="error-box">
				<h1>403</h1>
				<h3><i class="fal fa-warning"></i> Access forbidden error</h3>
				<a href="{{ url('/') }}" class="btn btn-custom btn-gradient-primary btn-rounded">Back to Home</a>
			</div>
		
        </div>
		<!-- /Main Wrapper -->
		
    </body>
</html>
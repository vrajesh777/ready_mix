@extends('auth.auth_master')
@section('auth_main_content')

<!-- Account Logo -->
<div class="account-logo">
	<a href="{{ url('/') }}"><img src="{{ asset('/images/logo.png') }}" alt=""></a>
</div>
<!-- /Account Logo -->

<div class="account-box">
	<div class="account-wrapper">
		<h3 class="account-title">Login</h3>
		<p class="account-subtitle">Access to our dashboard</p>

		@include('layout._operation_status')
		
		<!-- Account Form -->
		<form action="{{ Route('process_login') }}" method="POST" id="loginForm">
			{{ csrf_field() }}
			<div class="form-group">
				<label>Email Address</label>
				<input type="text" name="email" class="form-control" value="{{ old('email') }}" data-rule-required="true" data-rule-email="true" >
				<label class="error">{{ $errors->first('email') }}</label>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col">
						<label>Password</label>
					</div>
					<div class="col-auto">
						<a class="text-muted" href="{{ Route('forgot-password') }}">
							Forgot password?
						</a>
					</div>
				</div>
				<input type="password" name="password" class="form-control" data-rule-required="true" >
				<label class="error">{{ $errors->first('password') }}</label>
			</div>
			<div class="form-group text-center">
				<button class="btn btn-primary account-btn" type="submit">Login</button>
			</div>
			<div class="account-footer">
				<p>Want to inquire? <a href="{{ Route('inquire') }}">Inquire now</a></p>
			</div>
		</form>
		<!-- /Account Form -->

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#loginForm').validate();
	});
</script>

@stop
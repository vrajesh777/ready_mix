@extends('auth.auth_master')
@section('auth_main_content')

<!-- Account Logo -->
<div class="account-logo">
	<a href="{{ url('/') }}"><img src="{{ asset('/images/logo.png') }}" alt=""></a>
</div>
<!-- /Account Logo -->

<div class="account-box">
	<div class="account-wrapper">
		<h3 class="account-title">Forgot Password</h3>

		@include('layout._operation_status')
		
		<!-- Account Form -->
		<form action="{{ Route('process_forgot_password') }}" method="POST" id="loginForm">
			{{ csrf_field() }}
			<div class="form-group">
				<label>Email Address</label>
				<input type="text" name="email" class="form-control" value="{{ old('email') }}" data-rule-required="true" data-rule-email="true" >
				<label class="error">{{ $errors->first('email') }}</label>
			</div>
			<div class="form-group text-center">
				<button class="btn btn-primary account-btn" type="submit">Send</button>
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
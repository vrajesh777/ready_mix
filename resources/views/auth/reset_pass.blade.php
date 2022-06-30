@extends('auth.auth_master')
@section('auth_main_content')

<!-- Account Logo -->
<div class="account-logo">
	<a href="{{ url('/') }}"><img src="{{ asset('/images/logo.png') }}" alt=""></a>
</div>
<!-- /Account Logo -->

<div class="account-box">
	<div class="account-wrapper">
		<h3 class="account-title">Reset Password</h3>

		@include('layout._operation_status')
		
		<!-- Account Form -->
		<form action="{{ Route('process_reset_pass') }}" method="POST" id="loginForm">
			{{ csrf_field() }}
			<input type="hidden" name="enc_id" value="{{ $enc_id ?? '' }}">
			<input type="hidden" name="token" value="{{ $token ?? '' }}">
			<div class="form-group">
				<label>New Password</label>
				<input type="password" name="password" id="password" class="form-control" data-rule-required="true">
				<label class="error">{{ $errors->first('password') }}</label>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="confirm_password" class="form-control" data-rule-required="true" data-rule-equalTo="#password">
				<label class="error">{{ $errors->first('confirm_password') }}</label>
			</div>
			<div class="form-group text-center">
				<button class="btn btn-primary account-btn" type="submit">Submit</button>
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
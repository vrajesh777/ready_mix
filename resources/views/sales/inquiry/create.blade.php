@extends('auth.auth_master')
@section('auth_main_content')

<!-- Account Logo -->
<div class="account-logo">
	<a href="{{ url('/') }}"><img src="{{ asset('/images/logo.png') }}" alt=""></a>
</div>
<!-- /Account Logo -->

<div class="account-box">
	<div class="account-wrapper">
		<h3 class="account-title">{{ trans('admin.inquiry') }}</h3>

		@include('layout._operation_status')
		
		<!-- Account Form -->
		<form action="{{ Route('submit_inuiry') }}" method="POST" id="inquiryForm">
			{{ csrf_field() }}
			<div class="form-group">
				<label>Subject <span class="text-danger">*</span></label>
				<input type="text" name="subject" class="form-control" value="{{ old('subject') }}" data-rule-required="true" >
				<label class="error">{{ $errors->first('subject') }}</label>
			</div>

			<div class="form-group">
				<label>{{ trans('admin.medium') }} <span class="text-danger">*</span></label>
				<select name="medium" class="form-control" data-rule-required="true">
					<option value="">-- {{ trans('admin.select') }} --</option>
					<option value="google">Google</option>
					<option value="facebook">Facebook</option>
					<option value="email">Email</option>
					<option value="physical">Physical</option>
				</select>
				<label class="error">{{ $errors->first('medium') }}</label>
			</div>

			<div class="form-group">
				<label>{{ trans('admin.first_name') }}<span class="text-danger">*</span></label>
				<input type="text" name="cust_name" class="form-control" value="{{ old('cust_name') }}" data-rule-required="true" >
				<label class="error">{{ $errors->first('cust_name') }}</label>
			</div>

			<div class="form-group">
				<label>{{ trans('admin.email') }} <span class="text-danger">*</span></label>
				<input type="text" name="email" class="form-control" value="{{ old('email') }}" data-rule-required="true" data-rule-email="true" >
				<label class="error">{{ $errors->first('email') }}</label>
			</div>

			<div class="form-group">
				<label>{{ trans('admin.requirement_details') }} <span class="text-danger">*</span></label>
				<textarea name="requirement" class="form-control">{{ old('requirement') }}</textarea>
				<label class="error">{{ $errors->first('requirement') }}</label>
			</div>

			<div class="form-group">
				<label>{{ trans('admin.additional') }} {{ trans('admin.note') }}</label>
				<textarea name="note" class="form-control">{{ old('note') }}</textarea>
				<label class="error">{{ $errors->first('note') }}</label>
			</div>

			<div class="form-group text-center">
				<button class="btn btn-primary account-btn" type="submit">{{ trans('admin.submit') }}</button>
			</div>
		</form>
		<!-- /Account Form -->

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#inquiryForm').validate();
	});
</script>

@stop
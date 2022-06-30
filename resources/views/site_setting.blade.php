@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>

<!-- Page Header -->
<form method="POST" name="formSiteSetting" action="{{ Route('site_setting_update') }}" id="formSiteSetting">
	{{ csrf_field() }}
	<input type="hidden" name="enc_id" value="{{ isset($arr_data['id'])?base64_encode($arr_data['id']):'' }}">
	<div class="row">
		<div class="col-sm-6">
			<div class="card">
				<div class="card-body">
					@include('layout._operation_status')
					<div class="form-group">
						<label class="col-form-label">{{ trans('admin.sales_with_flow') }}<span class="text-danger">*</span></label>
	                    <select name="sales_with_workflow" class="select select2" data-rule-required="true">
							<option value="">{{ trans('admin.not_selected') }}</option>
							<option value="1" @if(isset($arr_data['sales_with_workflow']) && $arr_data['sales_with_workflow']!='' && $arr_data['sales_with_workflow'] == '1') selected @endif>{{ trans('admin.with_workflow') }}</option>
							<option value="0" @if(isset($arr_data['sales_with_workflow']) && $arr_data['sales_with_workflow']!='' && $arr_data['sales_with_workflow'] == '0') selected @endif>{{ trans('admin.without_workflow') }}</option>
						</select>
						<label id="sales_with_workflow-error" class="error" for="sales_with_workflow"></label>
						<div class="error">{{ $errors->first('sales_with_workflow') }}</div>
					</div>

					<div class="form-group">
						<label class="col-form-label">{{ trans('admin.purchase_with_flow') }}<span class="text-danger">*</span></label>
	                    <select name="purchase_with_workflow" class="select select2" data-rule-required="true">
							<option value="">{{ trans('admin.not_selected') }}</option>
							<option value="1" @if(isset($arr_data['purchase_with_workflow']) && $arr_data['purchase_with_workflow']!='' && $arr_data['purchase_with_workflow'] == '1') selected @endif>{{ trans('admin.with_workflow') }}</option>
							<option value="0" @if(isset($arr_data['purchase_with_workflow']) && $arr_data['purchase_with_workflow']!='' && $arr_data['purchase_with_workflow'] == '0') selected @endif>{{ trans('admin.without_workflow') }}</option>
						</select>
						<label id="purchase_with_workflow-error" class="error" for="purchase_with_workflow"></label>
						<div class="error">{{ $errors->first('purchase_with_workflow') }}</div>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<a href="{{ Route('site_setting') }}" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</a>
	                </div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Page Header -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#formSiteSetting').validate();
	});
</script>
@stop
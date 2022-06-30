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
<h4 class="card-title mt-0 mb-2">Edit Contract</h4>

<div class="row">
	<form method="POST" action="{{ Route('contract_update') }}" id="formUpdateContract" autocomplete="off">
		{{ csrf_field() }}
		<input type="hidden" name="enc_id" value="{{ $enc_id ?? '' }}">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								{{-- <div class="form-group col-sm-6">
									<label class="col-form-label">Contract number<span class="text-danger">*</span></label>
		                            <input type="text" class="form-control" name="contract_no" placeholder="Contract number" data-rule-required="true" value="{{ $arr_data['contract_no'] ?? '' }}">
		                            <div class="error">{{ $errors->first('contract_no') }}</div>
								</div> --}}

								{{-- <div class="form-group col-sm-6 related_wrapp">
									<label class="col-form-label">Purchase Order<span class="text-danger">*</span></label>
		                            <select name="pur_order_id" class="select select2" id="pur_order_id" data-rule-required="true">
										<option value="">Not Selected</option>
										@if(isset($arr_pur_order) && sizeof($arr_pur_order)>0)
											@foreach($arr_pur_order as $pur_key => $pur_value)
												<option value="{{ $pur_value['id'] ?? '' }}" data-vendor-id ="{{ $pur_value['vendor_id'] ?? '' }}" data-contract-value="{{ $pur_value['total'] ?? '' }}" @if(isset($arr_data['pur_order_id']) && $arr_data['pur_order_id']!='' && $arr_data['pur_order_id'] == $pur_value['id']) selected @endif>#{{ $pur_value['order_number'] ?? '' }}-{{ $pur_value['name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label id="pur_order_id-error" class="error" for="pur_order_id"></label>
									<div class="error">{{ $errors->first('pur_order_id') }}</div>
								</div> --}}

								{{-- <div class="form-group col-sm-6 related_wrapp">
									<label class="col-form-label">Vendors<span class="text-danger">*</span></label>
		                            <select name="vendor_id" id="vendor_id" data-rule-required="true" disabled>
										<option value="">Not Selected</option>
										@if(isset($arr_vendor) && sizeof($arr_vendor)>0)
											@foreach($arr_vendor as $vendor)
												<option value="{{ $vendor['id'] ?? '' }}" @if(isset($arr_data['vendor_id']) && $arr_data['vendor_id']!='' && $arr_data['vendor_id'] == $vendor['id']) selected @endif>{{  $vendor['user_meta'][0]['meta_value'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label id="vendor_id-error" class="error" for="vendor_id"></label>
									<div class="error">{{ $errors->first('vendor_id') }}</div>
								</div>
								<input type="hidden" name="vendor_id" id="hide_vendor_id" value="{{ $arr_data['vendor_id'] ?? '' }}"> --}}

								{{-- <div class="form-group col-sm-6">
									<label class="col-form-label">Vendor <span class="text-danger">*</span></label>
		                            <select name="vendor_id" class="select2" id="vendor_id" data-rule-required="true">
										<option value="">Not Selected</option>
										@if(isset($arr_vendor) && sizeof($arr_vendor)>0)
											@foreach($arr_vendor as $vendor)
												<option value="{{ $vendor['id'] ?? '' }}" @if(isset($arr_data['vendor_id']) && $arr_data['vendor_id']!='' && $arr_data['vendor_id'] == $vendor['id']) selected @endif>{{  $vendor['user_meta'][0]['meta_value'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label id="vendor_id-error" class="error" for="vendor_id"></label>
									<div class="error">{{ $errors->first('vendor_id') }}</div>
								</div> --}}

								<div class="form-group col-sm-6">
									<label class="col-form-label">Contract Value</label>
		                            <input type="text" class="form-control" name="contract_value" id="contract_value" placeholder="Contract Value"  value="{{ $arr_data['contract_value'] ?? '' }}" data-rule-digits="true">
		                            <div class="error">{{ $errors->first('contract_value') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Start Date<span class="text-danger">*</span></label>
		                            <div class="position-relative p-0">
		        						<input class="form-control datepicker pr-5" name="start_date" value="{{ $arr_data['start_date'] ?? '' }}" data-rule-required="true">
		        						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
	        						</div>
		                            <div class="error">{{ $errors->first('start_date') }}</div>
								</div>

								<div class="form-group col-sm-6">
									<label class="col-form-label">End Date</label>
		                            <div class="position-relative p-0">
		        						<input class="form-control datepicker pr-5" name="end_date" value="{{ $arr_data['end_date'] ?? '' }}">
		        						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
	        						</div>
		                            <div class="error">{{ $errors->first('end_date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Payment after invoice (Days)</label>
		                            <input type="text" class="form-control" name="pay_days" id="pay_days" placeholder="Contract Value" data-rule-number="true" min="1" max="365" value="{{ $arr_data['pay_days'] ?? '' }}">
		                            <div class="error">{{ $errors->first('pay_days') }}</div>
								</div>
								<div class="form-group col-sm-6 related_wrapp">
									<label class="col-form-label">Signed status</label>
		                            <select name="sign_status" class="select select2" id="sign_status" data-rule-required="true">
										<option value="0" @if(isset($arr_data['sign_status']) && $arr_data['sign_status']!='' && $arr_data['sign_status']=='0') selected @endif>Not Signed</option>
										<option value="1" @if(isset($arr_data['sign_status']) && $arr_data['sign_status']!='' && $arr_data['sign_status']=='1') selected @endif>Signed</option>
									</select>
									<div class="error">{{ $errors->first('sign_status') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Signed date</label>
		                            <div class="position-relative p-0">
		        						<input class="form-control datepicker pr-5" name="signed_date" value="{{ $arr_data['signed_date'] ?? '' }}">
		        						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
	        						</div>
		                            <div class="error">{{ $errors->first('signed_date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Description</label>
		                            <textarea class="form-control" name="description">{{ $arr_data['description'] ?? '' }}</textarea>
		                            <div class="error">{{ $errors->first('description') }}</div>
								</div>
							</div>
						</div>

						@if(isset($arr_data['attachment']) && sizeof($arr_data['attachment'])>0)
						<div class="form-group col-sm-6">
						<div class="table-responsive">
							<table class="table table-striped table-nowrap custom-table mb-0">
								<thead>
									<tr>
										<th>#Id</th>
										<th>Name</th>
										<th>Download</th>
										<th class="text-right">Actions</th>
									</tr>
								</thead>
								
								<tbody>
									
									@foreach($arr_data['attachment'] as $key => $value)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $value['name'] ?? '' }}</td>
											<td><a href="{{ $purchase_contract_public_path }}/{{ $value['file'] ?? '' }}" download><i class="fa fa-download"></i></a></td>
											<td><a href="{{ Route('contract_attach_delete',base64_encode($value['id'] ?? '')) }}" onclick="confirm_action(this,event,'Do you really want to delete this attachment ?');"><i class="fa fa-trash"></i></a></td>
										</tr>
									@endforeach
									
								</tbody>
							</table>
						</div>
						</div>
						@endif


						<div class="text-center py-3 w-100">
				        	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
				        	<a href="{{ Route('contract') }}" class="btn btn-secondary btn-rounded">Cancel</a>
				        </div>

					</div>
				</div>
			</div>
		</div>

	</form>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#formUpdateContract').validate();
		$('.select2').select2();
	});

	/*$('#pur_order_id').change(function(){
		var vendor_id = $(this).find(':selected').data('vendor-id');
		var contract_value = $(this).find(':selected').data('contract-value');
		$('#vendor_id').select2("val", vendor_id.toString());
		$('#contract_value').val(contract_value);
		$('#hide_vendor_id').val(vendor_id);
	});*/
</script>
@endsection
@extends('layout.master')
@section('main_content')

@php

$total_left_to_pay = $arr_data['total'] ?? 0;
if(isset($arr_data['vendor_payment']) && sizeof($arr_data['vendor_payment'])>0)
{
	foreach ($arr_data['vendor_payment'] as $pay_value) 
	{
		$total_left_to_pay = $total_left_to_pay - $pay_value['amount'];
	}
}
@endphp

<div class="row align-items-center">
	<h4 class="col-md-6 card-title mt-0 mb-2">{{ trans('admin.purchase_order') }}  : #{{ $arr_data['order_number'] ?? '' }} - {{ $arr_data['name'] ?? '' }}</h4>

	<div class="col-md-6 justify-content-end d-flex align-items-center">
		@if($obj_user->hasPermissionTo('purchase-orders-update'))
			@if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] != '2')
				<div class="form-group mr-2 mb-2 related_wrapp">
		            <select name="status" class="select select2" id="status" data-rule-required="true">
		            	<option value="">{{ trans('admin.change') }} {{ trans('admin.status') }} {{ trans('admin.to') }}</option>
						<option value="1" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '1') disabled @endif>{{ trans('admin.not_yet') }} {{ trans('admin.approve') }}</option>
						<option value="2" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '2') disabled @endif>{{ trans('admin.approved') }}</option>
						<option value="3" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '3') disabled @endif>{{ trans('admin.reject') }}</option>
						<option value="4" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '4') disabled @endif>{{ trans('admin.cancel') }}</option>					
					</select>
				</div>
			@endif

			@if($total_left_to_pay > 0)
				<a href="javascript:void(0)" class="border-0 btn btn-success btn-gradient-success btn-rounded mb-2" data-toggle="modal" data-target="#payment_model" ><i class="fa fa-plus-square"></i> {{ trans('admin.payment') }}</a>
			@endif
			
		@endif
		

		<a href="{{ Route('dowload_purchase_order', base64_encode($arr_data['id'])) }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounded mb-2" target="_blank">{{ trans('admin.download') }}</a>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="row">
			
			<div class="col-md-12 d-flex">

				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h4 class="card-title mt-0 mb-2">{{ trans('admin.items') }} {{ trans('admin.details') }}</h4>
						<div class="tab-content">
							<div class="tab-pane active show" id="inventory-stock">
								<div class="table-responsive">
									<table class="table table-striped table-nowrap custom-table mb-0 datatable">
										<thead>
											<tr>
												<th>{{ trans('admin.items') }}</th>
												<th>{{ trans('admin.unit_price') }}</th>
												<th>{{ trans('admin.qty') }}</th>
												<th>{{ trans('admin.sub_total') }}</th>
												<th>{{ trans('admin.tax') }}</th>
												<th>{{ trans('admin.discount') }}</th>
												<th>{{ trans('admin.discount') }}(money)</th>
												<th>{{ trans('admin.total') }}</th>
											</tr>
										</thead>

										<tbody>
											@if(isset($arr_data['purchase_order_details']) && sizeof($arr_data['purchase_order_details'])>0)
												@foreach($arr_data['purchase_order_details'] as $details)

													<tr>
														<td>{{ $details['item_detail']['commodity_code'] }}-{{ $details['item_detail']['commodity_name'] ?? '' }}</td>
														<td>{{ number_format($details['unit_price'],2) ?? '' }}</td>
														<td>{{ $details['quantity'] ?? '' }}</td>
														<td>{{ number_format($details['net_total'],2) ?? '' }}</td>
														<td>
															@php
																$tax = 0;
																if(isset($details['net_total_after_tax']) && $details['net_total_after_tax']!='' || $details['net_total_after_tax']!=0)
																{
																	$tax = $details['net_total_after_tax'] - $details['net_total'];
																}
															@endphp
															{{ number_format( $tax,2) ?? '' }}
														</td>
														<td>{{ number_format( $details['discount_per'],2) ?? '' }}</td>
														<td>{{ number_format($details['discount_money'],2) ?? '' }}</td>
														<td>{{ number_format($details['total'],2) ?? '' }}</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-md-12 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h4 class="card-title mt-0 mb-2">{{ trans('admin.payment') }} {{ trans('admin.record') }}</h4>
						<div class="tab-content">
							<div class="tab-pane active show" id="inventory-stock">
								<div class="table-responsive">
									<table class="table table-striped table-nowrap custom-table mb-0 datatable">
										<thead>
											<tr>
												<th>{{ trans('admin.amount') }}</th>
												<th>{{ trans('admin.payment_mode') }}</th>
												<th>{{ trans('admin.transaction_id') }}</th>
												<th>{{ trans('admin.date') }}</th>
											</tr>
										</thead>

										<tbody>
											@if(isset($arr_payment) && sizeof($arr_payment)>0)
												@foreach($arr_payment as $payment)

													<tr>
														<td>{{ number_format($payment['amount'],2) ?? '' }}</td>
														<td>{{ $payment['payment_method_detail']['name'] ?? '' }}</td>
														<td>{{ $payment['trans_id'] ?? '' }}</td>
														<td>{{ $payment['pay_date'] ?? '' }}</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade right" id="payment_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.record_payment_for') }} #{{ $arr_data['order_number'] ?? '' }} - {{ $arr_data['name'] ?? '' }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('add_po_payment',base64_encode($arr_data['id'])) }}" id="add_payment">

					{{ csrf_field() }}
					<div class="row">
				        <div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.amount_received') }} <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" max="{{ $total_left_to_pay ?? '00' }}" value="{{ $total_left_to_pay ?? '00' }}" class="form-control" placeholder="{{ trans('admin.amount_received') }}" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.transaction_id') }}</label>
							<input type="text" class="form-control" name="trans_id" placeholder="{{ trans('admin.transaction_id') }}">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.payment_date') }} <span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.payment_mode') }} <span class="text-danger">*</span></label></label>
	                        <select class="select" name="pay_method_id" data-rule-required="true">
								<option value="">{{ trans('admin.no_selected') }}</option>
								@if(isset($arr_pay_methods) && !empty($arr_pay_methods))
									@foreach($arr_pay_methods as $method)
										<option value="{{ $method['id'] }}">{{ $method['name'] ?? '' }}</option>
									@endforeach
								@endif
							</select>
							<label id="pay_method_id-error" class="error" for="pay_method_id"></label>
							<label class="error" id="pay_method_id_error"></label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label">{{ trans('admin.leave_a_note') }} </label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="{{ trans('admin.leave_a_note') }}" ></textarea>
	                        <label class="error" id="note_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
		                </div>
				           
				        </div>
					</div>

				</form>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<script type="text/javascript">
	var module_url_path = "{{ $module_url_path ?? '' }}";
	var order_no = "{{ $arr_data['id'] ?? '' }}";
	var token = "{{ csrf_token() }}";
	$('#status').change(function(){
		var status = $(this).val();
		$.ajax({
			url:module_url_path+'/po_change_status/'+btoa(order_no),
			data:{status:btoa(status),_token:token},
			type:'POST',
			dataType:'json',
			success:function(response)
			{
				if(response.status == 'success')
				{
					common_ajax_store_action(response);
				}
			}
		})
	});
</script>

<script type="text/javascript">

	$(document).ready(function(){

		$('#add_payment').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#add_payment").submit(function(e) {

			e.preventDefault();

			if($(this).valid()) {

				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#payment_model").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#payment_model')[0].reset();
	}

</script>

@endsection
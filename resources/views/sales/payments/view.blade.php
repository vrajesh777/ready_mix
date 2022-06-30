@extends('layout.master')
@section('main_content')
<!-- Page Header -->

<?php

$grand_tot = $net_tot = $tot_tax = 0;

$invoice = $arr_payment['invoice']??[];

$payments = $invoice['inv_payments']??[];

// $total_left_to_pay = $invoice['grand_tot']??0;
$grand_tot = $invoice['grand_tot']??0;
$total_left_to_pay = $grand_tot-array_sum(array_column($payments, 'amount'));

/*if(!empty($payments)) {
	foreach($payments as $payment) {
		$total_left_to_pay = $total_left_to_pay-$payment['amount'];
	}
}*/ 

?>

<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row">
			<div class="col-sm-6">
				<div class="card">
				<div class="card-body">
					<h3 class="card-title mt-0">Payment for Invoice <a href="{{ Route('view_invoice', base64_encode($arr_payment['invoice_id'])) }}" target="_blank">{{ format_sales_invoice_number($arr_payment['id']) }}</a></h3>
					<hr>

					<form method="POST" action="{{ Route('update_payment', base64_encode($arr_payment['id'])) }}" id="add_payment">

						{{ csrf_field() }}

						<div class="row">

					        <div class="form-group col-md-12">
								<label class="col-form-label">{{ trans('admin.amount_received') }} <span class="text-danger">*</span></label>
		                        <input type="number" name="amount" value="{{ $arr_payment['amount'] ?? '00' }}" class="form-control" placeholder="Enter Amount" data-rule-required="true">
		                        <label class="error" id="amount_error"></label>
							</div>

							<div class="form-group col-sm-12">
								<label>{{ trans('admin.transaction_id') }}</label>
								<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID" value="{{ $arr_payment['trans_id'] ?? '' }}">
								<label class="error" id="trans_id_error"></label>
							</div>

							<div class="form-group col-md-12">
								<label class="col-form-label">{{ trans('admin.payment_date') }} <span class="text-danger">*</span></label>
		                        <input type="text" name="payment_date" class="form-control datepicker" value="{{ $arr_payment['pay_date'] ?? '' }}" data-rule-required="true">
		                        <label class="error" id="payment_date_error"></label>
							</div>

							<div class="form-group col-sm-12">
								<label class="col-form-label">{{ trans('admin.payment_mode') }} <span class="text-danger">*</span></label>
		                        <select class="select" name="pay_method" data-rule-required="true">
									<option value="">No Selected</option>
									@if(isset($invoice['pay_methods']) && !empty($invoice['pay_methods']))
									@foreach($invoice['pay_methods'] as $method)
									<option value="{{ $method['pay_method_id'] }}" {{ $arr_payment['pay_method_id']==$method['pay_method_id']?'selected':'' }} >{{ $method['method_details']['name'] ?? '' }}</option>
									@endforeach
									@endif
								</select>
								<label class="error" id="pay_method_error"></label>
							</div>

							<div class="form-group col-md-12">
								<label class="col-form-label"> {{ trans('admin.leave_a_note') }} </label>
		                        <textarea name="admin_note" rows="5" cols="5" class="form-control" placeholder="Admin Note" >{{ $arr_payment['note'] ?? '' }}</textarea>
		                        <label class="error" id="admin_note_error"></label>
							</div>

			                <div class="text-center py-3 w-100">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.update') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</button>
			                </div>

						</div>

					</form>
			 	</div>
		 		</div>
       		</div>
            <div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">

						<h3 class="card-title mt-0">{{ trans('admin.payment') }}</h3>
						<div class="pull-right">
							<a href="{{ Route('dowload_pay_receipt', base64_encode($arr_payment['id'])) }}" class="btn btn-primary btn-sm" target="_blank" ><i class="fa fa-file-pdf"></i></a>
							<a href="{{ Route('delete_payment', base64_encode($arr_payment['id']) ) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete this record?')" ><i class="fa fa-times"></i></a>
						</div>
						<hr>
						<div class="text-right">
						 	<p class="font-weight-bold"> To</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $invoice['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $invoice['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="billing_street">{{ $invoice['billing_street']??'' }}</span><br>
								<span class="billing_city">{{ $invoice['billing_city']??'' }}</span>,
								<span class="billing_state">{{ $invoice['billing_state']??'' }}</span>
								<br>
								<span class="billing_zip">{{ $invoice['billing_zip']??'' }}</span>
							</address>
							@if(isset($invoice['include_shipping'])&&$invoice['include_shipping'] == '1')
							<p class="font-weight-bold"> Ship to:</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $invoice['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $invoice['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="shipping_street">{{ $invoice['shipping_street']??'' }}</span><br>
								<span class="shipping_city">{{ $invoice['shipping_city']??'' }}</span>,
								<span class="shipping_state">{{ $invoice['shipping_state']??'' }}</span>
								<br>
								<span class="shipping_zip">{{ $invoice['shipping_zip']??'' }}</span>
							</address>
							@endif
						</div>
						<h1 class="card-title mt-0 text-center">{{ trans('admin.payment') }} {{ trans('admin.receipt') }}</h1>
						<ul class="personal-info">
							<li>
								<div class="title">{{ trans('admin.payment') }} {{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_payment['pay_date'] ?? 'N/A' }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.payment_mode') }}</div>
								<div class="text">{{ $arr_payment['pay_method_details']['name'] ?? 'N/A' }}</div>
							</li>
						</ul>

						<div class="clearfix"></div>

						<div class="green-box">
							<span>{{ trans('admin.total_amount') }}</span>
							<h4 class="font-weight-bold mbot30">{{ format_price($grand_tot) }}</h4>
						</div>

						<div class="clearfix"></div>

						<div class="row">
							<div class="col-md-12 mtop30">
								<h4>Payment For</h4>
								<div class="table-responsive">
									<table class="table table-borderd table-hover">
										<thead>
											<tr>
												<th>{{ trans('admin.invoice_number') }}</th>
												<th>{{ trans('admin.invoice_date') }}</th>
												<th>{{ trans('admin.invoice_amount') }}</th>
												<th>{{ trans('admin.payment_amount') }}</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{ format_sales_invoice_number($arr_payment['id']) }}</td>
												<td>{{ $invoice['invoice_date'] ?? 'N/A' }}</td>
												<td>{{ format_price($invoice['grand_tot'] ?? '00') }}</td>
												<td>{{ format_price($arr_payment['amount'] ?? 00) }}</td>
											</tr>
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
<!-- /Page Header -->

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

	});

</script>

@stop
@extends('layout.master')
@section('main_content')
<!-- Page Header -->

<?php

$grand_tot = $net_tot = $tot_tax = 0;

$order = $arr_invoice['order']??[];
$order_details = $order['ord_details']??[];

$payments = $arr_invoice['inv_payments']??[];

$total_left_to_pay = $arr_invoice['grand_tot'];

if(!empty($payments)) {
	foreach($payments as $payment) {
		$total_left_to_pay = $total_left_to_pay-$payment['amount'];
	}
}

$enc_id = base64_encode($arr_invoice['id']??'');

?>

<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># {{ $arr_invoice['invoice_number']??'' }}</h4>
			<div class="col-md-4">
				<button type="button" class="border-0 btn btn-primary mb-2 btn-sm dropdown-toggle" id="downActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf"></i></button>
				<div class="dropdown-menu" aria-labelledby="downActionBtn">
					<a class="dropdown-item" href="{{ Route('dowload_invoice', $enc_id) }}">{{ trans('admin.view_pdf') }}</a>
					<a class="dropdown-item" href="{{ Route('dowload_invoice', $enc_id) }}" target="_blank">{{ trans('admin.view_pdf_in_new_tab') }}</a>
					<a class="dropdown-item" href="{{ Route('dowload_invoice', $enc_id) }}" download="">{{ trans('admin.download') }}</a>
				</div>
				{{-- <a href="javascript:void(0)" class="border-0 btn btn-success btn-sm mb-2 {{ $total_left_to_pay==0?'disabled':'' }} " data-toggle="modal" data-target="#add_item" ><i class="fa fa-plus"></i> Payment</a> --}}
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-8">
				<div class="card">
				<div class="card-body">
	                <div class="table-responsive">
		               	<table class="table">
		               		<thead>
		               			<tr>
		               				<th>#</th>
		               				<th width="50%">{{ trans('admin.item') }}</th>
		               				<th>{{ trans('admin.qty') }}</th>
		               				<th>{{ trans('admin.rate') }}</th>
		               				<th width="12%">{{ trans('admin.net_amount') }}</th>
		               				<th width="12%">{{ trans('admin.tax') }}</th>
		               				<th width="14%">{{ trans('admin.amount') }}</th>
		               			</tr>
		               		</thead>
		               		<tbody>
		               			@if(isset($order_details) && !empty($order_details))
		               			@foreach($order_details as $index => $row)
		               			<?php
		               				$prod_det = $row['product_details'] ?? [];
		               				$tax_det = $prod_det['tax_detail'] ?? [];

		               				$tot_before_tax = $row['rate']*$row['quantity'];

		               				$net_tot += $tot_before_tax;

		               				$tax_amnt = round($tax_det['tax_rate'] * ($tot_before_tax / 100),2);

		               				$tot_tax += $tax_amnt;

		               				$tot_after_tax = $tot_before_tax + $tax_amnt;

		               				$grand_tot += $tot_after_tax;
		               			?>
		               			<tr>
		               				<td align="center">{{ ++$index }}</td>
		               				<td class="description">
		               					<span><strong>{{ $prod_det['name'] ?? '' }}</strong></span><br>
		               					<span>{{ $prod_det['description']??'' }}</span>
		               				</td>
		               				<td>{{ $row['quantity'] ?? '' }}</td>
		               				<td>{{ isset($row['rate'])?number_format($row['rate'],2):'' }}</td>
		               				<td>{{ number_format($tot_before_tax,2) }}</td>
		               				<td>{{ $tax_det['name'] ?? '' }} {{ $tax_det['tax_rate']??00 }}%<br></td>
		               				<td>{{ number_format($tot_after_tax,2) }}</td>
		               			</tr>
		               			@endforeach
				                <tr>
									<td colspan="6" class="text-right font-weight-normal">{{ trans('admin.sub_total') }}</td>
									<td colspan="1" class="subtotal font-weight-normal">{{ format_price($net_tot) }}</td>
				                </tr>
				                <tr>
				                	<td colspan="6" class="text-right font-weight-normal">{{ trans('admin.total') }} {{ trans('admin.tax') }}</td>
				                	<td colspan="1" class="font-weight-normal">{{ format_price($tot_tax) }}</td>
				                </tr>
				                <tr>
									<td colspan="6" class="font-weight-bold text-right">Total</td>
									<td colspan="1" class="font-weight-bold">{{ format_price($grand_tot) }} </td>
				                </tr>
				                @endif
				            </tbody>
		            	</table>
	                </div> 	
			 	</div>
		 		</div>
       		</div>
            <div class="col-md-4 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0">{{ trans('admin.summary') }}</h3>
						 	<p class="font-weight-bold">{{ trans('admin.to') }} </p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $arr_invoice['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $arr_invoice['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="billing_street">{{ $arr_invoice['billing_street']??'' }}</span><br>
								<span class="billing_city">{{ $arr_invoice['billing_city']??'' }}</span>,
								<span class="billing_state">{{ $arr_invoice['billing_state']??'' }}</span>
								<br>
								<span class="billing_zip">{{ $arr_invoice['billing_zip']??'' }}</span>
							</address>
							@if($arr_invoice['include_shipping'] == '1')
							<p class="font-weight-bold"> Ship to:</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $arr_invoice['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $arr_invoice['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="shipping_street">{{ $arr_invoice['shipping_street']??'' }}</span><br>
								<span class="shipping_city">{{ $arr_invoice['shipping_city']??'' }}</span>,
								<span class="shipping_state">{{ $arr_invoice['shipping_state']??'' }}</span>
								<br>
								<span class="shipping_zip">{{ $arr_invoice['shipping_zip']??'' }}</span>
							</address>
							@endif
						<h4 class="font-weight-bold mbot30">Total {{ format_price($grand_tot) }}</h4>
						<ul class="personal-info">
							<li>
								<div class="title">{{ trans('admin.status') }}</div>
								<div class="text">{{ strtoupper($arr_invoice['status']) }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_invoice['invoice_date'] ?? 'N/A' }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.expiry') }} {{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_invoice['due_date'] ?? 'N/A' }}</div>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
        </div>
	</div>

</div>
<!-- /Page Header -->



<!-- Modal -->
<div class="modal fade right" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.record_payment_for') }} {{ format_sales_invoice_number($arr_invoice['id']) }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('add_inv_payment', base64_encode($arr_invoice['id'])) }}" id="add_payment">

					{{ csrf_field() }}

					<div class="row">
				        <div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.amount_received') }}<span class="text-danger">*</span></label>
	                        <input type="number" name="amount" max="{{ $total_left_to_pay ?? '00' }}" value="{{ $total_left_to_pay ?? '00' }}" class="form-control" placeholder="Enter Amount" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.transaction_id') }}</label>
							<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID">
							<label class="error" id="trans_id_error"></label>
						</div>
						<div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.payment_date') }}<span class="text-danger">*</span></label>
	                        <input type="text" name="payment_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" data-rule-required="true">
	                        <label class="error" id="payment_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.payment_mode') }}<span class="text-danger">*</span></label></label>
	                        <select class="select" name="pay_method" data-rule-required="true">
								<option value="">No Selected</option>
								@if(isset($arr_invoice['pay_methods']) && !empty($arr_invoice['pay_methods']))
								@foreach($arr_invoice['pay_methods'] as $method)
								<option value="{{ $method['pay_method_id'] }}">{{ $method['method_details']['name'] ?? '' }}</option>
								@endforeach
								@endif
							</select>
							<label class="error" id="pay_method_error"></label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label">{{ trans('admin.leave_a_note') }}</label>
	                        <textarea name="admin_note" rows="2" cols="5" class="form-control" placeholder="Admin Note" ></textarea>
	                        <label class="error" id="admin_note_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</button>
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
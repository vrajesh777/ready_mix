@extends('layout.master')
@section('main_content')
<!-- Page Header -->

<?php

	$grand_tot = $net_tot = $tot_tax = $del_cnt = 0;

	$invoice = $arr_order['invoice']??[];

	$ord_details = $arr_order['ord_details']??[];

	$payments = $invoice['inv_payments']??[];

	//$total_left_to_pay = $grand_tot-array_sum(array_column($payments, 'amount'));

?>

<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2">Staement Details of # {{ $arr_order['order_no'] }}</h4>
		</div>

		<div class="row">
			<div class="col-sm-8">
				<div class="card">
					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-borderd table-hover">
								<thead>
									<tr>
										<th>{{ trans('admin.load_no') }}.</th>
										<th>{{ trans('admin.delivery') }} #</th>
										<th>{{ trans('admin.loaded_cbm') }}</th>
										<th>{{ trans('admin.mix_code') }}</th>
										<th>{{ trans('admin.mix_type') }}</th>
										<th>{{ trans('admin.truck') }}</th>
										<th>{{ trans('admin.total_price') }}</th>
										<th>{{ trans('admin.driver') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach($ord_details as $delivery)
									<?php
										$prod_details = $delivery['product_details']??[];
										$prod_price = ($delivery['opc_1_rate']??0)+($delivery['src_5_rate']??0);
										$tax_rate = $delivery['tax_rate']??0;
										$tax = (($prod_price/100)*$tax_rate);
										$base_price = $prod_price+$tax;
										$tot_tax += $tax;
									?>
									@if(isset($delivery['del_notes'])&&!empty($delivery['del_notes']))
									@foreach($delivery['del_notes'] as $note)
									<?php
										$del_cnt++;
										$drive = $note['driver']??[];
										$vehicle = $note['vehicle']??[];
										$del_tot = ($base_price*($note['quantity']??0));

										$net_tot += $base_price;

										$grand_tot += $del_tot;
									?>
									<tr>
										<td>{{ $note['load_no']??'' }}</td>
										<td>{{ $note['delivery_no']??'' }}</td>
										<td>{{ $note['quantity']??'' }}</td>
										<td>{{ $prod_details['mix_code']??'' }}</td>
										<td>{{ $prod_details['name']??'' }}</td>
										<td>{{ $vehicle['name']??'' }} ({{$vehicle['plate_no']??''}} {{$vehicle['plate_letter']??''}}) </td>
										<td>{{ format_price($del_tot??0) }}</td>
										<td>{{ $drive['first_name']??'' }} {{ $drive['last_name']??'' }}</td>
									</tr>
									@endforeach
									@endif
									@endforeach
									@if(isset($del_cnt) && $del_cnt > 0)
									<tr>
										<td colspan="6" class="text-right font-weight-normal">Sub Total</td>
										<td colspan="2" class="subtotal font-weight-normal">{{ format_price($net_tot) }}</td>
					                </tr>
					                <tr>
					                	<td colspan="6" class="text-right font-weight-normal">{{ trans('admin.total') }} {{ trans('admin.tax') }} </td>
					                	<td colspan="2" class="font-weight-normal">{{ format_price($tot_tax) }}</td>
					                </tr>
					                <tr>
										<td colspan="6" class="font-weight-bold text-right">{{ trans('admin.total') }}</td>
										<td colspan="2" class="font-weight-bold">{{ format_price($grand_tot) }} </td>
					                </tr>
					                @endif
								</tbody>
							</table>
							@if(isset($del_cnt) && $del_cnt <= 0)
			                <h3 class="text-center"> {{ trans('admin.no_delivery_assigned_yet') }}</h3>
			                @endif
						</div>

				 	</div>
		 		</div>
       		</div>

       		<div class="col-md-4 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0">{{ trans('admin.summary') }}</h3>
						 	<p class="font-weight-bold"> To</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $arr_order['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $arr_order['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="billing_street">{{ $invoice['billing_street']??'' }}</span><br>
								<span class="billing_city">{{ $invoice['billing_city']??'' }}</span>,
								<span class="billing_state">{{ $invoice['billing_state']??'' }}</span>
								<br>
								<span class="billing_zip">{{ $invoice['billing_zip']??'' }}</span>
							</address>
							@if($invoice['include_shipping'] == '1')
							<p class="font-weight-bold"> Ship to:</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $arr_order['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $arr_order['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="shipping_street">{{ $invoice['shipping_street']??'' }}</span><br>
								<span class="shipping_city">{{ $invoice['shipping_city']??'' }}</span>,
								<span class="shipping_state">{{ $invoice['shipping_state']??'' }}</span>
								<br>
								<span class="shipping_zip">{{ $invoice['shipping_zip']??'' }}</span>
							</address>
							@endif
						<h4 class="font-weight-bold mbot30">{{ trans('admin.booking') }} {{ trans('admin.amount') }} {{ format_price($arr_order['grand_tot']??0) }}</h4>
						<ul class="personal-info">
							<li>
								<div class="title">Status</div>
								<div class="text">{{ strtoupper($arr_order['order_status']) }}</div>
							</li>
							<li>
								<div class="title">Delivery </div>
								<div class="text">{{ $arr_order['delivery_date'] ?? 'N/A' }}</div>
							</li>

						</ul>
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
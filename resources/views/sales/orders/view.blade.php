@extends('layout.master')
@section('main_content')
<!-- Page Header -->

<?php

$grand_tot = $net_tot = $tot_tax = 0;

$invoice = $arr_order['invoice']??[];

$payments = $invoice['inv_payments']??[];

$total_left_to_pay = $invoice['grand_tot'];

if(!empty($payments)) {
	foreach($payments as $payment) {
		$total_left_to_pay = $total_left_to_pay-$payment['amount'];
	}
}

?>

<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># {{ $arr_order['order_no'] }}</h4>
			<div class="col-md-4">
				{{-- <a href="{{ Route('dowload_invoice', base64_encode($arr_order['id'])) }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounded mb-2" download="">{{ trans('admin.download') }}</a> --}}
				<a href="{{ Route('view_invoice', base64_encode($invoice['id'])) }}" class="border-0 btn btn-success btn-gradient-success btn-rounded mb-2 {{ $total_left_to_pay==0?'disabled':'' }} " target="_blank" ><i class="fa fa-money"></i> {{ trans('admin.invoice') }}</a>
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
		               				<th width="12%">{{ trans('admin.net_total') }}</th>
		               				<th width="12%">{{ trans('admin.tax') }}</th>
		               				<th width="13%">{{ trans('admin.amount') }}</th>
		               			</tr>
		               		</thead>
		               		<tbody>
		               			@if(isset($arr_order['ord_details']) && !empty($arr_order['ord_details']))
		               			@foreach($arr_order['ord_details'] as $index => $row)
		               			<?php
		               				$tax_amnt = $tot_tax = $tot_after_tax = 0;
		               				$prod_det = $row['product_details'] ?? [];
		               				$tax_det = $prod_det['tax_detail'] ?? [];

		               				$tot_before_tax = $row['rate']*$row['quantity'];

		               				$net_tot += $tot_before_tax;
		               				if(isset($tax_det['tax_rate']) && $tax_det['tax_rate']!=''){
		               					$tax_amnt = round($tax_det['tax_rate'] * ($tot_before_tax / 100),2);
		               				}

		               				$tot_tax += $tax_amnt;

		               				$tot_after_tax = $tot_before_tax + $tax_amnt;

		               				$grand_tot += $tot_after_tax;
		               			?>
		               			<tr>
		               				<td align="center">{{ ++$index }}</td>
		               				<td class="description">
		               					<span><strong>{{ $prod_det['name'] ?? '' }}</strong></span><br>
		               					<span>{{ $prod_det['description'] }}</span>
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
									<td colspan="6" class="font-weight-bold text-right">{{ trans('admin.total') }}</td>
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
						 	<p class="font-weight-bold"> {{ trans('admin.to') }}</p>
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
							<p class="font-weight-bold"> {{ trans('admin.ship_to') }}:</p>
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
						<h4 class="font-weight-bold mbot30">Total {{ format_price($grand_tot) }}</h4>
						<ul class="personal-info">
							<li>
								<div class="title">{{ trans('admin.status') }}</div>
								<div class="text">{{ strtoupper($arr_order['order_status']) }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_order['date'] ?? 'N/A' }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.expiry') }} {{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_order['expiry_date'] ?? 'N/A' }}</div>
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

	});

</script>

@stop
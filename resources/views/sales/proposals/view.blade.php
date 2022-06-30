@extends('layout.master')
@section('main_content')
<!-- Page Header -->

<?php

$grand_tot = $net_tot = $tot_tax = 0;

$status = $arr_props['status']??'';

$enc_id = base64_encode($arr_props['id']);

?>

{{-- <h4 class="card-title mt-0 mb-2">Proposal</h4> --}}
<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># {{ format_proposal_number($arr_props['id']) }}</h4>
			<div class="col-md-4">
				<button type="button" class="border-0 btn btn-primary mb-2 btn-sm dropdown-toggle" id="downActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf"></i></button>
				<div class="dropdown-menu" aria-labelledby="downActionBtn">
					<a class="dropdown-item" href="{{ Route('dowload_proposal', $enc_id) }}">{{ trans('admin.view_pdf') }}</a>
					<a class="dropdown-item" href="{{ Route('dowload_proposal', $enc_id) }}" target="_blank">{{ trans('admin.view_pdf_in_new_tab') }}</a>
					<a class="dropdown-item" href="{{ Route('dowload_proposal', $enc_id) }}" download="">{{ trans('admin.download') }}</a>
				</div>
				@if($obj_user->hasPermissionTo('sales-proposals-update'))
					@if(isset($arr_props['status']) && $arr_props['status'] == 'accepted')
						<a class="border-0 btn btn-sm btn-info mb-2" href="{{ Route('create_order',['est'=>base64_encode($arr_props['id'])]) }}" >{{ trans('admin.convert_to_order') }}</a>
					@endif

					<a class="border-0 btn btn-sm btn-info mb-2" href="{{ Route('send_prop_email',$enc_id) }}" data-toggle="tooltip" data-placement="bottom" title="Send to Email" ><i class="fa fa-envelope"></i></a>
					@if($status == 'sent' || $status == 'revised')
					<a class="border-0 btn btn-sm btn-success mb-2" href="{{ Route('change_inv_status', [$enc_id,'accepted']) }}" ><i class="fa fa-check"></i>{{ trans('admin.accept') }} </a>
					<a class="border-0 btn btn-sm btn-danger mb-2" href="{{ Route('change_inv_status',[$enc_id,'declined']) }}"><i class="fa fa-times"></i>{{ trans('admin.reject') }} </a>
					@endif
				@endif
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
		               			@if(isset($arr_props['prop_details']) && !empty($arr_props['prop_details']))
		               			@foreach($arr_props['prop_details'] as $index => $row)
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
		               					<span>{{ $prod_det['description'] }}</span>
		               				</td>
		               				<td>{{ $row['quantity'] ?? '' }}</td>
		               				<td>{{ isset($row['rate'])?number_format($row['rate'],2):'' }}</td>
		               				<td>{{ number_format($tot_before_tax,2) }}</td>
		               				<td>{{ $tax_det['name'] ?? '' }} {{ $tax_det['tax_rate'] }}%<br></td>
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
						 	<p class="font-weight-bold">{{ trans('admin.to') }} </p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $arr_props['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $arr_props['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="billing_street">{{ $arr_props['billing_street']??'' }}</span><br>
								<span class="billing_city">{{ $arr_props['billing_city']??'' }}</span>,
								<span class="billing_state">{{ $arr_props['billing_state']??'' }}</span>
								<br>
								<span class="billing_zip">{{ $arr_props['billing_zip']??'' }}</span>
							</address>
							@if($arr_props['include_shipping'] == '1')
							<p class="font-weight-bold"> Ship to:</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	{{ $arr_props['cust_details']['first_name'] ?? '' }}&nbsp;
							 	{{ $arr_props['cust_details']['last_name'] ?? '' }}
							 	</b><br>
								<span class="shipping_street">{{ $arr_props['shipping_street']??'' }}</span><br>
								<span class="shipping_city">{{ $arr_props['shipping_city']??'' }}</span>,
								<span class="shipping_state">{{ $arr_props['shipping_state']??'' }}</span>
								<br>
								<span class="shipping_zip">{{ $arr_props['shipping_zip']??'' }}</span>
							</address>
							@endif
						<h4 class="font-weight-bold mbot30">{{ trans('admin.total') }} {{ format_price($grand_tot) }}</h4>
						<ul class="personal-info">
							<li>
								<div class="title">{{ trans('admin.status') }}</div>
								<div class="text">{{ strtoupper($arr_props['status']) }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_props['date'] ?? 'N/A' }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.expiry') }} {{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_props['expiry_date'] ?? 'N/A' }}</div>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
        </div>
	</div>

	{{-- <div class="col-sm-8">
				<div class="card">
				<div class="card-body">
	                <div class="table-responsive">
		               	<table class="table" width="100%" style="border:none; font-size:13px;color:#333">
		               		<thead style="background-color:#fbfbfb;">
		               			<tr>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">#</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;" width="50%">{{ trans('admin.sub_total') }}</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">Qty</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">Rate</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">Tax</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">Amount</th>
		               			</tr>
		               		</thead>
		               		<tbody>
		               			<tr>
		               				<td style="border-bottom:1px solid #dee2e6;padding:.75rem;" align="center">1</td>
		               				<td style="border-bottom:1px solid #dee2e6;padding:.75rem;" class="description">
		               					<span><strong>Cancrete M15</strong></span><br>
		               					<span>Ready-Mix Concrete is concrete that is manufactured in a batch plant, according to a set engineered mix design. Ready-mix concrete is normally delivered in two ways. First is the barrel truck or in–transit mixers. This type of truck delivers concrete in a plastic state to the site.</span>
		               				</td>
		               				<td style="border-bottom:1px solid #dee2e6;padding:.75rem;">300 1</td>
		               				<td style="border-bottom:1px solid #dee2e6;padding:.75rem;">51.96</td>
		               				<td style="border-bottom:1px solid #dee2e6;padding:.75rem;">VAT 5.00%<br></td>
		               				<td style="border-bottom:1px solid #dee2e6;padding:.75rem;">15,588.00</td>
		               			</tr>
				                <tr>
				                  <td style="border-bottom:1px solid #dee2e6;padding:.75rem;font-weight:bold;" colspan="5" class="text-right font-weight-normal">Sub Total</td>
				                  <td style="border-bottom:1px solid #dee2e6;padding:.75rem;font-weight:bold;" colspan="1" class="subtotal font-weight-normal">$15,588.00</td>
				                </tr>
				                <tr>
				                	<td style="border-bottom:1px solid #dee2e6;padding:.75rem;font-weight:bold;" colspan="5" class="text-right font-weight-normal">VAT (5.00%)</td>
				                	<td style="border-bottom:1px solid #dee2e6;padding:.75rem;font-weight:bold;" colspan="1" class="font-weight-normal">$779.40</td>
				                </tr>                              
				                <tr>
				                  <td style="border-bottom:1px solid #dee2e6;padding:.75rem;font-weight:bold;" colspan="5" class="font-weight-bold text-right">Total</td>
				                  <td style="border-bottom:1px solid #dee2e6;padding:.75rem;font-weight:bold;" colspan="1" class="font-weight-bold">$16,367.40 </td>
				                </tr>
				            </tbody>
		            	</table>
	                </div> 	
			 	</div>
		 		</div>
    </div> --}}

</div>
<!-- /Page Header -->

@stop
@extends('layout.master')
@section('main_content')
<!-- Page Header -->

<?php

$grand_tot = $net_tot = $tot_tax = 0;

$status = $arr_proposal['status']??'';

$enc_id = base64_encode($arr_proposal['id']);

?>

{{-- <h4 class="card-title mt-0 mb-2">Proposal</h4> --}}
<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># {{ format_sales_estimation_number($arr_proposal['id']) }}</h4>
			<div class="col-md-4">
				<div class="dropdown d-inline-block">
					<button type="button" class="border-0 btn btn-primary mb-2 btn-sm dropdown-toggle" id="downActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf"></i></button>
					<div class="dropdown-menu" aria-labelledby="downActionBtn">
						<a class="dropdown-item" href="{{ Route('dowload_estimate', $enc_id) }}">{{ trans('admin.view_pdf') }}</a>
						<a class="dropdown-item" href="{{ Route('dowload_estimate', $enc_id) }}" target="_blank">{{ trans('admin.view_pdf_in_new_tab') }}</a>
						<a class="dropdown-item" href="{{ Route('dowload_estimate', $enc_id) }}" download="">{{ trans('admin.download') }}</a>
					</div>

					@if($obj_user->hasPermissionTo('sales-estimates-update'))
						@if($arr_proposal['related'] == 'lead')
							<button class="border-0 btn btn-sm btn-info btn-rounded mb-2 dropdown-toggle disabled" type="button" id="dropdownMenuButton" data-toggle="tooltip" data-placement="bottom" title="You need to convert the lead to customer in order to create Estimate/Invoice">{{ trans('admin.convert') }}</button>
						@else
							@if(isset($arr_proposal['status']) && in_array($arr_proposal['status'], ['sent','open']))
								<a class="border-0 btn btn-sm btn-info mb-2" href="{{Route('create_proposal',['prop'=>$enc_id]) }}" >{{ trans('admin.convert_to_proposal') }}</a>
							@endif
						@endif
					@endif
				</div>
				@if($obj_user->hasPermissionTo('sales-estimates-update'))
					<a class="border-0 btn btn-sm btn-info mb-2" href="{{ Route('send_est_email',$enc_id) }}" data-toggle="tooltip" data-placement="bottom" title="Send to Email" ><i class="fa fa-envelope"></i></a>
				@endif

				{{-- @if($status == 'sent' || $status == 'revised')
				<a class="border-0 btn btn-sm btn-success mb-2" href="{{ Route('change_status', [$enc_id,'accepted']) }}" ><i class="fa fa-check"></i> Accept</a>
				<a class="border-0 btn btn-sm btn-danger mb-2" href="{{ Route('change_status',[$enc_id,'declined']) }}"><i class="fa fa-times"></i> Reject</a>
				@endif --}}

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
		               			@if(isset($arr_proposal['product_quantity']) && !empty($arr_proposal['product_quantity']))
		               			@foreach($arr_proposal['product_quantity'] as $index => $row)
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
						 <p class="font-weight-bold"> {{ trans('admin.proposal') }} {{ trans('admin.information') }} </p>
		                  <address class="no-margin proposal-html-info">
		                     	<b>
		                     	{{ $arr_proposal['subject'] ?? '' }}
		                     	</b><br>
		                     	{{ $arr_proposal['address'] ?? '' }}
		                     	<br>
		                     	{{ $arr_proposal['city'] ?? '' }}&nbsp;
		                     	{{ $arr_proposal['state'] ?? '' }}&nbsp;
		                     	{{ $arr_proposal['postal_code'] ?? '' }}&nbsp;
		                     	<br><br>
		                     	<a href="mailto:{{ $arr_proposal['email'] ?? '' }}">{{ $arr_proposal['email'] ?? '' }}</a>                  
		                  </address>
						<h4 class="font-weight-bold mbot30">{{ trans('admin.total') }} {{ format_price($grand_tot) }}</h4>
						<ul class="personal-info">
							<li>
								<div class="title">{{ trans('admin.status') }}</div>
								<div class="text">{{ strtoupper($arr_proposal['status']) }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.date') }}</div>
								<div class="text">{{ $arr_proposal['date'] ?? 'N/A' }}</div>
							</li>
							<li>
								<div class="title">{{ trans('admin.open_till') }}</div>
								<div class="text">{{ $arr_proposal['open_till'] ?? 'N/A' }}</div>
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
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;" width="50%">{{ trans('admin.item') }}</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">{{ trans('admin.qty') }}</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">{{ trans('admin.rate') }}</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">{{ trans('admin.tax') }}</th>
		               				<th style="border-bottom:2px solid #dee2e6;padding:.75rem;color:#5f536f;">{{ trans('admin.amount') }}</th>
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
@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-6 card-title mt-0 mb-2">{{ trans('admin.estimate') }} {{ trans('admin.information') }}</h4>
	@if($obj_user->hasPermissionTo('purchase-estimates-update'))
	<div class="col-md-6 justify-content-end d-flex align-items-center">
		<div class="form-group mr-2 mb-2 related_wrapp">
            <select name="status" class="select select2" id="status" data-rule-required="true">
            	<option value="">{{ trans('admin.change') }} {{ trans('admin.status') }} {{ trans('admin.to') }}</option>
				<option value="1" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '1') disabled @endif>{{ trans('admin.not_yet') }} {{ trans('admin.approve') }}</option>
				<option value="2" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '2') disabled @endif>{{ trans('admin.approved') }}</option>
				<option value="3" @if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '3') disabled @endif>{{ trans('admin.reject') }}</option>
			</select>
		</div>
	</div>
	@endif
</div>

<div class="row">
	<div class="col-sm-12">
		<!-- <div class="card mb-0">
			<div class="card-body"> -->
				<div class="row">
					
					<div class="col-md-12 d-flex">

						<div class="card profile-box flex-fill">
							<div class="card-body">
								<h4 class="card-title mt-0 mb-2">This estimate is related to Purchase request : {{ $arr_data['estimate_no'] ?? '' }}</h4>
								<div class="tab-content">
									<div class="tab-pane active show" id="inventory-stock">
										<div class="table-responsive">
											<table class="table table-stripped mb-0 datatables">
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
													@if(isset($arr_data['purchase_estimate_details']) && sizeof($arr_data['purchase_estimate_details'])>0)
														@foreach($arr_data['purchase_estimate_details'] as $details)

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
			<!-- </div>
		</div> -->
	</div>
</div>
<script type="text/javascript">
	var module_url_path = "{{ $module_url_path ?? '' }}";
	var estimate_id = "{{ $arr_data['id'] ?? '' }}";
	var token = "{{ csrf_token() }}";
	$('#status').change(function(){
		var status = $(this).val();
		$.ajax({
			url:module_url_path+'/estimate_change_status/'+btoa(estimate_id),
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
@endsection
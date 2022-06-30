@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-6 card-title mt-0 mb-2">{{ trans('admin.purchase_request') }} {{ trans('admin.information') }} </h4>
	@if($obj_user->hasPermissionTo('purchase-request-update'))
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
					<div class="col-md-6 d-flex">
						<div class="card profile-box flex-fill">
							<div class="card-body">
								<h3 class="card-title border-bottom pb-2 mt-0 mb-3">{{ trans('admin.general_info') }}</h3>
								<ul class="personal-info border rounded">
									<li>
										<div class="title">{{ trans('admin.request_code') }}</div>
										<div class="text">{{ $arr_data['purchase_request_code'] ?? '' }}</div>
									</li>
									<li>
										<div class="title">{{ trans('admin.request_name') }}</div>
										<div class="text">{{ $arr_data['purchase_request_name'] ?? '' }}</div>
									</li>
									<li>
										<div class="title">{{ trans('admin.request_time') }}</div>
										<div class="text">{{ date('Y-m-d h:i A',strtotime($arr_data['created_at'])) ?? '' }}</div>
									</li>
									<li>
										<div class="title">{{ trans('admin.description') }}</div>
										<div class="text">{{ $arr_data['description'] ?? '' }}</div>
									</li>									
								</ul>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 d-flex">
						<div class="card profile-box flex-fill">
							<div class="card-body">
								<div class="tab-content">
									<div class="tab-pane active show" id="inventory-stock">
										<div class="table-responsive">
											<table class="table table-stripped mb-0 datatables">
												<thead>
													<tr>
														<th>{{ trans('admin.items') }}</th>
														<th>{{ trans('admin.unit') }}</th>
														<th>{{ trans('admin.unit_price') }}</th>
														<th>{{ trans('admin.qty') }}</th>
														<th>{{ trans('admin.total') }}</th>
													</tr>
												</thead>
												<tbody>
													@if(isset($arr_data['purchase_request_details']) && sizeof($arr_data['purchase_request_details'])>0)
														@foreach($arr_data['purchase_request_details'] as $details)
															<tr>
																<td>{{ $details['item_detail']['commodity_code'] }}-{{ $details['item_detail']['commodity_name'] ?? '' }}</td>
																<td>Unit</td>
																<td>{{ number_format($details['unit_price'],2) ?? '' }}</td>{{ trans('admin.purchase_request') }}
																<td>{{ $details['tax_detail']['name'] ?? '' }}</td>
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
	var pur_req_id = "{{ $arr_data['id'] ?? '' }}";
	var token = "{{ csrf_token() }}";
	$('#status').change(function(){
		var status = $(this).val();
		$.ajax({
			url:module_url_path+'/pur_req_change_status/'+btoa(pur_req_id),
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
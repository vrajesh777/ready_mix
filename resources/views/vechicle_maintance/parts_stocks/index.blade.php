@extends('layout.master')
@section('main_content')

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		@include('layout._operation_status')

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="driverTable">
						<thead>
							<tr>
								<th>{{ trans('admin.name') }} </th>
								<th>{{ trans('admin.qty') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									@php
										$count_purchase_qty = $supply_qty = $available_qty = 0;

										$count_purchase_qty = array_sum(array_column($value['vhc_purchase_orders'], 'quantity'));
										$supply_qty = array_sum(array_column($value['vhc_supply_detail'], 'quantity'));
										$available_qty = $count_purchase_qty - $supply_qty;
									@endphp
									<tr>
										<td>{{ $value['commodity_name'] ?? '' }}</td>
										<td>
											@if($available_qty > 0)
												<span class="btn btn-success btn-sm">{{ $available_qty ?? '' }}</span>
											@else
												<span class="btn btn-danger btn-sm">{{ $available_qty <=0 ? 'Out Of Stock' : '' }}</span>
											@endif
										</td>
										<td class="text-center">
										@if($available_qty > 0)  
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item action-edit" href="{{ Route('vhc_purchase_parts_create','') }}?id={{ base64_encode($value['id'] ?? 0) }}">{{ trans('admin.purchase_part') }}</a>
												</div>
											</div>
										@endif
										</td>
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
<!-- /Content End -->

<script type="text/javascript">

	$(document).ready(function(){
		$('#driverTable').DataTable({
		});
	});

</script>

@stop
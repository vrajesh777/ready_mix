@extends('layout.master')
@section('main_content')


<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form action="" id="filterForm">
			<ul class="list-inline-item pl-0 d-flex">
                <li class="list-inline-item">
                    <select name="vechicle_id" class="select" id="vechicle_id">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.vehicle') }}</option>
		            	@if(isset($arr_vechicle) && sizeof($arr_vechicle)>0)
							@foreach($arr_vechicle as $vhc)
								<option  value="{{$vhc['id']??''}}" {{ ($vhc['id']??'')==($vechicle_id??'')?'selected':'' }}>{{ $vhc['name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>
                <li class="list-inline-item">
                    <select name="status" class="select" id="status">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.status') }}</option>
						<option  value="Pending" {{ ('Pending')==($status??'')?'selected':'' }}>{{ trans('admin.pending') }}</option>
						<option  value="Delivered" {{ ('Delivered')==($status??'')?'selected':'' }}>{{ trans('admin.delivered') }}</option>
					</select>
                </li>
                <li class="list-inline-item">
                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
                </li>
            </ul>
        	</form>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<li class="list-inline-item">
                    <a href="{{ Route('vhc_repair_create') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-user-btn">{{ trans('admin.new') }} {{$module_title??''}}</a>
                </li>
			</ul>
		</div>
		
	</div>
</div>

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
								<th>{{ trans('admin.repair') }} {{ trans('admin.id') }}</th>
								<th>{{ trans('admin.vehicle') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.make') }}</th>
								<th>{{ trans('admin.model') }}</th>
								<th>{{ trans('admin.year') }}</th>
								<th>{{ trans('admin.chasis_no') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['order_no'] ?? 0 }}</td>
										<td>{{ $value['vechicle_details']['name'] ?? '-' }}</td>
										<td>{{ $value['vechicle_details']['make']['make_name'] ?? '-' }}</td>
										<td>{{ $value['vechicle_details']['model']['model_name'] ?? '-' }}</td>
										<td>{{ $value['vechicle_details']['year'] ?? '-' }}</td>
										<td>{{ $value['vechicle_details']['chasis_no'] ?? '-' }}</td>
										<td>
											@if($value['status'] == 'Pending')
												<a class="btn btn-danger btn-sm" href="{{ Route('vhc_repair_chg_status', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Delivered this order ?');" title="Pending">{{ trans('admin.pending') }}</a>
											@elseif($value['status'] == 'Delivered')
												<a class="btn btn-success btn-sm" href="javascript:void(0);" title="Delivered">{{ trans('admin.delivered') }}</a>
											@endif
										</td>
										<td class="text-center">
											@if($value['status'] != 'Delivered')
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item action-edit" href="{{ Route('vhc_repair_edit',base64_encode($value['id'] ?? 0)) }}">{{ trans('admin.edit') }}</a>
													<a class="dropdown-item action-edit" href="{{ Route('vhc_repair_view',base64_encode($value['id'] ?? 0)) }}">{{ trans('admin.view') }}</a>
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

		$("#vechicle_id,#status").change(function() {
			$("#filterForm").submit();
		});

		$('#clear_btn').click(function(){
			window.location.href="{{ Route('vhc_repair') }}";
		});
	});
</script>

@stop
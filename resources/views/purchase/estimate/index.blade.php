@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>


<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('purchase-estimates-create'))
                <li class="list-inline-item">
                    <a class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" href="{{ Route('estimate_create') }}">{{ trans('admin.new') }} {{ trans('admin.estimate') }}</a>
                </li>
                @endif
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="estimateTable">
						<thead>
							<tr>
								<th> {{ trans('admin.estimate') }} #</th>
								<th> {{ trans('admin.amount') }}</th>
								<th> {{ trans('admin.vendor') }}</th>
								<th> {{ trans('admin.purchase_request') }}</th>
								<th> {{ trans('admin.date') }}</th>
								<th> {{ trans('admin.expiry') }} {{ trans('admin.date') }}</th>
								@if($obj_user->hasPermissionTo('purchase-estimates-update'))
								<th> {{ trans('admin.status') }}</th>
								@endif
								<th class="text-right notexport"> {{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['estimate_no'] ?? '' }}</td>
										<td>{{ $value['total'] ?? '' }}</td>
										<td>{{ $value['user_meta'][0]['meta_value'] ?? '' }}</td>
										<td>{{ $value['pur_request']['purchase_request_name'] ?? '' }}</td>
										<td>{{ $value['estimate_date'] ?? '' }}</td>
										<td>{{ $value['expiry_date'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('purchase-estimates-update'))
										<td>
											@if($value['status'] == '1')
												<button type="button" class="btn btn-info btn-sm">{{ trans('admin.not_yet') }} {{ trans('admin.approve') }}</button>
											@elseif($value['status'] == '2')
												<button type="button" class="btn btn-success btn-sm">{{ trans('admin.approved') }}</button>
											@elseif($value['status'] == '3')
												<button type="button" class="btn btn-danger btn-sm">{{ trans('admin.reject') }}</button>
											@endif
										</td>
										@endif
	
										<td class="text-center">
											<a class="dropdown-item" href="{{ Route('estimate_view',base64_encode($value['id'])) }}"><i class="far fa-eye"></i></a>
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
		$('#estimateTable').DataTable({
			// "pageLength": 2
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '{{ Config::get('app.project.title') }} Estimate Group',
				filename: '{{ Config::get('app.project.title') }} Estimate Group PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Estimate Group',
				filename: '{{ Config::get('app.project.title') }} Estimate Group EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Estimate Group CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	})
</script>

@stop
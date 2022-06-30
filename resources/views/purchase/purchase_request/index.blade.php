@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('purchase-request-create'))
	                <li class="list-inline-item">
	                    <a class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" href="{{ Route('purchase_request_create') }}">{{ trans('admin.new') }} {{ trans('admin.purchase_request') }}</a>
	                </li>
                @endif
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<div class="row">
	<div class="col-sm-12">
		<div class="card mb-0">
			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="purReqTable">
						<thead>
							<tr>
								<th>{{ trans('admin.requester') }} #</th>
								<th>{{ trans('admin.purchase_request') }}</th>
								<th>{{ trans('admin.requester') }}</th>
								<th>{{ trans('admin.requested') }} {{ trans('admin.date') }}</th>
								<th>{{ trans('admin.status') }}</th>
								@if($obj_user->hasPermissionTo('purchase-request-update'))
									<th class="notexport">{{ trans('admin.actions') }}</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0 )
								@foreach($arr_data as $data)
									<tr>
										<td>
											{{ $data['purchase_request_code'] ?? '' }}
										</td>
										<td>
											{{ $data['purchase_request_name'] ?? '' }}
										</td>
										<td>{{ $data['user_detail']['first_name'] ?? '' }} {{ $data['user_detail']['last_name'] ?? '' }}</td>
										<td>{{ date('Y-m-d h:i A',strtotime($data['created_at'])) }}</td>
										@if($obj_user->hasPermissionTo('purchase-request-update'))
										<td>
											@if($data['status'] == '1')
												<button type="button" class="btn btn-info btn-sm">{{  trans('admin.not_yet')}} {{ trans('admin.approve') }}</button>
											@elseif($data['status'] == '2')
												<button type="button" class="btn btn-success btn-sm">{{ trans('admin.approved') }}</button>
											@elseif($data['status'] == '3')
												<button type="button" class="btn btn-danger btn-sm">{{ trans('admin.reject') }}</button>
											@endif
										</td>
										@endif
										<td class="text-center">
											<a class="dropdown-item" href="{{ Route('purchase_request_view',base64_encode($data['id'])) }}"><i class="far fa-eye"></i></a>
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

<script type="text/javascript">
	$(document).ready(function(){
			$('#purReqTable').DataTable({
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
				title: '{{ Config::get('app.project.title') }} Purchase Request',
				filename: '{{ Config::get('app.project.title') }} Purchase Request PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Purchase Request',
				filename: '{{ Config::get('app.project.title') }} Purchase Request EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Purchase Request CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});
</script>

@endsection
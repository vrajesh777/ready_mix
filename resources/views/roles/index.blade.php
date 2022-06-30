@extends('layout.master')
@section('main_content')
		
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <a href="{{ Route('roles_create') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task">{{ trans('admin.new') }} {{ trans('admin.role') }}</a>
                </li>
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
					<table class="table table-striped table-nowrap custom-table mb-0 datatable">
						<thead>
							<tr>
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.role') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.department') }}</th>
								<th class="text-right">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($roles) && sizeof($roles)>0)
								@foreach($roles as $key => $role)
									<tr>
										<td>{{ $role['id'] ?? '' }}</td>
										<td>{{ $role['name'] ?? '' }}</td>
										<td>
											@if(isset($arr_dept) && sizeof($arr_dept)>0)
												@foreach($arr_dept as $dept)
													@if($dept['id'] == $role['department_id'])
														{{ $dept['name'] ?? '' }}
													@endif
												@endforeach
											@endif
										</td>
										<td class="text-center">
											<a class="dropdown-item" href="{{ Route('roles_edit',base64_encode($role['id'])) }}"><i class="far fa-edit"></i></a>
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

@stop
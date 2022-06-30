@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">

			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false"> Status</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{Route('estimates')}}">All</a>
					<a class="dropdown-item" href="{{Route('estimates',['status'=>'draft'])}}">Draft</a>
                    <a class="dropdown-item" href="{{Route('estimates',['status'=>'open'])}}">Open</a>
                    <a class="dropdown-item" href="{{Route('estimates',['status'=>'sent'])}}">Sent</a>
                    <a class="dropdown-item" href="{{Route('estimates',['status'=>'accepted'])}}">Accepted</a>
                    <a class="dropdown-item" href="{{Route('estimates',['status'=>'declined'])}}">Declined</a>
				</div>
			</div>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('sales-estimates-create'))
                <li class="list-inline-item">
                	<a href="{{ Route('create_estimate') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }} {{ trans('admin.estimate') }} </a>
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

		@include('layout._operation_status')

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								<th>{{ trans('admin.estimate') }} #</th>
								<th>{{ trans('admin.subject') }}</th>
								<th>{{ trans('admin.to') }}</th>
								<th>{{ trans('admin.total') }}</th>
								<th>{{ trans('admin.date') }}</th>
								<th>{{ trans('admin.open_till') }}</th>
								<th>{{ trans('admin.date_created') }}</th>
								<th></th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>

							@if(isset($arr_props) && !empty($arr_props))

							@foreach($arr_props as $prop)

							<?php
								$enc_id = base64_encode($prop['id']);

								$status = $prop['status']??'';
							?>

							<tr>
								<td>
									<a href="{{ Route('view_estimate', $enc_id) }}" target="_blank" >{{ format_sales_estimation_number($prop['id']) ?? 'N/A' }}</a>
								</td>
								<td>{{ $prop['subject'] ?? 'N/A' }}</td>
								<td>{{ $prop['to'] ?? 'N/A' }}</td>
								<td>{{ number_format($prop['grand_tot'],2) ?? 0 }}</td>
								<td>{{ $prop['date'] ?? 'N/A' }}</td>
								<td>{{ $prop['open_till'] }}</td>
								<td>{{ date('d-M-y h:i A', strtotime($prop['created_at'])) }}</td>
								<td>{{ ucfirst($status) }}</td>
	                            <td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											@if($obj_user->hasPermissionTo('sales-estimates-update'))
											<a class="dropdown-item action-edit" href="{{ Route('edit_estimate', $enc_id) }}">Edit</a>
											@endif
											<a class="dropdown-item action-edit" href="{{ Route('view_estimate', $enc_id) }}">View</a>
											@if($obj_user->hasPermissionTo('sales-estimates-update'))
											@if($status == 'open')
											<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'draft']) }}">Mark as Draft</a>
											@endif
											@if($status == 'draft' || $status == 'open')
											<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'sent']) }}">Mark as Sent</a>
											@endif
											@if($status == 'draft' || $status == 'sent')
											<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'open']) }}">Mark as Open</a>
											@endif
											@if($status == 'declined')
											<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'revised']) }}">Mark as Revised</a>
											@endif
											@if($status == 'sent' || $status == 'revised')
											<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'declined']) }}">Mark as Declined</a>
											<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'accepted']) }}">Mark as Accepted</a>
											@endif
											@endif
										</div>
									</div>
								</td>
							</tr>

							@endforeach

							@else

							<h3 align="center">{{ trans('admin.no_record_found') }}</h3>

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

	$(document).ready(function() {

		$('#leadsTable').DataTable({
			// "pageLength": 2
			"order" : [[ 0, 'desc' ]],
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
				title: '{{ Config::get('app.project.title') }} Proposals',
				filename: '{{ Config::get('app.project.title') }} Proposals PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Proposals',
				filename: '{{ Config::get('app.project.title') }} Proposals EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Proposals CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

	});


</script>

@stop
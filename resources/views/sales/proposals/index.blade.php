@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">

			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false">{{ trans('admin.status') }}</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{Route('proposals')}}">{{ trans('admin.all') }}</a>
					<a class="dropdown-item" href="{{Route('proposals',['status'=>'draft'])}}">{{ trans('admin.draft') }}</a>
                    <a class="dropdown-item" href="{{Route('proposals',['status'=>'open'])}}">{{ trans('admin.open') }}</a>
                    <a class="dropdown-item" href="{{Route('proposals',['status'=>'sent'])}}">{{ trans('admin.sent') }}</a>
                    <a class="dropdown-item" href="{{Route('proposals',['status'=>'accepted'])}}">{{ trans('admin.accepted') }}</a>
                    <a class="dropdown-item" href="{{Route('proposals',['status'=>'declined'])}}">{{ trans('admin.declined') }}</a>
				</div>
			</div>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                	@if($obj_user->hasPermissionTo('sales-proposals-create'))
                		<a href="{{ Route('create_proposal') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }} {{ trans('admin.proposal') }}</a>
                	@endif
                	@if($obj_user->hasPermissionTo('sales-bookings-create'))
                		<a href="{{ Route('create_order') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }} {{ trans('admin.order') }}</a>
                	@endif
                </li>
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
								<th>{{ trans('admin.proposal') }} #</th>
								<th>{{ trans('admin.amount') }}</th>
								<th>{{ trans('admin.total') }} {{ trans('admin.tax') }} </th>
								<th>{{ trans('admin.customer') }}</th>
								<th>{{ trans('admin.date') }}</th>
								<th>{{ trans('admin.expiry') }} {{ trans('admin.date') }} </th>
								<th>{{ trans('admin.reference') }} #</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>

							@if(isset($arr_props) && !empty($arr_props))

							@foreach($arr_props as $prop)

							<?php
								$enc_id = base64_encode($prop['id']);
								$status = $prop['status']??'';
								$tax_amnt = 0;

								foreach($prop['prop_details'] as $row) {
									$tot_price = $row['quantity']*$row['rate'];
									$tax_rate = $row['tax_rate'];
									$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
								}
							?>

							<tr>
								<td>
									<a href="{{ Route('view_proposal', $enc_id) }}" target="_blank">{{ format_proposal_number($prop['id']) ?? 'N/A' }}</a>
								</td>
								<td>{{ number_format($prop['net_total'],2) ?? 'N/A' }}</td>
								<td>{{ number_format($tax_amnt,2) ?? 'N/A' }}</td>
								<td>{{ $prop['cust_details']['first_name'] ?? '' }} &nbsp; {{ $prop['cust_details']['last_name'] ?? '' }}</td>
								<td>{{ $prop['date'] ?? 'N/A' }}</td>
								<td>{{ $prop['expiry_date'] ?? '' }}</td>
								<td>{{ $prop['ref_num'] ?? 'N/A' }}</td>
								<td>{{ ucfirst($status) }}</td>
	                            <td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											@if($obj_user->hasPermissionTo('sales-proposals-update'))
											<a class="dropdown-item action-edit" href="{{ Route('edit_proposal', $enc_id) }}">{{ trans('admin.edit') }}</a>
											@endif
											<a class="dropdown-item action-edit" href="{{ Route('view_proposal', $enc_id) }}">{{ trans('admin.view') }}</a>
											@if($obj_user->hasPermissionTo('sales-proposals-update'))
												@if($status == 'open')
												<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'draft']) }}">{{ trans('admin.mark_as_draft') }}</a>
												@endif
												@if($status == 'draft' || $status == 'open')
												<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'sent']) }}">{{ trans('admin.mark_as_sent') }}</a>
												@endif
												@if($status == 'draft' || $status == 'sent')
												<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'open']) }}">{{ trans('admin.mark_as_open') }}</a>
												@endif
												@if($status == 'declined')
												<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'revised']) }}">{{ trans('admin.mark_as_revised') }}</a>
												@endif
												@if($status == 'sent' || $status == 'revised')
												<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'declined']) }}">{{ trans('admin.mark_as_declined') }}</a>
												<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'accepted']) }}">{{ trans('admin.mark_as_accepted') }}</a>
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
				title: '{{ Config::get('app.project.title') }} Estimate',
				filename: '{{ Config::get('app.project.title') }} Estimate PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Estimate',
				filename: '{{ Config::get('app.project.title') }} Estimate EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Estimate CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

	});


</script>

@stop
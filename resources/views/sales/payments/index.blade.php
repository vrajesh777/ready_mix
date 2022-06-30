@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">
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
								<th>{{ trans('admin.sr_no') }}</th>
								<th>{{ trans('admin.transaction_id') }}</th>
								<th>{{ trans('admin.customer') }}</th>
								<th>{{ trans('admin.amount') }}</th>
								<th>{{ trans('admin.payment_mode') }}</th>
								<th>{{ trans('admin.type') }}</th>
								<th>{{ trans('admin.date') }}</th>
								{{-- <th class="notexport">Action</th> --}}
							</tr>
						</thead>
						<tbody>

							@if(isset($arr_inv_pay) && !empty($arr_inv_pay))

							@foreach($arr_inv_pay as $key => $row)

							{{-- <?php
								$enc_id = base64_encode($row['id']);
							?> --}}

							<tr>
								{{-- <td>
									<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_sales_invoice_number($row['invoice_id']) ?? 'N/A' }}</a>
								</td> --}}
								<td>{{ $key+1 }}</td>
								<td>{{ $row['trans_no'] ?? '-' }}</td>
								<td>
									@if(isset($row['invoice_id']) && $row['invoice_id']!="")
										{{ $row['invoice']['order']['cust_details']['first_name'] ?? '' }}&nbsp; {{ $row['invoice']['order']['cust_details']['last_name'] ?? '' }}
									@else
										{{ $row['contract']['cust_details']['first_name'] ?? '' }}&nbsp; {{ $row['contract']['cust_details']['last_name'] ?? '' }}
									@endif
								</td>
								<td>{{ format_price($row['amount']) ?? 'N/A' }}</td>
								<td>{{ $row['pay_method_details']['name'] ?? 'N/A' }}</td>
								<td>{{ $row['type'] ?? '' }}</td>
								<td>{{ $row['pay_date'] ?? '' }}</td>
								{{-- <td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item action-edit" href="{{ Route('view_payment', $enc_id) }}">{{ trans('admin.view') }}</a>
											<a class="dropdown-item action-edit" href="{{ Route('delete_payment', $enc_id ) }}" onclick="return confirm('Are you sure want to delete this record?')" >{{ trans('admin.delete') }}</a>
										</div>
									</div>
								</td> --}}
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
				title: '{{ Config::get('app.project.title') }} Invoice',
				filename: '{{ Config::get('app.project.title') }} Invoice PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Invoice',
				filename: '{{ Config::get('app.project.title') }} Invoice EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Invoice CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

	});


</script>

@stop
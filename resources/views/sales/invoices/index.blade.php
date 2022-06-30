@extends('layout.master')
@section('main_content')

<!-- Page Header -->
{{-- <div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">
			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false"> All Leads</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">Recently Viewed</a>
                    <a class="dropdown-item" href="#">Items I'm following</a>
                    <a class="dropdown-item" href="#">All Leads</a>
                    <a class="dropdown-item" href="#">All Closed Leads</a>
                    <a class="dropdown-item" href="#">All Open Leads</a>
                    <a class="dropdown-item" href="#">Converted Leads</a>
                    <a class="dropdown-item" href="#">My Open Leads</a>
                    <a class="dropdown-item" href="#">Todays Leads</a>
				</div>
			</div>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                	<a href="{{ Route('create_invoice') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">New Invoice</a>
                </li>
            </ul>
		</div>
	</div>
</div> --}}
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
								<th>{{ trans('admin.total') }} {{ trans('admin.tax') }}</th>
								<th>{{ trans('admin.customer') }}</th>
								<th>{{ trans('admin.date') }}</th>
								<th>{{ trans('admin.expiry') }} Date</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>

							@if(isset($arr_invoices) && !empty($arr_invoices))

							@foreach($arr_invoices as $invoice)

							<?php
								$enc_id = base64_encode($invoice['id']);
								$tax_amnt = 0;

								$order = $invoice['order']??[];
								$ord_details = $order['ord_details']??[];
								$cust_details = $order['cust_details']??[];

								foreach($ord_details as $row) {
									$tot_price = $row['quantity']*$row['rate'];
									$tax_rate = $row['tax_rate'];
									$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
								}
							?>

							<tr>
								<td>
									<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_sales_invoice_number($invoice['id']) ?? 'N/A' }}</a>
								</td>
								<td>{{ $invoice['net_total'] ?? 'N/A' }}</td>
								<td>{{ $tax_amnt ?? 'N/A' }}</td>
								<td>{{ $cust_details['first_name'] ?? '' }} &nbsp; {{ $cust_details['last_name'] ?? '' }}</td>
								<td>{{ $invoice['invoice_date'] ?? 'N/A' }}</td>
								<td>{{ $invoice['due_date'] ?? '' }}</td>
								<td>{{ ucfirst($invoice['status']) ?? 'N/A' }}</td>
	                            <td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											{{-- <a class="dropdown-item action-edit" href="{{ Route('edit_invoice', $enc_id) }}">Edit</a> --}}
											<a class="dropdown-item action-edit" href="{{ Route('view_invoice', $enc_id) }}">View</a>
										</div>
									</div>
								</td>
							</tr>

							@endforeach

							@else

							<h3 align="center">{{ trans('admin.no_recors_found') }}</h3>

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
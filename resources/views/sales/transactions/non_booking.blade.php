@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('customers-create'))
	                <li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-cust-btn">{{ trans('admin.new') }} {{ trans('admin.customer') }}</button>
	                </li>
                @endif
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="card mb-0">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
				<thead>
					<tr>
						{{-- <th class="notexport">
							<label class="container-checkbox">
							  	<input type="checkbox">
							  	<span class="checkmark"></span>
							</label>
						</th> --}}
						<th>{{ trans('admin.cust') }}#</th>
						<th>{{ trans('admin.arabic_name') }}</th>
						<th>{{ trans('admin.english_name') }}</th>
						<th>{{ trans('admin.payments') }}</th>
						<th>{{ trans('admin.advance_payment') }}</th>
						<th>{{ trans('admin.expected') }} {{ trans('admin.m³') }}</th>
						<th>{{ trans('admin.created_on') }}</th>
					</tr>
				</thead>
				<tbody>

					@if(isset($arr_customers) && !empty($arr_customers))

						@foreach($arr_customers as $customer)
							<?php
								$transactions = $customer['transactions'];
								$sale_contracts = $customer['sale_contracts'];
								$advance_sum = $totalExpectedM3 = 0;
								foreach($transactions as $key => $trans) {
									if( $trans['type'] == 'credit'){
											$advance_sum += $trans['amount'] ?? 0;
									} 
								}
								foreach($sale_contracts as $key => $sc) {
									$totalExpectedM3 += $sc['excepted_m3'] ?? 0;
								}
							?>
						<tr>
							{{-- <td class="checkBox">
								<label class="container-checkbox">
								  	<input type="checkbox">
								  	<span class="checkmark"></span>
								</label>
							</td> --}}
							<td>{{ $customer['id'] ?? '' }}</td>
							<td>
								<!-- Name in Arabic-->
								<?php $payment_link = base64_encode($customer['id']??'').'?page=payments';?>
								<a href="{{ Route('view_customer', base64_encode($customer['id']??'')) }}" class="showLeadDetailsBtn" >{{ $customer['first_name'] ?? '' }}</a>
							</td>
							<td>{{ $customer['last_name'] ?? '' }}</td> <!-- Name in english-->
							<td>
							<a href="{{ Route('view_customer', $payment_link) }}" class="showLeadDetailsBtn" >{{trans('admin.transaction_details')}}</a>
							</td>
							<td>{{ $advance_sum??'00' }}</td>
							<td class="text-center actions">
								{{$totalExpectedM3??'00'}}
							</td>
							<td>{{ date('d-M-y h:i A', strtotime($customer['created_at'])) }}</td>
						</tr>

						@endforeach

					@else

						<h3 align="center">No Records Found!</h3>

					@endif
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">

	var createUrl = "{{ Route('store_customer') }}";
	var updateUrl = "{{ Route('update_customer','') }}";

	$(document).ready(function() {

		var table = $('#leadsTable').DataTable({
			   // "pageLength": 2
			"order" : [[ 4, 'desc' ]],
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
				title: '{{ Config::get('app.project.title') }} Leads',
				filename: '{{ Config::get('app.project.title') }} Leads PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Leads',
				filename: '{{ Config::get('app.project.title') }} Leads EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Leads CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});

</script>

@stop
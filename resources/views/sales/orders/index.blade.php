@extends('layout.master')
@section('main_content')

<?php
$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		{{-- <div class="col">
			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false"> {{ trans('admin.status') }} </a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{Route('booking')}}">{{ trans('admin.all') }} </a>
					<a class="dropdown-item" href="{{Route('booking',['status'=>'pending'])}}">{{ trans('admin.pending') }} </a>
					<a class="dropdown-item" href="{{Route('booking',['status'=>'in-progress'])}}">{{ trans('admin.in_progress') }} </a>
					<a class="dropdown-item" href="{{Route('booking',['status'=>'testing'])}}">{{ trans('admin.testings') }} </a>
					<a class="dropdown-item" href="{{Route('booking',['status'=>'re-build'])}}">{{ trans('admin.re_Build') }} </a>
					<a class="dropdown-item" href="{{Route('booking',['status'=>'re-testing'])}}">{{ trans('admin.re_testing') }} </a>
					<a class="dropdown-item" href="{{Route('booking',['status'=>'granted'])}}">{{ trans('admin.granted') }} </a>
				</div>
			</div>
		</div> --}}
		<div class="col-md-8">
			<form action="" id="filterForm">
			<ul class="list-inline-item pl-0">
				<li class="list-inline-item">
					<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
				</li>
                <li class="list-inline-item">
                    <select name="contract" class="select" id="contract">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.site') }}</option>
		            	@if(isset($arr_contracts) && sizeof($arr_contracts)>0)
							@foreach($arr_contracts as $site)
								<option  value="{{$site['id']??''}}" {{ ($site['id']??'')==($contract_id??'')?'selected':'' }} >{{ $site['cust_details']['first_name']??'' }} {{ $site['cust_details']['last_name']??'' }} - {{ $site['site_location']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>
                <li class="list-inline-item">
                    <select name="sales_user" class="select" id="sales_user">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.saleman') }}</option>
		            	@if(isset($arr_sales_user) && sizeof($arr_sales_user)>0)
							@foreach($arr_sales_user as $user)
								<option  value="{{$user['id']??''}}" {{ ($user['id']??'')==($sales_user??'')?'selected':'' }} >{{ $user['first_name']??'' }} {{ $user['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>
            </ul>
        	</form>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<li class="list-inline-item">
					<a href="{{ Route('create_order') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }} {{ trans('admin.booking') }}</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
<div class="col-sm-12">
<div class="row">
<div class="col-md-12 d-flex">
<div class="card profile-box flex-fill">
	<div class="card-body">
		<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
			@if(isset($arr_pump) && sizeof($arr_pump)>0)
				<li class="nav-item"><a class="nav-link active" href="#pump_all" data-toggle="tab">All</a></li>
				@foreach($arr_pump as $key => $pump)
					<li class="nav-item"><a class="nav-link" href="#pump_{{ $pump['id'] ?? '' }}" data-toggle="tab">{{ $pump['name'] ?? '' }}</a></li>
				@endforeach
			@endif
		</ul>
		<div class="tab-content">

			@if(isset($arr_pump) && sizeof($arr_pump)>0)
				@foreach($arr_pump as $pump)
				<div class="tab-pane show" id="pump_{{ $pump['id'] ?? '' }}">
					<div class="table-responsive">
						<table class="table table-stripped mb-0 leadsTable">
							<thead>
								<tr>
									<th>{{ trans('admin.booking') }} #</th>
									<th>{{ trans('admin.amount') }}</th>
									<th>{{ trans('admin.total') }} {{ trans('admin.tax') }}</th>
									<th>{{ trans('admin.customer') }}</th>
									<th>{{ trans('admin.delivery') }} {{ trans('admin.date') }}</th>
									<th>{{ trans('admin.pump') }}</th>
									<th>{{ trans('admin.total') }} m³</th>
									<th>{{ trans('admin.balance') }} {{ trans('admin.amount') }}</th>
									<th>{{ trans('admin.status') }}</th>
									<th class="text-right notexport">{{ trans('admin.actions') }}</th>
								</tr>
							</thead>
							<tbody>
								@if(isset($arr_orders) && !empty($arr_orders))

									@foreach($arr_orders as $order)

										@if(isset($order['pump']) && $order['pump']!='' && $order['pump'] == $pump['id'])
										
										<?php
											$enc_id = base64_encode($order['id']);
											$tax_amnt = $tot_qty = 0;

											$invoice = $order['invoice'] ?? [];

											foreach($order['ord_details'] as $row) {
												$tot_price = $row['quantity']*$row['rate'];
												$tax_rate = $row['tax_rate'];
												$tax_amnt += ( $tax_rate / 100 ) * $tot_price;

												$tot_qty += $row['quantity'] ?? 0;
											}
										?>

										<tr>
											<td>
												<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_order_number($order['id']) ?? 'N/A' }}</a>
											</td>
											<td>{{ number_format($invoice['net_total'],2) ?? 'N/A' }}</td>
											<td>{{ number_format($tax_amnt,2) ?? 'N/A' }}</td>
											<td>{{ $order['cust_details']['first_name'] ?? '' }} &nbsp; {{ $order['cust_details']['last_name'] ?? '' }}</td>
											{{-- <td>{{ $order['delivery_date'] ?? 'N/A' }}</td> --}}
											<td>{{ date('Y-m-d') }}</td>
											<td>{{ $order['pump_details']['name'] ?? '' }}</td>
											<td>{{ $tot_qty ?? '' }}</td>
											<td>-</td>
											<td>{{ ucfirst($order['order_status']) ?? 'N/A' }}</td>
				                            <td class="text-center">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item action-edit" href="{{ Route('edit_order', $enc_id) }}">Edit</a>
														<a class="dropdown-item action-edit" href="{{ Route('view_order', $enc_id) }}">View</a>
													</div>
												</div>
											</td>
										</tr>
										@endif

									@endforeach

								@else
									<h3 align="center">{{ trans('admin.no_record_found') }}</h3>
								@endif
							</tbody>
						</table>
					</div>
				</div>
				@endforeach
			@endif

			<div class="tab-pane active show" id="pump_all">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 leadsTable">
						<thead>
							<tr>
							<th>{{ trans('admin.booking') }} #</th>
							<th>{{ trans('admin.amount') }}</th>
							<th>{{ trans('admin.total') }} {{ trans('admin.tax') }}</th>
							<th>{{ trans('admin.customer') }}</th>
							<th>{{ trans('admin.delivery') }} {{ trans('admin.date') }}</th>
							<th>{{ trans('admin.pump') }}</th>
							<th>{{ trans('admin.total') }} m³</th>
							<th>{{ trans('admin.balance') }} {{ trans('admin.amount') }}</th>
							<th>{{ trans('admin.status') }}</th>
							<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $gobal_cr = 0; $arr_user_bal = []; ?>

							@if(isset($arr_orders) && !empty($arr_orders))
								@foreach($arr_orders as $order)
									<?php
										$enc_id = base64_encode($order['id']);
										$tax_amnt = $tot_qty = $cr_amnt = 0;

										$invoice = $order['invoice'] ?? [];

										foreach($order['ord_details'] as $row) {
											$tot_price = $row['quantity']*$row['rate'];
											$tax_rate = $row['tax_rate'];
											$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
											$tot_qty += $row['quantity'] ?? 0;
										}

										$cust_id = $order['cust_id'] ?? '';
										$contract_id = $order['contract_id'] ?? '';

										$transactions = array_values($arr_user_trans[$cust_id]??[]);

										$arr_trans_till_ord = [];

										$start_index = 0;
										$end_index = 0;

										foreach($transactions as $key => $trans) {
											if($trans['order_id'] == $order['id'] && $trans['type'] == 'debit') {
												$end_index = $key;
											}
										}

										$end_index++;

										//$end_index = $end_index<=1?($end_index+1):$end_index;

										$arr_trans_till_ord = array_slice($transactions, $start_index,$end_index);
										$arr_user_trans[$cust_id] = array_diff_key($transactions, array_flip(array_keys($arr_trans_till_ord)));

										if(!empty($transactions)) {
											foreach($arr_trans_till_ord as $tran) {
												//$cr_amnt += $tran['type']=='credit'?$tran['amount']:0;
												if($tran['type']=='credit'){
													$cr_amnt += $tran['amount'];
												}elseif($tran['type']=='debit'){
													$cr_amnt -= $tran['amount'];
												}
											}
										}

										if(isset($arr_user_bal[$cust_id])) {
											$arr_user_bal[$cust_id] += $cr_amnt;
										}else{
											$arr_user_bal[$cust_id] = $cr_amnt;
										}

									?>

									<tr>
										<td>
											<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_order_number($order['id']) ?? 'N/A' }}</a>
										</td>
										<td>{{ number_format($invoice['net_total'],2) ?? 'N/A' }}</td>
										<td>{{ number_format($tax_amnt,2) ?? 'N/A' }}</td>
										<td>{{ $order['cust_details']['first_name'] ?? '' }} &nbsp; {{ $order['cust_details']['last_name'] ?? '' }}</td>
										{{-- <td>{{ $order['delivery_date'] ?? 'N/A' }}</td> --}}
										<td>{{ date('Y-m-d') }}</td>
										<td>{{ $order['pump_details']['name'] ?? '' }}</td>
										<td>{{ $tot_qty ?? '' }}</td>
										<td> {{ format_price($arr_user_bal[$cust_id]??0) }} </td>
										<td>{{ ucfirst($order['order_status']) ?? 'N/A' }}</td>
			                            <td class="text-center">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item action-edit edit-ord" href="{{ Route('edit_order', $enc_id) }}">Edit</a>
													<a class="dropdown-item action-edit" href="{{ Route('view_order', $enc_id) }}">View</a>
												</div>
											</div>
										</td>
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
	</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Content End -->

<!-- Modal -->
<div class="modal fade right" id="edit_ord_modal" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">Edit Order</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div id="ordFormWrapp">
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->
<style type="text/css">
/*.modal.fade.right.show {opacity: 1;}*/
/*.show {display: block!important}*/
</style>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> 
<script src="{{ asset('/css/bootstrap-datetimepicker.css') }}"></script>
<script src="{{ asset('/css/bootstrap-datetimepicker.min.css') }}"></script>-->	
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script type="text/javascript">

	$(document).ready(function() {

		$('.leadsTable').DataTable({
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
				title: '{{ Config::get('app.project.title') }} Booking',
				filename: '{{ Config::get('app.project.title') }} Booking PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Booking',
				filename: '{{ Config::get('app.project.title') }} Booking EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Booking CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		$(".edit-ord").click(function(e) {
			e.preventDefault();
			var action_url = $(this).attr('href');
			$("#edit_ord_modal").modal("show");
			$("#ordFormWrapp").html('');

			$.ajax({
				url: action_url,
				dataType:'json',
				beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status.toLowerCase() == 'success') {
						$("#ordFormWrapp").html(response.html);
					}
					displayNotification(response.status, response.message, 5000);
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sdt??''}}',
		    endDate: '{{$edt??''}}'
		})
		.on('changeDate', function(e) {
			$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$("#contract,#sales_user").change(function() {
			$("#filterForm").submit();
		});

	});


</script>
@stop
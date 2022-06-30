@extends('layout.master')
@section('main_content')

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col-sm-8">
			<form action="" id="filterForm">
				<ul class="list-inline-item pl-0">
					<li class="list-inline-item">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item">
	                    <select name="custm_id" class="select" id="customer">
			            	<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
			            	@if(isset($arr_customer) && sizeof($arr_customer)>0)
								@foreach($arr_customer as $cust)
									<option  value="{{$cust['id']??''}}" {{ ($cust['id']??'')==($custm_id??'')?'selected':'' }}>{{ $cust['first_name']??'' }} {{ $cust['last_name']??'' }}</option>
								@endforeach
							@endif
						</select>
	                </li>

	                <li class="list-inline-item">
	                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
	                </li>
                
	            </ul>
        	</form>
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
					<table class="table table-stripped mb-0 leadsTable" id="leadsTable">
						<thead>
							<tr>
								<th>{{ trans('admin.customer') }} #</th>
								<th>{{ trans('admin.name') }}</th>
								<th>{{ trans('admin.total') }} m³</th>
								<th>{{ trans('admin.booking') }} {{ trans('admin.amount') }} ({{ trans('admin.sar') }})</th>
								<th>{{ trans('admin.advance_payment') }} ({{ trans('admin.sar') }})</th>
								<th>{{ trans('admin.balance') }} ({{ trans('admin.sar') }})</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_user_trans) && sizeof($arr_user_trans)>0)
								@foreach($arr_user_trans as $value)
									@foreach($value as $key => $details)
										@php
											$total_qty = $grand_tot = $advance_payment = $balance = 0;
											$total_qty += $details['ord_details'][0]['quantity'] ?? 0;
											$grand_tot += $details['grand_tot'] ?? 0;
											$advance_payment += $details['advance_payment'] ?? 0;
											$balance += $details['balance'] ?? 0;
											$cust_id = $details['cust_id'] ?? '';
											$cust_fname = $details['cust_details']['first_name'] ?? ''; 
											$cust_lname = $details['cust_details']['last_name'] ?? '';
											$cust_name = $cust_fname.' '.$cust_lname;
										@endphp
									@endforeach
									<tr>
										<td>{{ $cust_id ?? 0 }}</td>
										<td>{{ $cust_name ?? '' }}</td>
										<td>{{ $total_qty ?? 0 }}</td>
										<td>{{ $grand_tot ?? 0 }}</td>
										<td>{{ $advance_payment ?? 0 }}</td>
										<td>{{ $balance ?? 0 }}</td>
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

<script src="{{ asset('/js/moment.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script type="text/javascript">

	var custm_id = "{{ $custm_id ?? '' }}";
	$(document).ready(function() {

		if(custm_id!='')
		{
			load_sites(custm_id);
		}

		/*$('#leadsTable').DataTable({
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
		});*/

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

		$("#contract,#sales_user,#customer").change(function() {
			$("#filterForm").submit();
		});

	});

	$('#clear_btn').click(function(){
		window.location.href="{{ Route('booking_statement') }}";
	});

</script>

@stop
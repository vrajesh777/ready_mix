@extends('layout.master')
@section('main_content')
@php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
@endphp
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form action="" id="filterForm">
			<ul class="list-inline-item pl-0 d-flex">
				<li class="list-inline-item">
					<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
				</li>
				
                <li class="list-inline-item">
                    <select name="from_id" class="select" id="from_id">
		            	<option value="">{{ trans('admin.select') }}</option>
		            	@if(isset($arr_from_customer) && sizeof($arr_from_customer)>0)
							@foreach($arr_from_customer as $from)
								<option  value="{{$from['id']??''}}" {{ ($from['id']??'')==($from_id??'')?'selected':'' }}>{{ $from['id']??'' }} - {{ $from['first_name']??'' }} {{ $from['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>
                <li class="list-inline-item">
                    <select name="to_id" class="select" id="to_id">
		            	<option value="">{{ trans('admin.select') }}</option>
		            	@if(isset($arr_to_customer) && sizeof($arr_to_customer)>0)
							@foreach($arr_to_customer as $to)
								<option  value="{{$to['id']??''}}" {{ ($to['id']??'')==($to_id??'')?'selected':'' }}>{{ $to['id']??'' }} - {{ $to['first_name']??'' }} {{ $to['last_name']??'' }}</option>
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
<div class="col-sm-12">
<div class="row">
<div class="col-md-12 d-flex">
<div class="card profile-box flex-fill">
	<div class="card-body">

		<div class="tab-content">

			<div class="tab-pane active show" id="pump_all">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								<th colspan="6" style="background-color:#7d7b7a;text-align:center;">
									From Customer
								</th>
								<th colspan="7" style="background-color:#b0adac;text-align:center;">
									Resell To Customer
								</th>
							</tr>

							<tr>
								<th>Delivery Date</th>
								<th>Delivery #</th>
								<th>Customer #</th>
								<th>From Customer</th>
								<th>Mix</th>
								<th>Excess Qty</th>
								<th>Delivery Date</th>
								<th>Delivery #</th>
								<th>Customer #</th>
								<th>To Customer</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_delivery) && sizeof($arr_delivery)>0)
								@foreach($arr_delivery as $key => $delivery)
									<tr>
										<td>{{ isset($delivery['delivery_date'])?date_format_dd_mm_yy($delivery['delivery_date']):'' }}</td>
										<td>{{ $delivery['delivery_no'] ?? '' }}</td>
										<td>{{ $delivery['from_customer_id'] ?? '' }}</td>
										<td>{{ $delivery['from_customer']['first_name'] ?? '' }} {{ $delivery['from_customer']['last_name'] ?? '' }}</td>
										<td>{{ $delivery['order_details']['product_details']['name'] ?? '' }}</td>
										<td>{{ $delivery['excess_qty'] ?? '' }}</td>
										<td>{{ isset($delivery['to_delivery']['delivery_date'])?date_format_dd_mm_yy($delivery['to_delivery']['delivery_date']):'' }}</td>
										<td>{{ $delivery['to_delivery']['delivery_no'] ?? '' }}</td>
										<td>{{ $delivery['to_customer_id'] ?? '' }}</td>
										<td>{{ $delivery['to_customer']['first_name'] ?? '' }} {{ $delivery['to_customer']['last_name'] ?? '' }}</td>
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
</div>
</div>
</div>
</div>
<!-- /Content End -->

<style type="text/css">
/*.modal.fade.right.show {opacity: 1;}*/
/*.show {display: block!important}*/
</style>

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

<script type="text/javascript">
// body add class for sidebar start
var body = document.body;
body.classList.add("mini-sidebar");
// body add class for sidebar end

	var custm_id = "{{ $custm_id ?? '' }}";
	$(document).ready(function() {

        $( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
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

		$("#from_id,#to_id").change(function() {
			$("#filterForm").submit();
		});

		var sdt ="{{ $sdt ?? ''}}";
		var edt ="{{ $edt ?? ''}}";
		var table = $('#leadsTable').DataTable({
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
				title: '{{ Config::get('app.project.title') }} Excess/Resell',
				filename: '{{ Config::get('app.project.title') }} Excess/Resell '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Excess/Resell',
				filename: '{{ Config::get('app.project.title') }} Excess/Resell '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Excess/Resell '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});

	$('#clear_btn').click(function(){
		window.location.href="{{ Route('excess_rpt') }}";
	});

</script>
@stop
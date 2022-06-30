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
				
               {{--  <li class="list-inline-item">
                    <select name="custm_id" class="select" id="customer">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
		            	@if(isset($arr_customer) && sizeof($arr_customer)>0)
							@foreach($arr_customer as $cust)
								<option  value="{{$cust['id']??''}}" {{ ($cust['id']??'')==($custm_id??'')?'selected':'' }}>{{ $cust['first_name']??'' }} {{ $cust['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li> --}}

                {{-- <li class="list-inline-item">
                    <select name="contract" class="select" id="contract">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
		        
					</select>
                </li> --}}

               {{--  <li class="list-inline-item">
                    <select name="sales_user" class="select" id="sales_user">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.saleman') }}</option>
		            	@if(isset($arr_sales_user) && sizeof($arr_sales_user)>0)
							@foreach($arr_sales_user as $user)
								<option  value="{{$user['id']??''}}" {{ ($user['id']??'')==($sales_user??'')?'selected':'' }} >{{ $user['first_name']??'' }} {{ $user['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li> --}}
                <li class="list-inline-item">
                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
                </li>
            </ul>
        	</form>
		</div>
		{{-- <div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('sales-bookings-create'))
					<li class="list-inline-item">
						<a href="{{ Route('create_order') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }}</a>
					</li>
				@endif
			</ul>
		</div> --}}
		
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
								<th>{{ trans('admin.sr_no') }}</th>
								<th>{{ trans('admin.acc') }}#</th>
								<th>{{ trans('admin.customer') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.r_cbm') }}</th>
								<th>{{ trans('admin.mix') }}</th>
								<th>{{ trans('admin.batch') }}</th>
								<th>{{ trans('admin.pmp') }}</th>
								<th>{{ trans('admin.site') }} {{ trans('admin.location') }}</th>
								<th>{{ trans('admin.time') }}</th>
								<th>{{ trans('admin.d_cbm') }}</th>
								<th>{{ trans('admin.rej_cbm') }}</th>
								<th>{{ trans('admin.balance') }}</th>
								<th>{{ trans('admin.remark') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_orders) && sizeof($arr_orders)>0)
								@foreach($arr_orders as $key => $order)
									@php
										$d_qty = $reject_qty = 0;
										if(isset($order['ord_details'][0]['del_notes']) && sizeof($order['ord_details'][0]['del_notes'])>0){
											$d_qty = array_sum(array_column($order['ord_details'][0]['del_notes'],'quantity')) ?? 0;
											$reject_qty = array_sum(array_column($order['ord_details'][0]['del_notes'],'reject_qty')) ?? 0;
										}

										$dlv_qty = $d_qty - $reject_qty;	
									@endphp
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $order['cust_details']['id'] ?? '' }}</td>
										<td>{{ $order['cust_details']['first_name'] ?? '' }} {{ $order['cust_details']['last_name'] ?? '' }}</td>
										<td>{{ $order['ord_details'][0]['quantity'] ?? 0 }}</td>
										<td>{{ $order['ord_details'][0]['product_details']['name'] ?? '' }}</td>
										<td>{{ $order['ord_details'][0]['product_details']['mix_code'] ?? '' }}</td>
										<td>{{ $order['pump'] ?? 0 }}</td>
										<td>{{ $order['contract']['site_location'] ?? '' }}</td>
										<td>{{ date('H:i', strtotime($order['delivery_time']))??'' }}</td>
										<td>{{ $dlv_qty ?? 0 }}</td>
										<td>{{ $reject_qty ?? 0 }}</td>
										<td>{{ number_format($order['balance'],2) ?? 0 }}</td>
										<td>{{ $order['remark'] ?? '' }}</td>
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

		$("#customer").change(function() {
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
				title: '{{ Config::get('app.project.title') }} Rev Prog Report',
				filename: '{{ Config::get('app.project.title') }} Rev Prog Report '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Rev Prog Report',
				filename: '{{ Config::get('app.project.title') }} Rev Prog Report '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Rev Prog Report '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});

	$('#clear_btn').click(function(){
		window.location.href="{{ Route('resrv_progressive_rpt') }}";
	});

</script>
@stop
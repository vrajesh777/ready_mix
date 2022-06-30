@extends('layout.master')
@section('main_content')
@php
	$sdt = \Carbon::parse($start_date_time??'')->format('d/m/Y h:i A');
	$edt = \Carbon::parse($end_date_time??'')->format('d/m/Y h:i A');
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
								<th>{{ trans('admin.truck_no') }}.</th>
								<th>{{ trans('admin.driver') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.LD') }} #1</th>
								<th>{{ trans('admin.LD') }} #2</th>
								<th>{{ trans('admin.LD') }} #3</th>
								<th>{{ trans('admin.LD') }} #4</th>
								<th>{{ trans('admin.LD') }} #5</th>
								<th>{{ trans('admin.LD') }} #6</th>
								<th>{{ trans('admin.LD') }} #7</th>
								<th>{{ trans('admin.LD') }} #8</th>
								<th>{{ trans('admin.LD') }} #9</th>
								<th>{{ trans('admin.LD') }} #10</th>
								<th>{{ trans('admin.LD') }} #11</th>
								<th>{{ trans('admin.LD') }} #12</th>
								<th>{{ trans('admin.LD') }} #13</th>
								<th>{{ trans('admin.LD') }} #14</th>
								<th>{{ trans('admin.LD') }} #15</th>
								<th>{{ trans('admin.LD') }} #16</th>
								<th>{{ trans('admin.LD') }} #17</th>
								<th>{{ trans('admin.LD') }} #18</th>
								<th>{{ trans('admin.month_load') }}</th>
								<th>{{ trans('admin.total_load') }}</th>
								<th>{{ trans('admin.load_accum') }}</th>
							</tr>
						</thead>
						
						<tbody>
							@if(isset($arr_driver) && sizeof($arr_driver)>0)
								@foreach($arr_driver as $key => $order)
									@php
										$total_del_qty =0;
									@endphp
									<tr>
										<td>{{ $order[0]['vehicle']['plate_no'] ?? '' }}</td>
										<td>{{ $order[0]['driver']['first_name'] ?? '' }} {{ $order[0]['driver']['last_name'] ?? '' }}</td>

										@if(isset($order) && sizeof($order)>0)
											@foreach($order as $del_key => $del)
												@php
													$total_del_qty += $del['quantity'] ?? 0;
												@endphp
												<td>{{ $del['quantity'] ?? 0 }},<br>{{ date('H:i',strtotime($del['order_details']['order']['delivery_time'])) ?? '' }}</td>
											@endforeach
											@php
												$count = count($order) ?? 0;
												$remain_count = 18 - $count;
												for($i=1;$i<$remain_count+1;$i++){
													echo '<td></td>';
												}
											@endphp
										@endif
										
										<td>NA</td>
										<td>{{ $total_del_qty ?? 0 }}</td>
										<td>NA</td>

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
		      format: 'DD/MM/YYYY hh:mm A'
		    },
		    timePicker: true,
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
		window.location.href="{{ Route('daliv_output_mix_rpt') }}";
	});

</script>
@stop
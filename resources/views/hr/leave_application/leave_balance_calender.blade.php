@extends('layout.master')
@section('main_content')

@php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
@endphp

<link rel="stylesheet" href="{{ asset('/css/week-calendar.css') }}">

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form method="GET" action="{{ Route('leave_balance') }}" id="filterForm">
				<ul class="list-inline-item pl-0 d-flex">
					<li class="list-inline-item">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item" style="width:20%">
	                    <select name="type" class="select" id="type">
			            	<option value="">Select Type</option>
			            	<option value="paid" @if(isset($type) && $type!='' && $type == 'paid') selected @endif>{{ trans('admin.paid') }}</option>
							<option value="unpaid" @if(isset($type) && $type!='' && $type == 'unpaid') selected @endif>{{ trans('admin.unpaid') }}</option>
							<option value="on_duty" @if(isset($type) && $type!='' && $type == 'on_duty') selected @endif>{{ trans('admin.on_duty') }}</option>
							<option value="restricted_holidays" @if(isset($type) && $type!='' && $type == 'restricted_holidays') selected @endif>{{ trans('admin.restricted_holidays') }}</option>
						</select>
	                </li>
	                <li class="list-inline-item" style="width:20%">
	                    <select name="leave_type[]" class="select2" multiple="">
							@if(isset($arr_leave_type) && !empty($arr_leave_type))
							<option value="">All</option>
								@foreach($arr_leave_type as $type)
									<option value="{{ $type['id']??'' }}" @if(isset($leave_type_ids) && $leave_type_ids!='' && in_array($type['id'], $leave_type_ids)) selected @endif>{{ $type['title']??'' }}</option>
								@endforeach
							@endif
						</select>
	                </li>
	                <li class="list-inline-item" style="width:15%">
	                    <select name="department[]" class="select2" multiple="">
							@if(isset($arr_departments) && !empty($arr_departments))
								<option value="">All</option>
								@foreach($arr_departments as $dept)
								<option value="{{ $dept['id']??'' }}" @if(isset($dept_ids) && $dept_ids!='' && in_array($dept['id'], $dept_ids)) selected @endif>{{ $dept['name']??'' }}</option>
								@endforeach
							@endif
						</select>
	                </li>
	                <li class="list-inline-item" style="width:20%">
	                    <select name="employee[]" class="select2" multiple="">
							@if(isset($arr_employees) && !empty($arr_employees))
							<option value="">All</option>
								@foreach($arr_employees as $emp)
									<option value="{{ $emp['id']??'' }}" @if(isset($emp_ids) && $emp_ids!='' && in_array($emp['id'], $emp_ids)) selected @endif>{{ $emp['first_name']??'' }} {{ $emp['last_name']??'' }}</option>
								@endforeach
							@endif
						</select>
	                </li>
	               
	                <li class="list-inline-item">
	                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
	                </li>
	                <li class="list-inline-item">
	                	<button type="submit" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3">Search</button>
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

<div class="card mb-0">
	<div class="card-body">
		<div class="">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>{{ trans('admin.employee') }}</th>
						@if(isset($arr_leave_type) && !empty($arr_leave_type))
							@foreach($arr_leave_type as $leave_type)
								<th colspan="2">{{ $leave_type['title']??'' }}</th>
							@endforeach
						@endif
					</tr>
					<tr>
						<th></th>
						@if(isset($arr_leave_type) && !empty($arr_leave_type))
							@foreach($arr_leave_type as $leave_type)
								<th>Taken</th>
								<th>Balance</th>
							@endforeach
						@endif
					</tr>
				</thead>
					<tbody>
						@if(isset($arr_users) && !empty($arr_users))
						@foreach($arr_users as $user)
						<?php
							$leave_type_bal = $user['leave_type_bal']??[];
							$taken_leave = $user['taken_leave']??[];
						?>
						<tr>
							<th>
								{{ $user['first_name']??'' }} 
								{{ $user['last_name']??'' }}
							</th>
							@if(isset($arr_leave_type) && !empty($arr_leave_type))
								@foreach($arr_leave_type as $leave_type)
									@php
										$bal = $leave_type_bal[($leave_type['id']??'')] ?? 0;
										$bal = ($bal) - ($taken_leave[($leave_type['id']??'')] ?? 0)
									@endphp
									<td>
										@if((isset($taken_leave[($leave_type['id']??'')]) && $taken_leave[($leave_type['id']??'')]!='') || (isset($leave_type_bal[($leave_type['id']??'')]) && $leave_type_bal[($leave_type['id']??'')]!=''))
											{{ $taken_leave[($leave_type['id']??'')] ?? 0 }}
										@else
											N/A
										@endif
									</td>
									<td>
										@if(isset($leave_type_bal[($leave_type['id']??'')]) && $leave_type_bal[($leave_type['id']??'')]!='')
											{{ $bal ?? 0 }}
										@else
											N/A
										@endif
									</td>
								@endforeach
							@endif
						</tr>
						@endforeach
						@endif
					</tbody>
			</table>
		</div>
	</div>
</div>

<!-- /Content End -->
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

<script type="text/javascript">

	$(document).ready(function() {

		$('.select2').select2();

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sdt??''}}',
		    endDate: '{{$edt??''}}'
		})
		.on('changeDate', function(e) {
			//$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			//$('#dateRange').trigger('changeDate');
		});

		/*$('select[name="leave_type[]"]').change(function() {
			var total = $('select[name="leave_type[]"] option:selected').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');

				$('select[name="except_depts[]"]').val([]);
				$('select[name="except_depts[]"]').trigger('change');
				$('.except_depts-wrap').hide();
			}else{
				$('.except_depts-wrap').show();
			}
		});*/
	});

	$('#clear_btn').click(function(){
		window.location.href="{{ Route('leave_balance') }}";
	});

</script>

@stop
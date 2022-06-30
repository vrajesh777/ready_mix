@extends('layout.master')
@section('main_content')
@php
	$payable_days = 0;
	if(isset($arr_pay_schedule['salary_on']) && $arr_pay_schedule['salary_on']!='' && $arr_pay_schedule['salary_on'] == 0){
		$payable_days = cal_days_in_month(CAL_GREGORIAN,$arr_pay_run['for_month'],$arr_pay_run['for_year']);
	}elseif(isset($arr_pay_schedule['salary_on']) && $arr_pay_schedule['salary_on']!='' && $arr_pay_schedule['salary_on'] == 1){
		$payable_days = $arr_pay_schedule['days_per_month'] ?? 0;
	}

	$dateObj = \DateTime::createFromFormat('!m', $arr_pay_run['for_month']);
    $monthName = $dateObj->format('F');
@endphp
<div class="card">
		
		@include('layout._operation_status')

	<div class="card-header">
		<h4 class="card-title m-0">{{ trans('admin.paid_summary') }}</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-4 bg-light border btn d-block mx-3">
			    <div class="mb-3">
			      	<span class="text-xs">{{ trans('admin.period') }}:</span> <span class="font-weight-bold text-xs">{{ $monthName ?? '' }} {{ isset($arr_pay_run['for_year'])?date('Y',strtotime($arr_pay_run['for_year'])):'' }}</span> |
			      	<span class="text-xs">{{ $payable_days ?? 0 }} {{ trans('admin.payable_days') }}</span>
			    </div>
			    <div class="row net-pay-data-without-bt">
			      	<div class="col-md-6">
			          	<h4>{{ trans('admin.sar') }} {{ isset($arr_pay_run['emp_salary'])?number_format(array_sum(array_column($arr_pay_run['emp_salary'],'gross_total')),2):0}}</h4>
		        		<div class="text-uppercase text-xs">{{ trans('admin.payroll_cost') }}</div>
			      	</div>
			      	<div class="col-md-6">
			          	<h4>{{ trans('admin.sar') }} {{ isset($arr_pay_run['emp_salary'])?number_format(array_sum(array_column($arr_pay_run['emp_salary'],'monthly_total')),2):0}}</h4>
		        		<div class="text-uppercase text-xs">{{ trans('admin.employees_net_pay') }}</div>
			      	</div>
			    </div>
			</div>

			<div class="col-md-2 text-center border btn d-block mx-3">
			    <div class="text-uppercase text-muted">{{ trans('admin.pay_day') }}</div>
			    <div class="font-light text-xl">{{ isset($arr_pay_run['pay_date'])?date('d',strtotime($arr_pay_run['pay_date'])):'' }}</div>
			    <div class="text-uppercase text-xs">{{ isset($arr_pay_run['pay_date'])?date('M , Y',strtotime($arr_pay_run['pay_date'])):'' }}</div>
			    <hr class="my-2">
			      <div class="text-md">{{ isset($arr_pay_run['emp_salary'])?count($arr_pay_run['emp_salary']):0 }} {{ trans('admin.employees') }}</div>
			</div>
		  	<div class="col-md-2"></div>
		</div>
	</div>
</div>

<div class="card">
<div class="card-body">
	<div class="table-responsive">
		<table class="table table-striped table-nowrap custom-table mb-0" id="shiftsTable">
			<thead>
				<tr>
					<th>{{ trans('admin.emp_name') }}</th>
					<th>{{ trans('admin.paid_days') }}</th>
					<th>{{ trans('admin.net_pay') }}</th>
					{{-- <th>Payment Mode</th> --}}
					<th>{{ trans('admin.payment_status') }}</th>
					<th>{{ trans('admin.pay_slip') }}</th>
					<th>{{ trans('admin.actions') }}</th>
				</tr>
			</thead>
			<tbody>
				@if(isset($arr_pay_run['emp_salary']) && sizeof($arr_pay_run['emp_salary'])>0)
					@foreach($arr_pay_run['emp_salary'] as $emp_salary)

						<tr>
							<td>{{ $emp_salary['user_details']['first_name'] ?? '' }} {{ $emp_salary['user_details']['last_name'] ?? '' }} ({{ $emp_salary['user_details']['id'] ?? '' }})</td>
							<td>{{ $emp_salary['paid_days'] ?? '-' }}</td>
							<td>{{ isset($emp_salary['monthly_total'])?number_format($emp_salary['monthly_total'],2):0.00 }}</td>
							<td>{{ $emp_salary['payment_status'] ?? '' }} on {{ isset($emp_salary['payment_date'])?date('d/m/Y',strtotime($emp_salary['payment_date'])):'' }}</td>
							<td><a target="_blank" href="{{ Route('view_payslip',base64_encode($emp_salary['id'])) }}">{{ trans('admin.view') }}</a></td>
							<td>

							@if(isset($emp_salary['is_added_on_erp']) && $emp_salary['is_added_on_erp']=='0')
								<a class="btn btn-primary btn-sm"  id="push_to_erp" href="{{ Route('pay_run_push_to_erp',base64_encode($emp_salary['id'])) }}">Push To ERP</a>
							@else
								<a href="{{ Route('pay_run_push_to_erp',base64_encode($emp_salary['id'])) }}" class="btn btn-secondary btn-sm"  id="pushed_to_erp" >Pushed</a>
							@endif
							
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#shiftsTable').DataTable({
		});
	});
</script>
@endsection
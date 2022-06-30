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

<form method="GET" action="{{ Route('record_payment_preview') }}" name="frm_approve_payment" id="frm_approve_payment">
{{ csrf_field() }}
<div class="card">
		
		@include('layout._operation_status')

	<div class="card-header">
		<h4 class="card-title m-0">Pay Preview</h4>
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
			          	<h4>{{ trans('admin.sar') }} {{ $payroll_cost ?? 0.00 }}</h4>
		        		<div class="text-uppercase text-xs">{{ trans('admin.payroll_cost') }}</div>
			      	</div>
			      	<div class="col-md-6">
			          	<h4>{{ trans('admin.sar') }} {{ $emp_net_pay ?? 0.00 }}</h4>
		        		<div class="text-uppercase text-xs">{{ trans('admin.employees_net_pay') }}</div>
			      	</div>
			    </div>
			</div>
			<div class="col-md-2 text-center border btn d-block mx-3">
			    <div class="text-uppercase text-muted">{{ trans('admin.pay_day') }}</div>
			    <div class="font-light text-xl">{{ isset($arr_pay_run['pay_date'])?date('d',strtotime($arr_pay_run['pay_date'])):'' }}</div>
			    <div class="text-uppercase text-xs">{{ isset($arr_pay_run['pay_date'])?date('M , Y',strtotime($arr_pay_run['pay_date'])):'' }}</div>
			    <hr class="my-2">
			      <div class="text-md">{{ isset($arr_master_salary)?count($arr_master_salary):0 }} {{ trans('admin.employees') }}</div>
			</div>
		  	{{-- <div class="col-md-3 deductions-section mx-3">
			    <h4 class="font-xmedium">Taxes &amp; Deductions</h4>
			    <table class="table noborder-table">
			      <tbody>
			          <tr>
			            <td class="payrun-label">Taxes</td>
			            <td class="text-right">₹600.00</td>
			          </tr>
			          <tr>
			            <td class="payrun-label">Pre-Tax Deductions</td>
			            <td class="text-right">₹0.00</td>
			          </tr>
			          <tr>
			            <td class="payrun-label">Post-Tax Deductions</td>
			            <td class="text-right">₹0.00</td>
			          </tr>
			      </tbody>
			    </table>
		  	</div> --}}
		  	<div class="col-md-2"></div>

		</div>
		{{-- <a href="#"  data-toggle="modal" data-target="#SubmitApprove" class="mt-3 border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.submit_and_approve') }}</a> --}}
		{{-- <button type="submit" class="mt-3 border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.submit_and_approve') }}</button> --}}
		<button type="submit" class="mt-3 border-0 btn btn-primary btn-gradient-primary btn-rounded">Continue</button>
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
					<th>{{ trans('admin.gross_pay') }}</th>
					<th>{{ trans('admin.net_pay') }}</th>
					@if(isset($arr_extra_earning) && sizeof($arr_extra_earning)>0)
						@foreach($arr_extra_earning as $extra_earn)
							<th>{{ $extra_earn['name'] ?? '' }}</th>
						@endforeach
					@endif
					
				</tr>
			</thead>
			
			<tbody>
				@if(isset($arr_master_salary) && sizeof($arr_master_salary)>0)
					@foreach($arr_master_salary as $key => $salary)
					
						<tr>
							<td>{{ $salary['user_details']['first_name'] ?? '' }} {{ $salary['user_details']['last_name'] ?? '' }} ({{ $salary['user_details']['id'] ?? '' }})</td>
							<td>{{ $salary['paid_days'] ?? '-' }}</td>
							<td>{{ isset($salary['monthly_total'])?number_format($salary['monthly_total'],2):0.00 }}</td>
							<td>{{ isset($salary['new_monthly_total'])?number_format($salary['new_monthly_total'],2):0.00 }}</td>
							@if(isset($arr_extra_earning) && sizeof($arr_extra_earning)>0)
								@foreach($arr_extra_earning as $extra_key => $extra_earn)
									<td>
										<input type="hidden" name="is_extra[{{ $salary['user_id'] ?? '' }}][{{ $extra_earn['id'] ?? '' }}]" value="{{ $extra_earn['id'] }}"/>
										<input type="checkbox" name="is_extra[{{ $salary['user_id'] ?? '' }}][{{ $extra_earn['id'] ?? '' }}]" value="0" checked />
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

<input type="hidden" name="enc_id" value="{{ $enc_id ?? '' }}">

</form>
<!-- Modal -->

<!-- modal -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#shiftsTable').DataTable({
		});
	});
</script>
@endsection
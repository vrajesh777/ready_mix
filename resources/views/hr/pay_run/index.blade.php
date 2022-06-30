@extends('layout.master')
@section('main_content')

<div class="card">
	<div class="card-header">
		<h4 class="card-title m-0">{{ trans('admin.pay_run') }}</h4>
	</div>
	{{-- @if(isset($arr_master_salary['arr_master_salary']) && ($emp_count == count($arr_master_salary['arr_master_salary']))) --}}
		<div class="card-body">
			<ul class="nav nav-tabs">
				<li class="nav-item"><a class="nav-link active" href="#RunPayroll" data-toggle="tab">{{ trans('admin.run_payroll') }}</a></li>
				<li class="nav-item"><a class="nav-link" href="#PayrollHistory" data-toggle="tab">{{ trans('admin.payroll_history') }}</a></li>
			</ul>
			@php
				$dateObj = \DateTime::createFromFormat('!m', $arr_current_pay_run['for_month']);
	        	$monthName = $dateObj->format('F');
			@endphp
			<div class="tab-content">
				<div class="tab-pane show active" id="RunPayroll">
					<h5 class="mb-4">{{ trans('admin.process_pay_run_for') }} {{ $monthName ?? '' }} {{ isset($arr_current_pay_run['for_year'])?date('Y',strtotime($arr_current_pay_run['for_year'])):'' }}</h5>
					<div class="payrun-info-row row">
					      <div class="col-md-8 col-sm-12 col-lg-7">
					        <div class="row">
					          <div class="col-md-4 payrun-detail">
					            <p class="mb-2">{{ trans('admin.employees_net_pay') }}</p>
					              <span class="payrun-price font-weight-bold">{{ trans('admin.sar') }} {{ $emp_net_pay ?? 0.00 }}</span>
					          </div>
					          <div class="col-md-4 payrun-detail border-left pl-4">
					            <p class="mb-2">{{ trans('admin.payment_date') }}</p>
					            <span class="payrun-data font-weight-bold">{{ isset($arr_current_pay_run['pay_date'])?date('d/m/Y',strtotime($arr_current_pay_run['pay_date'])):'' }}</span>
					          </div>
					            <div class="col-md-4 payrun-detail">
					              <p class="mb-2">{{ trans('admin.no_of_employees') }}</p>
					              <span class="payrun-data font-weight-bold">{{ isset($arr_master_salary['arr_master_salary'])?count($arr_master_salary['arr_master_salary']):0 }}</span>
					            </div>
					        </div>
					      </div>
					      	<div class="col-md-4 col-sm-12 col-lg-5 text-right">
					            <a href="{{ Route('pay_preview',base64_encode($arr_current_pay_run['id'])) }}" id="ember111" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.view_details') }}</a>
					        </div>
					</div>
					<p class="mt-3 mb-0"><i class="fas fa-info-circle mr-2 form-text"></i>{{ trans('admin.please_approve_this_payroll_before') }} {{ isset($arr_current_pay_run['pay_date'])?date('d/m/Y',strtotime($arr_current_pay_run['pay_date'])):'' }}</p>
				</div>
				<div class="tab-pane" id="PayrollHistory">
					<div class="table-responsive">
	                    <table class="table table-striped custom-table">
	                    	@if(isset($arr_payroll_history) && sizeof($arr_payroll_history)>0)
	                        <thead>
	                          	<tr>
	                            	<th>{{ trans('admin.payment_date') }}</th>
	                            	<th>{{ trans('admin.details') }}</th>
	                            	<th>{{ trans('admin.actions') }}</th>
	                          	</tr>
	                        </thead>
	                        <tbody>
	                    		@foreach($arr_payroll_history as $payroll)
	                          		<tr>
			                            <td>{{ isset($payroll['pay_date'])?date('d/m/Y',strtotime($payroll['pay_date'])):'' }}</td>
			                            <td>01/{{ $payroll['for_month'] ?? '' }}/{{ $payroll['for_year'] }} - {{ isset($payroll['pay_date'])?date('d/m/Y',strtotime($payroll['pay_date'])):'' }}</td>
			                            <td class="text-success"><a href="{{ Route('pay_summary',base64_encode($payroll['id'])) }}">View</a></td>
	                          		</tr>
	                      		@endforeach
	                        </tbody>
	                        @else
	                      		{{ trans('admin.data_not_found') }}
	                      	@endif
	                    </table>
	                </div>
				</div>
			</div>
		</div>
	{{-- @else
		<h4 class="card-title m-0">For Pay run need to add salary details for all employee first.</h4>
	@endif --}}

</div>
@endsection
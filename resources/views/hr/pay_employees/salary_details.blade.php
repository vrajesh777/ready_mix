@extends('layout.master')
@section('main_content')
@php
	$nationality_id = $arr_user['nationality_id'];
@endphp
<div class="card">
	<div class="card-header">
		<h4 class="card-title m-0">{{ trans('admin.salary_details') }} ({{ $arr_user['emp_id'] ?? '' }}) - {{ $arr_user['first_name'] ?? '' }} {{ $arr_user['last_name'] ?? '' }}
			<a href="{{ Route('edit_salary_details',$enc_id) }}" class="edit-icon"><i class="fa fa-pencil"></i></a>
		</h4>
	</div>
	@if(isset($arr_salary) && sizeof($arr_salary)>0)
	<div class="card-body payroll-detail">
				
			<div class="form-group row">
				<div class="col-sm-4">
					<label class="col-form-label">{{ trans('admin.annual_ctc') }}</label>
					<div class="font-weight-bold">{{ trans('admin.sar') }} {{ isset($arr_salary['annualy_total'])?number_format($arr_salary['annualy_total'],2):0 }} {{ trans('admin.per_year') }}</div>
				</div>
				<div class="col-sm-4">
					<label class="col-form-label">{{ trans('admin.monthly_income') }}</label>
                    <div class="font-weight-bold">{{ trans('admin.sar') }} {{ isset($arr_salary['monthly_total'])?number_format($arr_salary['monthly_total'],2):0 }}
                  	</div>
				</div>
				<div class="col-sm-4">
					<ul class="pagination justify-content-end pt-3 px-3 mb-0">
						<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="window.print()">
							<i class="fal fa-print"></i></a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table mb-0">
					<thead>
						<tr>
							<th>{{ trans('admin.salary_component') }}</th>
							<th>{{ trans('admin.amount_monthly') }} (SAR)</th>
							<th>{{ trans('admin.amount_annually') }} (SAR)</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3" class="font-weight-bold">{{ trans('admin.earnings') }}</td>
						</tr>
						@php
							$arr_salary_details = [];
							if(isset($arr_salary['salary_details']) && sizeof($arr_salary['salary_details'])>0){
					            foreach ($arr_salary['salary_details'] as $key => $value) {
					                $arr_salary_details[$value['earning_id']] = $value ?? [];
					            }
					        }
						@endphp
						<tr>
							<td>{{ trans('admin.basic') }}</td>
							<td>{{ isset($arr_salary['basic'])?number_format($arr_salary['basic'],2):0 }}</td>
							<td>{{ isset($arr_salary['basic'])?number_format(($arr_salary['basic'] * 2 ),2):0 }}</td>
						</tr>
						@if((isset($arr_master_earning) && sizeof($arr_master_earning)>0) && (isset($arr_salary['salary_details']) && count($arr_salary['salary_details'])>0))
							@foreach($arr_master_earning as $key => $value)
								<tr>
									<td>{{ $value['name_payslip'] ?? '' }}<br>@if(isset($arr_salary_details[$value['id']]['cal_value']) && ($arr_salary_details[$value['id']]['cal_value']!='' && $arr_salary_details[$value['id']]['cal_value']!=0))	({{ $arr_salary_details[$value['id']]['cal_value'] ? $arr_salary_details[$value['id']]['cal_value']:0 }} % {{ trans('admin.of_basic') }}) 
									 @endif</td>
									<td>{{ $arr_salary_details[$value['id']]['monthly_amt'] ? number_format($arr_salary_details[$value['id']]['monthly_amt'],2):0 }}</td>
									<td>{{ $arr_salary_details[$value['id']]['monthly_amt'] ? number_format($arr_salary_details[$value['id']]['monthly_amt'] * 12) : 0 }}</td>
								</tr>
								
							@endforeach
						@endif
						<tr class="company-cost">
							{{-- <td colspan="">{{ trans('admin.cost_to_company') }}</td> --}}
							<td colspan="">{{ trans('admin.cost_to_emp') }}</td>
							
							<td class="">{{ trans('admin.sar') }} {{ isset($arr_salary['monthly_total'])?number_format($arr_salary['monthly_total'],2):0 }}	</td>
							
							<td>{{ trans('admin.sar') }} {{ isset($arr_salary['annualy_total'])?number_format(($arr_salary['annualy_total'] * 12 ),2):0 }}</td>
						</tr>

						<tr>
							<td colspan="3" class="font-weight-bold">{{ trans('admin.overhead_expances') }}</td>
						</tr>

						@php
							$sum_normal_earning = $total_normal_earning = $over_amount = $total_overhead_expances = 0;
							if((isset($arr_master_earning) && sizeof($arr_master_earning)>0) && (isset($arr_salary['salary_details']) && count($arr_salary['salary_details'])>0)){
								foreach($arr_master_earning as $key => $value){

									if($value['is_extra'] == 0){
										$sum_normal_earning += $arr_salary_details[$value['id']]['monthly_amt'];
									}
								}
							}

							$total_normal_earning =  ($arr_salary['basic'] ?? 0) + $sum_normal_earning;
						@endphp

						@if(isset($arr_overhed_exp) && sizeof($arr_overhed_exp)>0)
							@foreach($arr_overhed_exp as $over_key => $over_value)
								@if((isset($nationality_id) && $nationality_id!='' && $nationality_id == 191) && (in_array($over_value['id'],['1','2'])))
										@php
											if($over_value['type'] == 'percentage'){
												$over_amount = $total_normal_earning * $over_value['value'] / 100;
											}
											elseif($over_value['type'] == 'flat'){
												$over_amount = $over_value['value'] ?? 0;
											}

											$total_overhead_expances += $over_amount ?? 0;
										@endphp
										<tr>
											<td>{{ $over_value['name'] ?? '' }}</td>
											<td>{{ number_format($over_amount,2) ?? 0 }}</td>
											<td>{{ number_format(($over_amount * 12 ),2) }}</td>
										</tr>
								@elseif((isset($nationality_id) && $nationality_id!='' && $nationality_id != 191))
									@php
										if($over_value['type'] == 'percentage'){
											$over_amount = $total_normal_earning * $over_value['value'] / 100;
										}
										elseif($over_value['type'] == 'flat'){
											$over_amount = $over_value['value'] ?? 0;
										}

										$total_overhead_expances += $over_amount ?? 0;
									@endphp
									<tr>
										<td>{{ $over_value['name'] ?? '' }}</td>
										<td>{{ number_format($over_amount,2) ?? 0 }}</td>
										<td>{{ number_format(($over_amount * 12 ),2) }}</td>
									</tr>
								@endif
							@endforeach
						@endif
						

						<tr class="company-cost">
							<td colspan="">{{ trans('admin.cost_to_company') }}</td>
							
							<td class="">{{ trans('admin.sar') }} {{ isset($arr_salary['monthly_total'])?number_format(($arr_salary['monthly_total'] + $total_overhead_expances),2):0 }}	</td>
							
							<td>{{ trans('admin.sar') }} {{ isset($arr_salary['annualy_total'])?number_format((($arr_salary['annualy_total'] + $total_overhead_expances) * 12 ),2):0 }}</td>
						</tr>

					</tbody>
				</table>
			
			</div>
	</div>
	@else
		<div class="card-header">
		<h4>{{ trans('admin.salary_details_not_found') }} => <a href="{{ Route('edit_salary_details',$enc_id) }}">{{ trans('admin.add') }} {{ trans('admin.salary_details') }}</h4>
		</div>
	@endif
</div>

@endsection
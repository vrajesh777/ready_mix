@extends('layout.master')
@section('main_content')

<div class="card">

	@include('layout._operation_status')

	<div class="card-header">
		<h4 class="card-title mb-0"> {{ $arr_user['emp_id'] ?? '' }} - {{ $arr_user['first_name'] ?? '' }} {{ $arr_user['last_name'] ?? '' }} {{ trans('admin.salary_details') }}</h4>
	</div>
	<form method="post" action="{{ Route('update_salary_details') }}" name="frm_sal_details" id="frm_sal_details">
	{{ csrf_field() }}
		<input type="hidden" name="enc_id" value="{{ $enc_id ?? '' }}">
		<div class="card-body payroll-detail">	
				<div class="form-group d-flex align-items-center">
					<label>{{ trans('admin.basic') }}</label>
					<div class="input-group w-25 ml-5 mr-3">
					<div class="input-group-prepend">
						<span class="input-group-text">{{ trans('admin.sar') }}</span>
					</div>
					<input type="text" name="per_month" id="per_month" class="form-control w-50" placeholder="0" data-rule-required="true" value="{{ $arr_salary['basic'] ?? '' }}">
					
					</div>
					<label>{{ trans('admin.per_month') }}</label>
				</div>			
				<div class="table-responsive">
					<table class="table mb-0">
						<thead>
							<tr>
								<th>{{ trans('admin.salary_component') }}</th>
								<th>{{ trans('admin.calculation_type') }}</th>
								<th>{{ trans('admin.amount_monthly') }}</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="4" class="font-weight-bold">{{ trans('admin.earnings') }}</td>
							</tr>

							@php
								$arr_salary_details = [];
								if(isset($arr_salary['salary_details']) && sizeof($arr_salary['salary_details'])>0){
						            foreach ($arr_salary['salary_details'] as $key => $value) {
						                $arr_salary_details[$value['earning_id']] = $value ?? [];
						            }
						        }
						        //dd();
							@endphp

							@if(isset($arr_master_earning) && sizeof($arr_master_earning)>0)
								@foreach($arr_master_earning as $key => $value)
								<input type="hidden" name="earning_id[]" value="{{ $value['id'] ?? '' }}" >
								<tr>
									<td>{{ $value['name_payslip'] ?? '' }}</td>
									<td class="w-300">
										@if($value['cal_type'] !='' && $value['cal_type']!='flat')
											<div class="input-group per_allwns">
												<input type="text" name="cal_value[]" id="cal_value_{{ $value['id'] ?? '' }}" class="form-control per_allwns" placeholder="0.00" data-itr="{{ $key }}" data-rule-number="true" minlength="1" maxlength="2" @if(isset($arr_salary_details[$value['id']]['cal_value']) && $arr_salary_details[$value['id']]['cal_value']!='') value="{{ $arr_salary_details[$value['id']]['cal_value'] ?? '' }}" @endif>
												<div class="input-group-append">
													<span class="input-group-text" id="basic-addon2">% {{ trans('admin.of_basic') }}</span>
												</div>
											</div>
										@else
											<input type="hidden" name="cal_value[]" id="cal_value_{{ $value['id'] ?? '' }}">
											{{ trans('admin.fixed') }}
										@endif
									</td>
									<td class="w-300">
										<input type="text" name="monthly_amt[]" id="monthly_amt_{{ $value['id'] ?? '' }}" class="form-control text-right per_amt_{{ $key }}" placeholder="0" data-rule-number="true" @if(isset($value['cal_type']) && $value['cal_type']!='' && $value['cal_type']!='flat') readonly @endif @if(isset($arr_salary_details[$value['id']]['monthly_amt']) && $arr_salary_details[$value['id']]['monthly_amt']!='') value="{{ $arr_salary_details[$value['id']]['monthly_amt'] ?? 0 }}" @endif>
									</td>
								</tr>

								@endforeach
							@endif

							<tr class="company-cost">
								<td colspan="2">{{ trans('admin.cost_to_company') }}</td>
								<td id="total_monthly_amt" class="">{{ trans('admin.sar') }} {{ $arr_salary['monthly_total'] ?? 0 }}</td>
								<td id="total_annualy_amt">{{ trans('admin.sar') }} {{ $arr_salary['annualy_total'] ?? 0 }}</td>
								<input type="hidden" name="total_monthly_amt" id="h_total_monthly_amt">
								<input type="hidden" name="total_annualy_amt" id="h_total_annualy_amt">
							</tr>
						
						</tbody>
					</table>

					<div class="text-right">
						<button type="submit" name="frm_update" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>
						{{-- <button type="button" class="btn btn-secondary btn-rounded closeForm">Cancel</button> --}}
					</div>
				</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	var sar = "{{ trans('admin.sar') }}";
	$(document).ready(function() {

		$('#frm_sal_details').validate();

		$('#per_month').blur(function(){
			$(".per_allwns").each(function() {
				var per_month = $('input[name="per_month"]').val();
				if(per_month!=''){
					var itr = $(this).data('itr');
					var cal_value = $(this).val();
					var per_amt   = (per_month * cal_value) / 100;
					$('.per_amt_'+itr).val(per_amt);
					cal_total_per_month();
				}
			});
		});

		$(".per_allwns").blur(function(){
			var per_month = $('input[name="per_month"]').val();
			if(per_month!=''){
				var itr = $(this).data('itr');
				var cal_value = $(this).val();
				var per_amt   = (per_month * cal_value) / 100;
				$('.per_amt_'+itr).val(per_amt);
				cal_total_per_month();	
			}
		});

		function cal_total_per_month(){
			var total = 0;
			var per_month = $('input[name="per_month"]').val();
			$('input[name="monthly_amt[]"]').each(function() {
				if($(this).val()!=''){
					total += parseInt($(this).val());
				}
			})
			var per_month_total = parseInt(per_month) + parseInt(total);
			$('#total_monthly_amt').html(sar+' '+per_month_total);
			$('#total_annualy_amt').html(sar+' '+(per_month_total*12));
			
			$('#h_total_monthly_amt').val(per_month_total);
			$('#h_total_annualy_amt').val(per_month_total*12);
		}

		$('input[name="monthly_amt[]"]').blur(function(){
			var per_month = $('input[name="per_month"]').val();
			if(per_month!=''){
				cal_total_per_month();
			}
		});
	});

	function numberWithCommas(x) {
        "use strict";
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

@endsection
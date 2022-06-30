@extends('layout.master')
@section('main_content')

<form method="POST" action="{{ Route('pay_schedule_update') }}" id="formAddEstimate" autocomplete="off">
	<div class="row">
		{{ csrf_field() }}
		<input type="hidden" name="enc_id" value="{{ $arr_data['id'] ?? '' }}">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
				<h4>{{ trans('admin.pay_schedule') }}</h4>
				<hr>

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="form-group col-sm-12 related_wrapp">
									<label class="col-form-label">{{ trans('admin.calculate_monthly_salary_based_on') }}<span class="text-danger">*</span></label>
									<div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" name="salary_on" id="salary_on2" value="0" @if(isset($arr_data['salary_on']) && $arr_data['salary_on']!='' && $arr_data['salary_on'] == '0') checked @endif>
										<label class="form-check-label d-flex align-items-center" for="salary_on2">
										 {{ trans('admin.actual_days_in_month') }}
										</label>
									</div>
		                            <div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" name="salary_on" id="salary_on1" value="1" @if(isset($arr_data['salary_on']) && $arr_data['salary_on']!='' && $arr_data['salary_on'] == '1') checked @endif>
										<label class="form-check-label d-flex align-items-center" for="salary_on1">
										{{ trans('admin.organisation_working_days') }} - 
										<select class="form-control w-50 h-30 mx-1"  name="days_per_month" @if(isset($arr_data['salary_on']) && $arr_data['salary_on']!='' && $arr_data['salary_on'] != '1') disabled="disabled" @endif>
											<?php
												for($i=20;$i <= 30;$i=$i+1){
											?>
											<option value="{{ $i }}"  @if(isset($arr_data['days_per_month']) && $arr_data['days_per_month']!='' && $arr_data['days_per_month'] == $i) selected @endif>{{ $i }}</option>
											<?php
												}
											?>
										</select>
										{{ trans('admin.days_per_month') }}
										</label>
									</div>
								</div>

								<div class="form-group col-sm-12 related_wrapp">
									<label class="col-form-label">{{ trans('admin.pay_your_employees_on') }}<span class="text-danger">*</span></label>
									<div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" name="pay_on" id="pay_on2" value="0" @if(isset($arr_data['pay_on']) && $arr_data['pay_on']!='' && $arr_data['pay_on'] == '0') checked @endif>
										<label class="form-check-label d-flex align-items-center" for="pay_on2">
										 {{ trans('admin.last_day_every_month') }}
										</label>
									</div>
		                            <div class="form-check d-flex align-items-center ml-2">
										<input class="form-check-input" type="radio" name="pay_on" id="pay_on1" value="1" @if(isset($arr_data['pay_on']) && $arr_data['pay_on']!='' && $arr_data['pay_on'] == '1') checked @endif>
										<label class="form-check-label d-flex align-items-center" for="pay_on1">
										{{ trans('admin.day') }}  
										<select class="form-control w-50 h-30 mx-1"  name="on_every_month" id="on_every_month"  @if(isset($arr_data['pay_on']) && $arr_data['pay_on']!='' && $arr_data['pay_on'] != '1') disabled="disabled" @endif>
											<?php
												for($j=1;$j <= 28;$j=$j+1){
											?>
											<option value="{{ $j }}" @if(isset($arr_data['on_every_month']) && $arr_data['on_every_month']!='' && $arr_data['on_every_month'] == $j) selected @endif>{{ $j }}</option>
											<?php
												}
											?>
										</select>
										{{ trans('admin.of_every_month') }}
										</label>
									</div>
								</div>

								<div class="form-group col-sm-3 related_wrapp">
									<label class="col-form-label">{{ trans('admin.start_first_payroll') }}<span class="text-danger">*</span></label>
		                            <select name="start_payroll" class="select select2" id="start_payroll" data-rule-required="true">
		                            	<option value="">{{ trans('admin.select') }}</option>
										<option value="{{ date('m/Y',strtotime('-1 Month')) }}" @if(isset($arr_data['start_payroll']) && $arr_data['start_payroll']!='' && $arr_data['start_payroll'] == date('m/Y',strtotime('-1 Month'))) selected @endif>{{ date('M-Y',strtotime('-1 Month')) }}</option>
										<option value="{{ date('m/Y') }}" @if(isset($arr_data['start_payroll']) && $arr_data['start_payroll']!='' && $arr_data['start_payroll'] == date('m/Y')) selected @endif>{{ date('M-Y') }}</option>
										<option value="{{ date('m/Y',strtotime('+1 Month')) }}" @if(isset($arr_data['start_payroll']) && $arr_data['start_payroll']!='' && $arr_data['start_payroll'] == date('m/Y',strtotime('+1 Month'))) selected @endif>{{ date('M-Y',strtotime('+1 Month')) }}</option>
										<option value="{{ date('m/Y',strtotime('+2 Month')) }}" @if(isset($arr_data['start_payroll']) && $arr_data['start_payroll']!='' && $arr_data['start_payroll'] == date('m/Y',strtotime('+2 Month'))) selected @endif>{{ date('M-Y',strtotime('+2 Month')) }}</option>
										<option value="{{ date('m/Y',strtotime('+3 Month')) }}" @if(isset($arr_data['start_payroll']) && $arr_data['start_payroll']!='' && $arr_data['start_payroll'] == date('m/Y',strtotime('+3 Month'))) selected @endif>{{ date('M-Y',strtotime('+3 Month')) }}</option>
									</select>
									<label id="start_payroll-error" class="error" for="start_payroll"></label>
									<div class="error">{{ $errors->first('start_payroll') }}</div>
								</div>

								<div class="form-group col-sm-3 related_wrapp first_pay_date" @if(isset($arr_data['first_pay_date']) && $arr_data['first_pay_date']=='') style="display:none;" @endif>
									<label class="col-form-label">{{ trans('admin.sal_month_will_paid_on') }}<span class="text-danger">*</span></label>
		                            <select name="first_pay_date" class="select select2" id="first_pay_date" data-rule-required="true">
		                            	@if(isset($arr_data['first_pay_date']) && $arr_data['first_pay_date']!='')
		                            		<option value="{{ $arr_data['first_pay_date'] ?? '' }}">{{ date('d/m/Y',strtotime($arr_data['first_pay_date'])) ?? '' }}</option>
		                            	@endif
									</select>
									<label id="first_pay_date-error" class="error" for="first_pay_date"></label>
									<div class="error">{{ $errors->first('first_pay_date') }}</div>
								</div>

							</div>
						</div>
					</div>


				</div>
				@if(empty($arr_data))
					<div class="text-center py-3">
				    	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
				    </div>
			    @endif
			</div>
		</div>

	</div>
	
</form>
<script type="text/javascript">
	$(document).ready(function() {

		$('#formAddEstimate').validate();

		$('input[name=salary_on]').change(function() {
			if($(this).val() == 1) {
				$('select[name=days_per_month]').removeAttr('disabled');
			}else{
				$('select[name=days_per_month]').attr('disabled',true);
			}
		});

		$('input[name=pay_on]').change(function() {
			if($(this).val() == 1) {
				$('select[name=on_every_month]').removeAttr('disabled');
			}else{
				$('select[name=on_every_month]').attr('disabled',true);
			}
		});
	});

	var getDaysInMonth = function(month,year) {
		return new Date(year, month, 0).getDate();
	};

	var getDaysInMonths = function(day,month,year) {
		return new Date(year, month,day).getDate();
	};

	$('#start_payroll').change(function(){
		var first_payroll = $(this).val();
		var every_month = $('#on_every_month').val();
		var temp = first_payroll.split("/");
		var selected_radio = $("input[type='radio'][name='pay_on']:checked").val();
		console.log(selected_radio);
		if(selected_radio == 0){
			console.log('last');
			var days = getDaysInMonth(temp[0],temp[1]);
			var new_date = days+'/'+first_payroll;
		}else if(selected_radio == 1){
			console.log('every');
			var days = getDaysInMonths(every_month,temp[0],temp[1]);
			var new_date = days+'/'+first_payroll;
		}
		$('.first_pay_date').show();
		var html = '<option>'+new_date+'</option>';
		$('#first_pay_date').html(html);
	});
</script>
@stop
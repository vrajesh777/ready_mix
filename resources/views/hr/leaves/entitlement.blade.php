<div class="form-group input-group row">
	<label class="col-sm-2"><strong>{{ trans('admin.effective_after') }} </strong> <span class="text-danger">*</span></label>
	<div class="col-sm-6 d-flex align-items-center">
		<input type="text" name="effective_period" class="form-control w-90 mr-n01 rounded0-right" value="0">
		<div class="rounded0-left w-200">
		<select name="effective_unit" class="select">
			<option value="days">{{ trans('admin.days') }}</option>
			<option value="years" selected>{{ trans('admin.year') }}</option>
			<option value="months">{{ trans('admin.months') }}</option>
		</select>
		</div>
		<label class="col-sm-2 text-right">from</label>
		<select name="exp_field" class="select w-150">
			<option value="date_of_join" selected >{{ trans('admin.date_of_joining') }}</option>
			<option value="date_of_conf">{{ trans('admin.date_of_confirmation') }}</option>
		</select>
	</div>
</div>

<div class="form-group input-group row">
	<label class="col-sm-2 d-flex">
		<label class="container-checkbox">
		  	<input type="checkbox" name="accrual" value="1" checked="">
		  	<span class="checkmark"></span>
		</label>
		Accrual
	</label>
	<div class="col-sm-9 accrual-opt-wrap">
		<div class="row align-items-center">
		<div class="col-sm-2">
			<select name="accrual_period" class="select">
				{{-- <option value="on_time">{{ trans('admin.on_time') }}</option> --}}
				<option value="yearly" selected>{{ trans('admin.yearly') }}</option>
				{{-- <option value="monthly">{{ trans('admin.monthly') }}</option>
				<option value="half_yearly">{{ trans('admin.half_yearly') }}</option>
				<option value="triannually">{{ trans('admin.triannually') }}</option>
				<option value="quarterly">{{ trans('admin.quarterly') }}</option>
				<option value="bi_monthly">{{ trans('admin.bi_monthly') }}</option>
				<option value="semi_monthly">{{ trans('admin.semi_monthly') }}</option>
				<option value="bi_weekly">{{ trans('admin.bi_weekly') }}</option>
				<option value="weekly">{{ trans('admin.weekly') }}</option> --}}
			</select>
		</div>
		{{-- <label class="w-auto text-right">on</label>
		<div class="col-sm-2">
			<select name="accrual_time" class="select">
				@for($i=1;$i<=31;$i++)
				<option value="{{ $i }}">{{ ordinal($i) }}</option>
				@endfor
				<option value="last_day">{{ trans('admin.last_day') }}</option>
				<option value="policy_date">{{ trans('admin.policy_date') }}</option>
				<option value="joining_date">{{ trans('admin.joining_date') }}</option>
				<option value="birth_date">{{ trans('admin.birth_date') }}</option>
			</select>
		</div> --}}
		{{-- <div class="col-sm-2">
			<?php
				$from = date('Y-m-d', strtotime('first day of january this year'));
				$to = date('Y-m-d', strtotime('last day of december this year'));;
				$period = Carbon\CarbonPeriod::create($from, '1 month', $to);
			?>
			<select name="accrual_month" class="select">
				@foreach ($period as $key => $dt)
				@php $objCurr = new Carbon('first day of this month'); @endphp
    			<option value="{{ ++$key }}" {{ $dt->toDateString()==$objCurr->subMonth()->toDateString()?'selected':'' }} >{{ $dt->format('M') }} </option>
    			@endforeach
			</select>
		</div> --}}	
			<label class="w-auto text-right">{{ trans('admin.no_of_days') }}</label>
			<input type="text" name="accrual_no_days" class="form-control w-90 mx-3" data-rule-required="true" data-rule-digits="true">
			<label class="w-auto text-right">{{ trans('admin.in') }}</label>
			<div class="col-sm-2">
			<select name="accrual_mode" class="select">
				<option value="current_accrual" selected>{{ trans('admin.current_accrual') }} </option>
				<option value="next_accrual">{{ trans('admin.next_accrual') }} </option>
			</select>
			</div>
		</div>
	</div>
</div>

<div class="form-group input-group row">
	<label class="col-sm-2 d-flex">
		<label class="container-checkbox">
		  	<input type="checkbox" name="reset" value="1" checked="">
		  	<span class="checkmark"></span>
		</label>
		{{ trans('admin.reset') }}
	</label>
	<div class="col-sm-9 reset-opt-wrap">
		<div class="row align-items-center">
			<div class="col-sm-2">
				<select name="reset_period" class="select">
					{{-- <option value="on_time">{{ trans('admin.on_time') }}</option> --}}
					<option value="yearly" selected>{{ trans('admin.yearly') }}</option>
					{{-- <option value="monthly">{{ trans('admin.monthly') }}</option>
					<option value="half_yearly">{{ trans('admin.half_yearly') }}</option>
					<option value="triannually">{{ trans('admin.triannually') }}</option>
					<option value="quarterly">{{ trans('admin.quarterly') }}</option>
					<option value="bi_monthly">{{ trans('admin.bi_monthly') }}</option>
					<option value="semi_monthly">{{ trans('admin.semi_monthly') }}</option>
					<option value="bi_weekly">{{ trans('admin.bi_weekly') }}</option>
					<option value="weekly">{{ trans('admin.weekly') }}</option> --}}
				</select>
			</div>
				<label class="w-auto text-right">on</label>
			{{-- <div class="col-sm-2">
				<select name="reset_time" class="select">
					@for($i=1;$i<=31;$i++)
					<option value="{{ $i }}">{{ ordinal($i) }}</option>
					@endfor
					<option value="last_day">{{ trans('admin.last_day') }}</option>
					<option value="policy_date">{{ trans('admin.policy_date') }}</option>
					<option value="joining_date">{{ trans('admin.joining_date') }}</option>
					<option value="birth_date">{{ trans('admin.birth_date') }}</option>
				</select>
			</div> --}}
			{{-- <div class="col-sm-2">
				<?php
					$from = date('Y-m-d', strtotime('first day of january this year'));
					$to = date('Y-m-d', strtotime('last day of december this year'));;
					$period = Carbon\CarbonPeriod::create($from, '1 month', $to);
				?>
				<select name="reset_month" class="select">
					@foreach ($period as $key => $dt)
					@php $objCurr = new Carbon('first day of this month'); @endphp
	    			<option value="{{ ++$key }}" {{ $dt->toDateString()==$objCurr->subMonth()->toDateString()?'selected':'' }} >{{ $dt->format('M') }} </option>
	    			@endforeach
				</select>
			</div> --}}
			<div class="col-sm-2">
				<select name="reset_month" class="select w-150">
					<option value="date_of_join" selected >{{ trans('admin.date_of_joining') }}</option>
					<option value="date_of_conf">{{ trans('admin.date_of_confirmation') }}</option>
				</select>
			</div>
		</div>
	</div>
</div>
<!-- <hr> -->
<div class="form-group input-group row reset-opt-wrap">
	<div class="col-sm-12 sel-w-150 d-flex align-items-center">
		<div class="offset-2">&nbsp</div>
		<select name="cf_mode" class="select" id="cf_mode">
			<option value="carry_forward">{{ trans('admin.carry_forward') }}</option>
			<option value="carry_forward_with_expiry">{{ trans('admin.carry_forward_with_expiry') }}</option>
			{{-- <option value="Carry_forward_with_overall_limit">{{ trans('admin.Carry_forward_with_overall_limit') }}</option> --}}
		</select>

		<div class="col-sm-2 d-flex align-items-center rounded0-left">
			<input type="text" name="reset_carry" value="0" class="form-control w-90 mx-n01 rounded0-right">
			<select name="reset_carry_type" class="select">
				<option value="unit">{{ trans('admin.unit') }}(s)</option>
				<option value="percentage" selected>{{ trans('admin.percentage') }}</option>
			</select>
		</div>
		<label class="w-auto text-right max_limit">{{ trans('admin.max_limit') }}</label>
		<div class="col-sm-2 align-items-center max_limit">
			<!-- <label class="w-auto text-right px-2 max_limit">{{ trans('admin.max_limit') }}</label> -->
			<input type="text" name="reset_carry_limit" class="form-control w-90 max_limit">
		</div>

		<div class="col-sm-4 align-items-center expire_in" style="display:none!important;">
			<label class="col-sm-2 text-right">Expires in</label>
			<input type="text" name="reset_carry_expire_in" class="form-control w-90 mr-n01 rounded0-right" value="1">
			<select name="reset_carry_expire_unit" class="select w-150 rounded0-left">
				<option value="months">Month(s)</option>
			</select>
		</div>

	</div>
</div>	

<!-- <hr> -->

{{-- <div class="form-group input-group row reset-opt-wrap">
	<div class="col-sm-12 sel-w-150 d-flex align-self-center">
	<div class="offset-1 pl-5">&nbsp</div>

	<label class="w-150 text-right px-2">{{ trans('admin.encashment') }}</label>
		<input type="text" name="reset_encash_num" class="form-control w-90 mx-n01 rounded-0">

		<select name="encash_type" class="select">
			<option value="unit">{{ trans('admin.unit') }}(s)</option>
			<option value="percentage" selected>Percentage</option>
		</select>
		<label class="w-auto text-right px-2">{{ trans('admin.max_limit') }}</label>
		<input type="text" name="reset_encash_limit" class="form-control w-90">
	</div>
</div> --}}

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<script type="text/javascript">
	
	$(document).ready(function(){
		$('input[name=accrual]').change(function(){
			if($(this).is(':checked')) {
				$('.accrual-opt-wrap').fadeIn();
			}else{
				$('.accrual-opt-wrap').fadeOut();0001
			}
		});

		$('input[name=reset]').change(function(){
			if($(this).is(':checked')) {
				$('.reset-opt-wrap').fadeIn();
			}else{
				$('.reset-opt-wrap').fadeOut();
			}
		});
	});

	$('#cf_mode').change(function(){
		var cf_mode = $(this).val();
		if(cf_mode == 'carry_forward'){
			$('.expire_in').hide();
			$('.max_limit').show();
		}else if(cf_mode == 'carry_forward_with_expiry'){
			$('.expire_in').show();
			$('.max_limit').hide();
		}else if(cf_mode == 'Carry_forward_with_overall_limit'){
			$('.expire_in').hide();
			$('.max_limit').show();
		}
	})

</script>
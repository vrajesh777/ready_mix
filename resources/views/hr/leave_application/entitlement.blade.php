<div class="form-group input-group row">
	<label class="col-sm-2"><strong>Effective After </strong> <span class="text-danger">*</span></label>
	<div class="col-sm-6 d-flex align-items-center">
		<input type="text" name="effective_period" class="form-control w-90 mr-n01 rounded0-right" value="0">
		<select name="effective_unit" class="select w-150 rounded0-left">
			<option value="days">Days</option>
			<option value="years" selected>Year(s)</option>
			<option value="months">Months</option>
		</select>
		<label class="col-sm-2 text-right">from</label>
		<select name="exp_field" class="select w-150">
			<option value="date_of_join" selected >Date of Joining</option>
			<option value="date_of_conf">Date of Confirmation</option>
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
				<option value="on_time">On Time</option>
				<option value="yearly" selected>Yearly</option>
				<option value="monthly">Monthly</option>
				<option value="half_yearly">Half Yearly</option>
				<option value="triannually">Triannually</option>
				<option value="quarterly">Quarterly</option>
				<option value="bi_monthly">Bi Monthly</option>
				<option value="semi_monthly">Semi Monthly</option>
				<option value="bi_weekly">Bi Weekly</option>
				<option value="weekly">Weekly</option>
			</select>
		</div>
		<label class="w-auto text-right">on</label>
		<div class="col-sm-2">
			<select name="accrual_time" class="select">
				@for($i=1;$i<=31;$i++)
				<option value="{{ $i }}">{{ ordinal($i) }}</option>
				@endfor
				<option value="last_day">Last Day</option>
				<option value="policy_date">Policy Date</option>
				<option value="joining_date">Joining Date</option>
				<option value="birth_date">Birth Date</option>
			</select>
		</div>
		<div class="col-sm-2">
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
		</div>	
			<label class="w-auto text-right">No. of Days</label>
			<input type="text" name="accrual_no_days" class="form-control w-90 mx-3">
			<label class="w-auto text-right">in</label>
			<div class="col-sm-2">
			<select name="accrual_mode" class="select">
				<option value="current_accrual" selected>Current Accrual</option>
				<option value="next_accrual">Next Accrual</option>
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
		Reset
	</label>
	<div class="col-sm-9 reset-opt-wrap">
		<div class="row align-items-center">
			<div class="col-sm-2">
				<select name="reset_period" class="select">
					<option value="on_time">On Time</option>
					<option value="yearly" selected>Yearly</option>
					<option value="monthly">Monthly</option>
					<option value="half_yearly">Half Yearly</option>
					<option value="triannually">Triannually</option>
					<option value="quarterly">Quarterly</option>
					<option value="bi_monthly">Bi Monthly</option>
					<option value="semi_monthly">Semi Monthly</option>
					<option value="bi_weekly">Bi Weekly</option>
					<option value="weekly">Weekly</option>
				</select>
			</div>
				<label class="w-auto text-right">on</label>
			<div class="col-sm-2">
				<select name="reset_time" class="select">
					@for($i=1;$i<=31;$i++)
					<option value="{{ $i }}">{{ ordinal($i) }}</option>
					@endfor
					<option value="last_day">Last Day</option>
					<option value="policy_date">Policy Date</option>
					<option value="joining_date">Joining Date</option>
					<option value="birth_date">Birth Date</option>
				</select>
			</div>
			<div class="col-sm-2">
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
			</div>
		</div>
	</div>
</div>

<div class="form-group input-group row">
	<div class="col-sm-12 sel-w-150 d-flex">
		<div class="offset-1 pl-5">&nbsp</div>
		<select name="cf_mode" class="select">
			<option value="carry_forward">Carry Forward</option>
			<option value="carry_forward_with_expiry">Carry Forward With Expiry</option>
			<option value="Carry_forward_with_overall_limit">Carry Forward With Overall Limit</option>
		</select>

		<input type="text" name="reset_carry" value="0" class="form-control w-90 mx-n01 rounded-0">

		<select name="reset_carry_type" class="select">
			<option value="unit">Unit(s)</option>
			<option value="percentage" selected>Percentage</option>
		</select>
		<label class="w-auto text-right px-2">Max Limit</label>
		<input type="text" name="reset_carry_limit" class="form-control w-90">
	</div>
</div>	

<div class="form-group input-group row">
	<div class="col-sm-12 sel-w-150 d-flex align-self-center">
	<div class="offset-1 pl-5">&nbsp</div>

	<label class="w-150 text-right px-2">Encashment</label>
		<input type="text" name="reset_encash_num" class="form-control w-90 mx-n01 rounded-0">

		<select name="encash_type" class="select">
			<option value="unit">Unit(s)</option>
			<option value="percentage" selected>Percentage</option>
		</select>
		<label class="w-auto text-right px-2">Max Limit</label>
		<input type="text" name="reset_encash_limit" class="form-control w-90">
	</div>
</div>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<script type="text/javascript">
	
	$(document).ready(function(){

		$('input[name=accrual]').change(function(){
			if($(this).is(':checked')) {
				$('.accrual-opt-wrap').fadeIn();
			}else{
				$('.accrual-opt-wrap').fadeOut();
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

</script>
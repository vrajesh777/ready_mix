<div class="check-info mb-4">
	<h5 class="my-2">Weekends Between Leave Period :</h5>
	<div class="form-check d-flex align-items-center ml-2">
		<input class="form-check-input" type="radio" name="include_weekends" id="include_weekends1" value="1">
		<label class="form-check-label d-flex align-items-center" for="include_weekends1">
		Count as leave: Count after
		<input class="form-control w-50 h-30 mx-1" name="inc_weekends_after" disabled>Day
		</label>
	</div>
	<div class="form-check d-flex align-items-center ml-2">
		<input class="form-check-input" type="radio" name="include_weekends" id="include_weekends2" value="0" checked="">
		<label class="form-check-label d-flex align-items-center" for="include_weekends2">
		Don't count as leave
		</label>
	</div>
</div>
<div class="check-info mb-4">
	<h5 class="my-2">Holidays Between Leave Period :</h5>
	<div class="form-check d-flex align-items-center ml-2">
		<input class="form-check-input" type="radio" name="inc_holidays" id="inc_holidays1" value="1">
		<label class="form-check-label d-flex align-items-center" for="inc_holidays1">
		Count as leave: Count after<input class="form-control w-50 h-30 mx-1" name="incholidays_after" disabled>Day
		</label>
	</div>
	<div class="form-check d-flex align-items-center ml-2">
		<input class="form-check-input" type="radio" name="inc_holidays" id="inc_holidays0" value="0" checked>
		<label class="form-check-label d-flex align-items-center" for="inc_holidays0">
		Don't count as leave
		</label>
	</div>
</div>
<div class="check-info mb-4">
	<h5 class="my-2">While Applying Leave, Exceed Leave Balance :</h5>
	<div class="form-check form-check-inline ml-2">
		<input class="form-check-input" type="radio" name="exceed_maxcount" id="exceed_maxcount1" value="1" checked>
		<label class="form-check-label d-flex align-items-center" for="exceed_maxcount1">
		Allow 
		</label>
	</div>
	<div class="form-check form-check-inline ml-2">
		<input class="form-check-input" type="radio" name="exceed_maxcount" id="exceed_maxcount0" value="0">
		<label class="form-check-label d-flex align-items-center" for="exceed_maxcount0">
		Don't Allow
		</label>
	</div>
	<div class="d-block mt-2 ml-3 exceed_maxcount-opt_wrap">
		<div class="form-check form-check-inline ml-2">
			<input class="form-check-input" type="radio" name="exceed_allow_opt" id="exceed_allow_opt1" value="1" checked="">
			<label class="form-check-label d-flex align-items-center" for="exceed_allow_opt1">
			Without limit  
			</label>
		</div>
		<div class="form-check form-check-inline ml-2">
			<input class="form-check-input" type="radio" name="exceed_allow_opt" id="exceed_allow_opt2" value="2">
			<label class="form-check-label d-flex align-items-center" for="exceed_allow_opt2">
			Until year end limit 
			</label>
		</div>
		<div class="form-check form-check-inline ml-2">
			<input class="form-check-input" type="radio" name="exceed_allow_opt" id="exceed_allow_opt3" value="3">
			<label class="form-check-label d-flex align-items-center" for="exceed_allow_opt3">
			Without limit and mark as LOP
			</label>
		</div>
  	</div>
</div>
<div class="check-info mb-4">
	<h5 class="my-2">Duration(s) Allowed :</h5>
	<div class="col-md-6 d-flex">
		<label class="container-checkbox font-size-14 pr-4">
			<input type="checkbox" name="duration_allowed[]" value="full_day" checked="" readonly="">
			<span class="checkmark"></span>
			Full Day
		</label>
		<label class="container-checkbox font-size-14 pr-4">
			<input type="checkbox" name="duration_allowed[]" value="half_day">
			<span class="checkmark"></span>
			Half Day
		</label>
		<label class="container-checkbox font-size-14 pr-4">
			<input type="checkbox" name="duration_allowed[]" value="quarter_day">
			<span class="checkmark"></span>
			Quarter Day
		</label>
		<label class="container-checkbox font-size-14 pr-4">
			<input type="checkbox" name="duration_allowed[]" value="hourly">
			<span class="checkmark"></span>
			Hourly
		</label>
	</div>
</div>
<div class="check-info mb-4">
	<h5 class="my-2">Report Configuration :</h5>
	<div class="form-group row">
		<label class="col-sm-2 text-right">Allow users to view</label>
		<div class="col-sm-3">
			<select name="report_display" class="select" data-rule-required="true">
				<option value="leave_taken_alone">Leave Taken Alone</option>
				<option value="simple_leave_summary">Simple Leave Summary</option>
				<option value="complete_leave_summary" selected="">Complete Leave Summary</option>
			</select>
			<label class="error" id="report_display_error"></label>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 text-right">Balance to be displayed </label>
		<div class="col-sm-3">
			<select name="balance_display" class="select" data-rule-required="true">
				<option value="start_date_of_leave_request" selected="">Start date of leave request</option>
				<option value="accrual_period_balance">Accrual Period Balance</option>
				<option value="current_date">Current Date</option>
			</select>
			<label class="error" id="balance_display_error"></label>
		</div>
	</div>
</div>
<div class="check-info mb-4">
	<h5 class="my-2">Allow Requests For :</h5>
	<div class="form-check">
		<label class="container-checkbox font-size-14 pr-4">
			<input type="checkbox" name="pastbooking_enable" checked="" value="1">
			<span class="checkmark"></span>
			Past dates
		</label>
	</div>
	<div class="container-checkbox font-size-14 pr-4 d-flex ml-5">
		<div class="pastbooking_enable-opt-wrapp">
			<input type="checkbox" name="pastbooking_limit_enable" id="pastbooking_limit_enable" value="1">
			<span class="checkmark"></span>
			<label class="form-check-label d-flex align-items-center" for="pastbooking_limit_enable">
			Past  <input name="pastbooking_limit" data-rule-digits="true" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled="" >Days
			</label>
		</div>
	</div>

	<div class="form-check">
		<label class="container-checkbox font-size-14 pr-4" for="futurebooking_enable">
			<input type="checkbox" name="futurebooking_enable" value="1" id="futurebooking_enable" checked="">
			<span class="checkmark"></span>
			Future dates
		</label>
	</div>
	<div class="futurebooking_enable-opt-wrapp">
		<div class="container-checkbox font-size-14 pr-4 d-flex ml-5">
			<input type="checkbox" name="futurebooking_limit_enable" value="1" id="futurebooking_limit_enable">
			<span class="checkmark"></span>
			<label class="form-check-label d-flex align-items-center" for="futurebooking_limit_enable">
			Next <input name="futurebooking_limit" data-rule-digits="true" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled>Days
			</label>
		</div>
		<div class="container-checkbox font-size-14 pr-4 d-flex ml-5">
			<input type="checkbox" name="futurebooking_notice_enable" value="1" id="futurebooking_notice_enable">
			<span class="checkmark"></span>
			<label class="form-check-label d-flex align-items-center" for="futurebooking_notice_enable">
			To be applied <input name="futurebooking_notice" data-rule-digits="true" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled>days in advance
			</label>
		</div>
	</div>

	<div class="container-checkbox font-size-14 pr-4 d-flex ml-3">
		<input type="checkbox" name="min_leave_enable" id="min_leave_enable" value="1">
		<span class="checkmark"></span>
		<label class="form-check-label d-flex align-items-center dpndt-chk-inp" for="min_leave_enable">
		Minimum leave that can be availed per application
		</label>
		<input type="text" name="min_leave" class="form-control w-50 h-30 mx-1 position-relative opacity-1" data-rule-digits="true" disabled>
	</div>
	<div class="container-checkbox font-size-14 pr-4 d-flex ml-3">
		<input type="checkbox" name="max_leave_enable" id="max_leave_enable">
		<span class="checkmark"></span>
		<label class="form-check-label d-flex align-items-center dpndt-chk-inp" for="max_leave_enable">
		Maximum leave that can be availed per application
		</label>
		<input type="text" name="max_leave" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled="">
	</div>
	<div class="container-checkbox font-size-14 pr-4 d-flex ml-3">
		<input type="checkbox" name="max_consecutive_enable" id="max_consecutive_enable" value="1">
		<span class="checkmark"></span>
		<label class="form-check-label d-flex align-items-center dpndt-chk-inp" for="max_consecutive_enable">
		Maximum number of consecutive days of Leave allowed
		</label>
		<input type="text" name="max_consecutive" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled="">
	</div>
	<div class="container-checkbox font-size-14 pr-4 d-flex ml-3">
		<input type="checkbox" name="min_gap_enable" id="min_gap_enable" value="1">
		<span class="checkmark"></span>
		<label class="form-check-label d-flex align-items-center dpndt-chk-inp" for="min_gap_enable">
		Minimum gap (in days) between two applications
		</label>
		<input type="text" name="min_gap" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled="">
	</div>
	<div class="container-checkbox font-size-14 pr-4 d-flex ml-3">
		<input type="checkbox" name="show_fileupload_after_enable" id="show_fileupload_after_enable" value="1">
		<span class="checkmark"></span>
		<label class="form-check-label d-flex align-items-center dpndt-chk-inp" for="show_fileupload_after_enable">
		Enable file upload option if the applied leave period exceeds 
		</label>
		<input type="text" name="show_fileupload_after" class="form-control w-50 h-30 mx-1 position-relative opacity-1" disabled="">
	</div>

	{{-- <div class="font-size-14 pr-4 d-flex ml-3">
		<label class="form-check-label d-flex align-items-center" for="after">
		Maximum number of applications allowed within the specified period
		</label>
		<input class="form-control w-50 h-30 mx-1 position-relative opacity-1 ml-3" name="frequency_count" maxlength="4"> / &nbsp;&nbsp;
		<div class="w-150 h-30">
			<select name="frequency_period" class="select">
				<option value="week" selected>Week</option>
				<option value="month">Month</option>
				<option value="year">Year</option>
				<option value="accrual_period">Accrual Period</option>
				<option value="job_tenure">Job Tenure</option>
			</select>
		</div>
	</div> --}}

	{{-- <div class="font-size-14 pr-4 d-flex ml-3 pt-3">
		<label class="form-check-label d-flex align-items-center" for="after">
		This leave can be applied only on 
		</label>
		<div class="w-150 h-30 ml-3">
			<select name="applydates[]" class="select" multiple="">
				<optgroup label="Holidays" name="holiday">
					<option value="restricted_holidays">Restricted Holidays</option>
				</optgroup>
				<optgroup label="Employee" name="employee">
					<option value="date_of_joining">Date of joining</option>
					<option value="birth_date">Birth Date</option>
					<option value="date_of_exit">Date of exit</option>
				</optgroup>
			</select>
		</div>
	</div> --}}

	<div class="font-size-14 pr-4 d-flex ml-3 pt-3">
		<label class="form-check-label d-flex align-items-center" for="after">
		This leave cannot be taken together with 
		</label>
		<div class="w-150 h-30 ml-3">
			<select name="blocked_clubs[]" class="select" multiple="">
				@if(isset($arr_leave_types) && !empty($arr_leave_types))
				@foreach($arr_leave_types as $leave)
				<option value="{{ $leave['id']??'' }}">{{ $leave['title']??'' }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>

</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('input[name=include_weekends]').change(function() {
			if($(this).val() == 1) {
				$('input[name=inc_weekends_after]').removeAttr('disabled');
			}else{
				$('input[name=inc_weekends_after]').attr('disabled',true);
			}
		});

		$('input[name=inc_holidays]').change(function() {
			if($(this).val() == 1) {
				$('input[name=incholidays_after]').removeAttr('disabled');
			}else{
				$('input[name=incholidays_after]').attr('disabled',true);
			}
		});

		$('input[name=exceed_maxcount]').change(function() {
			if($(this).val() == 1) {
				$('.exceed_maxcount-opt_wrap .form-check').fadeIn();
			}else{
				$('.exceed_maxcount-opt_wrap .form-check').fadeOut();
			}
		});

		$('input[name=pastbooking_enable]').change(function() {
			if($(this).is(':checked')) {
				$('.pastbooking_enable-opt-wrapp').fadeIn();
			}else{
				$('.pastbooking_enable-opt-wrapp').fadeOut();
			}
		});

		$('input[name=pastbooking_limit_enable]').change(function() {
			if($(this).is(':checked')) {
				$('input[name=pastbooking_limit]').removeAttr('disabled');
			}else{
				$('input[name=pastbooking_limit]').attr('disabled',true);
			}
		});


		$('input[name=futurebooking_enable]').change(function() {
			if($(this).is(':checked')) {
				$('.futurebooking_enable-opt-wrapp').fadeIn();
			}else{
				$('.futurebooking_enable-opt-wrapp').fadeOut();
			}
		});

		$('input[name=futurebooking_limit_enable]').change(function() {
			if($(this).is(':checked')) {
				$('input[name=futurebooking_limit]').removeAttr('disabled');
			}else{
				$('input[name=futurebooking_limit]').attr('disabled',true);
			}
		});

		$('input[name=futurebooking_notice_enable]').change(function() {
			if($(this).is(':checked')) {
				$('input[name=futurebooking_notice]').removeAttr('disabled');
			}else{
				$('input[name=futurebooking_notice]').attr('disabled',true);
			}
		});

		$('.dpndt-chk-inp').click(function(){
			var idSelector = $(this).attr('for');
			if($("#"+idSelector).is(':checked')) {
				$(this).next('input').attr('disabled',true);
			}else{
				$(this).next('input').removeAttr('disabled');
			}
		});

	});
</script>
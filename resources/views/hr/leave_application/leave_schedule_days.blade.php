<style type="text/css">
	#leave_schedule_parent { height: 150px; overflow: auto; border: 1px solid #e9e9e9; }
	.leave-type-foot {padding: 10px 12px;border-left: 1px solid #e9e9e9;border-right: 1px solid #e9e9e9;border-bottom: 1px solid #e9e9e9;background: #f5f6f7;}
</style>
<?php

$start = Carbon::createFromFormat('d/m/Y', $from_date);
$end = Carbon::createFromFormat('d/m/Y', $to_date);

$period = Carbon\CarbonPeriod::create($start->format('Y-m-d'), $end->format('Y-m-d'));

$restrictions = $arr_leave_type['restrictions']??[];

$duration_allowed = json_decode($restrictions['duration_allowed']??'');
$today = new Carbon();

$arr_dates = [];
if(isset($arr_holidays) && sizeof($arr_holidays)>0){
	foreach ($arr_holidays as $h_key => $h_value) {
		$h_start = \Carbon::createFromFormat('Y-m-d', $h_value['start']);
        $h_end = \Carbon::createFromFormat('Y-m-d', $h_value['end']);
  
        $dateRange = Carbon\CarbonPeriod::create($h_start, $h_end); 
        $dates = $dateRange->toArray();
        foreach ($dates as $d) {
        	$arr_dates[] = $d->format('Y-m-d');
        }
	}
}

?>
<div class="table-responsive" id="leave_schedule_parent">
<table class="table table-stripped mb-0">
	<tbody>
		@foreach ($period as $date)
		<tr>
			<td>{{ $date->format('D d M Y') }}</td>
			<td>
				@if(in_array($date->format('Y-m-d'), $arr_dates))
					<select name="leave_schd_dates[]" class="select">
						<option value="holiday">Holiday</option>
					</select>
				@elseif($date->dayOfWeek == \Carbon::SUNDAY)
					<select name="leave_schd_dates[]" class="select disabled" readonly="true" >
						<option value="week_off" selected="">{{ trans('admin.weekoff') }}</option>
					</select>
				@else
				<select name="leave_schd_dates[]" class="select">
					@if(isset($duration_allowed) && !empty($duration_allowed))
					@foreach($duration_allowed as $duration)
						<option value="{{$duration}}">{{ ucwords(str_replace('_',' ', $duration)) }}</option>
					@endforeach
					@endif
				</select>
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
<div class="leave-type-foot">
	<div class="row">
		<div class="col-sm-6">
			<a><b>{{ trans('admin.total') }}</b></a>
		</div>
		<div class="col-sm-6">
			<b class="ML10">{{ count($period) }} {{ trans('admin.days') }}</b>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select').select2();
		$(".select.disabled").select2("readonly",true);
	});
</script>
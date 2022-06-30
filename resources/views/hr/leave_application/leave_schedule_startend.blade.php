<style type="text/css">
	#leave_schedule_parent { height: 150px; overflow: auto; border: 1px solid #e9e9e9; }
	.leave-type-foot {padding: 10px 12px;border-left: 1px solid #e9e9e9;border-right: 1px solid #e9e9e9;border-bottom: 1px solid #e9e9e9;background: #f5f6f7;}
	.table td, .table th {padding: .40rem; vertical-align: middle;}
</style>
<?php

$start = Carbon::createFromFormat('d/m/Y', $from_date);
$end = Carbon::createFromFormat('d/m/Y', $to_date);

$period = Carbon\CarbonPeriod::create($start->format('Y-m-d'), $end->format('Y-m-d'));

$restrictions = $arr_leave_type['restrictions']??[];

$duration_allowed = json_decode($restrictions['duration_allowed']??'');
$today = new Carbon();

?>
<div class="table-responsive" id="leave_schedule_parent">
<table class="table table-stripped mb-0">
	<tbody>
		@foreach ($period as $index => $date)
		<tr>
			<td>{{ $date->format('D d M Y') }}</td>
			@if($date->dayOfWeek == \Carbon::SUNDAY)
				<td colspan="2">
					<select class="select" disabled="">
						<option value="0" selected="">{{ trans('admin.weekoff') }}</option>
					</select>
				</td>
				<td></td>
			@else
			<?php

				$arr_shift = $arr_shifts[$date->format('Y-m-d')]??[];
				$arr_shift_dtls = $arr_shift['shift_details']??[];
				$shft_date = $arr_shift['today']??'';

				$shft_frm = $shft_date.' '.$arr_shift_dtls['from']??'';
				$shft_to = $shft_date.' '.$arr_shift_dtls['to']??'';

				$start_time = Carbon::parse($shft_frm);
				$end_time = Carbon::parse($shft_to);
			?>
				<td>
					<input type="time" name="leave_schd_time[start][{{$index}}]" value="{{ $start_time->format('H:i') }}" class="leave_schd_time_input schd_time_start" data-index="{{$index}}">
				</td>

				<td>
					<input type="time" name="leave_schd_time[end][{{$index}}]" value="{{ $end_time->format('H:i') }}" class="leave_schd_time_input" data-index="{{$index}}">
				</td>
				<td class="time-diff-wrapp-{{$index}}">
					{{ $start_time->diff($end_time)->format('%H:%i') }} Hr(s)
				</td>
			@endif
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
			<b class="ML10 totHrs">{{ count($period) }} {{ trans('admin.days') }}</b>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.select').select2();

		calculate_tot_time();

		$('.leave_schd_time_input').change(function() {

			var index = $(this).data('index');
			var start_time = $('input[name="leave_schd_time[start]['+index+']"]').val();
			var end_time = $('input[name="leave_schd_time[end]['+index+']"]').val();

			var timeStart = new Date("01/01/2007 " + start_time).getTime();
			var timeEnd = new Date("01/01/2007 " + end_time).getTime();
			var hourDiff = timeEnd - timeStart;
			var secDiff = hourDiff / 1000; //in s
			var minDiff = hourDiff / 60 / 1000; //in minutes
			var hDiff = hourDiff / 3600 / 1000; //in hours
			var humanReadable = {};
			humanReadable.hours = Math.floor(hDiff);
			humanReadable.minutes = minDiff - 60 * humanReadable.hours;

			$(".time-diff-wrapp-"+index).html(humanReadable.hours+':'+humanReadable.minutes+' Hr(s)');

			calculate_tot_time();

		});

		function calculate_tot_time() {

			var totHrs = 0;

			$('.schd_time_start').each(function(){
				var index = $(this).data('index');
				var start_time = $('input[name="leave_schd_time[start]['+index+']"]').val();
				var end_time = $('input[name="leave_schd_time[end]['+index+']"]').val();

				var timeStart = new Date("01/01/2007 " + start_time).getTime();
				var timeEnd = new Date("01/01/2007 " + end_time).getTime();
				var hourDiff = timeEnd - timeStart;
				totHrs += hourDiff;
			});

			var hourDiff = totHrs;
			var secDiff = hourDiff / 1000; //in s
			var minDiff = hourDiff / 60 / 1000; //in minutes
			var hDiff = hourDiff / 3600 / 1000; //in hours
			var humanReadable = {};
			humanReadable.hours = Math.floor(hDiff);
			humanReadable.minutes = minDiff - 60 * humanReadable.hours;

			$('.totHrs').html(humanReadable.hours+':'+humanReadable.minutes+' Hr(s)');
		}
	});
</script>
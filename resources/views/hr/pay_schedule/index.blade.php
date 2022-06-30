@extends('layout.master')
@section('main_content')

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<h4>{{ trans('admin.og_pay_run_on_this') }} <a href="{{ Route('pay_schedule_edit','') }}"><i class="fa fa-edit"></i></a></h4>
				<h5>{{ trans('admin.pay_frequency') }} : {{ trans('admin.every_month') }} </h5>
				{{-- <h5>Working Days :  </h5> --}}
				<h5>{{ trans('admin.pay_day') }} : {{ trans('admin.last_day_every_month') }} </h5>
				<h5>{{ trans('admin.first_pay_period') }} : {{ isset($arr_data['first_pay_date'])?date('M/Y',strtotime($arr_data['first_pay_date'])):'' }}</h5>
				<h5>{{ trans('admin.first_pay_date') }}: {{ isset($arr_data['first_pay_date'])?date('d/m/Y',strtotime($arr_data['first_pay_date'])):'' }}</h5>
				@if(isset($arr_data['days_per_month']) && $arr_data['days_per_month']!='0')
					<h5>{{ trans('admin.no_working_days') }} : {{ $arr_data['days_per_month'] ?? 0 }}</h5>
				@endif

				<h4 style="color:red;">{{ trans('admin.note') }}:{{ trans('admin.note_pay_schedule') }}</h4>
			</div>
		</div>
	</div>
</div>

@if(isset($arr_data['first_pay_date']) && $arr_data['first_pay_date']!='')
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<h4>{{ trans('admin.upcoming_payrolls') }}</h4>
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0">
						<thead>
							<tr>
								<td>{{ trans('admin.pay_period') }}</td>
								<td>{{ trans('admin.pay_date') }}</td>
							</tr>
						</thead>
						@php
						    $begin = new DateTime($arr_data['first_pay_date'] ?? '');
						    $period = new DatePeriod(
						        $begin,
						        new DateInterval('P1M'),
						        (int) 5 //added cast to be sure, in case this data comes from DB
						    );
						    $clean = array();//<-- return this
						    $last = (int) $begin->format('m');
						    foreach ($period as $date)
						    {
						        while($last != $date->format('m'))
						            $date->modify('-1 day');//subtract days until we get to the last day of the previous month...
						        $clean[] = $date;
						        if (++$last > 12)
						            $last = 1;//no 13th month, of course...
						    }
						@endphp
						<tbody>
							@foreach($clean as $cl)
								@php
									$date = $cl->format('d/m/Y');
									$month = $cl->format('m');
									$year = $cl->format('Y');

									$payable_days = 0;
									if(isset($arr_data['salary_on']) && $arr_data['salary_on']!='' && $arr_data['salary_on'] == 0){
										$payable_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
									}elseif(isset($arr_data['salary_on']) && $arr_data['salary_on']!='' && $arr_data['salary_on'] == 1){
										$payable_days = $arr_data['days_per_month'] ?? 0;
									}

									$new_date = $payable_days.'/'.$cl->format('m/Y');
								@endphp
								<tr>
									<td>{{ $cl->format('M/Y') }}</td>
									<td>{{ $new_date ?? '' }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
<!-- /Content End -->
@stop
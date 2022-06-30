@extends('layout.master')
@section('main_content')

<link href='{{ asset('/css') }}/fullcalendar.css' rel='stylesheet' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
<script src='{{ asset('/js') }}/moment.min.js'></script>
<script src='{{ asset('/js') }}/fullcalendar.min.js'></script>

<style type="text/css">
	tr:first-child > td > .fc-day-grid-event {
		margin: 10x;
		padding: 5px;
	}
</style>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <select name="user_id" class="select" id="user_id">
		            	<option value="">{{trans('admin.select')}} {{trans('admin.employee')}}</option>
		            	@if(isset($arr_emp) && sizeof($arr_emp)>0)
							@foreach($arr_emp as $emp)
							<option  value="{{$emp['id']??''}}" {{ ($emp['id']??'')==($auth_user_id??'')?'selected':'' }}>{{ $emp['first_name']??'' }} {{ $emp['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div id='calendar'></div>
			</div>
		</div>
	</div>
</div>
<!-- /Content End -->
<script>
	var current_date = '{{ date('Y-m-d') }}';

	var calEvents = [];

	var $calendar = $('#calendar');

	$(document).ready(function() {

		$calendar.fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek' //agendaDay
			},
			lang: 'en',
			showNonCurrentDates:false,
			defaultDate: current_date,
			navLinks: false, // can click day/week names to navigate views
			editable: false,
			eventLimit: false, // allow "more" link when too many events
			events: function(start, end, timezone, callback) {
				callback(calEvents);
				update_calendar();
		    }
		});

		$(".fc-other-month .fc-day-number").hide();

		$("#user_id").change(function() {
			if($(this).val() != '') {
				update_calendar();
			}

		});
	});


	function update_calendar() {

		var active_user = $('#user_id').find(":selected").val();

		$.ajax({
            url: '{{ Route('get_cal_data') }}',
            dataType: 'json',
            data: {
            	user_id : active_user,
                start: $('#calendar').fullCalendar("getView").intervalStart.format(),
                end: $('#calendar').fullCalendar("getView").intervalEnd.format()
            },
            success: function(resp) {

            	if(resp.status == 'success') {

            		calEvents = [];

            		if(resp.data.length > 0) {
	            		$.each(resp.data, function(index,row) {
		                    calEvents.push({
		                        title: row.title,
		                        start: row.start,
		                        end: row.end,
		                        color: row.color,
        						textColor: row.textColor 
		                    });
		                });
            		}
            		$calendar.fullCalendar('removeEvents'); 
        			$calendar.fullCalendar('addEventSource', calEvents);
            	}
            }
        });
	}

</script>
@stop
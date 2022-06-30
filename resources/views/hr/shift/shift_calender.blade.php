@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_shift" onclick="form_reset()" >{{ trans('admin.new') }} {{ trans('admin.shift') }}</button>
                </li>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->

<div class="card mb-0">
	<div class="card-body">
		<div class="table-responsive">
			<div class="mb-2" id="sked1"></div>
		</div>
	</div>
</div>

<!-- /Content End -->

<link rel="stylesheet" href="{{ asset('/css/skedTape/jquery.skedTape.css') }}">
<script src="{{ asset('/js/skedTape/jquery.skedTape.js') }}"></script>

<script type="text/javascript">

	var locations = [
		@if(isset($arr_users) && !empty($arr_users))
		@foreach($arr_users as $user)
        {id: '{{ $user['id']??'' }}', name: '{{ $user['first_name']??'' }} {{$user['last_name']??''}}'},
		@endforeach
		@endif
    ];
    var events = [
        {
            name: 'Meeting 1',
            location: '38',
            start: today(4, 15),
            end: today(7, 30)
        },
        {
            name: 'Meeting 2 (ovelapping)',
            location: '38',
            start: today(6, 30),
            end: today(9, 15)
        },
        {
            name: 'Meeting 3 (ovelapping)',
            location: '38',
            start: today(9, 0),
            end: today(11, 30)
        },
        {
            name: 'Meeting 4 (ovelapping)',
            location: '38',
            start: today(7, 45),
            end: today(8, 30)
        },
        {
            name: 'Meeting 5 (ovelapping)',
            location: '38',
            start: today(8, 0),
            end: today(8, 15)
        },
        {
            name: 'Meeting',
            location: '19',
            start: today(0, 0),
            end: today(1, 30)
        },
        {
            name: 'Meeting',
            location: '16',
            start: today(0, 0),
            end: today(1, 30)
        },
        {
            name: 'Meeting',
            location: '19',
            start: today(10, 0),
            end: today(11, 30)
        },
        {
            name: 'Meeting with custom class',
            location: '15',
            start: yesterday(22, 0),
            end: today(1, 30),
            class: 'custom-class'
        },
        {
            name: 'Meeting just after the previous one',
            location: '15',
            start: today(1, 45),
            end: today(2, 45),
            class: 'custom-class'
        },
        {
            name: 'And another one...',
            location: '15',
            start: today(3, 10),
            end: today(5, 30),
            class: 'custom-class'
        },
        {
            name: 'Disabled meeting',
            location: '13',
            start: yesterday(22, 15),
            end: yesterday(23, 30),
            disabled: true
        },
        {
            name: 'Meeting',
            location: '13',
            start: yesterday(23, 45),
            end: today(1, 30)
        },
        {
            name: 'Meeting that started early',
            location: '12',
            start: yesterday(21, 45),
            end: today(0, 45)
        },
        {
            name: 'Late meeting',
            location: '16',
            start: today(11, 15),
            end: today(13, 45)
        },
    ];

    // -------------------------- Helpers ------------------------------
    function today(hours, minutes) {
        var date = new Date();
        date.setHours(hours, minutes, 0, 0);
        return date;
    }
    function yesterday(hours, minutes) {
        var date = today(hours, minutes);
        date.setTime(date.getTime() - 24 * 60 * 60 * 1000);
        return date;
    }
    function tomorrow(hours, minutes) {
        var date = today(hours, minutes);
        date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
        return date;
    }

	$(document).ready(function() {
		var $sked1 = $('#sked1').skedTape({
	        caption: 'Employee',
	        start: yesterday(22, 0),
	        end: today(12, 0),
	        showEventTime: true,
	        showEventDuration: true,
	        scrollWithYWheel: true,
	        locations: locations.slice(),
	        events: events.slice(),
	        maxTimeGapHi: 60 * 1000, // 1 minute
	        minGapTimeBetween: 1 * 60 * 1000,
	        snapToMins: 1,
	        editMode: true,
	        timeIndicatorSerifs: true,
	        showIntermission: true,
	        formatters: {
	            date: function (date) {
	                return $.fn.skedTape.format.date(date, 'l', '.');
	            },
	            duration: function (ms, opts) {
	                return $.fn.skedTape.format.duration(ms, {
	                    hrs: 'Hrs.',
	                    min: 'Min.'
	                });
	            },
	        },
	        canAddIntoLocation: function(location, event) {
	            return location.id !== '38';
	        },
	        postRenderLocation: function($el, location, canAdd) {
	            this.constructor.prototype.postRenderLocation($el, location, canAdd);
	            $el.prepend('<i class="fas fa-user text-muted"/>&nbsp;');
	        }
	    });

		$sked1.on('event:dragEnded.skedtape', function(e) {
            console.log(e.detail.event);
        });
        $sked1.on('event:click.skedtape', function(e) {
            $sked1.skedTape('removeEvent', e.detail.event.id);
        });
        $sked1.on('timeline:click.skedtape', function(e, api) {
            try {
                $sked1.skedTape('startAdding', {
                    name: 'New meeting',
                    duration: 60 * 60 * 1000
                });
            }
            catch (e) {
                if (e.name !== 'SkedTape.CollisionError') throw e;
                //alert('Already exists');
            }
        });

	});

</script>

@stop
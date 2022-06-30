@extends('layout.master')
@section('main_content')

<link rel="stylesheet" href="{{ asset('/css/week-calendar.css') }}">
<!-- Page Header -->

 <div class="page-header mb-0 ">
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
<?php
$sdt = \Carbon::parse($week_start)->format('d/m/Y');
$edt = \Carbon::parse($week_end)->format('d/m/Y');
?>

<div class="week-calendar card mb-0">
	<div class="card-body">
		<div class="day-change d-flex justify-content-between align-items-center pb-3">
			<h4 class="card-title mt-0 mb-0">{{ trans('admin.calendar') }} {{ trans('admin.view') }}</h4>
			<ul class="pagination m-0">
				<form action="" id="rangeCalenderForm">
				<li class="page-item">
					<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
				</li>
				</form>
				{{-- <li class="page-item">
					<a class="page-link" href="#" tabindex="-1"><i class="fal fa-chevron-left"></i></a>
				</li>
				<li class="page-item">
					<a class="page-link" href="#">28-Feb-2021  -  06-Mar-2021</a>
				</li>
				<li class="page-item">
					<a class="page-link" href="#"><i class="fal fa-chevron-right"></i></a>
				</li> --}}
			</ul>

			<ul class="pagination m-0">
				{{-- <li class="page-item"><a class="page-link" href="#">Week</a></li>
				<li class="page-item"><a class="page-link" href="#">Day</a></li> --}}
				<li class="page-item"><a class="page-link" href="javascript:void(0)" data-toggle="modal" data-target="#add_shift" onclick="form_reset()">{{ trans('admin.assign_shift') }}</a></li>
				<li class="page-item"><a class="page-link" href="#"><i class="fal fa-filter"></i></a></li>
				<li class="page-item">
					<div class="btn-group page-link">
						<a href="javascript:void(0)" data-toggle="dropdown" class="action">
							<i class="fas fa-ellipsis-h"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="commodity-list-view.html" class="dropdown-item">{{ trans('admin.view') }}</a>
							<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">{{ trans('admin.edit') }}</button>
							<button class="dropdown-item" type="button">{{ trans('admin.delete') }}</button>
						</div>
					</div>
				</li>
			</ul>
		</div>
		<div class="table-responsive">
			<table class="table table-stripped mb-0">
				<thead>
					<tr>
						<th class="emp-title">{{ trans('admin.employee') }}</th>
						<?php
							$i=0;

							$begin = new DateTime($week_start);
							$end = new DateTime(date('Y-m-d', strtotime("+1 day", strtotime($week_end))));

							$interval = DateInterval::createFromDateString('1 day');
							$period = new DatePeriod($begin, $interval, $end);
						?>
						@foreach ($period as $key => $dt)
						<th>
							<span class="day">{{ $dt->format("d")??'' }}</span>
							<span class="long">{{ $dt->format("l")??'' }}</span>
							<span class="short">Mon</span>
						</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($arr_users as $user)
					@if(isset($user['shift']) && !empty($user['shift']))
					<tr>
						<td class="hour">
							<span><p>{{ $user['emp_id']??'' }}</p>{{ $user['first_name']??'' }} {{ $user['last_name']??'' }}</span>
						</td>
						@foreach($user['shift'] as $shift)
						<?php
							$shift_dtls = $shift['shift_details']??[];
							$col_code = $shift_dtls['color_code']??'';
						?>
						<td class="general-info">
							<p>
								<a href="javascript:void(0);" 
								style="color: {{ $col_code??'' }}" 
								class="shit-item-act" 
								data-user-id="{{ $user['id']??'' }}" 
								data-chng-date="{{ $shift['today']??'' }}" 
								data-target="#change_shift">{{ $shift_dtls['name']??'' }}</a>
							</p>
							<p>({{ date('H:i A', strtotime($shift_dtls['from']??'')) }} - {{ date('H:i A', strtotime($shift_dtls['to']??'')) }})</p>
						</td>
						@endforeach
					</tr>
					@endif
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- /Content End -->

<!-- Modal -->
<div class="modal fade right" id="add_shift" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.shift') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('store_emp_shift') }}" id="createShiftForm">
			            	{{ csrf_field() }}

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.applicable') }} {{ trans('admin.for') }} <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<select name="users[]" class="select2" id="users" multiple="" data-rule-required="true">
										<option value="">{{ trans('admin.all') }}</option>
										@if(isset($arr_users) && !empty($arr_users))
										@foreach($arr_users as $user)
										<option value="{{$user['id']??''}}">{{ $user['first_name']??'' }} {{$user['last_name']??''}}</option>
										@endforeach
										@endif
									</select>
									<label class="error" id="users_error"></label>
			        			</div>
			        		</div>
			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.shift_name') }} <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<select name="shift" class="select2" data-rule-required="true">
										<option value="">-- {{ trans('admin.select') }} --</option>
										@if(isset($arr_shifts) && !empty($arr_shifts))
										@foreach($arr_shifts as $shift)
										<option value="{{$shift['id']??''}}">{{ $shift['name']??'' }}</option>
										@endforeach
										@endif
									</select>
									<label class="error" id="shift_error"></label>
			        			</div>
			        		</div>
			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.date') }} <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input type="text" name="from_date" class="form-control" placeholder="From" value="" data-rule-required="true" data-date-format="dd-mm-yyyy" id="from_date" >
									<div class="input-group-append date-icon"><i class="fal fa-calendar"></i></div>
		                            <label class="error" id="from_date_error"></label>
								</div>
								<div class="col-sm-4">
									<input type="text" name="to_date" class="form-control" placeholder="To" value="" data-rule-required="true" data-date-format="dd-mm-yyyy" id="to_date">
									<div class="input-group-append date-icon"><i class="fal fa-calendar"></i></div>
		                            <label class="error" id="to_date_error"></label>
								</div>
							</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div>

			            </form>
			        </div>
			        <div class="col-md-12" id="conflictWrapper">
			        </div>
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<!-- Modal -->
<div class="modal fade" id="change_shift" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('update_emp_shift') }}" id="updateShiftForm">
			            	{{ csrf_field() }}

			            	<input type="hidden" name="user_id" id="updt-user-id">
			            	<input type="hidden" name="chng-date" id="updt-date">

			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.shift_name') }} <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<select name="shift" class="select2" data-rule-required="true">
										<option value="">-- {{ trans('admin.select') }} --</option>
										@if(isset($arr_shifts) && !empty($arr_shifts))
										@foreach($arr_shifts as $shift)
										<option value="{{$shift['id']??''}}">{{ $shift['name']??'' }}</option>
										@endforeach
										@endif
									</select>
									<label class="error" id="shift_error"></label>
			        			</div>
			        		</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.change') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div>

			            </form>
			        </div>
			        <div class="col-md-12" id="conflictWrapper">
			        </div>
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script type="text/javascript">

	var createUrl = "{{ Route('store_shift') }}";
	var updateUrl = "{{ Route('update_shift','') }}";

	$(document).ready(function() {

		$('.select2').select2();

		$('#from_date').datepicker({
			autoclose: true,
			startDate: "dateToday", // to disable past dates (skip if not needed)
		}).on('changeDate', function(e) {
			$('#to_date').data('datepicker').setStartDate(e.format());
		});

		$('#to_date').datepicker({
			autoclose: true,
			startDate: "dateToday"
		});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sdt??''}}',
		    endDate: '{{$edt??''}}'
		})
		.on('changeDate', function(e) {
			$("#rangeCalenderForm").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$('.shit-item-act').click(function() {
			var userId = $(this).data('user-id');
			var chngDate = $(this).data('chng-date');
			$('#updt-user-id').val(userId);
			$('#updt-date').val(chngDate);
			$('#change_shift').modal('show');
		});

        initValidate();

        $('input[name=margin_before]').on('dp.change',function(e){
        	var formatedValue = e.date.format('h:m A');
        	$('.margin-before-instr').html(formatedValue);
        });

        $('input[name=margin_after]').on('dp.change',function(e){
        	var formatedValue = e.date.format('h:m A');
        	$('.margin-after-instr').html(formatedValue);
        });

        $('input[name=shift_margin]').on('change', function(){
        	if($(this).val() == '1') {
        		$('.time-margin-div').fadeIn();
        	}else if($(this).val() == '0'){
        		$('.time-margin-div').fadeOut();
        	}
        });

		$("#createShiftForm").submit(function(e) {

			e.preventDefault();

			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					if(response.status == 'success') {
      						$("#conflictWrapper").html("");
	      					common_ajax_store_action(response);
      					}else{
      						$("#conflictWrapper").html(response.conflict_html);
      					}
      				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$("#updateShiftForm").submit(function(e) {

			e.preventDefault();

			if($(this).valid()) {

				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
	      				common_ajax_store_action(response);
      				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		var table = $('#shiftsTable').DataTable({
			   // "pageLength": 2
			buttons: [{
				extend: 'pdf',
				title: '{{ Config::get('app.project.title') }} Shifts',
				filename: '{{ Config::get('app.project.title') }} Shifts PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Shifts',
				filename: '{{ Config::get('app.project.title') }} Shifts EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Shifts CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		$('.action-edit').click(function() {

			var enc_id = $(this).data('id');

			$.ajax({
				url: "{{ Route('edit_shift') }}",
  				type:'GET',
  				data : {
  					'enc_id' : enc_id
  				},
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					hideProcessingOverlay();
  					if(response.status == 'success') {
  						$('#createShiftForm').attr('action', updateUrl+'/'+enc_id);
  						$('input[name=action]').val('update');
  						$("#add_shift").modal('show');
				        if(typeof response.data != 'undefined') {
				            $.each(response.data, function (key, val) {
				            	if(key == 'shift_margin') {
				            		if(val == '1') {
				            			$('input[name=shift_margin][value=1]').attr('checked', true);
				            			$('input[name=shift_margin][value=1]').trigger('change');
				            		}else{
				            			$('input[name=shift_margin][value=0]').attr('checked', true);
				            			$('input[name=shift_margin][value=0]').trigger('change');
				            		}
				            	}else{
				                	$("input[name="+ key +"]").val(val);
				            	}
				            });
				        }
				    }
				    displayNotification(response.status, response.message, 5000);
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});

		});

		$('.closeForm').click(function(){
			$("#add_shift").modal('hide');
			form_reset();
		});

		$('#updateShiftForm').validate({
			// ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

	});

	function initValidate() {
		$('#createShiftForm').validate({
			// ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});
	}

	function form_reset() {
		$("#createShiftForm")[0].reset();
		// document.getElementById('createShiftForm').reset();
	}
</script>

@stop
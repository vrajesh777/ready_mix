@extends('layout.master')
@section('main_content')

<style type="text/css">
	.right .modal-dialog { max-width: 1200px; }
	.modal.left .modal-dialog, .modal.right .modal-dialog {width: 1200px;}
</style>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_leave_type" onclick="form_reset()" >{{ trans('admin.apply') }} {{ trans('admin.leave') }}</button>
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
			<table class="table table-striped table-nowrap custom-table mb-0" id="shiftsTable">
				<thead>
					<tr>
						<th>{{ trans('admin.employee') }}</th>
						<th>{{ trans('admin.leave_type') }}</th>
						<th>{{ trans('admin.pay_type') }}</th>
						<th>{{ trans('admin.leave_period') }}</th>
						<th>{{ trans('admin.days_hours_taken') }}</th>
						<th>{{ trans('admin.date_of_request') }}</th>
						<th class="text-center notexport">{{ trans('admin.actions') }}</th>
					</tr>
				</thead>
				<tbody>
					@if(isset($arr_leave_apps) && !empty($arr_leave_apps))
					@foreach($arr_leave_apps as $key => $applcn)

					<?php
						$employee = $applcn['employee']??[];
						$leave_days = $applcn['leave_days']??[];
						$leave_type_details = $applcn['leave_type_details']??[];

						$taken_period = '';

						if($leave_type_details['unit'] == 'days') {
							$taken_period = count($leave_days).' Day(s)';
						}elseif($leave_type_details['unit'] == 'hours'){
							$arr_time = [];
							foreach($leave_days as $row) {
								$datetime1 = new DateTime($row['from_time']);
								$datetime2 = new DateTime($row['to_time']);
								$interval = $datetime1->diff($datetime2);
								$arr_time[] = $interval->format('%h:%i');
							}
							$taken_period = sum_time($arr_time).' Hr(s)';
						}
					?>

					<tr>
						<td>{{ $employee['first_name']??'' }} {{ $employee['last_name']??'' }}</td>
						<td>
							<a href="javascript:void(0)" class="action-edit" data-id="{{ base64_encode($applcn['id']) }}" >{{ $leave_type_details['title'] ?? 'N/A' }}</a>
						</td>
						<td>{{ ucfirst($leave_type_details['type']??'') }}</td>
						<td>
							{{ date('d-M-Y', strtotime($leave_days[0]['date']??'')) }} - 
							{{ date('d-M-Y', strtotime(end($leave_days)['date']??'')) }}
						</td>
						<td>{{ $taken_period??'' }}</td>
						<td>{{ date('d-M-Y', strtotime($applcn['created_at']??'')) }}</td>
                        <td class="text-center">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item action-edit" data-id="{{ base64_encode($applcn['id']) }}" href="javascript:void(0);">{{ trans('admin.edit') }} {{ trans('admin.type') }}</a>
								</div>
							</div>
						</td>
					</tr>

					@endforeach

					@else

					<h3 align="center">{{ trans('admin.no_record_found') }}</h3>

					@endif
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- /Content End -->

<!-- Modal -->
<div class="modal fade right" id="add_leave_type" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.apply') }} {{ trans('admin.leave') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('store_application') }}" id="leaveApplicForm">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.employee') }} <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<select name="employee" class="select" data-rule-required="true" id="employee">
										<option value="">-- {{ trans('admin.select') }} --</option>
										@if(isset($arr_employees) && !empty($arr_employees))
										@foreach($arr_employees as $empl)
										<option value="{{ $empl['id']??'' }}">{{ $empl['first_name']??'' }} {{ $empl['last_name']??'' }}</option>
										@endforeach
										@endif
									</select>
									<label id="leave_type-error" class="error" for="leave_type"></label>
			        			</div>
			        		</div>

			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.leave_type') }}<span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<select name="leave_type" id="leave_type" class="select" data-rule-required="true">
										<option value="">-- {{ trans('admin.select') }} --</option>
										{{-- @if(isset($arr_leave_types) && !empty($arr_leave_types))
										@foreach($arr_leave_types as $leave)
										<option value="{{ $leave['id']??'' }}" data-unit="{{ $leave['unit']??'' }}">{{ $leave['title']??'' }}</option>
										@endforeach
										@endif --}}
									</select>
									<label class="error" id="leave_type_error"></label>
			        			</div>
			        		</div>

			        		<div class="form-group row applied_with-wrap" style="display: none;">
								<label class="col-md-3 text-right">{{ trans('admin.apply') }} {{ trans('admin.with') }} <span class="text-danger">*</span></label>
								<div class="col-md-6">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="applied_with" id="applied_hrs" value="hours" data-rule-required="true" checked>
										<label class="form-check-label" for="applied_hrs">{{ trans('admin.start_time') }} {{ trans('admin.and') }} {{ trans('admin.total_hours') }}</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="applied_with" id="applied_startend" value="startend" data-rule-required="true" >
										<label class="form-check-label" for="applied_startend">{{ trans('admin.start_time') }} {{ trans('admin.and') }} {{ trans('admin.end_time') }}</label>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-3"></div>
								<div class="col-md-6" id="leave_schedule_wrapp">
								</div>
							</div>

			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.date') }} <span class="text-danger">*</span></label>
								<div class="col-sm-3">
									<input type="text" name="from_date" class="form-control datepicker" placeholder="dd/mm/yyyy" data-rule-required="true" data-date-format="dd/mm/yyyy" >
									<div class="input-group-append date-icon"><i class="fal fa-calendar"></i></div>
		                            <label class="error" id="from_date_error"></label>
								</div>
								<div class="col-sm-3">
									<input type="text" name="to_date" class="form-control datepicker" placeholder="dd/mm/yyyy" data-rule-required="true" data-date-format="dd/mm/yyyy" >
									<div class="input-group-append date-icon"><i class="fal fa-calendar"></i></div>
		                            <label class="error" id="to_date_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.reason_for_leave')}}</label>
								<div class="col-sm-6">
									<textarea name="reason" class="form-control"></textarea>
									<label class="error" id="reason_error"></label>
			        			</div>
			        		</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save')}}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel')}}</button>
			                </div>

			            </form>
			        </div>
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js"></script>

<script type="text/javascript">

	var createUrl = "{{ Route('store_application') }}";
	var updateUrl = "{{ Route('update_leave_type','') }}";

	$(document).ready(function() {

		$('.select2').select2();

		$('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            //startDate: "dateToday",
            autoclose: true,
        }).on('changeDate', function(){
        	get_schedule_form_table();
        });

        initValidate();

        $('select[name="employee"]').change(function() {
        	get_schedule_form_table();
        });
        $('select[name="leave_type"]').change(function() {
        	// $('select[name=leave_type] option:selected').val();
        	var unit = $('select[name="leave_type"] option:selected').data('unit');
        	if(unit == 'hours') {
        		$('.applied_with-wrap').fadeIn();
        	}else{
        		$('.applied_with-wrap').fadeOut();
        	}
        	get_schedule_form_table();
        });

        $('input[name="applied_with"]').change(function() {
        	get_schedule_form_table();
        });

		$("#leaveApplicForm").submit(function(e) {

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
				url: "{{ Route('edit_leave_type','') }}/"+enc_id,
  				type:'POST',
  				data : {
  					'_token' : "{{ csrf_token() }}"
  				},
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					hideProcessingOverlay();
  					if(response.status == 'success') {
  						$('#leaveApplicForm').attr('action', updateUrl+'/'+enc_id);
  						$('input[name=action]').val('update');
  						$("#add_leave_type").modal('show');
				        if(typeof response.data != 'undefined') {
				        	fill_edit_form(response.data);
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
			$("#add_leave_type").modal('hide');
			form_reset();
		});

	});

	$('#employee').change(function(){
		var emp_id = $(this).val();
		if(emp_id!=''){
			$.ajax({
				url:"{{ Route('get_emp_leave_type','') }}/"+btoa(emp_id),
				type:"GET",
				dataType:'JSON',
				success:function(response){
					if(response.status == 'SUCCESS'){
						if(typeof response.arr_leave_type != 'undefined'){
							var option = '<option value="">Select Type</option>'; 
							$(response.arr_leave_type).each(function(index,type){
								var select = '';
								/*if(selectId == year.year) {
									select = 'selected';
								}*/
								option+='<option value="'+type.leave_types_id+'" '+select+' >'+type.leave_type.title+'</option>';
							})

							$('select[name="leave_type"]').html(option);
						}
					}
					else{

					}
				}
			})
		}
	});

	function initValidate() {
		$('#leaveApplicForm').validate({
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
		// $("#leaveApplicForm")[0].reset();
		// document.getElementById('leaveApplicForm').reset();
	}

	function get_schedule_form_table() {

		var employee = $('select[name=employee] option:selected').val();
		var leave_type = $('select[name=leave_type] option:selected').val();
		var from_date = $('input[name=from_date]').val();
		var to_date = $('input[name=to_date]').val();

		if(employee!='' && leave_type!='' && from_date!='' && to_date!='') {

			$.ajax({
				url: "{{ Route('get_leave_schedule_form') }}",
  				type:'POST',
  				data : $('#leaveApplicForm').serialize(),
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					hideProcessingOverlay();
  					if(response.status == 'success') {
  						$("#leave_schedule_wrapp").html(response.html);
  					}
  					// common_ajax_store_action(response);
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		}


	}

</script>

@stop
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
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_leave_type" onclick="form_reset()" ><i class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
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
						<th>{{ trans('admin.sr_no') }}</th>
						<th>{{ trans('admin.leave_type') }}</th>
						<th>{{ trans('admin.pay_type') }}</th>
						<th>{{ trans('admin.unit') }}</th>
						<th class="text-center notexport">{{ trans('admin.actions') }}</th>
					</tr>
				</thead>
				<tbody>

					@if(isset($arr_leave_types) && !empty($arr_leave_types))

					@foreach($arr_leave_types as $key => $leave_type)

					<tr>
						<td>{{ ++$key }}</td>
						<td>
							<a href="javascript:void(0)" class="action-edit" data-id="{{ base64_encode($leave_type['id']) }}" >{{ $leave_type['title'] ?? 'N/A' }}</a>
						</td>
						<td>{{ ucfirst($leave_type['type']??'') }}</td>
						<td>{{ ucfirst($leave_type['unit']??'') }}</td>
                        <td class="text-center">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item action-edit" data-id="{{ base64_encode($leave_type['id']) }}" href="javascript:void(0);">{{ trans('admin.edit') }} Type</a>
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
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.leave') }} {{ trans('admin.type') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('store_leave_type') }}" id="createLeaveTypeForm">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.name') }} <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input class="form-control" name="title" placeholder="{{ trans('admin.name') }}" data-rule-required="true">
									<label class="error" id="name_error"></label>
			        			</div>
			        		</div>

			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.code') }}</label>
								<div class="col-sm-6">
									<input class="form-control" name="code" placeholder="{{ trans('admin.code') }}">
									<label class="error" id="code_error"></label>
			        			</div>
			        		</div>

			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.type') }} <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<select name="type" class="select" data-rule-required="true">
										<option value="paid">{{ trans('admin.paid') }}</option>
										<option value="unpaid">{{ trans('admin.unpaid') }}</option>
										{{-- <option value="on_duty">{{ trans('admin.on_duty') }}</option>
										<option value="restricted_holidays">{{ trans('admin.restricted_holidays') }}</option> --}}
									</select>
									<label class="error" id="code_error"></label>
			        			</div>
			        		</div>

			        		<div class="form-group row">
								<label class="col-md-3 text-right">{{ trans('admin.unit') }} <span class="text-danger">*</span></label>
								<div class="col-md-6">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="leaveunit" id="unit_days" value="days" data-rule-required="true" checked>
										<label class="form-check-label" for="unit_days">{{ trans('admin.days') }}</label>
									</div>
									{{-- <div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="leaveunit" id="unit_hours" value="hours" data-rule-required="true" >
										<label class="form-check-label" for="unit_hours">{{ trans('admin.hours') }}</label>
									</div> --}}
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.description') }} </label>
								<div class="col-sm-6">
									<textarea name="description" class="form-control"></textarea>
									<label class="error" id="description_error"></label>
			        			</div>
			        		</div>

			        		{{-- <div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.validity') }} </label>
								<div class="col-sm-3">
									<input type="text" name="start" class="form-control datepicker" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" >
									<div class="input-group-append date-icon"><i class="fal fa-calendar"></i></div>
		                            <label class="error" id="start_error"></label>
								</div>
								<div class="col-sm-3">
									<input type="text" name="end" class="form-control datepicker" placeholder="dd/mm/yyyy" data-date-format="dd/mm/yyyy" >
									<div class="input-group-append date-icon"><i class="fal fa-calendar"></i></div>
		                            <label class="error" id="end_error"></label>
								</div>
							</div> --}}

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.days') }}</label>
								<div class="col-sm-2">
									<input type="number" name="paid_days" class="form-control" value="0" >
		                            <label class="error" id="paid_days_error"></label>
								</div>
								{{-- <label class="col-sm-2 text-right">{{ trans('admin.unpaid') }} {{ trans('admin.days') }} </label>
								<div class="col-sm-2">
									<input type="number" name="unpaid_days" class="form-control" value="0" >
		                            <label class="error" id="unpaid_days_error"></label>
								</div> --}}
							</div>

			                <ul class="nav nav-tabs">
			                	<li class="nav-item active">
			                		<a class="nav-link active" data-toggle="tab" aria-current="page" href="#entitlement">{{ trans('admin.entitlement') }}</a>
			                	</li>
			                	<li class="nav-item">
			                		<a class="nav-link" data-toggle="tab" href="#applicable">{{ trans('admin.applicable') }}</a>
			                	</li>
			                	<li class="nav-item">
			                		<a class="nav-link" data-toggle="tab" href="#restrictions">{{ trans('admin.restrictions') }}</a>
			                	</li>
			                </ul>

			                <div class="tab-content">
			                	<div id="entitlement" class="tab-pane fade in show active">

			                		@include('hr.leaves.entitlement')

				                </div>
				                <div id="applicable" class="tab-pane fade">

				                	@include('hr.leaves.applicable')

				                </div>
				                <div id="restrictions" class="tab-pane fade">

				                	@include('hr.leaves.restrictions')

				                </div>
			                </div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div>

			            </form>
			        </div>
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('store_leave_type') }}";
	var updateUrl = "{{ Route('update_leave_type','') }}";

	$(document).ready(function() {

		$('.select2').select2();

		$('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            startDate: "dateToday",
            autoclose: true,
        });

        initValidate();

		$("#createLeaveTypeForm").submit(function(e) {

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
  						$('#createLeaveTypeForm').attr('action', updateUrl+'/'+enc_id);
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

	function initValidate() {
		$('#createLeaveTypeForm').validate({
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
		// $("#createLeaveTypeForm")[0].reset();
		// document.getElementById('createLeaveTypeForm').reset();
	}

	var arr_single_select = ['effective_unit','exp_field','accrual_period','accrual_time','accrual_month','accrual_mode','reset_period','reset_time','reset_month','cf_mode','reset_carry_type','encash_type','report_display','balance_display','frequency_period'];

	var arr_mult_select = {'departments':'applc_depts[]',
							'designations':'applc_designations[]',
							'employee_types':'applc_roles[]',
							'users':'applc_users[]',
							'applydates':'applydates[]',
							'blocked_clubs':'blocked_clubs[]'
						};

	var arr_mult_check = ['genders','marital_status','duration_allowed'];
	var arr_check = ['pastbooking_enable','pastbooking_limit_enable','futurebooking_enable','futurebooking_limit_enable','futurebooking_notice_enable','min_leave_enable','max_leave_enable','max_consecutive_enable','min_gap_enable','show_fileupload_after_enable'];

	var arr_radio = {'include_weekends':'include_weekends',
						'inc_holidays':'inc_holidays',
						'exceed_maxcount':'exceed_maxcount',
						'exceed_allow_opt':'exceed_allow_opt',
						'unit':'leaveunit'
					};

	var arr_textarea = ['description'];

	function fill_edit_form(data) {

		$.each(data, function (key, val) {

        	if(arr_single_select.includes(key)) {
        		$("select[name='"+key+"'] option[value="+val+"]").attr("selected", "selected");
	            $("select[name='"+key+"']").trigger("change");
        	}else if(arr_mult_select.hasOwnProperty(key)) {
        		var selector = arr_mult_select[key];
        		val = JSON.parse(val);
        		if(val != null) {
	        		$.each(val, function(index, value) {
		        		$('select[name="'+selector+'"]').find('option').each(function() {
		        			if ($(this).val() == value) {
								$(this).prop("selected","selected");
							}
			            });
		            });
		            $('select[name="'+selector+'"]').trigger("change");
		        }
        	}else if(arr_radio.hasOwnProperty(key)) {
				var selector = arr_radio[key];
        		$('input[name='+selector+'][value='+val+']').prop("checked", true);
        		$('input[name='+selector+'][value='+val+']').trigger("change");
        	}else if(arr_check.includes(key)) {
        		$('input[name='+key+'][value='+val+']').attr('checked', true);
        	}else if(arr_mult_check.includes(key)) {
        		val = JSON.parse(val);
        		$.each(val, function(index, value) {
        			$('input[name="'+key+'[]"][value='+value+']').attr('checked', true);
	            });
        	}else if(arr_textarea.includes(key)) {
        		$('textarea[name='+arr_textarea+']').html(val);
        	}else{
        		$("input[name="+ key +"]").val(val);
        		if(val != null && val != '') {
        			$("input[name="+ key +"]").removeAttr('disabled');
        		}
        	}
        });

	}
</script>

@stop
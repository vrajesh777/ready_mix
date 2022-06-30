@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_shift" onclick="form_reset()" >{{ trans('admin.add') }} {{ trans('admin.shift') }}</button>
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
							<th>{{ trans('admin.name') }}</th>
							<th>{{ trans('admin.time') }}</th>
							<th class="text-center notexport">{{ trans('admin.actions') }}</th>
						</tr>
					</thead>
					<tbody>

						@if(isset($arr_shifts) && !empty($arr_shifts))

						@foreach($arr_shifts as $key => $shift)

						<tr>
							<td>{{ ++$key }}</td>
							<td>
								<a href="javascript:void(0)" class="action-edit" data-id="{{ base64_encode($shift['id']) }}" >{{ $shift['name'] ?? 'N/A' }}</a>
							</td>
							<td>
								{{ date('h:i A', strtotime($shift['from'])) }} - 
								{{ date('h:i A', strtotime($shift['to'])) }}
							</td>
                            <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" data-id="{{ base64_encode($shift['id']) }}" href="javascript:void(0);">{{ trans('admin.edit') }} {{ trans('admin.shift') }}</a>
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
			            <form method="post" action="{{ Route('store_shift') }}" id="createShiftForm">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.name') }} <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" name="name" placeholder="{{ trans('admin.name') }}" data-rule-required="true">
									<label class="error" id="name_error"></label>
			        			</div>
			        			<div class="col-sm-2">
			        				<input type="color" name="color_code" class="form-control" value="#0202fa" style="width: 50px;cursor: pointer;">
			        			</div>
			        		</div>
			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.from') }} <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input type="text" name="from" class="form-control timepicker pl-4" placeholder="hh:mm" data-date-format="hh:mm A" value="09:00 AM" data-rule-required="true" >
									<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
		                            <label class="error" id="from_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.to') }} <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input type="text" name="to" class="form-control timepicker pl-4" placeholder="hh:mm" data-date-format="hh:mm A" value="06:00 AM" data-rule-required="true" >
									<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
		                            <label class="error" id="to_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-3 text-right">{{ trans('admin.shift_margin') }}</label>
								<div class="col-md-6">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="shift_margin" id="gender_male" value="1">
										<label class="form-check-label" for="gender_male">{{ trans('admin.enable') }}</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="shift_margin" id="gender_female" value="0" checked="">
										<label class="form-check-label" for="gender_female">{{ trans('admin.disable') }}</label>
									</div>
								</div>
							</div>

							<div class="form-group row time-margin-div" style="display: none;">
								<label class="col-sm-3 text-right"></label>
								<div class="col-sm-4">
									<input type="text" name="margin_before" class="form-control timepicker" placeholder="hh:mm" data-rule-required="true">
									<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
		                            <label class="error" id="margin_before_error"></label>
								</div>
								<label class="col-sm-5">{{ trans('admin.hours_before_the_shift_starts') }}</label>
							</div>

							<div class="form-group row time-margin-div" style="display: none;">
								<label class="col-sm-3"></label>
								<div class="col-sm-4">
									<input type="text" name="margin_after" class="form-control timepicker" placeholder="hh:mm" data-rule-required="true">
									<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
		                            <label class="error" id="margin_after_error"></label>
								</div>
								<label class="col-sm-3">{{ trans('admin.hours_after_the_shift_ends') }}</label>
							</div>

							<div class="form-group row">
								<label class="col-sm-3"></label>
								<div class="col-sm-9">
									<small>{{ trans('admin.attendance_time_note') }}<span class="margin-before-instr">9:00 AM </span> - <span class="margin-after-instr">6:00 PM</span> {{ trans('admin.attendance_time_note1') }}</small>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js" type="text/javascript" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

	var createUrl = "{{ Route('store_shift') }}";
	var updateUrl = "{{ Route('update_shift','') }}";

	$(document).ready(function() {

		$('.select2').select2();

		$('.timepicker').datetimepicker({
            format: 'HH:mm'
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
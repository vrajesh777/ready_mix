@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_shift" onclick="form_reset()" >{{ trans('admin.new') }} {{ trans('admin.break') }}</button>
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
						<th>{{ trans('admin.sr_no') }}.</th>
						<th>{{ trans('admin.name') }}</th>
						<th>{{ trans('admin.time') }}</th>
						<th>{{ trans('admin.pay_time') }}</th>
						<th>{{ trans('admin.mode') }}</th>
						<th class="text-center notexport">{{ trans('admin.actions') }}</th>
					</tr>
				</thead>
				<tbody>

					@if(isset($arr_breaks) && !empty($arr_breaks))

					@foreach($arr_breaks as $key => $break)

					<tr>
						<td>{{ ++$key }}</td>
						<td>
							<a href="javascript:void(0)" class="action-edit" data-id="{{ base64_encode($break['id']) }}" >{{ $break['title'] ?? 'N/A' }}</a>
						</td>
						<td>
							{{ date('h:i A', strtotime($break['start'])) }} - 
							{{ date('h:i A', strtotime($break['end'])) }}
						</td>
						<td>{{ ucfirst($break['pay_type']??'') }}</td>
						<td>{{ ucfirst($break['mode']??'') }}</td>
                        <td class="text-center">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item action-edit" data-id="{{ base64_encode($break['id']) }}" href="javascript:void(0);">{{ trans('admin.edit') }} {{ trans('admin.shift') }}</a>
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
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.break') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('store_break') }}" id="createBreakForm">
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
								<label class="col-md-3 text-right">{{ trans('admin.pay_type') }}</label>
								<div class="col-md-6">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="pay_type" id="type_paid" value="paid" checked>
										<label class="form-check-label" for="type_paid">{{ trans('admin.paid') }}</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="pay_type" id="type_unpaid" value="unpaid" >
										<label class="form-check-label" for="type_unpaid">{{ trans('admin.unpaid') }}</label>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-3 text-right">{{ trans('admin.mode') }}</label>
								<div class="col-md-6">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="mode" id="mode_auto" value="automatic" checked>
										<label class="form-check-label" for="mode_auto">{{ trans('admin.atomatic') }}</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="mode" id="mode_manual" value="manual">
										<label class="form-check-label" for="mode_manual">{{ trans('admin.manual') }}</label>
									</div>
								</div>
							</div>

			        		<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.start_time') }}<span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input type="text" name="start" class="form-control timepicker pl-4" placeholder="hh:mm" data-date-format="hh:mm A" value="" data-rule-required="true" >
									<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
		                            <label class="error" id="start_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.end_time') }} <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<input type="text" name="end" class="form-control timepicker pl-4" placeholder="hh:mm" data-date-format="hh:mm A" data-rule-required="true" value="" >
									<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
		                            <label class="error" id="end_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 text-right">{{ trans('admin.applicable') }} {{ trans('admin.shifts') }} <span class="text-danger">*</span></label>
								<div class="col-sm-4">
									<select class="form-control select2" name="applicable_shifts[]" multiple="" data-rule-required="true" >
										<option value="">{{ trans('admin.all') }} </option>
										@if(isset($arr_shifts) && !empty($arr_shifts))
										@foreach($arr_shifts as $shift)
										<option value="{{ $shift['id']??'' }}" >{{ $shift['name']??'' }}</option>
										@endforeach
										@endif
									</select>
		                            <label class="error" id="applicable_shifts_error"></label>
								</div>
							</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }} </button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }} </button>
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

	var createUrl = "{{ Route('store_break') }}";
	var updateUrl = "{{ Route('update_break','') }}";

	$(document).ready(function() {

		$('.select2').select2();

		$('.timepicker').datetimepicker({
            format: 'HH:mm'
        });

        initValidate();

		$("#createBreakForm").submit(function(e) {

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
				url: "{{ Route('edit_break','') }}/"+enc_id,
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
  						$('#createBreakForm').attr('action', updateUrl+'/'+enc_id);
  						$('input[name=action]').val('update');
  						$("#add_shift").modal('show');
				        if(typeof response.data != 'undefined') {
				            $.each(response.data, function (key, val) {
				            	if(key == 'pay_type' || key == 'mode') {
			            			$('input[name='+key+'][value='+val+']').attr('checked', true);
			            			$('input[name='+key+'][value='+val+']').trigger('change');
				            	}else if(key == 'applicable_shifts') {
				            		$("select[name='applicable_shifts[]']").find('option').each(function() {
				            			if ($.inArray($(this).val(), val) != -1) {
											$(this).prop("selected","selected");
										}
						            });
						            $("select[name='applicable_shifts[]']").trigger("change");
				            	}else{
				                	$("input[name="+ key +"]").val(val);
				            	}
				                	$("input[name="+ key +"]").val(val);
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
		$('#createBreakForm').validate({
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
		$("#createBreakForm")[0].reset();
		// document.getElementById('createBreakForm').reset();
	}
</script>

@stop
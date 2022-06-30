@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>
		
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<!-- <ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('pump-helper-create'))
                	<li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_pump_helper" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.pump_helper') }}</button>
	                </li>
                @endif
            </ul> -->
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="pumpHelperTable">
						<thead>
							<tr>
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.id_number') }}</th>
								<th>{{ trans('admin.name') }}</th>
								<th>{{ trans('admin.mobile_no') }}</th>
								@if($obj_user->hasPermissionTo('pump-helper-update'))
									<th>{{ trans('admin.status') }}</th>
									<th class="text-right notexport">{{ trans('admin.actions') }}</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['id'] ?? '' }}</td>
										<td>{{ $value['id_number'] ?? '-' }}</td>
										<td>{{ $value['first_name'] ?? '' }} {{ $value['last_name'] ?? '' }}</td>
										<td>{{ $value['mobile_no'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('pump-helper-update'))
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('driver_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">Active</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('driver_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">Deactive</a>
											@endif
										</td>
										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_pump_helper" onclick="driver_pump_helper('{{base64_encode($value['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
										</td>
										@endif
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Content End -->

<!-- Add Modal -->
<div class="modal right fade" id="add_pump_helper" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{trans('admin.add')}} {{trans('admin.pump_helper')}}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('pump_helper_store') }}" id="frmAddPumpHelper" enctype="multipart/form-data">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.first_name')}}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{trans('admin.first_name')}}" data-rule-required="true">
                					<label class="error" id="first_name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.last_name')}}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{trans('admin.last_name')}}" data-rule-required="true">
                					<label class="error" id="last_name_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.id_number')}}</label>
                					<input type="text" class="form-control" name="id_number" id="id_number" placeholder="{{trans('admin.id_number')}}" data-rule-digits="true" data-rule-maxlength="10" data-rule-minlength="3" data-rule-required="true">
                					<label class="error" id="id_number_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.mobile_no')}}</label>
                					<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="{{trans('admin.mobile_no')}}" data-rule-digits="true">
                					<label class="error" id="mobile_no_error"></label>
								</div>
							</div>
						
			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{trans('admin.save')}}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{trans('admin.cancel')}}</button>
			                </div>
			            </form>
			        </div>
				</div>
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- Add modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('pump_helper_store') }}";
	var updateUrl = "{{ Route('pump_helper_update','') }}";

	$(document).ready(function(){
		$('#frmAddPumpHelper').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#frmAddPumpHelper").submit(function(e) {

			e.preventDefault();

			var formData = new FormData(this);

			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data: formData,
      				dataType:'json',
      				processData: false,
					contentType: false,
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

		$('.closeForm').click(function(){
			$("#add_pump_helper").modal('hide');
			form_reset();
		});

		$('#pumpHelperTable').DataTable({
			// "pageLength": 2
			/*"order" : [[ 0, 'desc' ]],
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '{{ Config::get('app.project.title') }} Drivers',
				filename: '{{ Config::get('app.project.title') }} Drivers PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Drivers',
				filename: '{{ Config::get('app.project.title') }} Drivers EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Drivers CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]*/
		});


	});

	function form_reset() {
		$('#frmAddPumpHelper')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function driver_pump_helper(enc_id)
	{
		$('.top_title').html('Edit Pump Helper');
		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'SUCCESS')
							{
								$('#frmAddPumpHelper').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');
								$('#first_name').val(response.data.first_name);
								$('#last_name').val(response.data.last_name);
								$('#mobile_no').val(response.data.mobile_no);
								$('#id_number').val(response.data.id_number);

							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}
</script>
@stop
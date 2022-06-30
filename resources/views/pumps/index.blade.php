@extends('layout.master')
@section('main_content')
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('pumps-create'))
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_pump" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.pump') }}</button>
                </li>
                @endif
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
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0 datatable">
						<thead>
							<tr>
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.name') }}</th>
								<th>{{ trans('admin.pump_op') }}</th>
								<th>{{ trans('admin.pump_helper') }}</th>
								<th>{{ trans('admin.location') }}</th>
								@if($obj_user->hasPermissionTo('pumps-update'))
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right">{{ trans('admin.actions') }}</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['id'] ?? '' }}</td>
										<td>{{ $value['name'] ?? '' }}</td>
										<td>{{ $value['operator']['first_name'] ?? '' }} {{ $value['operator']['last_name'] ?? '' }}</td>
										<td>{{ $value['helper']['first_name'] ?? '' }} {{ $value['helper']['last_name'] ?? '' }}</td>
										<td>{{ $value['location'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('pumps-update'))
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('pump_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('pump_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>

										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_pump" onclick="product_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
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
<div class="modal right fade" id="add_pump" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.pump') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('pump_store') }}" id="frmAddPump">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('admin.name') }}" data-rule-required="true" maxlength="50">
                					<label class="error" id="name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.status') }}<span class="text-danger">*</span></label>
		                            <select class="form-control" name="is_active" id="is_active" data-rule-required="true">
		                            	<option value="" hidden>{{ trans('admin.select') }} {{ trans('admin.status') }}</option>
		                            	<option value="1">{{ trans('admin.active') }}</option>
		                            	<option value="0">{{ trans('admin.deactive') }}</option>
		                             </select>
		                             <label class="error" id="is_active_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.pump_op') }}<span class="text-danger">*</span></label>
		                            <select class="form-control" name="operator_id" id="operator_id" data-rule-required="true">
		                                <option value="" hidden>{{ trans('admin.select') }} {{ trans('admin.pump_op') }}</option>
		                                @if(isset($arr_operator) && sizeof($arr_operator)>0)
		                                	@foreach($arr_operator as $op)
		                                		<option value="{{ $op['id'] ?? '' }}">{{ $op['id_number'] ?? '' }} - {{ $op['first_name'] ?? '' }} {{ $op['last_name'] ?? '' }}</option>
		                                	@endforeach
		                                @endif
		                             </select>
		                             <label class="error" id="operator_id_error"></label>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.pump_helper') }}<span class="text-danger">*</span></label>
		                            <select class="form-control" name="helper_id" id="helper_id" data-rule-required="true">
		                                <option value="" hidden>{{ trans('admin.select') }} {{ trans('admin.pump_helper') }}</option>
		                                @if(isset($arr_helper) && sizeof($arr_helper)>0)
		                                	@foreach($arr_helper as $helper)
		                                		<option value="{{ $helper['id'] ?? '' }}">{{ $helper['id_number'] ?? '' }} - {{ $helper['first_name'] ?? '' }} {{ $helper['last_name'] ?? '' }}</option>
		                                	@endforeach
		                                @endif
		                             </select>
		                             <label class="error" id="helper_id_error"></label>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.driver') }}<span class="text-danger">*</span></label>
		                            <select class="form-control" name="driver_id" id="driver_id" data-rule-required="true">
		                                <option value="" hidden>{{ trans('admin.select') }} {{ trans('admin.driver') }}</option>
		                                @if(isset($arr_driver) && sizeof($arr_driver)>0)
		                                	@foreach($arr_driver as $driver)
		                                		<option value="{{ $driver['id'] ?? '' }}">{{ $driver['id_number'] ?? '' }} - {{ $driver['first_name'] ?? '' }} {{ $driver['last_name'] ?? '' }}</option>
		                                	@endforeach
		                                @endif
		                             </select>
		                             <label class="error" id="driver_id_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.longitude') }}</label>
                					<input type="text" class="form-control" name="lat" id="lat" placeholder="{{ trans('admin.longitude') }}" data-rule-number="true" maxlength="250">
                					<label class="error" id="lat_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.latitude') }}</label>
                					<input type="text" class="form-control" name="lng" id="lng" placeholder="{{ trans('admin.latitude') }}" data-rule-number="true" maxlength="250">
                					<label class="error" id="lng_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-12">
									<label class="col-form-label">{{ trans('admin.location') }}</label>
                					<textarea class="form-control" rows="3" name="location" id="location" placeholder="{{ trans('admin.location') }}"></textarea>
                					<label class="error" id="location_error"></label>
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
</div>
<!-- Add modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('pump_store') }}";
	var updateUrl = "{{ Route('pump_update','') }}";

	$(document).ready(function(){

		$('#frmAddPump').validate({
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

		$("#frmAddPump").submit(function(e) {
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

		$('.closeForm').click(function(){
			$("#add_pump").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddPump')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	var pump_op = "{{ trans('admin.select') }} {{ trans('admin.pump_op') }}";
	var pump_helper = "{{ trans('admin.select') }} {{ trans('admin.pump_helper') }}";
	var driver = "{{ trans('admin.select') }} {{ trans('admin.driver') }}";
	function product_edit(enc_id)
	{
		$('.top_title').html('Edit Pump');

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
								$('#frmAddPump').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#name').val(response.data.name);
								$('#lat').val(response.data.lat);
								$('#lng').val(response.data.lng);
								$('#location').val(response.data.location);
								$('select[name^="is_active"] option[value="'+response.data.is_active+'"]').attr("selected","selected");
								$('select[name="operator_id"]').removeAttr('disabled');
				                if(typeof(response.data.arr_operator) == "object"){
				                    var option = '<option value="" hidden>'+pump_op+'</option>'; 
				                    
				                    $(response.data.arr_operator).each(function(index,operator){   
				                    	var select = '';
				                    	if(operator.id == response.data.operator_id)
					                    {
					                    	select = 'selected';
					                    }

				                        option+='<option value="'+operator.id+'" '+select+' >'+operator.first_name+' '+operator.last_name+'</option>';
				                    });
				                    $('select[name="operator_id"]').html(option);
				                }

				                $('select[name="helper_id"]').removeAttr('disabled');
				                if(typeof(response.data.arr_helper) == "object"){
				                    var option = '<option value="" hidden>'+pump_helper+'</option>'; 
				                    
				                    $(response.data.arr_helper).each(function(index,helper){   
				                    	var select = '';
				                    	if(helper.id == response.data.helper_id)
					                    {
					                    	select = 'selected';
					                    }

				                        option+='<option value="'+helper.id+'" '+select+' >'+helper.first_name+' '+helper.last_name+'</option>';
				                    });
				                    $('select[name="helper_id"]').html(option);
				                }
								//
								$('select[name="driver_id"]').removeAttr('disabled');
				                if(typeof(response.data.arr_driver) == "object"){
				                    var option = '<option value="" hidden>'+driver+'</option>'; 
				                    
				                    $(response.data.arr_driver).each(function(index,driver){   
				                    	var select = '';
				                    	if(driver.id == response.data.driver_id)
					                    {
					                    	select = 'selected';
					                    }

				                        option+='<option value="'+driver.id+'" '+select+' >'+driver.first_name+' '+driver.last_name+'</option>';
				                    });
				                    $('select[name="driver_id"]').html(option);
				                }
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
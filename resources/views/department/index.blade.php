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
			<ul class="list-inline-item pl-0">
				 @if($obj_user->hasPermissionTo('department-create'))
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_department" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.department') }}</button>
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
								<th>{{ trans('admin.department') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.mail_alias') }}</th>
								<th>{{ trans('admin.department') }} {{ trans('admin.lead') }}</th>
								<th>{{ trans('admin.parent') }} {{ trans('admin.department') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th>{{ trans('admin.actions') }}</th>
								
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_dept) && sizeof($arr_dept)>0)
								@foreach($arr_dept as $key => $dept)
									<tr>
										<td>{{ $dept['name'] ?? '' }}</td>
										<td>{{ $dept['mail_alias'] ?? '' }}</td>
										<td>{{ $dept['lead_user']['first_name'] ?? '' }} {{ $dept['lead_user']['last_name'] ?? '' }}</td>
										<td>{{ $dept['parent_dept']['name'] ?? '' }} </td>
										<td>
											@if(isset($dept['is_active']) && $dept['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('department_deactivate', base64_encode($dept['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('department_activate',base64_encode($dept['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>
										 @if($obj_user->hasPermissionTo('department-update'))
										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_department" onclick="department_edit('{{base64_encode($dept['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
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
<div class="modal right fade" id="add_department" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.department') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('department_store') }}" id="frmAddDepartment">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.department') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="department_name" id="department_name" placeholder="{{ trans('admin.department') }} {{ trans('admin.name') }}" data-rule-required="true" data-rule-maxlength="150">
                					<label class="error" id="mix_code_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.mail_alias') }}</label>
                					<input type="text" class="form-control" name="mail_alias" id="mail_alias" placeholder="{{ trans('admin.mail_alias') }}">
                					<label class="error" id="name_error"></label>
								</div>
							</div>
							
							<div class="row">
							
								<div class="col-sm-6">
								     <label class="col-form-label">{{ trans('admin.department') }} {{ trans('admin.lead') }} <span class="text-danger">*</span></label>
									<select class="form-control" name="department_lead" id="department_lead" data-rule-required="true" >
										<option value="">{{ trans('admin.select') }} </option>
										@if(isset($arr_lead) && !empty($arr_lead))
										@foreach($arr_lead as $lead)
										<option value="{{ $lead['id']??'' }}" >{{ $lead['first_name']??'' }} {{ $lead['last_name']??'' }}</option>
										@endforeach
										@endif
									</select>
		                            <label class="error" id="applicable_shifts_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.parent') }} {{ trans('admin.department') }}</label>
									<select class="form-control" name="parent_department" id="parent_department">
										<option value="">{{ trans('admin.select') }} </option>
										@if(isset($arr_parent_dept) && !empty($arr_parent_dept))
										@foreach($arr_parent_dept as $department)
										<option value="{{ $department['id']??'' }}" >{{ $department['name']??'' }}</option>
										@endforeach
										@endif
									</select>
		                            <label class="error" id="applicable_shifts_error"></label>
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

	var createUrl = "{{ Route('department_store') }}";
	var updateUrl = "{{ Route('department_update','') }}";

	$(document).ready(function(){

		$('#frmAddDepartment').validate({
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

		$("#frmAddDepartment").submit(function(e) {
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
			$("#add_department").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddDepartment')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function department_edit(enc_id)
	{
		$('.top_title').html('Edit department');

		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){
							showProcessingOverlay();
						},
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'SUCCESS')
							{
								$('#frmAddDepartment').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');
								$('#department_name').val(response.data.name);
								$('#mail_alias').val(response.data.mail_alias);
								$('select[name^="department_lead"] option[value="'+response.data.lead_user_id+'"]').attr("selected","selected");
								$('select[name^="parent_department"] option[value="'+response.data.parent_id+'"]').attr("selected","selected");

								$.each(response.data.attr_values, function( index, value ) {
								  	$('#'+value.department_attr_id).val(value.value);
								});
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
@extends('layout.master')
@section('main_content')
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('overhead-expances-create'))
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_unit" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.overhead_expances') }}</button>
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
								<th>{{ trans('admin.value') }}</th>
								<th>{{ trans('admin.type') }}</th>
								@if($obj_user->hasPermissionTo('overhead-expances-update'))
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
										<td>{{ $value['value'] ?? '' }}</td>
										<td>{{ $value['type'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('overhead-expances-update'))
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('overhead_expances_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('overhead_expances_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>

										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_unit" onclick="unit_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
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
<div class="modal right fade" id="add_unit" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.overhead_expances') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('overhead_expances_store') }}" id="frmAddUnit">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('admin.name') }}" data-rule-required="true">
                					<label class="error" id="name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.calculation_type') }}<span class="text-danger">*</span></label>
		                            <select class="form-control" name="type" id="type" data-rule-required="true">
		                            	<option value="">{{ trans('admin.select') }}</option>
		                            	<option value="flat">{{ trans('admin.flat') }}</option>
		                            	<option value="percentage">{{ trans('admin.percentage') }}</option>
		                             </select>
		                             <label class="error" id="type_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.value') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="value" id="value" placeholder="{{ trans('admin.value') }}" data-rule-required="true" data-rule-number="true">
                					<label class="error" id="value_error"></label>
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

	var createUrl = "{{ Route('overhead_expances_store') }}";
	var updateUrl = "{{ Route('overhead_expances_update','') }}";

	$(document).ready(function(){

		$('#frmAddUnit').validate({
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

		$("#frmAddUnit").submit(function(e) {
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
			$("#add_unit").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddUnit')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	var overhead = "{{ trans('admin.overhead_expances') }}";
	function unit_edit(enc_id)
	{
		$('.top_title').html('Edit '+overhead);

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
								$('#frmAddUnit').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#name').val(response.data.name);
								$('select[name^="type"] option[value="'+response.data.type+'"]').attr("selected","selected");
								$('#value').val(response.data.value);
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
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
				@if($obj_user->hasPermissionTo('units-create'))
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_unit" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.unit') }}</button>
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
								<th>{{ trans('admin.unit') }} {{ trans('admin.code') }}</th>
								<th>{{ trans('admin.unit') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.unit') }} {{ trans('admin.symbol') }}</th>
								<th>{{ trans('admin.note') }}</th>
								@if($obj_user->hasPermissionTo('units-update'))
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
										<td>{{ $value['unit_code'] ?? '' }}</td>
										<td>{{ $value['unit_name'] ?? '' }}</td>
										<td>{{ $value['unit_symbol'] ?? '' }}</td>
										<td>{{ $value['note'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('units-update'))
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('unit_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('unit_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactivate') }}</a>
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
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.unit') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('unit_store') }}" id="frmAddUnit">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.unit') }} {{ trans('admin.code') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="unit_code" id="unit_code" placeholder="{{ trans('admin.unit') }} {{ trans('admin.code') }}" data-rule-required="true">
                					<label class="error" id="unit_code_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.unit') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="unit_name" id="unit_name" placeholder="{{ trans('admin.unit') }} {{ trans('admin.name') }}" data-rule-required="true">
                					<label class="error" id="unit_name_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.unit') }} {{ trans('admin.symbol') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="unit_symbol" id="unit_symbol" placeholder="{{ trans('admin.unit') }} {{ trans('admin.symbol') }}" data-rule-required="true">
                					<label class="error" id="unit_symbol_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.note') }}</label>
                					<input type="text" class="form-control" name="note" id="note" placeholder="{{ trans('admin.note') }}">
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

	var createUrl = "{{ Route('unit_store') }}";
	var updateUrl = "{{ Route('unit_update','') }}";

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
	function unit_edit(enc_id)
	{
		$('.top_title').html('Edit Unit');

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

								$('#unit_code').val(response.data.unit_code);
								$('#unit_name').val(response.data.unit_name);
								$('#unit_symbol').val(response.data.unit_symbol);
								$('#note').val(response.data.note);
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
@extends('layout.master')
@section('main_content')
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				{{-- @if($obj_user->hasPermissionTo('pumps-create')) --}}
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_reimbs" onclick="form_reset()">Add</button>
                </li>
                {{-- @endif --}}
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
								<th>Name</th>
								{{-- <th>Reimbursement Type</th> --}}
								<th>Maximum reimbursable amount</th>
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
										<td>{{ $value['name_payslip'] ?? '' }}</td>
										{{-- <td>{{ $value['reimbursement_type']['name'] ?? '' }}</td> --}}
										<td>{{ $value['amount'] }}</td>
										{{-- @if($obj_user->hasPermissionTo('pumps-update')) --}}
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('reimbursement_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('reimbursement_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>

										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_reimbs" onclick="reimbs_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
										</td>
										{{-- @endif --}}

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
<div class="modal right fade" id="add_reimbs" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('reimbursement_store') }}" id="frmAddPump">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								{{-- <div class="col-sm-6">
									<label class="col-form-label">Reimbursement Type<span class="text-danger">*</span></label>
		                            <select class="form-control" name="reimbursement_type_id" id="reimbursement_type_id" data-rule-required="true">
		                            	<option value="">Select</option>
		                                @if(isset($arr_reims_type) && sizeof($arr_reims_type)>0)
		                                	@foreach($arr_reims_type as $type)
		                                		<option value="{{ $type['id'] ?? '' }}">{{ $type['name'] ?? '' }}</option>
		                                	@endforeach
		                                @endif
		                             </select>
		                             <label class="error" id="reimbursement_type_id_error"></label>
								</div> --}}
								<div class="col-sm-6">
									<label class="col-form-label">Name in Payslip<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name_payslip" id="name_payslip" placeholder="Name in Payslip" data-rule-required="true" maxlength="50">
                					<label class="error" id="name_payslip_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">Enter Amount<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount" data-rule-number="true" data-rule-numbers="true" data-rule-required="true">
                					<label class="error" id="amount_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.status') }}<span class="text-danger">*</span></label>
		                            <select class="form-control" name="is_active" id="is_active" data-rule-required="true">
		                            	<option value="">{{ trans('admin.select') }} {{ trans('admin.status') }}</option>
		                            	<option value="1">{{ trans('admin.active') }}</option>
		                            	<option value="0">{{ trans('admin.deactive') }}</option>
		                             </select>
		                             <label class="error" id="is_active_error"></label>
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

	var createUrl = "{{ Route('reimbursement_store') }}";
	var updateUrl = "{{ Route('reimbursement_update','') }}";

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
			$("#add_reimbs").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddPump')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	var reimbursement_op = "{{ trans('admin.select') }} {{ trans('admin.reimbursement_op') }}";
	var reimbursement_helper = "{{ trans('admin.select') }} {{ trans('admin.reimbursement_helper') }}";
	function reimbs_edit(enc_id)
	{
		$('.top_title').html('Edit');

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
								console.log(response.data);
								$('#frmAddPump').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#name_payslip').val(response.data.name_payslip);
								$('#amount').val(response.data.amount);
								$('select[name^="is_active"] option[value="'+response.data.is_active+'"]').attr("selected","selected");

								//$('#reimbursement_type_id').attr('disabled',true);
				                /*if(typeof(response.data.arr_reims_type) == "object"){
				                    var option = '<option value="">'+reimbursement_op+'</option>'; 
				                    
				                    $(response.data.arr_reims_type).each(function(index,operator){   
				                    	var select = '';
				                    	if(operator.id === response.data.reimbursement_type_id)
					                    {
					                    	select = 'selected';
					                    }

				                        option+='<option value="'+operator.id+'" '+select+' >'+operator.name+'</option>';
				                    });
				                    $('select[name="reimbursement_type_id"]').html(option);
				                }*/
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
<?php $__env->startSection('main_content'); ?>
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_reimbs" onclick="form_reset()"><?php echo e(trans('admin.add_earning')); ?></button>
                </li>
                
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
								<th><?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.name_in_payslip')); ?></th>
								<th><?php echo e(trans('admin.calculation_type')); ?></th>
								
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right"><?php echo e(trans('admin.actions')); ?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($value['name'] ?? ''); ?></td>
										<td><?php echo e($value['name_payslip'] ?? ''); ?></td>
										<td><?php echo e($value['cal_type'] ?? ''); ?></td>
										
										
										<td>
											<?php if($value['is_active'] == '1'): ?>
												<a class="btn btn-success btn-sm" href="<?php echo e(Route('earning_deactivate', base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
											<?php else: ?>
												<a class="btn btn-danger btn-sm" href="<?php echo e(route('earning_activate',base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
											<?php endif; ?>
										</td>

										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_reimbs" onclick="reimbs_edit('<?php echo e(base64_encode($value['id'] ?? '')); ?>')"><i class="far fa-edit"></i></a>
										</td>
										

									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
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
                <h4 class="modal-title text-center top_title"><?php echo e(trans('admin.add')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="<?php echo e(Route('earning_store')); ?>" id="frmAddPump">
			            	<?php echo e(csrf_field()); ?>

			            	<input type="hidden" name="action" value="create">
			            	
							<div class="form-group row">
								
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.earning_name')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="Earning Name" data-rule-required="true" maxlength="50">
                					<label class="error" id="name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.name_in_payslip')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name_payslip" id="name_payslip" placeholder="Name in Payslip" data-rule-required="true" maxlength="50">
                					<label class="error" id="name_payslip_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.calculation_type')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control" name="cal_type" id="cal_type">
		                            	<option value=""><?php echo e(trans('admin.select')); ?></option>
		                            	<option value="flat"><?php echo e(trans('admin.flat')); ?></option>
		                            	<option value="percentage"><?php echo e(trans('admin.percentage')); ?></option>
		                             </select>
		                             <label class="error" id="cal_type_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.status')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control" name="is_active" id="is_active" data-rule-required="true">
		                            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.status')); ?></option>
		                            	<option value="1"><?php echo e(trans('admin.active')); ?></option>
		                            	<option value="0"><?php echo e(trans('admin.deactive')); ?></option>
		                             </select>
		                             <label class="error" id="is_active_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-6">
									<label class="container-checkbox font-size-14 pr-4">
										<input type="checkbox" name="is_extra" value="1">
										<span class="checkmark"></span>
										Is Extra Earning
									</label>
								</div>
							</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></button>
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

	var createUrl = "<?php echo e(Route('earning_store')); ?>";
	var updateUrl = "<?php echo e(Route('earning_update','')); ?>";

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

	/*$('#earning_type_id').change(function(){
		var earning_type_id = $(this).val();
		var exclude = ['5', '6', '16'];
		var n = exclude.includes(earning_type_id);
		if(n == true){
			$('#cal_value').attr('data-rule-required',false);
			$('#cal_type').attr('data-rule-required',false);
			$('.cal_type_value').hide();
		}
		else{
			$('#cal_value').attr('data-rule-required',true);
			$('#cal_type').attr('data-rule-required',true);
			$('.cal_type_value').show();
		}

	});*/

	function form_reset() {
		$('#frmAddPump')[0].reset();
	}

	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	var earning_op = "<?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.earning_op')); ?>";
	var earning_helper = "<?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.earning_helper')); ?>";
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
								/*earning_type_id
								name
								name_payslip
								cal_type
								cal_value*/
								
								$('#frmAddPump').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								var exclude = [5,6,16];
								var n = exclude.includes(response.data.earning_type_id);
								console.log(response.data.earning_type_id,n);
								if(n == true){
									$('#cal_value').attr('data-rule-required',false);
									$('#cal_type').attr('data-rule-required',false);
									$('.cal_type_value').hide();
								}
								else{
									$('#cal_value').attr('data-rule-required',true);
									$('#cal_type').attr('data-rule-required',true);
									$('.cal_type_value').show();
								}

								$('#name').val(response.data.name);
								$('#name_payslip').val(response.data.name_payslip);
								//$('#cal_value').val(response.data.cal_value);
								//$('#earning_type_id').val(response.data.earning_type_id);
								$('select[name^="is_active"] option[value="'+response.data.is_active+'"]').attr("selected","selected");
								$('select[name^="cal_type"] option[value="'+response.data.cal_type+'"]').attr("selected","selected");
								$('input[name="is_extra"][value='+response.data.is_extra+']').attr('checked', true);

								/*$('#earning_type_id').attr('disabled',true);
				                if(typeof(response.data.arr_earning_type) == "object"){
				                    var option = '<option value="">'+earning_op+'</option>'; 
				                    
				                    $(response.data.arr_earning_type).each(function(index,operator){   
				                    	var select = '';
				                    	if(operator.id === response.data.earning_type_id)
					                    {
					                    	select = 'selected';
					                    }

				                        option+='<option value="'+operator.id+'" '+select+' >'+operator.name+'</option>';
				                    });
				                    $('select[name="earning_type_id"]').html(option);
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/hr/earning/index.blade.php ENDPATH**/ ?>
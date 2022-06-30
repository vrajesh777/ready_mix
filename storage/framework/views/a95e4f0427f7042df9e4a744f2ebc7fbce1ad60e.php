<?php $__env->startSection('main_content'); ?>

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
				 <?php if($obj_user->hasPermissionTo('department-create')): ?>
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_department" onclick="form_reset()"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.department')); ?></button>
                </li>
                <?php endif; ?>
           
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
								<th><?php echo e(trans('admin.department')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.mail_alias')); ?></th>
								<th><?php echo e(trans('admin.department')); ?> <?php echo e(trans('admin.lead')); ?></th>
								<th><?php echo e(trans('admin.parent')); ?> <?php echo e(trans('admin.department')); ?></th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th><?php echo e(trans('admin.actions')); ?></th>
								
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_dept) && sizeof($arr_dept)>0): ?>
								<?php $__currentLoopData = $arr_dept; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($dept['name'] ?? ''); ?></td>
										<td><?php echo e($dept['mail_alias'] ?? ''); ?></td>
										<td><?php echo e($dept['lead_user']['first_name'] ?? ''); ?> <?php echo e($dept['lead_user']['last_name'] ?? ''); ?></td>
										<td><?php echo e($dept['parent_dept']['name'] ?? ''); ?> </td>
										<td>
											<?php if(isset($dept['is_active']) && $dept['is_active'] == '1'): ?>
												<a class="btn btn-success btn-sm" href="<?php echo e(Route('department_deactivate', base64_encode($dept['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
											<?php else: ?>
												<a class="btn btn-danger btn-sm" href="<?php echo e(route('department_activate',base64_encode($dept['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
											<?php endif; ?>
										</td>
										 <?php if($obj_user->hasPermissionTo('department-update')): ?>
										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_department" onclick="department_edit('<?php echo e(base64_encode($dept['id'] ?? '')); ?>')"><i class="far fa-edit"></i></a>
										</td>
										<?php endif; ?>
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
<div class="modal right fade" id="add_department" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.department')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="<?php echo e(Route('department_store')); ?>" id="frmAddDepartment">
			            	<?php echo e(csrf_field()); ?>

			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.department')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="department_name" id="department_name" placeholder="<?php echo e(trans('admin.department')); ?> <?php echo e(trans('admin.name')); ?>" data-rule-required="true" data-rule-maxlength="150">
                					<label class="error" id="mix_code_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.mail_alias')); ?></label>
                					<input type="text" class="form-control" name="mail_alias" id="mail_alias" placeholder="<?php echo e(trans('admin.mail_alias')); ?>">
                					<label class="error" id="name_error"></label>
								</div>
							</div>
							
							<div class="row">
							
								<div class="col-sm-6">
								     <label class="col-form-label"><?php echo e(trans('admin.department')); ?> <?php echo e(trans('admin.lead')); ?> <span class="text-danger">*</span></label>
									<select class="form-control" name="department_lead" id="department_lead" data-rule-required="true" >
										<option value=""><?php echo e(trans('admin.select')); ?> </option>
										<?php if(isset($arr_lead) && !empty($arr_lead)): ?>
										<?php $__currentLoopData = $arr_lead; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($lead['id']??''); ?>" ><?php echo e($lead['first_name']??''); ?> <?php echo e($lead['last_name']??''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
		                            <label class="error" id="applicable_shifts_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.parent')); ?> <?php echo e(trans('admin.department')); ?></label>
									<select class="form-control" name="parent_department" id="parent_department">
										<option value=""><?php echo e(trans('admin.select')); ?> </option>
										<?php if(isset($arr_parent_dept) && !empty($arr_parent_dept)): ?>
										<?php $__currentLoopData = $arr_parent_dept; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($department['id']??''); ?>" ><?php echo e($department['name']??''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
		                            <label class="error" id="applicable_shifts_error"></label>
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

	var createUrl = "<?php echo e(Route('department_store')); ?>";
	var updateUrl = "<?php echo e(Route('department_update','')); ?>";

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

	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/department/index.blade.php ENDPATH**/ ?>
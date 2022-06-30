<?php $__env->startSection('main_content'); ?>

<form method="POST" action="<?php echo e(Route('roles_store')); ?>" id="formAddRoles">
	<div class="row">
		<?php echo e(csrf_field()); ?>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.department')); ?><span class="text-danger">*</span></label>
	                            <select name="department_id" class="select2" id="department_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.department')); ?></option>
									<?php if(isset($arr_dept) && sizeof($arr_dept)>0): ?>
										<?php $__currentLoopData = $arr_dept; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($dept['id'] ?? ''); ?>"><?php echo e($dept['name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('department_id')); ?></div>
        					</div>
						</div>
						
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.role')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="name" id="name" placeholder="<?php echo e(trans('admin.role')); ?> <?php echo e(trans('admin.name')); ?>" data-rule-required="true" value="<?php echo e(old('name')); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('name')); ?></div>
        					</div>
						</div>
						
					</div>

					<div class="row">
						<?php if(isset($arr_permission) && count($arr_permission)>0): ?>
                       		<?php $__currentLoopData = $arr_permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-sm-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="permission[]" value="<?php echo e($value['id']); ?>"> <?php echo e(ucwords(str_replace('-', ' ', $value['name']))); ?>

									</label>
								</div>
							</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded"><?php echo e(trans('admin.cancel')); ?></button>
	                </div>

				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Page Header -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2();
		$('#formAddRoles').validate({});
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/roles/create.blade.php ENDPATH**/ ?>
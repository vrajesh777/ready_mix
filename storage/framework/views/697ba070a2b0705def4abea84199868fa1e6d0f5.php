<?php $__env->startSection('main_content'); ?>
		
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <a href="<?php echo e(Route('roles_create')); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.role')); ?></a>
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
								<th><?php echo e(trans('admin.id')); ?></th>
								<th><?php echo e(trans('admin.role')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.department')); ?></th>
								<th class="text-right"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($roles) && sizeof($roles)>0): ?>
								<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($role['id'] ?? ''); ?></td>
										<td><?php echo e($role['name'] ?? ''); ?></td>
										<td>
											<?php if(isset($arr_dept) && sizeof($arr_dept)>0): ?>
												<?php $__currentLoopData = $arr_dept; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php if($dept['id'] == $role['department_id']): ?>
														<?php echo e($dept['name'] ?? ''); ?>

													<?php endif; ?>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<a class="dropdown-item" href="<?php echo e(Route('roles_edit',base64_encode($role['id']))); ?>"><i class="far fa-edit"></i></a>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/roles/index.blade.php ENDPATH**/ ?>
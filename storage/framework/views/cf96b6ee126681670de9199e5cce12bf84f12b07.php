<?php $__env->startSection('main_content'); ?>


<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form action="" id="filterForm">
			<ul class="list-inline-item pl-0 d-flex">
                <li class="list-inline-item">
                    <select name="vechicle_id" class="select" id="vechicle_id">
		            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.vehicle')); ?></option>
		            	<?php if(isset($arr_vechicle) && sizeof($arr_vechicle)>0): ?>
							<?php $__currentLoopData = $arr_vechicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vhc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option  value="<?php echo e($vhc['id']??''); ?>" <?php echo e(($vhc['id']??'')==($vechicle_id??'')?'selected':''); ?>><?php echo e($vhc['name']??''); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</select>
                </li>
                <li class="list-inline-item">
                    <select name="status" class="select" id="status">
		            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.status')); ?></option>
						<option  value="Pending" <?php echo e(('Pending')==($status??'')?'selected':''); ?>><?php echo e(trans('admin.pending')); ?></option>
						<option  value="Delivered" <?php echo e(('Delivered')==($status??'')?'selected':''); ?>><?php echo e(trans('admin.delivered')); ?></option>
					</select>
                </li>
                <li class="list-inline-item">
                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
                </li>
            </ul>
        	</form>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<li class="list-inline-item">
                    <a href="<?php echo e(Route('vhc_repair_create')); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-user-btn"><?php echo e(trans('admin.new')); ?> <?php echo e($module_title??''); ?></a>
                </li>
			</ul>
		</div>
		
	</div>
</div>

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="driverTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.repair')); ?> <?php echo e(trans('admin.id')); ?></th>
								<th><?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.make')); ?></th>
								<th><?php echo e(trans('admin.model')); ?></th>
								<th><?php echo e(trans('admin.year')); ?></th>
								<th><?php echo e(trans('admin.chasis_no')); ?></th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($value['order_no'] ?? 0); ?></td>
										<td><?php echo e($value['vechicle_details']['name'] ?? '-'); ?></td>
										<td><?php echo e($value['vechicle_details']['make']['make_name'] ?? '-'); ?></td>
										<td><?php echo e($value['vechicle_details']['model']['model_name'] ?? '-'); ?></td>
										<td><?php echo e($value['vechicle_details']['year'] ?? '-'); ?></td>
										<td><?php echo e($value['vechicle_details']['chasis_no'] ?? '-'); ?></td>
										<td>
											<?php if($value['status'] == 'Pending'): ?>
												<a class="btn btn-danger btn-sm" href="<?php echo e(Route('vhc_repair_chg_status', base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Delivered this order ?');" title="Pending"><?php echo e(trans('admin.pending')); ?></a>
											<?php elseif($value['status'] == 'Delivered'): ?>
												<a class="btn btn-success btn-sm" href="javascript:void(0);" title="Delivered"><?php echo e(trans('admin.delivered')); ?></a>
											<?php endif; ?>
										</td>
										<td class="text-center">
											<?php if($value['status'] != 'Delivered'): ?>
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item action-edit" href="<?php echo e(Route('vhc_repair_edit',base64_encode($value['id'] ?? 0))); ?>"><?php echo e(trans('admin.edit')); ?></a>
													<a class="dropdown-item action-edit" href="<?php echo e(Route('vhc_repair_view',base64_encode($value['id'] ?? 0))); ?>"><?php echo e(trans('admin.view')); ?></a>
												</div>
											</div>
											<?php endif; ?>
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

<script type="text/javascript">
	$(document).ready(function(){
		$('#driverTable').DataTable({
		});

		$("#vechicle_id,#status").change(function() {
			$("#filterForm").submit();
		});

		$('#clear_btn').click(function(){
			window.location.href="<?php echo e(Route('vhc_repair')); ?>";
		});
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/vechicle_maintance/repair/index.blade.php ENDPATH**/ ?>
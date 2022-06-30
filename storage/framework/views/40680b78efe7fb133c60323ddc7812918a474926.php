<?php $__env->startSection('main_content'); ?>

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
								<th><?php echo e(trans('admin.name')); ?> </th>
								<th><?php echo e(trans('admin.qty')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$count_purchase_qty = $supply_qty = $available_qty = 0;

										$count_purchase_qty = array_sum(array_column($value['vhc_purchase_orders'], 'quantity'));
										$supply_qty = array_sum(array_column($value['vhc_supply_detail'], 'quantity'));
										$available_qty = $count_purchase_qty - $supply_qty;
									?>
									<tr>
										<td><?php echo e($value['commodity_name'] ?? ''); ?></td>
										<td>
											<?php if($available_qty > 0): ?>
												<span class="btn btn-success btn-sm"><?php echo e($available_qty ?? ''); ?></span>
											<?php else: ?>
												<span class="btn btn-danger btn-sm"><?php echo e($available_qty <=0 ? 'Out Of Stock' : ''); ?></span>
											<?php endif; ?>
										</td>
										<td class="text-center">
										<?php if($available_qty > 0): ?>  
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item action-edit" href="<?php echo e(Route('vhc_purchase_parts_create','')); ?>?id=<?php echo e(base64_encode($value['id'] ?? 0)); ?>"><?php echo e(trans('admin.purchase_part')); ?></a>
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
	});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/parts_stocks/index.blade.php ENDPATH**/ ?>
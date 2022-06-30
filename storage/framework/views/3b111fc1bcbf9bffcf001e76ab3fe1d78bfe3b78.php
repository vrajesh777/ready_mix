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
				<?php if($obj_user->hasPermissionTo('purchase-estimates-create')): ?>
                <li class="list-inline-item">
                    <a class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" href="<?php echo e(Route('estimate_create')); ?>"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.estimate')); ?></a>
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
					<table class="table table-striped table-nowrap custom-table mb-0" id="estimateTable">
						<thead>
							<tr>
								<th> <?php echo e(trans('admin.estimate')); ?> #</th>
								<th> <?php echo e(trans('admin.amount')); ?></th>
								<th> <?php echo e(trans('admin.vendor')); ?></th>
								<th> <?php echo e(trans('admin.purchase_request')); ?></th>
								<th> <?php echo e(trans('admin.date')); ?></th>
								<th> <?php echo e(trans('admin.expiry')); ?> <?php echo e(trans('admin.date')); ?></th>
								<?php if($obj_user->hasPermissionTo('purchase-estimates-update')): ?>
								<th> <?php echo e(trans('admin.status')); ?></th>
								<?php endif; ?>
								<th class="text-right notexport"> <?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($value['estimate_no'] ?? ''); ?></td>
										<td><?php echo e($value['total'] ?? ''); ?></td>
										<td><?php echo e($value['user_meta'][0]['meta_value'] ?? ''); ?></td>
										<td><?php echo e($value['pur_request']['purchase_request_name'] ?? ''); ?></td>
										<td><?php echo e($value['estimate_date'] ?? ''); ?></td>
										<td><?php echo e($value['expiry_date'] ?? ''); ?></td>
										<?php if($obj_user->hasPermissionTo('purchase-estimates-update')): ?>
										<td>
											<?php if($value['status'] == '1'): ?>
												<button type="button" class="btn btn-info btn-sm"><?php echo e(trans('admin.not_yet')); ?> <?php echo e(trans('admin.approve')); ?></button>
											<?php elseif($value['status'] == '2'): ?>
												<button type="button" class="btn btn-success btn-sm"><?php echo e(trans('admin.approved')); ?></button>
											<?php elseif($value['status'] == '3'): ?>
												<button type="button" class="btn btn-danger btn-sm"><?php echo e(trans('admin.reject')); ?></button>
											<?php endif; ?>
										</td>
										<?php endif; ?>
	
										<td class="text-center">
											<a class="dropdown-item" href="<?php echo e(Route('estimate_view',base64_encode($value['id']))); ?>"><i class="far fa-eye"></i></a>
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
		$('#estimateTable').DataTable({
			// "pageLength": 2
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '<?php echo e(Config::get('app.project.title')); ?> Estimate Group',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Estimate Group PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Estimate Group',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Estimate Group EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Estimate Group CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	})
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/purchase/estimate/index.blade.php ENDPATH**/ ?>
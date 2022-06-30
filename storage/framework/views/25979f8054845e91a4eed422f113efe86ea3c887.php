<?php $__env->startSection('main_content'); ?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<?php if($obj_user->hasPermissionTo('purchase-request-create')): ?>
	                <li class="list-inline-item">
	                    <a class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" href="<?php echo e(Route('purchase_request_create')); ?>"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.purchase_request')); ?></a>
	                </li>
                <?php endif; ?>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<div class="row">
	<div class="col-sm-12">
		<div class="card mb-0">
			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="purReqTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.requester')); ?> #</th>
								<th><?php echo e(trans('admin.purchase_request')); ?></th>
								<th><?php echo e(trans('admin.requester')); ?></th>
								<th><?php echo e(trans('admin.requested')); ?> <?php echo e(trans('admin.date')); ?></th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<?php if($obj_user->hasPermissionTo('purchase-request-update')): ?>
									<th class="notexport"><?php echo e(trans('admin.actions')); ?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0 ): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td>
											<?php echo e($data['purchase_request_code'] ?? ''); ?>

										</td>
										<td>
											<?php echo e($data['purchase_request_name'] ?? ''); ?>

										</td>
										<td><?php echo e($data['user_detail']['first_name'] ?? ''); ?> <?php echo e($data['user_detail']['last_name'] ?? ''); ?></td>
										<td><?php echo e(date('Y-m-d h:i A',strtotime($data['created_at']))); ?></td>
										<?php if($obj_user->hasPermissionTo('purchase-request-update')): ?>
										<td>
											<?php if($data['status'] == '1'): ?>
												<button type="button" class="btn btn-info btn-sm"><?php echo e(trans('admin.not_yet')); ?> <?php echo e(trans('admin.approve')); ?></button>
											<?php elseif($data['status'] == '2'): ?>
												<button type="button" class="btn btn-success btn-sm"><?php echo e(trans('admin.approved')); ?></button>
											<?php elseif($data['status'] == '3'): ?>
												<button type="button" class="btn btn-danger btn-sm"><?php echo e(trans('admin.reject')); ?></button>
											<?php endif; ?>
										</td>
										<?php endif; ?>
										<td class="text-center">
											<a class="dropdown-item" href="<?php echo e(Route('purchase_request_view',base64_encode($data['id']))); ?>"><i class="far fa-eye"></i></a>
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

<script type="text/javascript">
	$(document).ready(function(){
			$('#purReqTable').DataTable({
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
				title: '<?php echo e(Config::get('app.project.title')); ?> Purchase Request',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Purchase Request PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Purchase Request',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Purchase Request EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Purchase Request CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/purchase/purchase_request/index.blade.php ENDPATH**/ ?>
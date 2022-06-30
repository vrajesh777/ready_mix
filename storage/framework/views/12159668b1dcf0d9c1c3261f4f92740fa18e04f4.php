<div class="col-md-9">
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
					<thead>
						<tr>
							<th>Estimate #</th>
							<th>Subject</th>
							<th>Total</th>
							<th>Date</th>
							<th>Open Till</th>
							<th>Date Created</th>
							<th>Status</th>
							<th class="text-right notexport">Actions</th>
						</tr>
					</thead>
					<tbody>

						<?php if(isset($arr_estim) && !empty($arr_estim)): ?>

						<?php $__currentLoopData = $arr_estim; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						<?php
							$enc_id = base64_encode($estim['id']);

							$status = $estim['status']??'';
						?>

						<tr>
							<td>
								<a href="<?php echo e(Route('view_estimate', $enc_id)); ?>" target="_blank" ><?php echo e(format_sales_estimation_number($estim['id']) ?? 'N/A'); ?></a>
							</td>
							<td><?php echo e($estim['subject'] ?? 'N/A'); ?></td>
							<td><?php echo e(number_format($estim['grand_tot'],2) ?? 0); ?></td>
							<td><?php echo e($estim['date'] ?? 'N/A'); ?></td>
							<td><?php echo e($estim['open_till']); ?></td>
							<td><?php echo e(date('d-M-y h:i A', strtotime($estim['created_at']))); ?></td>
							<td><?php echo e(ucfirst($status)); ?></td>
                            <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" href="<?php echo e(Route('edit_estimate', $enc_id)); ?>">Edit</a>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('view_estimate', $enc_id)); ?>">View</a>
										<?php if($status == 'open'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_status', [$enc_id,'draft'])); ?>">Mark as Draft</a>
										<?php endif; ?>
										<?php if($status == 'draft' || $status == 'open'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_status', [$enc_id,'sent'])); ?>">Mark as Sent</a>
										<?php endif; ?>
										<?php if($status == 'draft' || $status == 'sent'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_status', [$enc_id,'open'])); ?>">Mark as Open</a>
										<?php endif; ?>
										<?php if($status == 'declined'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_status', [$enc_id,'revised'])); ?>">Mark as Revised</a>
										<?php endif; ?>
										<?php if($status == 'sent' || $status == 'revised'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_status', [$enc_id,'declined'])); ?>">Mark as Declined</a>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_status', [$enc_id,'accepted'])); ?>">Mark as Accepted</a>
										<?php endif; ?>
									</div>
								</div>
							</td>
						</tr>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<?php else: ?>

						<h3 align="center">No Records Found!</h3>

						<?php endif; ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#leadsTable').DataTable({
		});
	});
</script>
<?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/estimates.blade.php ENDPATH**/ ?>
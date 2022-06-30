<div class="col-md-9">
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
					<thead>
						<tr>
							<th><?php echo e(trans('admin.proposal')); ?> #</th>
							<th><?php echo e(trans('admin.amount')); ?></th>
							<th><?php echo e(trans('admin.total')); ?> <?php echo e(trans('admin.tax')); ?></th>
							<th><?php echo e(trans('admin.date')); ?></th>
							<th><?php echo e(trans('admin.expiry')); ?> <?php echo e(trans('admin.date')); ?></th>
							<th>Reference #</th>
							<th>Status</th>
							<th class="text-right notexport">Actions</th>
						</tr>
					</thead>
					<tbody>

						<?php if(isset($arr_props) && !empty($arr_props)): ?>

						<?php $__currentLoopData = $arr_props; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						<?php
							$enc_id = base64_encode($prop['id']);
							$status = $prop['status']??'';
							$tax_amnt = 0;

							foreach($prop['prop_details'] as $row) {
								$tot_price = $row['quantity']*$row['rate'];
								$tax_rate = $row['tax_rate'];
								$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
							}
						?>

						<tr>
							<td>
								<a href="<?php echo e(Route('view_proposal', $enc_id)); ?>" target="_blank"><?php echo e(format_proposal_number($prop['id']) ?? 'N/A'); ?></a>
							</td>
							<td><?php echo e(number_format($prop['net_total'],2) ?? 'N/A'); ?></td>
							<td><?php echo e(number_format($tax_amnt,2) ?? 'N/A'); ?></td>
							<td><?php echo e($prop['date'] ?? 'N/A'); ?></td>
							<td><?php echo e($prop['expiry_date'] ?? ''); ?></td>
							<td><?php echo e($prop['ref_num'] ?? 'N/A'); ?></td>
							<td><?php echo e(ucfirst($status)); ?></td>
                            <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" href="<?php echo e(Route('edit_proposal', $enc_id)); ?>">Edit</a>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('view_proposal', $enc_id)); ?>">View</a>
										<?php if($status == 'open'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'draft'])); ?>">Mark as Draft</a>
										<?php endif; ?>
										<?php if($status == 'draft' || $status == 'open'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'sent'])); ?>">Mark as Sent</a>
										<?php endif; ?>
										<?php if($status == 'draft' || $status == 'sent'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'open'])); ?>">Mark as Open</a>
										<?php endif; ?>
										<?php if($status == 'declined'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'revised'])); ?>">Mark as Revised</a>
										<?php endif; ?>
										<?php if($status == 'sent' || $status == 'revised'): ?>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'declined'])); ?>">Mark as Declined</a>
										<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'accepted'])); ?>">Mark as Accepted</a>
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
</script><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/proposals.blade.php ENDPATH**/ ?>
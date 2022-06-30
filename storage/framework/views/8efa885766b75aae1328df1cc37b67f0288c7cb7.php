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
						<th><?php echo e(trans('admin.status')); ?></th>
						<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php if(isset($arr_invoices) && !empty($arr_invoices)): ?>

					<?php $__currentLoopData = $arr_invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

					<?php
						$enc_id = base64_encode($invoice['id']);
						$tax_amnt = 0;

						$order = $invoice['order']??[];
						$ord_details = $order['ord_details']??[];
						$cust_details = $order['cust_details']??[];

						foreach($ord_details as $row) {
							$tot_price = $row['quantity']*$row['rate'];
							$tax_rate = $row['tax_rate'];
							$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
						}
					?>

					<tr>
						<td>
							<a href="<?php echo e(Route('view_invoice', $enc_id)); ?>" target="_blank"><?php echo e(format_sales_invoice_number($invoice['id']) ?? 'N/A'); ?></a>
						</td>
						<td><?php echo e($invoice['net_total'] ?? 'N/A'); ?></td>
						<td><?php echo e($tax_amnt ?? 'N/A'); ?></td>
						<td><?php echo e($invoice['invoice_date'] ?? 'N/A'); ?></td>
						<td><?php echo e($invoice['due_date'] ?? ''); ?></td>
						<td><?php echo e(ucfirst($invoice['status']) ?? 'N/A'); ?></td>
                        <td class="text-center">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
									
									<a class="dropdown-item action-edit" href="<?php echo e(Route('view_invoice', $enc_id)); ?>">View</a>
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


</script><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/invoices.blade.php ENDPATH**/ ?>
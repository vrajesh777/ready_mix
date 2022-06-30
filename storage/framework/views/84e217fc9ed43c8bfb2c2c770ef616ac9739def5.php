<?php $__env->startSection('main_content'); ?>
<!-- Page Header -->

<?php

$grand_tot = $net_tot = $tot_tax = 0;

$status = $arr_props['status']??'';

$enc_id = base64_encode($arr_props['id']);

?>


<div class="row">

	<div class="col-sm-12">

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># <?php echo e(format_proposal_number($arr_props['id'])); ?></h4>
			<div class="col-md-4">
				<button type="button" class="border-0 btn btn-primary mb-2 btn-sm dropdown-toggle" id="downActionBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf"></i></button>
				<div class="dropdown-menu" aria-labelledby="downActionBtn">
					<a class="dropdown-item" href="<?php echo e(Route('dowload_proposal', $enc_id)); ?>"><?php echo e(trans('admin.view_pdf')); ?></a>
					<a class="dropdown-item" href="<?php echo e(Route('dowload_proposal', $enc_id)); ?>" target="_blank"><?php echo e(trans('admin.view_pdf_in_new_tab')); ?></a>
					<a class="dropdown-item" href="<?php echo e(Route('dowload_proposal', $enc_id)); ?>" download=""><?php echo e(trans('admin.download')); ?></a>
				</div>
				<?php if($obj_user->hasPermissionTo('sales-proposals-update')): ?>
					<?php if(isset($arr_props['status']) && $arr_props['status'] == 'accepted'): ?>
						<a class="border-0 btn btn-sm btn-info mb-2" href="<?php echo e(Route('create_order',['est'=>base64_encode($arr_props['id'])])); ?>" ><?php echo e(trans('admin.convert_to_order')); ?></a>
					<?php endif; ?>

					<a class="border-0 btn btn-sm btn-info mb-2" href="<?php echo e(Route('send_prop_email',$enc_id)); ?>" data-toggle="tooltip" data-placement="bottom" title="Send to Email" ><i class="fa fa-envelope"></i></a>
					<?php if($status == 'sent' || $status == 'revised'): ?>
					<a class="border-0 btn btn-sm btn-success mb-2" href="<?php echo e(Route('change_inv_status', [$enc_id,'accepted'])); ?>" ><i class="fa fa-check"></i><?php echo e(trans('admin.accept')); ?> </a>
					<a class="border-0 btn btn-sm btn-danger mb-2" href="<?php echo e(Route('change_inv_status',[$enc_id,'declined'])); ?>"><i class="fa fa-times"></i><?php echo e(trans('admin.reject')); ?> </a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>	
		<div class="row">
			<div class="col-sm-8">
				<div class="card">
				<div class="card-body">
	                <div class="table-responsive">
		               	<table class="table">
		               		<thead>
		               			<tr>
		               				<th>#</th>
		               				<th width="50%"><?php echo e(trans('admin.item')); ?></th>
		               				<th><?php echo e(trans('admin.qty')); ?></th>
		               				<th><?php echo e(trans('admin.rate')); ?></th>
		               				<th width="12%"><?php echo e(trans('admin.net_total')); ?></th>
		               				<th width="12%"><?php echo e(trans('admin.tax')); ?></th>
		               				<th width="13%"><?php echo e(trans('admin.amount')); ?></th>
		               			</tr>
		               		</thead>
		               		<tbody>
		               			<?php if(isset($arr_props['prop_details']) && !empty($arr_props['prop_details'])): ?>
		               			<?php $__currentLoopData = $arr_props['prop_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		               			<?php
		               				$prod_det = $row['product_details'] ?? [];
		               				$tax_det = $prod_det['tax_detail'] ?? [];

		               				$tot_before_tax = $row['rate']*$row['quantity'];

		               				$net_tot += $tot_before_tax;

		               				$tax_amnt = round($tax_det['tax_rate'] * ($tot_before_tax / 100),2);
		               				$tot_tax += $tax_amnt;

		               				$tot_after_tax = $tot_before_tax + $tax_amnt;

		               				$grand_tot += $tot_after_tax;
		               			?>
		               			<tr>
		               				<td align="center"><?php echo e(++$index); ?></td>
		               				<td class="description">
		               					<span><strong><?php echo e($prod_det['name'] ?? ''); ?></strong></span><br>
		               					<span><?php echo e($prod_det['description']); ?></span>
		               				</td>
		               				<td><?php echo e($row['quantity'] ?? ''); ?></td>
		               				<td><?php echo e(isset($row['rate'])?number_format($row['rate'],2):''); ?></td>
		               				<td><?php echo e(number_format($tot_before_tax,2)); ?></td>
		               				<td><?php echo e($tax_det['name'] ?? ''); ?> <?php echo e($tax_det['tax_rate']); ?>%<br></td>
		               				<td><?php echo e(number_format($tot_after_tax,2)); ?></td>
		               			</tr>
		               			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				                <tr>
									<td colspan="6" class="text-right font-weight-normal"><?php echo e(trans('admin.sub_total')); ?></td>
									<td colspan="1" class="subtotal font-weight-normal"><?php echo e(format_price($net_tot)); ?></td>
				                </tr>
				                <tr>
				                	<td colspan="6" class="text-right font-weight-normal"><?php echo e(trans('admin.total')); ?> <?php echo e(trans('admin.tax')); ?></td>
				                	<td colspan="1" class="font-weight-normal"><?php echo e(format_price($tot_tax)); ?></td>
				                </tr>
				                <tr>
									<td colspan="6" class="font-weight-bold text-right"><?php echo e(trans('admin.total')); ?></td>
									<td colspan="1" class="font-weight-bold"><?php echo e(format_price($grand_tot)); ?> </td>
				                </tr>
				                <?php endif; ?>
				            </tbody>
		            	</table>
	                </div> 	
			 	</div>
		 		</div>
       		</div>
            <div class="col-md-4 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0"><?php echo e(trans('admin.summary')); ?></h3>
						 	<p class="font-weight-bold"><?php echo e(trans('admin.to')); ?> </p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	<?php echo e($arr_props['cust_details']['first_name'] ?? ''); ?>&nbsp;
							 	<?php echo e($arr_props['cust_details']['last_name'] ?? ''); ?>

							 	</b><br>
								<span class="billing_street"><?php echo e($arr_props['billing_street']??''); ?></span><br>
								<span class="billing_city"><?php echo e($arr_props['billing_city']??''); ?></span>,
								<span class="billing_state"><?php echo e($arr_props['billing_state']??''); ?></span>
								<br>
								<span class="billing_zip"><?php echo e($arr_props['billing_zip']??''); ?></span>
							</address>
							<?php if($arr_props['include_shipping'] == '1'): ?>
							<p class="font-weight-bold"> Ship to:</p>
							<address class="no-margin proposal-html-info">
							 	<b>
							 	<?php echo e($arr_props['cust_details']['first_name'] ?? ''); ?>&nbsp;
							 	<?php echo e($arr_props['cust_details']['last_name'] ?? ''); ?>

							 	</b><br>
								<span class="shipping_street"><?php echo e($arr_props['shipping_street']??''); ?></span><br>
								<span class="shipping_city"><?php echo e($arr_props['shipping_city']??''); ?></span>,
								<span class="shipping_state"><?php echo e($arr_props['shipping_state']??''); ?></span>
								<br>
								<span class="shipping_zip"><?php echo e($arr_props['shipping_zip']??''); ?></span>
							</address>
							<?php endif; ?>
						<h4 class="font-weight-bold mbot30"><?php echo e(trans('admin.total')); ?> <?php echo e(format_price($grand_tot)); ?></h4>
						<ul class="personal-info">
							<li>
								<div class="title"><?php echo e(trans('admin.status')); ?></div>
								<div class="text"><?php echo e(strtoupper($arr_props['status'])); ?></div>
							</li>
							<li>
								<div class="title"><?php echo e(trans('admin.date')); ?></div>
								<div class="text"><?php echo e($arr_props['date'] ?? 'N/A'); ?></div>
							</li>
							<li>
								<div class="title"><?php echo e(trans('admin.expiry')); ?> <?php echo e(trans('admin.date')); ?></div>
								<div class="text"><?php echo e($arr_props['expiry_date'] ?? 'N/A'); ?></div>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
        </div>
	</div>

	

</div>
<!-- /Page Header -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/proposals/view.blade.php ENDPATH**/ ?>
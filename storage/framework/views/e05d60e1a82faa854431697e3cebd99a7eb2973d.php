<?php $__env->startSection('main_content'); ?>
<!-- Page Header -->
<div class="row">

	<div class="col-sm-12">

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># <?php echo e($arr_contract['contract_no']); ?></h4>
			<div class="col-md-4">
				
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
		               				<th><?php echo e(trans('admin.item')); ?></th>
									<th><?php echo e(trans('admin.OPC_1')); ?></th>
									<th><?php echo e(trans('admin.SRC_1')); ?></th>
									<th><i class="fas fa-cog"></i></th>
		               			</tr>
		               		</thead>
		               		<tbody>
		               			<?php if(isset($arr_contract['contr_details']) && !empty($arr_contract['contr_details'])): ?>
			               			<?php $__currentLoopData = $arr_contract['contr_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			               			<tr>
			               				<td align="center"><?php echo e(++$index); ?></td>
			               				<td class="description">
			               					<span><strong><?php echo e($row['product_details']['name'] ?? ''); ?></strong></span><br>
			               					<span><?php echo e($row['product_details']['description']); ?></span>
			               				</td>
			               				
			               				<td><?php echo e(isset($row['opc_1_rate'])?number_format($row['opc_1_rate'],2):''); ?></td>
			               				<td><?php echo e(isset($row['src_5_rate'])?number_format($row['src_5_rate'],2):''); ?></td>
			               				
			               			</tr>
			               			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
					 	<p class="font-weight-bold"><?php echo e(trans('admin.customer')); ?>  : <?php echo e($arr_contract['cust_details']['first_name'] ?? ''); ?>&nbsp;
						 	<?php echo e($arr_contract['cust_details']['last_name'] ?? ''); ?></p>
						<p class="font-weight-bold"> Site : <?php echo e($arr_contract['title'] ?? ''); ?></p>
						<p class="font-weight-bold"> Location : <?php echo e($arr_contract['site_location'] ?? ''); ?></p>
					</div>
				</div>
			</div>
        </div>
        <div class="row">
        	<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0"><?php echo e(trans('admin.admin_note')); ?></h3>
					 	<p><?php echo e($arr_contract['admin_note'] ?? ''); ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0"><?php echo e(trans('admin.client_note')); ?></h3>
					 	<p><?php echo e($arr_contract['client_note'] ?? ''); ?></p>
					</div>
				</div>
			</div>
			<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0"><?php echo e(trans('admin.terms_&_conditions')); ?></h3>
					 	<p><?php echo e($arr_contract['terms_conditions'] ?? ''); ?></p>
					</div>
				</div>
			</div>

			<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">

						<div class="table-responsive">
			               	<table class="table">
			               		<thead>
			               			<tr>
			               				<th width="4%">#</th>
			               				<th width="50%"><?php echo e(trans('admin.document')); ?></th>
			               				<th width="27%"><?php echo e(trans('admin.actions')); ?></th>
			               			</tr>
			               		</thead>
			               		<tbody>
			               			<tr>
			               				<td>1</td>
			               				<td><?php echo e(trans('admin.contract')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['contract']) && $arr_contract['contract_attch']['contract'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['contract'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['contract'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>2</td>
			               				<td><?php echo e(trans('admin.quotation')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['quotation']) && $arr_contract['contract_attch']['quotation'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['quotation'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['quotation'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>3</td>
			               				<td><?php echo e(trans('admin.baladiya_permission')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['bala_per']) && $arr_contract['contract_attch']['bala_per'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['bala_per'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['bala_per'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>4</td>
			               				<td><?php echo e(trans('admin.owner_id')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['owner_id']) && $arr_contract['contract_attch']['owner_id'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['owner_id'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['owner_id'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>5</td>
			               				<td><?php echo e(trans('admin.credit_form')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['credit_form']) && $arr_contract['contract_attch']['credit_form'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['credit_form'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['credit_form'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>6</td>
			               				<td><?php echo e(trans('admin.purchase_order')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['purchase_order']) && $arr_contract['contract_attch']['purchase_order'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['purchase_order'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['purchase_order'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>7</td>
			               				<td><?php echo e(trans('admin.pay_grnt')); ?></td>
			               				<td>
			               					<?php if(isset($arr_contract['contract_attch']['pay_grnt']) && $arr_contract['contract_attch']['pay_grnt'] !=''): ?>
												<?php if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['pay_grnt'])): ?>
													<a target="_blank" download href="<?php echo e($cust_att_public_path); ?><?php echo e($arr_contract['contract_attch']['pay_grnt'] ?? ''); ?>"><i class="fa fa-download"></i></a>
												<?php endif; ?>	
											<?php endif; ?>
			               				</td>
			               			</tr>


					            </tbody>
			            	</table>
		                </div> 	
							

					</div>
				</div>
			</div>

        </div>
	</div>

</div>
<!-- /Page Header -->


<script type="text/javascript">

	$(document).ready(function(){

	});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/contract/view.blade.php ENDPATH**/ ?>
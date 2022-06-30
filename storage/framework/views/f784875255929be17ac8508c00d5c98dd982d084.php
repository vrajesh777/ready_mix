<?php $__env->startSection('main_content'); ?>

<div class="row align-items-center">
	<h4 class="col-md-6 card-title mt-0 mb-2"><?php echo e(trans('admin.purchase_request')); ?> <?php echo e(trans('admin.information')); ?> </h4>
	<?php if($obj_user->hasPermissionTo('purchase-request-update')): ?>
	<div class="col-md-6 justify-content-end d-flex align-items-center">
		<div class="form-group mr-2 mb-2 related_wrapp">
            <select name="status" class="select select2" id="status" data-rule-required="true">
            	<option value=""><?php echo e(trans('admin.change')); ?> <?php echo e(trans('admin.status')); ?> <?php echo e(trans('admin.to')); ?></option>
				<option value="1" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '1'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.not_yet')); ?> <?php echo e(trans('admin.approve')); ?></option>
				<option value="2" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '2'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.approved')); ?></option>
				<option value="3" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '3'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.reject')); ?></option>
			</select>
		</div>
	</div>
	<?php endif; ?>
</div>

<div class="row">
	<div class="col-sm-12">
		<!-- <div class="card mb-0">
			<div class="card-body"> -->
				<div class="row">
					<div class="col-md-6 d-flex">
						<div class="card profile-box flex-fill">
							<div class="card-body">
								<h3 class="card-title border-bottom pb-2 mt-0 mb-3"><?php echo e(trans('admin.general_info')); ?></h3>
								<ul class="personal-info border rounded">
									<li>
										<div class="title"><?php echo e(trans('admin.request_code')); ?></div>
										<div class="text"><?php echo e($arr_data['purchase_request_code'] ?? ''); ?></div>
									</li>
									<li>
										<div class="title"><?php echo e(trans('admin.request_name')); ?></div>
										<div class="text"><?php echo e($arr_data['purchase_request_name'] ?? ''); ?></div>
									</li>
									<li>
										<div class="title"><?php echo e(trans('admin.request_time')); ?></div>
										<div class="text"><?php echo e(date('Y-m-d h:i A',strtotime($arr_data['created_at'])) ?? ''); ?></div>
									</li>
									<li>
										<div class="title"><?php echo e(trans('admin.description')); ?></div>
										<div class="text"><?php echo e($arr_data['description'] ?? ''); ?></div>
									</li>									
								</ul>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 d-flex">
						<div class="card profile-box flex-fill">
							<div class="card-body">
								<div class="tab-content">
									<div class="tab-pane active show" id="inventory-stock">
										<div class="table-responsive">
											<table class="table table-stripped mb-0 datatables">
												<thead>
													<tr>
														<th><?php echo e(trans('admin.items')); ?></th>
														<th><?php echo e(trans('admin.unit')); ?></th>
														<th><?php echo e(trans('admin.unit_price')); ?></th>
														<th><?php echo e(trans('admin.qty')); ?></th>
														<th><?php echo e(trans('admin.total')); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php if(isset($arr_data['purchase_request_details']) && sizeof($arr_data['purchase_request_details'])>0): ?>
														<?php $__currentLoopData = $arr_data['purchase_request_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<tr>
																<td><?php echo e($details['item_detail']['commodity_code']); ?>-<?php echo e($details['item_detail']['commodity_name'] ?? ''); ?></td>
																<td>Unit</td>
																<td><?php echo e(number_format($details['unit_price'],2) ?? ''); ?></td><?php echo e(trans('admin.purchase_request')); ?>

																<td><?php echo e($details['tax_detail']['name'] ?? ''); ?></td>
																<td><?php echo e(number_format($details['total'],2) ?? ''); ?></td>
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
					</div>
					
				</div>
			<!-- </div>
		</div> -->
	</div>
</div>
<script type="text/javascript">
	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	var pur_req_id = "<?php echo e($arr_data['id'] ?? ''); ?>";
	var token = "<?php echo e(csrf_token()); ?>";
	$('#status').change(function(){
		var status = $(this).val();
		$.ajax({
			url:module_url_path+'/pur_req_change_status/'+btoa(pur_req_id),
			data:{status:btoa(status),_token:token},
			type:'POST',
			dataType:'json',
			success:function(response)
			{
				if(response.status == 'success')
				{
					common_ajax_store_action(response);
				}
			}
		})
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/purchase/purchase_request/view.blade.php ENDPATH**/ ?>
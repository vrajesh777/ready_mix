<?php $__env->startSection('main_content'); ?>

<?php

$total_left_to_pay = $arr_data['total'] ?? 0;
if(isset($arr_data['vendor_payment']) && sizeof($arr_data['vendor_payment'])>0)
{
	foreach ($arr_data['vendor_payment'] as $pay_value) 
	{
		$total_left_to_pay = $total_left_to_pay - $pay_value['amount'];
	}
}
?>

<div class="row align-items-center">
	<h4 class="col-md-6 card-title mt-0 mb-2"><?php echo e(trans('admin.purchase_order')); ?>  : #<?php echo e($arr_data['order_number'] ?? ''); ?> - <?php echo e($arr_data['name'] ?? ''); ?></h4>

	<div class="col-md-6 justify-content-end d-flex align-items-center">
		<?php if($obj_user->hasPermissionTo('purchase-orders-update')): ?>
			<?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] != '2'): ?>
				<div class="form-group mr-2 mb-2 related_wrapp">
		            <select name="status" class="select select2" id="status" data-rule-required="true">
		            	<option value=""><?php echo e(trans('admin.change')); ?> <?php echo e(trans('admin.status')); ?> <?php echo e(trans('admin.to')); ?></option>
						<option value="1" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '1'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.not_yet')); ?> <?php echo e(trans('admin.approve')); ?></option>
						<option value="2" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '2'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.approved')); ?></option>
						<option value="3" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '3'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.reject')); ?></option>
						<option value="4" <?php if(isset($arr_data['status']) && $arr_data['status']!='' && $arr_data['status'] == '4'): ?> disabled <?php endif; ?>><?php echo e(trans('admin.cancel')); ?></option>					
					</select>
				</div>
			<?php endif; ?>

			<?php if($total_left_to_pay > 0): ?>
				<a href="javascript:void(0)" class="border-0 btn btn-success btn-gradient-success btn-rounded mb-2" data-toggle="modal" data-target="#payment_model" ><i class="fa fa-plus-square"></i> <?php echo e(trans('admin.payment')); ?></a>
			<?php endif; ?>
			
		<?php endif; ?>
		

		<a href="<?php echo e(Route('dowload_purchase_order', base64_encode($arr_data['id']))); ?>" class="border-0 btn btn-primary btn-gradient-primary btn-rounded mb-2" target="_blank"><?php echo e(trans('admin.download')); ?></a>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="row">
			
			<div class="col-md-12 d-flex">

				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h4 class="card-title mt-0 mb-2"><?php echo e(trans('admin.items')); ?> <?php echo e(trans('admin.details')); ?></h4>
						<div class="tab-content">
							<div class="tab-pane active show" id="inventory-stock">
								<div class="table-responsive">
									<table class="table table-striped table-nowrap custom-table mb-0 datatable">
										<thead>
											<tr>
												<th><?php echo e(trans('admin.items')); ?></th>
												<th><?php echo e(trans('admin.unit_price')); ?></th>
												<th><?php echo e(trans('admin.qty')); ?></th>
												<th><?php echo e(trans('admin.sub_total')); ?></th>
												<th><?php echo e(trans('admin.tax')); ?></th>
												<th><?php echo e(trans('admin.discount')); ?></th>
												<th><?php echo e(trans('admin.discount')); ?>(money)</th>
												<th><?php echo e(trans('admin.total')); ?></th>
											</tr>
										</thead>

										<tbody>
											<?php if(isset($arr_data['purchase_order_details']) && sizeof($arr_data['purchase_order_details'])>0): ?>
												<?php $__currentLoopData = $arr_data['purchase_order_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

													<tr>
														<td><?php echo e($details['item_detail']['commodity_code']); ?>-<?php echo e($details['item_detail']['commodity_name'] ?? ''); ?></td>
														<td><?php echo e(number_format($details['unit_price'],2) ?? ''); ?></td>
														<td><?php echo e($details['quantity'] ?? ''); ?></td>
														<td><?php echo e(number_format($details['net_total'],2) ?? ''); ?></td>
														<td>
															<?php
																$tax = 0;
																if(isset($details['net_total_after_tax']) && $details['net_total_after_tax']!='' || $details['net_total_after_tax']!=0)
																{
																	$tax = $details['net_total_after_tax'] - $details['net_total'];
																}
															?>
															<?php echo e(number_format( $tax,2) ?? ''); ?>

														</td>
														<td><?php echo e(number_format( $details['discount_per'],2) ?? ''); ?></td>
														<td><?php echo e(number_format($details['discount_money'],2) ?? ''); ?></td>
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
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-md-12 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h4 class="card-title mt-0 mb-2"><?php echo e(trans('admin.payment')); ?> <?php echo e(trans('admin.record')); ?></h4>
						<div class="tab-content">
							<div class="tab-pane active show" id="inventory-stock">
								<div class="table-responsive">
									<table class="table table-striped table-nowrap custom-table mb-0 datatable">
										<thead>
											<tr>
												<th><?php echo e(trans('admin.amount')); ?></th>
												<th><?php echo e(trans('admin.payment_mode')); ?></th>
												<th><?php echo e(trans('admin.transaction_id')); ?></th>
												<th><?php echo e(trans('admin.date')); ?></th>
											</tr>
										</thead>

										<tbody>
											<?php if(isset($arr_payment) && sizeof($arr_payment)>0): ?>
												<?php $__currentLoopData = $arr_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

													<tr>
														<td><?php echo e(number_format($payment['amount'],2) ?? ''); ?></td>
														<td><?php echo e($payment['payment_method_detail']['name'] ?? ''); ?></td>
														<td><?php echo e($payment['trans_id'] ?? ''); ?></td>
														<td><?php echo e($payment['pay_date'] ?? ''); ?></td>
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
	</div>
</div>

<!-- Modal -->
<div class="modal fade right" id="payment_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center"><?php echo e(trans('admin.record_payment_for')); ?> #<?php echo e($arr_data['order_number'] ?? ''); ?> - <?php echo e($arr_data['name'] ?? ''); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="<?php echo e(Route('add_po_payment',base64_encode($arr_data['id']))); ?>" id="add_payment">

					<?php echo e(csrf_field()); ?>

					<div class="row">
				        <div class="form-group col-md-6">
							<label class="col-form-label"><?php echo e(trans('admin.amount_received')); ?> <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" max="<?php echo e($total_left_to_pay ?? '00'); ?>" value="<?php echo e($total_left_to_pay ?? '00'); ?>" class="form-control" placeholder="<?php echo e(trans('admin.amount_received')); ?>" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label><?php echo e(trans('admin.transaction_id')); ?></label>
							<input type="text" class="form-control" name="trans_id" placeholder="<?php echo e(trans('admin.transaction_id')); ?>">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label"><?php echo e(trans('admin.payment_date')); ?> <span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="<?php echo e(date('Y-m-d')); ?>" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label"><?php echo e(trans('admin.payment_mode')); ?> <span class="text-danger">*</span></label></label>
	                        <select class="select" name="pay_method_id" data-rule-required="true">
								<option value=""><?php echo e(trans('admin.no_selected')); ?></option>
								<?php if(isset($arr_pay_methods) && !empty($arr_pay_methods)): ?>
									<?php $__currentLoopData = $arr_pay_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($method['id']); ?>"><?php echo e($method['name'] ?? ''); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
							<label id="pay_method_id-error" class="error" for="pay_method_id"></label>
							<label class="error" id="pay_method_id_error"></label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label"><?php echo e(trans('admin.leave_a_note')); ?> </label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="<?php echo e(trans('admin.leave_a_note')); ?>" ></textarea>
	                        <label class="error" id="note_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></button>
		                </div>
				           
				        </div>
					</div>

				</form>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<script type="text/javascript">
	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	var order_no = "<?php echo e($arr_data['id'] ?? ''); ?>";
	var token = "<?php echo e(csrf_token()); ?>";
	$('#status').change(function(){
		var status = $(this).val();
		$.ajax({
			url:module_url_path+'/po_change_status/'+btoa(order_no),
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

<script type="text/javascript">

	$(document).ready(function(){

		$('#add_payment').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#add_payment").submit(function(e) {

			e.preventDefault();

			if($(this).valid()) {

				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#payment_model").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#payment_model')[0].reset();
	}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/purchase/purchase_order/view.blade.php ENDPATH**/ ?>
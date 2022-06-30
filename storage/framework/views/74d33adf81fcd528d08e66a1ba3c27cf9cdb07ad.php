<div class="col-sm-9">
	<div class="col text-right">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <a href="<?php echo e(Route('cust_create_contract',['id'=>$enc_id])); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.account')); ?></a>
            </li>
        </ul>
	</div>
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0 datatable">
					<thead>
						<tr>
							<th><?php echo e(trans('admin.contract')); ?> #</th>
							<th><?php echo e(trans('admin.title')); ?></th>
							<th><?php echo e(trans('admin.status')); ?></th>
							<th><?php echo e(trans('admin.actions')); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php if(isset($arr_contract) && sizeof($arr_contract)>0 ): ?>
							<?php $__currentLoopData = $arr_contract; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($data['contract_no'] ?? ''); ?></td>
									<td><?php echo e($data['title'] ?? ''); ?> <?php echo e($data['last_name'] ?? ''); ?></td>
									<td><?php echo e($data['status'] ?? ''); ?></td>
									<td class="text-center">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item action-edit" href="<?php echo e(Route('cust_edit_contract',  base64_encode($data['id']))); ?>"><?php echo e(trans('admin.edit')); ?></a>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('cust_view_contract', base64_encode($data['id']))); ?>"><?php echo e(trans('admin.view')); ?></a>
												<a class="dropdown-item pay_mod" href="javascript:void(0);" id="pay_mod" data-toggle="modal" data-target="#payment_model" data-cust-id="<?php echo e($data['cust_id'] ?? ''); ?>" data-contract-id="<?php echo e($data['id'] ?? ''); ?>"><?php echo e(trans('admin.payment')); ?></a>
											</div>
										</div>
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

<!-- Modal -->
<div class="modal fade right" id="payment_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.payment')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="<?php echo e(Route('add_contract_payment')); ?>" id="add_payment">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="enc_id" id="enc_id">
					<input type="hidden" name="cust_id" id="cust_id">
					<div class="row">
				        <div class="form-group col-md-6">
							<label class="col-form-label"><?php echo e(trans('admin.amount_received')); ?> <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" min="1" class="form-control" placeholder="Enter Amount" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label><?php echo e(trans('admin.transaction_id')); ?></label>
							<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label"><?php echo e(trans('admin.payment_date')); ?> <span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="<?php echo e(date('Y-m-d')); ?>" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label"><?php echo e(trans('admin.payment_mode')); ?><span class="text-danger">*</span></label></label>
	                        <select class="select" name="pay_method_id" data-rule-required="true">
								<option value="">No Selected</option>
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
							<label class="col-form-label"> <?php echo e(trans('admin.leave_a_note')); ?> </label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="Note" ></textarea>
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
	$(document).ready(function() {
		$('.pay_mod').click(function(){
			var id = $(this).data('contract-id');
			var cust_id = $(this).data('cust-id');
			$('input[name="enc_id"]').val(btoa(id));
			$('input[name="cust_id"]').val(cust_id);
		});

		$('#add_payment').validate({});
	});
</script>
<?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/account.blade.php ENDPATH**/ ?>
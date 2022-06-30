<div class="col-md-9">

	<div class="col text-right">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <a href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" data-toggle="modal" data-target="#payment_model" onclick="form_reset()">Add Payment</a>
            </li>
        </ul>
	</div>

	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
					<thead>
						<tr>
							<th><?php echo e(trans('admin.sr_no')); ?></th>
							<th><?php echo e(trans('admin.transaction_id')); ?></th>
							<th><?php echo e(trans('admin.amount')); ?></th>
							<th><?php echo e(trans('admin.payment_mode')); ?></th>
							<th><?php echo e(trans('admin.type')); ?></th>
							<th><?php echo e(trans('admin.date')); ?></th>
							
						</tr>
					</thead>
					<tbody>

						<?php if(isset($arr_inv_pay) && !empty($arr_inv_pay)): ?>

						<?php $__currentLoopData = $arr_inv_pay; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						<?php
							$enc_id = base64_encode($row['id']);
						?>

						<tr>
							<td><?php echo e($key+1); ?></td>
							<td><?php echo e($row['trans_no'] ?? 'N/A'); ?></td>
							<td><?php echo e(format_price($row['amount']) ?? 'N/A'); ?></td>
							<td><?php echo e($row['pay_method_details']['name'] ?? 'N/A'); ?></td>
							<td><?php echo e($row['type'] ?? ''); ?></td>
							<td><?php echo e($row['pay_date'] ?? ''); ?></td>
							
						</tr>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<?php else: ?>

						<h3 align="center"><?php echo e(trans('admin.no_record_found')); ?></h3>

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
                <h4 class="modal-title text-center">Add Payment</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<form method="POST" action="<?php echo e(Route('add_contract_payment')); ?>" id="add_payment">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="cust_id" value="<?php echo e($id ?? 0); ?>">
					<div class="row">

						<div class="form-group col-sm-6">
							<label class="col-form-label">Account<span class="text-danger">*</span></label></label>
	                        <select class="select" name="enc_id" data-rule-required="true">
								<option value="">Select</option>
								<?php if(isset($arr_contract) && !empty($arr_contract)): ?>
									<?php $__currentLoopData = $arr_contract; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e(base64_encode($contract['id'] ?? 0)); ?>"><?php echo e($contract['contract_no'] ?? ''); ?> <?php echo e($contract['site_location'] ?? ''); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
							<label id="enc_id-error" class="error" for="enc_id"></label>
							<label class="error" id="enc_id_error"></label>
						</div>

				        <div class="form-group col-md-6">
							<label class="col-form-label">Amount Received <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" min="1" class="form-control" placeholder="Enter Amount" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>Transaction ID</label>
							<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label">Payment Date <span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="<?php echo e(date('Y-m-d')); ?>" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">Payment Mode <span class="text-danger">*</span></label></label>
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
							<label class="col-form-label"> Leave a note </label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="Note" ></textarea>
	                        <label class="error" id="note_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded closeForm">Cancel</button>
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
		$('#leadsTable').DataTable({
		});

		$('.closeForm').click(function(){
			$("#add_payment").modal('hide');
			form_reset();
		});

		$('#add_payment').validate({});

	});

	function form_reset() {
		$('#add_payment')[0].reset();
	}
</script><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/payments.blade.php ENDPATH**/ ?>
<?php $__env->startSection('main_content'); ?>

<?php
	$count = isset($arr_data['vhc_part_detail'])?count($arr_data['vhc_part_detail']):0;
?>
<form method="POST" action="<?php echo e(Route('vhc_repair_update',$enc_id)); ?>" id="formAddUser" enctype="multipart/form-data">
<?php echo e(csrf_field()); ?>

	<div class="row">
		<div class="col-sm-12">

			<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.vehicle')); ?> <span class="text-danger">*</span></label>
	                            <select name="vechicle_id" class="select2" id="vechicle_id" data-rule-required="true" disabled>
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.vehicle')); ?></option>
									<?php if(isset($arr_vechicle) && sizeof($arr_vechicle)>0): ?>
										<?php $__currentLoopData = $arr_vechicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vechicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($vechicle['id'] ?? ''); ?>" <?php if(isset($arr_data['vechicle_id']) && $arr_data['vechicle_id']!='' && $arr_data['vechicle_id'] == $vechicle['id']): ?> selected <?php endif; ?>><?php echo e($vechicle['name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('vechicle_id')); ?></div>
	    					</div>
						</div>
						<input type="hidden" name="vechicle_id" value="<?php echo e($arr_data['vechicle_id'] ?? 0); ?>">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.assignee')); ?> <span class="text-danger">*</span></label>
	                            <select name="assignee_id" class="select2" id="assignee_id" data-rule-required="true" disabled>
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.assignee')); ?></option>
									<?php if(isset($arr_mechanics) && sizeof($arr_mechanics)>0): ?>
										<?php $__currentLoopData = $arr_mechanics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mechanic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($mechanic['id'] ?? ''); ?>" <?php if(isset($arr_data['assignee_id']) && $arr_data['assignee_id']!='' && $arr_data['assignee_id'] == $mechanic['id']): ?> selected <?php endif; ?>>
												<?php if(\App::getLocale() == 'ar'): ?>
													<span><?php echo e($mechanic['first_name'] ?? ''); ?></span>
												<?php else: ?>
													<span> <?php echo e($mechanic['last_name'] ?? ''); ?></span>
												<?php endif; ?>
											</option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('vechicle_id')); ?></div>
	    					</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.delivery_date')); ?><span class="text-danger">*</span></label>
	                            <input class="form-control datepicker pr-5" name="delivery_date" value="<?php echo e($arr_data['delivery_date'] ?? ''); ?>" id="delivery_date" data-rule-required="true" placeholder="Date" autocomplete="off">
								<div class="error"><?php echo e($errors->first('delivery_date')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.time')); ?><span class="text-danger">*</span></label>
	                            <input class="form-control timepicker pr-5" name="time" value="<?php echo e($arr_data['time'] ?? ''); ?>" id="delivery_time" data-rule-required="true" placeholder="HH:mm" autocomplete="off">
								<div class="error"><?php echo e($errors->first('time')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.door_no')); ?><span class="text-danger">*</span></label>
	                            <input type="text" name="door_no" value="<?php echo e($arr_data['door_no'] ?? ''); ?>" data-rule-required="true" class="form-control" disabled>
	                            <div class="error"><?php echo e($errors->first('door_no')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.km_count')); ?><span class="text-danger">*</span></label>
	                            <input type="text" name="km_count" value="<?php echo e($arr_data['km_count'] ?? ''); ?>" data-rule-required="true" class="form-control" disabled>
	                            <div class="error"><?php echo e($errors->first('km_count')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.hours_meter')); ?><span class="text-danger">*</span></label>
	                            <input type="text" name="hours_meter" value="<?php echo e($arr_data['hours_meter'] ?? ''); ?>" data-rule-required="true" class="form-control">
	                            <div class="error"><?php echo e($errors->first('hours_meter')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.complaint')); ?><span class="text-danger">*</span></label>
	                            <textarea name="complaint" value="<?php echo e($arr_data['complaint'] ?? ''); ?>" data-rule-required="true" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" disabled><?php echo e($arr_data['complaint'] ?? ''); ?></textarea>
	                            <div class="error"><?php echo e($errors->first('complaint')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.diagnosis')); ?><span class="text-danger">*</span></label>
	                            <textarea name="diagnosis" value="<?php echo e($arr_data['diagnosis'] ?? ''); ?>" data-rule-required="true" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" disabled><?php echo e($arr_data['diagnosis'] ?? ''); ?></textarea>
	                            <div class="error"><?php echo e($errors->first('diagnosis')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.actions')); ?> <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="action" value="<?php echo e($arr_data['action'] ?? ''); ?>" data-rule-required="true" disabled><?php echo e($arr_data['action'] ?? ''); ?></textarea>
	                            <div class="error"><?php echo e($errors->first('action')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.note')); ?> <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="note" value="<?php echo e($arr_data['note'] ?? ''); ?>" data-rule-required="true" disabled><?php echo e($arr_data['note'] ?? ''); ?></textarea>
	                            <div class="error"><?php echo e($errors->first('note')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.remark')); ?> <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="remark" value="<?php echo e($arr_data['remark'] ?? ''); ?>" data-rule-required="true"><?php echo e($arr_data['remark'] ?? ''); ?></textarea>
	                            <div class="error"><?php echo e($errors->first('remark')); ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="vhc_details">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h4><i class="fa fa-car"></i> <?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.details')); ?></h4>
					<div class="row">
						<div class="col-sm-3">
							<?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.name')); ?> : <span id="vehicle_name"></span>
						</div>
						<div class="col-sm-3">
							<?php echo e(trans('admin.make')); ?> : <span id="make"></span>
						</div>
						<div class="col-sm-3">
							<?php echo e(trans('admin.model')); ?> : <span id="model"></span>
						</div>
						<div class="col-sm-3">
							<?php echo e(trans('admin.year')); ?> : <span id="year"></span>
						</div>
						<div class="col-sm-3">
							<?php echo e(trans('admin.chasis_no')); ?> : <span id="chasis_no"></span>
						</div>
						<div class="col-sm-3">
							<?php echo e(trans('admin.vin_no')); ?># : <span id="vin_no"></span>
						</div>
						<div class="col-sm-3">
							<?php echo e(trans('admin.registration_no')); ?> : <span id="reg_no"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<h4><i class="fa fa-wrench"></i> <?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.parts')); ?></h4>
						</div>
						<div class="col-sm-6">
							<button type="button" class="btn btn-primary float-right" id="addItemBtn" style="margin-bottom: 5px;"><i class="fa fa-plus-circle"></i></button>
						</div>
						<div class="col-sm-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th><?php echo e(trans('admin.item')); ?></th>
										<th><?php echo e(trans('admin.code')); ?></th>
										<th><?php echo e(trans('admin.unit')); ?></th>
										<th><?php echo e(trans('admin.qty')); ?></th>
									</tr>
								</thead>
								<tbody class="items-wrapp">
									<?php if(isset($arr_parts) && count($arr_parts) > 0): ?>
									<?php $__currentLoopData = $arr_parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td>
											<?php if(isset($arr_items) && count($arr_items) > 0): ?>
											<?php endif; ?>
											<select name="item[]" class="form-control item-inp">
												<option>-- Select Item --</option>
												<?php if(isset($arr_items) && count($arr_items) > 0): ?>
												<?php $__currentLoopData = $arr_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($item['id'] ?? ''); ?>" <?php echo e($part['item_id'] == $item['id'] ? 'selected' : ''); ?> ><?php echo e($item['commodity_name'] ?? 'N/A'); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<?php endif; ?>
											</select>
										</td>
										<td>
											<input type="text" name="code[]" class="form-control" value="<?php echo e($part['item']['commodity_code'] ?? ''); ?>" readonly>
										</td>
										<td>
											<input type="text" name="unit[]" class="form-control" value="<?php echo e($part['quantity'] ?? ''); ?>" readonly>
										</td>
										<td>
											<input type="number" name="quantity[]" class="form-control" min="1" placeholder='Enter Quantity' value="<?php echo e($part['quantity'] ?? 0); ?>">
										</td>
										<td>
											<button class="btn btn-danger btn-sm btn-rm"><i class="fa fa-trash"></i></button>
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
	</div>

	<div class="text-center py-3 w-100">
    	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
    	<button type="button" class="btn btn-secondary btn-rounded"><?php echo e(trans('admin.cancel')); ?></button>
    </div>
</form>
<!-- /Page Header -->
<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>

<script type="text/javascript">

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(document).ready(function() {

		$("#addItemBtn").click(function() {
			$('.items-wrapp')
			var $html = '';
			$html += '<tr>'
				$html += '<td>'
					$html += '<select name="item[]" class="form-control item-inp">'
						$html += '<option>-- Select Item --</option>'
							<?php if(isset($arr_items) && count($arr_items) > 0): ?>
							<?php $__currentLoopData = $arr_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						$html += '<option value="'+"<?php echo e($item['id'] ?? ''); ?>"+'">'+"<?php echo e($item['commodity_name'] ?? 'N/A'); ?>"+'</option>'
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
					$html += '</select>'
				$html += '</td>'
				$html += '<td>'
					$html += '<input type="text" name="code[]" class="form-control" value="" readonly>'
				$html += '</td>'
				$html += '<td>'
					$html += '<input type="text" name="unit[]" class="form-control" value="" readonly>'
				$html += '</td>'
				$html += '<td>'
					$html += '<input type="number" name="quantity[]" class="form-control" min="1" value="1" placeholder="Enter Quantity">'
				$html += '</td>'
				$html += '<td>'
					$html += '<button class="btn btn-danger btn-sm btn-rm"><i class="fa fa-trash"></i></button>'
				$html += '</td>'
			$html += '</tr>'

			$(".items-wrapp").append($html);

		});

		$('body').on('click', '.btn-rm', function() {
			var that = $(this);
			that.parents('tr').remove();
		});

		$('body').on('change', '.item-inp', function() {
			var item_id = $(this).val();
			var that = $(this);
			$.ajax({
				url:"<?php echo e(Route('get_item_details','')); ?>/"+btoa(item_id),
				type:'POST',
				dataType:'json',
				success:function(resp) {
					if(resp.status == 'success')
					{
						if(typeof(resp.data) == 'object')
						{
							that.parents('tr').find('input[name="unit[]"]').val(resp.data.unit_name);
							that.parents('tr').find('input[name="code[]"]').val(resp.data.commodity_code);
						}
					}

				}
			});
		});

		initiate_form_validate();

		$('.select2').select2();

		$( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		});
		
		$('.timepicker').datetimepicker({
			format : 'HH:mm'
        });
		var vhc_id = $('#vechicle_id').val();
		vechicle_details(vhc_id);
		$('.decrement_repair_stock').change(function(){
			let isChecked = $(this).is(':checked');
			decrementRepairStockCall(vhc_id,isChecked)
		})
	});

	function vechicle_details(vhc_id)
	{
		$.ajax({
			url:"<?php echo e(Route('vechicle_details','')); ?>/"+btoa(vhc_id),
			type:'GET',
			dataType:'json',
			success:function(resp) {
				if(resp.status == 'success')
				{
					if(typeof(resp.arr_vechicle) == 'object')
					{
						$('#vhc_details').show();
						$('#vehicle_name').html(resp.arr_vechicle.name);
						$('#make').html(resp.arr_vechicle.make.make_name);
						$('#model').html(resp.arr_vechicle.model.model_name);
						$('#year').html(resp.arr_vechicle.year.year);
						$('#chasis_no').html(resp.arr_vechicle.chasis_no);
						$('#vin_no').html(resp.arr_vechicle.vin_no);
						$('#reg_no').html(resp.arr_vechicle.regs_no);
					}
				}
			}
		});
	}


	function initiate_form_validate() {
		$('#formAddUser').validate({
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
	}

	function decrementRepairStockCall(vhc_id,isChecked)
	{
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$.ajax({
			url:"<?php echo e(Route('decrement_repair_stock','')); ?>/"+btoa(vhc_id)+"?isChecked="+isChecked,
			type:'POST',
			dataType:'json',
			success:function(resp) {
				if(resp.message)
				{
					alert(resp.message)
				}
			}
		});
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/vechicle_maintance/repair/edit.blade.php ENDPATH**/ ?>
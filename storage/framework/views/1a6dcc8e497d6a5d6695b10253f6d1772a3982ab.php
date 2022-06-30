<?php

$order = $arr_data['order']??[];
$enc_id = base64_encode($order['id']);
$tax_amnt = 0;

$invoice = $order['invoice'] ?? [];
$product = $arr_data['product_details'] ?? [];
$prod_attrs = $product['attr_values'] ?? [];
$del_notes = $arr_data['del_notes']??[];

$max_loadable_quant = $arr_data['quantity']??0;
if($arr_data['edit_quantity']!='')
{
	$max_loadable_quant = $arr_data['edit_quantity']??0;
}

$tot_int_rejected_qty = 0;
$total_delivered_quantity=0;
if(isset($del_notes) && !empty($del_notes)) {
	foreach($del_notes as $note) {
		$max_loadable_quant -= $note['quantity']??0;
		$total_delivered_quantity += $note['quantity']??0;
		if($note['reject_by']!='' && $note['reject_by'] == '1' || $note['reject_by'] == '2')
		{
			$tot_int_rejected_qty += $note['reject_qty'] ?? 0;
		}
	}
	$max_loadable_quant = $max_loadable_quant + $tot_int_rejected_qty;
}

// $progressive_cbm = round(($max_loadable_quant/$arr_data['quantity'])*100, 2);
$progressive_cbm = $total_delivered_quantity;
$site_location = $order['contract']['site_location']??'';
$delivery_address = $order['contract']['delivery_address']??'';
$structure_element =$order['contract']['structure_element']??'';
$slump =$order['contract']['slump']??'';
$concrete_temp =$order['contract']['concrete_temp']??'';
$quantity =$order['contract']['quantity']??'';
$mix_code = $product['mix_code']??'';
$cement = $cement_type=$slamp=$air_content=$other='';
$selected_pump_operator = $order['pump_op_id'];
$selected_arr_helper = $order['pump_helper_id'];
$selected_arr_driver = $order['driver_id'];

if(isset($prod_attrs) && count($prod_attrs)>0)
{
	foreach($prod_attrs as $key => $value) 
	{
		if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='cement')
		{
			$cement = $value['value']??'';
		}
		if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='cement_type')
		{
			$cement_type = $value['value']??'';
		}
		if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='slamp')
		{
			$slamp = $value['value']??'';
		}
		if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='air_content')
		{
			$air_content = $value['value']??'';
		}
		if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='other')
		{
			$air_content = $value['value']??'';
		}
		
	}
}
?>

<?php if($max_loadable_quant <= 0): ?>
	<h3 align="center">You have already generated delivery note for this order</h3>
	<script type="text/javascript">
		$('.del_note_form_submit').hide();
	</script>
<?php else: ?>
	<!-- <form method="POST" action="<?php echo e(Route('store_del_note',base64_encode($arr_data['id']))); ?>" autocomplete="off" id="del_note_form"> -->
	<form autocomplete="off" id="del_note_form">
	<?php echo e(csrf_field()); ?>

	<div class="row">
		<div class="col-md-3 col-sm-3">
			<div class="position-relative p-0">
				<label>Time</label>
				<input class="form-control pr-5 commonTime" disabled="">
			</div>
		</div>
		<div class="form-group col-sm-3 offset-6">
			<label class="col-form-label"><?php echo e(trans('admin.date')); ?><span class="text-danger">*</span></label>
			<div class="position-relative p-0">
				<input class="form-control pr-5" value="<?php echo e(date('Y-m-d')??''); ?>" disabled="">
				
				<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
			</div>
		</div>
		<div class="form-group col-sm-4">
			<label class="col-form-label"><?php echo e(trans('admin.delivery_no')); ?></label>
			<input type="text" class="form-control" name="title" placeholder="NK02">
		</div>
		<div class="form-group col-sm-4">
			<label class="col-form-label"><?php echo e(trans('admin.rsn')); ?> </label>
			<input type="text" class="form-control" name="title" placeholder="254">
		</div>
		<div class="form-group col-sm-4">
			<label class="col-form-label"><?php echo e(trans('admin.date')); ?></label>
			<div class="d-flex align-items-center">
				<label class="container-checkbox">
					<input type="checkbox" checked="">
					<span class="checkmark"></span>
				</label>
				<div class="position-relative p-0 w-100">
					
					<input class="form-control datepicker pr-5" name="del_date" value="<?php echo e(date('Y-m-d')??''); ?>">
					<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
				</div>
			</div>	
		</div>

		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.customer_no')); ?> </label>
			<input type="text" class="form-control" name="cust_id" value="<?php echo e($order['cust_details']['id'] ?? ''); ?>">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.distance_km')); ?> </label>
			<input type="text" class="form-control" name="title" placeholder="254">
		</div>
		<div class="form-group col-sm-2">
			<input type="hidden" name="pump_op_id" value="<?php echo e($selected_pump_operator??''); ?>" />
			<label class="col-form-label"><?php echo e(trans('admin.pump_op')); ?></label>
			<select class="select2" name="pump_op_id" data-rule-required="false" id="pump_op_id" disabled>
				<option value=""><?php echo e(trans('admin.select_default')); ?></option>
				<?php if(isset($arr_operator) && count($arr_operator)>0): ?>
					<?php $__currentLoopData = $arr_operator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($op['id'] ?? ''); ?>" <?php echo e($selected_pump_operator == $op['id']?'selected':''); ?>><?php echo e($op['first_name'] ?? ''); ?> <?php echo e($op['last_name'] ?? ''); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group col-sm-2">
			<input type="hidden" name="pump_helper_id" value="<?php echo e($selected_arr_helper); ?>" />
			<label class="col-form-label"><?php echo e(trans('admin.pump_helper')); ?></label>
			<select class="select2" name="pump_helper_id" data-rule-required="false" id="pump_helper_id" disabled>
				<option value=""><?php echo e(trans('admin.select_default')); ?></option>
				<?php if(isset($arr_helper) && count($arr_helper)>0): ?>
					<?php $__currentLoopData = $arr_helper; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<option value="<?php echo e($helper['id'] ?? ''); ?>" <?php echo e($selected_arr_helper == $helper['id']?'selected':''); ?>><?php echo e($helper['first_name'] ?? ''); ?> <?php echo e($helper['last_name'] ?? ''); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.driver')); ?></label>
			<?php $delivery_date =''; ?>
			 <?php if(Session::has('curr_driver_del_details')): ?>
               <?php
                $arr_curr_driver_del_data = Session::get('curr_driver_del_details');
                $delivery_date            = $arr_curr_driver_del_data['delivery_date']??'';
                $session_vehicle_id       = $arr_curr_driver_del_data['vehicle_id']??'';
                $session_driver_id        = $arr_curr_driver_del_data['driver_id']??'';

               ?>
            <?php endif; ?>
            <?php if(strtotime(date('Y-m-d'))==strtotime($delivery_date)): ?>
			      <input type="hidden" name="session_vehicle_id" id="session_vehicle_id" value="<?php echo e($session_vehicle_id??''); ?>">
			      <input type="hidden" name="session_driver_id" id="session_driver_id" value="<?php echo e($session_driver_id??''); ?>">
			<?php endif; ?>
			<div class="d-flex align-items-center">
				<input type="hidden" name="driver" value="<?php echo e($selected_arr_driver); ?>" />
				<select name="driver" class="form-control form-select-lg mb-3 select2" id="driver_id" data-rule-required="false" disabled>
					<option value=""><?php echo e(trans('admin.no_selected')); ?></option>

					<?php if(isset($arr_drivers) && !empty($arr_drivers)): ?>
					<?php $__currentLoopData = $arr_drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$driver_fname = $driver['first_name'];
						$driver_fname .= ' '.$driver['last_name'];
						$selected_driver_id = $driver['id'];
					?>
					    
			        
					<option value="<?php echo e($driver['id']??''); ?>" <?php echo e($selected_arr_driver == $driver['id']?'selected':''); ?>><?php echo e($driver_fname .' - '. $driver['id']??''); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				</select>
			</div>	
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.truck_no')); ?></label>
			<select name="vehicle" class="form-control form-select-lg mb-3 select2" data-rule-required="false" id="vehicle">
				<option value="">No selected</option>
				<?php if(isset($arr_vehicles) && !empty($arr_vehicles)): ?>
				<?php $__currentLoopData = $arr_vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
				if($vehicle['driver_details'] !== null){
					$arr_driver = $vehicle['driver_details']??[];
					$driver_name = $arr_driver['first_name']??'';
					$driver_name .= ' '.$arr_driver['last_name']??'';
				}
				?>
				<option value="<?php echo e($vehicle['id']??''); ?>" data-driver-id="<?php echo e($arr_driver['id']??''); ?>" data-driver-name="<?php echo e($driver_name??''); ?>"><?php echo e($vehicle['name']??''); ?> (<?php echo e($vehicle['plate_no']??''); ?> <?php echo e($vehicle['plate_letter']??''); ?>)</option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label class="col-form-label"><?php echo e(trans('admin.deliver_to')); ?></label>
			<input type="text" class="form-control" name="cust_name" value="<?php echo e($order['cust_details']['first_name'] ?? ''); ?>&nbsp;<?php echo e($order['cust_details']['last_name'] ?? ''); ?>">
		</div>
		<div class="form-group col-sm-4">
			<label class="col-form-label"><?php echo e(trans('admin.site')); ?> <?php echo e(trans('admin.location')); ?></label>
			<input type="text" class="form-control" readonly="" name="site_location" value="<?php echo e($site_location??''); ?>">
		</div>
		<div class="form-group col-sm-4">
			<label class="col-form-label"><?php echo e(trans('admin.del_address')); ?></label>
			<input type="text" class="form-control" value="<?php echo e($delivery_address??''); ?>" name="del_address">
		</div>


		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.class_mix_psi')); ?></label>
			<input type="text" class="form-control" name="title" placeholder="Receiver">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.cement_kg_cbm')); ?></label>
			<input type="text" class="form-control" value="<?php echo e($cement??''); ?>" name="title">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.type')); ?></label>
			<input type="text" class="form-control" value="<?php echo e($cement_type??''); ?>" name="title">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.slumo_cp')); ?></label>
			<input type="text" class="form-control" value="<?php echo e($slamp??''); ?>" name="title">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.design_mix')); ?></label>
			<input type="text" class="form-control" name="product_name" value="<?php echo e($product['name']??''); ?> (<?php echo e($product['mix_code']??''); ?>)">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.pump_mix')); ?></label>
			<input type="text" class="form-control" name="pump" value="<?php echo e($order['pump']??''); ?>">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.additive')); ?>.</label>
			<input type="text" class="form-control" name="title">
		</div>

		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.total_order_cbm')); ?></label>
			<input type="number" class="form-control" name="tot_quant" value="<?php echo e($arr_data['quantity']??0); ?>">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.preogressive_cbm')); ?></label>
			<input type="text" class="form-control" name="preogressive_cbm" value="<?php echo e($progressive_cbm??0); ?>" disabled="">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.loaded_quant')); ?> <span class="text-danger">*</span></label>
			<input type="number" class="form-control" name="loaded_quant" min="1" max="<?php echo e($max_loadable_quant>=12?12:$max_loadable_quant); ?>" value="<?php echo e($max_loadable_quant>=10?10:$max_loadable_quant); ?>" data-rule-required="true">
		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label"><?php echo e(trans('admin.load_num')); ?>.</label>
			<input type="text" class="form-control" name="load_num" value="<?php echo e(count($del_notes)+1); ?>" readonly>
		</div>
			<div class="form-group col-sm-2">
			<label class="col-form-label">Gate #</label>
			<input type="text" class="form-control" name="gate">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-sm-2">
			<label class="col-form-label">Structure Element:</label>
			<?php echo e($structure_element??''); ?>

		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label">Concrete Temp:</label>
			<?php echo e($concrete_temp??''); ?>

		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label">Quantity: </label>
			<?php echo e($quantity??''); ?>

		</div>
		<div class="form-group col-sm-2">
			<label class="col-form-label">Mix Code: </label>
			<?php echo e($mix_code??''); ?>

		</div>
	
		
	</div>
	</form>
<script type="text/javascript">

	$(document).ready(function() {

		$('.del_note_form_submit').show();
		let selected_pump_operator = "<?php echo e($selected_pump_operator); ?>";
		let selected_arr_helper    = "<?php echo e($selected_arr_helper); ?>";
		let selected_arr_driver    = "<?php echo e($selected_arr_driver); ?>";
		if(!selected_pump_operator)
		  $('#pump_op_id').attr('disabled',false)
		if(!selected_arr_helper)
		  $('#pump_helper_id').attr('disabled',false)
		if(!selected_arr_driver)
		  $('#driver_id').attr('disabled',false)

		$('.select2').select2();

		$('select[name=vehicle]').change(function(){

			var driver_id   = $('select[name=vehicle] :selected').data('driver-id');
			var driver_name = $('select[name=vehicle] :selected').data('driver-name');
			var vehicle_id  = $(this).val();
			if(vehicle_id==$('#session_vehicle_id').val())
			{
				$('select[name=driver]').val($('#session_driver_id').val());
			}
			else
			{
				$('select[name=driver]').val(driver_id);
			}
			
    		$('select[name=driver]').select2().trigger('change');

			// $("input[name=driver]").val(driver_id);
			// $("input[name=driver_name]").val(driver_name);
		});

		$("#del_note_form").validate();

		$('.del_note_form_submit').click(function(e) {
			e.preventDefault();
			if($("#del_note_form").validate()){
				$.ajax({
					type:'POST',
					url: "<?php echo e(route('store_del_note',base64_encode($arr_data['id']))); ?>",
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					data: $("#del_note_form").serialize(),
					success: function(data) {
					if(data['status'] === 'success'){
						$('#exampleModal').modal('hide');
						if(data['pdfUrl']){
							setTimeout(() => {
								window.location.reload();
							}, 3000);
							window.open(data['pdfUrl'],"_blank").focus();
						}
					}
					}
				});
			}
			// submitDelNote(e);
		});

	});

</script>
<?php endif; ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/delivery/delivery_orders/delivery_note.blade.php ENDPATH**/ ?>
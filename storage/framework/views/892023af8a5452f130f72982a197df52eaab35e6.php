<?php

//$rate = $arr_product['rate']??0;
$rate = ($opc1_rate??0)+($src5_rate??0);

//$total = $rate * ($quantity??0);
$total = $rate * ($quantity??0);

?>
<tr class="">
	<td>
		<input type="hidden" name="prod_id[]" value="<?php echo e($prod_id ?? ''); ?>">
		<textarea name="prod_name[]" cols="5" class="form-control" data-rule-required="true"><?php echo e($arr_product['name'] ?? ''); ?></textarea>
	</td>
	<td>
		<textarea name="prod_descr[]" cols="5" class="form-control" data-rule-required="true"><?php echo e($arr_product['description'] ?? ''); ?></textarea>
	</td>
	<td>
		<input type="number" name="unit_quantity[]" value="<?php echo e($quantity ?? 1); ?>" class="form-control" min="0" id="unit_quantity" data-rule-required="true" onchange="calculate_prop_amnt()" >
	</td>
	<td style="display: none;">
		<input type="number" name="unit_rate[]" value="<?php echo e($rate??0); ?>" class="form-control" min="<?php echo e($arr_product['min_quant'] ?? '1'); ?>" readonly="readonly" data-rule-required="true">
	</td>
	<td>
		<input type="number" name="opc1_rate[]" value="<?php echo e($opc1_rate??''); ?>" class="form-control" min="0" id="opc1_rate" data-rule-required="true" onchange="calculate_prop_amnt()" >
	</td>
	<td>
		<input type="number" name="src5_rate[]" value="<?php echo e($src5_rate??''); ?>" class="form-control" min="0" id="src5_rate" onchange="calculate_prop_amnt()" >
	</td>
	<td>
		<select name="unit_tax[]" class="select unit_tax">
			<option value="">No selected</option>
			<?php if(isset($arr_taxes) && !empty($arr_taxes)): ?>
			<?php $__currentLoopData = $arr_taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<option value="<?php echo e($tax['id']); ?>" <?php echo e(isset($arr_product['tax_id'])&&$arr_product['tax_id']==$tax['id']?'selected':''); ?> ><?php echo e($tax['name']); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
		</select>
	</td>
	<td class="unit_price"><?php echo e(format_price($total)); ?></td>
	<td>
		<button class="btn btn-sm btn-danger" id="btnRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/proposals/item_clone.blade.php ENDPATH**/ ?>
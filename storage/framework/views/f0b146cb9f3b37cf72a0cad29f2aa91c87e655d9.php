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
		<input type="number" name="opc1_rate[]" value="<?php echo e($opc1_rate??''); ?>" class="form-control" min="0" id="opc1_rate" data-rule-required="true">
	</td>
	<td>
		<input type="number" name="src5_rate[]" value="<?php echo e($src5_rate??''); ?>" class="form-control" min="0" id="src5_rate">
	</td>
	<td>
		<button class="btn btn-sm btn-danger" id="btnRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/contract/item_clone.blade.php ENDPATH**/ ?>
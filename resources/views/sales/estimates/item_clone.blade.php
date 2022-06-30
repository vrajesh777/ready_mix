<?php

//$rate = $arr_product['rate']??0;
$rate = ($opc1_rate??0)+($src5_rate??0);

// $total = $rate * ($quantity??0);
$total = $rate * ($quantity??0);

?>
<tr class="">
	<td>
		<input type="hidden" name="prod_id[]" value="{{ $prod_id ?? '' }}">
		<textarea name="prod_name[]" cols="5" class="form-control" data-rule-required="true">{{ $arr_product['name'] ?? '' }}</textarea>
	</td>
	<td>
		<textarea name="prod_descr[]" cols="5" class="form-control" data-rule-required="true">{{ $arr_product['description'] ?? '' }}</textarea>
	</td>
	<td>
		<input type="number" name="unit_quantity[]" value="{{ $quantity ?? 1 }}" class="form-control" min="0" id="unit_quantity" data-rule-required="true" onchange="calculate_prop_amnt()" >
	</td>
	<td style="display: none;">
		<input type="number" name="unit_rate[]" value="{{ $arr_product['rate'] ?? '00' }}" class="form-control" min="{{ $arr_product['min_quant'] ?? '1' }}" readonly="readonly" data-rule-required="true">
	</td>
	<td>
		<input type="number" name="opc1_rate[]" value="{{ $opc1_rate??'' }}" class="form-control" min="0" id="opc1_rate" data-rule-required="true" onchange="calculate_prop_amnt()" >
	</td>
	<td>
		<input type="number" name="src5_rate[]" value="{{ $src5_rate??'' }}" class="form-control" min="0" id="src5_rate" onchange="calculate_prop_amnt()" >
	</td>
	<td>
		<select name="unit_tax[]" class="select unit_tax">
			<option value="">No selected</option>
			@if(isset($arr_taxes) && !empty($arr_taxes))
			@foreach($arr_taxes as $tax)
			<option value="{{ $tax['id'] }}" {{ isset($arr_product['tax_id'])&&$arr_product['tax_id']==$tax['id']?'selected':'' }} >{{ $tax['name'] }}</option>
			@endforeach
			@endif
		</select>
	</td>
	<td class="unit_price">{{ format_price($total) }}</td>
	<td>
		<button class="btn btn-sm btn-danger" id="btnRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
	</td>
</tr>
<?php $__env->startSection('main_content'); ?>

<form method="POST" action="<?php echo e(Route('vhc_purchase_parts_store')); ?>" id="formAddUser" enctype="multipart/form-data">
	<div class="row">
		<?php echo e(csrf_field()); ?>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<h5>Purchase Parts Form</h5><hr>
					<div class="row">
						
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Part<span class="text-danger">*</span></label>
	                            <select name="part_id" class="select2" id="part_id" data-rule-required="true">
									<option value="">Select Part</option>
									<?php if(isset($arr_items) && sizeof($arr_items)>0): ?>
										<?php $__currentLoopData = $arr_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($item['id'] ?? ''); ?>" <?php if(isset($arr_data['part_id']) && $arr_data['part_id']!='' && $arr_data['part_id'] == $item['id']): ?> selected <?php endif; ?>><?php echo e($item['commodity_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('part_id')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Supplier <span class="text-danger">*</span></label>
	                            <select name="supply_id" class="select2" id="supply_id" data-rule-required="true" disabled>
									<option value="">Select Supplier</option>
									<?php if(isset($arr_supplier) && sizeof($arr_supplier)>0): ?>
										<?php $__currentLoopData = $arr_supplier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($supplier['id'] ?? ''); ?>" <?php if(isset($arr_data['vendor_id']) && $arr_data['vendor_id']!='' && $arr_data['vendor_id'] == $supplier['id']): ?> selected <?php endif; ?>><?php echo e($supplier['first_name'] ?? ''); ?> <?php echo e($supplier['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('supply_id')); ?></div>
        					</div>
						</div>
						<input type="hidden" name="supply_id" value="<?php echo e($arr_data['vendor_id'] ?? 0); ?>">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Manufacturer <span class="text-danger">*</span></label>
	                            <select name="manufact_id" class="select2" id="manufact_id" data-rule-required="true">
									<option value="">Select Manufacturer</option>
									<?php if(isset($arr_manufacturer) && sizeof($arr_manufacturer)>0): ?>
										<?php $__currentLoopData = $arr_manufacturer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($manufact['id'] ?? ''); ?>" <?php if(isset($arr_data['manufact_id']) && $arr_data['manufact_id']!='' && $arr_data['manufact_id'] == $manufact['id']): ?> selected <?php endif; ?>><?php echo e($manufact['name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('manufact_id')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Condition <span class="text-danger">*</span></label>
	                            <select name="condition" id="condition" data-rule-required="true" class="select2">
									<option value="new"<?php if(isset($arr_data['condition']) && $arr_data['condition']!='' && $arr_data['condition'] == 'new'): ?> selected <?php endif; ?>>New</option>
									<option value="old"<?php if(isset($arr_data['condition']) && $arr_data['condition']!='' && $arr_data['condition'] == 'old'): ?> selected <?php endif; ?>>Old</option>
								</select>
								<div class="error"><?php echo e($errors->first('condition')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Buy Price(Per pcs) <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="buy_price" id="buy_price" placeholder="Buying Price" data-rule-required="true"  data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('buy_price')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Quantity <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="quantity" id="quantity" placeholder="Quantity" data-rule-required="true" data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('quantity')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Sell Price (Per pcs) </label>
            					<input type="text" class="form-control" name="sell_price" id="sell_price" placeholder="0.00" value="<?php echo e($arr_data['sell_price'] ?? 0); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('sell_price')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Part No <span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="part_no" id="part_no" placeholder="Part No" data-rule-required="true" value="<?php echo e($arr_data['part_no'] ?? ''); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('part_no')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Purchase Date <span class="text-danger">*</span></label>
	                            <input type="text" name="purch_date" data-rule-required="true" class="form-control datepicker" value="<?php echo e($arr_data['order_date'] ?? ''); ?>">
	                            <div class="error"><?php echo e($errors->first('purch_date')); ?></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Parts Warranty </label>
            					<input type="text" class="form-control" name="warrenty" id="warrenty" placeholder="5 Years or 6 Months" value="<?php echo e($arr_data['warrenty'] ?? ''); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('warrenty')); ?></div>
        					</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Total Amount <span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="0.00" data-rule-required="true" readonly data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('total')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Given Amount <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="given_amount" id="given_amount" placeholder="0.00" data-rule-required="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('given_amount')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Pending Amount <span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="pending_amount" id="pending_amount" placeholder="0.00" data-rule-required="true" readonly>
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('pending_amount')); ?></div>
        					</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">Parts Image</label>
	                           	<div class="position-relative p-0">
	        						<input type="file" class="file-text form-control" name="image" id="image" accept="application/pdf,image/jpeg,image/jpg,image/png">
	    						</div>
	    					</div>
						</div>
					</div>

					<h5>Parts fits with</h5><hr>
					<div class="row">

						<table id="partsdata" class="table table-bordered">
							<thead>
								<tr>
									<th>Make</th>
									<th>Model</th>
									<th>Year</th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
								<?php if(isset($arr_data['parts_details']) && sizeof($arr_data['parts_details'])>0): ?>
								<?php $__currentLoopData = $arr_data['parts_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_key => $p_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tbody id='parts-row<?php echo e($p_key ?? 0); ?>'>
										<tr>
											<td class='left'>
												<select class='form-control' id="make_<?php echo e($p_key ?? 0); ?>" onchange='loadModelDatax(this,<?php echo e($p_key ?? 0); ?>);' name='partsfilter[<?php echo e($p_key ?? 0); ?>][make]'>
													<option value=''>--Select Make--</option>
													<?php if(isset($arr_make) && sizeof($arr_make)>0): ?>
														<?php $__currentLoopData = $arr_make; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($make['id'] ?? 0); ?>" <?php if($make['id'] == $p_val['make_id']): ?> selected <?php endif; ?>><?php echo e($make['make_name'] ?? 0); ?></option>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</select>
											</td>
											<td class='left'>
												<select class='form-control' onchange='loadYearDatax(this,<?php echo e($p_key ?? 0); ?>);' name='partsfilter[<?php echo e($p_key ?? 0); ?>][model]' id='model_<?php echo e($p_key ?? 0); ?>'>
													<option value=''>--Select Model--</option>
													<?php if(isset($arr_model) && sizeof($arr_model)>0): ?>
														<?php $__currentLoopData = $arr_model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<?php if($model['make_id'] == $p_val['make_id']): ?>
																<option value="<?php echo e($model['id'] ?? 0); ?>" <?php if($model['id'] == $p_val['model_id']): ?> selected <?php endif; ?>><?php echo e($model['model_name'] ?? 0); ?></option>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</select>
											</td>
											<?php
												$yearArray = [];
												$start = get_year_from_model_make($p_val['make_id'],$p_val['model_id']);
												if($start!='')
												{
													$end = date('Y');
								                	$yearArray = range($start,$end);
												}
											?>
											<td class='left'>
												<select class='form-control' name='partsfilter[<?php echo e($p_key ?? 0); ?>][year]' id='year_<?php echo e($p_key ?? 0); ?>'>
													<option value=''>--Select Year--</option>
													<?php if(isset($yearArray) && sizeof($yearArray)>0): ?>
														<?php $__currentLoopData = $yearArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															
																<option value="<?php echo e($year ?? 0); ?>" <?php if($year == $p_val['year_id']): ?> selected <?php endif; ?>><?php echo e($year ?? 0); ?></option>
															
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</select>
											</td>
											<td class='left'>
												<button class='btn btn-danger' title='Remove' data-toggle='tooltip' onclick=$( '#parts-row<?php echo e($p_key ?? 0); ?>').remove(); type='button'><i class='fa fa-minus-circle'></i></button>
											</td>
										</tr>
									</tbody>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>

				                <tr>
				                  	<td colspan="4"></td>
				                  	<td class="left"><button class="btn btn-primary" title="" data-toggle="tooltip" onclick="addPartsData();" type="button"><i class="fa fa-plus-circle"></i></button></td>
				                </tr>
				            </tfoot>
						</table>
					</div>

					<div class="row" id="append_parts"></div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded">Cancel</button>
	                </div>

				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Page Header -->

<script type="text/javascript">

	$(document).ready(function() {

		initiate_form_validate();

		$('.select2').select2();

		$(".ppcal").keyup(function() {
			partsBuyPriceCalculation();
		});

		/*loadModelDatax();
		loadYearDatax();*/

	});

	function partsBuyPriceCalculation() {
		var parts_price = 0;
		var qty = 0;
		var given_amount = 0;
		
		if($("#buy_price").val() != '') {
			parts_price = $("#buy_price").val();
		}
		if($("#quantity").val() != '') {
			qty = $("#quantity").val();
		}
		if($("#given_amount").val() != '') {
			given_amount = $("#given_amount").val();
		}
		var total  = parseFloat(parseFloat(parts_price) * parseInt(qty));
		var ptotal = parseFloat(parseFloat(parseFloat(parts_price) * parseInt(qty)) - parseFloat(given_amount));
		
		ptotal = ptotal.toFixed(2);
		total = total.toFixed(2);
		$("#pending_amount").val(ptotal);
		$("#total_amount").val(total);
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

	var arr_make = <?php echo json_encode($arr_make); ?>;
	var parts_rows = 0;

	function addPartsData() {

		var makeOption = '<option value="">Select Model</option>'; 
		if(typeof(arr_make) == 'object')
		{
			$(arr_make).each(function(index,make){
				makeOption+='<option value="'+make.id+'">'+make.make_name+'</option>';
			})
		}

		html  = '<tbody id="parts-row' + parts_rows + '">';
		html += '  <tr>';
		html += '    <td class="left"><select class="form-control" id="make_' + parts_rows + '" name="partsfilter[' + parts_rows + '][make]" onchange="loadModelDatax(this,' + parts_rows + ');">';
		html += makeOption;
		html += '    </td>';

		html += '    <td class="left"><select class="form-control" disabled="disabled" id="model_' + parts_rows + '" name="partsfilter[' + parts_rows + '][model]" onchange="loadYearDatax(this,' + parts_rows + ');">';
		html += '      <option value="">--Select Model--</option>';
		html += '    </select></td>';
		html += '    <td class="left"><select class="form-control" id="year_' + parts_rows + '" disabled="disabled" name="partsfilter[' + parts_rows + '][year]">';
		html += '      <option value="">--Select Year--</option>';
		html += '    </select></td>';

		html += '    <td class="left"><button class="btn btn-danger" title="Remove" data-toggle="tooltip" onclick="$(\'#parts-row' + parts_rows + '\').remove();" type="button"><i class="fa fa-minus-circle"></i></button></td>';
		html += '  </tr>';	
		html += '</tbody>';
		
		$('#partsdata tfoot').before(html);
		
		parts_rows++;
	}

	function loadModelDatax(obj,row){
		if(obj.value != ''){
			$.ajax({
				type: "GET",
				url: '<?php echo e(Route('get_model_html','')); ?>/'+obj.value,
				success: function(response) {
					if(response.status == 'success'){
						$("#model_" + row).html(response.data);
						$("#model_" + row).prop('disabled', false);
					}
					else{
						alert('Wrong Request');
						$("#model_" + row).prop('disabled', true);
					}
				},
			});
		}
	}

	function loadYearDatax(obj,row){
		if(obj.value != ''){
			var post_url = '<?php echo e(Route('get_year_html')); ?>'+'?model_id='+obj.value+'&make_id='+$("#make_" + row).val();
			$.ajax({
				type: "GET",
				url: post_url,
				success: function(response) {
					if(response.status == 'success'){
						$("#year_" + row).html(response.data);
						$("#year_" + row).prop('disabled', false);
					}
					else{
						alert('Wrong Request');
						$("#year_" + row).prop('disabled', true);
					}
				},
			});
		}
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/purchase_parts/existing.blade.php ENDPATH**/ ?>
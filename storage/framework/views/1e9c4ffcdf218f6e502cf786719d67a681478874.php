<?php $__env->startSection('main_content'); ?>

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body">
				<h4><i class="fa fa-cart-plus"></i> <?php echo e(trans('admin.purchase')); ?> <?php echo e(trans('admin.for_exisiting_parts')); ?>  ?</h4>
				<div class="col-sm-4">
					<div class="form-group">
						<label class="col-form-label"><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.parts')); ?></label>
                        <select name="existing_id" class="select2" id="existing_id" data-rule-required="true" onchange="loadExistingParts(this);">
							<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.parts')); ?></option>
							<?php if(isset($arr_existing_parts) && sizeof($arr_existing_parts)>0): ?>
								<?php $__currentLoopData = $arr_existing_parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($exist['id'] ?? ''); ?>"><?php echo e($exist['part']['commodity_name'] ?? ''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<form method="POST" action="<?php echo e(Route('vhc_purchase_parts_store')); ?>" id="formAddUser" enctype="multipart/form-data">
	<div class="row">
		<?php echo e(csrf_field()); ?>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<h5><?php echo e(trans('admin.purchase')); ?> <?php echo e(trans('admin.parts')); ?> <?php echo e(trans('admin.from')); ?></h5><hr>
					<div class="row">
						
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.part')); ?><span class="text-danger">*</span></label>
	                            <select name="part_id" class="select2" id="part_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.part')); ?></option>
									<?php if(isset($arr_items) && sizeof($arr_items)>0): ?>
										<?php $__currentLoopData = $arr_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($item['id'] ?? ''); ?>" <?php if(isset($id) && $id!='' && $id == $item['id']): ?> selected <?php endif; ?>><?php echo e($item['commodity_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('part_id')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.supplier')); ?> <span class="text-danger">*</span></label>
	                            <select name="supply_id" class="select2" id="supply_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.supplier')); ?></option>
									<?php if(isset($arr_supplier) && sizeof($arr_supplier)>0): ?>
										<?php $__currentLoopData = $arr_supplier; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($supplier['id'] ?? ''); ?>"><?php echo e($supplier['first_name'] ?? ''); ?> <?php echo e($supplier['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('supply_id')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.manufacturer')); ?> <span class="text-danger">*</span></label>
	                            <select name="manufact_id" class="select2" id="manufact_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.manufacturer')); ?></option>
									<?php if(isset($arr_manufacturer) && sizeof($arr_manufacturer)>0): ?>
										<?php $__currentLoopData = $arr_manufacturer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($manufact['id'] ?? ''); ?>"><?php echo e($manufact['name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('manufact_id')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.condition')); ?> <span class="text-danger">*</span></label>
	                            <select name="condition" id="condition" data-rule-required="true" class="select2">
									<option value="new"><?php echo e(trans('admin.new')); ?></option>
									<option value="old"><?php echo e(trans('admin.old')); ?></option>
								</select>
								<div class="error"><?php echo e($errors->first('condition')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.buy')); ?> <?php echo e(trans('admin.price')); ?>(<?php echo e(trans('admin.per_pcs')); ?>) <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="buy_price" id="buy_price" placeholder="<?php echo e(trans('admin.buy')); ?> <?php echo e(trans('admin.price')); ?>" data-rule-required="true" value="<?php echo e(old('buy_price')); ?>" data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('buy_price')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.qty')); ?>  <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="quantity" id="quantity" placeholder="<?php echo e(trans('admin.qty')); ?>" data-rule-required="true" value="<?php echo e(old('quantity')); ?>" data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('quantity')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.sell')); ?> <?php echo e(trans('admin.price')); ?>  (<?php echo e(trans('admin.per_pcs')); ?>) </label>
            					<input type="text" class="form-control" name="sell_price" id="sell_price" placeholder="0.00" value="<?php echo e(old('sell_price')); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('sell_price')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.part')); ?> <?php echo e(trans('admin.no')); ?> <span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="part_no" id="part_no" placeholder="<?php echo e(trans('admin.part')); ?> <?php echo e(trans('admin.no')); ?>" data-rule-required="true" value="<?php echo e(old('part_no')); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('part_no')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.purchase')); ?> <?php echo e(trans('admin.date')); ?> <span class="text-danger">*</span></label>
	                            <input type="text" name="purch_date" data-rule-required="true" class="form-control datepicker" value="<?php echo e(date('Y-m-d')); ?>">
	                            <div class="error"><?php echo e($errors->first('purch_date')); ?></div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.parts')); ?> <?php echo e(trans('admin.warranty')); ?>  </label>
            					<input type="text" class="form-control" name="warrenty" id="warrenty" placeholder="<?php echo e(trans('admin.parts')); ?> <?php echo e(trans('admin.warranty')); ?>" value="<?php echo e(old('warrenty')); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('warrenty')); ?></div>
        					</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.total_amount')); ?><span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="0.00" data-rule-required="true" value="<?php echo e(old('total_amount')); ?>" readonly data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('total_amount')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.given_amount')); ?><span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="given_amount" id="given_amount" placeholder="0.00" data-rule-required="true" value="<?php echo e(old('given_amount')); ?>">
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('given_amount')); ?></div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.pending_amount')); ?><span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="pending_amount" id="pending_amount" placeholder="0.00" data-rule-required="true" value="<?php echo e(old('pending_amount')); ?>" readonly>
            					<label class="error" id="name_error"></label>
            					<div class="error"><?php echo e($errors->first('pending_amount')); ?></div>
        					</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.parts')); ?> <?php echo e(trans('admin.image')); ?></label>
	                           	<div class="position-relative p-0">
	        						<input type="file" class="file-text form-control" name="image" id="image" accept="application/pdf,image/jpeg,image/jpg,image/png">
	    						</div>
	    					</div>
						</div>
					</div>

					<h5><?php echo e(trans('admin.parts_fits_with')); ?> </h5><hr>
					<div class="row">

						<table id="partsdata" class="table table-bordered">
							<thead>
								<tr>
									<th><?php echo e(trans('admin.make')); ?></th>
									<th><?php echo e(trans('admin.model')); ?></th>
									<th><?php echo e(trans('admin.year')); ?></th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
				                <tr>
				                  	<td colspan="4"></td>
				                  	<td class="left"><button class="btn btn-primary" title="" data-toggle="tooltip" onclick="addPartsData();" type="button"><i class="fa fa-plus-circle"></i></button></td>
				                </tr>
				            </tfoot>
						</table>
					</div>

					<div class="row" id="append_parts"></div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded"><?php echo e(trans('admin.cancel')); ?></button>
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
		console.log(arr_make);

		var makeOption = '<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.model')); ?></option>'; 
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
		html += '      <option value="">--<?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.model')); ?>--</option>';
		html += '    </select></td>';
		html += '    <td class="left"><select class="form-control" id="year_' + parts_rows + '" disabled="disabled" name="partsfilter[' + parts_rows + '][year]">';
		html += '      <option value="">--<?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.year')); ?>--</option>';
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

	function loadExistingParts(ref) {
		var id = $(ref).val();
		if(id != '') {
			window.location.href = "<?php echo e(Route('existing_part','')); ?>/"+btoa(id);
		}
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/purchase_parts/create.blade.php ENDPATH**/ ?>
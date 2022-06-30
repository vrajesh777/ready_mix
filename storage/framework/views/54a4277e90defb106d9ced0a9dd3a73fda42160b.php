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
					<h4><i class="fa fa-wrench"></i> <?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.parts')); ?></h4>
					<div class="row">
						<table id="partsdata" class="table table-bordered">
							<thead>
								<tr>
									<th><?php echo e(trans('admin.make')); ?></th>
									<th><?php echo e(trans('admin.model')); ?></th>
									<th><?php echo e(trans('admin.year')); ?></th>
									<th><?php echo e(trans('admin.parts')); ?></th>
									<th><?php echo e(trans('admin.qty')); ?></th>
									<th><?php echo e(trans('admin.yes')); ?></th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
				                <?php if(isset($arr_data['vhc_part_detail']) && sizeof($arr_data['vhc_part_detail'])>0): ?>
								<?php $__currentLoopData = $arr_data['vhc_part_detail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p_key => $p_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

											

											<td class="left">
												<select class="form-control" id="part_<?php echo e($p_key ?? 0); ?>" name="partsfilter[<?php echo e($p_key ?? 0); ?>][part]">
													<option value="">--Select Part--</option>
													<?php if(isset($arr_parts) && sizeof($arr_parts)>0): ?>
														<?php $__currentLoopData = $arr_parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															 <?php if(($part['make_id'] == $p_val['make_id']) && ($part['model_id'] == $p_val['model_id'])): ?>
																<option value="<?php echo e($part['part_id'] ?? 0); ?>" <?php if($part['part_id'] == $p_val['part_id']): ?> selected <?php endif; ?>><?php echo e($part['part']['commodity_name'] ?? 0); ?></option>
															<?php endif; ?>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													<?php endif; ?>
												</select>
											</td>

											<td class="text-right"><input id="qty_<?php echo e($p_key ?? 0); ?>" type="text" name="partsfilter[<?php echo e($p_key ?? 0); ?>][quantity]" class="form-control" value="<?php echo e($p_val['quantity'] ?? 0); ?>" /></td>
											<td class="text-right"><input id="received_<?php echo e($p_key ?? 0); ?>" type="checkbox" 
												 name="partsfilter[<?php echo e($p_key ?? 0); ?>][received]" class="form-control decrement_repair_stock" data-toggle="tooltip" data-placement="top" title="Recevied" style="width: 20px;"  /></td>
											<td class='left'>
												<button class='btn btn-danger' title='Remove' data-toggle='tooltip' onclick="$( '#parts-row<?php echo e($p_key ?? 0); ?>').remove()"; type='button'><i class='fa fa-minus-circle'></i></button>
											</td>
										</tr>
									</tbody>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>

				                <tr>
				                  	<td colspan="6"></td>
				                  	<td class="left"><button class="btn btn-primary" title="" data-toggle="tooltip" onclick="addPartsData();" type="button"><i class="fa fa-plus-circle"></i></button></td>
				                </tr>
				            </tfoot>
						</table>
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

	$(document).ready(function() {

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
					success:function(resp){

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

	var arr_make = <?php echo json_encode($arr_make); ?>;
	var parts_rows = "<?php echo e($count ?? 0); ?>";
	function addPartsData() {
		console.log(arr_make);

		var makeOption = '<option value=""><?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.model')); ?> </option>'; 
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
		html += '      <option value="">--<?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.model')); ?> --</option>';
		html += '    </select></td>';

		html += '    <td class="left"><select class="form-control" id="year_' + parts_rows + '" disabled="disabled" name="partsfilter[' + parts_rows + '][year]" onchange="loadPartxDatax(this,' + parts_rows + ');">';
		html += '      <option value="">--<?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.year')); ?>--</option>';
		html += '    </select></td>';

		html += '    <td class="left"><select class="form-control" id="part_' + parts_rows + '" disabled="disabled" name="partsfilter[' + parts_rows + '][part]">';
		html += '      <option value="">--<?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.part')); ?>--</option>';
		html += '    </select></td>';

		html += '  <td class="text-right"><input id="qty_' + parts_rows + '" type="text" name="partsfilter[' + parts_rows + '][quantity]" class="form-control" /></td>';

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

	function loadPartxDatax(obj,row){
		if(obj.value != ''){
			var post_url = '<?php echo e(Route('get_parts_html')); ?>'+'?model_id='+$("#model_" + row).val()+'&make_id='+$("#make_" + row).val()+'&year_id='+$("#year_" + row).val();
			$.ajax({
				type: "GET",
				url: post_url,
				success: function(response) {
					if(response.status == 'success'){
						$("#part_" + row).html(response.data);
						$("#part_" + row).prop('disabled', false);
					}
					else{
						$("#part_" + row).prop('disabled', true);
					}
				},
			});
		}
	}
	// decrement repair stock
	function decrementRepairStockCall(vhc_id,isChecked)
	{
		// console.log($(this))
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$.ajax({
			url:"<?php echo e(Route('decrement_repair_stock','')); ?>/"+btoa(vhc_id)+"?isChecked="+isChecked,
			type:'POST',
			dataType:'json',
			success:function(resp){
				// console.log(resp)
				if(resp.message)
				{
					alert(resp.message)
				}

			}
			});
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/repair/edit.blade.php ENDPATH**/ ?>
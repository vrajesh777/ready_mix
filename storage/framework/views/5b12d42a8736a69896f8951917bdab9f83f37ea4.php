<?php $__env->startSection('main_content'); ?>

<form method="POST" action="<?php echo e(Route('vhc_repair_store')); ?>" id="formAddUser" enctype="multipart/form-data">
<?php echo e(csrf_field()); ?>

	<div class="row">
		<div class="col-sm-12">

			<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-2">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.vehicle')); ?> <span class="text-danger">*</span></label>
	                            <select name="vechicle_id" class="select2" id="vechicle_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.vehicle')); ?></option>
									<?php if(isset($arr_vechicle) && sizeof($arr_vechicle)>0): ?>
										<?php $__currentLoopData = $arr_vechicle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vechicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($vechicle['id'] ?? ''); ?>" data-maker="<?php echo e($vechicle['maker'] ?? ''); ?>" data-model="<?php echo e($vechicle['model'] ?? ''); ?>" data-year="<?php echo e($vechicle['year'] ?? ''); ?>"><?php echo e($vechicle['name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('vechicle_id')); ?></div>
	    					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.assignee')); ?> <span class="text-danger">*</span></label>
	                            <select name="assignee_id" class="select2" id="assignee_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.assignee')); ?></option>
									<?php if(isset($arr_mechanics) && sizeof($arr_mechanics)>0): ?>
										<?php $__currentLoopData = $arr_mechanics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mechanic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($mechanic['id'] ?? ''); ?>">
												<?php if(\App::getLocale() == 'ar'): ?>
													<span><?php echo e($mechanic['first_name'] ?? ''); ?></span>
												<?php else: ?>
													<span> <?php echo e($mechanic['last_name'] ?? ''); ?></span>
												<?php endif; ?>											</option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('vechicle_id')); ?></div>
	    					</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.created_date')); ?><span class="text-danger">*</span></label>
	                            <input class="form-control datepicker pr-5" name="delivery_date" value="<?php echo e(date('d-M-Y')); ?>" id="delivery_date" data-rule-required="true" placeholder="Date" autocomplete="off" disabled>
								<div class="error"><?php echo e($errors->first('delivery_date')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.time')); ?><span class="text-danger">*</span></label>
	                            <input class="form-control timepicker pr-5" name="time" id="delivery_time" data-rule-required="true" placeholder="HH:mm" autocomplete="off">
								<div class="error"><?php echo e($errors->first('time')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.door_no')); ?><span class="text-danger">*</span></label>
	                            <input type="text" name="door_no" data-rule-required="true" class="form-control">
	                            <div class="error"><?php echo e($errors->first('door_no')); ?></div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.km_count')); ?><span class="text-danger">*</span></label>
	                            <input type="text" name="km_count" data-rule-required="true" class="form-control" value="">
	                            <div class="error"><?php echo e($errors->first('km_count')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.complaint')); ?><span class="text-danger">*</span></label>
	                            <textarea name="complaint" data-rule-required="true" class="form-control" value="<?php echo e(date('Y-m-d')); ?>"></textarea>
	                            <div class="error"><?php echo e($errors->first('complaint')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.diagnosis')); ?><span class="text-danger">*</span></label>
	                            <textarea name="diagnosis" data-rule-required="true" class="form-control" value="<?php echo e(date('Y-m-d')); ?>"></textarea>
	                            <div class="error"><?php echo e($errors->first('diagnosis')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.actions')); ?> <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="action" data-rule-required="true"></textarea>
	                            <div class="error"><?php echo e($errors->first('action')); ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label"><?php echo e(trans('admin.note')); ?> <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="note" data-rule-required="true"></textarea>
	                            <div class="error"><?php echo e($errors->first('note')); ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="vhc_details" style="display:none;">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h4><i class="fa fa-car"></i> <?php echo e(trans('admin.vehicle')); ?>  <?php echo e(trans('admin.details')); ?> </h4>
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
					<h4><i class="fa fa-wrench"></i><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.parts')); ?></h4>
					<div class="row">
						<table id="partsdata" class="table table-bordered">
							<thead>
								<tr>
									<th><?php echo e(trans('admin.make')); ?></th>
									<th><?php echo e(trans('admin.model')); ?></th>
									<th><?php echo e(trans('admin.year')); ?></th>
									<th><?php echo e(trans('admin.parts')); ?></th>
									<th><?php echo e(trans('admin.qty')); ?></th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
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

		$('#vechicle_id').change(function(){
			var vhc_id = $(this).val();
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
								$('#year').html(resp.arr_vechicle.year);
								$('#chasis_no').html(resp.arr_vechicle.chasis_no);
								$('#vin_no').html(resp.arr_vechicle.vin_no);
								$('#reg_no').html(resp.arr_vechicle.regs_no);
							}
						}

					}
			});
		});

	});


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

		var sel_maker = $('#vechicle_id').find(':selected').data('maker');
		var sel_model = $('#vechicle_id').find(':selected').data('model');
		var sel_year  = $('#vechicle_id').find(':selected').data('year');

		loadModel(sel_maker,parts_rows);
		loadYear(parts_rows);
		loadPart(parts_rows);

		var makeOption = '<option value=""><?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.model')); ?></option>'; 
		if(typeof(arr_make) == 'object')
		{
			$(arr_make).each(function(index,make){
				var selected = '';
				if(sel_maker == make.id){
					selected = 'selected';
				}

				makeOption+='<option value="'+make.id+'" '+selected+'>'+make.make_name+'</option>';
			})
		}

		html  = '<tbody id="parts-row' + parts_rows + '">';
		html += '  <tr>';
		html += '    <td class="left"><select class="form-control" id="make_' + parts_rows + '" name="partsfilter[' + parts_rows + '][make]" onchange="loadModelDatax(this,' + parts_rows + ');">';
		html += makeOption;
		html += '    </td>';

		html += '    <td class="left"><select class="form-control" disabled="disabled" id="model_' + parts_rows + '" name="partsfilter[' + parts_rows + '][model]" onchange="loadYearDatax(this,' + parts_rows + ');">';
		html += '      <option value="">--<?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.model')); ?>--</option>';
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

	function loadModel(maker,row)
	{
		var sel_model = $('#vechicle_id').find(':selected').data('model');
		$.ajax({
				type: "GET",
				url: '<?php echo e(Route('get_model_html','')); ?>/'+maker,
				success: function(response) {
					if(response.status == 'success'){
						$("#model_" + row).html(response.data);
						$("#model_" + row).val(sel_model);
						$("#model_" + row).prop('disabled', false);
					}
					else{
						$("#model_" + row).prop('disabled', true);
					}
				},
			});
	}

	function loadYear(row)
	{
		var sel_maker = $('#vechicle_id').find(':selected').data('maker');
		var sel_model = $('#vechicle_id').find(':selected').data('model');
		var sel_year  = $('#vechicle_id').find(':selected').data('year');

		var post_url = '<?php echo e(Route('get_year_html')); ?>'+'?model_id='+sel_model+'&make_id='+sel_maker;
		$.ajax({
			type: "GET",
			url: post_url,
			success: function(response) {
				if(response.status == 'success'){
					$("#year_" + row).html(response.data);
					$("#year_" + row).val(sel_year);
					$("#year_" + row).prop('disabled', false);
				}
				else{
					$("#year_" + row).prop('disabled', true);
				}
			},
		});
	}

	function loadPart(row)
	{
		var sel_maker = $('#vechicle_id').find(':selected').data('maker');
		var sel_model = $('#vechicle_id').find(':selected').data('model');
		var sel_year  = $('#vechicle_id').find(':selected').data('year');

		var post_url = '<?php echo e(Route('get_parts_html')); ?>'+'?model_id='+sel_model+'&make_id='+sel_maker+'&year_id='+sel_year;
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
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/repair/create.blade.php ENDPATH**/ ?>
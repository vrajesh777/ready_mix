<?php $__env->startSection('main_content'); ?>

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>
		
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<?php if($obj_user->hasPermissionTo('dispatch-vechicle-create')): ?>
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_vehicle" onclick="form_reset()"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.vehicle')); ?></button>
                </li>
                <?php endif; ?>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="vehicleTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.id')); ?></th>
								<th><?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.plate_no')); ?></th>
								<th><?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.plate_letter')); ?></th>
								<th><?php echo e(trans('admin.assign_driver')); ?></th>
								<th><?php echo e(trans('admin.mobile_no')); ?></th>
								<?php if($obj_user->hasPermissionTo('dispatch-vechicle-update')): ?>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($value['id'] ?? ''); ?></td>
										<td><?php echo e($value['name'] ?? ''); ?></td>
										<td><?php echo e($value['plate_no'] ?? ''); ?></td>
										<td><?php echo e($value['plate_letter'] ?? ''); ?></td>
										<td><?php echo e($value['driver_details']['first_name'] ?? ''); ?> <?php echo e($value['driver_details']['last_name'] ?? ''); ?></td>
										<td><?php echo e($value['driver_details']['mobile_no'] ?? ''); ?></td>
										<?php if($obj_user->hasPermissionTo('dispatch-vechicle-update')): ?>
										<td>
											<?php if($value['is_active'] == '1'): ?>
												<a class="btn btn-success btn-sm" href="<?php echo e(Route('vehicle_deactivate', base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
											<?php else: ?>
												<a class="btn btn-danger btn-sm" href="<?php echo e(route('vehicle_activate',base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
											<?php endif; ?>
										</td>
	
										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_vehicle" onclick="vehicle_edit('<?php echo e(base64_encode($value['id'] ?? '')); ?>')"><i class="far fa-edit"></i></a>
										</td>
										<?php endif; ?>

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
<!-- /Content End -->

<!-- Add Modal -->
<div class="modal right fade" id="add_vehicle" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.vehicle')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="<?php echo e(Route('vehicle_store')); ?>" id="frmAddVehicle" enctype="multipart/form-data">
			            	<?php echo e(csrf_field()); ?>

			            	<input type="hidden" name="action" value="create">
							<div class="row">
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="Vehicle Name" data-rule-required="true">
                					<label class="error" id="name_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.plate_letter')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="plate_letter" id="plate_letter" placeholder="Plate Letter" data-rule-required="true">
                					<label class="error" id="plate_letter_error"></label>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.plate_no')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="Plate No" data-rule-required="true">
                					<label class="error" id="plate_no_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.driver')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control select2" id="driver_id" name="driver_id" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.driver')); ?></option>
										<?php if(isset($arr_driver) && sizeof($arr_driver)>0): ?>
											<?php $__currentLoopData = $arr_driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($driver['id'] ?? ''); ?>"><?php echo e($driver['first_name'] ?? ''); ?> <?php echo e($driver['last_name'] ?? ''); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
									<label class="error" id="driver_id_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.vehicle')); ?> <?php echo e(trans('admin.registration')); ?> <span id="lic_req" class="text-danger">*</span>
									<a target="_blank" style="display:none" id="download"><i class="fa fa-download"></i></a>
									</label>
		                           	<div class="position-relative p-0">
		        						<input type="file" class="file-text form-control" name="vehicle_reg" id="vehicle_reg" data-rule-required="true" accept="application/pdf,image/jpeg,image/jpg,image/png">
		    						</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.make')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control select2" id="make_id" name="maker" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.make')); ?></option>
										<?php if(isset($arr_make) && sizeof($arr_make)>0): ?>
											<?php $__currentLoopData = $arr_make; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($make['id'] ?? ''); ?>"><?php echo e($make['make_name'] ?? ''); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
									<label class="error" id="maker_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.model')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control select2" id="model_id" name="model" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.model')); ?></option>
										
									</select>
									<label class="error" id="model_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.year')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control select2" id="year" name="year" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.vehicle')); ?></option>
										
									</select>
									<label class="error" id="year_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.chasis_no')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="chasis_no" id="chasis_no" placeholder="<?php echo e(trans('admin.chasis_no')); ?>" data-rule-required="true">
                					<label class="error" id="chasis_no_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.registration_no')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="regs_no" id="regs_no" placeholder="<?php echo e(trans('admin.registration_no')); ?>" data-rule-required="true">
                					<label class="error" id="regs_no_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.vin_no')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="vin_no" id="vin_no" placeholder="<?php echo e(trans('admin.vin_no')); ?>" data-rule-required="true">
                					<label class="error" id="vin_no_error"></label>
								</div>

							</div>
							
			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></button>
			                </div>
			            </form>
			        </div>
				</div>
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- Add modal -->

<script type="text/javascript">

	var createUrl = "<?php echo e(Route('vehicle_store')); ?>";
	var updateUrl = "<?php echo e(Route('vehicle_update','')); ?>";

	$(document).ready(function(){

		$('.select2').select2();
		
		$('#frmAddVehicle').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#frmAddVehicle").submit(function(e) {

			e.preventDefault();
			var formData = new FormData(this);

			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data: formData,
      				dataType:'json',
      				processData: false,
					contentType: false,
					beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
      				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#add_vehicle").modal('hide');
			form_reset();
		});

		$('#vehicleTable').DataTable({
			// "pageLength": 2
			"order" : [[ 0, 'desc' ]],
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '<?php echo e(Config::get('app.project.title')); ?> Vehicle',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Vehicle PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Vehicle',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Vehicle EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Vehicle CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		$('#make_id').change(function(){
			var make_id = $(this).val();
			load_model(make_id);
		});

		$('#model_id').change(function(){
			var make_id = $('#make_id').val();
			var model_id = $(this).val();
			load_year(make_id,model_id);
		});

	});

	function form_reset() {
		$('#frmAddVehicle')[0].reset();
	}

	function load_model(make_id,selectId='')
	{
		$.ajax({
			url: "<?php echo e(Route('load_model','')); ?>/"+btoa(make_id),
			type:'GET',
			dataType:'json',
			success:function(resp)
			{
				if(typeof(resp.arr_model) == 'object')
				{
					var option = '<option value="">Select Model</option>'; 
					$(resp.arr_model).each(function(index,model){
						var select = '';
						if(selectId == model.id) {
							select = 'selected';
						}
						option+='<option value="'+model.id+'" '+select+' >'+model.model_name+'</option>';
					})

					$('select[name="model"]').html(option);
				}
			}
		})
	}

	function load_year(make_id,model_id,selectId=''){
		var post_url = '<?php echo e(Route('load_year')); ?>'+'?model_id='+btoa(model_id)+'&make_id='+btoa(make_id);
		$.ajax({
			url: post_url,
			type:'GET',
			dataType:'json',
			success:function(resp)
			{
				if(typeof(resp.arr_year) == 'object')
				{
					var option = '<option value="">Select Year</option>'; 
					$(resp.arr_year).each(function(index,year){
						var select = '';
						if(selectId == year.year) {
							select = 'selected';
						}
						option+='<option value="'+year.year+'" '+select+' >'+year.year+'</option>';
					})

					$('select[name="year"]').html(option);
				}
			}
		})
	}

	var arr_make = <?php echo json_encode($arr_make); ?>;
	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	var vehicle_reg_path = "<?php echo e($vehicle_reg_public_path ?? ''); ?>"
	function vehicle_edit(enc_id)
	{
		$('.top_title').html('Edit Vehicle');
		if(enc_id!='')
		{
			$.ajax({
					url:module_url_path+'/edit/'+enc_id,
					type:'GET',
					dataType:'json',
					beforeSend: function() {
				        showProcessingOverlay();
				    },
					success:function(response){
						hideProcessingOverlay();
						if(response.status == 'SUCCESS')
						{
							$('#make_id').val(response.data.maker);
							$('select[name=maker]').select2().trigger('change');

							load_model(response.data.maker,response.data.model);

							load_year(response.data.maker,response.data.model,response.data.year);

							/*$('#year').val(response.data.year);
							$('select[name=year]').select2().trigger('change');*/

							$('#vehicle_reg').attr('data-rule-required',false);
  							$('#lic_req').hide();

							$('#frmAddVehicle').attr('action', updateUrl+'/'+enc_id);
								$('input[name=action]').val('update');

							$('#name').val(response.data.name);
							$('#plate_no').val(response.data.plate_no);
							$('#plate_letter').val(response.data.plate_letter);
							$('#chasis_no').val(response.data.chasis_no);
							$('#regs_no').val(response.data.regs_no);
							$('#vin_no').val(response.data.vin_no);

							$('select[name="driver_id"]').removeAttr('disabled');
			                if(typeof(response.data.arr_driver) == "object"){
			                    var option = '<option value="">Select Driver</option>'; 
			                    
			                    $(response.data.arr_driver).each(function(index,driver){   
			                    	var select = '';
			                    	if(driver.id === response.data.driver_id)
				                    {
				                    	select = 'selected';
				                    }

			                        option+='<option value="'+driver.id+'" '+select+' >'+driver.first_name+' '+driver.last_name+'</option>';
			                    });
			                    $('select[name="driver_id"]').html(option);
			                }

			                $('#vehicle_reg').attr('data-rule-required',false);
  							$('#lic_req').hide();

  							if(response.data.vehicle_reg!=null)
							{
							 	var vehicle_reg = vehicle_reg_path+response.data.vehicle_reg;
							 	$('#download').attr('href',vehicle_reg);
							 	$('#download').show();
							}

						}
					},
					error:function(){
	  					hideProcessingOverlay();
	  				}
			  });
		}
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/delivery/vehicle/index.blade.php ENDPATH**/ ?>
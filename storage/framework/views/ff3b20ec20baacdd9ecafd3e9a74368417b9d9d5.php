<?php $__env->startSection('main_content'); ?>

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<h4><?php echo e(trans('admin.manage')); ?> <?php echo e(trans('admin.make')); ?></h4>
		<div class="card mb-0">
			<div class="card-header">
				<form method="post" action="<?php echo e(Route('vechicle_mym_store')); ?>" id="frmAddMake">
			        <?php echo e(csrf_field()); ?>

			        <input type="hidden" name="type" value="make">
					<div class="row">
						<div class="col-md-4">
							<label class="col-form-label"><?php echo e(trans('admin.make')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
	    					<input type="text" class="form-control" name="make_name" id="make_name" placeholder="<?php echo e(trans('admin.make')); ?> <?php echo e(trans('admin.name')); ?>" data-rule-required="true">
	    					<label class="error" id="first_name_error"></label>
	    					<div class="error"><?php echo e($errors->first('make_name')); ?></div>
						</div>
						<div class="col-md-2">
							<div class="pt-md-0 pt-3">
								<label class="col-form-label d-md-block d-none">&nbsp;</label>
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="btn_make"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
							</div>
						</div>	
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="makeTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.make')); ?></th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_make) && sizeof($arr_make)>0): ?>
								<?php $__currentLoopData = $arr_make; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($make['make_name'] ?? ''); ?></td>
										<td>
											<?php if($make['is_active'] == '1'): ?>
												<a class="btn btn-success btn-sm" href="<?php echo e(Route('make_deactivate', base64_encode($make['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
											<?php else: ?>
												<a class="btn btn-danger btn-sm" href="<?php echo e(route('make_activate',base64_encode($make['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
											<?php endif; ?>
										</td>
										<td><a class="dropdown-item action-edit" href="javascript:void(0);" onclick="make_edit('<?php echo e(base64_encode($make['id'] ?? '')); ?>')"><i class="fa fa-edit"></i></a></td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<br><br>

		<h4><?php echo e(trans('admin.manage')); ?> <?php echo e(trans('admin.model')); ?></h4>
		<div class="card mb-0">
			<div class="card-header">
				<form method="post" action="<?php echo e(Route('vechicle_mym_store')); ?>" id="frmAddModel">
			        <?php echo e(csrf_field()); ?>

			        <input type="hidden" name="type" value="model">
					<div class="row">
						<div class="col-sm-4">
							<label class="col-form-label"><?php echo e(trans('admin.make')); ?><span class="text-danger">*</span></label>
                            <select class="form-control" name="make_id" data-rule-required="true" id="m_make_id">
								<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.make')); ?></option>
								<?php if(isset($arr_make) && sizeof($arr_make)): ?>
									<?php $__currentLoopData = $arr_make; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($make_val['id'] ?? ''); ?>"><?php echo e($make_val['make_name'] ?? 0); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
							<label class="error" id="role_id_error"></label>
						</div>
						<div class="col-md-4">
							<label class="col-form-label"><?php echo e(trans('admin.model')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
	    					<input type="text" class="form-control" name="model_name" id="model_name" placeholder="<?php echo e(trans('admin.model')); ?> <?php echo e(trans('admin.name')); ?>" data-rule-required="true">
	    					<label class="error" id="first_name_error"></label>
	    					<div class="error"><?php echo e($errors->first('model_name')); ?></div>
						</div>
						<div class="col-md-2">
							<div class="pt-md-0 pt-3">
								<label class="col-form-label d-md-block d-none">&nbsp;</label>
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="btn_model"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
							</div>
						</div>	
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="modelTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.make')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.model')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php if(isset($arr_model) && sizeof($arr_model)>0): ?>
							<?php $__currentLoopData = $arr_model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($model['make']['make_name'] ?? ''); ?></td>
									<td><?php echo e($model['model_name'] ?? ''); ?></td>
									<td>
										<?php if($model['is_active'] == '1'): ?>
											<a class="btn btn-success btn-sm" href="<?php echo e(Route('model_deactivate', base64_encode($model['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
										<?php else: ?>
											<a class="btn btn-danger btn-sm" href="<?php echo e(route('model_activate',base64_encode($model['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
										<?php endif; ?>
									</td>
									<td><a class="dropdown-item action-edit" href="javascript:void(0);" onclick="model_edit('<?php echo e(base64_encode($model['id'] ?? '')); ?>')"><i class="fa fa-edit"></i></a></td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<br><br>
		<h4><?php echo e(trans('admin.manage')); ?> <?php echo e(trans('admin.year')); ?></h4>
		<div class="card mb-0">
			<div class="card-header">
				<form method="post" action="<?php echo e(Route('vechicle_mym_store')); ?>" id="frmAddYear">
			        <?php echo e(csrf_field()); ?>

			        <input type="hidden" name="type" value="year">
					<div class="row">
						<div class="col-sm-3">
							<label class="col-form-label"><?php echo e(trans('admin.make')); ?><span class="text-danger">*</span></label>
                            <select class="form-control" id="make_id" name="make_id" data-rule-required="true">
								<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.make')); ?></option>
								<?php if(isset($arr_make) && sizeof($arr_make)): ?>
									<?php $__currentLoopData = $arr_make; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $make_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($make_val['id'] ?? ''); ?>"><?php echo e($make_val['make_name'] ?? 0); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
							<label class="error" id="make_id_error"></label>
						</div>
						<div class="col-sm-3">
							<label class="col-form-label"><?php echo e(trans('admin.model')); ?><span class="text-danger">*</span></label>
                            <select class="form-control" id="model_id" name="model_id" data-rule-required="true">
								<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.model')); ?></option>
								<?php if(isset($arr_model) && sizeof($arr_model)): ?>
									<?php $__currentLoopData = $arr_model; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($model_val['id'] ?? ''); ?>"><?php echo e($model_val['model_name'] ?? 0); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
							<label class="error" id="model_id_error"></label>
						</div>
						<?php
							$start = date('Y');
							$end = date('Y', strtotime('-15 years'));
							$yearArray = range($start,$end);
						?>
						<div class="col-sm-3">
							<label class="col-form-label"><?php echo e(trans('admin.start')); ?> <?php echo e(trans('admin.year')); ?><span class="text-danger">*</span></label>
                            <select class="form-control" id="Year" name="Year" data-rule-required="true">
								<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.start')); ?> <?php echo e(trans('admin.year')); ?></option>
								<?php if(isset($yearArray) && sizeof($yearArray)): ?>
									<?php $__currentLoopData = $yearArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($y ?? ''); ?>"><?php echo e($y ?? ''); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
							<label class="error" id="Year_error"></label>
						</div>
						
						<div class="col-md-2">
							<div class="pt-md-0 pt-3">
								<label class="col-form-label d-md-block d-none">&nbsp;</label>
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="btn_year"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
							</div>
						</div>	
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="yearTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.make')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.model')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.year')); ?></th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php if(isset($arr_year) && sizeof($arr_year)>0): ?>
							<?php $__currentLoopData = $arr_year; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<tr>
									<td><?php echo e($year['make']['make_name'] ?? ''); ?></td>
									<td><?php echo e($year['model']['model_name'] ?? ''); ?></td>
									<td><?php echo e($year['year'] ?? ''); ?></td>
									<td>
										<?php if($year['is_active'] == '1'): ?>
											<a class="btn btn-success btn-sm" href="<?php echo e(Route('year_deactivate', base64_encode($year['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
										<?php else: ?>
											<a class="btn btn-danger btn-sm" href="<?php echo e(route('year_activate',base64_encode($year['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
										<?php endif; ?>
									</td>
									<td><a class="dropdown-item action-edit" href="javascript:void(0);" onclick="year_edit('<?php echo e(base64_encode($year['id'] ?? '')); ?>')"><i class="fa fa-edit"></i></a></td>
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

<script type="text/javascript">

	/*var createUrl = "<?php echo e(Route('vechicle_mym_store')); ?>";
	var updateUrl = "<?php echo e(Route('vc_part_suppy_update','')); ?>";
	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";*/

	$(document).ready(function(){
		$('#frmAddMake').validate({});
		$('#frmAddModel').validate({});
		$('#frmAddYear').validate({});

		$('#makeTable').DataTable({
		});
		$('#modelTable').DataTable({
		});
		$('#yearTable').DataTable({
		});

		$('#make_id').change(function(){
			var make_id = $(this).val();
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

							option+='<option value="'+model.id+'" '+select+' >'+model.model_name+'</option>';
						})

						$('select[name="model_id"]').html(option);
					}
				}
			})
		});
	});

	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	var updateUrl = "<?php echo e(Route('vechicle_mym_update','')); ?>"
	function make_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:"<?php echo e(Route('make_edit','')); ?>/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'success')
							{
  								$('#frmAddMake').attr('action', updateUrl+'/'+enc_id);
								$('#make_name').val(response.data.make_name);
								$('#btn_make').html('Update');
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}

	function model_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:"<?php echo e(Route('model_edit','')); ?>/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'success')
							{
  								$('#frmAddModel').attr('action', updateUrl+'/'+enc_id);
								$('#model_name').val(response.data.model_name);
								$('#m_make_id').val(response.data.make_id);
								$('#btn_model').html('Update');
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}

	function year_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:"<?php echo e(Route('year_edit','')); ?>/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'success')
							{
  								$('#frmAddYear').attr('action', updateUrl+'/'+enc_id);
								$('#Year').val(response.data.year);
								$('#make_id').val(response.data.make_id);
								$('#model_id').val(response.data.model_id);
								$('#btn_year').html('Update');
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
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/vechicle_maintance/make_model_year/index.blade.php ENDPATH**/ ?>
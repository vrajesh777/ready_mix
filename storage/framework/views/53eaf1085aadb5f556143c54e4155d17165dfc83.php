<?php $__env->startSection('main_content'); ?>

<?php
$days = ["Monday","Tuesday" ,"Wednesday","Thursday","Friday","Saturday","Sunday"];
?>
		
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<?php if($obj_user->hasPermissionTo('units-create')): ?>
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_unit" onclick="form_reset()"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.weekends')); ?></button>
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
					<table class="table table-striped table-nowrap custom-table mb-0 datatable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.id')); ?></th>
								<th><?php echo e(trans('admin.name')); ?></th>
								<th>Days</th>
								<th>Department</th>
								<?php if($obj_user->hasPermissionTo('units-update')): ?>
									<th class="text-right"><?php echo e(trans('admin.actions')); ?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$dpt = json_decode($value['dept_id']) ?? [];
										foreach ($dpt as $val) {
											$dept[] = get_dept_name($val);
										}
									?>
									<tr>
										<td><?php echo e($value['id'] ?? ''); ?></td>
										<td><?php echo e($value['name'] ?? ''); ?></td>
										<td><?php echo e(isset($value['days'])?implode(',', json_decode($value['days'])):''); ?></td>
										<td><?php echo e(isset($dept)?implode(',',$dept):''); ?></td>
										<?php if($obj_user->hasPermissionTo('units-update')): ?>
										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_unit" onclick="unit_edit('<?php echo e(base64_encode($value['id'] ?? '')); ?>')"><i class="far fa-edit"></i></a>
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
<div class="modal right fade" id="add_unit" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.weekends')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="<?php echo e(Route('weekends_store')); ?>" id="frmAddUnit">
			            	<?php echo e(csrf_field()); ?>

			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.weekends')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="<?php echo e(trans('admin.name')); ?>" data-rule-required="true">
                					<label class="error" id="unit_code_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.department')); ?> <span class="text-danger">*</span></label>
										<select name="depts[]" class="select2" multiple="" data-rule-required="true">
											<?php if(isset($arr_departments) && !empty($arr_departments)): ?>
											<option value="">All</option>
											<?php $__currentLoopData = $arr_departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($dept['id']??''); ?>"><?php echo e($dept['name']??''); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</select>
										<label class="error" id="depts_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.weekends')); ?> <?php echo e(trans('admin.days')); ?><span class="text-danger">*</span> </label>
										<select name="days[]" class="select2" multiple="" data-rule-required="true">
											<?php if(isset($days) && !empty($days)): ?>
											<option value="">All</option>
											<?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($day ??''); ?>"><?php echo e($day ??''); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</select>
										<label class="error" id="days_error"></label>
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

	var createUrl = "<?php echo e(Route('weekends_store')); ?>";
	var updateUrl = "<?php echo e(Route('weekends_update','')); ?>";

	$(document).ready(function(){

		$('.select2').select2();

		$('#frmAddUnit').validate({
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

		$("#frmAddUnit").submit(function(e) {
			e.preventDefault();
			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
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
			$("#add_unit").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddUnit')[0].reset();
	}

	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	var top_label = "<?php echo e(trans('admin.weekends')); ?>";
	function unit_edit(enc_id)
	{
		$('.top_title').html('Edit '+top_label);

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
								$('#frmAddUnit').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#name').val(response.data.name);

								var val = JSON.parse(response.data.dept_id);
				        		if(val != null) {
					        		$.each(val, function(index, value) {
						        		$('select[name="depts[]"]').find('option').each(function() {
						        			if ($(this).val() == value) {
												$(this).prop("selected","selected");
											}
							            });
						            });
						            $('select[name="depts[]"]').trigger("change");
						        }

						        var days = JSON.parse(response.data.days);
				        		if(days != null) {
					        		$.each(days, function(index, value) {
						        		$('select[name="days[]"]').find('option').each(function() {
						        			if ($(this).val() == value) {
												$(this).prop("selected","selected");
											}
							            });
						            });
						            $('select[name="days[]"]').trigger("change");
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
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/hr/weekends/index.blade.php ENDPATH**/ ?>
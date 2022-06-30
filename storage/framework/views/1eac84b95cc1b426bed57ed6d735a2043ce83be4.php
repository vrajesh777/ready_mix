<?php $__env->startSection('main_content'); ?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <select name="role" class="select" id="role">
		            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.role')); ?></option>		
		            	<?php if(isset($arr_roles) && sizeof($arr_roles)>0): ?>
							<?php $__currentLoopData = $arr_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option  value="<?php echo e($role['id'] ?? ''); ?>" <?php if(isset($roles) && $roles!='' && $roles == $role['id']): ?> selected <?php endif; ?>><?php echo e($role['name'] ?? ''); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</select>
                </li>
                <?php if($obj_user->hasPermissionTo('employee-create')): ?>
	                <li class="list-inline-item">
	                	<a href="<?php echo e(Route('add_emp')); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded"><?php echo e(trans('admin.new')); ?> <?php echo e($module_title??''); ?></a>
	                </li>
	                <li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-user-btn"><?php echo e(trans('admin.quick')); ?> <?php echo e(trans('admin.add')); ?> <?php echo e($module_title??''); ?></button>
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

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="driverTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.id')); ?></th>
								<th><?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.email')); ?></th>
								<th><?php echo e(trans('admin.mobile_no')); ?></th>
								<th><?php echo e(trans('admin.role')); ?></th>
								<?php if($obj_user->hasPermissionTo('employee-update')): ?>
									<th><?php echo e(trans('admin.status')); ?></th>
									<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($value['emp_id'] ?? ''); ?></td>
										<td><?php echo e($value['first_name'] ?? ''); ?> <?php echo e($value['last_name'] ?? ''); ?></td>
										<td><?php echo e($value['email'] ?? ''); ?></td>
										<td><?php echo e($value['mobile_no'] ?? ''); ?></td>
										<td><?php echo e($value['role']['name'] ?? ''); ?></td>
										<?php if($obj_user->hasPermissionTo('employee-update')): ?>
											<td>
												<?php if($value['is_active'] == '1'): ?>
													<a class="btn btn-success btn-sm" href="<?php echo e(Route('user_deactivate', base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive"><?php echo e(trans('admin.active')); ?></a>
												<?php else: ?>
													<a class="btn btn-danger btn-sm" href="<?php echo e(route('user_activate',base64_encode($value['id']))); ?>" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active"><?php echo e(trans('admin.deactive')); ?></a>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item action-edit" href="javascript:void(0);" data-toggle="modal" data-target="#add_user" onclick="user_edit('<?php echo e(base64_encode($value['id'] ?? '')); ?>')"><?php echo e(trans('admin.quick')); ?> <?php echo e(trans('admin.edit')); ?></a>
														<a class="dropdown-item action-edit" href="<?php echo e(Route('user_edit', base64_encode($value['id']??''))); ?>"><?php echo e(trans('admin.edit')); ?></a>
													</div>
												</div>
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
<div class="modal right fade" id="add_user" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close closeForm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.employee')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="<?php echo e(Route('user_store')); ?>" id="frmAddUser">
			            	<?php echo e(csrf_field()); ?>

			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.first_name')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="<?php echo e(trans('admin.first_name')); ?>" data-rule-required="true">
                					<label class="error" id="first_name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.last_name')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="<?php echo e(trans('admin.last_name')); ?>" data-rule-required="true">
                					<label class="error" id="last_name_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.email')); ?><span class="text-danger"></span></label>
                					<input type="email" class="form-control" name="email" id="email" placeholder="<?php echo e(trans('admin.email')); ?>" data-rule-required="false">
                					<label class="error" id="email_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.mobile_no')); ?><span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="<?php echo e(trans('admin.mobile_no')); ?>" data-rule-required="true" data-rule-digits="true">
                					<label class="error" id="mobile_no_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.password')); ?><span class="text-danger"></span></label>
                					<input type="password" class="form-control" name="password" id="password" placeholder="<?php echo e(trans('admin.password')); ?>" data-rule-required="false">
                					<label class="error" id="password_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.confirm')); ?> <?php echo e(trans('admin.password')); ?><span class="text-danger"></span></label>
                					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="<?php echo e(trans('admin.confirm')); ?> <?php echo e(trans('admin.password')); ?>" data-rule-required="true" data-rule-equalTo="#password">
                					<label class="error" id="confirm_password_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.assign')); ?> <?php echo e(trans('admin.role')); ?><span class="text-danger">*</span></label>
		                            <select class="form-control select2" id="role_id" name="role_id" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.role')); ?></option>
										<?php if(isset($arr_roles) && sizeof($arr_roles)>0): ?>
											<?php $__currentLoopData = $arr_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($role['id'] ?? ''); ?>"><?php echo e($role['name'] ?? ''); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
									<label class="error" id="role_id_error"></label>
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

	var createUrl = "<?php echo e(Route('user_store')); ?>";
	var updateUrl = "<?php echo e(Route('user_update','')); ?>";
	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";

	$(document).ready(function(){

		$('.select2').select2();

		initiate_form_validate();

		$("#add-user-btn").click(function(){
			form_reset();
			$('.top_title').html('Add Employee');
			$('input[name=password]').attr('data-rule-required', true);
			$('input[name=confirm_password]').attr('data-rule-required', true);
			initiate_form_validate();
			$("#add_user").modal('show');
		});

		$("#frmAddUser").submit(function(e) {

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
			$("#add_user").modal('hide');
			form_reset();
		});

		$('#driverTable').DataTable({
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
				title: '<?php echo e(Config::get('app.project.title')); ?> Drivers',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Drivers PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Drivers',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Drivers EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Drivers CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		$('#role').change(function(){
			var role = $("#role option:selected").val();
			window.location.href = module_url_path+'?type='+btoa(role);
		})
	});

	function form_reset() {
		$('#frmAddUser')[0].reset();
	}

	function user_edit(enc_id)
	{
		$('.top_title').html('Edit Employee');
		if(enc_id!='')
		{
			$.ajax({
				url:module_url_path+'/edit/'+enc_id,
				type:'GET',
				dataType:'json',
				beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status == 'SUCCESS')
					{
						$('#frmAddUser').attr('action', updateUrl+'/'+enc_id);
						$('input[name=action]').val('update');

						$('input[name=password]').attr('data-rule-required', false);
						$('input[name=confirm_password]').attr('data-rule-required', false);

						$('#first_name').val(response.data.first_name);
						$('#last_name').val(response.data.last_name);
						$('#email').val(response.data.email);
						$('#mobile_no').val(response.data.mobile_no);

						$('select[name^="role_id"] option[value="'+response.data.role_id+'"]').attr("selected","selected");
						$('.select2').trigger('change');

						$('#role_id').attr('disabled','true');
					}
				},
				error:function(){
  					hideProcessingOverlay();
  				}
		  });
		}
	}

	function initiate_form_validate() {
		$('#frmAddUser').validate({
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
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/user/index.blade.php ENDPATH**/ ?>
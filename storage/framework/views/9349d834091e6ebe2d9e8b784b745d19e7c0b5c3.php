<?php $__env->startSection('main_content'); ?>

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>

<link rel="stylesheet" href="<?php echo e(asset('/css/week-calendar.css')); ?>">

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form method="GET" action="<?php echo e(Route('leave_balance')); ?>" id="filterForm">
				<ul class="list-inline-item pl-0 d-flex">
					<li class="list-inline-item">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item" style="width:20%">
	                    <select name="type" class="select" id="type">
			            	<option value="">Select Type</option>
			            	<option value="paid" <?php if(isset($type) && $type!='' && $type == 'paid'): ?> selected <?php endif; ?>><?php echo e(trans('admin.paid')); ?></option>
							<option value="unpaid" <?php if(isset($type) && $type!='' && $type == 'unpaid'): ?> selected <?php endif; ?>><?php echo e(trans('admin.unpaid')); ?></option>
							<option value="on_duty" <?php if(isset($type) && $type!='' && $type == 'on_duty'): ?> selected <?php endif; ?>><?php echo e(trans('admin.on_duty')); ?></option>
							<option value="restricted_holidays" <?php if(isset($type) && $type!='' && $type == 'restricted_holidays'): ?> selected <?php endif; ?>><?php echo e(trans('admin.restricted_holidays')); ?></option>
						</select>
	                </li>
	                <li class="list-inline-item" style="width:20%">
	                    <select name="leave_type[]" class="select2" multiple="">
							<?php if(isset($arr_leave_type) && !empty($arr_leave_type)): ?>
							<option value="">All</option>
								<?php $__currentLoopData = $arr_leave_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($type['id']??''); ?>" <?php if(isset($leave_type_ids) && $leave_type_ids!='' && in_array($type['id'], $leave_type_ids)): ?> selected <?php endif; ?>><?php echo e($type['title']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
	                </li>
	                <li class="list-inline-item" style="width:15%">
	                    <select name="department[]" class="select2" multiple="">
							<?php if(isset($arr_departments) && !empty($arr_departments)): ?>
								<option value="">All</option>
								<?php $__currentLoopData = $arr_departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($dept['id']??''); ?>" <?php if(isset($dept_ids) && $dept_ids!='' && in_array($dept['id'], $dept_ids)): ?> selected <?php endif; ?>><?php echo e($dept['name']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
	                </li>
	                <li class="list-inline-item" style="width:20%">
	                    <select name="employee[]" class="select2" multiple="">
							<?php if(isset($arr_employees) && !empty($arr_employees)): ?>
							<option value="">All</option>
								<?php $__currentLoopData = $arr_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($emp['id']??''); ?>" <?php if(isset($emp_ids) && $emp_ids!='' && in_array($emp['id'], $emp_ids)): ?> selected <?php endif; ?>><?php echo e($emp['first_name']??''); ?> <?php echo e($emp['last_name']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
	                </li>
	               
	                <li class="list-inline-item">
	                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
	                </li>
	                <li class="list-inline-item">
	                	<button type="submit" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3">Search</button>
	                </li>
	            </ul>
        	</form>
		</div>
		
		
	</div>
</div>
<!-- /Page Header -->

<div class="card mb-0">
	<div class="card-body">
		<div class="">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th><?php echo e(trans('admin.employee')); ?></th>
						<?php if(isset($arr_leave_type) && !empty($arr_leave_type)): ?>
							<?php $__currentLoopData = $arr_leave_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<th colspan="2"><?php echo e($leave_type['title']??''); ?></th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</tr>
					<tr>
						<th></th>
						<?php if(isset($arr_leave_type) && !empty($arr_leave_type)): ?>
							<?php $__currentLoopData = $arr_leave_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<th>Taken</th>
								<th>Balance</th>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</tr>
				</thead>
					<tbody>
						<?php if(isset($arr_users) && !empty($arr_users)): ?>
						<?php $__currentLoopData = $arr_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							$leave_type_bal = $user['leave_type_bal']??[];
							$taken_leave = $user['taken_leave']??[];
						?>
						<tr>
							<th>
								<?php echo e($user['first_name']??''); ?> 
								<?php echo e($user['last_name']??''); ?>

							</th>
							<?php if(isset($arr_leave_type) && !empty($arr_leave_type)): ?>
								<?php $__currentLoopData = $arr_leave_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$bal = $leave_type_bal[($leave_type['id']??'')] ?? 0;
										$bal = ($bal) - ($taken_leave[($leave_type['id']??'')] ?? 0)
									?>
									<td>
										<?php if((isset($taken_leave[($leave_type['id']??'')]) && $taken_leave[($leave_type['id']??'')]!='') || (isset($leave_type_bal[($leave_type['id']??'')]) && $leave_type_bal[($leave_type['id']??'')]!='')): ?>
											<?php echo e($taken_leave[($leave_type['id']??'')] ?? 0); ?>

										<?php else: ?>
											N/A
										<?php endif; ?>
									</td>
									<td>
										<?php if(isset($leave_type_bal[($leave_type['id']??'')]) && $leave_type_bal[($leave_type['id']??'')]!=''): ?>
											<?php echo e($bal ?? 0); ?>

										<?php else: ?>
											N/A
										<?php endif; ?>
									</td>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</tbody>
			</table>
		</div>
	</div>
</div>

<!-- /Content End -->
<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>

<script type="text/javascript">

	$(document).ready(function() {

		$('.select2').select2();

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '<?php echo e($sdt??''); ?>',
		    endDate: '<?php echo e($edt??''); ?>'
		})
		.on('changeDate', function(e) {
			//$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			//$('#dateRange').trigger('changeDate');
		});

		/*$('select[name="leave_type[]"]').change(function() {
			var total = $('select[name="leave_type[]"] option:selected').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');

				$('select[name="except_depts[]"]').val([]);
				$('select[name="except_depts[]"]').trigger('change');
				$('.except_depts-wrap').hide();
			}else{
				$('.except_depts-wrap').show();
			}
		});*/
	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('leave_balance')); ?>";
	});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/hr/leave_application/leave_balance_calender.blade.php ENDPATH**/ ?>
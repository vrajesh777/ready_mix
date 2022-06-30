<?php $__env->startSection('auth_main_content'); ?>

<!-- Account Logo -->
<div class="account-logo">
	<a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('/images/logo.png')); ?>" alt=""></a>
</div>
<!-- /Account Logo -->

<div class="account-box">
	<div class="account-wrapper">
		<h3 class="account-title"><?php echo e(trans('admin.inquiry')); ?></h3>

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<!-- Account Form -->
		<form action="<?php echo e(Route('submit_inuiry')); ?>" method="POST" id="inquiryForm">
			<?php echo e(csrf_field()); ?>

			<div class="form-group">
				<label>Subject <span class="text-danger">*</span></label>
				<input type="text" name="subject" class="form-control" value="<?php echo e(old('subject')); ?>" data-rule-required="true" >
				<label class="error"><?php echo e($errors->first('subject')); ?></label>
			</div>

			<div class="form-group">
				<label><?php echo e(trans('admin.medium')); ?> <span class="text-danger">*</span></label>
				<select name="medium" class="form-control" data-rule-required="true">
					<option value="">-- <?php echo e(trans('admin.select')); ?> --</option>
					<option value="google">Google</option>
					<option value="facebook">Facebook</option>
					<option value="email">Email</option>
					<option value="physical">Physical</option>
				</select>
				<label class="error"><?php echo e($errors->first('medium')); ?></label>
			</div>

			<div class="form-group">
				<label><?php echo e(trans('admin.first_name')); ?><span class="text-danger">*</span></label>
				<input type="text" name="cust_name" class="form-control" value="<?php echo e(old('cust_name')); ?>" data-rule-required="true" >
				<label class="error"><?php echo e($errors->first('cust_name')); ?></label>
			</div>

			<div class="form-group">
				<label><?php echo e(trans('admin.email')); ?> <span class="text-danger">*</span></label>
				<input type="text" name="email" class="form-control" value="<?php echo e(old('email')); ?>" data-rule-required="true" data-rule-email="true" >
				<label class="error"><?php echo e($errors->first('email')); ?></label>
			</div>

			<div class="form-group">
				<label><?php echo e(trans('admin.requirement_details')); ?> <span class="text-danger">*</span></label>
				<textarea name="requirement" class="form-control"><?php echo e(old('requirement')); ?></textarea>
				<label class="error"><?php echo e($errors->first('requirement')); ?></label>
			</div>

			<div class="form-group">
				<label><?php echo e(trans('admin.additional')); ?> <?php echo e(trans('admin.note')); ?></label>
				<textarea name="note" class="form-control"><?php echo e(old('note')); ?></textarea>
				<label class="error"><?php echo e($errors->first('note')); ?></label>
			</div>

			<div class="form-group text-center">
				<button class="btn btn-primary account-btn" type="submit"><?php echo e(trans('admin.submit')); ?></button>
			</div>
		</form>
		<!-- /Account Form -->

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#inquiryForm').validate();
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/inquiry/create.blade.php ENDPATH**/ ?>
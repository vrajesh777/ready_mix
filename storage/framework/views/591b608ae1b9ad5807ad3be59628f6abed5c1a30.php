<?php $__env->startSection('auth_main_content'); ?>

<!-- Account Logo -->
<div class="account-logo">
	<a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('/images/logo.png')); ?>" alt=""></a>
</div>
<!-- /Account Logo -->

<div class="account-box">
	<div class="account-wrapper">
		<h3 class="account-title">Login</h3>
		<p class="account-subtitle">Access to our dashboard</p>

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<!-- Account Form -->
		<form action="<?php echo e(Route('process_login')); ?>" method="POST" id="loginForm">
			<?php echo e(csrf_field()); ?>

			<div class="form-group">
				<label>Email Address</label>
				<input type="text" name="email" class="form-control" value="<?php echo e(old('email')); ?>" data-rule-required="true" data-rule-email="true" >
				<label class="error"><?php echo e($errors->first('email')); ?></label>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col">
						<label>Password</label>
					</div>
					<div class="col-auto">
						<a class="text-muted" href="<?php echo e(Route('forgot-password')); ?>">
							Forgot password?
						</a>
					</div>
				</div>
				<input type="password" name="password" class="form-control" data-rule-required="true" >
				<label class="error"><?php echo e($errors->first('password')); ?></label>
			</div>
			<div class="form-group text-center">
				<button class="btn btn-primary account-btn" type="submit">Login</button>
			</div>
			<div class="account-footer">
				<p>Want to inquire? <a href="<?php echo e(Route('inquire')); ?>">Inquire now</a></p>
			</div>
		</form>
		<!-- /Account Form -->

	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#loginForm').validate();
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('auth.auth_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/auth/login.blade.php ENDPATH**/ ?>
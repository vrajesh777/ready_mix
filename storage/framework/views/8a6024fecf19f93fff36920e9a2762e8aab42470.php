<!-- Header -->
<?php echo $__env->make('layout._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- Sidebar -->
<?php echo $__env->make('layout._sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- /Sidebar -->

<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
		<?php echo $__env->yieldContent('main_content'); ?>
	</div>
</div>
<!-- /Page Wrapper -->

<?php echo $__env->make('layout._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/layout/master.blade.php ENDPATH**/ ?>
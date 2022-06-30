<?php $__env->startSection('main_content'); ?>

<div class="row align-items-center">
	<h4 class="col-md-8 card-title mt-0 mb-2">#<?php echo e($arr_cust['id']??''); ?> <?php echo e($arr_cust['first_name']??''); ?> <?php echo e($arr_cust['last_name']??''); ?></h4>
</div>

<?php
	$module_segment       = Request::get('page', 'profile');
?>

<div class="row all-reports m-0">

	<?php echo $__env->make('customers._sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


	<?php echo $__env->make("customers.$module_segment", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('.datatables').DataTable({searching: true, paging: true, info: true});

		$(".profile-tabs > li:first-child a").trigger('click');
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/view.blade.php ENDPATH**/ ?>
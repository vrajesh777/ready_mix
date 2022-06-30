<?php
	$module_segment       = Request::get('page');
?>
<div class="col-md-3 p-0">
	<ul class="nav nav-tabs card p-0 mb-0" id="reports" role="tablist">
		<li class="nav-item w-100">
			<a  href="<?php echo e(Route('view_customer',$enc_id)); ?>" class="nav-link border-bottom text-body <?php if($module_segment == ''): ?> active <?php endif; ?>"><i class="fal fa-user mr-2"></i>Profile</a>
		</li>
		<li class="nav-item w-100">
			<a href="<?php echo e(Route('view_customer',[$enc_id, 'page'=>'contacts'])); ?>" class="nav-link border-bottom text-body <?php if($module_segment == 'contacts'): ?> active <?php endif; ?>"><i class="fal fa-address-card mr-2"></i><?php echo e(trans('admin.contacts')); ?></a>
		</li>
		<li class="nav-item w-100">
			<a href="<?php echo e(Route('view_customer',[$enc_id, 'page'=>'account'])); ?>" class="nav-link border-bottom text-body <?php if($module_segment == 'account'): ?> active <?php endif; ?>"><i class="fal fa-handshake mr-2"></i><?php echo e(trans('admin.account')); ?></a>
		</li>
		<li class="nav-item w-100">
			<a href="<?php echo e(Route('view_customer',[$enc_id, 'page'=>'invoices'])); ?>" class="nav-link border-bottom text-body <?php if($module_segment == 'invoices'): ?> active <?php endif; ?>"><i class="fal fa-shopping-cart mr-2"></i><?php echo e(trans('admin.invoices')); ?></a>
		</li>
		<li class="nav-item w-100">
			<a href="<?php echo e(Route('view_customer',[$enc_id, 'page'=>'payments'])); ?>" class="nav-link border-bottom text-body <?php if($module_segment == 'payments'): ?> active <?php endif; ?>"><i class="fal fa-credit-card mr-2"></i><?php echo e(trans('admin.payments')); ?></a>
		</li>
		<li class="nav-item w-100">
			<a href="<?php echo e(Route('view_customer',[$enc_id, 'page'=>'proposals'])); ?>" class="nav-link border-bottom text-body <?php if($module_segment == 'proposals'): ?> active <?php endif; ?>"><i class="fal fa-clipboard mr-2"></i><?php echo e(trans('admin.proposals')); ?></a>
		</li>
		<li class="nav-item w-100">
			<a href="<?php echo e(Route('view_customer',[$enc_id, 'page'=>'estimates'])); ?>" class="nav-link border-bottom text-body <?php if($module_segment == 'estimates'): ?> active <?php endif; ?>"><i class="fal fa-paperclip mr-2"></i><?php echo e(trans('admin.estimates')); ?></a>
		</li>
	</ul>
</div><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/customers/_sidebar.blade.php ENDPATH**/ ?>
<!-- HEader -->
<?php echo $__env->make('auth._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->yieldContent('auth_main_content'); ?>

<?php echo $__env->make('auth._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/auth/auth_master.blade.php ENDPATH**/ ?>
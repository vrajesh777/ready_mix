<?php if(Session::has('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> <?php echo Session::get('success'); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<?php endif; ?>  

<?php if(Session::has('error')): ?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> <?php echo Session::get('error'); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>

<?php endif; ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/layout/_operation_status.blade.php ENDPATH**/ ?>
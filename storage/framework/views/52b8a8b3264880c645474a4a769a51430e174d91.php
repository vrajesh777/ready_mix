<?php $__env->startSection('main_content'); ?>

<body>
<div class="row no-print">
<div class="col-md-12">
<div class="card mb-0">
<div class="card-body">

<div class="page-header pt-3 mb-0 ">
	<div class="row">
    <div class="col-md-12">
       <?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
		<!-- <div class="col"> -->
      <input type="hidden" name="report_type" id="report_type" value="<?php echo e($type??''); ?>">
			<div class="col-sm-4 delivery-list">
			<select class="form-control" onchange="displayReport(this.value)" id="delivery_type" name="delivery_type">
          <option value="">Select Type</option>
          <option value="cube">Cube</option>
          <option value="cylinder">Cylinder</option>
      </select>
			</div>
       
		<!-- </div> -->
	</div>
</div>

</div>
</div>
</div>

</body>
<script type="text/javascript">
  function displayReport(delivery_type)
  {
    var url = "<?php echo e(url('/')); ?>";
    var report_type = $('#report_type').val();
    if(delivery_type=='cube')
    {
      module_url_path = url+'/cube/'+report_type;
    }
    else
    {
        module_url_path = url+'/cylinder/'+report_type;
    }
    window.location.href = module_url_path;
  }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/qc_report/index.blade.php ENDPATH**/ ?>
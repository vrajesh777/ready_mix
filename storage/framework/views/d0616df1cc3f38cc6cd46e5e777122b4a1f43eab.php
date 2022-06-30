<?php $__env->startSection('main_content'); ?>
<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form action="" id="filterForm">
			<ul class="list-inline-item pl-0 d-flex">
				<li class="list-inline-item">
					<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
				</li>
                <li class="list-inline-item">
                    <select name="reject_by" class="select" id="reject_by">
		            	<option value=""><?php echo e(trans('admin.select')); ?></option>
						<option value="1" <?php if(isset($reject_by) && $reject_by!='' && $reject_by == '1'): ?> selected <?php endif; ?>><?php echo e(trans('admin.internal_reason')); ?></option>
						<option value="2" <?php if(isset($reject_by) && $reject_by!='' && $reject_by == '2'): ?> selected <?php endif; ?>><?php echo e(trans('admin.customer_end')); ?></option>
					</select>
                </li>
                <li class="list-inline-item">
                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
                </li>
            </ul>
        	</form>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="driverTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.cust')); ?></th>
								<th><?php echo e(trans('admin.customer')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.load_no')); ?></th>
					            <th><?php echo e(trans('admin.truck')); ?></th>
					            <th><?php echo e(trans('admin.loaded_cbm')); ?></th>
					            <th><?php echo e(trans('admin.rej')); ?>(M³)</th>
					            <th><?php echo e(trans('admin.rej_by')); ?></th>
					            <th><?php echo e(trans('admin.driver')); ?></th>
					            <th><?php echo e(trans('admin.del_date')); ?></th>
					            
					            <th><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							    	<?php
							    		$driver = $note['driver']??[];
							    		$vehicle = $note['vehicle']??[];

							    		$del_date = Carbon::parse($note['delivery_date'])->format('Y-m-d');
							    	?>
							    	<tr>
							    		<td><?php echo e($note['order_details']['order']['cust_id'] ?? 0); ?></td>
							    		<td><?php echo e($note['order_details']['order']['cust_details']['first_name'] ?? ''); ?> <?php echo e($note['order_details']['order']['cust_details']['last_name'] ?? ''); ?></td>
							    		<td><?php echo e($note['load_no'] ?? 0); ?></td>
							            <td><?php echo e($vehicle['name']??''); ?>&nbsp;
							            	(<?php echo e($vehicle['plate_no']??''); ?> <?php echo e($vehicle['plate_letter']??''); ?>)
							            </td>
							            <td><?php echo e($note['quantity']??''); ?></td>
							            <td><?php echo e($note['reject_qty']?? 0); ?></td>
							            <td>
							           		<?php if($note['reject_by']!='' && $note['reject_by'] == '1'): ?>
							           			Readymix
							           		<?php elseif($note['reject_by']!='' && $note['reject_by'] == '2'): ?>
							           			Customer
							           		<?php endif; ?>
							            </td>
							            <td><?php echo e($driver['first_name']??''); ?>&nbsp;
							            	<?php echo e($driver['last_name']??''); ?>

							            </td>
							            <td><?php echo e(date_format_dd_mm_yy($note['delivery_date'] ?? '')??''); ?></td>
							            
							            <td>
							            	<a class="btn btn-primary btn-sm rej_details" id="rej_details" href="javascript:void(0);" data-toggle="modal" data-target="#details_model" data-rejected-by="<?php echo e($note['reject_by'] ?? ''); ?>" data-rejected-reason="<?php echo e($note['remark']?? 0); ?>" data-rejected-qty="<?php echo e($note['reject_qty']?? 0); ?>" data-note-id="<?php echo e(base64_encode($note['id'])); ?>"><i class="fa fa-eye" title="<?php echo e(trans('admin.details')); ?>"></i></a>
							            </td>
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
<!-- Edit Qty Modal -->
<div class="modal fade right" id="details_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center"><?php echo e(trans('admin.rejection_details')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<ul class="personal-info">
					<li>
						<div class="title"><?php echo e(trans('admin.rejected_by')); ?></div>
						<div class="text" id="rej_by"></div>
					</li>
					<li>
						<div class="title"><?php echo e(trans('admin.rejected_reason')); ?></div>
						<div class="text" id="rej_re"></div>
					</li>
					<li>
						<div class="title"><?php echo e(trans('admin.rejected')); ?> M³</div>
						<div class="text" id="rej_qt"></div>
					</li>
				</ul>

			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->
<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>

<script type="text/javascript">

	$(document).ready(function(){
		$('#driverTable').DataTable({
			});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '<?php echo e($sdt??''); ?>',
		    endDate: '<?php echo e($edt??''); ?>'
		})
		.on('changeDate', function(e) {
			$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$("#reject_by").change(function() {
			$("#filterForm").submit();
		});
	});

	var readymix = "<?php echo e(trans('admin.readymix')); ?>";
	var customer = "<?php echo e(trans('admin.customer')); ?>";

	$('body').on('click','.rej_details',function(){
		var rej_by = $(this).data('rejected-by');
		var rej_re = $(this).data('rejected-reason');
		var rej_qt = $(this).data('rejected-qty');
		if(rej_by == 1){
			var by = readymix;
		}
		else if(rej_by == 2){
			var by = customer;
		}
		$('#rej_by').html(by);
		$('#rej_re').html(rej_re);
		$('#rej_qt').html(rej_qt);
	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('rejected_del')); ?>";
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/delivery/rejected_del/index.blade.php ENDPATH**/ ?>
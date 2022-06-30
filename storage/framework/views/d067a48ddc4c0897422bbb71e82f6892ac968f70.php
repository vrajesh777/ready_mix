<?php $__env->startSection('main_content'); ?>

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>
<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js')); ?>/daterangepicker.min.js"></script>
<link href="<?php echo e(asset('/css/')); ?>/daterangepicker.css" rel="stylesheet" />
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col-sm-12">
			<form action="<?php echo e($module_url_path); ?>/confirmed_invoice" method="get" id="filterDeliveryForm" name="filterDeliveryForm">
				<ul class="list-inline-item pl-0">
					<li class="list-inline-item mb-2">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item mb-2">
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

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 deliveryNotesTable" id="deliveryNotesTable">
						<thead>
							<tr>
								
								<th><?php echo e(trans('admin.delivery_no')); ?></th>
					            <th><?php echo e(trans('admin.truck')); ?></th>
					            <th><?php echo e(trans('admin.loaded_cbm')); ?></th>
					            <th>Exess(M³)</th>
					            <th><?php echo e(trans('admin.rej')); ?>(M³)</th>
					            <th><?php echo e(trans('admin.rej_by')); ?></th>
					            <th><?php echo e(trans('admin.driver')); ?></th>
					            <th><?php echo e(trans('admin.del_date')); ?></th>
					            <th><?php echo e(trans('admin.status')); ?></th>
					            <th><?php echo e(trans('admin.actions')); ?></th>
								
							</tr>
						</thead>
						<tbody>
  							<?php if(isset($arr_delivery_note) && count($arr_delivery_note)>0): ?>
							<?php $__currentLoopData = $arr_delivery_note; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						    	<?php
						    		$driver = $note['driver']??[];
						    		$vehicle = $note['vehicle']??[];

						    		$del_date = Carbon::parse($note['delivery_date'])->format('Y-m-d');
						    	?>
						    	
							    	<tr>
							    		<td><?php echo e($note['delivery_no']??''); ?></td>
							            <td><?php echo e($vehicle['name']??''); ?>&nbsp;
							            	(<?php echo e($vehicle['plate_no']??''); ?> <?php echo e($vehicle['plate_letter']??''); ?>)
							            </td>
							            <td><?php echo e($note['quantity']??''); ?></td>
							            <td><?php echo e($note['excess_qty']?? ''); ?></td>
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
							            <td><?php echo e($note['status']??''); ?></td>
							            <td>
							            	<a class="btn btn-sm btn-info" href="<?php echo e(Route('dowload_del_note',base64_encode($note['id']))); ?>" target="_blank" title="<?php echo e(trans('admin.download_delivery_note')); ?>" ><i class="fa fa-download"></i></a>
											<?php if($note['is_pushed_to_erp']=='0'): ?>
											 <a class="btn btn-primary btn-sm"  id="add_to_erp" href="<?php echo e(Route('add_to_erp',base64_encode($note['id']))); ?>">Push To ERP</a>
							            	<?php endif; ?>
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

<script type="text/javascript">

	$(document).ready(function() {

		$('#deliveryNotesTable').DataTable({});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '<?php echo e($sdt??''); ?>',
		    endDate: '<?php echo e($edt??''); ?>'
		})
		.on('changeDate', function(e) {
			$('#filterDeliveryForm').submit();
			//load_delivery_note();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$('.change_status').click(function(){

			var status = $(this).data('status');
			var enc_id = $(this).data('note-id');
			$('#enc_order_id').val(enc_id);
			$('#delivery_status').val(status);
		})
		$('#frm_change_status').validate();
	});
	


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/finance/confirmed_invoice.blade.php ENDPATH**/ ?>
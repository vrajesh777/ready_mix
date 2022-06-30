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
			<form action="<?php echo e($module_url_path); ?>/delivery_invoice" method="get" id="filterDeliveryForm" name="filterDeliveryForm">
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
						    		$is_added_on_erp = $note['is_pushed_to_erp']??0;
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

							            	<?php if(isset($note['status']) && $note['status']=='pending'): ?>
							            	<a class="btn btn-primary btn-sm"  onclick="change_confirm_status('<?php echo e(base64_encode($note['id'])); ?>')">Confirm Invoice</a>

							            	<button type="button" class="btn btn-danger" onclick="change_cancel_status('<?php echo e(base64_encode($note['id'])); ?>')">Cancel Invoice
								            </button>					            	

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
<div class="modal fade right" id="change_status_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">Change Invoice Status</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST"  id="frm_change_status">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" name="enc_order_id" id="enc_order_id">
					<input type="hidden" name="delivery_status" id="delivery_status">
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Enter Reason</label>
							<input type="text" class="form-control reason" name="reason" placeholder="Enter Reason" data-rule-required="true" data-rule-maxlength="255">
							<label class="error" id="reason_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
		                	<button type="button" onclick="window.location.href='<?php echo e($module_url_path); ?>'" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></button>
		                </div>
				           
				        </div>
					</div>

				</form>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
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

		$('#frm_change_status').validate();
		$('#frm_change_status').on('submit',function(event){
			 event.preventDefault()
			if($('#frm_change_status').valid())
			{

				    var form = $('#frm_change_status')[0];
		            var data = new FormData(form);
		            $.ajax({
		                    type: "POST",
		                    url: "<?php echo e($module_url_path); ?>/change_delivery_status",
		                    data:data,
		                    processData: false,
		                    contentType: false,
		                    cache: false,
		                    beforeSend:function(){
							showProcessingOverlay();
						    },
		                    success: function(response){
		                       	hideProcessingOverlay();
								common_ajax_store_action(response);
		                    }
		                }); 
			}
		})
		
	});
	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('delivery_invoice')); ?>";
	});
	function change_cancel_status(enc_id)
	{
		$('#enc_order_id').val(enc_id);
		$('#change_status_model').modal('show');
	}
	function change_confirm_status(enc_id)
	{
		 if(enc_id!="")
		 {
		 	$.ajax({
						url:"<?php echo e($module_url_path); ?>/change_confirm_invoice/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){
							showProcessingOverlay();
						},
						success:function(response){
							hideProcessingOverlay();
							common_ajax_store_action(response);
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		 }
	}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/finance/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('main_content'); ?>

<!-- Content Starts -->
<form id="preview_setting_form" method="get" action="#" onsubmit="return false;">
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-0">
				<div class="card-body">
					<h4><?php echo e(trans('admin.generate_lable')); ?></h4>
					<div class="row">
						<div class="form-group col-sm-8">
							<select name="part_id" class="select" id="part_id">
				            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.parts')); ?></option>
				            	<?php if(isset($arr_parts) && sizeof($arr_parts)>0): ?>
									<?php $__currentLoopData = $arr_parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option  value="<?php echo e($parts['part_id']??''); ?>" data-part-id="<?php echo e($parts['part_id'] ?? ''); ?>" data-part-no="<?php echo e($parts['part_no'] ?? ''); ?>"><?php echo e($parts['part']['commodity_name']??''); ?> <?php echo e($parts['part_no']??''); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">
							<table class="table table-bordered table-striped table-condensed" id="product_table">
								<thead>
									<tr>
										<th class="col-sm-8"><?php echo e(trans('admin.parts')); ?></th>
										<th class="col-sm-4"><?php echo e(trans('admin.no_of_lables')); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php echo $__env->make('vechicle_maintance.print_labels.show_table_rows', ['index' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<hr/>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-0">
				
				<div class="card-body">
					<h4><?php echo e(trans('admin.info_to_show_on_lable')); ?></h4>
					<div class="row">
						<div class="col-sm-3">
							<div class="checkbox">
							    <label>
							    	<input type="checkbox" checked name="print[name]" value="1"> <b><?php echo e(trans('admin.part_name')); ?></b>
							    </label>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="checkbox">
							    <label>
							    	<input type="checkbox" checked name="print[variations]" value="1"> <b><?php echo e(trans('admin.part_no')); ?></b>
							    </label>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="checkbox">
							    <label>
							    	<input type="checkbox" checked name="print[price]" value="1" id="is_show_price"> <b><?php echo e(trans('admin.part_price')); ?></b>
							    </label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<hr/>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-0">
				
				<div class="card-body">
					<h4><?php echo e(trans('admin.barcode')); ?> <?php echo e(trans('admin.setting')); ?></h4>
					<div class="row">
						<div class="col-sm-6">
							<select class="form-control" name="barcode_setting" id="code_id">
				            	<?php if(isset($arr_barcodes) && sizeof($arr_barcodes)>0): ?>
									<?php $__currentLoopData = $arr_barcodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barcode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option  value="<?php echo e($barcode['id']??''); ?>"><?php echo e($barcode['name']??''); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="text-center py-3">
	                	<button type="submit" id="labels_preview" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.preview')); ?></button>
	                </div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Content End -->

<script type="text/javascript">

	$(document).ready(function(){

		//window.location.href="<?php echo e(Route('print_labels')); ?>";

		$('button#labels_preview').click(function() {
	        if ($('form#preview_setting_form table#product_table tbody tr').length > 0) {
	            //var url = base_path + '/labels/preview?' + $('form#preview_setting_form').serialize();
	            var url = "<?php echo e(Route('print_labels_preview','')); ?>?" + $('form#preview_setting_form').serialize();

	            window.open(url, 'newwindow');

	        } else {
	            swal(LANG.label_no_product_error).then(value => {
	                $('#search_product_for_label').focus();
	            });
	        }
	    });

	    $(document).on('click', 'button#print_label', function() {
	        window.print();
	    });

	});

	$('#part_id').change(function(){
		var part_id = $('#part_id').find(':selected').data('part-id');
		var part_no = $('#part_id').find(':selected').data('part-no');
		get_label_product_row(part_id,part_no);
	});

	function get_label_product_row(part_id, part_no) {
    if (part_id) {
        var row_count = $('table#product_table tbody tr').length;
        $.ajax({
            method: 'GET',
            url: '<?php echo e(Route('print_labels_row')); ?>',
            dataType: 'html',
            data: { part_id: part_id, row_count: row_count, part_no: part_no },
            success: function(result) {
                $('table#product_table tbody').append(result);
            },
        });
    }
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/vechicle_maintance/print_labels/index.blade.php ENDPATH**/ ?>
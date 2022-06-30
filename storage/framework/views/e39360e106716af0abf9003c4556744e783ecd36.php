<?php $__env->startSection('main_content'); ?>

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_item" onclick="form_reset()"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.parts')); ?></button>
                </li>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<div class="row">
	<div class="col-sm-12">
		<div class="card mb-0">
			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="itemsTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.id')); ?></th>
								<th><?php echo e(trans('admin.part')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th class="notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_data) && sizeof($arr_data)>0 ): ?>
								<?php $__currentLoopData = $arr_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($data['id'] ?? ''); ?></td>
										<td><?php echo e($data['commodity_name'] ?? ''); ?></td>
										<td class="text-center">
											<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item" onclick="item_edit('<?php echo e(base64_encode($data['id'] ?? '')); ?>')"><i class="fa fa-edit"></i></button>
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
			
<!-- Add Modal -->
<div class="modal right fade" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.parts')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="post" action="<?php echo e(Route('vc_part_store')); ?>" id="frmAddItem" enctype="multipart/form-data">
		            <?php echo e(csrf_field()); ?>

					<div class="row">
		            	<input type="hidden" name="action" value="create">
				        <div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane show active">
									<div class="row">
										<div class="form-group col-sm-6">
											<label class="col-form-label"><?php echo e(trans('admin.part')); ?> <?php echo e(trans('admin.name')); ?><span class="text-danger">*</span></label>
			            					<input type="text" class="form-control"  name="commodity_name" id="commodity_name" placeholder="<?php echo e(trans('admin.part')); ?> <?php echo e(trans('admin.name')); ?>" data-rule-required="true">
										</div>
									</div>
								</div>
							</div>

			                <div class="py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm"><?php echo e(trans('admin.cancel')); ?></button>
			                </div> 
				        </div>
					</div>
				</form>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<script type="text/javascript">
	var createUrl = "<?php echo e(Route('vc_part_store')); ?>";
	var updateUrl = "<?php echo e(Route('vc_part_update','')); ?>";

	$(document).ready(function(){

		$('.select2').select2();

		$('#frmAddItem').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#frmAddItem").submit(function(e) {
			e.preventDefault();
			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
      				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#add_item").modal('hide');
			form_reset();
		});


		$('#itemsTable').DataTable({
			// "pageLength": 2
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '<?php echo e(Config::get('app.project.title')); ?> Items',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Items PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Items',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Items EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Items CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

	});

	function form_reset() {
		$('#frmAddItem')[0].reset();
	}

	var module_url_path = "<?php echo e($module_url_path ?? ''); ?>";
	function item_edit(enc_id)
	{
		var title = "<?php echo e(trans('admin.edit')); ?>"+" <?php echo e(trans('admin.part')); ?>";
		$('.top_title').html(title);
		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'SUCCESS')
							{
								$('#frmAddItem').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#commodity_name').val(response.data.commodity_name);
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/vechicle_maintance/parts/index.blade.php ENDPATH**/ ?>
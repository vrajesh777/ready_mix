<?php $__env->startSection('main_content'); ?>
<?php
	$sdt = \Carbon::parse($start_date_time??'')->format('d/m/Y h:i A');
	$edt = \Carbon::parse($end_date_time??'')->format('d/m/Y h:i A');
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
<div class="col-sm-12">
<div class="row">
<div class="col-md-12 d-flex">
<div class="card profile-box flex-fill">
	<div class="card-body">

		<div class="tab-content">

			<div class="tab-pane active show" id="pump_all">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.truck_no')); ?>.</th>
								<th><?php echo e(trans('admin.driver')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.LD')); ?> #1</th>
								<th><?php echo e(trans('admin.LD')); ?> #2</th>
								<th><?php echo e(trans('admin.LD')); ?> #3</th>
								<th><?php echo e(trans('admin.LD')); ?> #4</th>
								<th><?php echo e(trans('admin.LD')); ?> #5</th>
								<th><?php echo e(trans('admin.LD')); ?> #6</th>
								<th><?php echo e(trans('admin.LD')); ?> #7</th>
								<th><?php echo e(trans('admin.LD')); ?> #8</th>
								<th><?php echo e(trans('admin.LD')); ?> #9</th>
								<th><?php echo e(trans('admin.LD')); ?> #10</th>
								<th><?php echo e(trans('admin.LD')); ?> #11</th>
								<th><?php echo e(trans('admin.LD')); ?> #12</th>
								<th><?php echo e(trans('admin.LD')); ?> #13</th>
								<th><?php echo e(trans('admin.LD')); ?> #14</th>
								<th><?php echo e(trans('admin.LD')); ?> #15</th>
								<th><?php echo e(trans('admin.LD')); ?> #16</th>
								<th><?php echo e(trans('admin.LD')); ?> #17</th>
								<th><?php echo e(trans('admin.LD')); ?> #18</th>
								<th><?php echo e(trans('admin.month_load')); ?></th>
								<th><?php echo e(trans('admin.total_load')); ?></th>
								<th><?php echo e(trans('admin.load_accum')); ?></th>
							</tr>
						</thead>
						
						<tbody>
							<?php if(isset($arr_driver) && sizeof($arr_driver)>0): ?>
								<?php $__currentLoopData = $arr_driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$total_del_qty =0;
									?>
									<tr>
										<td><?php echo e($order[0]['vehicle']['plate_no'] ?? ''); ?></td>
										<td><?php echo e($order[0]['driver']['first_name'] ?? ''); ?> <?php echo e($order[0]['driver']['last_name'] ?? ''); ?></td>

										<?php if(isset($order) && sizeof($order)>0): ?>
											<?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $del_key => $del): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php
													$total_del_qty += $del['quantity'] ?? 0;
												?>
												<td><?php echo e($del['quantity'] ?? 0); ?>,<br><?php echo e(date('H:i',strtotime($del['order_details']['order']['delivery_time'])) ?? ''); ?></td>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php
												$count = count($order) ?? 0;
												$remain_count = 18 - $count;
												for($i=1;$i<$remain_count+1;$i++){
													echo '<td></td>';
												}
											?>
										<?php endif; ?>
										
										<td>NA</td>
										<td><?php echo e($total_del_qty ?? 0); ?></td>
										<td>NA</td>

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
</div>
</div>
</div>
</div>
<!-- /Content End -->

<style type="text/css">
/*.modal.fade.right.show {opacity: 1;}*/
/*.show {display: block!important}*/
</style>

<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>

<script type="text/javascript">
// body add class for sidebar start
var body = document.body;
body.classList.add("mini-sidebar");
// body add class for sidebar end

	var custm_id = "<?php echo e($custm_id ?? ''); ?>";
	$(document).ready(function() {

        $( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY hh:mm A'
		    },
		    timePicker: true,
		    startDate: '<?php echo e($sdt??''); ?>',
		    endDate: '<?php echo e($edt??''); ?>'
		})
		.on('changeDate', function(e) {
			$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$("#customer").change(function() {
			$("#filterForm").submit();
		});

		var sdt ="<?php echo e($sdt ?? ''); ?>";
		var edt ="<?php echo e($edt ?? ''); ?>";
		var table = $('#leadsTable').DataTable({
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
				title: '<?php echo e(Config::get('app.project.title')); ?> Rev Prog Report',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Rev Prog Report '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Rev Prog Report',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Rev Prog Report '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Rev Prog Report '+sdt+'-'+edt,
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('daliv_output_mix_rpt')); ?>";
	});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/report/daliv_output_mix_rpt.blade.php ENDPATH**/ ?>
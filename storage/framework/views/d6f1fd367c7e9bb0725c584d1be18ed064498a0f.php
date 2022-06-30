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
								<th><?php echo e(trans('admin.sr_no')); ?></th>
								<th><?php echo e(trans('admin.acc')); ?>#</th>
								<th><?php echo e(trans('admin.customer')); ?> <?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.r_cbm')); ?></th>
								<th><?php echo e(trans('admin.mix')); ?></th>
								<th><?php echo e(trans('admin.batch')); ?></th>
								<th><?php echo e(trans('admin.pmp')); ?></th>
								<th><?php echo e(trans('admin.site')); ?> <?php echo e(trans('admin.location')); ?></th>
								<th><?php echo e(trans('admin.time')); ?></th>
								<th><?php echo e(trans('admin.d_cbm')); ?></th>
								<th><?php echo e(trans('admin.rej_cbm')); ?></th>
								<th><?php echo e(trans('admin.balance')); ?></th>
								<th><?php echo e(trans('admin.remark')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_orders) && sizeof($arr_orders)>0): ?>
								<?php $__currentLoopData = $arr_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$d_qty = $reject_qty = 0;
										if(isset($order['ord_details'][0]['del_notes']) && sizeof($order['ord_details'][0]['del_notes'])>0){
											$d_qty = array_sum(array_column($order['ord_details'][0]['del_notes'],'quantity')) ?? 0;
											$reject_qty = array_sum(array_column($order['ord_details'][0]['del_notes'],'reject_qty')) ?? 0;
										}

										$dlv_qty = $d_qty - $reject_qty;	
									?>
									<tr>
										<td><?php echo e($key+1); ?></td>
										<td><?php echo e($order['cust_details']['id'] ?? ''); ?></td>
										<td><?php echo e($order['cust_details']['first_name'] ?? ''); ?> <?php echo e($order['cust_details']['last_name'] ?? ''); ?></td>
										<td><?php echo e($order['ord_details'][0]['quantity'] ?? 0); ?></td>
										<td><?php echo e($order['ord_details'][0]['product_details']['name'] ?? ''); ?></td>
										<td><?php echo e($order['ord_details'][0]['product_details']['mix_code'] ?? ''); ?></td>
										<td><?php echo e($order['pump'] ?? 0); ?></td>
										<td><?php echo e($order['contract']['site_location'] ?? ''); ?></td>
										<td><?php echo e(date('H:i', strtotime($order['delivery_time']))??''); ?></td>
										<td><?php echo e($dlv_qty ?? 0); ?></td>
										<td><?php echo e($reject_qty ?? 0); ?></td>
										<td><?php echo e(number_format($order['balance'],2) ?? 0); ?></td>
										<td><?php echo e($order['remark'] ?? ''); ?></td>
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
		window.location.href="<?php echo e(Route('resrv_progressive_rpt')); ?>";
	});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/report/resrv_progressive_rpt.blade.php ENDPATH**/ ?>
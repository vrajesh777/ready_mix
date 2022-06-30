<?php $__env->startSection('main_content'); ?>

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col-sm-8">
			<form action="" id="filterForm">
				<ul class="list-inline-item pl-0">
					<li class="list-inline-item">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item">
	                    <select name="custm_id" class="select" id="customer">
			            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.customer')); ?></option>
			            	<?php if(isset($arr_customer) && sizeof($arr_customer)>0): ?>
								<?php $__currentLoopData = $arr_customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option  value="<?php echo e($cust['id']??''); ?>" <?php echo e(($cust['id']??'')==($custm_id??'')?'selected':''); ?>><?php echo e($cust['first_name']??''); ?> <?php echo e($cust['last_name']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
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

		<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 leadsTable" id="leadsTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.customer')); ?> #</th>
								<th><?php echo e(trans('admin.name')); ?></th>
								<th><?php echo e(trans('admin.total')); ?> m³</th>
								<th><?php echo e(trans('admin.booking')); ?> <?php echo e(trans('admin.amount')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
								<th><?php echo e(trans('admin.advance_payment')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
								<th><?php echo e(trans('admin.balance')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($arr_user_trans) && sizeof($arr_user_trans)>0): ?>
								<?php $__currentLoopData = $arr_user_trans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php
											$total_qty = $grand_tot = $advance_payment = $balance = 0;
											$total_qty += $details['ord_details'][0]['quantity'] ?? 0;
											$grand_tot += $details['grand_tot'] ?? 0;
											$advance_payment += $details['advance_payment'] ?? 0;
											$balance += $details['balance'] ?? 0;
											$cust_id = $details['cust_id'] ?? '';
											$cust_fname = $details['cust_details']['first_name'] ?? ''; 
											$cust_lname = $details['cust_details']['last_name'] ?? '';
											$cust_name = $cust_fname.' '.$cust_lname;
										?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td><?php echo e($cust_id ?? 0); ?></td>
										<td><?php echo e($cust_name ?? ''); ?></td>
										<td><?php echo e($total_qty ?? 0); ?></td>
										<td><?php echo e($grand_tot ?? 0); ?></td>
										<td><?php echo e($advance_payment ?? 0); ?></td>
										<td><?php echo e($balance ?? 0); ?></td>
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

<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script type="text/javascript">

	var custm_id = "<?php echo e($custm_id ?? ''); ?>";
	$(document).ready(function() {

		if(custm_id!='')
		{
			load_sites(custm_id);
		}

		/*$('#leadsTable').DataTable({
			// "pageLength": 2
			"order" : [[ 0, 'desc' ]],
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
				title: '<?php echo e(Config::get('app.project.title')); ?> Invoice',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Invoice PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Invoice',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Invoice EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Invoice CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});*/

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

		$("#contract,#sales_user,#customer").change(function() {
			$("#filterForm").submit();
		});

	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('booking_statement')); ?>";
	});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/transactions/monthly_booking_statement.blade.php ENDPATH**/ ?>
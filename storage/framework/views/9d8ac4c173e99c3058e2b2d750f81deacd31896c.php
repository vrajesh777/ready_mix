<?php $__env->startSection('main_content'); ?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<?php if($obj_user->hasPermissionTo('customers-create')): ?>
	                <li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-cust-btn"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.customer')); ?></button>
	                </li>
                <?php endif; ?>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="card mb-0">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
				<thead>
					<tr>
						
						<th><?php echo e(trans('admin.cust')); ?>#</th>
						<th><?php echo e(trans('admin.arabic_name')); ?></th>
						<th><?php echo e(trans('admin.english_name')); ?></th>
						<th><?php echo e(trans('admin.payments')); ?></th>
						<th><?php echo e(trans('admin.advance_payment')); ?></th>
						<th><?php echo e(trans('admin.expected')); ?> <?php echo e(trans('admin.m³')); ?></th>
						<th><?php echo e(trans('admin.created_on')); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php if(isset($arr_customers) && !empty($arr_customers)): ?>

						<?php $__currentLoopData = $arr_customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$transactions = $customer['transactions'];
								$sale_contracts = $customer['sale_contracts'];
								$advance_sum = $totalExpectedM3 = 0;
								foreach($transactions as $key => $trans) {
									if( $trans['type'] == 'credit'){
											$advance_sum += $trans['amount'] ?? 0;
									} 
								}
								foreach($sale_contracts as $key => $sc) {
									$totalExpectedM3 += $sc['excepted_m3'] ?? 0;
								}
							?>
						<tr>
							
							<td><?php echo e($customer['id'] ?? ''); ?></td>
							<td>
								<!-- Name in Arabic-->
								<?php $payment_link = base64_encode($customer['id']??'').'?page=payments';?>
								<a href="<?php echo e(Route('view_customer', base64_encode($customer['id']??''))); ?>" class="showLeadDetailsBtn" ><?php echo e($customer['first_name'] ?? ''); ?></a>
							</td>
							<td><?php echo e($customer['last_name'] ?? ''); ?></td> <!-- Name in english-->
							<td>
							<a href="<?php echo e(Route('view_customer', $payment_link)); ?>" class="showLeadDetailsBtn" ><?php echo e(trans('admin.transaction_details')); ?></a>
							</td>
							<td><?php echo e($advance_sum??'00'); ?></td>
							<td class="text-center actions">
								<?php echo e($totalExpectedM3??'00'); ?>

							</td>
							<td><?php echo e(date('d-M-y h:i A', strtotime($customer['created_at']))); ?></td>
						</tr>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					<?php else: ?>

						<h3 align="center">No Records Found!</h3>

					<?php endif; ?>
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">

	var createUrl = "<?php echo e(Route('store_customer')); ?>";
	var updateUrl = "<?php echo e(Route('update_customer','')); ?>";

	$(document).ready(function() {

		var table = $('#leadsTable').DataTable({
			   // "pageLength": 2
			"order" : [[ 4, 'desc' ]],
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
				title: '<?php echo e(Config::get('app.project.title')); ?> Leads',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Leads PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Leads',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Leads EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Leads CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/transactions/non_booking.blade.php ENDPATH**/ ?>
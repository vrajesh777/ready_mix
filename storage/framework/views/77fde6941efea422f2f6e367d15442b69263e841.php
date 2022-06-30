<?php $__env->startSection('main_content'); ?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">

			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false"><?php echo e(trans('admin.status')); ?></a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="<?php echo e(Route('proposals')); ?>"><?php echo e(trans('admin.all')); ?></a>
					<a class="dropdown-item" href="<?php echo e(Route('proposals',['status'=>'draft'])); ?>"><?php echo e(trans('admin.draft')); ?></a>
                    <a class="dropdown-item" href="<?php echo e(Route('proposals',['status'=>'open'])); ?>"><?php echo e(trans('admin.open')); ?></a>
                    <a class="dropdown-item" href="<?php echo e(Route('proposals',['status'=>'sent'])); ?>"><?php echo e(trans('admin.sent')); ?></a>
                    <a class="dropdown-item" href="<?php echo e(Route('proposals',['status'=>'accepted'])); ?>"><?php echo e(trans('admin.accepted')); ?></a>
                    <a class="dropdown-item" href="<?php echo e(Route('proposals',['status'=>'declined'])); ?>"><?php echo e(trans('admin.declined')); ?></a>
				</div>
			</div>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                	<?php if($obj_user->hasPermissionTo('sales-proposals-create')): ?>
                		<a href="<?php echo e(Route('create_proposal')); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.proposal')); ?></a>
                	<?php endif; ?>
                	<?php if($obj_user->hasPermissionTo('sales-bookings-create')): ?>
                		<a href="<?php echo e(Route('create_order')); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded"><?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.order')); ?></a>
                	<?php endif; ?>
                </li>
            </ul>
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
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.proposal')); ?> #</th>
								<th><?php echo e(trans('admin.amount')); ?></th>
								<th><?php echo e(trans('admin.total')); ?> <?php echo e(trans('admin.tax')); ?> </th>
								<th><?php echo e(trans('admin.customer')); ?></th>
								<th><?php echo e(trans('admin.date')); ?></th>
								<th><?php echo e(trans('admin.expiry')); ?> <?php echo e(trans('admin.date')); ?> </th>
								<th><?php echo e(trans('admin.reference')); ?> #</th>
								<th><?php echo e(trans('admin.status')); ?></th>
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>

							<?php if(isset($arr_props) && !empty($arr_props)): ?>

							<?php $__currentLoopData = $arr_props; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

							<?php
								$enc_id = base64_encode($prop['id']);
								$status = $prop['status']??'';
								$tax_amnt = 0;

								foreach($prop['prop_details'] as $row) {
									$tot_price = $row['quantity']*$row['rate'];
									$tax_rate = $row['tax_rate'];
									$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
								}
							?>

							<tr>
								<td>
									<a href="<?php echo e(Route('view_proposal', $enc_id)); ?>" target="_blank"><?php echo e(format_proposal_number($prop['id']) ?? 'N/A'); ?></a>
								</td>
								<td><?php echo e(number_format($prop['net_total'],2) ?? 'N/A'); ?></td>
								<td><?php echo e(number_format($tax_amnt,2) ?? 'N/A'); ?></td>
								<td><?php echo e($prop['cust_details']['first_name'] ?? ''); ?> &nbsp; <?php echo e($prop['cust_details']['last_name'] ?? ''); ?></td>
								<td><?php echo e($prop['date'] ?? 'N/A'); ?></td>
								<td><?php echo e($prop['expiry_date'] ?? ''); ?></td>
								<td><?php echo e($prop['ref_num'] ?? 'N/A'); ?></td>
								<td><?php echo e(ucfirst($status)); ?></td>
	                            <td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<?php if($obj_user->hasPermissionTo('sales-proposals-update')): ?>
											<a class="dropdown-item action-edit" href="<?php echo e(Route('edit_proposal', $enc_id)); ?>"><?php echo e(trans('admin.edit')); ?></a>
											<?php endif; ?>
											<a class="dropdown-item action-edit" href="<?php echo e(Route('view_proposal', $enc_id)); ?>"><?php echo e(trans('admin.view')); ?></a>
											<?php if($obj_user->hasPermissionTo('sales-proposals-update')): ?>
												<?php if($status == 'open'): ?>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'draft'])); ?>"><?php echo e(trans('admin.mark_as_draft')); ?></a>
												<?php endif; ?>
												<?php if($status == 'draft' || $status == 'open'): ?>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'sent'])); ?>"><?php echo e(trans('admin.mark_as_sent')); ?></a>
												<?php endif; ?>
												<?php if($status == 'draft' || $status == 'sent'): ?>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'open'])); ?>"><?php echo e(trans('admin.mark_as_open')); ?></a>
												<?php endif; ?>
												<?php if($status == 'declined'): ?>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'revised'])); ?>"><?php echo e(trans('admin.mark_as_revised')); ?></a>
												<?php endif; ?>
												<?php if($status == 'sent' || $status == 'revised'): ?>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'declined'])); ?>"><?php echo e(trans('admin.mark_as_declined')); ?></a>
												<a class="dropdown-item action-edit" href="<?php echo e(Route('change_inv_status', [$enc_id,'accepted'])); ?>"><?php echo e(trans('admin.mark_as_accepted')); ?></a>
												<?php endif; ?>
											<?php endif; ?>
										</div>
									</div>
								</td>
							</tr>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php else: ?>

							<h3 align="center"><?php echo e(trans('admin.no_record_found')); ?></h3>

							<?php endif; ?>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Content End -->

<script type="text/javascript">

	$(document).ready(function() {

		$('#leadsTable').DataTable({
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
				title: '<?php echo e(Config::get('app.project.title')); ?> Estimate',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Estimate PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '<?php echo e(Config::get('app.project.title')); ?> Estimate',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Estimate EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '<?php echo e(Config::get('app.project.title')); ?> Estimate CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

	});


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/proposals/index.blade.php ENDPATH**/ ?>
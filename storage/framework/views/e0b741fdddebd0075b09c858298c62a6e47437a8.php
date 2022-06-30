
<div class="card">
          <div class="card-body">
          	
             <div class="card-header p-0 pb-2 mb-2">
				<div class="row align-items-center justify-content-between">
					<h3 class="col-md-5 col-xl-6 card-title m-0">Booking Statement</h3>
						<div class="col-md-4 col-xl-3">
							<div class="position-relative mt-md-0 mt-sm-2">
							<input type="text" name="StatementdateRange" class="form-control" id="StatementdateRange" value="" >
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
							</div>
						</div>
						<div class="col-md-3">
							 <select name="custm_id" class="select form-control" onchange="filterDashboardData()" id="customer_id">
			            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.customer')); ?></option>
			            	<?php if(isset($arr_customer) && sizeof($arr_customer)>0): ?>
								<?php $__currentLoopData = $arr_customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option  value="<?php echo e($cust['id']??''); ?>" <?php echo e(($cust['id']??'')==($custm_id??'')?'selected':''); ?>><?php echo e($cust['first_name']??''); ?> <?php echo e($cust['last_name']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
						</div>
					
				   </div>
			</div>

			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="BookingStatementTable">
					<thead>
						<tr>
							<th><?php echo e(trans('admin.date')); ?></th>
							<th><?php echo e(trans('admin.cust')); ?> #</th>
							<th><?php echo e(trans('admin.account')); ?> #</th>
							<th><?php echo e(trans('admin.customer')); ?> <?php echo e(trans('admin.name')); ?> </th>
							<th><?php echo e(trans('admin.salesman')); ?> <?php echo e(trans('admin.name')); ?> </th>
						
							<th><?php echo e(trans('admin.total')); ?> m³</th>
							<th><?php echo e(trans('admin.booking')); ?> <?php echo e(trans('admin.amount')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
							<th><?php echo e(trans('admin.advance_payment')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
							<th><?php echo e(trans('admin.balance')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
							
						</tr>
					</thead>
					<tbody>

						<?php if(isset($arr_statement) && !empty($arr_statement)): ?>
							<?php $__currentLoopData = $arr_statement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sr => $statement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									$enc_id = base64_encode($statement['id']);
									$tax_amnt = $tot_qty = $cr_amnt = $start_index = $end_index = $adv_pay = 0;

									$cust_details = $statement['cust_details']??[];
									$sales_agent = $statement['sales_agent_details']??[];

									$invoice = $statement['invoice'] ?? [];

									foreach($statement['ord_details'] as $row) {
										$tot_price = $row['quantity']*$row['rate'];
										$tax_rate = $row['tax_rate'];
										$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
										$tot_qty += $row['quantity'] ?? 0;
									}
									$cust_id = $statement['cust_id'] ?? '';
									$contract_id = $statement['contract_id'] ?? '';

									$transactions = array_values($arr_user_trans[$cust_id]??[]);


									$end_index++;

									$arr_trans_till_ord = array_slice($transactions, $start_index,$end_index);
									$arr_user_trans[$cust_id] = array_diff_key($transactions, array_flip(array_keys($arr_trans_till_ord)));

								?>

								<tr>
								
									<td><?php echo e(date('d-M-Y', strtotime($statement['delivery_date']))); ?></td>
									<td><a href="<?php echo e(Route('satement_details', $enc_id)); ?>" target="_blank"><?php echo e($cust_id ?? ''); ?></a></td>
									<td><?php echo e(uniqid()); ?></td>
									<td><a href="<?php echo e(Route('satement_details', $enc_id)); ?>" target="_blank"><?php echo e($cust_details['first_name']??''); ?> <?php echo e($cust_details['last_name']??''); ?></a></td>
									<td><?php echo e($sales_agent['first_name']??''); ?> <?php echo e($sales_agent['last_name']??''); ?></td>
								
									<td><?php echo e($tot_qty ?? ''); ?></td>
									<td><?php echo e(number_format($statement['grand_tot']??0,2)); ?></td>
									<td><?php echo e(number_format($statement['advance_payment']??0,2)); ?></td>
									<td><?php echo e(number_format($statement['balance']??0,2)); ?></td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
						
					</tbody>
				</table>
			</div>


          </div>
 </div>

<div class="card">
          <div class="card-body">
          		<div id="statement_chart_id"></div>
          </div>
</div><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/dashboard/booking_statement.blade.php ENDPATH**/ ?>
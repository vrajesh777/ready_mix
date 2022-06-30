<?php $__env->startSection('main_content'); ?>

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col-sm-12">
			<form action="" id="filterForm">
				<ul class="list-inline-item pl-0">
					<li class="list-inline-item mb-2">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item mb-2">
	                    <select name="custm_id" class="select" id="customer">
			            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.customer')); ?></option>
			            	<?php if(isset($arr_customer) && sizeof($arr_customer)>0): ?>
								<?php $__currentLoopData = $arr_customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option  value="<?php echo e($cust['id']??''); ?>" <?php echo e(($cust['id']??'')==($custm_id??'')?'selected':''); ?>><?php echo e($cust['first_name']??''); ?> <?php echo e($cust['last_name']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
	                </li>

	                <li class="list-inline-item mb-2">
	                    <select name="contract" class="select" id="contract">
			            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.customer')); ?> <?php echo e(trans('admin.first')); ?> </option>
			            	
						</select>
	                </li>

	                <li class="list-inline-item mb-2">
	                    <select name="sales_user" class="select" id="sales_user">
			            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.saleman')); ?></option>
			            	<?php if(isset($arr_sales_user) && sizeof($arr_sales_user)>0): ?>
								<?php $__currentLoopData = $arr_sales_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option  value="<?php echo e($user['id']??''); ?>" <?php echo e(($user['id']??'')==($sales_user??'')?'selected':''); ?> ><?php echo e($user['first_name']??''); ?> <?php echo e($user['last_name']??''); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
						</select>
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
					<table class="table table-stripped mb-0 leadsTable" id="leadsTable">
						<thead>
							<tr>
								
								<th><?php echo e(trans('admin.date')); ?></th>
								<th><?php echo e(trans('admin.cust')); ?> #</th>
								<th><?php echo e(trans('admin.account')); ?> #</th>
								<th><?php echo e(trans('admin.customer')); ?> <?php echo e(trans('admin.name')); ?> </th>
								<th><?php echo e(trans('admin.salesman')); ?> <?php echo e(trans('admin.name')); ?> </th>
								<th><?php echo e(trans('admin.comission')); ?></th>
								<th><?php echo e(trans('admin.payment_type')); ?> </th>
								<th><?php echo e(trans('admin.rate')); ?></th>
								<th><?php echo e(trans('admin.expected')); ?> m³</th>
								<th><?php echo e(trans('admin.total')); ?> m³</th>
								<th><?php echo e(trans('admin.booking')); ?> <?php echo e(trans('admin.amount')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
								<th><?php echo e(trans('admin.advance_payment')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
								<th><?php echo e(trans('admin.site')); ?> <?php echo e(trans('admin.location')); ?></th>
								
								<th><?php echo e(trans('admin.balance')); ?> (<?php echo e(trans('admin.sar')); ?>)</th>
								
							</tr>
						</thead>
						<tbody>

							<?php
								$gobal_cr = 0; $arr_user_bal = [];
								$oldCust_id = 0;
								$qty_sum = $bk_amnt_sum = $bal_sum = $advance_sum = $advance_row_sum = 0;
							?>

							<?php if(isset($arr_orders) && !empty($arr_orders)): ?>
								<?php $__currentLoopData = $arr_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sr => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
										$enc_id = base64_encode($order['id']);
										$tax_amnt = $tot_qty = $cr_amnt = $start_index = $end_index = $adv_pay = 0;

										$cust_details = $order['cust_details']??[];
										$sales_agent = $order['sales_agent_details']??[];
										$contract    = $order['contract']??[];
										$invoice = $order['invoice'] ?? [];
										$isAdvancePayUpdated = false;

										foreach($order['ord_details'] as $row) {
											$tot_price = $row['quantity']*$row['rate'];
											$tax_rate = $row['tax_rate'];
											$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
											$tot_qty += $row['quantity'] ?? 0;
										}

										$qty_sum += $tot_qty;

										$tot_sal_amnt = ($invoice['net_total']+$tax_amnt);

										$bk_amnt_sum += $tot_sal_amnt;

										$cust_id = $order['cust_id'] ?? '';
										$contract_id = $order['contract_id'] ?? '';

										$transactions = array_values($arr_user_trans[$cust_id]??[]);
										$arr_trans_till_ord = [];
										$advance_row_sum = $advance_sum = 0;
										
										if(!$isAdvancePayUpdated){
											foreach($transactions as $key => $trans) {
												if( $trans['type'] == 'credit'){
													if($cust_id===$trans['user_id']){
														$advance_row_sum += $trans['amount'] ?? 0;
													} 
												} 
											}
										}
										
										if($cust_id === $oldCust_id){
											$advance_row_sum = $bal_sum;
											$bal_sum = $bal_sum - $order['grand_tot']??0;
										}else if($order['grand_tot']){
											$oldCust_id = $cust_id;
											$bal_sum = $advance_row_sum - $order['grand_tot']??0;
											$isAdvancePayUpdated = true;
										}
										$advance_sum = $advance_row_sum;
										// dd($advance_sum);
										// $end_index++;

										// $arr_trans_till_ord = array_slice($transactions, $start_index,$end_index);
										// $arr_user_trans[$cust_id] = array_diff_key($transactions, array_flip(array_keys($arr_trans_till_ord)));
										// dd($arr_user_trans);
										// if(!empty($arr_trans_till_ord)) {
										// 	foreach($arr_trans_till_ord as $tran) {
										// 		if($tran['type']=='credit'){
										// 			$cr_amnt += $tran['amount'];
										// 		}elseif($tran['type']=='debit'){
										// 			$cr_amnt -= $tran['amount'];
										// 		}
										// 	}
										// 	foreach($arr_trans_till_ord as $tran) {
										// 		if($tran['type']=='credit'){
										// 			$adv_pay += $tran['amount'];
										// 		}elseif($tran['type']=='debit'){
										// 			break;
										// 		}
										// 	}
										// }

										/*if(isset($arr_user_bal[$cust_id])) {
											$arr_user_bal[$cust_id] += $cr_amnt;
										}else{
											$arr_user_bal[$cust_id] = $cr_amnt;
										}

										$bal_sum += ($arr_user_bal[$cust_id]??0);*/

										// $bal_sum += $order['balance'] ?? 0;
										// $advance_sum += $order['advance_payment'] ?? 0;
									?>

									<tr>
										
										<td><?php echo e(date('d-M-Y', strtotime($order['delivery_date']))); ?></td>
										<td><a href="<?php echo e(Route('satement_details', $enc_id)); ?>" target="_blank"><?php echo e($cust_id ?? ''); ?></a></td>
										<td><?php echo e(uniqid()); ?></td>
										<td><a href="<?php echo e(Route('satement_details', $enc_id)); ?>" target="_blank"><?php echo e($cust_details['first_name']??''); ?> <?php echo e($cust_details['last_name']??''); ?></a></td>
										<td><?php echo e($sales_agent['first_name']??''); ?> <?php echo e($sales_agent['last_name']??''); ?></td>
										<td>N/A</td>
										<td>N/A</td>
										<td>N/A</td>
										<td><?php echo e($contract['excepted_m3']??''); ?></td>
										<td><?php echo e($tot_qty ?? ''); ?></td>
										<td>
											<?php echo e(number_format($order['grand_tot']??0,2)); ?>

										</td>
										<td><?php echo e(number_format($advance_row_sum??0,2)); ?></td>
										<td><?php echo e($contract['site_location']??''); ?></td>
										
										<td><?php echo e(number_format($bal_sum??0,2)); ?></td>
									</tr>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<tr>
										<td colspan="9" class="text-right"><?php echo e(trans('admin.total')); ?></td>
										<td><?php echo e($qty_sum??0); ?></td>
										<td><?php echo e(number_format($bk_amnt_sum ?? 0,2)); ?></td>
										<td><?php echo e(number_format($advance_sum?? 0,2)); ?></td>
										<td></td>
										<td><?php echo e(number_format($bal_sum ?? 0,2)); ?></td>
									</tr>
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

	$('#customer').change(function(){
		var cust_id = $(this).val();
		load_sites(cust_id);
	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('booking_statement')); ?>";
	});

	function load_sites(cust_id) {
		$.ajax({
			url:'<?php echo e(Route('load_sites','')); ?>/'+btoa(cust_id),
			method:'GET',
			dataType:'json',
			success:function(response){
				if(response.status == 'success'){
					if(typeof(response.arr_sites) == "object"){
						var option = '<option value="">Choose Site</option>';
						var slected_id = "<?php echo e($contract_id ?? ''); ?>";
						$(response.arr_sites).each(function(index,contract){ 
							var selected = '';
							if(slected_id == contract.id)  
							{
								selected = 'selected';
							}
							console.log(selected)
	                        option+='<option value="'+contract.id+'" '+selected+'>'+contract.site_location+'</option>';
	                    });
	                    $('select[name="contract"]').html(option);
					}
				}
				return false;
			}
		});
	}


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/transactions/index.blade.php ENDPATH**/ ?>
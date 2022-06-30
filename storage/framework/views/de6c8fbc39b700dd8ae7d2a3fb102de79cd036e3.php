<?php $__env->startSection('main_content'); ?>

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');

	$glob_qty_total = 0;
	if(isset($arr_orders) && !empty($arr_orders))
	{
		foreach($arr_orders as $itr => $order)
		{
			$glob_qty_total += $order['ord_details'][0]['quantity'] ?? 0;
		}
	}
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
                    <select name="contract" class="select" id="contract">
		            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.customer')); ?></option>
		            	
					</select>
                </li>

                <li class="list-inline-item">
                    <select name="sales_user" class="select" id="sales_user">
		            	<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.saleman')); ?></option>
		            	<?php if(isset($arr_sales_user) && sizeof($arr_sales_user)>0): ?>
							<?php $__currentLoopData = $arr_sales_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option  value="<?php echo e($user['id']??''); ?>" <?php echo e(($user['id']??'')==($sales_user??'')?'selected':''); ?> ><?php echo e($user['first_name']??''); ?> <?php echo e($user['last_name']??''); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>
					</select>
                </li>
                <li class="list-inline-item">
                	<input type="text" readonly class="form-control text-center" value="Total(M³) : <?php echo e($glob_qty_total ?? 0); ?>" >
                </li>
                <li class="list-inline-item">
                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
                </li>
            </ul>
        	</form>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				<?php if($obj_user->hasPermissionTo('sales-bookings-create')): ?>
					<li class="list-inline-item">
						<a href="<?php echo e(Route('create_order')); ?>" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded"><?php echo e(trans('admin.new')); ?></a>
					</li>
				<?php endif; ?>
			</ul>
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
	
		<?php if($obj_user->hasPermissionTo('sales-bookings-create')): ?>
			<form method="POST" action="<?php echo e(Route('store_order')); ?>" id="formAddProposal">
			<?php echo e(csrf_field()); ?>

				<div class="row">
					<div class="col-sm-12">
						<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<div class="d-flex clone_master" id="clone_master">
							<div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.customer')); ?> <span class="text-danger">*</span></label>
	                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select_and_begin_typing')); ?></option>
									<?php if(isset($arr_customer) && !empty($arr_customer)): ?>
									<?php $__currentLoopData = $arr_customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($cust['id']??''); ?>" ><?php echo e($cust['first_name'] ?? ''); ?> <?php echo e($cust['last_name'] ?? ''); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="error"><?php echo e($errors->first('cust_id')); ?></div>
							</div>
							<div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.account')); ?> <span class="text-danger">*</span></label>
	                            <select name="contract_id" class="select2" id="contract_id" data-rule-required="true">
									<option value=""><?php echo e(trans('admin.select_and_begin_typing')); ?></option>
								</select>
								<div class="error"><?php echo e($errors->first('contract_id')); ?></div>
							</div>
							<div class="form-group w-15 mr-2">
	                            <label class="col-form-label"><?php echo e(trans('admin.delivery_date')); ?><span class="text-danger">*</span></label>
	                            <div class="position-relative p-0">
	                                <input class="form-control datepicker pr-5" name="delivery_date" id="delivery_date" data-rule-required="true" readonly>
	                                <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
	                            </div>
	                            <div class="error"><?php echo e($errors->first('delivery_date')); ?></div>
	                        </div>

	                        <div class="form-group w-15 mr-2">
	                            <label class="col-form-label"><?php echo e(trans('admin.delivery_time')); ?><span class="text-danger">*</span></label>
	                            <div class="position-relative p-0">
	                                <input class="form-control timepicker pr-5" name="delivery_time" id="delivery_time" data-rule-required="true" placeholder="HH:mm" data-date-format="HH:mm" value="09:00">
	                                <div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
	                            </div>
	                            <div class="error"><?php echo e($errors->first('delivery_time')); ?></div>
	                        </div>
	                        <div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.pump')); ?></label>
	                            <select class="select2" name="pump" data-rule-required="false" id="pump">
	                            	<option value=""><?php echo e(trans('admin.select_default')); ?></option>
	                            	<?php if(isset($arr_pump) && count($arr_pump)>0): ?>
	                            		<?php $__currentLoopData = $arr_pump; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pump): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($pump['id'] ?? ''); ?>" data-operator-id="<?php echo e($pump['operator_id'] ?? ''); ?>"  data-helper-id="<?php echo e($pump['helper_id'] ?? ''); ?>" data-driver-id="<?php echo e($pump['driver_id'] ?? ''); ?>"><?php echo e($pump['name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>
						</div>
						</div>
						</div>
						<div class="row">
						<div class="col-sm-12">
						<div class="d-flex clone_master">
							<div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.pump_op')); ?>

								<!-- <span class="text-danger">*</span> -->
								</label>
	                            <select class="select2" name="pump_op_id" data-rule-required="false" id="pump_op_id">
	                            	<option value=""><?php echo e(trans('admin.select_default')); ?></option>
	                            	<?php if(isset($arr_operator) && count($arr_operator)>0): ?>
	                            		<?php $__currentLoopData = $arr_operator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($op['id'] ?? ''); ?>"><?php echo e($op['first_name'] ?? ''); ?> <?php echo e($op['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>
							<div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.pump_helper')); ?>

									<!-- <span class="text-danger">*</span> -->
								</label>
	                            <select class="select2" name="pump_helper_id" data-rule-required="false" id="pump_helper_id">
	                            	<option value=""><?php echo e(trans('admin.select_default')); ?></option>
	                            	<?php if(isset($arr_helper) && count($arr_helper)>0): ?>
	                            		<?php $__currentLoopData = $arr_helper; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($helper['id'] ?? ''); ?>"><?php echo e($helper['first_name'] ?? ''); ?> <?php echo e($helper['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>
							<div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.driver')); ?>

									<!-- <span class="text-danger">*</span> -->
								</label>
	                            <select class="select2" name="driver_id" data-rule-required="false" id="driver_id">
	                            	<option value=""><?php echo e(trans('admin.select_default')); ?></option>
	                            	<?php if(isset($arr_driver) && count($arr_driver)>0): ?>
	                            		<?php $__currentLoopData = $arr_driver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($driver['id'] ?? ''); ?>"><?php echo e($driver['first_name'] ?? ''); ?> <?php echo e($driver['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
							</div>

							<div class="form-group w-15 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.select_item')); ?>

									<span class="text-danger">*</span>
								</label>
								<select name="prod_id[]" class="select2 productSrch" data-rule-required="true">
									<option><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.item')); ?></option>
								</select>
								<div class="error"><?php echo e($errors->first('product')); ?></div>
							</div>
							<div class="form-group w-10 mr-2">
								<label class="col-form-label"><?php echo e(trans('admin.cubic_meter')); ?><span class="text-danger">*</span></label>
								<input type="number" name="unit_quantity[]" value="1" class="form-control" min="1" id="unit_quantity" data-rule-required="true">
								<div class="error"><?php echo e($errors->first('unit_quantity')); ?></div>
							</div>
							<div class="d-none">
								<input type="number" name="unit_rate[]" class="form-control" min="0" readonly="readonly">
							</div>
							<div class="d-none">
								<input type="number" name="opc1_rate[]" class="form-control" min="0" id="opc1_rate_index" onchange="calculate_prop_amnt()" >
							</div>
							<div class="d-none">
								<input type="number" name="src5_rate[]" class="form-control" min="0" id="src5_rate_index" onchange="calculate_prop_amnt()" >
							</div>
							<div class="d-none">
								<input type="number" name="unit_tax[]" class="form-control unit_tax" min="0" id="unit_tax_index">		
							</div>
							<div class=" py-3">
						    	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded px-2"><?php echo e(trans('admin.save')); ?></button>
						    </div>

						    <input type="hidden" name="disc_type" id="disc_type" value="percentage">
						    <input type="hidden" name="status" value="granted">
						</div>
					</div>
				</div>
			</form>
		<?php endif; ?>

		<div class="tab-content">

			<div class="tab-pane active show" id="pump_all">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 leadsTable">
						<thead>
							<tr>
								<th><?php echo e(trans('admin.pump')); ?></th>
								<th><?php echo e(trans('admin.cust')); ?></th>
								<th><?php echo e(trans('admin.customer')); ?></th>
								<th><?php echo e(trans('admin.location')); ?></th>
								<th><?php echo e(trans('admin.delivery')); ?></th>
								<th>M³</th>
								
								<th><?php echo e(trans('admin.mix')); ?></th>
								<!-- <th><?php echo e(trans('admin.structure')); ?></th> -->
								<!-- <th><?php echo e(trans('admin.cont')); ?></th> -->
								<th><?php echo e(trans('admin.remarks')); ?></th>
								
								
								
								
								
								
								<th class="text-right notexport"><?php echo e(trans('admin.actions')); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $gobal_cr = 0; $arr_user_bal = []; ?>

							<?php if(isset($arr_sorted_orders) && !empty($arr_sorted_orders)): ?>
							<?php $__currentLoopData = $arr_sorted_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arr_orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

							<?php $pmp_tot_quant = $pmp_tot_actl_quant = 0; ?>

							<?php if(isset($arr_orders) && !empty($arr_orders)): ?>
							<?php $__currentLoopData = $arr_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itr => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									$enc_id = base64_encode($order['id']);
									$tax_amnt = $tot_qty = $cr_amnt = $adv_pay = 0;

									$invoice = $order['invoice'] ?? [];
									$contract = $order['contract'] ?? [];

									$ord_dtls = current($order['ord_details'])??[];

									foreach($order['ord_details'] as $row) {
										$tot_price = $row['quantity']*$row['rate'];
										$tax_rate = $row['tax_rate'];
										$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
										$tot_qty += $row['quantity'] ?? 0;
									}

									$pmp_tot_quant += $tot_qty;

									$pmp_tot_actl_quant += $contract['excepted_m3']??0;

									$cust_id = $order['cust_id'] ?? '';
									$contract_id = $order['contract_id'] ?? '';

									$transactions = array_values($arr_user_trans[$cust_id]??[]);

									$arr_trans_till_ord = [];

									$start_index = 0;
									$end_index = 0;

									foreach($transactions as $key => $trans) {
										if($trans['order_id'] == $order['id'] && $trans['type'] == 'debit') {
											$end_index = $key;
										}
									}
									$end_index++;
									$arr_trans_till_ord = array_slice($transactions, $start_index,$end_index);
									$arr_user_trans[$cust_id] = array_diff_key($transactions, array_flip(array_keys($arr_trans_till_ord)));

									if(!empty($arr_trans_till_ord)) {
										foreach($arr_trans_till_ord as $tran) {
											if($tran['type']=='credit'){
												$cr_amnt += $tran['amount'];
											}elseif($tran['type']=='debit'){
												$cr_amnt -= $tran['amount'];
											}
										}
										foreach($arr_trans_till_ord as $tran) {
											if($tran['type']=='credit'){
												$adv_pay += $tran['amount'];
											}elseif($tran['type']=='debit'){
												break;
											}
										}
									}

									if(isset($arr_user_bal[$cust_id])) {
										$arr_user_bal[$cust_id] += $cr_amnt;
									}else{
										$arr_user_bal[$cust_id] = $cr_amnt;
									}
								?>

								<tr>
									<?php if($itr == 0): ?>
									<td rowspan="<?php echo e(count($arr_orders)); ?>"><?php echo e($order['pump_details']['name'] ?? ''); ?></td>
									<?php endif; ?>
									<td>
										
										<a href="<?php echo e(Route('view_invoice', $enc_id)); ?>" target="_blank"><?php echo e($cust_id ?? 0); ?></a>
									</td>
									<?php if(\App::getLocale() == 'ar'): ?>
										<td><?php echo e($order['cust_details']['first_name'] ?? ''); ?></td>
									<?php else: ?>
										<td> <?php echo e($order['cust_details']['last_name'] ?? ''); ?></td>
									<?php endif; ?>
									<td><?php echo e($contract['site_location']??''); ?></td>
									<td><?php echo e(date_format_dd_mm_yy($order['delivery_date']) ?? ''); ?> <?php echo e(date('H:i', strtotime($order['delivery_time']))??''); ?> </td>
									<td><?php echo e($tot_qty ?? ''); ?></td>
									
									<td><?php echo e($ord_dtls['product_details']['name']??''); ?></td>
									<!-- <td><?php echo e($order['structure']??''); ?></td> -->
									<!-- <td><?php echo e($order['cust_details']['mobile_no'] ?? 'N/A'); ?></td> -->
									<td><?php echo e(Str::limit($order['remark'],10) ?? 'N/A'); ?></td>
									
									
									
									
									
									
		                            <td class="text-center">
		                            	<?php if($order['delivery_date'] > date('Y-m-d') ): ?>
		                            		<a  href="<?php echo e(Route('edit_order', $enc_id)); ?>"><i class="fas fa-edit" title="Edit Order"></i></a>
		                            	<?php endif; ?>
		                            	<a  href="<?php echo e(Route('view_order', $enc_id)); ?>"><i class="fa fa-eye" title="<?php echo e(trans('admin.view_details')); ?>"></i></a>
										<a class="btn btn-primary btn-sm btn-edit-qty" href="<?php echo e(route('edit_order', base64_encode($order['id']))); ?>" id="edit_order"><i class="fa fa-edit" title="<?php echo e(trans('admin.edit_order')); ?>" aria-hidden="true"></i></a>
										<?php if($ord_dtls['quantity_delivered'] <= 0): ?>
										<a class="btn btn-primary btn-sm btn-edit-qty" href="<?php echo e(route('cancel_order', base64_encode($order['id']))); ?>" id="cancel_order"><i class="fa fa-trash" title="<?php echo e(trans('admin.cancel_order')); ?>" aria-hidden="true"></i></a>
										<?php endif; ?>
										
									</td>
								</tr>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
							<?php endif; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?>
								<h3 align="center"><?php echo e(trans('admin.no_record_found')); ?></h3>
							<?php endif; ?>
						</tbody>
					</table>
					<div>
						<?php echo e($obj_orders->links()); ?>

					</div>
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

<!-- Modal -->
<div class="modal fade right" id="edit_ord_modal" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center"><?php echo e(trans('admin.edit_order')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div id="ordFormWrapp">
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->
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

		$('.timepicker').datetimepicker({
			format : 'HH:mm'
        });

        $( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		});

		$('.select2').select2();

		if(custm_id!='')
		{
			load_sites(custm_id);
		}

		$(".edit-ord").click(function(e) {
			e.preventDefault();
			var action_url = $(this).attr('href');
			$("#edit_ord_modal").modal("show");
			$("#ordFormWrapp").html('');

			$.ajax({
				url: action_url,
				dataType:'json',
				beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status.toLowerCase() == 'success') {
						$("#ordFormWrapp").html(response.html);
					}
					displayNotification(response.status, response.message, 5000);
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
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

		$("#contract,#sales_user,#customer").change(function() {
			$("#filterForm").submit();
		});

		$("#cust_id").change(function(){
			get_contracts($(this).val());
		});

		$("#contract_id").change(function(){
			get_contracts_items($(this).val());
		});

		$('#formAddProposal').validate({});

		$('.productSrch').select2({
			placeholder: "Search for an Item",
			escapeMarkup: function(markup) {
				return markup;
			},
			templateResult: function(data) {
				return data.html;
			},
			templateSelection: function(data) {
				return data.text;
			}
		}).on('change', function (e) {
		    var prodId = $(".productSrch option:selected").val();
		    var prodName = $(".productSrch option:selected").text();

		    $('.prod_id').val(prodId);

		    var callUrl = "<?php echo e(Route('get_contract_item','')); ?>/"+btoa(prodId);

		    if($("input[name='prod_id[]']").length >= 1) {
				displayNotification('error', "Cannot add more than 1 Mix!", 5000);
				return false;
			}

		    $.ajax({
				url: callUrl,
  				type:'GET',
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(resp)
  				{
  					hideProcessingOverlay();
  					if(resp.status.toLowerCase() == 'success') {
  						$('.clone_master').find(".prod_id").val(resp.data.product_id);
  						$('.clone_master').find("#sel_prod_name").val(resp.data.product_details.name);
  						$('.clone_master').find("#sel_prod_descr").val(resp.data.product_details.description);

  						$('.clone_master').find("#unit_quantity").attr('min',resp.data.product_details.min_quant);
  						$('.clone_master').find("#unit_quantity").val(resp.data.product_details.min_quant);
  						$('.clone_master').find("#unit_rate").val(resp.data.rate);
  						$('.clone_master').find("#opc1_rate_index").val(resp.data.opc_1_rate);
  						$('.clone_master').find("#src5_rate_index").val(resp.data.src_5_rate);
  						$('.clone_master').find("#unit_tax_index").val(resp.data.tax_id);
  						/*$('.clone_master').find("#unit_tax option[value="+resp.data.tax_id+"]").prop('selected', true);
  						$('.clone_master').find("#unit_tax").select2().trigger('change');*/

  						var unitPrice = (resp.data.product_details.min_quant * resp.data.rate);

  						$('.clone_master').find('.unit_price').html(unitPrice);

  					}
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		});

		$('select[name=pump]').change(function(){
			var operator_id = $('select[name=pump] :selected').data('operator-id');
			var helper_id = $('select[name=pump] :selected').data('helper-id');
			var driver_id = $('select[name=pump] :selected').data('driver-id');

			$('select[name=pump_op_id]').val(operator_id);
    		$('select[name=pump_op_id]').select2().trigger('change');

    		$('select[name=pump_helper_id]').val(helper_id);
    		$('select[name=pump_helper_id]').select2().trigger('change');

			$('select[name=driver_id]').val(driver_id);
    		$('select[name=driver_id]').select2().trigger('change');
		});

	});

	$('#customer').change(function(){
		var cust_id = $(this).val();
		load_sites(cust_id);
	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('booking')); ?>";
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

	var contract_id_label = "<?php echo e(trans('admin.select_and_begin_typing')); ?>";
	function get_contracts(user_id) {
		if(user_id!='') {

			var callUrl = "<?php echo e(Route('get_user_cotracts','')); ?>/"+btoa(user_id);

		    $.ajax({
				url: callUrl,
					type:'GET',
					dataType:'json',
					beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(resp)
				{
					$('#contract_id').empty();
					$('#contract_id').html('<option value="">'+contract_id_label+'</option>');
					hideProcessingOverlay();
					if(resp.status.toLowerCase() == 'success') {
						var data_contr = [];
						if(resp.contracts.length > 0) {
							$.each(resp.contracts, function( index, value ) {
								var location = '';
								if(value.site_location !== null && value.site_location !== '')
								{
									location = '- '+value.site_location;
								}
								data_contr.push({
									id:value.id,
									text:''+value.contract_no+' '+location
								});
							});
						}
						else
						{
							$('#contract_id').empty();
						}
						$('#contract_id').select2({
							data: data_contr
						});
						initiate_form_validate();

					}
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		}
	}

	function get_contracts_items(contract_id) {

		if(contract_id!='') {

			var callUrl = "<?php echo e(Route('get_contract_items','')); ?>/"+btoa(contract_id);

		    $.ajax({
				url: callUrl,
					type:'GET',
					dataType:'json',
					beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(resp)
				{
					hideProcessingOverlay();
					if(resp.status.toLowerCase() == 'success') {

						$('.productSrch').empty();
						$('.productSrch').html('<option>Add Item</option>');

						var data_items = [];
						if(resp.contracts.length > 0) {
							$.each(resp.contracts, function( index, value ) {
								data_items.push({
									id: value.product_details.id,
									text: value.product_details.name,
								});
							});
						}
						$('.productSrch').select2({
							data: data_items
						});
						initiate_form_validate();
					}
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		}
	}

	function calculate_prop_amnt() {
		$.ajax({
			url: "<?php echo e(Route('calculate_ord_amnt')); ?>",
			type:'POST',
			dataType:'json',
			data : $("#formAddProposal").serialize(),
			beforeSend: function() {
		        showProcessingOverlay();
		    },
			success:function(response)
			{
				hideProcessingOverlay();
				if(response.status.toLowerCase() == 'success') {
					$('.subtotal').html(response.sub_tot);
					$('.tot_disc').html("-"+response.disc_amnt);
					$('.grand_tot').html(response.grand_tot);
					$('input[name=grand_tot]').val(response.grand_tot);
				}
			},
			error:function(){
				hideProcessingOverlay();
			}
		});
	}

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/orders/index_new.blade.php ENDPATH**/ ?>
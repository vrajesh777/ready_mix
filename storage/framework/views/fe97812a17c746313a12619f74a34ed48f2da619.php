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
								<th>Actual M³</th>
								<th>Change M³</th>
								<th><?php echo e(trans('admin.mix')); ?></th>
								<th><?php echo e(trans('admin.structure')); ?></th>
								<th><?php echo e(trans('admin.cont')); ?></th>
								<th><?php echo e(trans('admin.remarks')); ?></th>
								
								
								
								
								
								
								
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
									$tax_amnt = $tot_qty = $cr_amnt = $adv_pay = $tot_edit_quantity = 0;

									$invoice = $order['invoice'] ?? [];
									$contract = $order['contract'] ?? [];

									$ord_dtls = current($order['ord_details'])??[];

									foreach($order['ord_details'] as $row) {
										$tot_price = $row['quantity']*$row['rate'];
										$tax_rate = $row['tax_rate'];
										$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
										$tot_qty += $row['quantity'] ?? 0;
										$tot_edit_quantity += $row['edit_quantity'] ?? 0;
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
									<td><?php echo e($order['cust_details']['first_name'] ?? ''); ?> <?php echo e($order['cust_details']['last_name'] ?? ''); ?></td>
									<td><?php echo e($contract['site_location']??''); ?></td>
									<td><?php echo e(date_format_dd_mm_yy($order['delivery_date']) ?? ''); ?> <?php echo e(date('H:i', strtotime($order['delivery_time']))??''); ?> </td>
									<td><?php echo e($tot_qty ?? ''); ?></td>
									<td><?php echo e($tot_edit_quantity ?? ''); ?></td>
									
									<td><?php echo e($ord_dtls['product_details']['name']??''); ?></td>
									<td><?php echo e($order['structure']??''); ?></td>
									<td><?php echo e($order['cust_details']['mobile_no'] ?? 'N/A'); ?></td>
									<td><?php echo e(Str::limit($order['remark'],10) ?? 'N/A'); ?></td>
									
									
									
									
									
									
		                           

										
									
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
            format: 'HH:mm'
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
	});

	$('#customer').change(function(){
		var cust_id = $(this).val();
		load_sites(cust_id);
	});

	$('#clear_btn').click(function(){
		window.location.href="<?php echo e(Route('differential')); ?>";
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
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/sales/orders/differential.blade.php ENDPATH**/ ?>
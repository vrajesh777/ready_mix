<?php $__env->startSection('main_content'); ?>

<?php

$clone = $arr_prop_clone??[];

$prop_id = $arr_prop_clone['id']??'';

$ord_items = $clone['product_quantity']??[];

?>

<!-- Page Header -->
<div class="row">
	<form method="POST" action="<?php echo e(Route('store_proposal')); ?>" id="formAddProposal">

		<?php echo e(csrf_field()); ?>


		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<?php echo $__env->make('layout._operation_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="row">
						<div class="col-sm-6 border-right">
							<div class="row">

								<?php if(isset($arr_site_setting['sales_with_workflow']) && $arr_site_setting['sales_with_workflow']!='' && $arr_site_setting['sales_with_workflow'] == '1'): ?>
								<div class="form-group col-sm-12">
									<label class="col-form-label"><?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.estimate')); ?><span class="text-danger">*</span></label>
		                            <select name="proposal_id" class="select2" id="proposal_id" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?>  <?php echo e(trans('admin.estimate')); ?></option>
										<?php if(isset($arr_proposals) && !empty($arr_proposals)): ?>
											<?php $__currentLoopData = $arr_proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($proposal['id'] ?? ''); ?>" <?php echo e($prop_id==($proposal['id']??'')?'selected':''); ?> ><?php echo e($proposal['subject'] ?? ''); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
									<div class="error"><?php echo e($errors->first('proposal_id')); ?></div>
								</div>
								<?php endif; ?>

								<div class="form-group col-sm-12">
									<label class="col-form-label"><?php echo e(trans('admin.customer')); ?> <span class="text-danger">*</span></label>
		                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true">
										<option value=""><?php echo e(trans('admin.select')); ?> <?php echo e(trans('admin.and')); ?> <?php echo e(trans('admin.begin_typing')); ?></option>
										<?php if(isset($arr_custs) && !empty($arr_custs)): ?>
										<?php $__currentLoopData = $arr_custs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cust): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($cust['id'] ?? ''); ?>" <?php echo e(($cust['id']??'')==($clone['cust_id']??'')?'selected':''); ?> ><?php echo e($cust['first_name'] ?? ''); ?> <?php echo e($cust['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
									<div class="error"><?php echo e($errors->first('cust_id')); ?></div>
								</div>
								<div class="form-group col-sm-12">
									<div class="row">
										<div class="col-md-12">
											<a href="#" class="edit_shipping_billing_info" data-toggle="modal" data-target="#billing_and_shipping_details"><i class="fal fa-pencil"></i></a>
											<?php echo $__env->make('sales.proposals.address_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
										</div>

										<div class="col-md-6">
											<p class="bold"><?php echo e(trans('admin.bill_to')); ?></p>
											<address>
												<span class="billing_street"><?php echo e($clone['address']??'--'); ?></span><br>
												<span class="billing_city"><?php echo e($clone['city']??'--'); ?></span>,
												<span class="billing_state"><?php echo e($clone['state']??'--'); ?></span>
												<br>
												<span class="billing_zip"><?php echo e($clone['postal_code']??'--'); ?></span>
											</address>
										</div>
										<div class="col-md-6">
											<p class="bold"><?php echo e(trans('admin.ship_to')); ?></p>
											<address>
												<span class="shipping_street">--</span><br>
												<span class="shipping_city">--</span>,
												<span class="shipping_state">--</span>
												<br>
												<span class="shipping_country">--</span>,
												<span class="shipping_zip">--</span>
											</address>
										</div>
									</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.estimate')); ?> <?php echo e(trans('admin.date')); ?> <span class="text-danger">*</span></label>
		                            <input type="text" name="date" data-rule-required="true" class="form-control datepicker" value="<?php echo e($clone['date']??''); ?>">
		                            <div class="error"><?php echo e($errors->first('date')); ?></div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.expiry')); ?> <?php echo e(trans('admin.date')); ?></label>
	            					<input type="text" class="form-control datepicker" name="expiry_date" value="<?php echo e($clone['open_till']??''); ?>">
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">

								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.status')); ?></label>
		                            <select class="select" name="status">
										<option value="draft">Draft</option>
										<option value="sent">Sent</option>
										<option value="expired">Expired</option>
										<option value="declined">Declined</option>
										<option value="accepted">Accepted</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label"><?php echo e(trans('admin.sales_agent')); ?></label>
	            					<select class="select" name="assigned_to">
										<option value=""><?php echo e(trans('admin.no_selected')); ?></option>
										<?php if(isset($arr_sales_user) && !empty($arr_sales_user)): ?>
										<?php $__currentLoopData = $arr_sales_user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($user['id'] ?? ''); ?>" <?php echo e(($clone['assigned_to']??'')==($user['id']??'')?'selected':''); ?> ><?php echo e($user['first_name'] ?? ''); ?> <?php echo e($user['last_name'] ?? ''); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label"><?php echo e(trans('admin.reference')); ?> #</label>
		                            <input type="text" class="form-control" name="ref_num" placeholder="Reference #" >
		                            <div class="error"><?php echo e($errors->first('ref_num')); ?></div>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label"><?php echo e(trans('admin.admin_note')); ?></label>
		                           	<textarea name="admin_note" rows="5" cols="5" class="form-control" placeholder="<?php echo e(trans('admin.admin_note')); ?>" ></textarea>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<input type="hidden" name="disc_type" id="disc_type" value="percentage">

					<div class="row align-items-center justify-content-between border-bottom">
						<div class="col-sm-4">
							<div class="form-group d-flex">
								<select name="product" class="" id="productSrch">
									<option><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.item')); ?></option>
									<?php if(isset($arr_products) && !empty($arr_products)): ?>
									<?php $__currentLoopData = $arr_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option>
										<strong><?php echo e($product['name'] ?? ''); ?></strong> <br>
										<?php echo e($product['description'] ?? ''); ?>

									</option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endif; ?>
								</select>
								<div class="input-group-append cursor-pointer">
									<span class="input-group-text" data-toggle="modal" data-target="#add_item"><i class="far fa-plus"></i></span>
								</div>
							</div>
						</div>

					</div>
					<div class="table-responsive">
						<table class="table" id="tblProds">
							<thead>
								<tr>
									<th><?php echo e(trans('admin.item')); ?></th>
									<th><?php echo e(trans('admin.description')); ?></th>
									<th><?php echo e(trans('admin.qty')); ?></th>
									<th style="display: none;"><?php echo e(trans('admin.rate')); ?></th>
									<th><?php echo e(trans('admin.OPC_1')); ?></th>
									<th><?php echo e(trans('admin.SRC_1')); ?></th>
									<th><?php echo e(trans('admin.tax')); ?></th>
									<th><?php echo e(trans('admin.amount')); ?></th>
									<th><i class="fas fa-cog"></i></th>
								</tr>
							</thead>
							<tbody>
								<tr class="clone_master" id="clone_master">
									<td>
										<input type="hidden" class="prod_id">
										<textarea cols="5" class="form-control" id="sel_prod_name"></textarea>
									</td>
									<td>
										<textarea cols="5" class="form-control" id="sel_prod_descr"></textarea>
									</td>
									<td>
										<input type="number" value="0" class="form-control" min="0" id="unit_quantity">
									</td>
									<td style="display: none;">
										<input type="number" value="0" class="form-control" min="0" id="unit_rate" readonly="readonly">
									</td>
									<td>
										<input type="number" value="0" class="form-control" min="0" id="opc1_rate">
									</td>
									<td>
										<input type="number" value="0" class="form-control" min="0" id="src5_rate">
									</td>
									<td>
										<select class="select" id="unit_tax">
											<option><?php echo e(trans('admin.no_selected')); ?></option>
											<?php if(isset($arr_taxes) && !empty($arr_taxes)): ?>
											<?php $__currentLoopData = $arr_taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($tax['id']); ?>"><?php echo e($tax['name']); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</select>
									</td>
									<td class="unit_price"></td>
									<td>
										<button class="btn btn-sm btn-primary" id="btnCLone" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
									</td>
								</tr>

								<?php if(isset($ord_items) && !empty($ord_items)): ?>
								<?php $__currentLoopData = $ord_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

								<?php
									$product = $row['product_details']??[];
									$rate = ($row['opc_1_rate']??0)+($row['src_5_rate']??0);
									$total = $rate * ($row['quantity']??0);
								?>

								<tr class="">
									<td>
										<input type="hidden" name="prod_id[]" value="<?php echo e($row['product_id']??''); ?>">
										<textarea name="prod_name[]" cols="5" class="form-control" data-rule-required="true"><?php echo e($product['name'] ?? ''); ?></textarea>
									</td>
									<td>
										<textarea name="prod_descr[]" cols="5" class="form-control" data-rule-required="true"><?php echo e($product['description'] ?? ''); ?></textarea>
									</td>
									<td>
										<input type="number" name="unit_quantity[]" value="<?php echo e($row['quantity']??1); ?>" class="form-control" min="1" id="unit_quantity" data-rule-required="true" onchange="calculate_prop_amnt()" >
									</td>
									<td style="display: none;">
										<input type="number" name="unit_rate[]" value="<?php echo e($row['rate'] ?? '00'); ?>" class="form-control" min="0" readonly="readonly" data-rule-required="true">
									</td>
									<td>
										<input type="number" name="opc1_rate[]" value="<?php echo e($row['opc_1_rate']??0); ?>" class="form-control" min="0" id="opc1_rate" data-rule-required="true" onchange="calculate_prop_amnt()" >
									</td>
									<td>
										<input type="number" name="src5_rate[]" value="<?php echo e($row['src_5_rate']??0); ?>" class="form-control" min="0" id="src5_rate" onchange="calculate_prop_amnt()" >
									</td>
									<td>
										<select name="unit_tax[]" class="select unit_tax">
											<option value="">No selected</option>
											<?php if(isset($arr_taxes) && !empty($arr_taxes)): ?>
											<?php $__currentLoopData = $arr_taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($tax['id']); ?>" <?php echo e(($row['tax_id']??'')==$tax['id']?'selected':''); ?> ><?php echo e($tax['name']); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										</select>
									</td>
									<td class="unit_price"><?php echo e(format_price($total??0)); ?></td>
									<td>
										<button class="btn btn-sm btn-danger" id="btnRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
									</td>
								</tr>

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>

							</tbody>
						</table>
					</div>
					<div class="col-md-8 offset-4">
						<table class="table text-right">
						    <tbody>
						        <tr>
						           <td><span class="font-weight-bold"><?php echo e(trans('admin.sub_total')); ?>:</span>
						           </td>
						           <td class="subtotal">$0.00<input type="hidden" name="subtotal" value="0.00"></td>
						        </tr>
						        <tr>
						           <td>
						              <div class="row">
						                 <div class="col-md-8">
						                    <span class="font-weight-bold"><?php echo e(trans('admin.discount')); ?></span>
						                 </div>
						                 <div class="col-md-4">
						                    <div class="input-group">
						                       <input type="number" class="form-control" min="0" max="100" name="discount_num" id="discount_num" value="<?php echo e($clone['discount']??''); ?>">
						                       <div class="input-group-append">
													<button type="button" class="btn btn-white dropdown-toggle py-2" data-toggle="dropdown">%</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item disc_type_opt" data-type="percentage" href="javascript:void(0);">%</a>
														<a class="dropdown-item disc_type_opt" data-type="fixed" href="javascript:void(0);"><?php echo e(trans('admin.fixed')); ?> <?php echo e(trans('admin.discount')); ?></a>
													</div>
												</div>

						                    </div>
						                 </div>
						              </div>
						           </td>
						           <td class="discount-total tot_disc">-$0.00</td>
						        </tr>
						        <tr class="table-light">
						           <td><span class="font-weight-bold"><?php echo e(trans('admin.total')); ?> :</span>
						           </td>
						           <td class="total font-weight-bold grand_tot">$0.00</td>
						        </tr>
						    </tbody>
						</table>
					</div>

					<div class="row">
						<div class="form-group col-sm-12">
							<label class="col-form-label"><?php echo e(trans('admin.client_note')); ?></label>
		                   	<textarea name="client_note" rows="5" cols="5" class="form-control" placeholder="Client Note" ></textarea>
						</div>
						<div class="form-group col-sm-12">
							<label class="col-form-label"><?php echo e(trans('admin.terms_&_conditions')); ?></label>
		                   	<textarea name="terms_n_cond" rows="5" cols="5" class="form-control" placeholder="Terms & Conditions" ></textarea>
						</div>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
	                	<a href="<?php echo e(Route('proposals')); ?>" class="btn btn-secondary btn-rounded"><?php echo e(trans('admin.cancel')); ?></a>
	                </div>
				</div>
			</div>
		</div>

	</form>
</div>
<!-- /Page Header -->

<!-- Modal -->
<div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center"><?php echo e(trans('admin.add')); ?> <?php echo e(trans('admin.new')); ?> <?php echo e(trans('admin.item')); ?></h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="<?php echo e(Route('product_store')); ?>" id="createProdForm">

					<?php echo e(csrf_field()); ?>


					<div class="row">
				        <div class="form-group col-md-12">
							<label class="col-form-label"><?php echo e(trans('admin.description')); ?> <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control" name="name" placeholder="<?php echo e(trans('admin.description')); ?>" data-rule-required="true">
						</div>
						<div class="form-group col-sm-12">
							<label><?php echo e(trans('admin.long_description')); ?></label>
							<textarea name="description" rows="5" cols="5" class="form-control" placeholder="<?php echo e(trans('admin.long_description')); ?>"></textarea>
						</div>
						<div class="form-group col-md-12">
							<label class="col-form-label"><?php echo e(trans('admin.rate')); ?>  <span class="text-danger">*</span></label>
	                        <input type="number" class="form-control" name="rate" placeholder="<?php echo e(trans('admin.rate')); ?> " data-rule-required="true">
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label"><?php echo e(trans('admin.choose')); ?> <?php echo e(trans('admin.tax')); ?></label>
	                        <select class="select" name="tax_id">
								<option>No Tax</option>
								<?php if(isset($arr_taxes) && !empty($arr_taxes)): ?>
								<?php $__currentLoopData = $arr_taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($tax['id']); ?>"><?php echo e($tax['name']); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</select>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label"><?php echo e(trans('admin.unit')); ?> : <?php echo e(trans('admin.cubic_meter')); ?></label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label"><?php echo e(trans('admin.min_qty')); ?></label>
	                        <input type="number" class="form-control" name="min_quant" placeholder="Enter Min Quantity" min="1" value="1" >
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded"><?php echo e(trans('admin.save')); ?></button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded"><?php echo e(trans('admin.cancel')); ?></button>
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

	$(document).ready(function() {

		<?php if(Request::has('prop') && Request::get('prop') != ''): ?>
		calculate_prop_amnt();
		<?php endif; ?>

		$("#include_shipping").change(function(){
			if($(this).is(':checked')) {
				$("#shipping_details").fadeIn();
			}else{
				$("#shipping_details").fadeOut();
			}
		});

		$("#unit_quantity, #discount_num, #opc1_rate, #src5_rate").change(function(){
			calculate_prop_amnt();
		});

		$('.select2').select2();

		var data = [
					<?php if(isset($arr_products) && !empty($arr_products)): ?>
					<?php $__currentLoopData = $arr_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					{
						id: '<?php echo e($product['id'] ?? ''); ?>',
						text: '',
						html: '<strong><?php echo e($product['name'] ?? ''); ?></strong><br><p><?php echo e($product['description'] ?? ''); ?><p>'
					},
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>
				];

		$('#productSrch').select2({
			placeholder: "Search for an Item",
			data: data,
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
		    var prodId = $("#productSrch option:selected").val();
		    var prodName = $("#productSrch option:selected").text();

		    $('.prod_id').val(prodId);

		    var callUrl = "<?php echo e(Route('product_edit','')); ?>/"+btoa(prodId);

		    $.ajax({
				url: callUrl,
  				type:'GET',
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					hideProcessingOverlay();
  					if(response.status.toLowerCase() == 'success') {
  						$('.clone_master').find(".prod_id").val(response.data.id);
  						$('.clone_master').find("#sel_prod_name").val(response.data.name);
  						$('.clone_master').find("#sel_prod_descr").val(response.data.description);

  						$('.clone_master').find("#unit_quantity").attr('min',response.data.min_quant);
  						$('.clone_master').find("#unit_quantity").val(response.data.min_quant);
  						$('.clone_master').find("#unit_rate").val(response.data.rate);
  						$('.clone_master').find("#opc1_rate").val(response.data.opc_1_rate);
  						$('.clone_master').find("#src5_rate").val(response.data.src_5_rate);
  						$('.clone_master').find("#unit_tax option[value="+response.data.tax_id+"]").prop('selected', true);
  						$('.clone_master').find("#unit_tax").select2().trigger('change');

  						// var unitPrice = (response.data.min_quant * response.data.rate);
  						var unitPrice = (response.data.min_quant * (response.data.opc_1_rate+response.data.src_5_rate));

  						$('.clone_master').find('.unit_price').html(format_price(unitPrice));

  						// calculate_prop_amnt();
  					}
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		});

		initiate_form_validate();

		$("#tblProds").delegate( '#btnCLone', 'click', function () {

			if($('.clone_master').find(".prod_id").val() != '') {

				var prodId = $('.prod_id').val();
				var quant = $('#unit_quantity').val();
				var opc1_rate = $('#opc1_rate').val();
				var src5_rate = $('#src5_rate').val();

				$.ajax({
					url: "<?php echo e(Route('confirm_prop_product')); ?>",
	  				type:'GET',
	  				dataType:'json',
	  				data : {
	  					prod_id : prodId,
	  					quantity : quant,
	  					opc1_rate : opc1_rate,
	  					src5_rate : src5_rate,
	  				},
	  				beforeSend: function() {
				        showProcessingOverlay();
				    },
	  				success:function(response)
	  				{
	  					hideProcessingOverlay();
	  					if(response.status.toLowerCase() == 'success') {
	  						$("#clone_master").after(response.html);
	  						initiate_form_validate();
	  						calculate_prop_amnt();
	  						$( '.clone_master' ).find('input').val('');
			    			$( '.clone_master' ).find('textarea').val('');
			    			$('.unit_tax').select2();
	  					}
	  				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$("#tblProds").delegate( '#btnRemove', 'click', function () {
			$(this).closest('tr').remove();
		});

		$('#apply_address').click(function(){
			var billing_street = $("#billing_street").val()==''?'--':$("#billing_street").val();
			var billing_city = $("#billing_city").val()==''?'--':$("#billing_city").val();
			var billing_state = $("#billing_state").val()==''?'--':$("#billing_state").val();
			var billing_zip = $("#billing_zip").val()==''?'--':$("#billing_zip").val();
			var shipping_street = $("#shipping_street").val()==''?'--':$("#shipping_street").val();
			var shipping_city = $("#shipping_city").val()==''?'--':$("#shipping_city").val();
			var shipping_state = $("#shipping_state").val()==''?'--':$("#shipping_state").val();
			var shipping_zip = $("#shipping_zip").val()==''?'--':$("#shipping_zip").val();

			$('.billing_street').html(billing_street);
			$('.billing_city').html(billing_city);
			$('.billing_state').html(billing_state);
			$('.billing_zip').html(billing_zip);
			$('.shipping_street').html(shipping_street);
			$('.shipping_city').html(shipping_city);
			$('.shipping_state').html(shipping_state);
			$('.shipping_zip').html(shipping_zip);

			$('#billing_and_shipping_details').modal('hide');
		});

		$("#proposal_id").change(function(){
			clone_proposal($(this).val());
		});

		$("#cust_id").change(function(){
			var cust_id = $(this).val();
			$.ajax({
				url:'<?php echo e(Route('get_user_meta','')); ?>/'+btoa(cust_id),
				type:'GET',
				dataType:'json',
				success:function(response){
					if(response.status == 'success')
					{

						$('textarea[name=billing_street]').html(response.data.billing_street);
						$('input[name=billing_city]').attr('value',response.data.billing_city);
						$('input[name=billing_state]').attr('value',response.data.billing_state);
						$('input[name=billing_zip]').attr('value',response.data.billing_zip);

						if($('#include_shipping').is(':checked')){
							$('textarea[name=shipping_street]').html(response.data.shipping_street);
							$('input[name=shipping_city]').attr('value',response.data.shipping_city);
							$('input[name=shipping_state]').attr('value',response.data.shipping_state);
							$('input[name=shipping_zip]').attr('value',response.data.shipping_zip);

							$('.shipping_street').html(response.data.shipping_street);
							$('.shipping_city').html(response.data.shipping_city);
							$('.shipping_state').html(response.data.shipping_state);
							$('.shipping_zip').html(response.data.shipping_zip);
						}


						$('.billing_street').html(response.data.billing_street);
						$('.billing_city').html(response.data.billing_city);
						$('.billing_state').html(response.data.billing_state);
						$('.billing_zip').html(response.data.billing_zip);
						
					}
				}
			});
		});

	});

	function initiate_form_validate() {
		$('#formAddProposal').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});
	}

	function calculate_prop_amnt() {
		$.ajax({
			url: "<?php echo e(Route('calculate_prop_amnt')); ?>",
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
				}
			},
			error:function(){
				hideProcessingOverlay();
			}
		});
	}

	function clone_proposal(prop_id) {

		if(prop_id!='') {

			var callUrl = "<?php echo e(Route('get_prop_to_est_clone_data','')); ?>/"+btoa(prop_id);

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

						$('#tblProds > tbody > tr').not(':first').remove();

						$('#cust_id').val(resp.data.cust_id);
						$("#cust_id").select2().trigger('change');
						$('select[name=assigned_to]').val(resp.data.assigned_to);
						$("select[name=assigned_to]").select2().trigger('change');

						$('input[name=date]').val(resp.data.date);
						$('input[name=expiry_date]').val(resp.data.open_till);

						$('.billing_street').html(resp.data.address);
						$('.billing_city').html(resp.data.city);
						$('.billing_state').html(resp.data.state);
						$('.billing_zip').html(resp.data.postal_code);
						$('textarea[name=billing_street]').html(resp.data.address);
						$('input[name=billing_city]').attr('value',resp.data.city);
						$('input[name=billing_state]').attr('value',resp.data.state);
						$('input[name=billing_zip]').attr('value',resp.data.postal_code);

						$('input[name=discount_num]').val(resp.data.discount);

						$("#clone_master").after(resp.items_html);
						initiate_form_validate();
						calculate_prop_amnt();
						$( '.clone_master' ).find('input').val('');
		    			$( '.clone_master' ).find('textarea').val('');
		    			$('.unit_tax').select2();
					}
					displayNotification(resp.status, resp.message, 5000);
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		}
	}



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sales/proposals/create.blade.php ENDPATH**/ ?>
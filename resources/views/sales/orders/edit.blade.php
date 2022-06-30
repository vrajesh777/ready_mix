@extends('layout.master')
@section('main_content')


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Page Header -->
<div class="row">
	<form method="POST" action="{{ Route('update_order', base64_encode($arr_order['id'])) }}" id="frmEditBooking">

		{{ csrf_field() }}

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-6 border-right">
							<div class="row">

								<div class="form-group col-sm-6">
									<label class="col-form-label">Customer <span class="text-danger">*</span></label>
		                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true" 
									<?= isset($arr_order['ord_details'][0]['quantity_delivered']) && $arr_order['ord_details'][0]['quantity_delivered']>0 ?'disabled' :'';?>
									>
										<option value="">Select and begin typing</option>
										@if(isset($arr_custs) && !empty($arr_custs))
										@foreach($arr_custs as $cust)
										<option value="{{$cust['id']??''}}" @if(isset($arr_order['cust_id']) && $arr_order['cust_id']!='' && $arr_order['cust_id'] == $cust['id']) selected @endif >{{ $cust['first_name'] ?? '' }} {{ $cust['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
									<div class="error">{{ $errors->first('cust_id') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Contract <span class="text-danger">*</span></label>
		                            <select name="contract_id" class="select2" id="contract_id" data-rule-required="true" disabled>
										<option value="">Select and begin typing</option>
									</select>
									<div class="error">{{ $errors->first('contract_id') }}</div>
								</div>
								<div class="form-group col-sm-12">
									<div class="row">
										<div class="col-md-12">
											<a href="#" class="edit_shipping_billing_info" data-toggle="modal" data-target="#billing_and_shipping_details"><i class="fal fa-pencil"></i></a>
											@include('sales.orders.edit_address_modal')
										</div>

										<div class="col-md-6">
											<p class="bold">Bill To</p>
											<address>
												<span class="billing_street">{{ $arr_order['invoice']['billing_street']??'--' }}</span><br>
												<span class="billing_city">{{ $arr_order['invoice']['billing_city']??'--' }}</span>,
												<span class="billing_state">{{ $arr_order['invoice']['billing_state']??'--' }}</span>
												<br>
												<span class="billing_zip">{{ $arr_order['invoice']['billing_zip']??'--' }}</span>
											</address>
										</div>
										<div class="col-md-6">
											<p class="bold">Ship to</p>
											<address>
												<span class="shipping_street">{{ $arr_order['invoice']['shipping_street']??'' }}</span><br>
												<span class="shipping_city">{{ $arr_order['invoice']['shipping_city']??'' }}</span>,
												<span class="shipping_state">{{ $arr_order['invoice']['shipping_state']??'' }}</span>
												<br>
												<span class="shipping_zip">{{ $arr_order['invoice']['shipping_zip']??'' }}</span>
											</address>
										</div>
									</div>
								</div>
								<div class="form-group col-sm-6">
                                    <label class="col-form-label">Delivery date <span class="text-danger">*</span></label>
                                    <div class="position-relative p-0">
                                        <input class="form-control datepicker pr-5" name="delivery_date" value="{{$arr_order['delivery_date']??''}}" id="delivery_date" data-rule-required="true" readonly>
                                        <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
                                    </div>
                                    <div class="error">{{ $errors->first('delivery_date') }}</div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="col-form-label">Delivery Time <span class="text-danger">*</span></label>
                                    <div class="position-relative p-0">
                                        <input class="form-control timepicker pr-5" name="delivery_time" value="{{$arr_order['delivery_time']??''}}" id="delivery_time" data-rule-required="true" placeholder="hh:mm" data-date-format="hh:mm A" >
                                        <div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
                                    </div>
                                    <div class="error">{{ $errors->first('delivery_time') }}</div>
                                </div>

								<div class="form-group col-sm-6">
									<label class="col-form-label">Sales Agent</label>
	            					<select class="select" name="sales_agent">
										<option value="">No selected</option>
										@if(isset($arr_sales_user) && !empty($arr_sales_user))
										@foreach($arr_sales_user as $user)
										<option value="{{ $user['id'] ?? '' }}" {{ $arr_order['sales_agent']==$user['id']?'selected':'' }} >{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-6" style="display: none;">
									<label class="col-form-label">Status</label>
		                            <select class="select" name="status">
										<option value="pending">Pending</option>
										<option value="in-progress">In-Progress</option>
										<option value="testing">Testing</option>
										<option value="re-build">Re-Build</option>
										<option value="re-testing">Re-Testing</option>
										<option value="granted" selected="">Granted</option>
									</select>
								</div>

								<div class="form-group col-sm-12" style="display: none;">
									<label class="col-form-label"> Allowed payment modes for this invoice </label>
	            					<select class="select" name="pay_modes[]" multiple="">
										@if(isset($arr_pay_methods) && !empty($arr_pay_methods))
										@foreach($arr_pay_methods as $row)
										<option value="{{ $row['id'] ?? '' }}" selected="" >{{ $row['name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">Admin Note</label>
		                           	<textarea name="admin_note" rows="5" cols="5" class="form-control" placeholder="Admin Note" >{{ $arr_order['admin_note'] }}</textarea>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">

								<div class="form-group col-sm-6">
									<label class="col-form-label">Pump </span></label>
		                            <select class="select2" name="pump" data-rule-required="false">
		                            	<option value="">-- Select --</option>
										@if(isset($arr_pump) && count($arr_pump)>0)
		                            		@foreach($arr_pump as $pump)
												<option value="{{ $pump['id'] ?? '' }}" @if(isset($arr_order['pump']) && $arr_order['pump']!='' && $arr_order['pump'] == $pump['id']) selected @endif>{{ $pump['name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.pump_op') }}</span></label>
		                            <select class="select2" name="pump_op_id" data-rule-required="false" id="pump_op_id">
		                            	<option value="">{{ trans('admin.select_default') }}</option>
		                            	@if(isset($arr_operator) && count($arr_operator)>0)
		                            		@foreach($arr_operator as $op)
												<option value="{{ $op['id'] ?? '' }}"  @if(isset($arr_order['pump_op_id']) && $arr_order['pump_op_id']!='' && $arr_order['pump_op_id'] == $op['id']) selected @endif>{{ $op['first_name'] ?? '' }} {{ $op['last_name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.pump_helper') }}</span></label>
		                            <select class="select2" name="pump_helper_id" data-rule-required="false" id="pump_helper_id">
		                            	<option value="">{{ trans('admin.select_default') }}</option>
		                            	@if(isset($arr_helper) && count($arr_helper)>0)
		                            		@foreach($arr_helper as $helper)
												<option value="{{ $helper['id'] ?? '' }}" @if(isset($arr_order['pump_helper_id']) && $arr_order['pump_helper_id']!='' && $arr_order['pump_helper_id'] == $helper['id']) selected @endif>{{ $helper['first_name'] ?? '' }} {{ $helper['last_name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.driver') }}</span></label>
		                            <select class="select2" name="driver_id" data-rule-required="false" id="driver_id">
		                            	<option value="">{{ trans('admin.select_default') }}</option>
		                            	@if(isset($arr_driver) && count($arr_driver)>0)
		                            		@foreach($arr_driver as $driver)
												<option value="{{ $driver['id'] ?? '' }}" @if(isset($arr_order['driver_id']) && $arr_order['driver_id']!='' && $arr_order['driver_id'] == $driver['id']) selected @endif>{{ $driver['first_name'] ?? '' }} {{ $driver['last_name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="col-sm-12">
									<canvas id="pump_chart" width="800" height="450"></canvas>
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
									<option>Add Item</option>
								</select>
							</div>
						</div>

					</div>
					<div class="table-responsive">
						<table class="table" id="tblProds">
							<thead>
								<tr>
									<th>Item</th>
									<th>Description</th>
									<th>Qty</th>
									<th style="display: none;">Rate</th>
									<th style="display: none;">OPC (Type I)</th>
									<th style="display: none;">SRC (Type V)</th>
									<th style="display: none;">Tax</th>
									<th style="display: none;">Amount</th>
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
									<td style="display: none;">
										<input type="number" value="0" class="form-control" min="0" id="opc1_rate">
									</td>
									<td style="display: none;">
										<input type="number" value="0" class="form-control" min="0" id="src5_rate">
									</td>
									<td style="display: none;">
										<select class="select" id="unit_tax">
											<option>No selected</option>
											@if(isset($arr_taxes) && !empty($arr_taxes))
											@foreach($arr_taxes as $tax)
											<option value="{{ $tax['id'] }}">{{ $tax['name'] }}</option>
											@endforeach
											@endif
										</select>
									</td>
									<td class="unit_price" style="display: none;"></td>
									<td>
										<button class="btn btn-sm btn-primary" id="btnCLone" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
									</td>
								</tr>

								@if(isset($arr_order['ord_details']) && !empty($arr_order['ord_details']))
								@foreach($arr_order['ord_details'] as $row)

									<?php
										$product = $row['product_details']??[];
										$rate = ($row['opc_1_rate']??0)+($row['src_5_rate']??0);
										$total = $rate * ($row['quantity']??0);
									?>

									<tr class="">
										<td>
											<input type="hidden" name="prod_id[]" value="{{$row['product_id']??''}}">
											<textarea name="prod_name[]" cols="5" class="form-control" data-rule-required="true">{{ $product['name'] ?? '' }}</textarea>
										</td>
										<td>
											<textarea name="prod_descr[]" cols="5" class="form-control" data-rule-required="true">{{ $product['description'] ?? '' }}</textarea>
										</td>
										<td>
											<input type="number" name="unit_quantity[]" value="{{ $row['quantity']??1 }}" class="form-control" min="1" id="unit_quantity" data-rule-required="true" onchange="calculate_prop_amnt()" >
										</td>
										<td style="display: none;">
											<input type="number" name="unit_rate[]" value="{{ $row['rate'] ?? '00' }}" class="form-control" min="0" readonly="readonly" data-rule-required="true">
										</td>
										<td style="display: none;">
											<input type="number" name="opc1_rate[]" value="{{ $row['opc_1_rate']??0 }}" class="form-control" min="0" id="opc1_rate" data-rule-required="true" onchange="calculate_prop_amnt()" >
										</td>
										<td style="display: none;">
											<input type="number" name="src5_rate[]" value="{{ $row['src_5_rate']??0 }}" class="form-control" min="0" id="src5_rate" onchange="calculate_prop_amnt()" >
										</td>
										<td style="display: none;">
											<select name="unit_tax[]" class="select unit_tax">
												<option value="">No selected</option>
												@if(isset($arr_taxes) && !empty($arr_taxes))
												@foreach($arr_taxes as $tax)
												<option value="{{ $tax['id'] }}" {{ ($row['tax_id']??'')==$tax['id']?'selected':'' }} >{{ $tax['name'] }}</option>
												@endforeach
												@endif
											</select>
										</td>
										<td class="unit_price" style="display: none;">{{ format_price($total??0) }}</td>
										<td>
											<button class="btn btn-sm btn-danger" id="btnRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
										</td>
									</tr>

								@endforeach
								@endif

							</tbody>
						</table>
					</div>
					<div class="col-md-8 offset-4">
						<table class="table text-right" style="display: none;">
						    <tbody>
						        <tr>
						           <td>
						              <div class="row">
						                 <div class="col-md-8">
						                    <span class="font-weight-bold">Discount</span>
						                 </div>
						                 <div class="col-md-4">
						                    <div class="input-group">
						                       	<input type="number" class="form-control" min="0" max="100" name="discount_num" id="discount_num" value="{{ $arr_order['discount']??'' }}">
						                       	<div class="input-group-append">
													<button type="button" class="btn btn-white dropdown-toggle py-2" data-toggle="dropdown">%</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item disc_type_opt" data-type="percentage" href="javascript:void(0);">%</a>
														<a class="dropdown-item disc_type_opt" data-type="fixed" href="javascript:void(0);">Fixed Amount</a>
													</div>
												</div>

						                    </div>
						                 </div>
						              </div>
						           </td>
						           <td class="discount-total tot_disc">-$0.00</td>
						        </tr>
						        <tr class="table-light">
						           <td><span class="font-weight-bold">Total :</span>
						           </td>
						           <td class="total font-weight-bold grand_tot">$0.00</td>
						        </tr>
						    </tbody>
						</table>
					</div>

					<div class="row">
						<div class="form-group col-sm-12">
							<label class="col-form-label">Client Note</label>
		                   	<textarea name="client_note" rows="5" cols="5" class="form-control" placeholder="Client Note" >{{ $arr_order['client_note']??'' }}</textarea>
						</div>
						<div class="form-group col-sm-12">
							<label class="col-form-label">Terms & Conditions</label>
		                   	<textarea name="terms_n_cond" rows="5" cols="5" class="form-control" placeholder="Terms & Conditions" >{{ $arr_order['terms_conditions']??'' }}</textarea>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="col-form-label">Structure</label>
                            <input type="text" id="structure" name="structure" class="form-control" value="{{ $arr_order['structure']??'' }}">
                            <div class="error">{{ $errors->first('structure') }}</div>
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">Remark</label>
		                   	<textarea name="remark" rows="2" cols="2" class="form-control" placeholder="Remark">{{ $arr_order['Remark']??'' }}</textarea>
						</div>
					</div>
					<div class="text-center py-3 w-100">
	                	<button type="button" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="checkBalance">Save</button>&nbsp;&nbsp;
	                	<a href="{{ Route('proposals') }}" class="btn btn-secondary btn-rounded">Cancel</a>
	                </div>
				</div>
			</div>
		</div>

		<input type="hidden" name="grand_tot" value="0">

	</form>
</div>
<!-- /Page Header -->
<script src="{{ asset('/js/linebar.min.js') }}"></script>

<script type="text/javascript">

	var chart_data = {data: {
					labels: ["2000", "2010", "2011", "2015", "2020"],
					datasets: [
					{
						label: "Pumps",
						backgroundColor: ["#fe7096", "#9a55ff","#3cba9f","#e8c3b9","#9a55ff"],
						data: [2478,5267,734,784,433]
					}
					]
				},
				options: {
					legend: { display: true },
					title: {
						display: true,
						text: 'Pump wise Mix quantity ( in m³ )'
					}
				}};


	$(document).ready(function() {

		$('.timepicker').datetimepicker({
            format: 'HH:mm'
        });

        $('#delivery_date').datepicker({
        	format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		}).on('changeDate', function(e) {
			var dev_date = $(this).val();
			pump_booking(dev_date);
		});

		pump_booking('{{ $arr_order['delivery_date'] ?? '' }}');

		$("#include_shipping").change(function(){
			if($(this).is(':checked')) {
				$("#shipping_details").fadeIn();
			}else{
				$("#shipping_details").fadeOut();
			}
		});

		$("#discount_num, #opc1_rate, #src5_rate").change(function(){
			calculate_prop_amnt();
		});

		$('.select2').select2();

		$('#productSrch').select2({
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
		    var prodId = $("#productSrch option:selected").val();
		    var prodName = $("#productSrch option:selected").text();

		    $('.prod_id').val(prodId);

		    var callUrl = "{{ Route('get_contract_item','') }}/"+btoa(prodId);

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
  						$('.clone_master').find("#opc1_rate").val(resp.data.opc_1_rate);
  						$('.clone_master').find("#src5_rate").val(resp.data.src_5_rate);
  						$('.clone_master').find("#unit_tax option[value="+resp.data.tax_id+"]").prop('selected', true);
  						$('.clone_master').find("#unit_tax").select2().trigger('change');

  						var unitPrice = (resp.data.product_details.min_quant * resp.data.rate);

  						$('.clone_master').find('.unit_price').html(unitPrice);

  					}
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		});

		initiate_form_validate();

		$("#tblProds").delegate( '#btnCLone', 'click', function () {

			if($("input[name='prod_id[]']").length >= 1) {
				displayNotification('error', "Cannot add more than 1 Mix!", 5000);
				return false;
			}

			if($('.clone_master').find(".prod_id").val() != '') {

				var prodId = $('.prod_id').val();
				var quant = $('#unit_quantity').val();
				var opc1_rate = $('#opc1_rate').val();
				var src5_rate = $('#src5_rate').val();

				$.ajax({
					url: "{{ Route('confirm_ord_product') }}",
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

		
		get_contracts('{{ $arr_order['cust_id'] ?? '' }}');
		get_contracts_items('{{ $arr_order['contract_id'] ?? '' }}');
		get_user_meta('{{ $arr_order['cust_id'] ?? '' }}');

		$("#contract_id").change(function(){
			get_contracts_items($(this).val());
		});

		$("#checkBalance").click(function(){
			if(!$("#frmEditBooking").valid()) {
				displayNotification('error', "Please fill valid form values", 5000);
			}else{

				if($("input[name='prod_id[]']").length > 0) {

					var contract_id = btoa($("#contract_id").val());
					var cust_id = btoa($("#cust_id").val());

					$("#frmEditBooking").submit();

					/*$.ajax({
						url: "{{ Route('get_customer_bal','') }}"+"/"+cust_id,
						type:'POST',
						dataType:'json',
						data : {
							_token : "{{ csrf_token() }}",
							total : 4200
						},
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response)
						{
							hideProcessingOverlay();
							if(response.status.toLowerCase() == 'success') {
								var grand_tot = parseFloat($('input[name=grand_tot]').val());

								if(grand_tot > response.rem_bal ) {
									displayNotification('error', 'You dont have enough balance. Please contact to sales manager!', 5000);
								}else{
									displayNotification('success', grand_tot+' '+response.rem_bal, 5000);
									$("#frmEditBooking").submit();
								}
							}
						},
						error:function(){
							hideProcessingOverlay();
						}
					});*/
				}else{
					displayNotification('error', 'Please add atleast 1 Item to proceed!', 5000);
				}

			}
		});

		$("input[name=delivery_date]").change(function() {
			pump_booking($(this).val());
		});

		// initialize_pump_chart(chart_data);

	});

	function pump_booking(delivery_date) 
	{
		$.ajax({
				url: "{{ Route('get_pump_bookings') }}",
				type:'POST',
				dataType:'json',
				data : {
					_token : "{{ csrf_token() }}",
					date : delivery_date,
				},
				beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status.toLowerCase() == 'success') {
						chart_data = response.arr_data_chart;
						initialize_pump_chart(chart_data);
					}
					else if(response.status.toLowerCase() == 'error')
					{
						initialize_pump_chart('');
					}
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
	}

	function initialize_pump_chart(book) {
		/*horixzontal bar chart*/
		new Chart(document.getElementById("pump_chart"), {
			type: 'horizontalBar',
			data: book.data,
			options: book.options
		});
	}

	function initiate_form_validate() {
		$('#frmEditBooking').validate({
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
			url: "{{ Route('calculate_ord_amnt') }}",
			type:'POST',
			dataType:'json',
			data : $("#frmEditBooking").serialize(),
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

	function get_contracts(user_id) {

		if(user_id!='') {

			var callUrl = "{{ Route('get_user_cotracts','') }}/"+btoa(user_id);
			var contract_id = '{{ $arr_order['contract_id'] ?? '' }}';
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
						var data_contr = [];
						if(resp.contracts.length > 0) {
							$.each(resp.contracts, function( index, value ) {

								var checked = false;
								if(contract_id == value.id)
								{
									checked = true;
								}

								var location = '';
								if(value.site_location !== null && value.site_location !== '')
								{
									location = '- '+value.site_location;
								}

								data_contr.push({
									id:value.id,
									text:''+value.contract_no+' '+location,
									selected : checked
								});
							});
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

	function get_user_meta(cust_id)
	{
		$.ajax({
			url:'{{ Route('get_user_meta','') }}/'+btoa(cust_id),
			type:'GET',
			dataType:'json',
			success:function(response){
				if(response.status == 'success')
				{

					if(response.data.billing_street != undefined && response.data.billing_street!='')
					{
						$('textarea[name=billing_street]').html(response.data.billing_street);
						$('.billing_street').html(response.data.billing_street);
					}
					else
					{
						$('textarea[name=billing_street]').html('');
						$('.billing_street').html('--');
					}

					if(response.data.billing_city != undefined && response.data.billing_city!='')
					{
						$('input[name=billing_city]').attr('value',response.data.billing_city);
						$('.billing_city').html(response.data.billing_city);
					}
					else
					{
						$('input[name=billing_city]').attr('value','');
						$('.billing_city').html('--')
					}
					
					if(response.data.billing_state != undefined && response.data.billing_state!='')
					{
						$('input[name=billing_state]').attr('value',response.data.billing_state);
						$('.billing_state').html(response.data.billing_state);
					}
					else
					{
						$('input[name=billing_state]').attr('value','');
						$('.billing_state').html('--')
					}
					
					if(response.data.billing_zip != undefined && response.data.billing_zip!='')
					{
						$('input[name=billing_zip]').attr('value',response.data.billing_zip);
						$('.billing_zip').html(response.data.billing_zip);
					}
					else
					{
						$('input[name=billing_zip]').attr('value','');
						$('.billing_zip').html('--')
					}
					

					if($('#include_shipping').is(':checked')){

						if(response.data.shipping_street != undefined && response.data.shipping_street!='')
						{
							$('textarea[name=shipping_street]').html(response.data.shipping_street);
							$('.shipping_street').html(response.data.shipping_street);
						}
						else
						{
							$('textarea[name=shipping_street]').html('');
							$('.shipping_street').html('--');
						}

						if(response.data.shipping_city != undefined && response.data.shipping_city!='')
						{
							$('input[name=shipping_city]').attr('value',response.data.shipping_city);
							$('.shipping_city').html(response.data.shipping_city);
						}
						else
						{
							$('input[name=shipping_city]').attr('value','');
							$('.shipping_city').html('--');
						}

						if(response.data.shipping_state != undefined && response.data.shipping_state!='')
						{
							$('input[name=shipping_state]').attr('value',response.data.shipping_state);
							$('.shipping_state').html(response.data.shipping_state);
						}
						else
						{
							$('input[name=shipping_state]').attr('value','');
							$('.shipping_state').html('--');
						}

						if(response.data.shipping_zip != undefined && response.data.shipping_zip!='')
						{
							$('input[name=shipping_zip]').attr('value',response.data.shipping_zip);
							$('.shipping_zip').html(response.data.shipping_zip);
						}
						else
						{
							$('input[name=shipping_zip]').attr('value','');
							$('.shipping_zip').html('--');
						}
					}
					
				}
			}
		});
	}

	function get_contracts_items(contract_id) {

		if(contract_id!='') {
			var callUrl = "{{ Route('get_contract_items','') }}/"+btoa(contract_id);

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
						var data_items = [];
						if(resp.contracts.length > 0) {
							$.each(resp.contracts, function( index, value ) {
								data_items.push({
									id: value.product_details.id,
									text: value.product_details.name,
								});
							});
						}
						$('#productSrch').select2({
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

	$("#contract_id").change(function(){
		$('#tblProds > tbody > tr').not(':first').remove();
	});



</script>

@stop
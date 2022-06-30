@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {width: 100% !important;}
	.notification {z-index: 999999;}
</style>

<?php

$arr_inv_pay_methods = $arr_invoice['pay_methods'];
$arr_defined_pay_methods = array_column($arr_inv_pay_methods, 'pay_method_id');

?>

<!-- Page Header -->
<div class="row">
	<form method="POST" action="{{ Route('update_invoice', base64_encode($arr_invoice['id'])) }}" id="formEditEstimate">

		{{ csrf_field() }}

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-6 border-right">
							<div class="row">

								<div class="form-group col-sm-12">
									<label class="col-form-label">Customer <span class="text-danger">*</span></label>
		                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true">
										<option value="">Select and begin typing</option>
										@if(isset($arr_custs) && !empty($arr_custs))
										@foreach($arr_custs as $cust)
										<option value="{{ $cust['id'] ?? '' }}" {{ ($arr_invoice['cust_id']??'')==$cust['id']?'selected':'' }} >{{ $cust['first_name'] ?? '' }} {{ $cust['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
									<div class="error">{{ $errors->first('cust_id') }}</div>
								</div>
								<div class="form-group col-sm-12">
									<div class="row">
										<div class="col-md-12">
											<a href="#" class="edit_shipping_billing_info" data-toggle="modal" data-target="#billing_and_shipping_details"><i class="fal fa-pencil"></i></a>
											@include('sales.invoices.edit_address_modal')
										</div>

										<div class="col-md-6">
											<p class="bold">Bill To</p>
											<address>
												<span class="billing_street">{{ $arr_invoice['billing_street']??'' }}</span><br>
												<span class="billing_city">{{ $arr_invoice['billing_city']??'' }}</span>,
												<span class="billing_state">{{ $arr_invoice['billing_state']??'' }}</span>
												<br>
												<span class="billing_zip">{{ $arr_invoice['billing_zip']??'' }}</span>
											</address>
										</div>
										<div class="col-md-6">
											<p class="bold">Ship to</p>
											<address>
												<span class="shipping_street">{{ $arr_invoice['shipping_street']??'' }}</span><br>
												<span class="shipping_city">{{ $arr_invoice['shipping_city']??'' }}</span>,
												<span class="shipping_state">{{ $arr_invoice['shipping_state']??'' }}</span>
												<br>
												<span class="shipping_zip">{{ $arr_invoice['shipping_zip']??'' }}</span>
											</address>
										</div>
									</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Invoice Date <span class="text-danger">*</span></label>
		                            <input type="text" name="invoice_date" data-rule-required="true" class="form-control datepicker" value="{{ $arr_invoice['invoice_date'] ?? '' }}">
		                            <div class="error">{{ $errors->first('invoice_date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Due Date</label>
	            					<input type="text" class="form-control datepicker" name="due_date" value="{{ $arr_invoice['due_date'] ?? '' }}">
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">

								<div class="form-group col-sm-6">
									<label class="col-form-label">Status</label>
		                            <select class="select" name="status">
										<option value="draft" {{ $arr_invoice['status']=='draft'?'selected':'' }} >Draft</option>
										<option value="sent" {{ $arr_invoice['status']=='sent'?'selected':'' }} >Sent</option>
										<option value="expired" {{ $arr_invoice['status']=='expired'?'selected':'' }} >Expired</option>
										<option value="declined" {{ $arr_invoice['status']=='declined'?'selected':'' }} >Declined</option>
										<option value="accepted" {{ $arr_invoice['status']=='accepted'?'selected':'' }} >Accepted</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Sales Agent</label>
	            					<select class="select" name="sales_agent">
										<option value="">No selected</option>
										@if(isset($arr_sales_user) && !empty($arr_sales_user))
										@foreach($arr_sales_user as $user)
										<option value="{{ $user['id'] ?? '' }}" {{ $arr_invoice['sales_agent']==$user['id']?'selected':'' }} >{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label"> Allowed payment modes for this invoice </label>
	            					<select class="select" name="pay_modes[]" multiple="">
										<option value="">No selected</option>
										@if(isset($arr_pay_methods) && !empty($arr_pay_methods))
										@foreach($arr_pay_methods as $row)
										<option value="{{ $row['id'] ?? '' }}" {{ in_array($row['id'], $arr_defined_pay_methods)?'selected':'' }} >{{ $row['name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">Admin Note</label>
		                           	<textarea name="admin_note" rows="5" cols="5" class="form-control" placeholder="Admin Note" >{{ $arr_invoice['admin_note']??'' }}</textarea>
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
									@if(isset($arr_products) && !empty($arr_products))
									@foreach($arr_products as $product)
									<option>
										<strong>{{ $product['name'] ?? '' }}</strong> <br>
										{{ $product['description'] ?? '' }}
									</option>
									@endforeach
									@endif
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
									<th>Item</th>
									<th>Description</th>
									<th>Qty</th>
									<th>Rate</th>
									<th>Tax</th>
									<th>Amount</th>
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
									<td>
										<input type="number" value="0" class="form-control" min="0" id="unit_rate" readonly="readonly">
									</td>
									<td>
										<select class="select" id="unit_tax">
											<option>No selected</option>
											@if(isset($arr_taxes) && !empty($arr_taxes))
											@foreach($arr_taxes as $tax)
											<option value="{{ $tax['id'] }}">{{ $tax['name'] }}</option>
											@endforeach
											@endif
										</select>
									</td>
									<td class="unit_price"></td>
									<td>
										<button class="btn btn-sm btn-primary" id="btnCLone" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
									</td>
								</tr>
								@if(isset($arr_invoice['inv_details']) && sizeof($arr_invoice['inv_details'])>0)
								@foreach($arr_invoice['inv_details'] as $product_key => $product_value)
									<tr>
										<td>
											<input type="hidden" name="prod_id[]" value="{{ $product_value['product_id'] ?? '' }}">
											<textarea name="prod_name[]" cols="5" class="form-control" id="sel_prod_name">{{ $product_value['product_details']['name'] ?? '' }}</textarea>
										</td>
										<td>
											<textarea name="prod_descr[]" cols="5" class="form-control" id="sel_prod_descr">{{ $product_value['product_details']['description'] ?? '' }}</textarea>
										</td>
										<td>
											<input type="number" class="form-control" min="0" name="unit_quantity[]" id="unit_quantity" value="{{ $product_value['quantity'] ?? '' }}">
										</td>
										<td>
											<input type="number" class="form-control" min="0" name="unit_rate[]" id="unit_rate" readonly="readonly" value="{{ $product_value['rate'] ?? '' }}">
										</td>
										<td>
											<select class="select" name="unit_tax[]" id="unit_tax">
												<option>No selected</option>
												@if(isset($arr_taxes) && !empty($arr_taxes))
												@foreach($arr_taxes as $tax)
													<option value="{{ $tax['id'] }}" @if(isset($product_value['product_details']['tax_id']) && $product_value['product_details']['tax_id']!='' && $product_value['product_details']['tax_id'] == $tax['id']) selected @endif>{{ $tax['name'] }}</option>
												@endforeach
												@endif
											</select>
										</td>
										<td class="unit_price"></td>
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
						<table class="table text-right">
						    <tbody>
						        <tr>
						           <td><span class="font-weight-bold">Sub Total :</span>
						           </td>
						           <td class="subtotal">$0.00<input type="hidden" name="subtotal" value="0.00"></td>
						        </tr>
						        <tr>
						           <td>
						              <div class="row">
						                 <div class="col-md-8">
						                    <span class="font-weight-bold">Discount</span>
						                 </div>
						                 <div class="col-md-4">
						                    <div class="input-group">
						                       <input type="number" class="form-control" min="0" max="100" name="discount_num" id="discount_num" value="{{ $arr_invoice['discount']??'' }}">
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
		                   	<textarea name="client_note" rows="5" cols="5" class="form-control" placeholder="Client Note" >{{ $arr_invoice['client_note']??'' }}</textarea>
						</div>
						<div class="form-group col-sm-12">
							<label class="col-form-label">Terms & Conditions</label>
		                   	<textarea name="terms_n_cond" rows="5" cols="5" class="form-control" placeholder="Terms & Conditions" >{{ $arr_invoice['terms_n_cond'] ?? '' }}</textarea>
						</div>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Update</button>&nbsp;&nbsp;
	                	<a href="{{ Route('estimates') }}" class="btn btn-secondary btn-rounded">Cancel</a>
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
                <h4 class="modal-title text-center">Add New item</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('product_store') }}" id="createProdForm">

					{{ csrf_field() }}

					<div class="row">
				        <div class="form-group col-md-12">
							<label class="col-form-label">Description <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control" name="name" placeholder="Enter Description" data-rule-required="true">
						</div>
						<div class="form-group col-sm-12">
							<label>Long Description</label>
							<textarea name="description" rows="5" cols="5" class="form-control" placeholder="Enter message"></textarea>
						</div>
						<div class="form-group col-md-12">
							<label class="col-form-label">Rate <span class="text-danger">*</span></label>
	                        <input type="number" class="form-control" name="rate" placeholder="Enter Rate" data-rule-required="true">
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">Choose Tax</label>
	                        <select class="select" name="tax_id">
								<option>No Tax</option>
								@if(isset($arr_taxes) && !empty($arr_taxes))
								@foreach($arr_taxes as $tax)
								<option value="{{ $tax['id'] }}">{{ $tax['name'] }}</option>
								@endforeach
								@endif
							</select>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label">Unit : Cubic Meter ( m³ )</label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label">Min Quantity</label>
	                        <input type="number" class="form-control" name="min_quant" placeholder="Enter Min Quantity" min="1" value="1" >
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded">Cancel</button>
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

		calculate_prop_amnt();

		$("#include_shipping").change(function(){
			if($(this).is(':checked')) {
				$("#shipping_details").fadeIn();
			}else{
				$("#shipping_details").fadeOut();
			}
		});

		$("#unit_quantity, #discount_num").change(function(){
			calculate_prop_amnt();
		});

		$('.select2').select2();

		var data = [
					@if(isset($arr_products) && !empty($arr_products))
					@foreach($arr_products as $product)
					{
						id: '{{ $product['id'] ?? '' }}',
						text: '',
						html: '<strong>{{ $product['name'] ?? '' }}</strong><br><p>{{ $product['description'] ?? '' }}<p>'
					},
					@endforeach
					@endif
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

		    var callUrl = "{{ Route('product_edit','') }}/"+btoa(prodId);

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
  						$('.clone_master').find("#unit_tax option[value="+response.data.tax_id+"]").prop('selected', true);
  						$('.clone_master').find("#unit_tax").select2().trigger('change');

  						var unitPrice = (response.data.min_quant * response.data.rate);

  						$('.clone_master').find('.unit_price').html(unitPrice);

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

				$.ajax({
					url: "{{ Route('confirm_est_product') }}",
	  				type:'GET',
	  				dataType:'json',
	  				data : {
	  					prod_id : prodId,
	  					quantity : quant,
	  				},
	  				beforeSend: function() {
				        showProcessingOverlay();
				    },
	  				success:function(response)
	  				{
	  					hideProcessingOverlay();
	  					if(response.status.toLowerCase() == 'success') {
	  						console.log(response.html);
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

	});

	function initiate_form_validate() {
		$('#formEditEstimate').validate({
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
			url: "{{ Route('calculate_prop_amnt') }}",
				type:'POST',
				dataType:'json',
				data : $("#formEditEstimate").serialize(),
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

</script>

@stop
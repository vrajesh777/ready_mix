@extends('layout.master')
@section('main_content')

<?php

$clone = $arr_prop_clone??[];

$prop_id = $arr_prop_clone['id']??'';

$ord_items = $clone['product_quantity']??[];

?>

<!-- Page Header -->
<div class="row">
	<form method="POST" action="{{ Route('store_proposal') }}" id="formAddProposal">

		{{ csrf_field() }}

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-6 border-right">
							<div class="row">

								@if(isset($arr_site_setting['sales_with_workflow']) && $arr_site_setting['sales_with_workflow']!='' && $arr_site_setting['sales_with_workflow'] == '1')
								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.select') }}  {{ trans('admin.estimate') }}<span class="text-danger">*</span></label>
		                            <select name="proposal_id" class="select2" id="proposal_id" data-rule-required="true">
										<option value="">{{ trans('admin.select') }}  {{ trans('admin.estimate') }}</option>
										@if(isset($arr_proposals) && !empty($arr_proposals))
											@foreach($arr_proposals as $proposal)
												<option value="{{ $proposal['id'] ?? '' }}" {{ $prop_id==($proposal['id']??'')?'selected':'' }} >{{ $proposal['subject'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<div class="error">{{ $errors->first('proposal_id') }}</div>
								</div>
								@endif

								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.customer') }} <span class="text-danger">*</span></label>
		                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true">
										<option value="">{{ trans('admin.select') }} {{ trans('admin.and') }} {{ trans('admin.begin_typing') }}</option>
										@if(isset($arr_custs) && !empty($arr_custs))
										@foreach($arr_custs as $cust)
										<option value="{{ $cust['id'] ?? '' }}" {{ ($cust['id']??'')==($clone['cust_id']??'')?'selected':'' }} >{{ $cust['first_name'] ?? '' }} {{ $cust['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
									<div class="error">{{ $errors->first('cust_id') }}</div>
								</div>
								<div class="form-group col-sm-12">
									<div class="row">
										<div class="col-md-12">
											<a href="#" class="edit_shipping_billing_info" data-toggle="modal" data-target="#billing_and_shipping_details"><i class="fal fa-pencil"></i></a>
											@include('sales.proposals.address_modal')
										</div>

										<div class="col-md-6">
											<p class="bold">{{ trans('admin.bill_to') }}</p>
											<address>
												<span class="billing_street">{{ $clone['address']??'--' }}</span><br>
												<span class="billing_city">{{ $clone['city']??'--' }}</span>,
												<span class="billing_state">{{ $clone['state']??'--' }}</span>
												<br>
												<span class="billing_zip">{{ $clone['postal_code']??'--' }}</span>
											</address>
										</div>
										<div class="col-md-6">
											<p class="bold">{{ trans('admin.ship_to') }}</p>
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
									<label class="col-form-label">{{ trans('admin.estimate') }} {{ trans('admin.date') }} <span class="text-danger">*</span></label>
		                            <input type="text" name="date" data-rule-required="true" class="form-control datepicker" value="{{ $clone['date']??'' }}">
		                            <div class="error">{{ $errors->first('date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.expiry') }} {{ trans('admin.date') }}</label>
	            					<input type="text" class="form-control datepicker" name="expiry_date" value="{{$clone['open_till']??''}}">
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">

								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.status') }}</label>
		                            <select class="select" name="status">
										<option value="draft">Draft</option>
										<option value="sent">Sent</option>
										<option value="expired">Expired</option>
										<option value="declined">Declined</option>
										<option value="accepted">Accepted</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.sales_agent') }}</label>
	            					<select class="select" name="assigned_to">
										<option value="">{{ trans('admin.no_selected') }}</option>
										@if(isset($arr_sales_user) && !empty($arr_sales_user))
										@foreach($arr_sales_user as $user)
										<option value="{{ $user['id'] ?? '' }}" {{ ($clone['assigned_to']??'')==($user['id']??'')?'selected':''}} >{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.reference') }} #</label>
		                            <input type="text" class="form-control" name="ref_num" placeholder="Reference #" >
		                            <div class="error">{{ $errors->first('ref_num') }}</div>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.admin_note') }}</label>
		                           	<textarea name="admin_note" rows="5" cols="5" class="form-control" placeholder="{{ trans('admin.admin_note') }}" ></textarea>
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
									<option>{{ trans('admin.add') }} {{ trans('admin.item') }}</option>
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
									<th>{{ trans('admin.item') }}</th>
									<th>{{ trans('admin.description') }}</th>
									<th>{{ trans('admin.qty') }}</th>
									<th style="display: none;">{{ trans('admin.rate') }}</th>
									<th>{{ trans('admin.OPC_1') }}</th>
									<th>{{ trans('admin.SRC_1') }}</th>
									<th>{{ trans('admin.tax') }}</th>
									<th>{{ trans('admin.amount') }}</th>
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
											<option>{{ trans('admin.no_selected') }}</option>
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

								@if(isset($ord_items) && !empty($ord_items))
								@foreach($ord_items as $row)

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
									<td>
										<input type="number" name="opc1_rate[]" value="{{ $row['opc_1_rate']??0 }}" class="form-control" min="0" id="opc1_rate" data-rule-required="true" onchange="calculate_prop_amnt()" >
									</td>
									<td>
										<input type="number" name="src5_rate[]" value="{{ $row['src_5_rate']??0 }}" class="form-control" min="0" id="src5_rate" onchange="calculate_prop_amnt()" >
									</td>
									<td>
										<select name="unit_tax[]" class="select unit_tax">
											<option value="">No selected</option>
											@if(isset($arr_taxes) && !empty($arr_taxes))
											@foreach($arr_taxes as $tax)
											<option value="{{ $tax['id'] }}" {{ ($row['tax_id']??'')==$tax['id']?'selected':'' }} >{{ $tax['name'] }}</option>
											@endforeach
											@endif
										</select>
									</td>
									<td class="unit_price">{{ format_price($total??0) }}</td>
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
						           <td><span class="font-weight-bold">{{ trans('admin.sub_total') }}:</span>
						           </td>
						           <td class="subtotal">$0.00<input type="hidden" name="subtotal" value="0.00"></td>
						        </tr>
						        <tr>
						           <td>
						              <div class="row">
						                 <div class="col-md-8">
						                    <span class="font-weight-bold">{{ trans('admin.discount') }}</span>
						                 </div>
						                 <div class="col-md-4">
						                    <div class="input-group">
						                       <input type="number" class="form-control" min="0" max="100" name="discount_num" id="discount_num" value="{{ $clone['discount']??'' }}">
						                       <div class="input-group-append">
													<button type="button" class="btn btn-white dropdown-toggle py-2" data-toggle="dropdown">%</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item disc_type_opt" data-type="percentage" href="javascript:void(0);">%</a>
														<a class="dropdown-item disc_type_opt" data-type="fixed" href="javascript:void(0);">{{ trans('admin.fixed') }} {{ trans('admin.discount') }}</a>
													</div>
												</div>

						                    </div>
						                 </div>
						              </div>
						           </td>
						           <td class="discount-total tot_disc">-$0.00</td>
						        </tr>
						        <tr class="table-light">
						           <td><span class="font-weight-bold">{{ trans('admin.total') }} :</span>
						           </td>
						           <td class="total font-weight-bold grand_tot">$0.00</td>
						        </tr>
						    </tbody>
						</table>
					</div>

					<div class="row">
						<div class="form-group col-sm-12">
							<label class="col-form-label">{{ trans('admin.client_note') }}</label>
		                   	<textarea name="client_note" rows="5" cols="5" class="form-control" placeholder="Client Note" ></textarea>
						</div>
						<div class="form-group col-sm-12">
							<label class="col-form-label">{{ trans('admin.terms_&_conditions') }}</label>
		                   	<textarea name="terms_n_cond" rows="5" cols="5" class="form-control" placeholder="Terms & Conditions" ></textarea>
						</div>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<a href="{{ Route('proposals') }}" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</a>
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
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.new') }} {{ trans('admin.item') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('product_store') }}" id="createProdForm">

					{{ csrf_field() }}

					<div class="row">
				        <div class="form-group col-md-12">
							<label class="col-form-label">{{ trans('admin.description') }} <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control" name="name" placeholder="{{ trans('admin.description') }}" data-rule-required="true">
						</div>
						<div class="form-group col-sm-12">
							<label>{{ trans('admin.long_description') }}</label>
							<textarea name="description" rows="5" cols="5" class="form-control" placeholder="{{ trans('admin.long_description') }}"></textarea>
						</div>
						<div class="form-group col-md-12">
							<label class="col-form-label">{{ trans('admin.rate') }}  <span class="text-danger">*</span></label>
	                        <input type="number" class="form-control" name="rate" placeholder="{{ trans('admin.rate') }} " data-rule-required="true">
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.choose') }} {{ trans('admin.tax') }}</label>
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
							<label class="col-form-label">{{ trans('admin.unit') }} : {{ trans('admin.cubic_meter') }}</label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label">{{ trans('admin.min_qty') }}</label>
	                        <input type="number" class="form-control" name="min_quant" placeholder="Enter Min Quantity" min="1" value="1" >
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</button>
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

		@if(Request::has('prop') && Request::get('prop') != '')
		calculate_prop_amnt();
		@endif

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
					url: "{{ Route('confirm_prop_product') }}",
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
				url:'{{ Route('get_user_meta','') }}/'+btoa(cust_id),
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
			url: "{{ Route('calculate_prop_amnt') }}",
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

			var callUrl = "{{ Route('get_prop_to_est_clone_data','') }}/"+btoa(prop_id);

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

@stop
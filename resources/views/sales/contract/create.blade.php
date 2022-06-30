@extends('layout.master')
@section('main_content')

<?php

$clone = $arr_est_clone??[];

$est_id = $clone['id']??'';

$ord_items = $clone['prop_details']??[];

?>

<!-- Page Header -->
<form method="POST" action="{{ Route('cust_store_contract') }}" id="formAddProposal" enctype="multipart/form-data">
	<div class="row">
		{{ csrf_field() }}

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="form-group col-sm-3">
							<label class="col-form-label">{{ trans('admin.site') }} {{ trans('admin.name') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="{{ trans('admin.site') }} {{ trans('admin.name') }}" data-rule-required="true">
                            <div class="error">{{ $errors->first('title') }}</div>
						</div>
						<div class="form-group col-sm-3">
							<label class="col-form-label">{{ trans('admin.customer') }} <span class="text-danger">*</span></label>
                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true">
								<option value="">{{ trans('admin.select') }} {{ trans('admin.and') }} {{ trans('admin.begin_typing') }} </option>
								@if(isset($arr_custs) && !empty($arr_custs))
								@foreach($arr_custs as $cust)
								<option value="{{$cust['id']??''}}" {{ ($cust_id??'')==($cust['id']??'')?'selected':'' }} >{{ $cust['first_name'] ?? '' }} {{ $cust['last_name'] ?? '' }}</option>
								@endforeach
								@endif
							</select>
							<div class="error">{{ $errors->first('cust_id') }}</div>
						</div>
						<div class="form-group col-sm-3">
							<label class="col-form-label">{{ trans('admin.status') }}</label>
                            <select class="select" name="status">
								<option value="unsigned">{{ trans('admin.unsigned') }}</option>
								<option value="signed">{{ trans('admin.signed') }}</option>
							</select>
						</div>
						<div class="form-group col-sm-3">
							<label class="col-form-label">{{ trans('admin.sales_agent') }}</label>
        					<select class="select" name="sales_agent">
								<option value="">{{ trans('admin.no_selected') }}</option>
								@if(isset($arr_sales_user) && !empty($arr_sales_user))
								@foreach($arr_sales_user as $user)
								<option value="{{$user['id']??''}}" {{($user['id']??'')==($clone['assigned_to']??'')?'selected':''  }} >{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</option>
								@endforeach
								@endif
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="col-form-label">{{ trans('admin.comp_strg_on_cube') }}</label>
	                        <input type="text" name="compressive_strength" class="form-control" placeholder="{{ trans('admin.comp_strg_on_cube') }}" data-rule-number="true">
	                        <label class="error" id="compressive_strength_error"></label>
						</div>
						<div class="form-group col-md-3">
							<label class="col-form-label">{{ trans('admin.structure_element') }}</label>
	                        <input type="text" name="structure_element" class="form-control" placeholder="{{ trans('admin.structure_element') }}">
	                        <label class="error" id="structure_element_error"></label>
						</div>
						<div class="form-group col-md-3">
							<label class="col-form-label">{{ trans('admin.slump') }}</label>
	                        <input type="text" name="slump" class="form-control" placeholder="{{ trans('admin.slump') }}">
	                        <label class="error" id="slump_error"></label>
						</div>
						<div class="form-group col-md-3">
							<label class="col-form-label">{{ trans('admin.concrete_temp') }} (°C)</label>
	                        <input type="text" name="concrete_temp" class="form-control" placeholder="{{ trans('admin.concrete_temp') }}" data-rule-number="true">
	                        <label class="error" id="concrete_temp_error"></label>
						</div>
						<div class="form-group col-md-2">
							<label class="col-form-label">{{ trans('admin.quantity') }}</label>
	                        <input type="text" name="quantity" min="1" class="form-control" placeholder="{{ trans('admin.quantity') }}" data-rule-number="true">
	                        <label class="error" id="quantity_error"></label>
						</div>
						<div class="form-group col-sm-2">
							<label class="col-form-label">{{ trans('admin.expected') }} m³</label>
                            <input type="text" class="form-control" name="excepted_m3" id="excepted_m3" placeholder="{{ trans('admin.expected') }} m³" data-rule-number="true">
                            <div class="error">{{ $errors->first('excepted_m3') }}</div>
						</div>
						<div class="form-group col-sm-4">
							<label class="col-form-label">{{ trans('admin.site') }} ({{ trans('admin.location') }})</label>
							<input type="text" class="form-control" name="site_location" id="site_location" placeholder="{{ trans('admin.site') }} ({{ trans('admin.location') }})" maxlength="55">
						</div>
						<div class="form-group col-sm-4">
							<label class="col-form-label">{{ trans('admin.delivery') }} {{ trans('admin.address') }}</label>
							<input type="text" class="form-control" name="delivery_address" id="delivery_address" placeholder="{{ trans('admin.delivery') }} {{ trans('admin.address') }}" maxlength="255">
						</div>
						<div class="form-group col-sm-4">
							<label class="col-form-label">{{ trans('admin.admin_note') }} </label>
                           	<textarea name="admin_note" rows="2" cols="2" class="form-control" placeholder="{{ trans('admin.admin_note') }}" >{{ $clone['admin_note']??'' }}</textarea>
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
									<th>{{ trans('admin.OPC_1') }}</th>
									<th>{{ trans('admin.SRC_1') }}</th>
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
										<input type="number" value="0" class="form-control" min="0" id="opc1_rate">
									</td>
									<td>
										<input type="number" value="0" class="form-control" min="0" id="src5_rate">
									</td>
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
										<input type="number" name="opc1_rate[]" value="{{ $row['opc_1_rate']??0 }}" class="form-control" min="0" id="opc1_rate" data-rule-required="true">
									</td>
									<td>
										<input type="number" name="src5_rate[]" value="{{ $row['src_5_rate']??0 }}" class="form-control" min="0" id="src5_rate">
									</td>
									<td>
										<button class="btn btn-sm btn-danger" id="btnRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
									</td>
								</tr>

								@endforeach
								@endif

							</tbody>
						</table>
					</div>
					
					<div class="row">
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.client_note') }}</label>
		                   	<textarea name="client_note" rows="2" cols="2" class="form-control" placeholder="Client Note" >{{ $clone['client_note']??'' }}</textarea>
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.terms_&_conditions') }}</label>
		                   	<textarea name="terms_n_cond" rows="2" cols="2" class="form-control" placeholder="Terms & Conditions" >{{ $clone['terms_n_cond']??'' }}</textarea>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.contract') }}</label>
							<input type="file" class="file-text form-control" name="contract" id="contract" accept="image/*,.pdf">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.quotation') }}</label>
	    					<input type="file" class="file-text form-control" name="quotation" id="quotation" accept="image/*,.pdf">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.baladiya_permission') }} </label>
	    					<input type="file" class="file-text form-control" name="bala_per" id="bala_per" accept="image/*,.pdf">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.owner_id') }}</label>
	    					<input type="file" class="file-text form-control" name="owner_id" id="owner_id" accept="image/*,.pdf">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.credit_form') }}</label>
	    					<input type="file" class="file-text form-control" name="credit_form" id="credit_form" accept="image/*,.pdf">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.purchase_order') }}</label>
	    					<input type="file" class="file-text form-control" name="purchase_order" id="purchase_order" accept="image/*,.pdf">
						</div>
						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.pay_grnt') }}</label>
	    					<input type="file" class="file-text form-control" name="pay_grnt" id="pay_grnt" accept="image/*,.pdf">
						</div>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<a href="{{ Route('proposals') }}" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</a>
	                </div>
				</div>
			</div>
		</div>

	</div>
</form>
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
		$("#include_shipping").change(function(){
			if($(this).is(':checked')) {
				$("#shipping_details").fadeIn();
			}else{
				$("#shipping_details").fadeOut();
			}
		});

		$('.select2').select2();

		var data = [
					@if(isset($arr_products) && !empty($arr_products))
					@foreach($arr_products as $product)
					{
						id: '{{ $product['id'] ?? '' }}',
						text: '',
						html: '<strong>{{ $product['name'] ?? '' }}</strong><br><p>{!! $product['description'] ?? '' !!}<p>'
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
  						$('.clone_master').find("#opc1_rate").val(response.data.opc_1_rate);
  						$('.clone_master').find("#src5_rate").val(response.data.src_5_rate);
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
				var opc1_rate = $('#opc1_rate').val();
				var src5_rate = $('#src5_rate').val();

				$.ajax({
					url: "{{ Route('confirm_contr_product') }}",
	  				type:'GET',
	  				dataType:'json',
	  				data : {
	  					prod_id : prodId,
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
	  						
	  						$( '.clone_master' ).find('input').val('');
			    			$( '.clone_master' ).find('textarea').val('');
			 
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
</script>

@stop
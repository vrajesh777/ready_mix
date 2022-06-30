@extends('layout.master')
@section('main_content')

<div class="row">
	<form method="POST" action="{{ Route('store_estimate') }}" id="formAddProposal">

		{{ csrf_field() }}

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-6 border-right">
							<div class="row">
								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.subject') }}<span class="text-danger">*</span></label>
		                            <input type="text" class="form-control" name="subject" placeholder="{{ trans('admin.subject') }}" data-rule-required="true" >
		                            <div class="error">{{ $errors->first('subject') }}</div>
								</div>
								<div class="form-group col-sm-12 related_wrapp">
									<label class="col-form-label">{{ trans('admin.related') }}<span class="text-danger">*</span></label>
		                            <select name="related" class="select select2" id="related" data-rule-required="true">
										<option value="">{{ trans('admin.not_selected') }}</option>
										<option value="lead">{{ trans('admin.lead') }}</option>
										<option value="customer">{{ trans('admin.customer') }}</option>
									</select>
									<div class="error">{{ $errors->first('related') }}</div>
								</div>
								<div class="form-group col-sm-12 user_id_wrapp" style="display: none;">
									<label class="col-form-label user_id_label">{{ trans('admin.lead') }}<span class="text-danger">*</span></label>
		                            <select name="user_id" class="select2" id="user_id" data-rule-required="true">
										<option value="">{{ trans('admin.select') }} {{ trans('admin.and') }} {{ trans('admin.begin_typing') }}</option>
									</select>
									<div class="error">{{ $errors->first('user_id') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.date') }}<span class="text-danger">*</span></label>
		                            <input type="text" name="date" data-rule-required="true" class="form-control datepicker">
		                            <div class="error">{{ $errors->first('date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.open_till') }}</label>
	            					<input type="text" class="form-control datepicker" name="open_till">
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
										<option value="open">Open</option>
										<option value="revised">Revised</option>
										<option value="declined">Declined</option>
										<option value="accepted">Accepted</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.assigned') }}</label>
	            					<select class="select" name="assigned_to">
										<option value="">No selected</option>
										@if(isset($arr_sales_user) && !empty($arr_sales_user))
										@foreach($arr_sales_user as $user)
										<option value="{{ $user['id'] ?? '' }}">{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</option>
										@endforeach
										@endif
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.to') }}<span class="text-danger">*</span></label>
		                            <input type="text" class="form-control" name="to" placeholder="{{ trans('admin.to') }}" data-rule-required="true" >
		                            <div class="error">{{ $errors->first('to') }}</div>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">{{ trans('admin.address') }}<span class="text-danger">*</span></label>
		                           	<textarea name="address" rows="5" cols="5" class="form-control" placeholder="{{ trans('admin.address') }}" data-rule-required="true" ></textarea>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.city') }}</label>
		                            <input type="text" class="form-control" name="city" placeholder="{{ trans('admin.city') }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.state') }}</label>
	            					<input type="text" class="form-control" name="state" placeholder="{{ trans('admin.state') }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.zip_code') }}</label>
	            					<input type="text" class="form-control" name="postal_code" placeholder="{{ trans('admin.zip_code') }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.email') }}<span class="text-danger">*</span></label>
		                            <input type="text" class="form-control" name="email" data-rule-required="true" data-rule-email="true" placeholder="{{ trans('admin.email') }}">
		                            <div class="error">{{ $errors->first('email') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.phone') }}</label>
	            					<input type="text" class="form-control" name="phone" placeholder="{{ trans('admin.phone') }}">
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

							</tbody>
						</table>
					</div>
					<div class="col-md-8 offset-4">
						<table class="table text-right">
						    <tbody>
						        <tr>
						           <td><span class="font-weight-bold">{{ trans('admin.sub_total') }} :</span>
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
						                       <input type="number" value="0" class="form-control" min="0" max="100" name="discount_num" id="discount_num">
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

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<a href="{{ Route('estimates') }}" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</a>
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
							<label class="col-form-label">{{ trans('admin.rate') }} <span class="text-danger">*</span></label>
	                        <input type="number" class="form-control" name="rate" placeholder="{{ trans('admin.rate') }}" data-rule-required="true">
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.choose') }} {{ trans('admin.tax') }}</label>
	                        <select class="select" name="tax_id">
								<option value="">{{ trans('admin.no') }} {{ trans('admin.tax') }}</option>
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
	                        <input type="number" class="form-control" name="min_quant" placeholder="{{ trans('admin.min_qty') }}" min="1" value="1" >
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

		$('.disc_type_opt').click(function(){
			var discType = $(this).data('type');
			$("#disc_type").val(discType);
			calculate_prop_amnt();
		});

		$("#unit_quantity, #discount_num, #opc1_rate, #src5_rate").change(function(){
			calculate_prop_amnt();
		});

		$('.select2').select2();

		$('#related').select2({
			placeholder: "Search for an Item",
		    minimumInputLength: 2,
		}).on('change', function (e) {
		    var related = $("#related option:selected").val();
		    if(related == 'lead') {
		    	$('.user_id_wrapp').fadeIn();
		    	$(".user_id_label").html('Lead <span class="text-danger">*</span>');
		    }else if(related == 'customer') {
		    	$('.user_id_wrapp').fadeIn();
		    	$(".user_id_label").html('Customer <span class="text-danger">*</span>');
		    }else{
		    	$('.user_id_wrapp').fadeOut();
		    	// $("#user_id").prop('disabled', true);
		    }
		});

		$('#user_id').select2({
			placeholder: "Search for an Item",
		    minimumInputLength: 2,
		    ajax: {
		        url: "{{ Route('get_related_person') }}",
		        dataType: 'json',
		        type: "GET",
		        quietMillis: 50,
		        data: function (term) {
		            return {
		                keyword: term.term,
		                related: $("#related option:selected").val()
		            };
		        },
		        beforeSend: function() {
			        showProcessingOverlay();
			    },
			    success:function(response)
  				{
  					hideProcessingOverlay();
  				},
		        results: function (data) {
		            return {
		                results: $.map(data, function (item) {
		                    return {
		                        text: item.completeName,
		                        id: item.id
		                    }
		                })
		            };
		        },
  				error:function(){
  					hideProcessingOverlay();
  				}
		    }
		}).on('change', function (e) {
		    var related = $("#related option:selected").val();
		    var user_id = $("#user_id option:selected").val();

		    $.ajax({
				url: "{{ Route('prop_related_user_details') }}",
				type:'POST',
				dataType:'json',
				data : {
					_token:"{{ csrf_token() }}",
					related:related,
					user_id:user_id
				},
		        beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status.toLowerCase() == 'success') {
						$("input[name=to]").val(response.data.to_name);
						$("textarea[name=address]").val(response.data.address);
						$("input[name=city]").val(response.data.city);
						$("input[name=state]").val(response.data.state);
						$("input[name=postal_code]").val(response.data.postal_code);
						$("input[name=email]").val(response.data.email);
						$("input[name=phone]").val(response.data.phone);
					}
				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		});

		$('#productSrch').select2({
			placeholder: "Search for an Item",
		    minimumInputLength: 2,
		    ajax: {
		        url: "{{ Route('product_search') }}",
		        dataType: 'json',
		        type: "GET",
		        quietMillis: 50,
		        data: function (term) {
		            return {
		                keyword: term.term
		            };
		        },
		        results: function (data) {
		            return {
		                results: $.map(data, function (item) {
		                    return {
		                        text: item.completeName,
		                        id: item.id
		                    }
		                })
		            };
		        }
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
					url: "{{ Route('confirm_est_product') }}",
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
			url: "{{ Route('calculate_est_amnt') }}",
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

</script>

@stop
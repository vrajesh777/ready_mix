@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('product-create'))
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_product" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.product') }}</button>
                </li>
                @endif
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0 datatable">
						<thead>
							<tr>
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.arabic_name') }}</th>
								<th>{{ trans('admin.english_name') }}</th>
								<th>{{ trans('admin.rate') }}</th>
								<th>{{ trans('admin.tax') }}</th>
								<th>{{ trans('admin.min_qty') }}</th>
								@if($obj_user->hasPermissionTo('product-update'))
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right">{{ trans('admin.actions') }}</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['id'] ?? '' }}</td>
										<td>{{ $value['name'] ?? '' }}</td>
										<td>{{ $value['name_english'] ?? '' }}</td>
										<td>{{ format_price($value['rate'] ?? '') }}</td>
										<td>{{ $value['tax_detail']['name'] ?? '' }} ({{ $value['tax_detail']['tax_rate'] ?? '' }}%)</td>
										<td>{{ $value['min_quant'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('product-update'))
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('product_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('product_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>

										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_product" onclick="product_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
										</td>
										@endif
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Content End -->

<!-- Add Modal -->
<div class="modal right fade" id="add_product" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.product') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('product_store') }}" id="frmAddProduct">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.mix_code') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="mix_code" id="mix_code" placeholder="{{ trans('admin.mix_code') }}" data-rule-required="true">
                					<label class="error" id="mix_code_error"></label>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.mix_design_arabic') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('admin.mix_design_arabic') }}" data-rule-required="true">
                					<label class="error" id="name_error"></label>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.mix_design_english') }}<span class="text-danger"></span></label>
                					<input type="text" class="form-control" name="name_english" id="name_english" placeholder="{{ trans('admin.mix_design_english') }}" data-rule-required="false">
                					<label class="error" id="name_english_error"></label>
								</div>
							</div>
							@if($obj_user->hasPermissionTo('product-price-update'))
								<div class="form-group row">
									<div class="col-sm-3">
										<label class="col-form-label">{{ trans('admin.OPC_rate') }}</label>
	                					<input type="text" class="form-control" name="opc_1_rate" id="opc_1_rate" placeholder="{{ trans('admin.OPC_rate') }}">
	                					<label class="error" id="mix_code_error"></label>
									</div>
									<div class="col-sm-3">
										<label class="col-form-label">{{ trans('admin.SRC_rate') }}</label>
	                					<input type="text" class="form-control" name="src_5_rate" id="src_5_rate" placeholder="{{ trans('admin.SRC_rate') }}">
	                					<label class="error" id="name_src_5_rater"></label>
									</div>
									<div class="col-sm-3">
										<label class="col-form-label">{{ trans('admin.rate') }}<span class="text-danger">*</span></label>
	                					<input type="text" class="form-control" name="rate" id="rate" placeholder="{{ trans('admin.rate') }}" data-rule-required="true" data-rule-number="true">
	                					<label class="error" id="rate_error"></label>
									</div>
									<div class="col-sm-3">
										<label class="col-form-label">{{ trans('admin.tax') }}<span class="text-danger">*</span></label>
			                            <select class="form-control" name="tax_id" id="tax_id" data-rule-required="true">
			                                <option value="">{{ trans('admin.select') }} {{ trans('admin.tax') }}</option>
			                                @if(isset($arr_tax) && sizeof($arr_tax)>0)
			                                	@foreach($arr_tax as $tax)
			                                		<option value="{{ $tax['id'] ?? '' }}">{{ $tax['name'] ?? '' }} ({{ number_format($tax['tax_rate'],2) ?? '' }} %)</option>
			                                	@endforeach
			                                @endif
			                             </select>
			                             <label class="error" id="tax_id_error"></label>
									</div>
								</div>
							@endif
							<div class="form-group row">
								<div class="col-sm-3">
									<label class="col-form-label">{{ trans('admin.min_qty') }}</label>
                					<input type="text" class="form-control" name="min_quant" placeholder="Minimum Qty" id="min_quant" data-rule-required="true" data-rule-digits="true">
                					<label class="error" id="min_quant_error"></label>
								</div>
								<div class="col-sm-9">
									<label class="col-form-label">{{ trans('admin.description') }}</label>
                					<textarea class="form-control" rows="2" name="description" id="description" placeholder="{{ trans('admin.description') }}"></textarea>
                					<label class="error" id="description_error"></label>
								</div>
							</div>
							<div class="row">
								@if(isset($arr_attribute) && sizeof($arr_attribute)>0)
									@foreach($arr_attribute as $attr_key => $attr_value)
										@if($attr_value['name'] === "Cement Type")
										<div class="col-sm-3">
											<label class="col-form-label">{{ $attr_value['name'] ?? '' }}<span class="text-danger">*</span></label>
											<select class="form-control" name="dynamic_att[{{ $attr_value['id'] ?? '' }}]" id="{{ $attr_value['id'] ?? '' }}"  data-rule-required="true">
			                                <option value="" hidden>{{ trans('admin.select') }}</option>
			                                @if(sizeof(CEMENT_TYPE))
			                                	@foreach(CEMENT_TYPE as $cement_type)
			                                		<option value="{{ $cement_type ?? '' }}">{{ $cement_type ?? '' }}</option>
			                                	@endforeach
			                                @endif
			                             </select>
										 <input type="text" class="form-control" name="dynamic_att[{{'other-'.$attr_value['id'] ?? '' }}]" id="{{'other-'.$attr_value['id'] ?? '' }}" placeholder="{{'Enter '. $attr_value['name'] ?? '' }}" data-rule-required="false">
			            				 <label class="error" id="{{ $attr_value['slug'] ?? '' }}_error"></label>
										</div>
										@elseif($attr_value['name'] === "Slamp")
										<div class="col-sm-3">
											<label class="col-form-label">{{ $attr_value['name'] ?? '' }}<span class="text-danger">*</span></label>
											<select class="form-control" name="dynamic_att[{{ $attr_value['id'] ?? '' }}]" id="{{ $attr_value['id'] ?? '' }}"  data-rule-required="true">
			                                <option value="" hidden>{{ trans('admin.select') }}</option>
			                                @if(sizeof(SLAMP))
			                                	@foreach(SLAMP as $slamp)
			                                		<option value="{{ $slamp ?? '' }}">{{ $slamp ?? '' }}</option>
			                                	@endforeach
			                                @endif
			                             </select>
										 <input type="text" class="form-control" name="dynamic_att[{{'other-'.$attr_value['id'] ?? '' }}]" id="{{'other-'.$attr_value['id'] ?? '' }}" placeholder="{{'Enter '. $attr_value['name'] ?? '' }}" data-rule-required="false">
			            				 <label class="error" id="{{ $attr_value['slug'] ?? '' }}_error"></label>
										</div>
										@elseif($attr_value['name'] === "Air Content")
										<div class="col-sm-3">
											<label class="col-form-label">{{ $attr_value['name'] ?? '' }}<span class="text-danger">*</span></label>
											<select class="form-control" name="dynamic_att[{{ $attr_value['id'] ?? '' }}]" id="{{ $attr_value['id'] ?? '' }}"  data-rule-required="true">
			                                <option value="" hidden>{{ trans('admin.select') }}</option>
			                                @if(sizeof(AIR_CONTENT))
			                                	@foreach(AIR_CONTENT as $air_content)
			                                		<option value="{{ $air_content ?? '' }}">{{ $air_content ?? '' }}</option>
			                                	@endforeach
			                                @endif
			                             </select>
										 <input type="text" class="form-control" name="dynamic_att[{{'other-'.$attr_value['id'] ?? '' }}]" id="{{'other-'.$attr_value['id'] ?? '' }}" placeholder="{{'Enter '. $attr_value['name'] ?? '' }}" data-rule-required="false">
			            				 <label class="error" id="{{ $attr_value['slug'] ?? '' }}_error"></label>
										</div>
										@else
										<div class="col-sm-3">
											<label class="col-form-label">{{ $attr_value['name'] ?? '' }}<span class="text-danger">*</span></label>
			            					<input type="text" class="form-control" name="dynamic_att[{{ $attr_value['id'] ?? '' }}]" id="{{ $attr_value['id'] ?? '' }}" placeholder="{{ $attr_value['name'] ?? '' }}" data-rule-required="true">
			            					<label class="error" id="{{ $attr_value['slug'] ?? '' }}_error"></label>
										</div>
										@endif
									@endforeach
								@endif
							</div>
			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div>
			            </form>
			        </div>
				</div>
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- Add modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('product_store') }}";
	var updateUrl = "{{ Route('product_update','') }}";

	function handleDropDown(selectElem,otherInputId){
			if(selectElem){
				if($(selectElem).val()==='OTHERS'){
					$(otherInputId).show();
				}
				else{
					$(otherInputId).val('');
					$(otherInputId).hide();
				}
			}
	}

	$(document).ready(function(){
		
		$(document).on('change','select[name^="dynamic_att[14]"]',function(){
			handleDropDown('select[name^="dynamic_att[14]"]','#other-14');
		});

		$(document).on('change','select[name^="dynamic_att[15]"]',function(){
			handleDropDown('select[name^="dynamic_att[15]"]','#other-15');
		});

		$(document).on('change','select[name^="dynamic_att[17]"]',function(){
			handleDropDown('select[name^="dynamic_att[17]"]','#other-17');
		});

		$('#name').blur(function(){
			isArabic($(this));
		});

		$(document).on('shown.bs.modal','#add_product', function (e) {
			setTimeout(() => {
				handleDropDown('#14','#other-14');
				handleDropDown('#15','#other-15');
				handleDropDown('#17','#other-17');
			}, 1000);
		});

		$('#frmAddProduct').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#frmAddProduct").submit(function(e) {
			e.preventDefault();
			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
      				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#add_product").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddProduct')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function product_edit(enc_id)
	{
		$('.top_title').html('Edit Product');

		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){
							showProcessingOverlay();
						},
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'SUCCESS')
							{
								$('#frmAddProduct').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');
								$('#name').val(response.data.name);
								$('#name_english').val(response.data.name_english);
								$('#mix_code').val(response.data.mix_code);
								$('#rate').val(response.data.rate);
								$('#min_quant').val(response.data.min_quant);
								$('#description').val(response.data.description);
								$('#opc_1_rate').val(response.data.opc_1_rate);
								$('#src_5_rate').val(response.data.src_5_rate);
								$('select[name^="tax_id"] option[value="'+response.data.tax_id+'"]').attr("selected","selected");

								$.each(response.data.attr_values, function( index, value ) {
								  	$('#'+value.product_attr_id).val(value.value);
									$('#other-'+value.product_attr_id).val(value.other_val);
								});
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}
</script>
@stop
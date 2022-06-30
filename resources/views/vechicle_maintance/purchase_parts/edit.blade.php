@extends('layout.master')
@section('main_content')

@php
	$count = isset($arr_data['parts_details'])?count($arr_data['parts_details']):0;
@endphp

<form method="POST" action="{{ Route('vhc_purchase_parts_update',$enc_id) }}" id="formAddUser" enctype="multipart/form-data">
	<div class="row">
		{{ csrf_field() }}
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<h5>{{ trans('admin.purchase') }} {{ trans('admin.parts') }} {{ trans('admin.from') }}</h5><hr>
					<div class="row">
						{{-- <div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.part') }}<span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('admin.part') }}" data-rule-required="true" value="{{ $arr_data['name'] ?? '' }}">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('name') }}</div>
        					</div>
						</div> --}}
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.part') }}<span class="text-danger">*</span></label>
	                            <select name="part_id" class="select2" id="part_id" data-rule-required="true">
									<option value="">Select Part</option>
									@if(isset($arr_items) && sizeof($arr_items)>0)
										@foreach($arr_items as $item)
											<option value="{{ $item['id'] ?? '' }}"  @if(isset($arr_data['part_id']) && $arr_data['part_id']!='' && $arr_data['part_id'] == $item['id']) selected @endif>{{ $item['commodity_name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('part_id') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.supplier') }} <span class="text-danger">*</span></label>
	                            <select name="supply_id" class="select2" id="supply_id" data-rule-required="true" disabled>
									<option value="">{{ trans('admin.select') }} {{ trans('admin.supplier') }}</option>
									@if(isset($arr_supplier) && sizeof($arr_supplier)>0)
										@foreach($arr_supplier as $supplier)
											<option value="{{ $supplier['id'] ?? '' }}" @if(isset($arr_data['vendor_id']) && $arr_data['vendor_id']!='' && $arr_data['vendor_id'] == $supplier['id']) selected @endif>{{ $supplier['first_name'] ?? '' }} {{ $supplier['last_name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('supply_id') }}</div>
        					</div>
						</div>
						<input type="hidden" name="supply_id" value="{{ $arr_data['vendor_id'] ?? 0 }}">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.manufacturer') }} <span class="text-danger">*</span></label>
	                            <select name="manufact_id" class="select2" id="manufact_id" data-rule-required="true">
									<option value="">{{ trans('admin.select') }} {{ trans('admin.manufacturer') }}</option>
									@if(isset($arr_manufacturer) && sizeof($arr_manufacturer)>0)
										@foreach($arr_manufacturer as $manufact)
											<option value="{{ $manufact['id'] ?? '' }}" @if(isset($arr_data['manufact_id']) && $arr_data['manufact_id']!='' && $arr_data['manufact_id'] == $manufact['id']) selected @endif>{{ $manufact['name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('manufact_id') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.condition') }} <span class="text-danger">*</span></label>
	                            <select name="condition" id="condition" data-rule-required="true" class="select2">
									<option value="new"@if(isset($arr_data['condition']) && $arr_data['condition']!='' && $arr_data['condition'] == 'new') selected @endif>New</option>
									<option value="old"@if(isset($arr_data['condition']) && $arr_data['condition']!='' && $arr_data['condition'] == 'old') selected @endif>Old</option>
								</select>
								<div class="error">{{ $errors->first('condition') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.buy') }} {{ trans('admin.price') }}({{ trans('admin.per_pcs') }})  <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="buy_price" id="buy_price" placeholder="{{ trans('admin.buy') }} {{ trans('admin.price') }}({{ trans('admin.per_pcs') }}) " data-rule-required="true" value="{{ $arr_data['buy_price'] ?? 0 }}" data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('buy_price') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.qty') }} <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="quantity" id="quantity" placeholder="{{ trans('admin.qty') }}" data-rule-required="true" value="{{ $arr_data['quantity'] ?? 0 }}" data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('quantity') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.sell') }} {{ trans('admin.price') }}  ({{ trans('admin.per_pcs') }}) </label>
            					<input type="text" class="form-control" name="sell_price" id="sell_price" placeholder="0.00" value="{{ $arr_data['sell_price'] ?? 0 }}">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('sell_price') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.part') }} {{ trans('admin.no') }}  <span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="part_no" id="part_no" placeholder="{{ trans('admin.part') }} {{ trans('admin.no') }} " data-rule-required="true" value="{{ $arr_data['part_no'] ?? '' }}">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('part_no') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.purchase') }} {{ trans('admin.date') }} <span class="text-danger">*</span></label>
	                            <input type="text" name="purch_date" data-rule-required="true" class="form-control datepicker" value="{{ $arr_data['order_date'] ?? '' }}">
	                            <div class="error">{{ $errors->first('purch_date') }}</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.parts') }} {{ trans('admin.warranty') }} </label>
            					<input type="text" class="form-control" name="warrenty" id="warrenty" placeholder="5 Years or 6 Months" value="{{ $arr_data['warrenty'] ?? '' }}">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('warrenty') }}</div>
        					</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.total_amount') }} <span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="0.00" data-rule-required="true" value="{{ $arr_data['total'] ?? '' }}" readonly data-rule-number="true">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('total_amount') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.given_amount') }} <span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="given_amount" id="given_amount" placeholder="0.00" data-rule-required="true" value="{{ $arr_data['given_amount'] ?? 0 }}">
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('given_amount') }}</div>
        					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.pending_amount') }}<span class="text-danger">*</span></label>
            					<input type="text" class="form-control" name="pending_amount" id="pending_amount" placeholder="0.00" data-rule-required="true" value="{{ $arr_data['pending_amount'] ?? 0 }}" readonly>
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('pending_amount') }}</div>
        					</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.parts') }} {{ trans('admin.image') }}</label>
	                           	<div class="position-relative p-0">
	        						<input type="file" class="file-text form-control" name="image" id="image" accept="application/pdf,image/jpeg,image/jpg,image/png">
	    						</div>
	    					</div>
						</div>
					</div>

					<h5>{{ trans('admin.parts_fits_with') }} </h5><hr>
					<div class="row">

						<table id="partsdata" class="table table-bordered">
							<thead>
								<tr>
									<th>{{ trans('admin.make') }}</th>
									<th>{{ trans('admin.model') }}</th>
									<th>{{ trans('admin.year') }}</th>
									<th></th>
								</tr>
							</thead>
							<tfoot>
								@if(isset($arr_data['parts_details']) && sizeof($arr_data['parts_details'])>0)
								@foreach($arr_data['parts_details'] as $p_key => $p_val)
									<tbody id='parts-row{{ $p_key ?? 0 }}'>
										<tr>
											<td class='left'>
												<select class='form-control' id="make_{{ $p_key ?? 0 }}" onchange='loadModelDatax(this,{{ $p_key ?? 0 }});' name='partsfilter[{{ $p_key ?? 0 }}][make]'>
													<option value=''>--{{ trans('admin.select') }} {{ trans('admin.make') }}--</option>
													@if(isset($arr_make) && sizeof($arr_make)>0)
														@foreach($arr_make as $make)
															<option value="{{ $make['id'] ?? 0 }}" @if($make['id'] == $p_val['make_id']) selected @endif>{{ $make['make_name'] ?? 0 }}</option>
														@endforeach
													@endif
												</select>
											</td>
											<td class='left'>
												<select class='form-control' onchange='loadYearDatax(this,{{ $p_key ?? 0 }});' name='partsfilter[{{ $p_key ?? 0 }}][model]' id='model_{{ $p_key ?? 0 }}'>
													<option value=''>--{{ trans('admin.select') }} {{ trans('admin.model') }}--</option>
													@if(isset($arr_model) && sizeof($arr_model)>0)
														@foreach($arr_model as $model)
															@if($model['make_id'] == $p_val['make_id'])
																<option value="{{ $model['id'] ?? 0 }}" @if($model['id'] == $p_val['model_id']) selected @endif>{{ $model['model_name'] ?? 0 }}</option>
															@endif
														@endforeach
													@endif
												</select>
											</td>
											@php
												$yearArray = [];
												$start = get_year_from_model_make($p_val['make_id'],$p_val['model_id']);
												if($start!='')
												{
													$end = date('Y');
								                	$yearArray = range($start,$end);
												}
											@endphp
											<td class='left'>
												<select class='form-control' name='partsfilter[{{ $p_key ?? 0 }}][year]' id='year_{{ $p_key ?? 0 }}'>
													<option value=''>--{{ trans('admin.select') }} {{ trans('admin.year') }}--</option>
													
													@if(isset($yearArray) && sizeof($yearArray)>0)
														@foreach($yearArray as $year)
															{{-- @if($year['id'] == $p_val['year_id']) --}}
																<option value="{{ $year ?? 0 }}" @if($year == $p_val['year_id']) selected @endif>{{ $year ?? 0 }}</option>
															{{-- @endif --}}
														@endforeach
													@endif

												</select>
											</td>
											<td class='left'>
												<button class='btn btn-danger' title='Remove' data-toggle='tooltip' onclick="$( '#parts-row{{ $p_key ?? 0 }}').remove()"; type='button'><i class='fa fa-minus-circle'></i></button>
											</td>
										</tr>
									</tbody>
								@endforeach
								@endif

				                <tr>
				                  	<td colspan="4"></td>
				                  	<td class="left"><button class="btn btn-primary" title="" data-toggle="tooltip" onclick="addPartsData();" type="button"><i class="fa fa-plus-circle"></i></button></td>
				                </tr>
				            </tfoot>
						</table>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</button>
	                </div>

				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Page Header -->

<script type="text/javascript">

	$(document).ready(function() {

		initiate_form_validate();

		$('.select2').select2();

		$(".ppcal").keyup(function() {
			partsBuyPriceCalculation();
		});

		/*loadModelDatax();
		loadYearDatax();*/

	});

	function partsBuyPriceCalculation() {
		var parts_price = 0;
		var qty = 0;
		var given_amount = 0;
		
		if($("#buy_price").val() != '') {
			parts_price = $("#buy_price").val();
		}
		if($("#quantity").val() != '') {
			qty = $("#quantity").val();
		}
		if($("#given_amount").val() != '') {
			given_amount = $("#given_amount").val();
		}
		var total  = parseFloat(parseFloat(parts_price) * parseInt(qty));
		var ptotal = parseFloat(parseFloat(parseFloat(parts_price) * parseInt(qty)) - parseFloat(given_amount));
		
		ptotal = ptotal.toFixed(2);
		total = total.toFixed(2);
		$("#pending_amount").val(ptotal);
		$("#total_amount").val(total);
	}

	function initiate_form_validate() {
		$('#formAddUser').validate({
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

	var arr_make = <?php echo json_encode($arr_make); ?>;
	var parts_rows = "{{ $count ?? 0 }}";
	function addPartsData() {

		var makeOption = '<option value="">{{ trans('admin.select') }} {{ trans('admin.model') }}</option>'; 
		if(typeof(arr_make) == 'object')
		{
			$(arr_make).each(function(index,make){
				makeOption+='<option value="'+make.id+'">'+make.make_name+'</option>';
			})
		}

		html  = '<tbody id="parts-row' + parts_rows + '">';
		html += '  <tr>';
		html += '    <td class="left"><select class="form-control" id="make_' + parts_rows + '" name="partsfilter[' + parts_rows + '][make]" onchange="loadModelDatax(this,' + parts_rows + ');">';
		html += makeOption;
		html += '    </td>';

		html += '    <td class="left"><select class="form-control" disabled="disabled" id="model_' + parts_rows + '" name="partsfilter[' + parts_rows + '][model]" onchange="loadYearDatax(this,' + parts_rows + ');">';
		html += '      <option value="">--{{ trans('admin.select') }} {{ trans('admin.model') }} --</option>';
		html += '    </select></td>';
		html += '    <td class="left"><select class="form-control" id="year_' + parts_rows + '" disabled="disabled" name="partsfilter[' + parts_rows + '][year]">';
		html += '      <option value="">--{{ trans('admin.select') }} {{ trans('admin.year') }}--</option>';
		html += '    </select></td>';

		html += '    <td class="left"><button class="btn btn-danger" title="Remove" data-toggle="tooltip" onclick="$(\'#parts-row' + parts_rows + '\').remove();" type="button"><i class="fa fa-minus-circle"></i></button></td>';
		html += '  </tr>';	
		html += '</tbody>';
		
		$('#partsdata tfoot').before(html);
		
		parts_rows++;
	}

	function loadModelDatax(obj,row){
		if(obj.value != ''){
			$.ajax({
				type: "GET",
				url: '{{ Route('get_model_html','') }}/'+obj.value,
				success: function(response) {
					if(response.status == 'success'){
						$("#model_" + row).html(response.data);
						$("#model_" + row).prop('disabled', false);
					}
					else{
						alert('Wrong Request');
						$("#model_" + row).prop('disabled', true);
					}
				},
			});
		}
	}

	function loadYearDatax(obj,row){
		if(obj.value != ''){
			var post_url = '{{ Route('get_year_html') }}'+'?model_id='+obj.value+'&make_id='+$("#make_" + row).val();
			$.ajax({
				type: "GET",
				url: post_url,
				success: function(response) {
					if(response.status == 'success'){
						$("#year_" + row).html(response.data);
						$("#year_" + row).prop('disabled', false);
					}
					else{
						alert('Wrong Request');
						$("#year_" + row).prop('disabled', true);
					}
				},
			});
		}
	}
</script>

@stop
@extends('layout.master')
@section('main_content')

<link rel="stylesheet" href="{{ asset('/css/handsontable.css') }}">
<script src="{{ asset('/js/handson/handsontable.full.min.js') }}"></script>
<link rel="stylesheet" type="text/css" id="vendor-css" href="https://shaimaa.softclicksol.com/crm/assets/builds/A.vendor-admin.css,qv=2.7.2.pagespeed.cf.CNDifrkKx9.css">

<script type="text/javascript">
    var app= {};
    app.options= {};
    app.lang= {};
</script>

<h4 class="card-title mt-0 mb-2">{{ trans('admin.create') }} {{ trans('admin.purchase_order') }}</h4>

<form method="POST" action="{{ Route('purchase_order_store') }}" id="formAddPo" autocomplete="off">
	<div class="row">

		{{ csrf_field() }}
		<input type="hidden" name="purchase_order_detail" value="">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-12">
							<div class="row">

                                <div class="form-group col-sm-3">
                                    <label class="col-form-label">{{ trans('admin.purchase_order') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"  name="name" id="name" placeholder="Purchase order name" data-rule-required="true">
                                    <label class="error" id="name_error"></label>
                                </div>
                                @if(isset($arr_site_setting['purchase_with_workflow']) && $arr_site_setting['purchase_with_workflow']!='' && $arr_site_setting['purchase_with_workflow'] == '1')
                                    <div class="form-group col-sm-3 related_wrapp">
                                        <label class="col-form-label">For Estimate<span class="text-danger">*</span></label>
                                        <select name="estimate_id" class="select select2" id="estimate_id" data-rule-required="true">
                                            <option value="">{{ trans('admin.no_selected') }}</option>
                                            @if(isset($arr_estimate) && sizeof($arr_estimate)>0)
                                                @foreach($arr_estimate as $estimate)
                                                    <option value="{{ $estimate['id'] ?? '' }}" data-vendor-id="{{$estimate['vendor_id'] ?? ''}}">{{ $estimate['estimate_no'] ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="estimate_id-error" class="error" for="estimate_id"></label>
                                        <div class="error">{{ $errors->first('estimate_id') }}</div>
                                    </div>
                                @endif

								<div class="form-group col-sm-3 related_wrapp">
									<label class="col-form-label">{{ trans('admin.vendor') }}<span class="text-danger">*</span></label>
		                            <select name="vendor_id" class="form-control" id="vendor_id" data-rule-required="true">
										<option value="">Not Selected</option>
										@if(isset($arr_vendor) && sizeof($arr_vendor)>0)
											@foreach($arr_vendor as $vendor)
												<option value="{{ $vendor['id'] ?? '' }}">{{ $vendor['user_meta'][0]['meta_value'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label id="vendor_id-error" class="error" for="vendor_id"></label>
									<div class="error">{{ $errors->first('vendor_id') }}</div>
								</div>

                                <div class="form-group col-sm-2">
                                    <label class="col-form-label">{{ trans('admin.order') }} {{ trans('admin.date') }}  <span class="text-danger">*</span></label>
                                    <div class="position-relative p-0">
                                        <input class="form-control datepicker pr-5" name="order_date" data-rule-required="true">
                                        <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
                                    </div>
                                    <div class="error">{{ $errors->first('order_date') }}</div>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label class="col-form-label">{{ trans('admin.no_of_days_owed') }}</label>
                                    <input type="text" class="form-control"  name="no_of_days_owned" id="no_of_days_owned" placeholder="Number of days owed">
                                    <label class="error" id="no_of_days_owned_error"></label>
                                </div>

                                <div class="form-group col-sm-2">
                                    <label class="col-form-label">{{ trans('admin.delivery_date') }}</label>
                                    <div class="position-relative p-0">
                                        <input class="form-control datepicker pr-5" name="delivery_Date" data-rule-required="true">
                                        <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
                                    </div>
                                    <div class="error">{{ $errors->first('delivery_Date') }}</div>
                                </div>

							</div>
						</div>
					</div>

					<div class="row">
                        <div class="col-md-12">
                            <p class="bold p_style">{{ trans('admin.purchase_order') }} 
                        {{ trans('admin.details') }} </p>
                        <hr class="hr_style"/>
                        <div id="example">
                        </div>
                        </div>

                        <input type="hidden" name="estimate_detail" value=""/>
                        <div class="col-md-6 col-md-offset-6">
                            <table class="table text-right">
                                <tbody>
                                    <tr id="subtotal">
                                        <td class="td_style"><span class="bold">{{ trans('admin.sub_total') }}</span>
                                        </td>
                                        <td width="65%" id="total_td">

                                            <div class="input-group" id="discount-total">

                                                <input type="text" readonly class="form-control text-right" name="total_mn" value="">

                                                <div class="input-group-addon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" id="dropdown_menu_tax_total_type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <span class="discount-type-selected">{{ trans('admin.sar') }}</span>
                                                        </a>

                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="discount_area">
                                        <td>
                                            <span class="bold">{{ trans('admin.discount') }}</span>
                                        </td>
                                        <td>  
                                            <div class="input-group" id="discount-total">
                                                <input type="number" value="" onchange="dc_percent_change(this); return false;" class="form-control pull-left input-percent text-right" min="0" max="100" name="dc_percent">
                                                <div class="input-group-addon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" id="dropdown_menu_tax_total_type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <span class="discount-type-selected">%</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="discount_area">
                                        <td>
                                            <span class="bold">{{ trans('admin.discount') }}</span>
                                        </td>
                                        <td>  
                                            <div class="input-group" id="discount-total">

                                                <input type="text" value="" class="form-control pull-left text-right" onchange="dc_total_change(this); return false;" data-type="currency" name="dc_total">

                                                <div class="input-group-addon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" id="dropdown_menu_tax_total_type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <span class="discount-type-selected">{{ trans('admin.sar') }}</span>
                                                            </a>

                                                        </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="td_style"><span class="bold">{{ trans('admin.after') }} {{ trans('admin.discount') }} </span>
                                        </td>
                                        <td width="55%" id="total_td">

                                            <div class="input-group" id="discount-total">

                                                <input type="text" readonly class="form-control text-right" name="after_discount" value="">

                                                <div class="input-group-addon">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="#" id="dropdown_menu_tax_total_type" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <span class="discount-type-selected">{{ trans('admin.sar') }}</span>
                                                            </a>

                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                    <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="col-form-label">{{ trans('admin.vendor') }}  {{ trans('admin.note') }} </label>
                        <textarea class="form-control"  name="vendor_note" id="vendor_note" placeholder="Vendor note"></textarea>
                        <label class="error" id="name_error"></label>
                    </div>

                    <div class="form-group col-sm-6">
                        <label class="col-form-label"> {{ trans('admin.terms_&_conditions') }}</label>
                        <textarea class="form-control"  name="terms_conditions" id="terms_conditions" placeholder="{{ trans('admin.terms_&_conditions') }}"></textarea>
                        <label class="error" id="name_error"></label>
                    </div>
                    </div>
                                    
					<div class="text-center py-3">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<a href="{{ Route('purchase_order') }}" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</a>
	                </div>

				</div>
			</div>
		</div>

	</div>
</form>

<script src="{{ asset('/js/handson/vendor-admin.js') }}"></script>
<script src="{{ asset('/js/handson/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/handson/common.js') }}"></script>
<script src="{{ asset('/js/handson/chosen.jquery.js') }}"></script>
<script src="{{ asset('/js/handson/handsontable-chosen-editor.js') }}"></script>
<script src="{{ asset('/js/handson/main.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#formAddPo').validate();
	});

    $('#estimate_id').change(function(){
        var vendor_id = $(this).find(':selected').data('vendor-id');
        var estimate_id = $(this).val();
        $('select[name^="vendor_id"] option[value="'+vendor_id+'"]').attr("selected","selected");

        $.ajax({
            url : '{{ Route('get_estimate_deatils','') }}/'+btoa(estimate_id),
            type : 'GET',
            success:function(response)
            {
                hot.loadData(response.data.arr_estimate);

                $('input[name=dc_percent]').val(response.data.arr_base_estimate.dc_percent);
                $('input[name=dc_total]').val(response.data.arr_base_estimate.dc_total);
                $('input[name=after_discount]').val(response.data.arr_base_estimate.after_discount);
                $('input[name=no_of_days_owned]').val(response.data.arr_base_estimate.days_owed);
            }
      });
    });
</script>

<script>
(function($) {
    "use strict";
    validate_estimates_form();
    function validate_estimates_form(selector) {

        selector = typeof(selector) == 'undefined' ? '#estimate-form' : selector;

        appValidateForm($(selector), {
            vendor: 'required',
            pur_request: 'required',
            date: 'required',
            currency: 'required',
            number: {
                required: true
            }
        });

    }

    })(jQuery);

    function removeCommas(str) {
        "use strict";
        return(str.replace(/,/g,''));
    }

    function dc_percent_change(invoker){
        "use strict";
        var total_mn = $('input[name="total_mn"]').val();
        var t_mn = parseFloat(removeCommas(total_mn));
        var rs = (t_mn*invoker.value)/100;

        $('input[name="dc_total"]').val(numberWithCommas(rs));
        $('input[name="after_discount"]').val(numberWithCommas(t_mn - rs));

    }

    function dc_total_change(invoker){
        "use strict";
        var total_mn = $('input[name="total_mn"]').val();
        var t_mn = parseFloat(removeCommas(total_mn));
        var rs = t_mn - parseFloat(removeCommas(invoker.value));

        $('input[name="after_discount"]').val(numberWithCommas(rs));
    }

    function numberWithCommas(x) {
        "use strict";
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var dataObject = [];
    var hotElement = document.querySelector('#example');
    var hotElementContainer = hotElement.parentNode;
    var hotSettings = {
        data: dataObject,
        columns: [
                    {
                        data: 'item_code',
                        renderer: customDropdownRenderer,
                        editor: "chosen",
                        width: 150,
                        chosenOptions: {
                            data: [
                            			@if(isset($arr_items) && !empty($arr_items))
						                    @foreach($arr_items as $item)
						                    {"id":"{{ $item['id'] }}","label":"{{ $item['commodity_code'].' - '.$item['commodity_name'] }}"},
						                    @endforeach
					                    @endif
                            	  ]}
                    },
                    {
                        data: 'unit_id',
                        renderer: customDropdownRenderer,
                        editor: "chosen",
                        width: 50,
                        chosenOptions: {
                            data: [
                            @if(isset($arr_units) && !empty($arr_units))
			                    @foreach($arr_units as $unit)
			                    {"id":"{{ $unit['id'] }}","label":"{{ $unit['unit_name'] }}"},
			                    @endforeach
		                    @endif
                		]},
                            readOnly: true

                    },
                    {
                        data: 'unit_price',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0,0'
                        },

                    },
                    {
                        data: 'quantity',
                        type: 'numeric',

                    },
                    {
                        data: 'into_money',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0,0'
                        },
                        readOnly: true
                    },
                    {
                        data: 'tax',
                        renderer: customDropdownRenderer,
                        editor: "chosen",
                        multiSelect:true,
                        width: 50,
                        chosenOptions: {
                            multiple: true,
                            data: [
                            		@if(isset($arr_taxes) && sizeof($arr_taxes)>0)
                            			@foreach($arr_taxes as $taxes)
                            				{"id":"{{ $taxes['id'] ?? '' }}","label":"{{ $taxes['name'] ?? '' }}","taxrate":"{{ $taxes['tax_rate'] ?? '' }}"},
                            			@endforeach
                            		@endif

                            	  ]  }
                    },
                    {
                        data: 'total',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0,0'
                        },
                        readOnly: true
                    },
                    {
                        data: 'discount_%',
                        type: 'numeric',

                    },
                    {
                        data: 'discount_money',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0,0'
                        }
                    },
                    {
                        data: 'total_money',
                        type: 'numeric',
                        numericFormat: {
                            pattern: '0,0'
                        }

                    }

                ],
            licenseKey: 'non-commercial-and-evaluation',
            stretchH: 'all',
            width: '100%',
            autoWrapRow: true,
            rowHeights: 30,
            columnHeaderHeight: 40,
            minRows: 10,
            maxRows: 22,
            rowHeaders: true,
            colWidths: [200,10,100,50,100,50,100,50,100,100],
            colHeaders: [
            'Items',
            'Unit',
            'Unit price',
            'Quantity',
            'Subtotal(before tax)',
            'Tax',
            'Subtotal(after tax)',
            'Discount(%)',
            'Discount(money)',
            'Total',
            ],
            columnSorting: {
                indicator: true
            },
            autoColumnSize: {
                samplingRatio: 23
            },
            dropdownMenu: true,
            mergeCells: true,
            contextMenu: true,
            manualRowMove: true,
            manualColumnMove: true,
            multiColumnSorting: {
                indicator: true
            },
            filters: true,
            manualRowResize: true,
            manualColumnResize: true
    };

    var hot = new Handsontable(hotElement, hotSettings);
    hot.addHook('afterChange', function(changes, src) {
        if(changes !== null){
            changes.forEach(([row, prop, oldValue, newValue]) => {
                if(newValue != ''){
                    if(prop == 'item_code'){
                        $.post("{{ Route('get_item_details','') }}/"+btoa(newValue)).done(function(response){
                            response = JSON.parse(response);

                            hot.setDataAtCell(row,1, response.value.unit_id);
                            hot.setDataAtCell(row,2, response.value.purchase_price);
                            hot.setDataAtCell(row,4, response.value.purchase_price*hot.getDataAtCell(row,3));
                        });

                        $.ajax({
		                    url: "{{ Route('get_item_details','') }}/"+btoa(newValue),
		                    data : {
		                        _token : "{{ csrf_token() }}"
		                    },
		                    method : 'POST',
		                    success: function (response) {
		                        hot.setDataAtCell(row,1, response.data.unit_id);
		                        hot.setDataAtCell(row,2, response.data.purchase_price);
		                        hot.setDataAtCell(row,3, response.data.purchase_price*hot.getDataAtCell(row,3));
		                        hot.setDataAtCell(row,4, response.data.purchase_price*hot.getDataAtCell(row,3));
		                    }
			            });
                    }else if(prop == 'quantity'){
                        hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,2));
                        hot.setDataAtCell(row,6, newValue*hot.getDataAtCell(row,2));
                        hot.setDataAtCell(row,9, newValue*hot.getDataAtCell(row,2));
                    }else if(prop == 'unit_price'){
                        hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,3));
                        hot.setDataAtCell(row,6, newValue*hot.getDataAtCell(row,3));
                        hot.setDataAtCell(row,9, newValue*hot.getDataAtCell(row,3));
                    }else if(prop == 'tax'){
                    	 $.ajax({
		                    url: "{{ Route('get_tax_details','') }}/"+btoa(newValue),
		                    data : {
		                        _token : "{{ csrf_token() }}"
		                    },
		                    method : 'POST',
		                    success: function (response) {
		                      
		                        hot.setDataAtCell(row,6, (response.data.total_tax*parseFloat(hot.getDataAtCell(row,4)))/100 + parseFloat(hot.getDataAtCell(row,4)));
                    			hot.setDataAtCell(row,9, (response.data.total_tax*parseFloat(hot.getDataAtCell(row,4)))/100 + parseFloat(hot.getDataAtCell(row,4)));

		                    }
		                });
                    }else if(prop == 'discount_%'){
                        hot.setDataAtCell(row,8, (newValue*parseFloat(hot.getDataAtCell(row,6)))/100);

                    }else if(prop == 'discount_money'){
                        hot.setDataAtCell(row,9, (parseFloat(hot.getDataAtCell(row,6)) - newValue));
                    }else if(prop == 'total_money'){
                        var total_money = 0;
                        for (var row_index = 0; row_index <= 40; row_index++) {
                            if(parseFloat(hot.getDataAtCell(row_index, 9)) > 0){
                                total_money += (parseFloat(hot.getDataAtCell(row_index, 9)));
                            }
                        }
                        $('input[name="total_mn"]').val(numberWithCommas(total_money));
                        $('input[name="total_mn"]').trigger('change');
                    }
                }

            });
        }
    });

    hot.addHook('afterLoadData', function() {
        var total_money = 0;
        for (var row_index = 0; row_index <= 40; row_index++) {
          if(parseFloat(hot.getDataAtCell(row_index, 9)) > 0){
            total_money += (parseFloat(hot.getDataAtCell(row_index, 9)));
          }
        }
        $('input[name="total_mn"]').val(numberWithCommas(total_money));
        $('input[name=dc_percent]').trigger('change');
        //dc_percent_change
        //dc_total_change
    });

    $('input[name=total_mn]').on('propertychange change click keyup input paste',function(){
        $('input[name=dc_percent]').trigger('change');
        $('input[name=dc_total]').trigger('change');
    })

    $('#formAddPo').on('click', function() {
        $('input[name="purchase_order_detail"]').val(JSON.stringify(hot.getData()));   
    });


   /* function coppy_pur_request(){
        "use strict";
        var pur_request = $('select[name="pur_request"]').val();
        if(pur_request != ''){
            hot.alter('remove_row',0,hot.countRows ());
            $.post(admin_url + 'purchase/coppy_pur_request/'+pur_request).done(function(response){
                response = JSON.parse(response);
                hot.updateSettings({
                    data: response.result,
                });
            });
        }else{
            alert_float('warning', 'Please select a purchase request first!')
        }
    }*/

    function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
        "use strict";
        var selectedId;
        var optionsList = cellProperties.chosenOptions.data;

        if(typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
            Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
            return td;
        }

        var values = (value + "").split("|");
        value = [];
        for (var index = 0; index < optionsList.length; index++) {

            if (values.indexOf(optionsList[index].id + "") > -1) {
                selectedId = optionsList[index].id;
                value.push(optionsList[index].label);
            }
        }
        value = value.join(", ");

        Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
        return td;
    }

</script>
@endsection
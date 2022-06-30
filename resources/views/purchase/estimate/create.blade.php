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

<h4 class="card-title mt-0 mb-2">{{ trans('admin.create') }} {{ trans('admin.estimate') }}</h4>

<form method="POST" action="{{ Route('estimate_store') }}" id="formAddEstimate" autocomplete="off">
	<div class="row">

		{{ csrf_field() }}
		 <input type="hidden" name="purchase_estimate_detail" value="">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="form-group col-sm-3 related_wrapp">
									<label class="col-form-label">{{ trans('admin.vendor') }}<span class="text-danger">*</span></label>
		                            <select name="vendor_id" class="select select2" id="vendor_id" data-rule-required="true">
										<option value="">{{ trans('admin.not_selected') }}</option>
										@if(isset($arr_vendor) && sizeof($arr_vendor)>0)
											@foreach($arr_vendor as $vendor)
												<option value="{{ $vendor['id'] ?? '' }}">{{ $vendor['user_meta'][0]['meta_value'] ?? '' }}</option>
											@endforeach
										@endif
										
									</select>
									<label id="vendor_id-error" class="error" for="vendor_id"></label>
									<div class="error">{{ $errors->first('vendor_id') }}</div>
								</div>
								<div class="form-group col-sm-3 related_wrapp">
									<label class="col-form-label">{{ trans('admin.purchase_request') }}<span class="text-danger">*</span></label>
		                            <select name="pur_req_id" class="select select2" id="pur_req_id" data-rule-required="true">
										<option value="">{{ trans('admin.not_selected') }}</option>
										@if(isset($arr_pur_request) && sizeof($arr_pur_request)>0)
											@foreach($arr_pur_request as $pur_req)
												<option value="{{ $pur_req['id'] ?? '' }}">{{ $pur_req['id'] ?? '' }}-{{ $pur_req['purchase_request_name'] ?? '' }}</option>
											@endforeach
										@endif
										
									</select>
									<label id="pur_req_id-error" class="error" for="pur_req_id"></label>
									<div class="error">{{ $errors->first('pur_req_id') }}</div>
								</div>
				
                                <div class="form-group col-sm-3">
                                    <label class="col-form-label">{{ trans('admin.estimate') }} {{ trans('admin.date') }}<span class="text-danger">*</span></label>
                                    <div class="position-relative p-0">
                                        <input class="form-control datepicker pr-5" name="estimate_date" data-rule-required="true">
                                        <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
                                    </div>
                                    <div class="error">{{ $errors->first('estimate_date') }}</div>
                                </div>

                                <div class="form-group col-sm-3">
                                    <label class="col-form-label">{{ trans('admin.expiry') }} {{ trans('admin.date') }}<span class="text-danger">*</span></label>
                                    <div class="position-relative p-0">
                                        <input class="form-control datepicker pr-5" name="expiry_date" data-rule-required="true">
                                        <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
                                    </div>
                                    <div class="error">{{ $errors->first('expiry_date') }}</div>
                                </div>

							</div>
						</div>
					</div>

					<div class="row">
                        <p class="bold p_style">{{ trans('admin.estimate') }} {{ trans('admin.details') }}</p>
                        <hr class="hr_style"/>
                        <div id="example">
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
                                        <td class="td_style"><span class="bold">{{ trans('admin.after') }} {{ trans('admin.discount') }}</span>
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

					<div class="text-center py-3">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
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
		$('#formAddEstimate').validate();

        $('#pur_req_id').change(function(){
            var pur_req_id = $(this).val();
            if(pur_req_id != '')
            {
                $.ajax({
                    url: "{{ Route('estimate_pur_req_detail','') }}/"+btoa(pur_req_id),
                    method : 'GET',
                    success: function (response) {

                        hot.loadData(response.data);

                    }

                })
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

        /*appValidateForm($(selector), {
            vendor: 'required',
            pur_request: 'required',
            date: 'required',
            currency: 'required',
            number: {
                required: true
            }
        });*/

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

    dataObject = [];

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
            "{{ trans('admin.items') }}",
            "{{ trans('admin.unit') }}",
            "{{ trans('admin.unit_price') }}",
            "{{ trans('admin.qty') }}",
            "{{ trans('admin.sub_total') }}(before tax)",
            "{{ trans('admin.tax') }}",
            "{{ trans('admin.sub_total') }}(after tax)",
            "{{ trans('admin.discount') }}(%)",
            "{{ trans('admin.discount') }}(money)",
            "{{ trans('admin.total') }}",
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
    })

    $('#formAddEstimate').on('click', function() {
        $('input[name="purchase_estimate_detail"]').val(JSON.stringify(hot.getData()));   
    });


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
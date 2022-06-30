@extends('layout.master')
@section('main_content')

<link rel="stylesheet" href="{{ asset('/css/handsontable.css') }}">
<script src="{{ asset('/js/handson/handsontable.full.min.js') }}"></script>

<h4 class="card-title mt-0 mb-2">{{ $page_title ?? '' }}</h4>
<div class="row">
	<div class="col-sm-12">
		<form method="post" action="{{ Route('purchase_request_store') }}" name="frmCreateRequest" id="frmCreateRequest">
		  {{ csrf_field() }}

            <input type="hidden" name="request_detail" value="">

			<div class="row">
				<div class="col-md-8 d-flex">
					<div class="card profile-box flex-fill">
						<div class="card-body">
							<h3 class="card-title border-bottom pb-2 mt-0 mb-3">{{ trans('admin.other_info') }}</h3>

							<div class="row">
								{{-- <div class="form-group col-sm-6">
									<label class="col-form-label">Purchase Request Code<span class="text-danger">*</span></label>
		                            <input type="text" class="form-control"  name="purchase_request_code" id="purchase_request_code" placeholder="Purchase Request Code" data-rule-required="true">
		                            <label class="error" id="purchase_request_code_error"></label>
								</div> --}}
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.purchase_request') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
	            					<input type="text" class="form-control"  name="purchase_request_name" id="purchase_request_name" placeholder="{{ trans('admin.purchase_request') }} {{ trans('admin.name') }}" data-rule-required="true">
	            					<label class="error" id="purchase_request_name_error"></label>
								</div>
								{{-- <div class="form-group col-sm-6">
									<label class="col-form-label">Department<span class="text-danger">*</span></label>
		                            <select class="form-control select2" id="department_id" name="department_id" data-rule-required="true">
										<option value="">Select Department</option>
									</select>
									<label class="error" id="department_id_error"></label>
								</div> --}}
								<div class="form-group col-sm-12">
									<label>{{ trans('admin.description') }}</label>
									<textarea rows="5" cols="5" class="form-control" placeholder="{{ trans('admin.description') }}" name="description" id="description"></textarea>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="col-md-4 d-flex">
					<div class="card profile-box flex-fill">
						<div class="card-body">
							<h3 class="card-title border-bottom pb-2 mt-0 mb-3">{{ trans('admin.general_info') }}</h3>
							<ul class="personal-info border">
								<li>
									<div class="title">{{ trans('admin.requester') }}</div>
									<div class="text">{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</div>
								</li>
								<li>
									<div class="title">{{ trans('admin.req') }} {{ trans('admin.date') }}</div>
									<div class="text">{{ date('Y-m-d') }}</div>
								</li>
							</ul>
							
						</div>
					</div>
				</div>
			</div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group d-flex">
                        <div class="input-group-append cursor-pointer">
                            <span class="border-0 btn btn-primary btn-gradient-primary btn-rounded" data-toggle="modal" data-target="#add_item">{{ trans('admin.add') }} {{ trans('admin.new') }} {{ trans('admin.item') }}</span>
                        </div>
                    </div>
                </div>
            </div>

			<div id="example">
				<hr>
			</div>

			<div class="text-center py-3">
            	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
            	<a href="{{ Route('purchase_request') }}" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</a>
            </div>
		</form>
	</div>
</div>

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

                <form method="post" action="{{ Route('items_store') }}" id="frmAddItem" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="action" value="create">
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div class="tab-pane show active">
                                <div class="row">
                                    {{-- <div class="form-group col-sm-6">
                                        <label class="col-form-label">Commodity Code / Sku Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  name="commodity_code" id="commodity_code" placeholder="Commodity Code / Sku Code" data-rule-required="true">
                                        <label class="error" id="commodity_code_error"></label>
                                    </div> --}}
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">{{ trans('admin.commodity_name') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  name="commodity_name" id="commodity_name" placeholder="{{ trans('admin.commodity_name') }}" data-rule-required="true">
                                    </div>
                                    {{-- <div class="form-group col-md-4">
                                        <label class="col-form-label"> Commodity Barcode <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" placeholder="Commodity Barcode" name="commodity_barcode" id="commodity_barcode" data-rule-required="true">
                                        <label class="error" id="commodity_barcode_error"></label>
                                    </div> --}}
                                    {{-- <div class="form-group col-md-4">
                                        <label class="col-form-label">Sku Code<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" placeholder="First name" name="sku_code" id="sku_code" data-rule-required="true">
                                        <label class="error" id="sku_code_error"></label>
                                    </div> --}}
                                    {{-- <div class="form-group col-md-4">
                                        <label class="col-form-label">Sku Name<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" placeholder="Last name" name="sku_name" id="sku_name" data-rule-required="true">
                                        <label class="error" id="sku_name_error"></label>
                                    </div> --}}
                              
                            
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">{{ trans('admin.commodity_group') }} </label>
                                        <select class="form-control select2" id="commodity_group" name="commodity_group">
                                            <option value="">{{ trans('admin.commodity_group') }} </option>
                                            @if(isset($arr_commodity_group) && sizeof($arr_commodity_group)>0)
                                                @foreach($arr_commodity_group as $group)
                                                    <option value="{{ $group['id'] ?? '' }}">{{ $group['name'] ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    {{-- <div class="form-group col-sm-6">
                                        <label class="col-form-label">Rate<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"  name="rate" id="rate" placeholder="Rate" data-rule-required="true" data-rule-number=true>
                                        <label class="error" id="rate_error"></label>
                                    </div> --}}
                                
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">{{ trans('admin.price') }}<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="{{ trans('admin.price') }}" data-rule-required="true" data-rule-number=true>
                                        <label class="error" id="purchase_price_error"></label>
                                    </div>
                                
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">{{ trans('admin.unit') }}<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="units" name="units" data-rule-required="true">
                                            <option value="">{{ trans('admin.select') }} {{ trans('admin.units') }}</option>
                                            @if(isset($arr_units) && sizeof($arr_units)>0)
                                                @foreach($arr_units as $units)
                                                    <option value="{{ $units['id'] ?? '' }}">{{ $units['unit_name'] ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label class="error" id="units_error"></label>
                                    </div>
                                            
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label">{{ trans('admin.taxes') }}</label>
                                        <select class="form-control" id="tax_id" name="tax_id">
                                            <option value="">{{ trans('admin.select') }} {{ trans('admin.tax') }}</option>
                                            @if(isset($arr_taxes) && sizeof($arr_taxes)>0)
                                                @foreach($arr_taxes as $tax)
                                                    <option value="{{ $tax['id'] ?? '' }}">{{ $tax['name'] ?? '' }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label>{{ trans('admin.description') }}</label>
                                        <textarea rows="5" cols="5" class="form-control" placeholder="{{ trans('admin.description') }}" name="description" id="description"></textarea>
                                    </div>
                                    
                                </div>

                                <div class="user-box user-box-upload-section">
                                   
                                    <div class="main-abt-title">
                                        <label class="name-labell">{{ trans('admin.images') }}{{-- <span class="busine-span-smll"> ( Maximum 5 Images ) </span> --}}</label>
                                    </div>
                                   
                                    <div class="add-busine-multi">
                                        <span data-multiupload="3">
                                            <span data-multiupload-holder></span>
                                            <span class="upload-photo">
                                                <img src="{{ asset('/images/plus-img.jpg') }}" alt="plus img">
                                                <input data-multiupload-src class="upload_pic_btn" type="file" multiple="" data-rule-required="false"> 
                                                <span data-multiupload-fileinputs></span>
                                            </span>
                                        </span>
                                        <div class="clerfix"></div>
                                    </div>
                                 
                                    <div class="clearfix"></div>   

                                    <div class="photo-gallery mt-4">
                                        <div class="row photos item_images">

                                            {{-- <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="images/desk.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="images/desk.jpg"></a></div> --}}
                                            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="text-center py-3">
                            <button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
                        </div> 
                    </div>
                </form>

            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
<!-- modal -->

{{-- <script src="{{ asset('/js/handson/vendor-admin.js') }}"></script> --}}
<script src="{{ asset('/js/handson/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/handson/common.js') }}"></script>
<script src="{{ asset('/js/handson/chosen.jquery.js') }}"></script>
<script src="{{ asset('/js/handson/handsontable-chosen-editor.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
        $("#frmCreateRequest").validate();
		$("#frmAddItem").validate();


        var createUrl = "{{ Route('items_store') }}";
        $("#frmAddItem").submit(function(e) {
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
                    success:function(response)
                    {
                        common_ajax_store_action(response);
                    }
                });
            }
        });

	})
</script>

<script type="text/javascript">
(function($) {
"use strict";  

//appValidateForm($('#add_edit_pur_request-form'),{pur_rq_code:'required', pur_rq_name:'required', department:'required'});
var dataObject = [

];
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
                    ]          
            }
        },
        {
            data: 'unit_id',
            renderer: customDropdownRenderer,
            editor: "chosen",
            width: 150,
            chosenOptions: {
                data: [
                    @if(isset($arr_units) && !empty($arr_units))
                    @foreach($arr_units as $unit)
                    {"id":"{{ $unit['id'] }}","label":"{{ $unit['unit_name'] }}"},
                    @endforeach
                    @endif
                    ]
            },
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
            data: 'inventory_quantity',
            type: 'numeric',
            readOnly: true
        },
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

    colHeaders: [
                'Items',
                'Unit',
                'Unit price',
                'Quantity',
                'Total'
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
    hiddenColumns: {
        columns: [5],
        indicators: true
    },
    filters: true,
    manualRowResize: true,
    manualColumnResize: true
};

var hot = new Handsontable(hotElement, hotSettings);
hot.addHook('afterChange', function(changes, src) {
    changes.forEach(([row, prop, oldValue, newValue]) => {
        if(prop == 'item_code'){

            if(newValue) {
                $.ajax({
                    url: "{{ Route('get_item_details','') }}/"+btoa(newValue),
                    data : {
                        _token : "{{ csrf_token() }}"
                    },
                    method : 'POST',
                    success: function (response) {
                        console.clear();
                        hot.setDataAtCell(row,1, response.data.unit_id);
                        hot.setDataAtCell(row,2, response.data.purchase_price);
                        hot.setDataAtCell(row,3, response.data.purchase_price*hot.getDataAtCell(row,3));
                        hot.setDataAtCell(row,5, response.data.inventory);
                        //console.log(hot.getDataAtCell(row,0));

                    }
                });
            }

        }else if(prop == 'quantity'){
            hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,2));
        }else if(prop == 'unit_price'){
            hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,3));
        }

    });
});

$('#frmCreateRequest').submit(function(e){
    $('input[name="request_detail"]').val(JSON.stringify(hot.getData()));
});

})(jQuery);    

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
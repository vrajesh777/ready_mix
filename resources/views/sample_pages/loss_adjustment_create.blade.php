@extends('layout.master')
@section('main_content')
<link href="{{ asset('/css/handsontable.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('/js/handson/handsontable.full.min.js') }}"></script>
	<div class="row">
		<h4 class="col-md-8 card-title mt-0 mb-2">Add Loss & Adjustment</h4>
	</div>

	<div class="card">
		<div class="card-body">
					<div class="row mb-3">
						<div class="form-group col-sm-4">
							<label class="col-form-label">Time (lost or adjustment )</label>
                  <div class="position-relative p-0">
	        					<input class="form-control datepicker pr-5" name="title">
	        					<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
        					</div>
						</div>

						<div class="form-group col-sm-4">
							<label class="col-form-label">Type<span class="text-danger">*</span></label>
              <select class="select">
								<option>No selected</option>
								<option value="1">CRMAdmin</option>
								<option value="2">Anil Sharma</option>
								<option value="2">Anil Bhosale</option>
							</select>
						</div>
						<div class="form-group col-sm-4">
							<label class="col-form-label">Warehouse<span class="text-danger">*</span></label>
        			<select class="select">
								<option>No selected</option>
								<option value="1">Before Tax</option>
								<option value="2">After Tax</option>
							</select>
						</div>
					</div>
					<h3 class="card-title border-bottom pb-2 mt-0 mb-3"><i class="fal fa-hand-holding-box text-black-50 mr-1"></i>Loss & adjustment detail</h3>
        <form action="https://shaimaa.softclicksol.com/crm/admin/purchase/pur_request" id="add_edit_pur_request-form" method="post" accept-charset="utf-8">
          <input type="hidden" name="csrf_token_name" value="cbb75f4b6a8f543b09adecbc844f752b"/>                     
          <div id="example">
            <hr>
          </div>          
        </form>   
          <div class="form-group">
              <label class="col-form-label">Reason</label>
                <textarea rows="5" cols="5" class="form-control" placeholder="Enter Note"></textarea>
          </div>             
 					<div class="text-center py-3 w-100">
          	<button type="button" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
          	<button type="button" class="btn btn-secondary btn-rounded">Close</button>
          </div>

		</div>
	</div>

<script src="{{ asset('/js/handson/vendor-admin.js') }}"></script>
<script src="{{ asset('/js/handson/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/handson/common.js') }}"></script>
<script src="{{ asset('/js/handson/chosen.jquery.js') }}"></script>
<script src="{{ asset('/js/handson/handsontable-chosen-editor.js') }}"></script>
<script type="text/javascript">
  (function($) {
  "use strict";  

  appValidateForm($('#add_edit_pur_request-form'),{pur_rq_code:'required', pur_rq_name:'required', department:'required'});
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
                data: [{"id":"1","label":" - Cancrete M15"},{"id":"2","label":"2523 - UltraTech Cement"}]          }
          },
          {
            data: 'unit_id',
            renderer: customDropdownRenderer,
            editor: "chosen",
            width: 150,
            chosenOptions: {
                data: [{"id":"1","label":"Kilograms"}]          },
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
          'Total',
          'Inventory quantity'
          
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
          $.post(admin_url + 'purchase/items_change/'+newValue).done(function(response){
            response = JSON.parse(response);

            hot.setDataAtCell(row,1, response.value.unit_id);
            hot.setDataAtCell(row,2, response.value.purchase_price);
            hot.setDataAtCell(row,4, response.value.purchase_price*hot.getDataAtCell(row,3));
            hot.setDataAtCell(row,5, response.value.inventory);
          });

        }else if(prop == 'quantity'){
          hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,2));
        }else if(prop == 'unit_price'){
          hot.setDataAtCell(row,4, newValue*hot.getDataAtCell(row,3));
        }

      });
    });
  $('.save_detail').on('click', function() {
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
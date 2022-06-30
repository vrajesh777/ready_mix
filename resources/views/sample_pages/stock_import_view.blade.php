@extends('layout.master')
@section('main_content')

	<link href="{{ asset('/css/handsontable.css') }}" rel="stylesheet" type="text/css"/>
	<script src="{{ asset('/js/handson/handsontable.full.min.js') }}"></script>
	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Stock received information</h4>
	</div>

	<div class="card">
		<div class="card-body">
			<div class="profile-box flex-fill"></div>
				<h3 class="card-title border-bottom pb-2 mt-0 mb-3">Store Input Slip 
					<a href="{{ Route('stock_import_create') }}" class="edit-icon"><i class="fa fa-pencil"></i></a>
				</h3>
				<div class="row">
					<div class="col-md-3 offset-7 mb-2">Days 31 Month 01 Year 2021</div>
					<div class="col-md-2 mb-2">Debit: .....................</div>
					<div class="col-md-3 offset-7 mb-2">Voucher number: NK01</div>
					<div class="col-md-2 mb-2">Credit: .....................</div>
				</div>

				<div class="row">
					<div class="col-md-4">		
						<ul class="personal-info border rounded-sm mt-2">
							<li>
								<div class="title">Deliver name</div>
								<div class="text">Raj</div>
							</li>
							<li>
								<div class="title">No</div>
								<div class="text">NK01</div>
							</li>
							<li>
								<div class="title">Input in stock</div>
								<div class="text">---</div>
							</li>
							<li>
								<div class="title">attach</div>
								<div class="text">534</div>
							</li>
							<li>
								<div class="title">Download PDF</div>
								<div class="text"><a href="" class="btn btn-secondary btn-sm">Download</a></div>
							</li>
						</ul>		
					</div>
					<div class="col-md-8">
						<div class="table-responsive">
							<table class="table table-stripped mb-0">
								<thead>
									<tr>
										<th>STT</th>
										<th>Commodity Code</th>
										<th>Commodity Name</th>
										<th>Unit Name</th>
										<th>Quantity</th>
										<th>Unit Price</th>
										<th>Total payment</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>NK01</td>
										<td>Jay</td>
										<td>CRM Admin</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
									</tr>
									<tr>
										<td>NK01</td>
										<td>Jay</td>
										<td>CRM Admin</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
									</tr>
									<tr>
										<td>NK01</td>
										<td>Jay</td>
										<td>CRM Admin</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
									</tr>
									<tr>
										<td>NK01</td>
										<td>Jay</td>
										<td>CRM Admin</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
										<td>0.00</td>
									</tr>
								</tbody>
								<tr>
								<td colspan="6" class="text-right">Amount of :</td>	
								<td>0.00(VND)</td>	
								</tr>
								<tr><td colspan="7" class=""></td></tr>
								<tr>
								<td colspan="2" class="border-0 text-center">Deliver name<br>(Sign, full name)</td>	
								<td colspan="2" class="border-0 text-center">Stocker<br>(Sign, full name)</td>	
								<td colspan="3" class="border-0 text-center">Days ......... Month ......... Year ..........<br>Chief accountant<br>(Sign, full name)</td>	
								</tr>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>

	<div class="card mb-0">
		<div class="card-body">
			<h3 class="card-title border-bottom pb-2 mt-0 mb-3"><i class="fal fa-hand-holding-box text-black-50 mr-1"></i>tock received docket detail</h3>
            <div id="small-table">
	              <div class="tab-content">
	                <div role="tabpanel" class="tab-pane active" id="commodity">
	                  <div class="form"> 
	                      <div id="hot_purchase" class="hot handsontable htColumnHeaders">
	                          
	                      </div>
	                    
	                        <input type="hidden" name="hot_purchase" value=""/>
	                  </div>
	                </div>
	                <div role="tabpanel" class="tab-pane" id="tax">
	                </div>
	              </div>

                  <div class="col-md-3 pull-right panel-padding">
                    <table class="table border table-striped table-margintop">
                        <tbody>
                            <tr class="project-overview">
                              <td><div class="form-group" app-field-wrapper="total_goods_money"><label for="total_goods_money" class="control-label">Total goods money</label><input type="" id="total_goods_money" name="total_goods_money" class="form-control" disabled="true" value=""></div>                                            
                          <input type="hidden" name="total_goods_money" value=""/>
                              </td>
                           </tr>

                           <tr class="project-overview">
                              <td><div class="form-group" app-field-wrapper="total_money"><label for="total_money" class="control-label">Total payment</label><input type="" id="total_money" name="total_money" class="form-control" disabled="true" value=""></div>                                            
                          <input type="hidden" name="total_money" value=""/>
                                
                              </td>

                           </tr>
                            </tbody>
                    </table>
                  </div>
                  <div class="col-md-3 pull-right  panel-padding">
                    <table class="table border table-striped table-margintop">
                      <tbody>
                         <tr class="project-overview">
                            <td><div class="form-group" app-field-wrapper="total_tax_money"><label for="total_tax_money" class="control-label">Total tax money</label><input type="" id="total_tax_money" name="total_tax_money" class="form-control" disabled="true" value=""></div>                                          
                          <input type="hidden" name="total_tax_money" value=""/>
                              
                            </td>

                         </tr>
                         <tr class="project-overview">
                            <td><div class="form-group" app-field-wrapper="value_of_inventory"><label for="value_of_inventory" class="control-label">Value of inventory</label><input type="" id="value_of_inventory" name="value_of_inventory" class="form-control" disabled="true" value=""></div>                                          
                          <input type="hidden" name="value_of_inventory" value=""/>
                              
                            </td>
                         </tr>
                         
                          </tbody>
                      </table>
                  </div>
            </div>
		</div>
	</div>

<script src="{{ asset('/js/handson/vendor-admin.js') }}"></script>
<script src="{{ asset('/js/handson/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/handson/common.js') }}"></script>
<script src="{{ asset('/js/handson/chosen.jquery.js') }}"></script>
<script src="{{ asset('/js/handson/handsontable-chosen-editor.js') }}"></script>
<script type="text/javascript">
      var purchase;
    (function($) {
      "use strict";

      appValidateForm($('#add_goods_receipt'), {
         date_c: 'required',
         date_add: 'required',
         warehouse_id: 'required',
        
       }); 



      var dataObject_pu = [];
      var hotElement1 = document.querySelector('#hot_purchase');
        purchase = new Handsontable(hotElement1, {
        licenseKey: 'non-commercial-and-evaluation',

        contextMenu: true,
        manualRowMove: true,
        manualColumnMove: true,
        stretchH: 'all',
        autoWrapRow: true,
        rowHeights: 30,
        defaultRowHeight: 100,
        minRows: 9,
        maxRows: 22,
        width: '100%',
        height: 330,

        rowHeaders: true,
        autoColumnSize: {
          samplingRatio: 23
        },
       
        filters: true,
        manualRowResize: true,
        manualColumnResize: true,
        allowInsertRow: true,
        allowRemoveRow: true,
        columnHeaderHeight: 40,

        colWidths: [110, 100,80, 80,80, 100,120,120,120,120,],
        rowHeights: 30,
        rowHeaderWidth: [44],

        columns: [
                    {
                      type: 'text',
                      data: 'commodity_code',
                      renderer: customDropdownRenderer,
                      editor: "chosen",
                      width: 150,
                      chosenOptions: {
                          data: [{"id":"1","label":"_Cancrete M15"},{"id":"2","label":"2523_UltraTech Cement"}]                  }
                    },
                     
                    {
                      
                      type: 'text',
                      data: 'unit_id',
                      renderer: customDropdownRenderer,
                      editor: "chosen",
                      width: 150,
                      chosenOptions: {
                          data: [{"id":"1","label":"Kilograms"}]                  },
                      readOnly: true

                    },
                    {
                      type: 'numeric',
                      data:'quantity',
                      numericFormat: {
                        pattern: '0,00',
                      }
                    },
                    {
                      type: 'numeric',
                      data: 'unit_price',
                      numericFormat: {
                        pattern: '0,00',
                      },
                      readOnly: true

                          
                    },
                    {
                      type: 'numeric',
                      data:'tax_rate',
                      numericFormat: {
                        pattern: '0,00',
                      },
                    readOnly: true

                    },
                    {
                      type: 'numeric',
                      data: 'into_money',
                      numericFormat: {
                        pattern: '0,00',
                      },
                    readOnly: true

                          
                    },
                    {
                      type: 'numeric',
                      data: 'tax_money',
                      numericFormat: {
                        pattern: '0,00',
                      },
                    readOnly: true

                          
                    },
                    {
                      type: 'date',
                      dateFormat: 'YYYY-MM-DD',
                      correctFormat: true,
                      defaultDate: "2021-01-28"
                    },
                    {
                      type: 'date',
                      dateFormat: 'YYYY-MM-DD',
                      correctFormat: true,
                      defaultDate: "2021-01-28"
                    },
                    {
                      type: 'text',
                      data: 'note',
                    },
                 
                    
                  ],

              colHeaders: [
            'Commodity Code',
            'Unit',
            'Quantity',
            'Unit price',
            'Tax %',
            'Goods money',
            'Tax money',
            'Date Manufacture',
            'Expiry Date',
            'Note',
            
          ],
       
        data: dataObject_pu,

        cells: function (row, col, prop, value, cellProperties) {
            var cellProperties = {};
            var data = this.instance.getData();
            cellProperties.className = 'htMiddle ';
            
            return cellProperties;
          }


      });

    })(jQuery);

      (function($) {
      "use strict";
          
          var purchase_value = purchase;

        purchase.addHook('afterChange', function(changes, src) {
          "use strict";

            if(changes !== null){
            changes.forEach(([row, col, prop, oldValue, newValue]) => {
              if($('select[name="warehouse_id"]').val() == ''){
                alert_float('warning', "Please select a warehouse");

              }else{

                if(col == 'commodity_code' && oldValue != ''&& oldValue != ''){
                  console.log('oldValue', oldValue);
                  $.post(admin_url + 'warehouse/commodity_code_change/'+oldValue ).done(function(response){
                    response = JSON.parse(response);
                      purchase.setDataAtCell(row,1, response.value.unit_id);
                      purchase.setDataAtCell(row,2, '');
                      purchase.setDataAtCell(row,3, response.value.purchase_price);
                      purchase.setDataAtCell(row,4, response.value.taxrate);
                      purchase.setDataAtCell(row,7, '');
                      purchase.setDataAtCell(row,8, '');

                  });
                }
                if(col == 'commodity_code' && oldValue == null){
                    purchase.setDataAtCell(row,1,'');
                    purchase.setDataAtCell(row,2,'');
                    purchase.setDataAtCell(row,3,'');
                    purchase.setDataAtCell(row,4,'');
                    purchase.setDataAtCell(row,5,'');
                    purchase.setDataAtCell(row,6,'');
                    purchase.setDataAtCell(row,7,'');
                    purchase.setDataAtCell(row,8,'');
                }
                if(col == 'quantity' && oldValue != ''){
                      var total_tax_money =0;
                      var total_goods_money =0;
                      var value_of_inventory =0;
                      var total_money =0;

                    purchase.setDataAtCell(row,5,oldValue*purchase.getDataAtCell(row,3));
                    purchase.setDataAtCell(row,6,oldValue*purchase.getDataAtCell(row,3)*(purchase.getDataAtCell(row,4)/100));
                    

                    for (var row_index = 0; row_index <= 20; row_index++) {

                      total_tax_money += (purchase.getDataAtCell(row_index, 2)*purchase.getDataAtCell(row_index, 3))*purchase.getDataAtCell(row_index, 4)/100;
                      total_goods_money += purchase.getDataAtCell(row_index, 2)*purchase.getDataAtCell(row_index, 3);
                      value_of_inventory += purchase.getDataAtCell(row_index, 2)*purchase.getDataAtCell(row_index, 3);

                    }

                      total_money = total_tax_money + total_goods_money;

                      $('input[name="total_tax_money"]').val((total_tax_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                      $('input[name="total_goods_money"]').val((total_goods_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                      $('input[name="value_of_inventory"]').val((value_of_inventory).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                      $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                }else if(col == 'quantity' && oldValue == ''){
                    purchase.setDataAtCell(row,5,0);
                    purchase.setDataAtCell(row,6,0);
                    $('input[name="total_goods_money"]').val(0);
                    $('input[name="value_of_inventory"]').val(0);
                    $('input[name="total_money"]').val(0);
                }
              }

            });
          }
        });

       
          $('.add_goods_receipt').on('click', function() {
            var valid_warehouse_type = $('#hot_purchase').find('.htInvalid').html();

            if(valid_warehouse_type){
              alert_float('danger', "data_must_number");

            }else{
              $('input[name="hot_purchase"]').val(purchase_value.getData());
              $('#add_goods_receipt').submit(); 

            }
          });
            

       })(jQuery);

      function pr_order_change(){
        "use strict";

        var pr_order_id = $('select[name="pr_order_id"]').val();

        if(pr_order_id != ''){
          alert_float('warning', 'Stock received docket from purchase request')
          $.post(admin_url + 'warehouse/coppy_pur_request/'+pr_order_id).done(function(response){
                response = JSON.parse(response);
                console.log(response);
                purchase.updateSettings({
                data: response.result,
                maxRows: response.total_row,
              });
                $('input[name="total_tax_money"]').val((response.total_tax_money));
                $('input[name="total_goods_money"]').val((response.total_goods_money));
                $('input[name="value_of_inventory"]').val((response.value_of_inventory));
                $('input[name="total_money"]').val((response.total_money));



              });
          $.post(admin_url + 'warehouse/copy_pur_vender/'+pr_order_id).done(function(response){
           var response_vendor = JSON.parse(response);

            $('select[name="supplier_code"]').val(response_vendor.userid).change();
            $('select[name="buyer_id"]').val(response_vendor.buyer).change();

          });
          
        }else{
          purchase.updateSettings({
                data: [],
                maxRows: 22,
              });
        }
    }

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
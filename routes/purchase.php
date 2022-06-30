<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Purchase\CommodityGroupsController;
use App\Http\Controllers\Purchase\ItemController;
use App\Http\Controllers\Purchase\PurchaseRequestController;
use App\Http\Controllers\Purchase\VendorController;
use App\Http\Controllers\Purchase\EstimateController;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Purchase\ContractController;

Route::group(array('middleware'=>['auth','purchase']), function ()
{
	Route::group(array('prefix' => 'commodity_groups'), function ()  {
		Route::get('/',						[CommodityGroupsController::class,'index'])->name('commodity_groups');
		Route::post('/store',				[CommodityGroupsController::class,'store'])->name('commodity_groups_store');
		Route::get('/edit/{enc_id}',		[CommodityGroupsController::class,'edit'])->name('commodity_groups_edit');
		Route::post('/update/{enc_id}',		[CommodityGroupsController::class,'update'])->name('commodity_groups_update');
		Route::get('/activate/{enc_id}',	[CommodityGroupsController::class,'activate'])->name('commodity_groups_activate');
		Route::get('/deactivate/{enc_id}',	[CommodityGroupsController::class,'deactivate'])->name('commodity_groups_deactivate');
	});

	Route::group(array('prefix' => 'items'), function ()  {
		Route::get('/',							[ItemController::class,'index'])->name('items');
		Route::post('/store',					[ItemController::class,'store'])->name('items_store');
		Route::get('/edit/{enc_id}',			[ItemController::class,'edit'])->name('items_edit');
		Route::get('/view/{enc_id}',			[ItemController::class,'view'])->name('items_view');
		Route::post('/update/{enc_id}',			[ItemController::class,'update'])->name('items_update');
		Route::get('/activate/{enc_id}',		[ItemController::class,'activate'])->name('items_activate');
		Route::get('/deactivate/{enc_id}',		[ItemController::class,'deactivate'])->name('items_deactivate');
		Route::post('/get_item_details/{enc_id}',[ItemController::class,'get_item_details'])->name('get_item_details');
		Route::post('/get_tax_details/{enc_id}',[ItemController::class,'get_tax_details'])->name('get_tax_details');
	});

	Route::group(array('prefix' => 'purchase_request'), function ()  {
		Route::get('/',						[PurchaseRequestController::class,'index'])->name('purchase_request');
		Route::get('/create',				[PurchaseRequestController::class,'create'])->name('purchase_request_create');
		Route::post('/store',				[PurchaseRequestController::class,'store'])->name('purchase_request_store');
		Route::get('/view/{enc_id}',		[PurchaseRequestController::class,'view'])->name('purchase_request_view');
		Route::post('/pur_req_change_status/{enc_id}',[PurchaseRequestController::class,'pur_req_change_status'])->name('pur_req_change_status');	
	});

	Route::group(array('prefix' => 'vendors'), function ()  {
		Route::get('/',									[VendorController::class,'index'])->name('vendors');
		Route::post('/store',							[VendorController::class,'store'])->name('vendors_store');
		Route::get('/edit/{enc_id}',					[VendorController::class,'edit'])->name('vendors_edit');
		Route::get('/view/{enc_id}',					[VendorController::class,'view'])->name('vendors_view');
		Route::post('/update/{enc_id}',					[VendorController::class,'update'])->name('vendors_update');
		Route::get('/activate/{enc_id}',				[VendorController::class,'activate'])->name('vendors_activate');
		Route::get('/deactivate/{enc_id}',				[VendorController::class,'deactivate'])->name('vendors_deactivate');

		Route::get('/contact/{enc_id}',					[VendorController::class,'contact'])->name('contact_view');
		Route::post('/contact_store',					[VendorController::class,'contact_store'])->name('contact_store');
		Route::get('/contact_edit/{enc_id}',			[VendorController::class,'contact_edit'])->name('contact_edit');
		Route::post('/contact_update/{enc_id}',			[VendorController::class,'contact_update'])->name('contact_update');

		Route::get('/note/{enc_id}',					[VendorController::class,'note'])->name('note_view');
		Route::post('/note_store',						[VendorController::class,'note_store'])->name('note_store');
		Route::get('/note_edit/{enc_id}',				[VendorController::class,'note_edit'])->name('note_edit');
		Route::post('/note_update/{enc_id}',			[VendorController::class,'note_update'])->name('note_update');

		Route::get('/attachment/{enc_id}',				[VendorController::class,'attachment'])->name('attachment_view');
		Route::post('/attachment_store',				[VendorController::class,'attachment_store'])->name('attachment_store');
		Route::get('/attachment_delete/{enc_id}',		[VendorController::class,'attachment_delete'])->name('attachment_delete');

		Route::get('/contract/{enc_id}',				[VendorController::class,'contract'])->name('vend_contract');
		Route::get('/purchase_orders/{enc_id}',			[VendorController::class,'purchase_orders'])->name('purchase_orders');

		Route::get('/vendor_payment/{enc_id}',			[VendorController::class,'vendor_payment'])->name('vendor_payment');	
	});

	Route::group(array('prefix' => 'estimate'), function ()  {
		Route::get('/',							[EstimateController::class,'index'])->name('estimate');
		Route::get('/create',					[EstimateController::class,'create'])->name('estimate_create');
		Route::post('/store',					[EstimateController::class,'store'])->name('estimate_store');
		Route::get('/view/{enc_id}',			[EstimateController::class,'view'])->name('estimate_view');		
		Route::post('/estimate_change_status/{enc_id}',[EstimateController::class,'estimate_change_status'])->name('estimate_change_status');	
		Route::get('/pur_req_detail/{enc_id}',			[EstimateController::class,'pur_req_detail'])->name('estimate_pur_req_detail');
	});

	Route::group(array('prefix' => 'purchase_order'), function ()  {
		Route::get('/',							[PurchaseOrderController::class,'index'])->name('purchase_order');
		Route::get('/create',					[PurchaseOrderController::class,'create'])->name('purchase_order_create');
		Route::post('/store',					[PurchaseOrderController::class,'store'])->name('purchase_order_store');
		Route::get('/view/{enc_id}',			[PurchaseOrderController::class,'view'])->name('purchase_order_view');	
		Route::post('/po_change_status/{enc_id}',			[PurchaseOrderController::class,'po_change_status'])->name('po_change_status');	
		Route::post('/add_po_payment/{enc_id}',	[PurchaseOrderController::class,'add_po_payment'])->name('add_po_payment');	
		Route::get('/dowload_purchase_order/{enc_id}',			[PurchaseOrderController::class,'dowload_purchase_order'])->name('dowload_purchase_order');
		Route::get('/get_estimate_deatils/{enc_id}',			[PurchaseOrderController::class,'get_estimate_deatils'])->name('get_estimate_deatils');	
		
	});

	Route::group(array('prefix' => 'contract'), function ()  {
		Route::get('/',							[ContractController::class,'index'])->name('contract');
		Route::get('/create',					[ContractController::class,'create'])->name('contract_create');
		Route::post('/store',					[ContractController::class,'store'])->name('contract_store');
		Route::get('/edit/{enc_id}',			[ContractController::class,'edit'])->name('contract_edit');		
		Route::post('/update',					[ContractController::class,'update'])->name('contract_update');
		Route::get('/delete/{enc_id}',			[ContractController::class,'attachment_delete'])->name('contract_attach_delete');
	});


	





	
});
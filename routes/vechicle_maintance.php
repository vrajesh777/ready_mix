<?php

use App\Http\Controllers\InvoiceReceivingController;
use App\Http\Controllers\MaintenanceCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vechicle_Maintance\SupplierController;
use App\Http\Controllers\Vechicle_Maintance\ManufacturerController;
use App\Http\Controllers\Vechicle_Maintance\VechicleMakeYearMController;
use App\Http\Controllers\Vechicle_Maintance\PurchasePartsController;
use App\Http\Controllers\Vechicle_Maintance\VechicleRepairController;
use App\Http\Controllers\Vechicle_Maintance\VechiclePartsController;
use App\Http\Controllers\Vechicle_Maintance\PurchasePartsStockController;
use App\Http\Controllers\Vechicle_Maintance\PrintLabelsController;

Route::group(array('middleware'=>['auth','sales']), function ()
{

	Route::group(array('prefix' => 'vc_part'), function ()  {
		Route::get('/',							[VechiclePartsController::class,'index'])->name('vc_part');
		Route::post('/store',					[VechiclePartsController::class,'store'])->name('vc_part_store');
		Route::get('/edit/{enc_id}',			[VechiclePartsController::class,'edit'])->name('vc_part_edit');
		Route::get('/view/{enc_id}',			[VechiclePartsController::class,'view'])->name('vc_part_view');
		Route::post('/update/{enc_id}',			[VechiclePartsController::class,'update'])->name('vc_part_update');
		Route::get('/activate/{enc_id}',		[VechiclePartsController::class,'activate'])->name('vc_part_activate');
		Route::get('/deactivate/{enc_id}',		[VechiclePartsController::class,'deactivate'])->name('vc_part_deactivate');
	});

	Route::group(array('prefix' => 'vc_part_suppy'), function ()  {
		Route::get('/',									[SupplierController::class,'index'])->name('vc_part_suppy');
		Route::post('/store',							[SupplierController::class,'store'])->name('vc_part_suppy_store');
		Route::get('/edit/{enc_id}',					[SupplierController::class,'edit'])->name('vc_part_suppy_edit');
		Route::get('/view/{enc_id}',					[SupplierController::class,'view'])->name('vc_part_suppy_view');
		Route::post('/update/{enc_id}',					[SupplierController::class,'update'])->name('vc_part_suppy_update');
		Route::get('/activate/{enc_id}',				[SupplierController::class,'activate'])->name('vc_part_suppy_activate');
		Route::get('/deactivate/{enc_id}',				[SupplierController::class,'deactivate'])->name('vc_part_suppy_deactivate');
		Route::post('/add_vc_supplier_payment',	[SupplierController::class,'add_vc_supplier_payment'])->name('add_vc_supplier_payment');
	});

	Route::group(array('prefix' => 'manufacturer'), function ()  {
		Route::get('/',									[ManufacturerController::class,'index'])->name('manufacturer');
		Route::post('/store',							[ManufacturerController::class,'store'])->name('manufacturer_store');
		Route::get('/edit/{enc_id}',					[ManufacturerController::class,'edit'])->name('manufacturer_edit');
		Route::get('/view/{enc_id}',					[ManufacturerController::class,'view'])->name('manufacturer_view');
		Route::post('/update/{enc_id}',					[ManufacturerController::class,'update'])->name('manufacturer_update');
		Route::get('/activate/{enc_id}',				[ManufacturerController::class,'activate'])->name('manufacturer_activate');
		Route::get('/deactivate/{enc_id}',				[ManufacturerController::class,'deactivate'])->name('manufacturer_deactivate');
	});

	Route::group(array('prefix' => 'vechicle_mym'), function ()  {
		Route::get('/',									[VechicleMakeYearMController::class,'index'])->name('vechicle_mym');
		Route::post('/store',							[VechicleMakeYearMController::class,'store'])->name('vechicle_mym_store');
		Route::post('/update/{enc_id}',					[VechicleMakeYearMController::class,'update'])->name('vechicle_mym_update');
		Route::get('/make_edit/{enc_id}',				[VechicleMakeYearMController::class,'make_edit'])->name('make_edit');
		Route::get('/model_edit/{enc_id}',				[VechicleMakeYearMController::class,'model_edit'])->name('model_edit');
		Route::get('/year_edit/{enc_id}',				[VechicleMakeYearMController::class,'year_edit'])->name('year_edit');

		Route::get('/make_activate/{enc_id}',				[VechicleMakeYearMController::class,'make_activate'])->name('make_activate');
		Route::get('/make_deactivate/{enc_id}',				[VechicleMakeYearMController::class,'make_deactivate'])->name('make_deactivate');

		Route::get('/model_activate/{enc_id}',				[VechicleMakeYearMController::class,'model_activate'])->name('model_activate');
		Route::get('/model_deactivate/{enc_id}',				[VechicleMakeYearMController::class,'model_deactivate'])->name('model_deactivate');

		Route::get('/year_activate/{enc_id}',				[VechicleMakeYearMController::class,'year_activate'])->name('year_activate');
		Route::get('/year_deactivate/{enc_id}',				[VechicleMakeYearMController::class,'year_deactivate'])->name('year_deactivate');
		
	});

	Route::group(array('prefix' => 'vhc_purchase_parts'), function ()  {
		Route::get('/',									[PurchasePartsController::class,'index'])->name('vhc_purchase_parts');
		Route::get('/create',									[PurchasePartsController::class,'create'])->name('vhc_purchase_parts_create');
		Route::post('/store',							[PurchasePartsController::class,'store'])->name('vhc_purchase_parts_store');
		Route::get('/edit/{enc_id}',					[PurchasePartsController::class,'edit'])->name('vhc_purchase_parts_edit');
		Route::get('/view/{enc_id}',					[PurchasePartsController::class,'view'])->name('vhc_purchase_parts_view');
		Route::post('/update/{enc_id}',					[PurchasePartsController::class,'update'])->name('vhc_purchase_parts_update');
		
		Route::get('/getModelHtml/{enc_id}',			[PurchasePartsController::class,'get_model_html'])->name('get_model_html');
		Route::get('/getYearHtml',						[PurchasePartsController::class,'get_year_html'])->name('get_year_html');
		Route::get('/getPartsHtml',						[PurchasePartsController::class,'get_parts_html'])->name('get_parts_html');
		Route::get('/existing_part/{enc_id}',			[PurchasePartsController::class,'existing_part'])->name('existing_part');

		
	});

	Route::group(array('prefix' => 'vhc_repair'), function ()  {
		Route::get('/',						[VechicleRepairController::class,'index'])->name('vhc_repair');
		Route::get('/create',				[VechicleRepairController::class,'create'])->name('vhc_repair_create');
		Route::post('/store',				[VechicleRepairController::class,'store'])->name('vhc_repair_store');
		Route::get('/edit/{enc_id}',		[VechicleRepairController::class,'edit'])->name('vhc_repair_edit');
		Route::get('/show/{enc_id}',		[VechicleRepairController::class,'show'])->name('vhc_repair_view');
		Route::post('/update/{enc_id}',		[VechicleRepairController::class,'update'])->name('vhc_repair_update');
		Route::get('/change_status/{enc_id}',	[VechicleRepairController::class,'change_status'])->name('vhc_repair_chg_status');
		Route::post('/decrementRepairStock/{enc_id}', [VechicleRepairController::class,'decrementRepairStock'])->name('decrement_repair_stock');
	});

	Route::group(array('prefix' => 'vhc_parts_stocks'), function ()  {
		Route::get('/',						[PurchasePartsStockController::class,'index'])->name('vhc_parts_stocks');
		Route::get('/create',				[PurchasePartsStockController::class,'create'])->name('vhc_parts_stocks_create');
		Route::post('/store',				[PurchasePartsStockController::class,'store'])->name('vhc_parts_stocks_store');
		Route::get('/edit/{enc_id}',		[PurchasePartsStockController::class,'edit'])->name('vhc_parts_stocks_edit');
		Route::get('/view/{enc_id}',		[PurchasePartsStockController::class,'view'])->name('vhc_parts_stocks_view');
		Route::post('/update/{enc_id}',		[PurchasePartsStockController::class,'update'])->name('vhc_parts_stocks_update');
		Route::get('/activate/{enc_id}',	[PurchasePartsStockController::class,'activate'])->name('vhc_parts_stocks_activate');
		Route::get('/deactivate/{enc_id}',	[PurchasePartsStockController::class,'deactivate'])->name('vhc_parts_stocks_deactivate');
	});

	Route::group(array('prefix' => 'print_labels'), function ()  {
		Route::get('/',						[PrintLabelsController::class,'index'])->name('print_labels');
		Route::get('/create',				[PrintLabelsController::class,'create'])->name('print_labels_create');
		Route::get('/print_labels_row',				[PrintLabelsController::class,'print_labels_row'])->name('print_labels_row');
		Route::any('/print_labels/print_labels_preview',				[PrintLabelsController::class,'print_labels_preview'])->name('print_labels_preview');
	});

	Route::group(array('prefix' => 'maintenance_category'), function ()  {
		Route::get('/',			[MaintenanceCategoryController::class,'index'])->name('maintenance_category_list');
		Route::post('/store',	[MaintenanceCategoryController::class,'store'])->name('maintenance_category_store');
		Route::get('/edit/{enc_id}',	[MaintenanceCategoryController::class,'edit'])->name('maintenance_category_edit');
		Route::post('/update/{enc_id}',	[MaintenanceCategoryController::class,'update'])->name('maintenance_category_update');
		});
	
	Route::group(array('prefix' => 'invoice_receiving'), function ()  {
			Route::get('/create',		[InvoiceReceivingController::class,'create'])->name('invoice_receiving_create');
			Route::post('/store',		[InvoiceReceivingController::class,'store'])->name('invoice_receiving_store');
		});
});

?>
<?php
	use App\Http\Controllers\SampleController;

	Route::group(array('middleware'=>['auth','purchase']), function ()
	{
		Route::group(array('prefix' => 'inventory'), function ()  {

		  Route::get('/item',					[SampleController::class,'item_index'])->name('item_index');
		  Route::get('/item_view',			[SampleController::class,'item_view'])->name('item_view');

		  Route::get('/stock_import',			[SampleController::class,'stock_import_list'])->name('stock_import_list');
		  Route::get('/stock_import_create',    [SampleController::class,'stock_import_create'])->name('stock_import_create');
		  Route::get('/stock_import_view',		[SampleController::class,'stock_import_view'])->name('stock_import_view');

		  Route::get('/stock_export',	[SampleController::class,'stock_export'])->name('stock_export');
		  Route::get('/stock_export_create',		[SampleController::class,'stock_export_create'])->name('stock_export_create');
		  Route::get('/stock_export_view',		[SampleController::class,'stock_export_view'])->name('stock_export_view');

		  Route::get('/loss_adjustment',		[SampleController::class,'loss_adjustment'])->name('loss_adjustment');
		  Route::get('/loss_adjustment_create',	[SampleController::class,'loss_adjustment_create'])->name('loss_adjustment_create');
		  
		  Route::get('/warehouse_history',		[SampleController::class,'warehouse_history'])->name('warehouse_history');
		  Route::get('/inventory_report',		[SampleController::class,'inventory_report'])->name('inventory_report');
		  Route::get('/inventory_setting',		[SampleController::class,'inventory_setting'])->name('inventory_setting');

		  Route::get('/vendor_setting',		[SampleController::class,'vendor_setting'])->name('vendor_setting');
		  Route::get('/trak_list',		[SampleController::class,'trak_list'])->name('trak_list');
		  Route::get('/cube',		[SampleController::class,'cube_index'])->name('cube_index');
		  
		  Route::get('/payroll',		[SampleController::class,'payroll'])->name('payroll');
		  Route::get('/payroll1',		[SampleController::class,'payroll1'])->name('payroll1');
		  Route::get('/payroll2',		[SampleController::class,'payroll2'])->name('payroll2');
		  Route::get('/payroll3',		[SampleController::class,'payroll3'])->name('payroll3');
		  Route::get('/payroll4',		[SampleController::class,'payroll4'])->name('payroll4');
		});
	});
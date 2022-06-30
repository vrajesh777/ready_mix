<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Delivery\DriverController;
use App\Http\Controllers\Delivery\VehicleController;
use App\Http\Controllers\Delivery\DeliveryOrdersController;
use App\Http\Controllers\Delivery\RejectedController;

Route::group(array('middleware'=>['auth','delivery']), function ()
{
	Route::group(array('prefix' => 'delivery_orders'), function ()  {
		Route::get('/',						[DeliveryOrdersController::class,'index'])->name('delivery_orders');
		Route::get('/all_delivered',			[DeliveryOrdersController::class,'index'])->name('all_delivered');
		Route::post('/del_note_det/{enc_id}',	[DeliveryOrdersController::class,'del_note_det'])->name('get_del_note_det');
		Route::post('/store_del_note/{enc_id}',	[DeliveryOrdersController::class,'store_del_note'])->name('store_del_note');
		Route::get('/dowload_del_note/{enc_id}',			[DeliveryOrdersController::class,'dowload_del_note'])->name('dowload_del_note');
		Route::post('/edit_del_qty',			[DeliveryOrdersController::class,'edit_del_qty'])->name('edit_del_qty');
		Route::post('/reject_del_qty',			[DeliveryOrdersController::class,'reject_del_qty'])->name('reject_del_qty');
		Route::get('/get_same_product_customer/{enc_id}',			[DeliveryOrdersController::class,'get_same_product_customer'])->name('get_same_product_customer');
		Route::get('/cancel_note/{enc_id}',			[DeliveryOrdersController::class,'cancel_note'])->name('cancel_note');
	});

	Route::group(array('prefix' => 'driver'), function ()  {
		Route::get('/',						[DriverController::class,'index'])->name('driver');
		Route::post('/store',				[DriverController::class,'store'])->name('driver_store');
		Route::get('/edit/{enc_id}',		[DriverController::class,'edit'])->name('driver_edit');
		Route::post('/update/{enc_id}',		[DriverController::class,'update'])->name('driver_update');
		Route::get('/activate/{enc_id}',	[DriverController::class,'activate'])->name('driver_activate');
		Route::get('/deactivate/{enc_id}',	[DriverController::class,'deactivate'])->name('driver_deactivate');
	});

	Route::group(array('prefix' => 'vehicle'), function ()  {
		Route::get('/',						[VehicleController::class,'index'])->name('vehicle');
		Route::post('/store',				[VehicleController::class,'store'])->name('vehicle_store');
		Route::get('/edit/{enc_id}',		[VehicleController::class,'edit'])->name('vehicle_edit');
		Route::post('/update/{enc_id}',		[VehicleController::class,'update'])->name('vehicle_update');
		Route::get('/activate/{enc_id}',	[VehicleController::class,'activate'])->name('vehicle_activate');
		Route::get('/deactivate/{enc_id}',	[VehicleController::class,'deactivate'])->name('vehicle_deactivate');
	});

	Route::group(array('prefix' => 'rejected_del'), function ()  {
		Route::get('/',						[RejectedController::class,'index'])->name('rejected_del');
	});

	

})

?>
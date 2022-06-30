<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Sales\InquiryController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PumpController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CommonDataController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PumpOperatorController;
use App\Http\Controllers\PumpHelpController;
use App\Http\Controllers\CubeController;
use App\Http\Controllers\CylinderController;
use App\Http\Controllers\QCController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CustomerSummaryReportController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MainDepartmentController;

use App\Http\Controllers\Report\DalivOutPutMixerReportController;
use App\Http\Controllers\Report\ResrvProgressiveReportController;
use App\Http\Controllers\Report\ExcessReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear_cache', function() {
	\Artisan::call('cache:clear');
	\Artisan::call('config:cache');
		//  Clears route cache
	\Artisan::call('route:clear');
	//\Cache::flush();
	//\Artisan::call('optimize');
	//exec('composer dump-autoload');
	Cache::flush();
	dd("Cache cleared!");
 });

Route::get('/login', 						[AuthController::class,'login'])->name('login');
Route::post('process_login', 				[AuthController::class,'process_login'])->name('process_login');
Route::get('/logout', 						[AuthController::class,'logout'])->name('logout');
Route::get('/forgot-password', 				[AuthController::class,'forgot_password'])->name('forgot-password');
Route::post('/process_forgot_password', 	[AuthController::class,'process_forgot_password'])->name('process_forgot_password');
Route::get('/reset-password/{token}', 		[AuthController::class,'reset_password'])->name('reset_password');
Route::post('/process_reset_pass', 			[AuthController::class,'process_reset_pass'])->name('process_reset_pass');


Route::get('/inquire', 			[InquiryController::class,'create'])->name('inquire');
Route::post('/submit_inuiry', 	[InquiryController::class,'submit_inuiry'])->name('submit_inuiry');

Route::get('/load_model/{enc_id}',		[CommonDataController::class,'load_model'])->name('load_model');
Route::get('/load_year',				[CommonDataController::class,'load_year'])->name('load_year');
Route::get('/vechicle_details/{enc_id}',         [CommonDataController::class,'vechicle_details'])->name('vechicle_details');

Route::get('/set-locale/{locale}', [CommonDataController::class,'set_locale']);

Route::group(array('middleware'=>['auth']), function ()
{
	
	Route::group(array('prefix' => 'dashboard'), function ()  {
		Route::get('get_pump_data',[DashboardController::class,'get_pumps_data']);
	});

	

	Route::group(array('prefix' => 'roles'), function ()  {
		Route::get('/',					[RolesController::class,'index'])->name('roles');
		Route::get('/create',					[RolesController::class,'create'])->name('roles_create');
		Route::post('/store',			[RolesController::class,'store'])->name('roles_store');
		Route::get('/edit/{enc_id}',	[RolesController::class,'edit'])->name('roles_edit');
		Route::post('/update/{enc_id}',	[RolesController::class,'update'])->name('roles_update');
		Route::get('/activate/{enc_id}',	[RolesController::class,'activate'])->name('roles_activate');
		Route::get('/deactivate/{enc_id}',	[RolesController::class,'deactivate'])->name('roles_deactivate');
	});

	Route::group(array('prefix'=>'main_department'),function() {
		Route::get('/',             	[MainDepartmentController::class,'index'])->name('main_department');
		Route::post('/store',			[MainDepartmentController::class,'store'])->name('main_department_store');
		Route::get('/edit/{enc_id}',	[MainDepartmentController::class,'edit'])->name('main_department_edit');
		Route::post('/update/{enc_id}',	[MainDepartmentController::class,'update'])->name('main_department_update');
		Route::get('/activate/{enc_id}',	[MainDepartmentController::class,'activate'])->name('main_department_activate');
		Route::get('/deactivate/{enc_id}',	[MainDepartmentController::class,'deactivate'])->name('main_department_deactivate');
	});

	Route::group(array('prefix' => 'department'), function ()  {
		Route::get('/',					[DepartmentController::class,'index'])->name('department');
		Route::get('/create',			[DepartmentController::class,'create']);
		Route::post('/store',			[DepartmentController::class,'store'])->name('department_store');
		Route::get('/edit/{enc_id}',	[DepartmentController::class,'edit']);
		Route::post('/update/{enc_id}',	[DepartmentController::class,'update'])->name('department_update');
		Route::get('/activate/{enc_id}',[DepartmentController::class,'activate'])->name('department_activate');
		Route::get('/deactivate/{enc_id}',[DepartmentController::class,'deactivate'])->name('department_deactivate');
	});

	Route::group(array('prefix' => 'taxes'), function ()  {
		Route::get('/',					[TaxesController::class,'index'])->name('taxes');
		Route::post('/store',			[TaxesController::class,'store'])->name('tax_store');
		Route::get('/edit/{enc_id}',	[TaxesController::class,'edit'])->name('tax_edit');
		Route::post('/update/{enc_id}',	[TaxesController::class,'update'])->name('tax_update');
		Route::get('/activate/{enc_id}',	[TaxesController::class,'activate'])->name('tax_activate');
		Route::get('/deactivate/{enc_id}',	[TaxesController::class,'deactivate'])->name('tax_deactivate');
	});

	Route::group(array('prefix'=>'units'),function() {
		Route::get('/',             	[UnitsController::class,'index'])->name('units');
		Route::post('/store',			[UnitsController::class,'store'])->name('unit_store');
		Route::get('/edit/{enc_id}',	[UnitsController::class,'edit'])->name('unit_edit');
		Route::post('/update/{enc_id}',	[UnitsController::class,'update'])->name('unit_update');
		Route::get('/activate/{enc_id}',	[UnitsController::class,'activate'])->name('unit_activate');
		Route::get('/deactivate/{enc_id}',	[UnitsController::class,'deactivate'])->name('unit_deactivate');
	});

	Route::group(array('prefix'=>'payment_methods'),function(){
		Route::get('/',           		[PaymentMethodsController::class,'index'])->name('payment_methods');
		Route::post('/store',			[PaymentMethodsController::class,'store'])->name('payment_method_store');
		Route::get('/edit/{enc_id}',	[PaymentMethodsController::class,'edit'])->name('payment_method_edit');
		Route::post('/update/{enc_id}',	[PaymentMethodsController::class,'update'])->name('payment_method_update');
		Route::get('/activate/{enc_id}',	[PaymentMethodsController::class,'activate'])->name('payment_method_activate');
		Route::get('/deactivate/{enc_id}',	[PaymentMethodsController::class,'deactivate'])->name('payment_method_deactivate');
	});

	Route::group(array('prefix'=>'product'),function() {
		Route::get('/',              	[ProductController::class,'index'])->name('product');
		Route::post('/store',		 	[ProductController::class,'store'])->name('product_store');
		Route::any('/search',		 	[ProductController::class,'search'])->name('product_search');
		Route::get('/edit/{enc_id}', 	[ProductController::class,'edit'])->name('product_edit');
		Route::post('/update/{enc_id}',	[ProductController::class,'update'])->name('product_update');
		Route::get('/activate/{enc_id}',[ProductController::class,'activate'])->name('product_activate');
		Route::get('/deactivate/{enc_id}',	[ProductController::class,'deactivate'])->name('product_deactivate');
	});

	Route::group(array('prefix'=>'site_setting'),function() {
		Route::get('/',              	[SiteSettingController::class,'index'])->name('site_setting');
		Route::post('/update',			[SiteSettingController::class,'update'])->name('site_setting_update');
	});

	Route::group(array('prefix'=>'employee'),function() {
		Route::get('/',           			[UserController::class,'index'])->name('employee');
		Route::get('/add',           		[UserController::class,'create'])->name('add_emp');
		Route::post('/store',				[UserController::class,'store'])->name('user_store');
		Route::get('/edit/{enc_id}',		[UserController::class,'edit'])->name('user_edit');
		Route::post('/update/{enc_id}',		[UserController::class,'update'])->name('user_update');
		Route::get('/activate/{enc_id}',	[UserController::class,'activate'])->name('user_activate');
		Route::get('/deactivate/{enc_id}',	[UserController::class,'deactivate'])->name('user_deactivate');
		Route::post('/store_emp_desgn',		[UserController::class,'store_desgn'])->name('store_emp_desgn');
		Route::post('/store_emp_department',		[UserController::class,'store_department'])->name('store_emp_department');
	});

	Route::group(array('prefix'=>'pumps'),function(){
		Route::get('/',           			[PumpController::class,'index'])->name('pumps');
		Route::post('/store',				[PumpController::class,'store'])->name('pump_store');
		Route::get('/edit/{enc_id}',		[PumpController::class,'edit'])->name('pump_edit');
		Route::post('/update/{enc_id}',		[PumpController::class,'update'])->name('pump_update');
		Route::get('/activate/{enc_id}',	[PumpController::class,'activate'])->name('pump_activate');
		Route::get('/deactivate/{enc_id}',	[PumpController::class,'deactivate'])->name('pump_deactivate');
	});

	Route::group(array('prefix'=>'attendance'),function(){
		Route::any('/user-attend/{mode}',	[AttendanceController::class,'user_attend'])->name('user-attend');
		Route::any('/calendarview',			[AttendanceController::class,'attend_calender_view'])->name('attend_calender_view');
		Route::any('/get_cal_data',			[AttendanceController::class,'get_cal_data'])->name('get_cal_data');
		Route::get('/save_attendance',	[AttendanceController::class,'save_attendance'])->name('save_attendance');
	});

	Route::group(array('prefix' => 'pump_op'), function ()  {
		Route::get('/',						[PumpOperatorController::class,'index'])->name('pump_op');
		Route::post('/store',				[PumpOperatorController::class,'store'])->name('pump_op_store');
		Route::get('/edit/{enc_id}',		[PumpOperatorController::class,'edit'])->name('pump_op_edit');
		Route::post('/update/{enc_id}',		[PumpOperatorController::class,'update'])->name('pump_op_update');
		Route::get('/activate/{enc_id}',	[PumpOperatorController::class,'activate'])->name('pump_op_activate');
		Route::get('/deactivate/{enc_id}',	[PumpOperatorController::class,'deactivate'])->name('pump_op_deactivate');
	});
	Route::group(array('prefix' => 'qc'), function ()  {
		Route::get('/delivery_report/{type?}',	[QCController::class,'index'])->name('delivery_report');
		Route::get('/cube_cylinder',	        [QCController::class,'cube_cylinder'])->name('cube_cylinder_report');
		Route::get('get_delivery_no_suggestion',[QCController::class,'get_delivery_no_suggestion']);
		Route::get('get_delivery_details',[QCController::class,'get_delivery_details']);

	});
	Route::group(array('prefix' => 'customer_summary_report'), function () {

		Route::get('/',[CustomerSummaryReportController::class,'index'])->name('customer_summery_report');
		Route::get('get_customer_suggestion',[CustomerSummaryReportController::class,'get_customer_suggestion']);
	  Route::get('get_customer_details',[CustomerSummaryReportController::class,'get_customer_details']);
		
	});
	Route::group(array('prefix' => 'finance'), function ()  {
		

		Route::post('/load_delivery_note',      [FinanceController::class,'load_delivery_note'])->name('load_delivery_note');
		Route::post('/change_delivery_status',  [FinanceController::class,'change_delivery_status']);
		Route::get('/change_confirm_invoice/{enc_id}',[FinanceController::class,'change_confirm_invoice']);
		Route::get('add_to_erp/{enc_id}',   [FinanceController::class,'add_to_erp'])->name('add_to_erp');;
		Route::get('/delivery_invoice',      [FinanceController::class,'index'])->name('delivery_invoice');
		Route::get('/confirmed_invoice',      [FinanceController::class,'confirmed_invoice'])->name('confirmed_invoice');
		
	});
	Route::group(array('prefix' => 'cube'), function ()  {
		Route::get('get_delivery_no_suggestion',[CubeController::class,'get_delivery_no_suggestion']);
		Route::get('get_delivery_details',[CubeController::class,'get_delivery_details']);
		Route::get('calculate_density',   [CubeController::class,'calculate_density']);
		Route::get('calculate_tested_date',     [CubeController::class,'calculate_tested_date']);
		Route::post('calculate_avg_days', [CubeController::class,'calculate_avg_days']);
		Route::post('store',              [CubeController::class,'store_cube_details']);
		Route::get('delete_cube/{cube_id}/{delivery_no}',[CubeController::class,'delete_cube_details']);
		Route::get('/{report_type}',	        [CubeController::class,'index'])->name('cube');
		
	});
	Route::group(array('prefix' => 'cylinder'), function ()  {
		
		Route::get('get_delivery_no_suggestion',[CylinderController::class,'get_delivery_no_suggestion']);
		Route::get('get_delivery_details',      [CylinderController::class,'get_delivery_details']);
		Route::post('get_valid_date',           [CylinderController::class,'get_valid_date']);
		Route::post('calculate_avg_days',       [CylinderController::class,'calculate_avg_days']);
		Route::post('store',                    [CylinderController::class,'store_cube_details']);
		Route::get('delete_cube/{cube_id}/{delivery_no}',[CylinderController::class,'delete_cube_details']);
		Route::get('calculate_density',   [CylinderController::class,'calculate_density']);
		Route::get('/{report_type?}',	  [CylinderController::class,'index'])->name('cylinder');
		
	});

	Route::group(array('prefix' => 'pump_helper'), function ()  {
		Route::get('/',						[PumpHelpController::class,'index'])->name('pump_helper');
		Route::post('/store',				[PumpHelpController::class,'store'])->name('pump_helper_store');
		Route::get('/edit/{enc_id}',		[PumpHelpController::class,'edit'])->name('pump_helper_edit');
		Route::post('/update/{enc_id}',		[PumpHelpController::class,'update'])->name('pump_helper_update');
		Route::get('/activate/{enc_id}',	[PumpHelpController::class,'activate'])->name('pump_helper_activate');
		Route::get('/deactivate/{enc_id}',	[PumpHelpController::class,'deactivate'])->name('pump_helper_deactivate');
	});

	Route::group(array('prefix' => 'daliv_output_mix_rpt'), function ()  {
		Route::get('/',						[DalivOutPutMixerReportController::class,'index'])->name('daliv_output_mix_rpt');
	});

	Route::group(array('prefix' => 'resrv_progressive_rpt'), function ()  {
		Route::get('/',							[ResrvProgressiveReportController::class,'index'])->name('resrv_progressive_rpt');
	});

	Route::group(array('prefix' => 'excess_rpt'), function ()  {
		Route::get('/',							[ExcessReportController::class,'index'])->name('excess_rpt');
	});
	Route::get('/', [DashboardController::class,'index'])->name('dashboard');
	

});


include('sales.php');
include('purchase.php');
include('delivery.php');
include('human_resource.php');
include('sample.php');
include('vechicle_maintance.php');

Route::get('/shift_order', function () {
    $exitCode = Artisan::call('shift_order:publish');
});
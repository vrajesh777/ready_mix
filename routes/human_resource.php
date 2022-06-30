<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HR\WorkShiftsController;
use App\Http\Controllers\HR\BreakController;
use App\Http\Controllers\HR\LeavesController;
use App\Http\Controllers\HR\LeaveApplicationController;
use App\Http\Controllers\HR\MasterEarningController;
use App\Http\Controllers\HR\MasterReimbursementController;
use App\Http\Controllers\HR\PayScheduleController;
use App\Http\Controllers\HR\EmployeesController;
use App\Http\Controllers\HR\PayRunController;
use App\Http\Controllers\HR\OverheadExpancesController;
use App\Http\Controllers\HR\WeekendController;

Route::group(array('middleware'=>['auth','sales']), function ()
{
	Route::group(array('prefix' => 'attendance'), function ()  {
		Route::group(array('prefix' => 'shifts'), function ()  {
			Route::get('/', 					[WorkShiftsController::class,'index'])->name('shifts');
			Route::post('/store_shift', 		[WorkShiftsController::class,'store_shift'])->name('store_shift');
			Route::get('/edit_shift', 			[WorkShiftsController::class,'edit_shift'])->name('edit_shift');
			Route::post('/update_shift/{enc_id}',[WorkShiftsController::class,'update_shift'])->name('update_shift');
			Route::get('/shift_calender',		[WorkShiftsController::class,'shift_calender'])->name('shift_calender');
			Route::post('/store_emp_shift',		[WorkShiftsController::class,'store_emp_shift'])->name('store_emp_shift');
			Route::post('/update_emp_shift',	[WorkShiftsController::class,'update_emp_shift'])->name('update_emp_shift');

		});

		Route::group(array('prefix' => 'break'), function ()  {
			Route::get('/',						[BreakController::class,'index'])->name('break');
			Route::post('/store_break', 		[BreakController::class,'store_break'])->name('store_break');
			Route::post('/edit_break/{enc_id}', [BreakController::class,'edit_break'])->name('edit_break');
			Route::post('/update_break/{enc_id}',[BreakController::class,'update_break'])->name('update_break');
		});

	});

	Route::group(array('prefix' => 'leavetracker'), function ()  {

		Route::group(array('prefix' => 'leaves'), function ()  {
			Route::get('/',						[LeavesController::class,'index'])->name('leaves');
			Route::post('/store_leave_type', 	[LeavesController::class,'store_leave_type'])->name('store_leave_type');
			Route::post('/edit_leave_type/{enc_id}', [LeavesController::class,'edit_leave_type'])->name('edit_leave_type');
			Route::post('/update_leave_type/{enc_id}',[LeavesController::class,'update_leave_type'])->name('update_leave_type');
			Route::get('/get_emp_leave_type/{enc_id}',[LeavesController::class,'get_emp_leave_type'])->name('get_emp_leave_type');
		});

		Route::group(array('prefix' => 'applications'), function ()  {
			Route::get('/',							[LeaveApplicationController::class,'index'])->name('leave_application');
			Route::post('/store_application', 		[LeaveApplicationController::class,'store'])->name('store_application');
			Route::post('/get_leave_schedule_form', [LeaveApplicationController::class,'get_leave_schedule_form'])->name('get_leave_schedule_form');
			Route::get('/leave_balance', 			[LeaveApplicationController::class,'leave_balance'])->name('leave_balance');
		});

	});

	Route::group(array('prefix' => 'salary_component'), function ()  {

		Route::group(array('prefix' => 'earning'), function ()  {
			Route::get('/',						[MasterEarningController::class,'index'])->name('earning');
			Route::post('/store',				[MasterEarningController::class,'store'])->name('earning_store');
			Route::get('/edit/{enc_id}',		[MasterEarningController::class,'edit'])->name('earning_edit');
			Route::post('/update/{enc_id}',		[MasterEarningController::class,'update'])->name('earning_update');
			Route::get('/activate/{enc_id}',	[MasterEarningController::class,'activate'])->name('earning_activate');
			Route::get('/deactivate/{enc_id}',	[MasterEarningController::class,'deactivate'])->name('earning_deactivate');
		});

		Route::group(array('prefix' => 'reimbursement'), function ()  {
			Route::get('/',						[MasterReimbursementController::class,'index'])->name('reimbursement');
			Route::post('/store',				[MasterReimbursementController::class,'store'])->name('reimbursement_store');
			Route::get('/edit/{enc_id}',		[MasterReimbursementController::class,'edit'])->name('reimbursement_edit');
			Route::post('/update/{enc_id}',		[MasterReimbursementController::class,'update'])->name('reimbursement_update');
			Route::get('/activate/{enc_id}',	[MasterReimbursementController::class,'activate'])->name('reimbursement_activate');
			Route::get('/deactivate/{enc_id}',	[MasterReimbursementController::class,'deactivate'])->name('reimbursement_deactivate');
		});

	});

	Route::group(array('prefix' => 'pay_schedule'), function ()  {
		Route::get('/',						[PayScheduleController::class,'index'])->name('pay_schedule');
		Route::post('/store',				[PayScheduleController::class,'store'])->name('pay_schedule_store');
		Route::get('/edit',					[PayScheduleController::class,'edit'])->name('pay_schedule_edit');
		Route::post('/update',		        [PayScheduleController::class,'update'])->name('pay_schedule_update');
	});

	Route::group(array('prefix' => 'pay_employees'), function ()  {
		Route::get('/',						[EmployeesController::class,'index'])->name('pay_employees');
		Route::get('/salary_details/{enc_id}',		[EmployeesController::class,'salary_details'])->name('salary_details');
		Route::get('/edit_salary_details/{enc_id}',		[EmployeesController::class,'edit_salary_details'])->name('edit_salary_details');
		Route::post('/update_salary_details',  [EmployeesController::class,'update_salary_details'])->name('update_salary_details');
	});

	Route::group(array('prefix' => 'pay_run'), function ()  {
		Route::get('/',								[PayRunController::class,'index'])->name('pay_run');
		Route::get('/pay_preview/{enc_id}',			[PayRunController::class,'pay_preview'])->name('pay_preview');
		Route::post('/record_payment',  				[PayRunController::class,'record_payment'])->name('record_payment');
		Route::get('/pay_summary/{enc_id}',			[PayRunController::class,'pay_summary'])->name('pay_summary');
		Route::get('/view_payslip/{enc_id}',			[PayRunController::class,'view_payslip'])->name('view_payslip');
		Route::get('/record_payment_preview',			[PayRunController::class,'record_payment_preview'])->name('record_payment_preview');
		Route::get('/push_to_erp/{enc_id}',[PayRunController::class,'pay_run_push_to_erp'])->name('pay_run_push_to_erp');
		/*Route::get('/salary_details/{enc_id}',			[PayRunController::class,'salary_details'])->name('salary_details');
		Route::get('/edit_salary_details/{enc_id}',		[PayRunController::class,'edit_salary_details'])->name('edit_salary_details');
		Route::post('/update_salary_details',  			[PayRunController::class,'update_salary_details'])->name('update_salary_details');*/
	});


	

	Route::group(array('prefix'=>'overhead_expances'),function() {
		Route::get('/',             	[OverheadExpancesController::class,'index'])->name('overhead_expances');
		Route::post('/store',			[OverheadExpancesController::class,'store'])->name('overhead_expances_store');
		Route::get('/edit/{enc_id}',	[OverheadExpancesController::class,'edit'])->name('overhead_expances_edit');
		Route::post('/update/{enc_id}',	[OverheadExpancesController::class,'update'])->name('overhead_expances_update');
		Route::get('/activate/{enc_id}',	[OverheadExpancesController::class,'activate'])->name('overhead_expances_activate');
		Route::get('/deactivate/{enc_id}',	[OverheadExpancesController::class,'deactivate'])->name('overhead_expances_deactivate');
	});
	
	Route::group(array('prefix'=>'weekends'),function() {
		Route::get('/',             	[WeekendController::class,'index'])->name('weekends');
		Route::post('/store',			[WeekendController::class,'store'])->name('weekends_store');
		Route::get('/edit/{enc_id}',	[WeekendController::class,'edit'])->name('weekends_edit');
		Route::post('/update/{enc_id}',	[WeekendController::class,'update'])->name('weekends_update');
		Route::get('/activate/{enc_id}',	[WeekendController::class,'activate'])->name('weekends_activate');
		Route::get('/deactivate/{enc_id}',	[WeekendController::class,'deactivate'])->name('weekends_deactivate');
	});
	

	
});

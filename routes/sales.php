<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Sales\InquiryController;
use App\Http\Controllers\Sales\InvoicesController;
use App\Http\Controllers\Sales\PaymentsController;
use App\Http\Controllers\Sales\LeadsController;
use App\Http\Controllers\Sales\OrdersController;
use App\Http\Controllers\Sales\EstimateController;
use App\Http\Controllers\Sales\ProposalsController;
use App\Http\Controllers\Sales\ContractController;
use App\Http\Controllers\Sales\TransactionsController;


Route::group(array('middleware'=>['auth','sales']), function ()
{
	Route::group(array('prefix' => 'inquiries'), function ()  {
		Route::get('/', 					[InquiryController::class,'index'])->name('inquiries');
	});

	Route::group(array('prefix' => 'leads'), function ()  {
		Route::get('/', 					[LeadsController::class,'index'])->name('leads');
		Route::post('/create_lead', 		[LeadsController::class,'create_lead'])->name('create_lead');
		Route::post('/update_lead/{enc_id}',[LeadsController::class,'update_lead'])->name('update_lead');
		Route::get('/get_lead_details', 	[LeadsController::class,'get_lead_details'])->name('get_lead_details');
		Route::get('/get_lead_details_html',[LeadsController::class,'get_lead_details_html'])->name('get_lead_details_html');
	});

	Route::group(array('prefix' => 'estimates'), function ()  {
		Route::get('/', 						[EstimateController::class,'index'])->name('estimates');
		Route::get('/create_estimate', 			[EstimateController::class,'create_estimate'])->name('create_estimate');
		Route::post('/update_estimate/{enc_id}',[EstimateController::class,'update_estimate'])->name('update_estimate');
		Route::get('/edit_estimate/{enc_id}',	[EstimateController::class,'edit_estimate'])->name('edit_estimate');
		Route::get('/view_estimate/{enc_id}',	[EstimateController::class,'view_estimate'])->name('view_estimate');
		Route::get('/get_estimate_details', 	[EstimateController::class,'get_estimate_details'])->name('get_estimate_details');
		Route::post('/calculate_est_amnt', 		[EstimateController::class,'calculate_est_amnt'])->name('calculate_est_amnt');
		Route::post('/store_estimate', 			[EstimateController::class,'store_estimate'])->name('store_estimate');
		Route::get('/get_related_person', 		[EstimateController::class,'get_related_person'])->name('get_related_person');
		Route::post('/prop_related_user_details',	[EstimateController::class,'prop_related_user_details'])->name('prop_related_user_details');
		Route::get('/dowload_estimate/{enc_id}',[EstimateController::class,'dowload'])->name('dowload_estimate');
		Route::get('/change_status/{enc_id}/{status}',	[EstimateController::class,'change_status'])->name('change_status');
		Route::get('/convert_to_estimate/{enc_id}',	[EstimateController::class,'convert_to_estimate'])->name('convert_to_estimate');
		Route::get('/convert_to_invoice/{enc_id}',	[EstimateController::class,'convert_to_invoice'])->name('convert_to_invoice');
		Route::get('/send_est_email/{enc_id}',	[EstimateController::class,'send_est_email'])->name('send_est_email');
		Route::get('/confirm_est_product/',		[EstimateController::class,'confirm_est_product'])->name('confirm_est_product');
	});

	Route::group(array('prefix' => 'customer'), function ()  {
		Route::get('/', 						[CustomersController::class,'index'])->name('customer');
		Route::post('/store_customer', 			[CustomersController::class,'store_customer'])->name('store_customer');
		Route::post('/update_customer/{enc_id}',[CustomersController::class,'update_customer'])->name('update_customer');
		Route::get('/view/{enc_id}',			[CustomersController::class,'view'])->name('view_customer');
		Route::get('/edit/{enc_id}',			[CustomersController::class,'edit'])->name('cust_edit');
		Route::post('/cust_status_update/{enc_id}',[CustomersController::class,'enableDisableCust'])->name('cust_status_update');
		Route::post('/update/{enc_id}',			[CustomersController::class,'update'])->name('update_customer');
		Route::get('/get_proposal_details', 	[CustomersController::class,'get_proposal_details'])->name('get_proposal_details');
		Route::post('/update_address/{enc_id}',	[CustomersController::class,'update_address'])->name('update_address');

		Route::post('/cust_contact_store',		[CustomersController::class,'cust_contact_store'])->name('cust_contact_store');
		Route::get('/cust_contact_edit/{enc_id}',[CustomersController::class,'cust_contact_edit'])->name('cust_contact_edit');
		Route::post('/cust_contact_update/{enc_id}',[CustomersController::class,'cust_contact_update'])->name('cust_contact_update');
		/*Route::get('/activate/{enc_id}',	[UserController::class,'activate'])->name('user_activate');
		Route::get('/deactivate/{enc_id}',	[UserController::class,'deactivate'])->name('user_deactivate');*/

	});

	Route::group(array('prefix' => 'proposals'), function ()  {
		Route::get('/', 						[ProposalsController::class,'index'])->name('proposals');
		Route::get('/create_proposal', 			[ProposalsController::class,'create_proposal'])->name('create_proposal');
		Route::post('/store_proposal', 			[ProposalsController::class,'store_proposal'])->name('store_proposal');
		Route::post('/update_proposal/{enc_id}',[ProposalsController::class,'update_proposal'])->name('update_proposal');
		Route::get('/edit_proposal/{enc_id}',	[ProposalsController::class,'edit_proposal'])->name('edit_proposal');
		Route::get('/view_proposal/{enc_id}',	[ProposalsController::class,'view_proposal'])->name('view_proposal');
		Route::get('/confirm_prop_product/',	[ProposalsController::class,'confirm_prop_product'])->name('confirm_prop_product');
		Route::post('/calculate_prop_amnt', 	[ProposalsController::class,'calculate_prop_amnt'])->name('calculate_prop_amnt');
		Route::get('/dowload_proposal/{enc_id}',[ProposalsController::class,'dowload'])->name('dowload_proposal');
		Route::get('/convert_est_to_inv/{enc_id}',	[ProposalsController::class,'convert_to_invoice'])->name('convert_est_to_inv');
		Route::get('/change_status/{enc_id}/{status}',	[ProposalsController::class,'change_status'])->name('change_inv_status');
		Route::get('/send_est_to_cust/{enc_id}/',[ProposalsController::class,'send_est_to_cust'])->name('send_est_to_cust');
		Route::get('/get_prop_to_est_clone_data/{enc_id}/',[ProposalsController::class,'get_prop_to_est_clone_data'])->name('get_prop_to_est_clone_data');
		Route::get('/send_prop_email/{enc_id}',	[ProposalsController::class,'send_prop_email'])->name('send_prop_email');
		Route::get('/get_user_meta/{enc_id}',	[ProposalsController::class,'get_user_meta'])->name('get_user_meta');
	});

	Route::group(array('prefix' => 'invoices'), function ()  {
		Route::get('/', 						[InvoicesController::class,'index'])->name('invoices');
		Route::get('/view_invoice/{enc_id}',	[InvoicesController::class,'view_invoice'])->name('view_invoice');
		Route::get('/create_invoice', 			[InvoicesController::class,'create_invoice'])->name('create_invoice');
		Route::post('/calculate_inv_amnt/',		[InvoicesController::class,'calculate_inv_amnt'])->name('calculate_inv_amnt');
		Route::post('/store_invoice', 			[InvoicesController::class,'store_invoice'])->name('store_invoice');
		Route::get('/edit_invoice/{enc_id}',	[InvoicesController::class,'edit_invoice'])->name('edit_invoice');
		Route::post('/update_invoice/{enc_id}',	[InvoicesController::class,'update_invoice'])->name('update_invoice');
		Route::get('/dowload_invoice/{enc_id}',	[InvoicesController::class,'dowload'])->name('dowload_invoice');
		Route::post('/add_inv_payment/{enc_id}',[InvoicesController::class,'add_inv_payment'])->name('add_inv_payment');
	});

	Route::group(array('prefix' => 'booking'), function ()  {
		Route::get('/', 						[OrdersController::class,'index'])->name('booking');
		Route::get('/view_order/{enc_id}',		[OrdersController::class,'view_order'])->name('view_order');
		Route::get('/create_order', 			[OrdersController::class,'create_order'])->name('create_order');
		Route::get('/confirm_ord_product/',		[OrdersController::class,'confirm_product'])->name('confirm_ord_product');
		Route::post('/calculate_ord_amnt/',		[OrdersController::class,'calculate_ord_amnt'])->name('calculate_ord_amnt');
		Route::post('/store_order', 			[OrdersController::class,'store_order'])->name('store_order');
		Route::get('/edit_order/{enc_id}',		[OrdersController::class,'edit_order'])->name('edit_order');
		Route::get('/cancel_order/{enc_id}',	[OrdersController::class,'cancel_order'])->name('cancel_order');
		Route::post('/update_order/{enc_id}',	[OrdersController::class,'update_order'])->name('update_order');
		Route::post('/add_inv_payment/{enc_id}',[OrdersController::class,'add_inv_payment'])->name('add_inv_payment');
		Route::get('/get_user_cotracts/{enc_id}/',[OrdersController::class,'get_user_cotracts'])->name('get_user_cotracts');
		Route::get('/get_contract_items/{enc_id}/',[OrdersController::class,'get_contract_items'])->name('get_contract_items');
		Route::get('/get_contract_item/{enc_id}',[OrdersController::class,'get_contract_item'])->name('get_contract_item');
		Route::post('/get_pump_bookings',		[OrdersController::class,'get_pump_bookings'])->name('get_pump_bookings');
		Route::get('/load_sites/{enc_id}',[OrdersController::class,'load_sites'])->name('load_sites');
		
	});

	Route::group(array('prefix' => 'differential'), function ()  {
		Route::get('/', 	  [OrdersController::class,'differential'])->name('differential');
	});

	Route::group(array('prefix' => 'cust_contract'), function ()  {
		Route::get('/', 						[ContractController::class,'index'])->name('cust_contract');
		Route::get('/view/{enc_id}',			[ContractController::class,'view_contract'])->name('cust_view_contract');
		Route::get('/create', 					[ContractController::class,'create_contract'])->name('cust_create_contract');
		Route::get('/confirm_contr_product/',	[ContractController::class,'confirm_product'])->name('confirm_contr_product');
		Route::post('/calculate_contr_amnt/',	[ContractController::class,'calculate_contr_amnt'])->name('calculate_contr_amnt');
		Route::post('/store', 					[ContractController::class,'store_contract'])->name('cust_store_contract');
		Route::get('/edit/{enc_id}',			[ContractController::class,'edit_contract'])->name('cust_edit_contract');
		Route::post('/update/{enc_id}',			[ContractController::class,'update_contract'])->name('cust_update_contract');
		Route::post('/contract_bal/{enc_id}',	[ContractController::class,'contract_bal'])->name('get_contract_balalnce');
		Route::post('/customer_bal/{enc_id}',	[ContractController::class,'customer_bal'])->name('get_customer_bal');
		Route::post('/add_contract_payment',	[ContractController::class,'add_contract_payment'])->name('add_contract_payment');
	});

	Route::group(array('prefix' => 'payments'), function ()  {
		Route::get('/', 						[PaymentsController::class,'index'])->name('payments');
		Route::get('/view_payment/{enc_id}',	[PaymentsController::class,'view_payment'])->name('view_payment');
		Route::post('/update_payment/{enc_id}',	[PaymentsController::class,'update_payment'])->name('update_payment');
		Route::get('/delete/{enc_id}',			[PaymentsController::class,'delete'])->name('delete_payment');
		Route::get('/dowload_receipt/{enc_id}',	[PaymentsController::class,'dowload'])->name('dowload_pay_receipt');
	});

	Route::group(array('prefix' => 'statements'), function ()  {
		Route::get('/booking_statement', 		[TransactionsController::class,'index'])->name('booking_statement');
		Route::get('/non_booking_statement', 	[TransactionsController::class,'nonBooking'])->name('non_booking_statement');
		Route::get('/account_statement', 		[TransactionsController::class,'index'])->name('account_statement');
		Route::get('/satement_details/{enc_id}',[TransactionsController::class,'satement_details'])->name('satement_details');
		/*Route::post('/update_payment/{enc_id}',	[TransactionsController::class,'update_payment'])->name('update_payment');
		Route::get('/delete/{enc_id}',			[TransactionsController::class,'delete'])->name('delete_payment');
		Route::get('/dowload_receipt/{enc_id}',	[TransactionsController::class,'dowload'])->name('dowload_pay_receipt');*/
		Route::get('/monthly_booking_statement', 		[TransactionsController::class,'monthly_booking_statement'])->name('monthly_booking_statement');
		
	});

});

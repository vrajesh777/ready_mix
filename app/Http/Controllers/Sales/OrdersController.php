<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\TranscationService;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\ProductModel;
use App\Models\SalesEstimateModel;
use App\Models\TaxesModel;
use App\Models\PaymentMethodsModel;
use App\Models\SalesEstimateProdQuantModel;
use App\Models\InvoicePayMethodsModel;
use App\Models\SalesProposalModel;
use App\Models\SalesProposalDetailsModel;
use App\Models\SalesInvoiceModel;
use App\Models\SalesInvoiceDetailsModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailsModel;
use App\Models\SalesContractModel;
use App\Models\SalesContractDetailsModel;
use App\Models\PumpModel;
use App\Models\TransactionsModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->UserModel                   = new User;
        $this->LeadsModel                  = new LeadsModel;
        $this->ProductModel                = new ProductModel;
        $this->SalesEstimateModel          = new SalesEstimateModel;
        $this->PaymentMethodsModel         = new PaymentMethodsModel;
        $this->SalesEstimateProdQuantModel = new SalesEstimateProdQuantModel;
        $this->InvoicePayMethodsModel      = new InvoicePayMethodsModel;
        $this->SalesProposalModel          = new SalesProposalModel;
        $this->SalesProposalDetailsModel   = new SalesProposalDetailsModel;
        $this->SalesInvoiceModel           = new SalesInvoiceModel;
        $this->SalesInvoiceDetailsModel    = new SalesInvoiceDetailsModel;
        $this->TaxesModel                  = new TaxesModel;
        $this->OrdersModel                 = new OrdersModel;
        $this->OrderDetailsModel           = new OrderDetailsModel;
        $this->SalesContractModel          = new SalesContractModel;
        $this->SalesContractDetailsModel   = new SalesContractDetailsModel;
        $this->PumpModel                   = new PumpModel;
        $this->TransactionsModel           = new TransactionsModel;
        $this->auth                        = auth();

        $this->arr_view_data                = [];
        $this->module_title                 = "Admin";
        $this->module_view_folder           = "sales.orders";
        $this->TranscationService           = new TranscationService();
    }

    public function index(Request $request) {

        //$this->cron();
        $arr_orders = $arr_sorted_orders = $arr_sales_user = $arr_trans = $arr_pump = $arr_user_trans = $arr_contracts = [];

        $contract_id = $sales_user = $custm_id = '';

        /* Order Mode Query */

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','ord_details.product_details','invoice','cust_details','pump_details','transactions','contract'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date)
                                    ->where('order_status','!=','cancelled')
                                    ->orderBy('orders.delivery_date','asc')
                                    ->orderBy('orders.delivery_time','asc');

        if($this->auth->user()->role_id != config('app.roles_id.admin')) {
            $obj_orders = $obj_orders->where('sales_agent', $this->auth->user()->id);
        }
        if($request->has('status') && $request->input('status') != '') {
            $obj_orders = $obj_orders->where('order_status', $request->input('status'));
        }
        if($request->has('custm_id') && $request->input('custm_id') != '') {
            $custm_id = $request->input('custm_id');
            $obj_orders = $obj_orders->where('cust_id', $custm_id);
        }

        if($request->has('contract') && $request->input('contract') != '') {
            $contract_id = $request->input('contract');
            $obj_orders = $obj_orders->where('contract_id', $contract_id);
        }
        if($request->has('sales_user') && $request->input('sales_user') != '') {
            $sales_user = $request->input('sales_user');
            $obj_orders = $obj_orders->where('sales_agent', $sales_user);
        }
        $obj_orders = $obj_orders->orderBy('pump', 'ASC')->paginate(10);
        if($obj_orders->count() > 0) {
            $arr_orders = $obj_orders->toArray();
        }

        if($obj_orders->count() > 0) {
            foreach($arr_orders['data'] as $row) {
                $arr_sorted_orders[$row['pump']][] = $row;
            }
        }


        /* Order Mode Query */

        $obj_trans = $this->TransactionsModel->whereHas('contract', function(){})
                                            ->with(['contract'])
                                            ->whereNotNull('contract_id')->get();

        if($obj_trans->count() > 0) { $arr_trans = $obj_trans->toArray(); }

        if(!empty($arr_trans)) {
            foreach($arr_trans as $trans) {
                $contract = $trans['contract']??[];
                if(!empty($contract)) {
                    $cust_id = $contract['cust_id']??0;
                    unset($trans['contract']);
                    $arr_user_trans[$cust_id][] = $trans;
                }
            }
        }

        // dd($arr_user_trans);

        $obj_pump = $this->PumpModel->where('is_active','1')->select('id','name','operator_id','helper_id','driver_id')->get();
        if($obj_pump) {
            $arr_pump = $obj_pump->toArray();
        }

        $obj_contracts = $this->SalesContractModel->whereHas('cust_details', function(){})
                                                ->with(['cust_details'])
                                                ->get();

        if($obj_contracts->count() > 0) {
            $arr_contracts = $obj_contracts->toArray();
        }

        $obj_customer = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->get();

        if($obj_customer->count() > 0) {
            $arr_customer = $obj_customer->toArray();
        }


        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.sales'))
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_sales_user = $obj_users->toArray();
        }

        $arr_helper = $arr_operator = $arr_driver = [];
        $obj_helper = $this->UserModel->where('role_id', config('app.roles_id.pump_helper'))
                                    ->where('last_name', 'not like', '%Dummy%')
                                    ->select('id','first_name','last_name')
                                    ->get();

        if($obj_helper->count() > 0) {
            $arr_helper = $obj_helper->toArray();
        }

        $obj_opertaor = $this->UserModel->where('role_id', config('app.roles_id.pump_operator'))
                                        ->where('last_name', 'not like', '%Dummy%')
                                    ->select('id','first_name','last_name')
                                    ->get();

        if($obj_opertaor->count() > 0) {
            $arr_operator = $obj_opertaor->toArray();
        }

        $obj_driver = $this->UserModel->where('role_id', config('app.roles_id.driver'))
                                      ->whereNotIn('id',NOT_A_MIXER_DRIVER)
                                      ->where('last_name', 'not like', '%Dummy%')
                                    ->select('id','first_name','last_name')
                                    ->get();

        if($obj_driver->count() > 0) {
            $arr_driver = $obj_driver->toArray();
        }

        $this->arr_view_data['arr_orders']        = $arr_orders['data'] ?? [];
        $this->arr_view_data['arr_pump']          = $arr_pump;
        $this->arr_view_data['arr_helper']        = $arr_helper;
        $this->arr_view_data['arr_driver']        = $arr_driver;
        $this->arr_view_data['arr_operator']      = $arr_operator;
        $this->arr_view_data['arr_trans']         = $arr_trans;
        $this->arr_view_data['arr_contracts']     = $arr_contracts;
        $this->arr_view_data['arr_user_trans']    = $arr_user_trans;
        $this->arr_view_data['arr_sales_user']    = $arr_sales_user;
        $this->arr_view_data['start_date']        = $start_date;
        $this->arr_view_data['end_date']          = $end_date;
        $this->arr_view_data['contract_id']       = $contract_id;
        $this->arr_view_data['custm_id']          = $custm_id;
        $this->arr_view_data['arr_sorted_orders'] = $arr_sorted_orders;
        $this->arr_view_data['obj_orders']        = $obj_orders;
        $this->arr_view_data['sales_user']        = $sales_user;
        $this->arr_view_data['arr_customer']      = $arr_customer ?? [];
        // dd($arr_orders['data']);
        return view($this->module_view_folder.'.index_new',$this->arr_view_data);
    }

    public function create_order(Request $request) {

        $arr_sales_user = $arr_taxes = $arr_products = $arr_custs = $arr_pay_methods = $arr_estim = $arr_est_clone = [];

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.sales'))
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_sales_user = $obj_users->toArray();
        }

        $obj_customers = $this->UserModel->whereHas('role', function(){})
                                        ->with(['role'])
                                        ->where('role_id', config('app.roles_id.customer'))
                                        ->where('is_active', '1')
                                        ->get();

        if($obj_customers->count() > 0) {
            $arr_custs = $obj_customers->toArray();
        }

        $obj_product = $this->ProductModel->get();

        if($obj_product) {
            $arr_products = $obj_product->toArray();
        }

        $obj_taxes = $this->TaxesModel->where('is_active', '1')->get();

        if($obj_taxes->count() > 0) {
            $arr_taxes = $obj_taxes->toArray();
        }

        $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

        if($obj_pay_methods->count() > 0) {
            $arr_pay_methods = $obj_pay_methods->toArray();
        }

        $obj_estim = $this->SalesProposalModel->get();
        if($obj_estim->count()>0)
        {
            $arr_estim = $obj_estim->toArray();
        }

        if($request->has('est') && $request->input('est') != '') {
            $estId = base64_decode($request->input('est'));

            $obj_est = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                        ->whereHas('cust_details', function(){})
                                        ->with(['prop_details',
                                                'cust_details',
                                                'prop_details.product_details',
                                                'prop_details.product_details.tax_detail'])
                                        ->where('id', $estId)->first();

            if($obj_est) {
                $arr_est_clone = $obj_est->toArray();
            }
        }

        $arr_pump = [];
        $obj_pump = $this->PumpModel->where('is_active','1')->select('id','name','operator_id','helper_id','driver_id')->get();
        if($obj_pump)
        {
            $arr_pump = $obj_pump->toArray();
        }

        $arr_helper = $arr_operator = $arr_driver = [];
        $obj_helper = $this->UserModel->where('role_id', config('app.roles_id.pump_helper'))
                                    ->where('last_name', 'not like', '%Dummy%')
                                    ->select('id','first_name','last_name')
                                    ->get();

        if($obj_helper->count() > 0) {
            $arr_helper = $obj_helper->toArray();
        }

        $obj_driver = $this->UserModel->where('role_id', config('app.roles_id.driver'))
                                    ->whereNotIn('id',NOT_A_MIXER_DRIVER)
                                    ->where('last_name', 'not like', '%Dummy%')
                                    ->select('id','first_name','last_name')
                                    ->get();

        if($obj_driver->count() > 0) {
            $arr_driver = $obj_driver->toArray();
        }

        $obj_opertaor = $this->UserModel->where('role_id', config('app.roles_id.pump_operator'))
                                    ->where('last_name', 'not like', '%Dummy%')
                                    ->select('id','first_name','last_name')
                                    ->get();

        if($obj_opertaor->count() > 0) {
            $arr_operator = $obj_opertaor->toArray();
        }

        $this->arr_view_data['arr_est_clone']   = $arr_est_clone;
        $this->arr_view_data['arr_sales_user']  = $arr_sales_user;
        $this->arr_view_data['arr_custs']       = $arr_custs;
        $this->arr_view_data['arr_taxes']       = $arr_taxes;
        $this->arr_view_data['arr_products']    = $arr_products;
        $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;
        $this->arr_view_data['arr_estim']       = $arr_estim;
        $this->arr_view_data['arr_pump']        = $arr_pump;
        $this->arr_view_data['arr_helper']      = $arr_helper;
        $this->arr_view_data['arr_operator']    = $arr_operator;
        $this->arr_view_data['arr_driver']      = $arr_driver;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function calculate_ord_amnt(Request $request) {

        $arr_req = $request->all();

        $sub_tot = $grand_tot = $tax_amnt = 0;

        $arr_resp = $arr_taxes = [];

        $obj_taxes = $this->TaxesModel->whereIn('id', $arr_req['unit_tax'])->get();

        if($obj_taxes->count() > 0) {
            $arr_taxes = $obj_taxes->toArray();
        }

        foreach($arr_req['prod_id'] as $key => $req) {

            $opc1_rate = $arr_req['opc1_rate'][$key] ?? 0;
            $src5_rate = $arr_req['src5_rate'][$key] ?? 0;
            $unit_rate = $opc1_rate+$src5_rate;

            $unit_quant = $arr_req['unit_quantity'][$key] ?? 0;
            $unit_tax = $arr_req['unit_tax'][$key] ?? '';
            $tax_rate = 0;

            if($unit_tax != '' && !empty($arr_taxes)) {
                $index = array_search($unit_tax, array_column($arr_taxes, 'id'));
                $tax_data = $arr_taxes[$index]??[];
                $tax_rate = $tax_data['tax_rate']??0;
            }

            $unit_sub_tot = ($unit_rate * $unit_quant);
            $tax_amnt += ( $tax_rate / 100 ) * $unit_sub_tot;
            $sub_tot += $unit_sub_tot;
        }

        $disc_num  = $arr_req['discount_num'] ?? 0;
        $disc_type = $arr_req['disc_type'] ?? 'percentage';

        $arr_resp['status'] = 'success';

        $arr_resp['sub_tot'] = $sub_tot;

        if(strtolower($disc_type) == 'percentage') {
            $disc_amnt = round($disc_num * ($sub_tot / 100),2);
        }elseif(strtolower($disc_type) == 'fixed'){
            $disc_amnt = $disc_num;
        }

        if($request->ajax()) {
            $arr_resp['sub_tot'] = ($sub_tot);
            $arr_resp['disc_amnt'] = ($disc_amnt);
            $arr_resp['grand_tot'] = ($sub_tot - $disc_amnt + $tax_amnt);
        }else{
            $arr_resp['sub_tot'] = $sub_tot;
            $arr_resp['disc_amnt'] = $disc_amnt;
            $arr_resp['grand_tot'] = ($sub_tot - $disc_amnt + $tax_amnt);
        }

        return response()->json($arr_resp, 200);
    }

    public function store_order(Request $request) {
        $arr_rules                  = $arr_resp = array();

        $arr_rules['cust_id']        = "required";
        $arr_rules['contract_id']    = "required";
        // $arr_rules['pump']           = "required";
        // $arr_rules['pump_op_id']     = "required";
        // $arr_rules['pump_helper_id'] = "required";
        // $arr_rules['driver_id']      = "required";
        $arr_rules['delivery_date']  = "required";
        $arr_rules['delivery_time']  = "required";
        $arr_rules['prod_id']        = 'required|array|min:1';
        $arr_rules['prod_id.*']      = 'required|integer';

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            if($validator->errors()->has('prod_id')) {
                Session::flash('error',trans('admin.select_at_least_one_product'));
            }
            // dd($validator->errors()->has('prod_id'), $validator->messages()->toArray());
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        else
        {
            $calc_resp = $this->calculate_ord_amnt($request);

            $calc = json_decode($calc_resp->content(), true);

            $arr_ins            = [];
            $cust_id            = $request->input('cust_id');
            $arr_ins['cust_id'] = $cust_id;

            //$user_payment = calculate_customer_payment($cust_id);

            /*$datetime = new \DateTime($request->input('delivery_date'));
            $date = $datetime->format('Y-m-d');
            $time = $datetime->format('H:i');*/
            $arr_ins['delivery_date']    = date('Y-m-d',strtotime($request->input('delivery_date')));
            $arr_ins['extended_date']    = date('Y-m-d',strtotime($request->input('delivery_date')));

            $arr_ins['delivery_time']    = date('H:i',strtotime($request->input('delivery_time'))) ?? '';
        
            $arr_ins['contract_id']      = $request->input('contract_id');
            $arr_ins['pump']             = $request->input('pump');
            $arr_ins['sales_agent']      = $request->input('sales_agent');
            $arr_ins['status']           = $request->input('status');
            $arr_ins['admin_note']       = $request->input('admin_note');
            $arr_ins['client_note']      = $request->input('client_note');
            $arr_ins['terms_conditions'] = $request->input('terms_n_cond');
            $arr_ins['order_status']     = $request->input('status');
            $arr_ins['sub_total']        = $calc['sub_tot'] ?? 0;
            $arr_ins['disc_amnt']        = $calc['disc_amnt'] ?? 0;
            $arr_ins['grand_tot']        = $calc['grand_tot'] ?? 0;
            $arr_ins['structure']        = $request->input('structure');
            $arr_ins['remark']           = $request->input('remark');
            $arr_ins['pump_op_id']       = $request->input('pump_op_id');
            $arr_ins['pump_helper_id']   = $request->input('pump_helper_id');
            $arr_ins['driver_id']        = $request->input('driver_id');
            
            /*----------Account statment calculation-------*/
            $adv_payment = 0;
            $trans_ids = [];
            $user_payment = calculate_customer_payment($cust_id);
            $arr_adv_payment = get_cust_latest_adavnce_payment($cust_id);
            if(isset($arr_adv_payment) && sizeof($arr_adv_payment)>0)
            {
                $adv_payment = array_sum(array_column($arr_adv_payment, 'amount'));
                $trans_ids   = array_column($arr_adv_payment, 'id');
            }

            $arr_ins['advance_payment'] = $adv_payment;
            $arr_ins['balance']         = ($user_payment['credit_amt'] - $user_payment['debit_amt']) - $calc['grand_tot'];
            $arr_ins['adv_plus_bal'] = $user_payment['credit_amt'] - $user_payment['debit_amt'] ?? 0;

            /*----------------------------------------------------*/



            if($request->has('estimation_id'))
            {
                $arr_ins['estimation_id'] = $request->input('estimation_id');
            }

            if($obj_order = $this->OrdersModel->create($arr_ins)) {

                if(count($trans_ids)>0)
                {
                    $this->TransactionsModel->whereIn('id',$trans_ids)
                                    ->update(['is_show'=>'1']);
                }
                
                $obj_order->order_no = format_order_number($obj_order->id);
                $obj_order->save();

                $arr_req = $request->all();

                $arr_taxes = [];

                $arr_tax_id = $request->input('unit_tax');
                $arr_tax_id = array_unique($arr_tax_id);
                $obj_taxes = $this->TaxesModel->whereIn('id', $arr_tax_id)->get();

                if($obj_taxes->count() > 0) { $arr_taxes = $obj_taxes->toArray(); }

                $arr_ins = [];
                foreach($arr_req['prod_id'] as $key => $row) {

                    $tax_det = [];

                    $tax_id = $arr_req['unit_tax'][$key] ?? '';

                    foreach($arr_taxes as $tax) {
                        if($tax_id == $tax['id']) {
                            $tax_det = $tax;
                        }
                    }

                    $arr_ins[$key]['order_id']      = $obj_order->id;
                    $arr_ins[$key]['product_id']    = $row;
                    $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key] ?? 1;
                    //$arr_ins[$key]['rate']          = $arr_req['unit_rate'][$key] ?? 1;
                    $opc1_rate = $arr_req['opc1_rate'][$key] ?? 0;
                    $src5_rate = $arr_req['src5_rate'][$key] ?? 0;
                    $unit_rate = $opc1_rate+$src5_rate;
                    $arr_ins[$key]['rate']          = $unit_rate;

                    $arr_ins[$key]['opc_1_rate']    = $arr_req['opc1_rate'][$key] ?? 1;
                    $arr_ins[$key]['src_5_rate']    = $arr_req['src5_rate'][$key] ?? 1;
                    $arr_ins[$key]['tax_id']        = $tax_id;
                    $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                }

                $flag = $this->OrderDetailsModel->insert($arr_ins);

                $arr_store['user_id']     = $request->input('cust_id');
                $arr_store['contract_id'] = $request->input('contract_id');
                $arr_store['order_id']    = $obj_order->id;
                $arr_store['amount']      = $calc['grand_tot']??0;
                $arr_store['type']        = 'debit';
                $arr_store['pay_date']    = date('Y-m-d');

                $this->TranscationService->store_payment($arr_store);

                $arr_ins_inv['order_id']            = $obj_order->id;
                $arr_ins_inv['invoice_number']      = 'INV-DRAFT';
                $arr_ins_inv['invoice_date']        = date('Y-m-d',strtotime($request->input('delivery_date')));
                $arr_ins_inv['due_date']            = $request->input('due_date');
                $arr_ins_inv['net_total']           = $calc['sub_tot'] ?? 0;
                $arr_ins_inv['discount']            = $request->input('discount_num');
                $arr_ins_inv['discount_type']       = $request->input('disc_type');
                $arr_ins_inv['grand_tot']           = $calc['grand_tot'] ?? 0;
                $arr_ins_inv['billing_street']      = $request->input('billing_street');
                $arr_ins_inv['billing_city']        = $request->input('billing_city');
                $arr_ins_inv['billing_state']       = $request->input('billing_state');
                $arr_ins_inv['billing_zip']         = $request->input('billing_zip');
                $arr_ins_inv['billing_country']     = 1;
                $arr_ins_inv['include_shipping']    = $request->input('include_shipping','0');
                $arr_ins_inv['shipping_street']     = $request->input('shipping_street');
                $arr_ins_inv['shipping_city']       = $request->input('shipping_city');
                $arr_ins_inv['shipping_state']      = $request->input('shipping_state');
                $arr_ins_inv['shipping_zip']        = $request->input('shipping_zip');
                $arr_ins_inv['shipping_country']    = 1;

                $obj_inv = $this->SalesInvoiceModel->create($arr_ins_inv);

                if(isset($arr_req['pay_modes']) && !empty($arr_req['pay_modes'])) {

                    foreach($arr_req['pay_modes'] as $index => $row) {
                        $arr_pay_ins[$index]['invoice_id'] = $obj_inv->id;
                        $arr_pay_ins[$index]['pay_method_id'] = $row;
                    }

                    $pay_flag = $this->InvoicePayMethodsModel->insert($arr_pay_ins);
                }
                Session::flash('success',trans('admin.invoice').' '.trans('admin.created_successfully'));
            }else{
                Session::flash('error',trans('admin.error_msg'));
            }
        }
        return redirect()->route('booking');
    }

    public function edit_order($enc_id, Request $request) {

        $arr_sales_user = $arr_taxes = $arr_order = $arr_custs = $arr_products = $arr_pay_methods = $arr_estim = [];

        $id = base64_decode($enc_id);

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','invoice','cust_details','invoice.pay_methods','ord_details.product_details'])
                                    ->where('id', $id)
                                    ->first();
        if(!$obj_orders) {

            Session::flash('error',trans('admin.invalid_request'));

            return redirect()->back();

        }else{

            $arr_order = $obj_orders->toArray();
            // dump($arr_order);
            $obj_users = $this->UserModel->whereHas('role', function(){})
                                        ->with(['role'])
                                        ->where('role_id', config('app.roles_id.sales'))
                                        ->get();

            if($obj_users->count() > 0) {
                $arr_sales_user = $obj_users->toArray();
            }

            $obj_customers = $this->UserModel->whereHas('role', function(){})
                                        ->with(['role'])
                                        ->where('role_id', config('app.roles_id.customer'))
                                        ->get();

            if($obj_customers->count() > 0) {
                $arr_custs = $obj_customers->toArray();
            }

            $obj_product = $this->ProductModel->get();

            if($obj_product) {
                $arr_products = $obj_product->toArray();
            }

            $obj_taxes = $this->TaxesModel->where('is_active', '1')->get();

            if($obj_taxes->count() > 0) {
                $arr_taxes = $obj_taxes->toArray();
            }

            $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

            if($obj_pay_methods->count() > 0) {
                $arr_pay_methods = $obj_pay_methods->toArray();
            }

            $obj_estim = $this->SalesProposalModel->get();
            if($obj_estim->count()>0)
            {
                $arr_estim = $obj_estim->toArray();
            }

            $arr_pump = [];
            $obj_pump = $this->PumpModel->where('is_active','1')->select('id','name')->get();
            if($obj_pump)
            {
                $arr_pump = $obj_pump->toArray();
            }

            $obj_product = $this->SalesContractModel->whereHas('contr_details', function(){})
                                        ->with([
                                            'contr_details',
                                            'contr_details.product_details',
                                        ])
                                        ->where('id', $obj_orders->contract_id)->first();
            if($obj_product)
            {
                $arr_product = $obj_product->toArray();
            }
            // 
            $arr_helper = $arr_operator = $arr_driver = [];
            $obj_helper = $this->UserModel->where('role_id', config('app.roles_id.pump_helper'))
                                        ->select('id','first_name','last_name')
                                        ->get();
    
            if($obj_helper->count() > 0) {
                $arr_helper = $obj_helper->toArray();
            }
    
            $obj_opertaor = $this->UserModel->where('role_id', config('app.roles_id.pump_operator'))
                                        ->select('id','first_name','last_name')
                                        ->get();
    
            if($obj_opertaor->count() > 0) {
                $arr_operator = $obj_opertaor->toArray();
            }
    
            $obj_driver = $this->UserModel->where('role_id', config('app.roles_id.driver'))
                                          ->whereNotIn('id',NOT_A_MIXER_DRIVER)
                                        ->select('id','first_name','last_name')
                                        ->get();
    
            if($obj_driver->count() > 0) {
                $arr_driver = $obj_driver->toArray();
            }
            $this->arr_view_data['arr_sales_user']  = $arr_sales_user;
            $this->arr_view_data['arr_taxes']       = $arr_taxes;
            $this->arr_view_data['arr_custs']       = $arr_custs;
            $this->arr_view_data['arr_products']    = $arr_products;
            $this->arr_view_data['arr_order']       = $arr_order;
            $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;
            $this->arr_view_data['arr_estim']       = $arr_estim;
            $this->arr_view_data['arr_pump']        = $arr_pump;
            $this->arr_view_data['arr_product']     = $arr_product;
            $this->arr_view_data['arr_helper']      = $arr_helper;
            $this->arr_view_data['arr_operator']    = $arr_operator;
            $this->arr_view_data['arr_driver']      = $arr_driver;

            if($request->ajax()) {
                $arr_resp['status'] = 'success';
                $arr_resp['message'] = trans('admin.data_found');
                $arr_resp['html'] = view($this->module_view_folder.'.quick_edit',$this->arr_view_data)->render();
                return response()->json($arr_resp, 200);

            }else{
                return view($this->module_view_folder.'.edit',$this->arr_view_data);
            }
        }
    }

    public function update_order($enc_id, Request $request) {
        //dd($request->All());
        $id = base64_decode($enc_id);

        $obj_order = $this->OrdersModel->with(['ord_details.product_details.tax_detail'])->where('id', $id)->first();

        if(!$obj_order) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $old_order_data = $obj_order;
            $arr_rules                  = $arr_resp = array();
            //$arr_rules['cust_id']       = "required";
            //$arr_rules['contract_id']   = "required";
            $arr_rules['delivery_date'] = "required";
            $arr_rules['pump']          = "required";
            //$arr_rules['invoice_date']  = "required";
            $arr_rules['prod_id']       = 'required|array|min:1';
            $arr_rules['prod_id.*']     = 'required|integer';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                if($request->ajax()) {
                    Session::flash('error','Failed to updated Order!');
                }else{
                    $arr_resp['status']         = 'error';
                    $arr_resp['validation_err'] = $validator->messages()->toArray();
                    $arr_resp['message']        = trans('admin.validation_errors');
                }
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $calc_resp = $this->calculate_ord_amnt($request);

                $calc = json_decode($calc_resp->content(), true);

                //$arr_ins['cust_id']        = $request->input('cust_id');

                $arr_ins['delivery_date']    = date('Y-m-d',strtotime($request->input('delivery_date')));
                $arr_ins['extended_date']    = date('Y-m-d',strtotime($request->input('delivery_date')));
                
                $arr_ins['delivery_time']    = date('H:i',strtotime($request->input('delivery_time'))) ?? '';

                $arr_ins['pump']             = $request->input('pump');
                $arr_ins['sales_agent']      = $request->input('sales_agent');
                $arr_ins['admin_note']       = $request->input('admin_note');
                $arr_ins['client_note']      = $request->input('client_note');
                $arr_ins['terms_conditions'] = $request->input('terms_n_cond');
                $arr_ins['order_status']     = $request->input('status') ?? 'granted';
                $arr_ins['sub_total']        = $calc['sub_tot'] ?? 0;
                $arr_ins['disc_amnt']        = $calc['disc_amnt'] ?? 0;
                $arr_ins['grand_tot']        = $calc['grand_tot'] ?? 0;
                $arr_ins['structure']        = $request->input('structure');
                $arr_ins['remark']           = $request->input('remark');
                $arr_ins['pump_op_id']       = $request->input('pump_op_id');
                $arr_ins['pump_helper_id']   = $request->input('pump_helper_id');
                $arr_ins['driver_id']        = $request->input('driver_id');

                if($request->has('estimation_id'))
                {
                    $arr_ins['estimation_id'] = $request->input('estimation_id');
                }

                if($this->OrdersModel->where('id', $id)->update($arr_ins)) {

                    $resp = $this->OrderDetailsModel->where('order_id', $id)->delete();

                    $arr_req = $request->all();

                    $arr_taxes = [];

                    $arr_tax_id = $request->input('unit_tax');
                    $arr_tax_id = array_unique($arr_tax_id);
                    $obj_taxes = $this->TaxesModel->whereIn('id', $arr_tax_id)->get();

                    if($obj_taxes->count() > 0) { $arr_taxes = $obj_taxes->toArray(); }

                    $arr_ins = [];
                    foreach($arr_req['prod_id'] as $key => $row) {

                        $tax_det = [];

                        $tax_id = $arr_req['unit_tax'][$key] ?? '';

                        foreach($arr_taxes as $tax) {
                            if($tax_id == $tax['id']) {
                                $tax_det = $tax;
                            }
                        }

                        $arr_ins[$key]['order_id']      = $id;
                        $arr_ins[$key]['product_id']    = $row;
                        $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key] ?? 1;
                        //$arr_ins[$key]['rate']          = $arr_req['unit_rate'][$key] ?? 1;

                        $opc1_rate = $arr_req['opc1_rate'][$key] ?? 0;
                        $src5_rate = $arr_req['src5_rate'][$key] ?? 0;
                        $unit_rate = $opc1_rate+$src5_rate;
                        $arr_ins[$key]['rate']          = $unit_rate;

                        $arr_ins[$key]['opc_1_rate']    = $arr_req['opc1_rate'][$key] ?? 1;
                        $arr_ins[$key]['src_5_rate']    = $arr_req['src5_rate'][$key] ?? 1;
                        $arr_ins[$key]['tax_id']        = $tax_id;
                        $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                    }

                    $prv_bal = 0;
                    $obj_prv_order = $this->OrdersModel->where('id','<',$id)
                                            ->where('cust_id',$obj_order->cust_id)
                                            ->orderBy('id','desc')
                                            ->first();
                    if($obj_prv_order)
                    {
                        $prv_bal = $obj_prv_order->balance ?? 0;
                    }   

                    $flag = $this->OrderDetailsModel->insert($arr_ins);
                    if(isset($old_order_data->grand_tot) && $old_order_data->grand_tot != $calc['grand_tot'])
                    {
                        $arr_credit['contract_id'] = $old_order_data->contract_id ?? '';
                        $arr_credit['order_id']     = $id;
                        $arr_credit['amount']      = $old_order_data->grand_tot ?? 0;
                        $arr_credit['type']        = 'credit';
                        $arr_credit['pay_date']    = date('Y-m-d');
                        $arr_credit['user_id']     = $obj_order->cust_id ?? '';
                        $this->TranscationService->store_payment($arr_credit);

                        /*-------------------Account Payment----------*/
                        $old_balance = $old_adv_plus_bal = 0;

                        $old_balance      = $obj_order->balance ?? 0;
                        $old_adv_plus_bal = $obj_order->adv_plus_bal ?? 0;

                        $user_payment = calculate_customer_payment($obj_order->cust_id);
                        $arr_adv_payment = get_cust_latest_adavnce_payment($obj_order->cust_id);
                        if(isset($arr_adv_payment) && sizeof($arr_adv_payment)>0)
                        {
                            $adv_payment = array_sum(array_column($arr_adv_payment, 'amount'));
                            $trans_ids   = array_column($arr_adv_payment, 'id');
                            
                            $advance_payment = ($obj_order->advance_payment ?? 0) + $adv_payment;
                            $arr_up['advance_payment'] = $advance_payment;

                            //$arr_up['balance']         = $advance_payment - $calc['grand_tot'];

                            //$arr_up['balance']         = $advance_payment - $calc['grand_tot'] + $old_balance;

                            $arr_up['balance']         = $prv_bal + $advance_payment - ($calc['grand_tot'] ?? 0);

                            $this->OrdersModel->where('id', $id)->update($arr_up);

                            $this->TransactionsModel->whereIn('id',$trans_ids)
                                            ->update(['is_show'=>'1']);

                            $this->update_cust_order_payments($id,$obj_order->cust_id);
                        }
                        else
                        {
                            $balance = $old_advance = 0;
                            $old_advance = $obj_order->advance_payment ?? 0;

                            $balance = $old_advance + $prv_bal - ($calc['grand_tot'] ?? 0);
                            //dd($balance,$prv_bal,$calc['grand_tot']);
                            $this->OrdersModel->where('id', $id)->update(['balance'=>$balance]);

                            $this->update_cust_order_payments($id,$obj_order->cust_id);
                        }

                        $arr_debit['contract_id'] = $old_order_data->contract_id ?? '';
                        $arr_debit['order_id']    = $id;
                        $arr_debit['amount']      = $calc['grand_tot']??0;
                        $arr_debit['type']        = 'debit';
                        $arr_debit['pay_date']    = date('Y-m-d');
                        $arr_debit['user_id']     = $obj_order->cust_id ?? '';
                        $this->TranscationService->store_payment($arr_debit);
                    }
                    else
                    {
                        $adv_payment = 0;
                        $trans_ids = [];

                        $old_balance = $old_adv_plus_bal = 0;

                        $old_balance      = $obj_order->balance ?? 0;
                        $old_adv_plus_bal = $obj_order->adv_plus_bal ?? 0;

                        $user_payment = calculate_customer_payment($obj_order->cust_id);
                        $arr_adv_payment = get_cust_latest_adavnce_payment($obj_order->cust_id);
                        
                        if(isset($arr_adv_payment) && sizeof($arr_adv_payment)>0)
                        {
                            $advance_payment = 0;
                            $adv_payment = array_sum(array_column($arr_adv_payment, 'amount'));
                            $trans_ids   = array_column($arr_adv_payment, 'id');
                            
                            $advance_payment = ($obj_order->advance_payment ?? 0) + $adv_payment;
                            $arr_up['advance_payment'] = $advance_payment;
                           
                            //$arr_up['balance']         = $advance_payment + ($obj_order->balance ?? 0);

                            $arr_up['balance']         = $prv_bal + $advance_payment - ($calc['grand_tot'] ?? 0);
                            
                            $this->OrdersModel->where('id', $id)->update($arr_up);

                            $this->TransactionsModel->whereIn('id',$trans_ids)
                                            ->update(['is_show'=>'1']);

                            $this->update_cust_order_payments($id,$obj_order->cust_id);
                        }
                        else
                        {
                            $arr_up['balance']         = $old_balance;
                            $arr_up['adv_plus_bal']    = $old_adv_plus_bal;

                            $this->OrdersModel->where('id', $id)->update($arr_up);
                        }

                    }

                    $arr_ins_inv['invoice_number']      = 'INV-DRAFT';
                    $arr_ins_inv['invoice_date']        = date('Y-m-d',strtotime($request->input('delivery_date')));
                    $arr_ins_inv['due_date']            = $request->input('due_date');
                    $arr_ins_inv['net_total']           = $calc['sub_tot'] ?? 0;
                    $arr_ins_inv['discount']            = $request->input('discount_num');
                    $arr_ins_inv['discount_type']       = $request->input('disc_type');
                    $arr_ins_inv['grand_tot']           = $calc['grand_tot'] ?? 0;
                    $arr_ins_inv['billing_street']      = $request->input('billing_street');
                    $arr_ins_inv['billing_city']        = $request->input('billing_city');
                    $arr_ins_inv['billing_state']       = $request->input('billing_state');
                    $arr_ins_inv['billing_zip']         = $request->input('billing_zip');
                    $arr_ins_inv['billing_country']     = 1;
                    $arr_ins_inv['include_shipping']    = $request->input('include_shipping','0');
                    $arr_ins_inv['shipping_street']     = $request->input('shipping_street');
                    $arr_ins_inv['shipping_city']       = $request->input('shipping_city');
                    $arr_ins_inv['shipping_state']      = $request->input('shipping_state');
                    $arr_ins_inv['shipping_zip']        = $request->input('shipping_zip');
                    $arr_ins_inv['shipping_country']    = 1;

                    $obj_inv = $this->SalesInvoiceModel->where('order_id', $id)->update($arr_ins_inv);

                    if(isset($arr_req['pay_modes']) && !empty($arr_req['pay_modes'])) {
                        
                        $this->InvoicePayMethodsModel->where('invoice_id', $id)->delete();

                        foreach($arr_req['pay_modes'] as $index => $row) {
                            $arr_pay_ins[$index]['invoice_id'] = $id;
                            $arr_pay_ins[$index]['pay_method_id'] = $row;
                        }

                        $pay_flag = $this->InvoicePayMethodsModel->insert($arr_pay_ins);
                    }

                    if($request->ajax()) {
                    Session::flash('success',trans('admin.order').' '.trans('admin.updated_successfully'));
                    }else{
                        $arr_resp['status'] = 'success';
                        $arr_resp['message'] = trans('admin.order').' '.trans('admin.updated_successfully');
                    }

                }else{
                    if($request->ajax()) {
                        Session::flash('error',trans('admin.error_msg'));
                    }else{
                        $arr_resp['status'] = 'success';
                        $arr_resp['message'] = trans('admin.order').' '.trans('admin.updated_successfully');
                    }
                }
            }
        }

        if($request->ajax()) {
            return response()->json($arr_resp, 200);
        }

        return redirect()->route('booking');
    }
    
    public function cancel_order($enc_id, Request $request){
        $id = base64_decode($enc_id);
        $arr_resp = array();
        $param['order_status'] = 'cancelled';
        $updated = $this->OrdersModel->where('id', $id)->update($param);

        if($updated){
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.order').' '.trans('admin.cancelled_success');
        }
        else{
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.order').' '.trans('admin.somthing_went_wrong');
        }
        return redirect()->route('booking');
    }

    public function update_cust_order_payments($ord_id,$cust_id)
    {
        $old_order = $this->OrdersModel->where('id',$ord_id)->first();
        $old_balance = $old_order->balance ?? 0;

        $obj_next_order = $this->OrdersModel->where('id','>',$ord_id)
                                            ->where('cust_id',$cust_id)
                                            ->get();
        if($obj_next_order)
        {
            $arr_next_order = $obj_next_order->toArray();

            foreach ($arr_next_order as $key => $value) {
                $grand_tot = $value['grand_tot'] ?? 0;
                $advance_payment = $value['advance_payment'] ?? 0;
                $old_balance = ($old_balance + $advance_payment) - $grand_tot;
                $this->OrdersModel->where('id',$value['id'])->update(['balance'=>$old_balance]);
            }
        }
    }


    public function view_order($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_proposal = [];

        $id = base64_decode($enc_id);

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details',
                                        'invoice',
                                        'cust_details',
                                        'invoice.pay_methods',
                                        'ord_details.product_details',
                                        'ord_details.product_details.tax_detail',
                                    ])
                                    ->where('id', $id)
                                    ->first();

        if(!$obj_orders) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_order = $obj_orders->toArray();

            $this->arr_view_data['arr_order'] = $arr_order;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
    }

    public function dowload($enc_id) {

        $id = base64_decode($enc_id);

        $obj_inv = $this->SalesInvoiceModel->whereHas('inv_details', function(){})
                                        ->with(['inv_details',
                                                'cust_details',
                                                'inv_details.product_details',
                                                'inv_details.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_inv) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_invoice = $obj_inv->toArray();

            $this->arr_view_data['arr_invoice'] = $arr_invoice;

            $view = view($this->module_view_folder.'.download_pdf',$this->arr_view_data);
            $html = $view->render();

            PDF::SetTitle(format_order_number($arr_invoice['id']));
            PDF::AddPage();
            PDF::writeHTML($html, true, false, true, false, '');
            PDF::Output(format_order_number($arr_invoice['id']).'.pdf');
        }
    }

    public function change_status($enc_id, $status) {

        $id = base64_decode($enc_id);

        $obj_est = $this->SalesInvoiceModel->where('id', $id)->first();

        if(!$obj_est) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }

        $arr_update['status'] = $status;

        if($this->SalesInvoiceModel->where('id', $id)->update($arr_update)) {
            Session::flash('success',trans('admin.updated_successfully'));
            return redirect()->back();
        }else{
            Session::flash('error','Failed to update Invoice!');
            return redirect()->back();
        }
    }

    public function confirm_product(Request $request) {

        $arr_taxes = $arr_product = [];

        $prod_id = $request->input('prod_id');
        $quantity = $request->input('quantity');
        $opc1_rate = $request->input('opc1_rate');
        $src5_rate = $request->input('src5_rate');

        $obj_product = $this->ProductModel->where('id', $prod_id)->first();

        if($obj_product) {

            $arr_product = $obj_product->toArray();

            $obj_taxes = $this->TaxesModel->where('is_active', '1')->get();

            if($obj_taxes->count() > 0) {
                $arr_taxes = $obj_taxes->toArray();
            }

            $this->arr_view_data['arr_taxes'] = $arr_taxes;
            $this->arr_view_data['prod_id'] = $prod_id;
            $this->arr_view_data['quantity'] = $quantity;
            $this->arr_view_data['opc1_rate'] = $opc1_rate;
            $this->arr_view_data['src5_rate'] = $src5_rate;
            $this->arr_view_data['arr_product'] = $arr_product;

            $arr_resp['status'] = 'success';

            $arr_resp['html'] = view($this->module_view_folder.'.item_clone',$this->arr_view_data)->render();
        }else{
            $arr_resp['status'] = 'error';
        }

        return response()->json($arr_resp, 200);

    }

    public function add_inv_payment($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_inv = $this->SalesInvoiceModel->where('id', $id)->first();

        if($obj_inv) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['amount']        = "required";
            $arr_rules['pay_method']    = "required";
            $arr_rules['payment_date']  = 'required';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                $arr_store['invoice_id']    = $id;
                $arr_store['order_id']      = $obj_inv->order_id;
                $arr_store['amount']        = $request->input('amount');
                $arr_store['pay_method_id'] = $request->input('pay_method');
                $arr_store['pay_date']      = $request->input('payment_date');
                $arr_store['trans_id']      = $request->input('trans_id');
                $arr_store['note']          = $request->input('admin_note');
                $arr_store['user_id']       = '';

                if($this->TranscationService->store_payment($arr_store)) {
                    $arr_resp['status'] = 'success';
                    $arr_resp['message'] = trans('admin.payment_record_success');
                }else{
                    $arr_resp['status'] = 'error';
                    $arr_resp['message'] = trans('admin.payment_record_error');
                }
            }
        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

    public function get_user_cotracts($enc_id) {

        $arr_cust = $arr_resp = $arr_taxes = [];

        $user_id = base64_decode($enc_id);

        $obj_cust = $this->UserModel->with(['sale_contracts'])
                                    ->where('id', $user_id)->first();

        if(!$obj_cust) {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }else{
            $arr_cust = $obj_cust->toArray();

            $arr_resp['contracts'] = $arr_cust['sale_contracts']??[];
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
        }
        return response()->json($arr_resp, 200);
    }

    public function get_contract_items($enc_id) {

        $arr_cust = $arr_resp = $arr_taxes = [];

        $id = base64_decode($enc_id);

        $obj_contract = $this->SalesContractModel->whereHas('contr_details', function(){})
                                            ->with([
                                                'contr_details',
                                                'contr_details.product_details',
                                            ])
                                            ->where('id', $id)->first();

        if(!$obj_contract) {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }else{
            $arr_cust = $obj_contract->toArray();

            $arr_resp['contracts'] = $arr_cust['contr_details']??[];
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
        }
        return response()->json($arr_resp, 200);
    }

    public function get_contract_item($enc_id) {

        $arr_data = $arr_resp = $arr_taxes = [];

        $id = base64_decode($enc_id);

        $obj_contract = $this->SalesContractDetailsModel->whereHas('product_details', function(){})
                                            ->with([
                                                'product_details',
                                            ])
                                            ->where('product_id', $id)->first();

        if(!$obj_contract) {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }else{
            $arr_data = $obj_contract->toArray();

            $arr_resp['data'] = $arr_data??[];
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
        }
        return response()->json($arr_resp, 200);
    }

    public function get_pump_bookings(Request $request) {

        $date = date('Y-m-d',strtotime($request->input('date')));
        $arr_data = [];

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                            ->with([
                                                'ord_details',
                                            ])
                                            ->where('delivery_date', $date)->get();

        if($obj_orders->count() > 0) {
            $arr_orders = $obj_orders->toArray();

            foreach($arr_orders as $row) {
                if($row['pump'] != '') {
                    $pump = $row['pump']??'';
                    $ord_details = $row['ord_details'];
                    $arr_quamtities = array_column($ord_details, 'quantity');
                    $arr_data[$pump]['quantity'] = ($arr_data[$pump]['quantity']??0)+array_sum($arr_quamtities);
                }
            }
        }

        $arr_labels = array_keys($arr_data);
        $arr_labels = array_map(function($val) { return 'Pump '.$val;} , $arr_labels);

        $arr_data_chart['data'] = [];
        $arr_data_chart['data']['labels'] = $arr_labels;
        $arr_data_chart['data']['datasets'][0]['label'] = "Pumps";

        foreach($arr_data as $row) {
            $arr_data_chart['data']['datasets'][0]['backgroundColor'][] = "#3cba9f";
            $arr_data_chart['data']['datasets'][0]['data'][] = (string) $row['quantity']??0;
        }
        $arr_data_chart['data']['datasets'][0]['data'][] = 0;
        $arr_data_chart['options']['legend']['display'] = true;
        $arr_data_chart['options']['title']['display'] = true;
        $arr_data_chart['options']['title']['text'] = trans('admin.pump_wise_qty');

        if(empty($arr_data)) {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.no_booking_found');
        }else{
            $arr_resp['data'] = $arr_data??[];
            $arr_resp['arr_data_chart'] = $arr_data_chart??[];
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
        }
        return response()->json($arr_resp, 200);
    }

    public function load_sites($enc_id)
    {
        $arr_sites = [];
        $id = base64_decode($enc_id);
        if($id !='')
        {
            $obj_sites = $this->SalesContractModel->where('cust_id',$id)
                                              ->select('id','title','site_location')
                                              ->get();
            if($obj_sites)
            {
                $arr_sites = $obj_sites->toArray();

                $arr_resp['status'] = 'success';
                $arr_resp['arr_sites'] = $arr_sites;
                $arr_resp['message'] = trans('admin.sites_found');
            }
            else
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.sites_not_found');
            }
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }

    public function cron()
    {
        $arr_orders = [];
        $today = date('Y-m-d');
        //$today = date('Y-m-d',strtotime("-1 day", strtotime($today)));
        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->with(['ord_details.del_notes'])
                                    ->whereDate('delivery_date',$today)
                                    ->get();

        if($obj_orders)
        {
            $arr_orders = $obj_orders->toArray();
        }
        
        $booking_qty = $del_qty = $remaing_qty = 0;

        foreach ($arr_orders as $key => $value) {

            $booking_qty = $value['ord_details'][0]['quantity'] ?? 0;
            $del_qty     = array_sum(array_column($value['ord_details'][0]['del_notes'],'quantity')) ?? 0;
            $remaing_qty = $booking_qty - $del_qty;

            if($value['ord_details'][0]['del_notes']!='')
            {
                if($remaing_qty > 0)
                {
                    $extended_date = date('Y-m-d',strtotime("+1 day", strtotime($value['extended_date'])));

                    /*$this->OrdersModel->where('id',$value['id'])
                                  ->update(['extended_date'=>$extended_date]);*/
                }
            }
            else
            {
                $extended_date = date('Y-m-d',strtotime("+1 day", strtotime($value['extended_date'])));

                /*$this->OrdersModel->where('id',$value['id'])
                                  ->update(['extended_date'=>$extended_date]);*/
            }
            
        }
    }

    public function differential(Request $request) 
    {
         $arr_orders = $arr_sorted_orders = $arr_sales_user = $arr_trans = $arr_pump = $arr_user_trans = $arr_contracts = [];

        $contract_id = $sales_user = $custm_id = '';

        /* Order Mode Query */

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function($qry){
                                            $qry->whereNotNull('edit_quantity');
                                        })
                                        ->whereHas('invoice', function(){})
                                        ->whereHas('cust_details', function(){})
                                        ->with(['ord_details','ord_details.product_details','invoice','cust_details','pump_details','transactions','contract'])
                                        ->whereDate('delivery_date','>=', $start_date)
                                        ->whereDate('delivery_date','<=', $end_date);

        if($this->auth->user()->role_id != config('app.roles_id.admin')) {
            $obj_orders = $obj_orders->where('sales_agent', $this->auth->user()->id);
        }
        if($request->has('status') && $request->input('status') != '') {
            $obj_orders = $obj_orders->where('order_status', $request->input('status'));
        }
        if($request->has('custm_id') && $request->input('custm_id') != '') {
            $custm_id = $request->input('custm_id');
            $obj_orders = $obj_orders->where('cust_id', $custm_id);
        }

        if($request->has('contract') && $request->input('contract') != '') {
            $contract_id = $request->input('contract');
            $obj_orders = $obj_orders->where('contract_id', $contract_id);
        }
        if($request->has('sales_user') && $request->input('sales_user') != '') {
            $sales_user = $request->input('sales_user');
            $obj_orders = $obj_orders->where('sales_agent', $sales_user);
        }
        $obj_orders = $obj_orders->orderBy('pump', 'ASC')->paginate(10);
        if($obj_orders->count() > 0) {
            $arr_orders = $obj_orders->toArray();
        }

        if($obj_orders->count() > 0) {
            foreach($arr_orders['data'] as $row) {
                $arr_sorted_orders[$row['pump']][] = $row;
            }
        }


        /* Order Mode Query */

        $obj_trans = $this->TransactionsModel->whereHas('contract', function(){})
                                            ->with(['contract'])
                                            ->whereNotNull('contract_id')->get();

        if($obj_trans->count() > 0) { $arr_trans = $obj_trans->toArray(); }

        if(!empty($arr_trans)) {
            foreach($arr_trans as $trans) {
                $contract = $trans['contract']??[];
                if(!empty($contract)) {
                    $cust_id = $contract['cust_id']??0;
                    unset($trans['contract']);
                    $arr_user_trans[$cust_id][] = $trans;
                }
            }
        }

        // dd($arr_user_trans);

        $obj_pump = $this->PumpModel->where('is_active','1')->select('id','name')->get();
        if($obj_pump) {
            $arr_pump = $obj_pump->toArray();
        }

        $obj_contracts = $this->SalesContractModel->whereHas('cust_details', function(){})
                                                ->with(['cust_details'])
                                                ->get();

        if($obj_contracts->count() > 0) {
            $arr_contracts = $obj_contracts->toArray();
        }

        $obj_customer = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->get();

        if($obj_customer->count() > 0) {
            $arr_customer = $obj_customer->toArray();
        }


        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.sales'))
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_sales_user = $obj_users->toArray();
        }

        $this->arr_view_data['arr_orders']      = $arr_orders['data'] ?? [];
        $this->arr_view_data['arr_pump']        = $arr_pump;
        $this->arr_view_data['arr_trans']       = $arr_trans;
        $this->arr_view_data['arr_contracts']   = $arr_contracts;
        $this->arr_view_data['arr_user_trans']  = $arr_user_trans;
        $this->arr_view_data['arr_sales_user']  = $arr_sales_user;
        $this->arr_view_data['start_date']      = $start_date;
        $this->arr_view_data['end_date']        = $end_date;
        $this->arr_view_data['contract_id']     = $contract_id;
        $this->arr_view_data['custm_id']        = $custm_id;
        $this->arr_view_data['arr_sorted_orders']     = $arr_sorted_orders;
        $this->arr_view_data['obj_orders']      = $obj_orders;
        $this->arr_view_data['sales_user']      = $sales_user;
        $this->arr_view_data['arr_customer']    = $arr_customer ?? [];

        return view($this->module_view_folder.'.differential',$this->arr_view_data);
    }
}

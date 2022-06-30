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
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;

class InvoicesController extends Controller
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
        $this->auth                        = auth();
        $this->arr_view_data               = [];
        $this->module_title                = "Admin";
        $this->module_view_folder          = "sales.invoices";
        $this->TranscationService              = new TranscationService();
    }

    public function index() {

        $arr_invoices = $arr_sales_user = [];

        $obj_invoice = $this->SalesInvoiceModel->whereHas('order', function($q){
                                        if(auth()->user()->role_id != config('app.roles_id.admin'))
                                        {
                                            $q->where('sales_agent', auth()->user()->id);
                                        }
                                    })
                                    ->with(['order','order.ord_details','order.cust_details'])
                                    ->get();

        if($obj_invoice->count() > 0) {
            $arr_invoices = $obj_invoice->toArray();
        }

        $this->arr_view_data['arr_invoices']   = $arr_invoices;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create_invoice() {

        Session::flash('error','Not Allowed!');

        return redirect()->back();

        $arr_sales_user = $arr_taxes = $arr_products = $arr_custs = $arr_pay_methods = [];

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

        $this->arr_view_data['arr_sales_user'] = $arr_sales_user;
        $this->arr_view_data['arr_custs'] = $arr_custs;
        $this->arr_view_data['arr_taxes'] = $arr_taxes;
        $this->arr_view_data['arr_products'] = $arr_products;
        $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function calculate_inv_amnt(Request $request) {

        $arr_req = $request->all();

        $sub_tot = $grand_tot = 0;

        $arr_resp = $arr_taxes = [];

        $obj_taxes = $this->TaxesModel->whereIn('id', $arr_req['unit_tax'])->get();

        if($obj_taxes->count() > 0) {
            $arr_taxes = $obj_taxes->toArray();
        }

        foreach($arr_req['prod_id'] as $key => $req) {

            $unit_rate = $arr_req['unit_rate'][$key] ?? 0;
            $unit_quant = $arr_req['unit_quantity'][$key] ?? 0;
            $unit_tax = $arr_req['unit_tax'][$key] ?? '';
            $tax_amnt = $tax_rate = 0;

            if($unit_tax != '' && !empty($arr_taxes)) {
                $index = array_search($unit_tax, array_column($arr_taxes, 'id'));
                $tax_data = $arr_taxes[$index]??[];
                $tax_rate = $tax_data['tax_rate']??0;
            }

            $unit_sub_tot = ($unit_rate * $unit_quant);

            $tax_amnt = ( $tax_rate / 100 ) * $unit_sub_tot;

            $sub_tot += ( $unit_sub_tot + $tax_amnt );
        }

        $disc_num = $arr_req['discount_num'] ?? 0;
        $disc_type = $arr_req['disc_type'] ?? 'percentage';

        $arr_resp['status'] = 'success';

        $arr_resp['sub_tot'] = $sub_tot;

        if(strtolower($disc_type) == 'percentage') {
            $disc_amnt = round($disc_num * ($sub_tot / 100),2);
        }elseif(strtolower($disc_type) == 'fixed'){
            $disc_amnt = $disc_num;
        }

        $arr_resp['disc_amnt'] = $disc_amnt;
        $arr_resp['grand_tot'] = ($sub_tot - $disc_amnt);

        return response()->json($arr_resp, 200);
    }

    public function store_invoice(Request $request) {

        $arr_rules              = $arr_resp = array();
        $arr_rules['cust_id']       = "required";
        $arr_rules['invoice_date']  = "required";
        $arr_rules['prod_id']       = 'required|array|min:1';
        $arr_rules['prod_id.*']     = 'required|integer';

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            // dd($validator->messages()->toArray());
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        else
        {
            $calc_resp = $this->calculate_inv_amnt($request);

            $calc = json_decode($calc_resp->content(), true);

            $arr_ins = [];

            $arr_ins['cust_id']             = $request->input('cust_id');
            $arr_ins['sales_agent']         = $request->input('sales_agent');
            $arr_ins['status']              = $request->input('status');
            $arr_ins['invoice_date']        = $request->input('invoice_date');
            $arr_ins['due_date']            = $request->input('due_date');
            $arr_ins['admin_note']          = $request->input('admin_note');
            $arr_ins['client_notes']        = $request->input('client_note');
            $arr_ins['terms_conditions']    = $request->input('terms_n_cond');
            $arr_ins['net_total']           = $calc['sub_tot'] ?? 0;
            $arr_ins['discount']            = $request->input('discount_num');
            $arr_ins['discount_type']       = $request->input('disc_type');
            $arr_ins['grand_tot']           = $calc['grand_tot'] ?? 0;
            $arr_ins['billing_street']      = $request->input('billing_street');
            $arr_ins['billing_city']        = $request->input('billing_city');
            $arr_ins['billing_state']       = $request->input('billing_state');
            $arr_ins['billing_zip']         = $request->input('billing_zip');
            $arr_ins['billing_country']     = 1;
            $arr_ins['include_shipping']    = $request->input('include_shipping','0');
            $arr_ins['shipping_street']     = $request->input('shipping_street');
            $arr_ins['shipping_city']       = $request->input('shipping_city');
            $arr_ins['shipping_state']      = $request->input('shipping_state');
            $arr_ins['shipping_zip']        = $request->input('shipping_zip');
            $arr_ins['shipping_country']    = 1;

            if($obj_sales_inv = $this->SalesInvoiceModel->create($arr_ins)) {

                $obj_sales_inv->invoice_number = format_sales_invoice_number($obj_sales_inv->id);
                $obj_sales_inv->save();

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

                    $arr_ins[$key]['invoice_id']    = $obj_sales_inv->id;
                    $arr_ins[$key]['product_id']    = $row;
                    $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key] ?? 1;
                    $arr_ins[$key]['rate']          = $arr_req['unit_rate'][$key] ?? 1;
                    $arr_ins[$key]['tax_id']        = $tax_id;
                    $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                }

                $flag = $this->SalesInvoiceDetailsModel->insert($arr_ins);

                if(isset($arr_req['pay_modes']) && !empty($arr_req['pay_modes'])) {

                    foreach($arr_req['pay_modes'] as $index => $row) {
                        $arr_pay_ins[$index]['invoice_id'] = $obj_sales_inv->id;
                        $arr_pay_ins[$index]['pay_method_id'] = $row;
                    }

                    $pay_flag = $this->InvoicePayMethodsModel->insert($arr_pay_ins);
                }

                Session::flash('success',trans('admin.invoice_create_success'));
            }else{
                Session::flash('error',trans('admin.invoice_create_error'));
            }
        }

        return redirect()->route('invoices');
    }

    public function edit_invoice($enc_id) {

        return redirect()->back();

        $arr_sales_user = $arr_taxes = $arr_invoice = $arr_custs = $arr_products = $arr_pay_methods = [];

        $id = base64_decode($enc_id);

        $obj_invoice = $this->SalesInvoiceModel->where('id', $id)
                                                ->with(['inv_details.product_details.tax_detail',
                                                    'pay_methods'
                                                        ])->first();
        if(!$obj_invoice) {

            Session::flash('error',trans('admin.invalid_request'));

            return redirect()->back();

        }else{

            $arr_invoice = $obj_invoice->toArray();
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

            $this->arr_view_data['arr_sales_user'] = $arr_sales_user;
            $this->arr_view_data['arr_taxes'] = $arr_taxes;
            $this->arr_view_data['arr_custs'] = $arr_custs;
            $this->arr_view_data['arr_products'] = $arr_products;
            $this->arr_view_data['arr_invoice'] = $arr_invoice;
            $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;

            return view($this->module_view_folder.'.edit',$this->arr_view_data);

        }
    }

    public function update_invoice($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesInvoiceModel->with(['inv_details.product_details.tax_detail'])->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error','Invalid request!');
            return redirect()->back();
        }else{

            $arr_rules              = $arr_resp = array();
            $arr_rules['cust_id']       = "required";
            $arr_rules['invoice_date']  = "required";
            $arr_rules['prod_id']       = 'required|array|min:1';
            $arr_rules['prod_id.*']     = 'required|integer';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $calc_resp = $this->calculate_inv_amnt($request);

                $calc = json_decode($calc_resp->content(), true);

                $arr_ins['cust_id']             = $request->input('cust_id');
                $arr_ins['sales_agent']         = $request->input('sales_agent');
                $arr_ins['status']              = $request->input('status');
                $arr_ins['invoice_date']        = $request->input('invoice_date');
                $arr_ins['due_date']            = $request->input('due_date');
                $arr_ins['admin_note']          = $request->input('admin_note');
                $arr_ins['client_notes']        = $request->input('client_note');
                $arr_ins['terms_conditions']    = $request->input('terms_n_cond');
                $arr_ins['net_total']           = $calc['sub_tot'] ?? 0;
                $arr_ins['discount']            = $request->input('discount_num');
                $arr_ins['discount_type']       = $request->input('disc_type');
                $arr_ins['grand_tot']           = $calc['grand_tot'] ?? 0;
                $arr_ins['billing_street']      = $request->input('billing_street');
                $arr_ins['billing_city']        = $request->input('billing_city');
                $arr_ins['billing_state']       = $request->input('billing_state');
                $arr_ins['billing_zip']         = $request->input('billing_zip');
                $arr_ins['billing_country']     = 1;
                $arr_ins['include_shipping']    = $request->input('include_shipping','0');
                $arr_ins['shipping_street']     = $request->input('shipping_street');
                $arr_ins['shipping_city']       = $request->input('shipping_city');
                $arr_ins['shipping_state']      = $request->input('shipping_state');
                $arr_ins['shipping_zip']        = $request->input('shipping_zip');
                $arr_ins['shipping_country']    = 1;

                if($obj_sales_inv = $this->SalesInvoiceModel->where('id', $id)->update($arr_ins)) {

                    $resp = $this->SalesInvoiceDetailsModel->where('invoice_id', $id)->delete();

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

                        $arr_ins[$key]['invoice_id']    = $id;
                        $arr_ins[$key]['product_id']    = $row;
                        $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key] ?? 1;
                        $arr_ins[$key]['rate']          = $arr_req['unit_rate'][$key] ?? 1;
                        $arr_ins[$key]['tax_id']        = $tax_id;
                        $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                    }

                    $flag = $this->SalesInvoiceDetailsModel->insert($arr_ins);


                    if(isset($arr_req['pay_modes']) && !empty($arr_req['pay_modes'])) {
                        
                        $this->InvoicePayMethodsModel->where('invoice_id', $id)->delete();

                        foreach($arr_req['pay_modes'] as $index => $row) {
                            $arr_pay_ins[$index]['invoice_id'] = $id;
                            $arr_pay_ins[$index]['pay_method_id'] = $row;
                        }

                        $pay_flag = $this->InvoicePayMethodsModel->insert($arr_pay_ins);
                    }

                    Session::flash('success',trans('admin.estimate_update_suceess'));
                }else{
                    Session::flash('error',trans('admin.estimate_update_error'));
                }
            }
        }

        return redirect()->route('invoices');
    }

    public function view_invoice($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_proposal = [];

        $id = base64_decode($enc_id);

        $obj_inv = $this->SalesInvoiceModel->whereHas('order', function(){})
                                    ->with(['order',
                                            'order.ord_details',
                                            'order.ord_details.product_details',
                                            'order.ord_details.product_details.tax_detail',
                                            'order.cust_details',
                                            'inv_payments',
                                            'pay_methods',
                                            'pay_methods.method_details',
                                        ])
                                    ->where('id', $id)->first();

        if(!$obj_inv) {
            Session::flash('error','Invalid request!');
            return redirect()->back();
        }else{
            $arr_invoice = $obj_inv->toArray();

            $this->arr_view_data['arr_invoice'] = $arr_invoice;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
    }

    public function dowload($enc_id) {

        $id = base64_decode($enc_id);

        $obj_inv = $this->SalesInvoiceModel->whereHas('order', function(){})
                                    ->with(['order',
                                            'order.ord_details',
                                            'order.ord_details.product_details',
                                            'order.ord_details.product_details.tax_detail',
                                            'order.cust_details',
                                            'order.cust_details.user_meta',
                                            'pay_methods',
                                            'pay_methods.method_details',
                                        ])
                                    ->where('id', $id)->first();

        if(!$obj_inv) {
            Session::flash('error','Invalid request!');
            return redirect()->back();
        }else{
            $arr_invoice = $obj_inv->toArray();

            $this->arr_view_data['arr_invoice'] = $arr_invoice;

            $view = view($this->module_view_folder.'.download_pdf_new',$this->arr_view_data);
            // return $view;
            $html = $view->render();

            $img_file = asset('/images/image--000.png');
            PDF::SetTitle(format_sales_invoice_number($arr_invoice['id']));
            PDF::AddPage();
            PDF::SetAlpha(0.08);
            PDF::Image($img_file, 35, 70, 140, 140, '', '', '', false, 300, '', false, false, 0);
            PDF::SetAlpha(1);
            PDF::setPageMark();
            PDF::writeHTML($html, true, false, true, false, '');
            PDF::Output(format_sales_invoice_number($arr_invoice['id']).'.pdf');
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
            Session::flash('success',trans('admin.invoice_update_success'));
            return redirect()->back();
        }else{
            Session::flash('error',trans('admin.invoice_update_error'));
            return redirect()->back();
        }
    }

    public function confirm_product(Request $request) {

        $arr_taxes = $arr_product = [];

        $prod_id = $request->input('prod_id');
        $quantity = $request->input('quantity');

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
            $this->arr_view_data['arr_product'] = $arr_product;

            $arr_resp['status'] = 'success';

            // return view($this->module_view_folder.'.item_clone',$this->arr_view_data);

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
                $arr_store['invoice_id'] = $id;
                $arr_store['amount'] = $request->input('amount');
                $arr_store['pay_method_id'] = $request->input('pay_method');
                $arr_store['pay_date'] = $request->input('payment_date');
                $arr_store['trans_no'] = $request->input('trans_id');
                $arr_store['note'] = $request->input('admin_note');

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
}

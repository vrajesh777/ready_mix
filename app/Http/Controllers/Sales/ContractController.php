<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\TranscationService;
use App\Models\User;
use App\Models\ProductModel;
use App\Models\TaxesModel;
use App\Models\PaymentMethodsModel;
use App\Models\InvoicePayMethodsModel;
use App\Models\SalesProposalModel;
use App\Models\SalesProposalDetailsModel;
use App\Models\SalesInvoiceModel;
use App\Models\SalesInvoiceDetailsModel;
use App\Models\SalesContractModel;  
use App\Models\SalesContractDetailsModel; 
use App\Models\CustContractAttachmentModel; 
use App\Models\TransactionsModel; 
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->UserModel                   = new User;
        $this->ProductModel                = new ProductModel;
        $this->PaymentMethodsModel         = new PaymentMethodsModel;
        $this->InvoicePayMethodsModel      = new InvoicePayMethodsModel;
        $this->SalesProposalModel          = new SalesProposalModel;
        $this->SalesProposalDetailsModel   = new SalesProposalDetailsModel;
        $this->SalesInvoiceModel           = new SalesInvoiceModel;
        $this->SalesInvoiceDetailsModel    = new SalesInvoiceDetailsModel;
        $this->TaxesModel                  = new TaxesModel;
        $this->SalesContractModel          = new SalesContractModel;
        $this->SalesContractDetailsModel   = new SalesContractDetailsModel;
        $this->CustContractAttachmentModel = new CustContractAttachmentModel;
        $this->TransactionsModel           = new TransactionsModel;

        $this->auth                      = auth();
        $this->arr_view_data             = [];
        $this->module_title              = "Admin";
        $this->module_view_folder        = "sales.contract";
        $this->TranscationService        = new TranscationService();

        $this->cust_att_public_path = url('/').config('app.project.image_path.cust_contract_attch');
        $this->cust_att_base_path   = base_path().config('app.project.image_path.cust_contract_attch');  
    }

    public function index(Request $request) {

        $arr_contract = $arr_sales_user = [];

        $obj_contract = $this->SalesContractModel->whereHas('contr_details', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['contr_details','cust_details']);

        if($this->auth->user()->role_id != config('app.roles_id.admin')) {
            $obj_contract = $obj_contract->where('sales_agent', $this->auth->user()->id);
        }

        if($request->has('status') && $request->input('status') != '') {
            $obj_contract = $obj_contract->where('order_status', $request->input('status'));
        }

        $obj_contract = $obj_contract->orderBy('id', 'DESC')
                                    ->get();

        if($obj_contract->count() > 0) {
            $arr_contract = $obj_contract->toArray();
        }

        $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

        if($obj_pay_methods->count() > 0) {
            $arr_pay_methods = $obj_pay_methods->toArray();
        }


        $this->arr_view_data['arr_contract']   = $arr_contract??[];
        $this->arr_view_data['arr_pay_methods']   = $arr_pay_methods??[];

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create_contract(Request $request) {
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

        $this->arr_view_data['arr_est_clone']   = $arr_est_clone;
        $this->arr_view_data['arr_sales_user']  = $arr_sales_user;
        $this->arr_view_data['arr_custs']       = $arr_custs;
        $this->arr_view_data['arr_taxes']       = $arr_taxes;
        $this->arr_view_data['arr_products']    = $arr_products;
        $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;
        $this->arr_view_data['arr_estim']       = $arr_estim;
        $this->arr_view_data['cust_id']       = $request->id ? base64_decode($request->id):'';

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function calculate_contr_amnt(Request $request) {

        $arr_req = $request->all();

        $sub_tot = $grand_tot = 0;

        $arr_resp = $arr_taxes = [];

        $obj_taxes = $this->TaxesModel->whereIn('id',1)->get();

        if($obj_taxes->count() > 0) {
            $arr_taxes = $obj_taxes->toArray();
        }

        foreach($arr_req['prod_id'] as $key => $req) {

            // $unit_rate = $arr_req['unit_rate'][$key] ?? 0;
            $opc1_rate = $arr_req['opc1_rate'][$key] ?? 0;
            $src5_rate = $arr_req['src5_rate'][$key] ?? 0;
            $unit_rate = $opc1_rate+$src5_rate;
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

        if($request->ajax()) {
            $arr_resp['sub_tot'] = format_price($sub_tot);
            $arr_resp['disc_amnt'] = format_price($disc_amnt);
            $arr_resp['grand_tot'] = format_price($sub_tot - $disc_amnt);
        }else{
            $arr_resp['sub_tot'] = $sub_tot;
            $arr_resp['disc_amnt'] = $disc_amnt;
            $arr_resp['grand_tot'] = ($sub_tot - $disc_amnt);
        }

        return response()->json($arr_resp, 200);
    }

    public function store_contract(Request $request) {

        $arr_rules              = $arr_resp = array();
        $arr_rules['title']     = "required";
        $arr_rules['cust_id']   = "required";
        $arr_rules['prod_id']   = 'required|array|min:1';
        $arr_rules['prod_id.*'] = 'required|integer';

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            if($validator->errors()->has('prod_id')) {
                Session::flash('error',trans('admin.select_at_least_one_product'));
            }
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        else
        {
            $arr_ins = [];

            $arr_ins['title']                = $request->input('title');
            $arr_ins['cust_id']              = $request->input('cust_id');
            $arr_ins['sales_agent']          = $request->input('sales_agent');
            $arr_ins['status']               = $request->input('status');
            $arr_ins['admin_note']           = $request->input('admin_note');
            $arr_ins['client_note']          = $request->input('client_note');
            $arr_ins['terms_conditions']     = $request->input('terms_n_cond');
            $arr_ins['site_location']        = $request->input('site_location');
            $arr_ins['excepted_m3']          = $request->input('excepted_m3');
            $arr_ins['compressive_strength'] = $request->input('compressive_strength');
            $arr_ins['structure_element']    = $request->input('structure_element');
            $arr_ins['slump']                = $request->input('slump');
            $arr_ins['concrete_temp']        = $request->input('concrete_temp');
            $arr_ins['quantity']             = $request->input('quantity');
            $arr_ins['delivery_address']     = $request->input('delivery_address','');

            if($obj_contract = $this->SalesContractModel->create($arr_ins)) {

                $obj_contract->contract_no = format_sales_contract_number($obj_contract->id);
                $obj_contract->save();

                $arr_req = $request->all();

                $arr_taxes = [];
                $obj_taxes = $this->TaxesModel->where('id',1)->get();

                if($obj_taxes->count() > 0) { $arr_taxes = $obj_taxes->toArray(); }

                $arr_ins = [];
                foreach($arr_req['prod_id'] as $key => $row) {

                    $tax_det = [];

                    $tax_id = 1 ?? '';

                    foreach($arr_taxes as $tax) {
                        if($tax_id == $tax['id']) {
                            $tax_det = $tax;
                        }
                    }

                    $arr_ins[$key]['contr_id']      = $obj_contract->id;
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

                $this->SalesContractDetailsModel->insert($arr_ins);

                if($request->hasFile('contract'))
                {
                    $contract                     = $request->file('contract');
                    $file_extension               = strtolower($contract->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                    = time().uniqid().'.'.$file_extension;
                        $isUpload                     = $contract->move($this->cust_att_base_path , $file_name);
                        $arr_attch['contract']     = $file_name;
                    }
                }

                if($request->hasFile('quotation'))
                {
                    $quotation                     = $request->file('quotation');
                    $file_extension                = strtolower($quotation->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                     = time().uniqid().'.'.$file_extension;
                        $isUpload                      = $quotation->move($this->cust_att_base_path , $file_name);
                        $arr_attch['quotation']    = $file_name;
                    }
                }

                if($request->hasFile('bala_per'))
                {
                    $bala_per                     = $request->file('bala_per');
                    $file_extension               = strtolower($bala_per->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                    = time().uniqid().'.'.$file_extension;
                        $isUpload                     = $bala_per->move($this->cust_att_base_path , $file_name);
                        $arr_attch['bala_per']     = $file_name;
                    }
                }

                if($request->hasFile('owner_id'))
                {
                    $owner_id                     = $request->file('owner_id');
                    $file_extension               = strtolower($owner_id->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                    = time().uniqid().'.'.$file_extension;
                        $isUpload                     = $owner_id->move($this->cust_att_base_path , $file_name);
                        $arr_attch['owner_id']     = $file_name;
                    }
                }

                if($request->hasFile('credit_form'))
                {
                    $credit_form                     = $request->file('credit_form');
                    $file_extension               = strtolower($credit_form->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                    = time().uniqid().'.'.$file_extension;
                        $isUpload                     = $credit_form->move($this->cust_att_base_path , $file_name);
                        $arr_attch['credit_form']     = $file_name;
                    }
                }

                if($request->hasFile('purchase_order'))
                {
                    $purchase_order                     = $request->file('purchase_order');
                    $file_extension               = strtolower($purchase_order->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                    = time().uniqid().'.'.$file_extension;
                        $isUpload                     = $purchase_order->move($this->cust_att_base_path , $file_name);
                        $arr_attch['purchase_order']     = $file_name;
                    }
                }

                if($request->hasFile('pay_grnt'))
                {
                    $pay_grnt                     = $request->file('pay_grnt');
                    $file_extension               = strtolower($pay_grnt->getClientOriginalExtension());

                    if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                    {
                        $file_name                    = time().uniqid().'.'.$file_extension;
                        $isUpload                     = $pay_grnt->move($this->cust_att_base_path , $file_name);
                        $arr_attch['pay_grnt']     = $file_name;
                    }
                }

                if(!empty($arr_attch))
                {
                    $arr_attch['cust_cont_id'] = $obj_contract->id;
                    $this->CustContractAttachmentModel->create($arr_attch);
                }

                Session::flash('success',trans('admin.stored_successfully'));
            }else{
                Session::flash('error',trans('admin.prob_occured'));
            }
        }

        return redirect()->route('cust_contract');
    }

    public function edit_contract($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_contract = $arr_custs = $arr_products = $arr_pay_methods = $arr_estim = [];

        $id = base64_decode($enc_id);

        $obj_orders = $this->SalesContractModel->whereHas('contr_details', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['contr_details','cust_details','contr_details.product_details','contract_attch'])
                                    ->where('id', $id)
                                    ->first();
        if(!$obj_orders) {

            Session::flash('error',trans('admin.invalid_request'));

            return redirect()->back();

        }else{

            $arr_contract = $obj_orders->toArray();

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

            $this->arr_view_data['arr_sales_user']       = $arr_sales_user;
            $this->arr_view_data['arr_taxes']            = $arr_taxes;
            $this->arr_view_data['arr_custs']            = $arr_custs;
            $this->arr_view_data['arr_products']         = $arr_products;
            $this->arr_view_data['arr_contract']         = $arr_contract;
            $this->arr_view_data['arr_pay_methods']      = $arr_pay_methods;
            $this->arr_view_data['arr_estim']            = $arr_estim;
            $this->arr_view_data['cust_att_public_path'] = $this->cust_att_public_path;
            $this->arr_view_data['cust_att_base_path'] = $this->cust_att_base_path;

            return view($this->module_view_folder.'.edit',$this->arr_view_data);

        }
    }

    public function update_contract($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_order = $this->SalesContractModel->with(['contr_details.product_details.tax_detail'])->where('id', $id)->first();

        if(!$obj_order) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_rules                  = $arr_resp = array();
            $arr_rules['title']         = "required";
            //$arr_rules['cust_id']       = "required";
            $arr_rules['prod_id']       = 'required|array|min:1';
            $arr_rules['prod_id.*']     = 'required|integer';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
               
                $arr_ins['title']                = $request->input('title');
                //$arr_ins['cust_id']            = $request->input('cust_id');
                $arr_ins['sales_agent']          = $request->input('sales_agent');
                $arr_ins['status']               = $request->input('status');
                $arr_ins['admin_note']           = $request->input('admin_note');
                $arr_ins['client_note']          = $request->input('client_note');
                $arr_ins['terms_conditions']     = $request->input('terms_n_cond');
                $arr_ins['site_location']        = $request->input('site_location');
                $arr_ins['excepted_m3']          = $request->input('excepted_m3');
                $arr_ins['compressive_strength'] = $request->input('compressive_strength');
                $arr_ins['structure_element']    = $request->input('structure_element');
                $arr_ins['slump']                = $request->input('slump');
                $arr_ins['concrete_temp']        = $request->input('concrete_temp');
                $arr_ins['quantity']             = $request->input('quantity');
                $arr_ins['delivery_address']     = $request->input('delivery_address');

                if($obj_order = $this->SalesContractModel->where('id', $id)->update($arr_ins)) {

                    $resp = $this->SalesContractDetailsModel->where('contr_id', $id)->delete();

                    $arr_req = $request->all();

                    $arr_taxes = [];

                  /*  $arr_tax_id = $request->input('unit_tax');
                    $arr_tax_id = array_unique($arr_tax_id);*/
                    $obj_taxes = $this->TaxesModel->where('id',1)->get();

                    if($obj_taxes->count() > 0) { $arr_taxes = $obj_taxes->toArray(); }

                    $arr_ins = [];
                    foreach($arr_req['prod_id'] as $key => $row) {

                        $tax_det = [];

                        $tax_id = 1;

                        foreach($arr_taxes as $tax) {
                            if($tax_id == $tax['id']) {
                                $tax_det = $tax;
                            }
                        }

                        $arr_ins[$key]['contr_id']      = $id;
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

                    $this->SalesContractDetailsModel->insert($arr_ins);

                    if($request->hasFile('contract'))
                    {
                        $contract                     = $request->file('contract');
                        $file_extension               = strtolower($contract->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                    = time().uniqid().'.'.$file_extension;
                            $isUpload                     = $contract->move($this->cust_att_base_path , $file_name);
                            $arr_attch['contract']     = $file_name;
                        }
                    }

                    if($request->hasFile('quotation'))
                    {
                        $quotation                     = $request->file('quotation');
                        $file_extension                = strtolower($quotation->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                     = time().uniqid().'.'.$file_extension;
                            $isUpload                      = $quotation->move($this->cust_att_base_path , $file_name);
                            $arr_attch['quotation']    = $file_name;
                        }
                    }

                    if($request->hasFile('bala_per'))
                    {
                        $bala_per                     = $request->file('bala_per');
                        $file_extension               = strtolower($bala_per->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                    = time().uniqid().'.'.$file_extension;
                            $isUpload                     = $bala_per->move($this->cust_att_base_path , $file_name);
                            $arr_attch['bala_per']     = $file_name;
                        }
                    }

                    if($request->hasFile('owner_id'))
                    {
                        $owner_id                     = $request->file('owner_id');
                        $file_extension               = strtolower($owner_id->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                    = time().uniqid().'.'.$file_extension;
                            $isUpload                     = $owner_id->move($this->cust_att_base_path , $file_name);
                            $arr_attch['owner_id']     = $file_name;
                        }
                    }

                    if($request->hasFile('credit_form'))
                    {
                        $credit_form                     = $request->file('credit_form');
                        $file_extension               = strtolower($credit_form->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                    = time().uniqid().'.'.$file_extension;
                            $isUpload                     = $credit_form->move($this->cust_att_base_path , $file_name);
                            $arr_attch['credit_form']     = $file_name;
                        }
                    }

                    if($request->hasFile('purchase_order'))
                    {
                        $purchase_order                     = $request->file('purchase_order');
                        $file_extension               = strtolower($purchase_order->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                    = time().uniqid().'.'.$file_extension;
                            $isUpload                     = $purchase_order->move($this->cust_att_base_path , $file_name);
                            $arr_attch['purchase_order']     = $file_name;
                        }
                    }

                    if($request->hasFile('pay_grnt'))
                    {
                        $pay_grnt                     = $request->file('pay_grnt');
                        $file_extension               = strtolower($pay_grnt->getClientOriginalExtension());
                        if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                        {
                            $file_name                    = time().uniqid().'.'.$file_extension;
                            $isUpload                     = $pay_grnt->move($this->cust_att_base_path , $file_name);
                            $arr_attch['pay_grnt']     = $file_name;
                        }
                    }
   
                    if(!empty($arr_attch))
                    {
                        $arr_attch['cust_cont_id'] = $id;
                        $this->CustContractAttachmentModel->updateOrCreate(['cust_cont_id'=>$id],$arr_attch);
                    }


                    Session::flash('success',trans('admin.updated_successfully'));
                }else{
                    Session::flash('error',trans('admin.updated_error'));
                }
            }
        }

        return redirect()->route('cust_contract');
    }

    public function view_contract($enc_id) {

        $arr_contract = [];

        $id = base64_decode($enc_id);

        $obj_contract = $this->SalesContractModel->whereHas('contr_details', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['contr_details',
                                        'cust_details',
                                        'contr_details.product_details',
                                        'contr_details.product_details.tax_detail',
                                        'contract_attch'
                                    ])
                                    ->where('id', $id)
                                    ->first();

        if(!$obj_contract) {
            Session::flash('error','Invalid request!');
            return redirect()->back();
        }else{
            $arr_contract = $obj_contract->toArray();

            $this->arr_view_data['arr_contract']         = $arr_contract;
            $this->arr_view_data['cust_att_public_path'] = $this->cust_att_public_path;
            $this->arr_view_data['cust_att_base_path']   = $this->cust_att_base_path;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
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

    public function add_contract_payment(Request $request)
    {
        $arr_rules                  = $arr_resp = array();
        $arr_rules['enc_id']        = "required";
        $arr_rules['amount']        = "required";
        $arr_rules['pay_method_id'] = "required";
        $arr_rules['pay_date']      = 'required';
        
        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $trans_id = $request->input('trans_id');
        if($trans_id!='')
        {
            $is_exist = $this->TransactionsModel->where('trans_no',$trans_id)
                                                ->count();
            if($is_exist > 0)
            {
                Session::flash('error',trans('admin.transaction_id_already_exist'));
                return redirect()->back();
            }
        }

        $arr_store['user_id']       = $request->input('cust_id');
        $arr_store['contract_id']   = base64_decode($request->input('enc_id'));
        $arr_store['amount']        = $request->input('amount');
        $arr_store['type']          = 'credit';
        $arr_store['pay_method_id'] = $request->input('pay_method_id');
        $arr_store['pay_date']      = $request->input('pay_date');
        $arr_store['trans_no']      = $trans_id;
        $arr_store['note']          = $request->input('note');

        if($this->TranscationService->store_payment($arr_store)) {
            Session::flash('success',trans('admin.payment_record_added_successfully'));
        }else{
            Session::flash('error',trans('admin.failed_to_record_payment'));
        }
        return redirect()->back();
    }

    public function contract_bal($enc_id, Request $request) {
        
        $id = base64_decode($enc_id);

        $total = $request->input('total');

        $obj_contract = $this->SalesContractModel->where('id', $id)->first();

        if($obj_contract) {
            $bal = $this->TranscationService->get_contract_bal($id);
            $arr_resp['status'] = 'success';
            $arr_resp['rem_bal'] = $bal;
            $arr_resp['message'] = '';
        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }
        
        return response()->json($arr_resp, 200);
    }

    public function customer_bal($enc_id, Request $request) {
        
        $id = base64_decode($enc_id);

        $total = $request->input('total');

        $obj_cust = $this->UserModel->where('id', $id)->first();

        if($obj_cust) {
            $bal = $this->TranscationService->get_customer_bal($id);
            $arr_resp['status'] = 'success';
            $arr_resp['rem_bal'] = $bal;
            $arr_resp['message'] = '';
        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] =  trans('admin.invalid_request');
        }
        
        return response()->json($arr_resp, 200);
    }
}

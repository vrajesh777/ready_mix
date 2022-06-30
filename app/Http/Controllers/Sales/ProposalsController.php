<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\Common\Services\EmailService;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\ProductModel;
use App\Models\SalesEstimateModel;
use App\Models\TaxesModel;
use App\Models\SalesEstimateProdQuantModel;
use App\Models\SalesProposalModel;
use App\Models\SalesProposalDetailsModel;
use App\Models\SalesInvoiceModel;
use App\Models\SalesInvoiceDetailsModel;
use App\Common\Services\SalesProposalService;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;

class ProposalsController extends Controller
{
     public function __construct()
    {
        $this->UserModel                    = new User;
        $this->LeadsModel                   = new LeadsModel;
        $this->ProductModel                 = new ProductModel;
        $this->SalesEstimateModel                = new SalesEstimateModel;
        $this->SalesEstimateProdQuantModel       = new SalesEstimateProdQuantModel;
        $this->SalesProposalModel         = new SalesProposalModel;
        $this->SalesProposalDetailsModel  = new SalesProposalDetailsModel;
        $this->SalesInvoiceModel            = new SalesInvoiceModel;
        $this->SalesInvoiceDetailsModel     = new SalesInvoiceDetailsModel;
        $this->TaxesModel                   = new TaxesModel;
        $this->SalesProposalService         = new SalesProposalService;
        $this->auth                         = auth();
        $this->arr_view_data                = [];
        $this->module_title                 = "Admin";
        $this->module_view_folder           = "sales.proposals";
        $this->EmailService                 = new EmailService();
    }

    public function index(Request $request) {

        $arr_sales_user = [];

        /*$obj_proposals = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['prop_details','cust_details'])
                                    ->get();

        if($obj_proposals->count() > 0) {
            $arr_props = $obj_proposals->toArray();
        }*/

        $arr_props = $this->SalesProposalService->get_all_proposal();

        $this->arr_view_data['arr_props']   = $arr_props;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create_proposal(Request $request) {

        $arr_sales_user = $arr_taxes = $arr_products = $arr_custs = $arr_proposals = $arr_prop_clone = [];

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

        $obj_proposals = $this->SalesEstimateModel->whereIn('status',['sent','open','revised'])
                              ->select('id','subject','status')->get();
        if($obj_proposals)
        {
            $arr_proposals = $obj_proposals->toArray();
        }

        if($request->has('prop') && $request->input('prop') != '') {
            $propId = base64_decode($request->input('prop'));

            $obj_prop = $this->SalesEstimateModel->whereHas('product_quantity', function(){})
                                            ->with(['product_quantity',
                                                    'product_quantity.product_details',
                                                    'product_quantity.product_details.tax_detail'])
                                            ->where('id', $propId)->first();

            if($obj_prop) {
                $arr_prop_clone = $obj_prop->toArray();
            }

        }

        $this->arr_view_data['arr_sales_user']  = $arr_sales_user;
        $this->arr_view_data['arr_custs']       = $arr_custs;
        $this->arr_view_data['arr_taxes']       = $arr_taxes;
        $this->arr_view_data['arr_products']    = $arr_products;
        $this->arr_view_data['arr_proposals']   = $arr_proposals;
        $this->arr_view_data['arr_prop_clone']  = $arr_prop_clone;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function calculate_prop_amnt(Request $request) {

        $arr_req = $request->all();

        $sub_tot = $grand_tot = 0;

        $arr_resp = $arr_taxes = [];

        $obj_taxes = $this->TaxesModel->whereIn('id', $arr_req['unit_tax'])->get();

        if($obj_taxes->count() > 0) {
            $arr_taxes = $obj_taxes->toArray();
        }

        foreach($arr_req['prod_id'] as $key => $req) {

            //$unit_rate = $arr_req['unit_rate'][$key] ?? 0;
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

    public function store_proposal(Request $request) {

        $arr_rules              = $arr_resp = array();
        $arr_rules['cust_id']   = "required";
        $arr_rules['date']      = "required";
        $arr_rules['prod_id']   = 'required|array|min:1';
        $arr_rules['prod_id.*'] = 'required|integer';

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            // dd($validator->messages()->toArray());
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        else
        {
            $calc_resp = $this->calculate_prop_amnt($request);

            $calc = json_decode($calc_resp->content(), true);

            $arr_ins = [];

            $arr_ins['cust_id']             = $request->input('cust_id');
            $arr_ins['assigned_to']         = $request->input('assigned_to');
            $arr_ins['ref_num']             = $request->input('ref_num');
            $arr_ins['status']              = $request->input('status');
            $arr_ins['date']                = $request->input('date');
            $arr_ins['expiry_date']         = $request->input('expiry_date');
            $arr_ins['admin_note']          = $request->input('admin_note');
            $arr_ins['client_note']         = $request->input('client_note');
            $arr_ins['terms_n_cond']        = $request->input('terms_n_cond');
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

            if($request->has('proposal_id'))
            {
                $arr_ins['proposal_id']    = $request->input('proposal_id');
            }

            if($obj_sales_est = $this->SalesProposalModel->create($arr_ins)) {

                $obj_sales_est->est_num = format_proposal_number($obj_sales_est->id);
                $obj_sales_est->save();

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

                    $arr_ins[$key]['estimation_id']     = $obj_sales_est->id;
                    $arr_ins[$key]['product_id']        = $row;
                    $arr_ins[$key]['quantity']          = $arr_req['unit_quantity'][$key] ?? 1;
                    $arr_ins[$key]['rate']              = $arr_req['unit_rate'][$key] ?? 1;
                    $arr_ins[$key]['opc_1_rate']        = $arr_req['opc1_rate'][$key] ?? 1;
                    $arr_ins[$key]['src_5_rate']        = $arr_req['src5_rate'][$key] ?? 1;
                    $arr_ins[$key]['tax_id']            = $tax_id;
                    $arr_ins[$key]['tax_rate']          = $tax_det['tax_rate']??0;
                }

                $flag = $this->SalesProposalDetailsModel->insert($arr_ins);

                Session::flash('success',trans('admin.estimates')." ".trans('admin.created_successfully'));
            }else{
                Session::flash('error',trans('admin.error_msg'));
            }
        }

        return redirect()->route('proposals');
    }

    public function edit_proposal($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_proposal = $arr_custs = $arr_products = $arr_proposals = [];

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesProposalModel->with(['prop_details.product_details.tax_detail'])->where('id', $id)->first();

        if(!$obj_prop) {

            Session::flash('error',trans('admin.invalid_request'));

            return redirect()->back();

        }else{

            $arr_proposal = $obj_prop->toArray();
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

            $obj_proposals = $this->SalesEstimateModel/*->whereIn('status',['sent','open','revised'])*/
                              ->select('id','subject','status')->get();
            if($obj_proposals)
            {
                $arr_proposals = $obj_proposals->toArray();
            }

            $this->arr_view_data['arr_sales_user'] = $arr_sales_user;
            $this->arr_view_data['arr_taxes']      = $arr_taxes;
            $this->arr_view_data['arr_custs']      = $arr_custs;
            $this->arr_view_data['arr_products']   = $arr_products;
            $this->arr_view_data['arr_proposal']   = $arr_proposal;
            $this->arr_view_data['arr_proposals']  = $arr_proposals;

            return view($this->module_view_folder.'.edit',$this->arr_view_data);

        }
    }

    public function update_proposal($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesProposalModel->with(['prop_details.product_details.tax_detail'])->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{

            $arr_rules              = $arr_resp = array();
            $arr_rules['cust_id']   = "required";
            $arr_rules['date']      = "required";
            $arr_rules['prod_id']   = 'required|array|min:1';
            $arr_rules['prod_id.*'] = 'required|integer';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $calc_resp = $this->calculate_prop_amnt($request);

                $calc = json_decode($calc_resp->content(), true);

                $arr_ins['cust_id']             = $request->input('cust_id');
                $arr_ins['assigned_to']         = $request->input('assigned_to');
                $arr_ins['ref_num']             = $request->input('ref_num');
                $arr_ins['status']              = $request->input('status');
                $arr_ins['date']                = $request->input('date');
                $arr_ins['expiry_date']         = $request->input('expiry_date');
                $arr_ins['admin_note']          = $request->input('admin_note');
                $arr_ins['client_note']         = $request->input('client_note');
                $arr_ins['terms_n_cond']        = $request->input('terms_n_cond');
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

                if($request->has('proposal_id'))
                {
                    $arr_ins['proposal_id']    = $request->input('proposal_id');
                }

                if($obj_sales_est = $this->SalesProposalModel->where('id', $id)->update($arr_ins)) {

                    $resp = $this->SalesProposalDetailsModel->where('estimation_id', $id)->delete();

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

                        $arr_ins[$key]['estimation_id']     = $id;
                        $arr_ins[$key]['product_id']        = $row;
                        $arr_ins[$key]['quantity']          = $arr_req['unit_quantity'][$key] ?? 1;
                        $arr_ins[$key]['rate']              = $arr_req['unit_rate'][$key] ?? 1;
                        $arr_ins[$key]['opc_1_rate']        = $arr_req['opc1_rate'][$key] ?? 1;
                        $arr_ins[$key]['src_5_rate']        = $arr_req['src5_rate'][$key] ?? 1;
                        $arr_ins[$key]['tax_id']            = $tax_id;
                        $arr_ins[$key]['tax_rate']          = $tax_det['tax_rate']??0;
                    }

                    $flag = $this->SalesProposalDetailsModel->insert($arr_ins);

                Session::flash('success',trans('admin.estimates').' '.trans('admin.updated_successfully'));
                }else{
                    Session::flash('error',trans('admin.error_msg'));
                }
            }
        }

        return redirect()->route('proposals');
    }

    public function view_proposal($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_proposal = [];

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                        ->whereHas('cust_details', function(){})
                                        ->with(['prop_details',
                                                'cust_details',
                                                'prop_details.product_details',
                                                'prop_details.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_proposal = $obj_prop->toArray();

            $this->arr_view_data['arr_props'] = $arr_proposal;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
    }

    public function dowload($enc_id, $ret_file=false) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                        ->with(['prop_details',
                                                'cust_details',
                                                'cust_details.user_meta',
                                                'prop_details.product_details',
                                                'prop_details.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_proposal = $obj_prop->toArray();

            $this->arr_view_data['arr_proposal'] = $arr_proposal;

            $view = view($this->module_view_folder.'.download_pdf_new',$this->arr_view_data);
            $html = $view->render();

            $img_file = asset('/images/image--000.png');
            PDF::SetTitle(format_proposal_number($arr_proposal['id']));
            PDF::SetMargins(2, 5, 5, true);
            PDF::AddPage();
            PDF::SetAlpha(0.08);
            PDF::Image($img_file, 35, 70, 140, 140, '', '', '', false, 300, '', false, false, 0);
            PDF::SetAlpha(1);
            PDF::writeHTML($html, true, false, true, false, '');
            if($ret_file) {
                PDF::Output(\Storage::path(format_proposal_number($arr_proposal['id']).'.pdf'),'F');
                return \Storage::path(format_proposal_number($arr_proposal['id']).'.pdf');
            }else{
                PDF::Output(format_proposal_number($arr_proposal['id']).'.pdf');
            }
        }
    }

    public function change_status($enc_id, $status) {

        $id = base64_decode($enc_id);

        $obj_est = $this->SalesProposalModel->where('id', $id)->first();

        if(!$obj_est) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }

        $arr_update['status'] = $status;

        if($this->SalesProposalModel->where('id', $id)->update($arr_update)) {
            Session::flash('success',trans('admin.estimates')." ".trans('admin.updated_successfully'));
            return redirect()->back();
        }else{
            Session::flash('error',trans('admin.error_msg'));
            return redirect()->back();
        }
    }

    public function convert_est_to_ord($enc_id) {

        $id = base64_decode($enc_id);

        $obj_est = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                        ->with(['prop_details'])
                                        ->where('id', $id)->first();

        dd($obj_est);

        if(!$obj_est) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }

        if($obj_est->related == 'lead') {
            Session::flash('error',trans('admin.convert_leads_to_cust'));
            return redirect()->back();
        }

        $arr_est = $obj_est->toArray();

        $arr_ins['cust_id']             = $arr_est['cust_id'];
        $arr_ins['sales_agent']         = $arr_est['assigned_to'];
        $arr_ins['ref_num']             = $arr_est['ref_num'];
        $arr_ins['status']              = $arr_est['status'];
        $arr_ins['invoice_date']        = $arr_est['date'];
        $arr_ins['due_date']            = $arr_est['expiry_date'];
        $arr_ins['admin_note']          = $arr_est['admin_note'];
        $arr_ins['client_note']         = $arr_est['client_note'];
        $arr_ins['terms_conditions']    = $arr_est['terms_n_cond'];
        $arr_ins['net_total']           = $arr_est['net_total'] ?? 0;
        $arr_ins['discount']            = $arr_est['discount'];
        $arr_ins['discount_type']       = $arr_est['discount_type'];
        $arr_ins['grand_tot']           = $arr_est['grand_tot'] ?? 0;
        $arr_ins['billing_street']      = $arr_est['billing_street'];
        $arr_ins['billing_city']        = $arr_est['billing_city'];
        $arr_ins['billing_state']       = $arr_est['billing_state'];
        $arr_ins['billing_zip']         = $arr_est['billing_zip'];
        $arr_ins['billing_country']     = 1;
        $arr_ins['include_shipping']    = $arr_est['include_shipping'];
        $arr_ins['shipping_street']     = $arr_est['shipping_street'];
        $arr_ins['shipping_city']       = $arr_est['shipping_city'];
        $arr_ins['shipping_state']      = $arr_est['shipping_state'];
        $arr_ins['shipping_zip']        = $arr_est['shipping_zip'];
        $arr_ins['shipping_country']    = 1;

        if($obj_sales_inv = $this->SalesInvoiceModel->create($arr_ins)) {

            $obj_sales_inv->invoice_number = format_sales_invoice_number($obj_sales_inv->id);
            $obj_sales_inv->save();

            if(isset($arr_est['prop_details']) && !empty($arr_est['prop_details'])) {
                foreach($arr_est['prop_details'] as $key => $row) {
                    $arr_est_dtls[$key]['invoice_id']   = $obj_sales_inv->id;
                    $arr_est_dtls[$key]['product_id']   = $row['product_id']??'';
                    $arr_est_dtls[$key]['quantity']     = $row['quantity']??'';
                    $arr_est_dtls[$key]['rate']         = $row['rate']??'';
                    $arr_est_dtls[$key]['tax_id']       = $row['tax_id']??'';
                    $arr_est_dtls[$key]['tax_rate']     = $row['tax_rate']??'';
                }

                $ret = $this->SalesInvoiceDetailsModel->insert($arr_est_dtls);
            }
            Session::flash('success',trans('admin.estimate_success_msg'));
            return redirect()->back();
        }else{
            Session::flash('error',trans('admin.error_msg'));
            return redirect()->back();
        }

    }

    public function confirm_prop_product(Request $request) {

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

    public function get_prop_to_est_clone_data($enc_id) {

        $arr_proposal = $arr_resp = $arr_taxes = [];

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->whereHas('product_quantity', function(){})
                                        ->with(['product_quantity',
                                                'product_quantity.product_details',
                                                'product_quantity.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_prop) {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }else{
            $arr_proposal = $obj_prop->toArray();

            $obj_taxes = $this->TaxesModel->where('is_active', '1')->get();

            if($obj_taxes->count() > 0) {
                $arr_taxes = $obj_taxes->toArray();
            }

            $arr_resp['items_html'] = '';

            foreach($arr_proposal['product_quantity'] as $row) {
                $this->arr_view_data['arr_taxes'] = $arr_taxes;
                $this->arr_view_data['prod_id'] = $row['product_id']??'';
                $this->arr_view_data['quantity'] = $row['quantity']??'';
                $this->arr_view_data['opc1_rate'] = $row['opc_1_rate']??'';
                $this->arr_view_data['src5_rate'] = $row['src_5_rate']??'';
                $this->arr_view_data['arr_product'] = $row['product_details']??[];
                $arr_resp['items_html'] .= view($this->module_view_folder.'.item_clone',$this->arr_view_data)->render();
            }

            $arr_data = array_map(function ($v){if (is_array($v) || is_object($v)) {return "";}return $v;}, $arr_proposal);

            $arr_resp['data'] = $arr_data;
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');

        }

        return response()->json($arr_resp, 200);
    }

    public function send_prop_email($enc_id) {

        $id = base64_decode($enc_id);

        $obj_est = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                        ->whereHas('cust_details', function(){})
                                        ->with(['prop_details',
                                                'cust_details',
                                                'prop_details.product_details',
                                                'prop_details.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if($obj_est) {
            $file = $this->dowload(base64_encode($id), true);

            $arr_est = $obj_est->toArray();
            $arr_cust = $arr_est['cust_details']??[];

            $username = $arr_cust['first_name'];
            $username .= ' '.$arr_cust['last_name'];

            $attachment[]   = $file;

            $arr_mail_data['username']      = $username;
            $arr_mail_data['arr_est_data']   = $arr_est;
            $arr_mail_data['email']          = $arr_cust['email']??'';
            $arr_mail_data['prop_page_link'] = url('/');
            $arr_mail_data['template_from']  = config('app.project.title');
            $arr_mail_data['email_template'] = 'emails.estimation';
            $arr_mail_data['subject']        = 'Proposal';

            $email_status = $this->EmailService->send_mail($arr_mail_data,$attachment);

            if($email_status) {
                Session::flash('success',trans('admin.mail_sent_successfully'));
            }else{
                Session::flash('error',trans('admin.faild_to_send_email'));
            }
        }else{
            Session::flash('error',trans('admin.invalid_request'));
        }

        return redirect()->back();

    }

    public function get_user_meta($enc_id)
    {
        $arr_meta = [];
        $id = base64_decode($enc_id);
        $obj_user_meta = $this->UserModel->with('user_meta')
                                         ->where('id',$id)
                                         ->first();
        if($obj_user_meta)
        {
            $arr_user_meta = $obj_user_meta->toArray();

            if(isset($arr_user_meta['user_meta']) && !empty($arr_user_meta['user_meta'])) {
                foreach($arr_user_meta['user_meta'] as $meta) {
                    $arr_meta[($meta['meta_key']??'')] = $meta['meta_value']??'';
                }
            }   

            $arr_resp['status']  = 'success';
            $arr_resp['message'] = trans('admin.data_found');
            $arr_resp['data']    = $arr_meta;
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }
}

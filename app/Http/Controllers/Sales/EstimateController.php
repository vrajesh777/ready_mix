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
use App\Models\SalesEstimateProdQuantModel;
use App\Models\TaxesModel;
use App\Models\SalesProposalModel;
use App\Models\SalesProposalDetailsModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;

class EstimateController extends Controller
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
        $this->TaxesModel                   = new TaxesModel;
        $this->auth                         = auth();
        $this->arr_view_data                = [];
        $this->module_title                 = "Admin";
        $this->module_view_folder           = "sales.estimates";
        $this->EmailService                 = new EmailService();
    }

    public function index(Request $request) {

        $arr_props = $arr_sales_user = [];

        $obj_proposals = $this->SalesEstimateModel;
                                    // ->with(['assigned_to'])

        if($this->auth->user()->role_id != config('app.roles_id.admin')) {
            $obj_proposals = $obj_proposals->where('assigned_to', $this->auth->user()->id);
        }

        if($request->has('status') && $request->input('status') != '') {
            $obj_proposals = $obj_proposals->where('status', $request->input('status'));
        }

        $obj_proposals = $obj_proposals
                                    ->orderBy('id', 'DESC')
                                    ->get();

        if($obj_proposals->count() > 0) {
            $arr_props = $obj_proposals->toArray();
        }

        $this->arr_view_data['arr_props']   = $arr_props;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create_estimate() {

        $arr_sales_user = $arr_taxes = [];

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.sales'))
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_sales_user = $obj_users->toArray();
        }

        $obj_taxes = $this->TaxesModel->where('is_active', '1')->get();

        if($obj_taxes->count() > 0) {
            $arr_taxes = $obj_taxes->toArray();
        }

        $this->arr_view_data['arr_sales_user'] = $arr_sales_user;
        $this->arr_view_data['arr_taxes'] = $arr_taxes;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function calculate_est_amnt(Request $request) {

        $arr_req = $request->all();

        $sub_tot = $grand_tot = 0;

        $arr_resp = $arr_taxes = [];

        $obj_taxes = $this->TaxesModel->whereIn('id', ($arr_req['unit_tax']??[]))->get();

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

    public function store_estimate(Request $request) {

        $arr_rules              = $arr_resp = array();
        $arr_rules['subject']   = "required";
        $arr_rules['related']   = "required";
        $arr_rules['user_id']   = "required";
        $arr_rules['to']        = "required";
        $arr_rules['date']      = "required";
        $arr_rules['address']   = "required";
        $arr_rules['email']     = "required";
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
            $calc_resp = $this->calculate_est_amnt($request);

            $calc = json_decode($calc_resp->content(), true);

            $lead_id = $cust_id = 0;

            if($request->input('related') == 'lead') {
                $lead_id = $request->input('user_id');
            }else{
                $cust_id = $request->input('user_id');
            }

            $arr_ins = [];

            $arr_ins['subject']         = $request->input('subject');
            $arr_ins['related']         = $request->input('related');
            $arr_ins['assigned_to']     = $request->input('assigned_to');
            $arr_ins['lead_id']         = $lead_id;
            $arr_ins['cust_id']         = $cust_id;
            $arr_ins['date']            = $request->input('date');
            $arr_ins['open_till']       = $request->input('open_till');
            $arr_ins['status']          = $request->input('status');
            $arr_ins['to']              = $request->input('to');
            $arr_ins['address']         = $request->input('address');
            $arr_ins['city']            = $request->input('city');
            $arr_ins['state']           = $request->input('state');
            $arr_ins['postal_code']     = $request->input('postal_code');
            $arr_ins['country']         = 1;
            $arr_ins['email']           = $request->input('email');
            $arr_ins['phone']           = $request->input('phone');
            $arr_ins['net_total']       = $calc['sub_tot'] ?? 0;
            $arr_ins['discount']        = $request->input('discount_num');
            $arr_ins['discount_type']   = $request->input('disc_type');
            $arr_ins['grand_tot']       = $calc['grand_tot'] ?? 0;

            if($obj_prop = $this->SalesEstimateModel->create($arr_ins)) {

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

                    $arr_ins[$key]['proposal_id']   = $obj_prop->id;
                    $arr_ins[$key]['product_id']    = $row;
                    $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key] ?? 1;

                    $opc1_rate = $arr_req['opc1_rate'][$key] ?? 0;
                    $src5_rate = $arr_req['src5_rate'][$key] ?? 0;
                    $unit_rate = $opc1_rate+$src5_rate;

                    $arr_ins[$key]['rate']          = $unit_rate;
                    $arr_ins[$key]['opc_1_rate']    = $arr_req['opc1_rate'][$key] ?? 1;
                    $arr_ins[$key]['src_5_rate']    = $arr_req['src5_rate'][$key] ?? 1;
                    $arr_ins[$key]['tax_id']        = $tax_id;
                    $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                }

                $flag = $this->SalesEstimateProdQuantModel->insert($arr_ins);

                Session::flash('success',trans('admin.proposal')." ".trans('admin.created_successfully'));
            }else{
                Session::flash('error',trans('admin.error_msg'));
            }
        }

        return redirect()->route('estimates');
    }

    public function update_estimate($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->with(['product_quantity.product_details.tax_detail'])->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{

            $arr_rules              = $arr_resp = array();
            $arr_rules['subject']   = "required";
            $arr_rules['related']   = "required";
            $arr_rules['user_id']   = "required";
            $arr_rules['to']        = "required";
            $arr_rules['date']      = "required";
            $arr_rules['address']   = "required";
            $arr_rules['email']     = "required";
            $arr_rules['prod_id']   = 'required|array|min:1';
            $arr_rules['prod_id.*'] = 'required|integer';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $calc_resp = $this->calculate_est_amnt($request);

                $calc = json_decode($calc_resp->content(), true);

                $lead_id = $cust_id = 0;

                if($request->input('related') == 'lead') {
                    $lead_id = $request->input('user_id');
                }else{
                    $cust_id = $request->input('user_id');
                }

                $arr_ins = [];

                $arr_ins['subject']         = $request->input('subject');
                $arr_ins['related']         = $request->input('related');
                $arr_ins['assigned_to']     = $request->input('assigned_to');
                $arr_ins['lead_id']         = $lead_id;
                $arr_ins['cust_id']         = $cust_id;
                $arr_ins['date']            = $request->input('date');
                $arr_ins['open_till']       = $request->input('open_till');
                $arr_ins['status']          = $request->input('status');
                $arr_ins['to']              = $request->input('to');
                $arr_ins['address']         = $request->input('address');
                $arr_ins['city']            = $request->input('city');
                $arr_ins['state']           = $request->input('state');
                $arr_ins['postal_code']     = $request->input('postal_code');
                $arr_ins['country']         = 1;
                $arr_ins['email']           = $request->input('email');
                $arr_ins['phone']           = $request->input('phone');
                $arr_ins['net_total']       = $calc['sub_tot'] ?? 0;
                $arr_ins['discount']        = $request->input('discount_num');
                $arr_ins['discount_type']   = $request->input('disc_type');
                $arr_ins['grand_tot']       = $calc['grand_tot'] ?? 0;

                if($obj_prop = $this->SalesEstimateModel->where('id', $id)->update($arr_ins)) {

                    $this->SalesEstimateProdQuantModel->where('proposal_id', $id)->delete();

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

                        $arr_ins[$key]['proposal_id']   = $id;
                        $arr_ins[$key]['product_id']    = $row;
                        $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key]??1;
                        $opc1_rate = $arr_req['opc1_rate'][$key] ?? 0;
                        $src5_rate = $arr_req['src5_rate'][$key] ?? 0;
                        $unit_rate = $opc1_rate+$src5_rate;
                        $arr_ins[$key]['rate']          = $unit_rate;
                        //$arr_ins[$key]['rate']          = $arr_req['unit_rate'][$key]??1;
                        $arr_ins[$key]['opc_1_rate']    = $arr_req['opc1_rate'][$key] ?? 1;
                        $arr_ins[$key]['src_5_rate']    = $arr_req['src5_rate'][$key] ?? 1;
                        $arr_ins[$key]['tax_id']        = $tax_id;
                        $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                    }

                    $flag = $this->SalesEstimateProdQuantModel->insert($arr_ins);

                    Session::flash('success',trans('admin.proposal').' '.trans('admin.updated_successfully'));
                }else{
                    Session::flash('error',trans('admin.errro_msg'));
                }
            }
        }

        return redirect()->route('estimates');
    }

    public function get_related_person(Request $request) {

        $keyword = $request->input('keyword');
        $related = $request->input('related');

        $arr_resp = [];

        if($related == 'lead') {
            $obj_leads = $this->LeadsModel
                                    ->where('name', 'like', '%'.$keyword.'%')
                                    ->get();

            if($obj_leads->count() > 0) {
                foreach($obj_leads->toArray() as $lead) {
                    $arr_resp['results'][] = array('text'=>$lead['name'], 'id'=>$lead['id']);
                }
            }

        }elseif($related == 'customer') {

            $obj_cust = $this->UserModel->where('is_active', '1')
                                        ->where(function($q) use($keyword){
                                            $q->where('first_name','like', '%'.$keyword.'%');
                                            $q->orWhere('last_name','like', '%'.$keyword.'%');
                                        })
                                        ->where('role_id', config('app.roles_id.customer'))
                                        ->get();

            if($obj_cust->count() > 0) {
                foreach($obj_cust->toArray() as $key => $row) {
                    $full_name = $row['first_name'].' '.$row['last_name'];
                    $arr_resp['results'][] = array('id'=> $row['id'], 'text'=> $full_name);
                }
            }
            
        }

        return response()->json($arr_resp, 200);
    }

    public function prop_related_user_details(Request $request) {

        $related = $request->input('related');
        $user_id = $request->input('user_id');

        $arr_resp = [];

        if($related == 'lead') {

            $obj_lead = $this->LeadsModel->where('id', $user_id)->first();

            if($obj_lead) {

                $arr_lead = $obj_lead->toArray();

                $arr_data['to_name'] = $arr_lead['name'] ?? '';
                $arr_data['address'] = $arr_lead['address'] ?? '';
                $arr_data['city'] = $arr_lead['city'] ?? '';
                $arr_data['state'] = $arr_lead['state'] ?? '';
                $arr_data['postal_code'] = $arr_lead['zip_code'] ?? '';
                $arr_data['email'] = $arr_lead['email'] ?? '';
                $arr_data['phone'] = $arr_lead['phone'] ?? '';

                $arr_resp['status'] = 'success';
                $arr_resp['data'] = $arr_data;
            }

        }elseif($related == 'customer'){

            $obj_cust = $this->UserModel->where('id', $user_id)->first();

            if($obj_cust) {
                $arr_cust = $obj_cust->toArray();

                $full_name = $arr_cust['first_name'] ?? '';
                $full_name .= ' '.$arr_cust['last_name'] ?? '';

                $arr_data['to_name'] = $full_name;
                $arr_data['address'] = $arr_cust['address'] ?? '';
                $arr_data['city'] = $arr_cust['city'] ?? '';
                $arr_data['state'] = $arr_cust['state'] ?? '';
                $arr_data['postal_code'] = $arr_cust['postal_code'] ?? '';
                $arr_data['email'] = $arr_cust['email'] ?? '';
                $arr_data['phone'] = $arr_cust['phone'] ?? '';

                $arr_resp['status'] = 'success';
                $arr_resp['data'] = $arr_data;
            }
        }

        return response()->json($arr_resp, 200);
    }

    public function edit_estimate($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_proposal = $arr_custs = $arr_leads = [];

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->with(['product_quantity.product_details.tax_detail'])->where('id', $id)->first();

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

            $obj_leads = $this->LeadsModel->get();

            if($obj_leads->count() > 0) {
                $arr_leads = $obj_leads->toArray();
            }

            $obj_taxes = $this->TaxesModel->where('is_active', '1')->get();

            if($obj_taxes->count() > 0) {
                $arr_taxes = $obj_taxes->toArray();
            }

            $this->arr_view_data['arr_sales_user'] = $arr_sales_user;
            $this->arr_view_data['arr_custs'] = $arr_custs;
            $this->arr_view_data['arr_leads'] = $arr_leads;
            $this->arr_view_data['arr_taxes'] = $arr_taxes;
            $this->arr_view_data['arr_proposal'] = $arr_proposal;

            return view($this->module_view_folder.'.edit',$this->arr_view_data);

        }
    }

    public function view_estimate($enc_id) {

        $arr_sales_user = $arr_taxes = $arr_proposal = [];

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->whereHas('product_quantity', function(){})
                                        ->with(['product_quantity',
                                                'product_quantity.product_details',
                                                'product_quantity.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_proposal = $obj_prop->toArray();

            $this->arr_view_data['arr_proposal'] = $arr_proposal;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
    }

    public function dowload($enc_id, $ret_file=false) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->whereHas('product_quantity', function(){})
                                        ->with(['product_quantity',
                                                'product_quantity.product_details',
                                                'product_quantity.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_proposal = $obj_prop->toArray();

            $this->arr_view_data['arr_proposal'] = $arr_proposal;

            $view = view($this->module_view_folder.'.download_pdf',$this->arr_view_data);
            // return $view;
            $html = $view->render();

            PDF::SetTitle(format_sales_estimation_number($arr_proposal['id']));
            PDF::AddPage();
            PDF::writeHTML($html, true, false, true, false, '');

            if($ret_file) {
                PDF::Output(\Storage::path(format_sales_estimation_number($arr_proposal['id']).'.pdf'),'F');
                return \Storage::path(format_sales_estimation_number($arr_proposal['id']).'.pdf');
            }else{
                PDF::Output(format_sales_estimation_number($arr_proposal['id']).'.pdf');
            }


        }
    }

    public function change_status($enc_id, $status) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }

        $arr_update['status'] = $status;

        if($this->SalesEstimateModel->where('id', $id)->update($arr_update)) {
            Session::flash('success',trans('admin.proposal').' '.trans('admin.updated_successfully'));
            return redirect()->back();
        }else{
            Session::flash('error',trans('admin.errro_msg'));
            return redirect()->back();
        }
    }

    public function convert_to_estimate($enc_id) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->whereHas('product_quantity', function(){})
                                        ->with(['product_quantity',
                                                'product_quantity.product_details',
                                                'product_quantity.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if(!$obj_prop) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }

        if($obj_prop->related == 'lead') {
            Session::flash('error',trans('admin.convert_leads_to_cust'));
            return redirect()->back();
        }

        $arr_prop = $obj_prop->toArray();

        $arr_ins['cust_id']         = $arr_prop['cust_id']??'';
        $arr_ins['assigned_to']     = $arr_prop['assigned_to']??0;
        $arr_ins['date']            = $arr_prop['date']??'';
        $arr_ins['expiry_date']     = $arr_prop['open_till']??'';
        $arr_ins['tags']            = $arr_prop['tags']??'';
        $arr_ins['net_total']       = $arr_prop['net_total']??0;
        $arr_ins['discount']        = $arr_prop['discount']??0;
        $arr_ins['discount_type']   = $arr_prop['discount_type']??'';
        $arr_ins['grand_tot']       = $arr_prop['grand_tot']??0;
        $arr_ins['adjustment']      = $arr_prop['adjustment']??'';

        if($obj_sales_pro = $this->SalesProposalModel->create($arr_ins)) {

            $obj_sales_pro->est_num = format_proposal_number($obj_sales_pro->id);
            $obj_sales_pro->save();

            if(isset($arr_prop['product_quantity']) && !empty($arr_prop['product_quantity'])) {
                foreach($arr_prop['product_quantity'] as $key => $row) {
                    $arr_prod_det = $row['product_details']??[];
                    $arr_tax_det = $arr_prod_det['tax_detail']??[];
                    $arr_est_dtls[$key]['estimation_id']    = $obj_sales_pro->id;
                    $arr_est_dtls[$key]['product_id']       = $row['product_id']??'';
                    $arr_est_dtls[$key]['quantity']         = $row['quantity']??'';
                    $arr_est_dtls[$key]['rate']             = $row['rate']??'';
                    $arr_est_dtls[$key]['tax_id']           = $arr_tax_det['id']??'';
                    $arr_est_dtls[$key]['tax_rate']         = $arr_tax_det['tax_rate']??0;
                }

                $ret = $this->SalesProposalDetailsModel->insert($arr_est_dtls);
            }
            Session::flash('success',trans('admin.estimate_proposal_convert_msg'));
            return redirect()->back();
        }else{
            Session::flash('error',trans('admin.error_msg'));
            return redirect()->back();
        }

    }

    public function send_est_email($enc_id) {

        $id = base64_decode($enc_id);

        $obj_prop = $this->SalesEstimateModel->whereHas('product_quantity', function(){})
                                        ->with(['product_quantity',
                                                'product_quantity.product_details',
                                                'product_quantity.product_details.tax_detail'])
                                        ->where('id', $id)->first();

        if($obj_prop) {
            $file = $this->dowload(base64_encode($id), true);

            $attachment[]   = $file;

            $arr_mail_data['username']       = $obj_prop->to??'';
            $arr_mail_data['email']          = $obj_prop->email??'';
            $arr_mail_data['prop_page_link'] = url('/');
            $arr_mail_data['template_from']  = config('app.project.title');
            $arr_mail_data['email_template'] = 'emails.proposal';
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

     public function confirm_est_product(Request $request) {

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

            // return view($this->module_view_folder.'.item_clone',$this->arr_view_data);

            $arr_resp['html'] = view($this->module_view_folder.'.item_clone',$this->arr_view_data)->render();
        }else{
            $arr_resp['status'] = 'error';
        }

        return response()->json($arr_resp, 200);

    }
}

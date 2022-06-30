<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\Common\Services\EmailService;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\UserMetaModel;
use App\Models\OrdersModel;
use App\Models\SalesInvoiceModel;
use App\Models\SalesProposalModel;
use App\Models\SalesEstimateModel;
use App\Models\TransactionsModel;
use App\Models\CustomerContactModel;
use App\Models\SalesContractModel;
use App\Models\PaymentMethodsModel;
use App\Common\Services\ERP\CustomerService;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;


class CustomersController extends Controller
{
    public function __construct()
    {
        $this->UserModel            = new User;
        $this->LeadsModel           = new LeadsModel;
        $this->UserMetaModel        = new UserMetaModel;
        $this->OrdersModel          = new OrdersModel;
        $this->SalesInvoiceModel    = new SalesInvoiceModel;
        $this->SalesProposalModel   = new SalesProposalModel;
        $this->SalesEstimateModel   = new SalesEstimateModel;
        $this->TransactionsModel    = new TransactionsModel;
        $this->CustomerContactModel = new CustomerContactModel;
        $this->SalesContractModel   = new SalesContractModel;
        $this->PaymentMethodsModel  = new PaymentMethodsModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Customers";
        $this->module_view_folder   = "customers";
        $this->module_url_path      = url('/customer');
        $this->CustomerService      = new CustomerService();
        // $this->EmailService      = new EmailService();
    }

    public function index() {

        $arr_customers = [];

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->orderBy('id', 'DESC')
                                    ->get();
        // $obj_users = DB::table('users')
        //             ->join('roles','roles.id','=','users.role_id')
        //             ->where('users.id', '!=', $this->auth->user()->id)
        //             ->where('role_id', config('app.roles_id.customer'))
        //             ->get();

        if($obj_users->count() > 0) {
            $arr_customers = $obj_users->toArray();
        }

        $this->arr_view_data['arr_customers']   = $arr_customers;
        $this->arr_view_data['page_title']      = $this->module_title;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store_customer(Request $request) {

        $arr_rules                  = $arr_resp = $arr_data=array();
        $arr_rules['u_first_name']  = "required";
        $arr_rules['u_last_name']   = "required";
        // $arr_rules['u_email']       = "required|email|unique:users,email";
        $arr_rules['u_company']     = "required";
        // $arr_rules['u_password']    = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
        }else{

            $arr_ins = $arr_meta_ins = [];

            $arr_ins['role_id']         = config('app.roles_id.customer');
            $arr_ins['first_name']      = $request->input('u_first_name');
            $arr_ins['last_name']       = $request->input('u_last_name');
            $arr_ins['email']           = $request->input('u_email');
            $arr_ins['mobile_no']       = $request->input('u_phone');
            $arr_ins['address']         = $request->input('u_address');
            $arr_ins['city']            = $request->input('u_city');
            $arr_ins['state']           = $request->input('u_state');
            $arr_ins['postal_code']     = $request->input('u_zip_code');
            $arr_ins['password']        = \Hash::make($request->input('u_password'));
            $arr_ins['is_active']       = '1';
            //$arr_ins['site_location']   = $request->input('site_location','');

            if($obj_user = $this->UserModel->create($arr_ins)) {

                $arr_meta_ins = [];
                if($request->has('u_website') && $request->input('u_website')!='') {
                    $arr_meta_ins[1]['user_id']     = $obj_user->id;
                    $arr_meta_ins[1]['meta_key']    = 'website';
                    $arr_meta_ins[1]['meta_value']  = $request->input('u_website');
                }
                if($request->has('u_company') && $request->input('u_company')!='') {
                    $arr_meta_ins[2]['user_id']     = $obj_user->id;
                    $arr_meta_ins[2]['meta_key']    = 'company';
                    $arr_meta_ins[2]['meta_value']  = $request->input('u_company');
                }

                if(!empty($arr_meta_ins)) {
                    $this->UserMetaModel->insert($arr_meta_ins);
                }

                if($request->has('lead_id') && $request->input('lead_id') != '') {
                    $this->LeadsModel->where('id', $request->input('lead_id'))->delete();
                }

                $arr_data['first_name'] = $request->input('u_first_name');
                $arr_data['last_name']  = $request->input('u_last_name');
                $arr_data['address']    = $request->input('u_address');
                $arr_data['city']       = $request->input('u_city');
                $arr_data['state']      = $request->input('u_state');
                $arr_data['postal_code']= $request->input('u_zip_code');    

                $this->CustomerService->store($arr_data);
                
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.customer')." ".trans('added_successfully');
            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
            }
        }

        return response()->json($arr_resp, 200);
    }

    public function get_lead_details(Request $request) {

        $enc_id = $request->input('enc_id');
        $id = base64_decode($enc_id);

        $arr_lead = $arr_resp = [];

        $obj_leads = $this->LeadsModel
                                    ->where('id', $id)
                                    ->with(['assigned_to'])
                                    ->first();

        if($obj_leads) {

            $arr_resp['status']     = 'success';
            $arr_resp['data']       = $obj_leads->toArray();
            $arr_resp['message']    = trans('admin.data_found');

        }else{
            $arr_resp['status']     = 'error';
            $arr_resp['message']    = trans('admin.data_not_found');
        }

        return response()->json($arr_resp, 200);
    }

    public function update_lead($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_lead = $this->LeadsModel->where('id', $id)->first();

        if($obj_lead) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['lead_status']   = "required";
            $arr_rules['source']        = "required";
            $arr_rules['name']          = "required";

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) 
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                if($request->input('contacted_today')) {
                    $contacted_date = date('Y-m-d');
                }else{
                    $contacted_date = $request->input('contact_date');
                }

                $arr_ins = [];

                $arr_ins['status']          = $request->input('lead_status');
                $arr_ins['source']          = $request->input('source');
                $arr_ins['assigned']        = $request->input('assigned_to');
                $arr_ins['name']            = $request->input('name');
                $arr_ins['email']           = $request->input('email');
                $arr_ins['address']         = $request->input('address');
                $arr_ins['position']        = $request->input('position');
                $arr_ins['city']            = $request->input('city');
                $arr_ins['state']           = $request->input('state');
                $arr_ins['website']         = $request->input('website');
                $arr_ins['zip_code']        = $request->input('zip_code');
                $arr_ins['country']         = 1;
                $arr_ins['phone']           = $request->input('phone');
                $arr_ins['company']         = $request->input('company');
                $arr_ins['description']     = $request->input('description');
                $arr_ins['contacted_date']  = $contacted_date;
                $arr_ins['user_id']         = $this->auth->user()->id;

                if($this->LeadsModel->where('id', $id)->update($arr_ins)) {
                    $arr_resp['status']         = 'success';
                    $arr_resp['message']        = trans('admin.lead')." ".trans('admin.updated_successfully');
                }else{
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.error_msg');
                }
            }
        }else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

    public function get_lead_details_html(Request $request) {

        $enc_id = $request->input('enc_id');
        $id = base64_decode($enc_id);

        $arr_lead = $arr_resp = [];

        $obj_leads = $this->LeadsModel
                                    ->where('id', $id)
                                    ->with(['assigned_to'])
                                    ->first();

        if($obj_leads) {

            $this->arr_view_data['arr_lead']       = $obj_leads->toArray();

            // dd($obj_leads->toArray());

            $html = view($this->module_view_folder.'.lead_details_modal_html',$this->arr_view_data)->render();

            $arr_resp['status'] = 'success';
            $arr_resp['html'] = $html;
            $arr_resp['message'] = trans('admin.data_found');

        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.data_not_found');
        }

        return response()->json($arr_resp, 200);
    }

    public function view($enc_id,Request $request) {
        //dd($request->page);
        $arr_orders = [];

        $id = base64_decode($enc_id);

        $obj_cust = $this->UserModel->whereHas('role', function(){})
                                    ->where('id', $id)
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->with('user_meta')
                                    ->first();

        if($obj_cust) {

            $arr_data = $obj_cust->toArray();

            if(isset($arr_data['user_meta']) && !empty($arr_data['user_meta'])) {
                foreach($arr_data['user_meta'] as $meta) {
                    $arr_data[($meta['meta_key']??'')] = $meta['meta_value']??'';
                }
            }
            unset($arr_data['user_meta']);

            $obj_orders = $this->OrdersModel->whereHas('invoice', function(){})
                                            ->with(['ord_details','invoice'])
                                            ->where('cust_id',$id)
                                            ->get();
            if($obj_orders)
            {
                $arr_orders = $obj_orders->toArray();
            }

            if($request->page!='' && $request->page == 'contacts')
            {
                $arr_contact = $this->get_all_contact($id);
                $this->arr_view_data['module_url_path'] = $this->module_url_path; 
                $this->arr_view_data['arr_contact'] = $arr_contact; 
            }
            elseif($request->page!='' && $request->page == 'account')
            {
                $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

                if($obj_pay_methods->count() > 0) {
                    $arr_pay_methods = $obj_pay_methods->toArray();
                }
                $arr_contract = $this->get_all_contract($id);
                
                $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods??[];
                $this->arr_view_data['arr_contract']    = $arr_contract??[];
            }
            elseif($request->page!='' && $request->page == 'invoices')
            {
                $arr_invoices = $this->get_all_invoice($id);
                $this->arr_view_data['arr_invoices'] = $arr_invoices;
            }
            elseif($request->page!='' && $request->page == 'payments')
            {
                $arr_pay_methods = [];
                $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

                if($obj_pay_methods->count() > 0) {
                    $arr_pay_methods = $obj_pay_methods->toArray();
                }

                $this->arr_view_data['arr_inv_pay']     = $this->get_all_payments($id);
                $this->arr_view_data['arr_contract']    = $this->get_all_contract($id);
                $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;
                $this->arr_view_data['id'] = $id;
            }
            elseif($request->page!='' && $request->page == 'proposals')
            {
                $arr_props = $this->get_all_proposals($id);
                $this->arr_view_data['arr_props'] = $arr_props;
            }
            elseif($request->page!='' && $request->page == 'estimates')
            {
                $arr_estim = $this->get_all_estimates($id);
                $this->arr_view_data['arr_estim'] = $arr_estim;
            }
            else
            {
                $this->arr_view_data['arr_orders']  = $arr_orders;
                $this->arr_view_data['arr_cust']    = $arr_data;
            }
            
            $this->arr_view_data['arr_cust']    = $arr_data;
            $this->arr_view_data['enc_id']      = $enc_id;
            $this->arr_view_data['page_title']  = $this->module_title;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }else{
            Session::flash('error','Invalid Request!');
            return redirect()->back();
        }
    }

    public function get_all_contact($id)
    {
        $arr_conatct = [];
        $obj_conatct = $this->UserModel->whereHas('cust_contact',function($qry)use($id){
                                        $qry->where('cust_id',$id);
                                  })
                                  ->with(['cust_contact'])
                                  ->where('role_id',config('app.roles_id.contact'))
                                  ->get();
        if($obj_conatct)
        {
            $arr_conatct = $obj_conatct->toArray();
        }

        return $arr_conatct;
    }

    public function get_all_contract($id)
    {
        $arr_contract = [];
        $obj_contract = $this->SalesContractModel->whereHas('contr_details', function(){})
                                                 ->where('cust_id',$id)
                                                 ->get();
        if($obj_contract)
        {
            $arr_contract = $obj_contract->toArray();
        }

        return $arr_contract;
    }

    public function get_all_invoice($id)
    {
        $arr_invoices = [];
        $obj_invoice = $this->SalesInvoiceModel->whereHas('order', function($q)use($id){
                                        $q->where('cust_id',$id);
                                    })
                                    ->with(['order','order.ord_details'])
                                    ->get();

        if($obj_invoice->count() > 0) {
            $arr_invoices = $obj_invoice->toArray();
        }

        return $arr_invoices;
    }

    public function get_all_payments($id)
    {
        $arr_inv_pay = [];
        $obj_inv_pay = $this->TransactionsModel->whereHas('pay_method_details', function(){})
                                    ->with(['invoice.order'=>function($qry)use($id){
                                        $qry->where('cust_id',$id);
                                    },'contract'=>function($qry)use($id){
                                        $qry->where('cust_id',$id);
                                    },'pay_method_details'])
                                    ->where('user_id',$id)
                                    ->get();

        if($obj_inv_pay->count() > 0) {
            $arr_inv_pay = $obj_inv_pay->toArray();
        }
        return $arr_inv_pay;
    }

    public function get_all_proposals($id)
    {
        $arr_props = [];
        $obj_props = $this->SalesProposalModel->whereHas('prop_details', function(){})
                                              ->whereHas('cust_details', function(){})
                                              ->with(['prop_details'])
                                              ->where('cust_id',$id)
                                              ->get();
        if($obj_props)
        {
            $arr_props = $obj_props->toArray();
        }

        return $arr_props;
    }

    public function get_all_estimates($id)
    {
        $arr_estim = [];
        $obj_estim = $this->SalesEstimateModel->where('cust_id',$id)->get();
        if($obj_estim)
        {
            $arr_estim = $obj_estim->toArray();
        }

        return $arr_estim;
    }

    public function edit($enc_id)
    {
        if($enc_id!='')
        {
            $id = base64_decode($enc_id);
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg'] = trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->UserModel->with('user_meta')->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();

            if(isset($arr_data['user_meta']) && !empty($arr_data['user_meta'])) {
                foreach($arr_data['user_meta'] as $meta) {
                    $arr_data[($meta['meta_key']??'')] = $meta['meta_value']??'';
                }
            }

            unset($arr_data['user_meta']);
        }

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data'] = $arr_data;
            $arr_response['msg'] = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg'] = trans('admin.somthing_went_wrong_try_agin');
        }

        return response()->json($arr_response);
    }

    public function update($enc_id, Request $request) {

        $id = base64_decode($enc_id);
        $obj_cust = $this->UserModel->where('id', $id)->first();

        if($obj_cust){

            $arr_rules                  = $arr_resp = array();
            $arr_rules['u_first_name']  = "required";
            $arr_rules['u_last_name']   = "required";
            // $arr_rules['u_email']       = "required|email|unique:users,email,".$id;
            $arr_rules['u_company']     = "required";

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) 
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{

                $arr_ins = $arr_meta_ins = [];

                $arr_ins['role_id']         = config('app.roles_id.customer');
                $arr_ins['first_name']      = $request->input('u_first_name');
                $arr_ins['last_name']       = $request->input('u_last_name');
                // $arr_ins['email']           = $request->input('u_email');
                $arr_ins['mobile_no']       = $request->input('u_phone');
                $arr_ins['address']         = $request->input('u_address');
                $arr_ins['city']            = $request->input('u_city');
                $arr_ins['state']           = $request->input('u_state');
                $arr_ins['postal_code']     = $request->input('u_zip_code');

                if($request->has('u_password') && $request->input('u_password')!='') {
                    $arr_ins['password']        = \Hash::make($request->input('u_password'));
                }

                if($this->UserModel->where('id', $id)->update($arr_ins)) {

                    $arr_meta_ins = [];
                    if($request->has('u_website') && $request->input('u_website')!='') {
                        $arr_meta_ins[1]['user_id'] = $id;
                        $arr_meta_ins[1]['meta_key'] = 'website';
                        $arr_meta_ins[1]['meta_value'] = $request->input('u_website');
                    }
                    if($request->has('u_company') && $request->input('u_company')!='') {
                        $arr_meta_ins[2]['user_id'] = $id;
                        $arr_meta_ins[2]['meta_key'] = 'company';
                        $arr_meta_ins[2]['meta_value'] = $request->input('u_company');
                    }

                    $this->UserMetaModel->where('user_id', $id)
                                        ->whereIn('meta_key', ['website','company'])
                                        ->delete();

                    if(!empty($arr_meta_ins)) {
                        $this->UserMetaModel->insert($arr_meta_ins);
                    }

                    if($request->has('lead_id') && $request->input('lead_id') != '') {
                        $this->LeadsModel->where('id', $request->input('lead_id'))->delete();
                    }

                    $arr_resp['status']         = 'success';
                    $arr_resp['message']        =  trans('admin.customer')." ".trans('admin.updated_successfully');;
                }else{
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.error_msg');
                }
            }
        }
        else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

    public function update_address($enc_id, Request $request) {

        $id = base64_decode($enc_id);
        $obj_cust = $this->UserModel->where('id', $id)->first();

        if($obj_cust){
            $arr_req = $request->all();
            unset($arr_req['_token']);
            if(!empty($arr_req)) {
                $arr_meta_ins = [];
                $i=0;
                foreach($arr_req as $meta => $value) {
                    $arr_meta_ins[$i]['user_id'] = $id;
                    $arr_meta_ins[$i]['meta_key'] = $meta;
                    $arr_meta_ins[$i]['meta_value'] = $value;
                    $i++;
                }

                $this->UserMetaModel->where('user_id', $id)
                                        ->whereIn('meta_key', array_keys($arr_req))
                                        ->delete();

                if(!empty($arr_meta_ins)) {
                    $this->UserMetaModel->insert($arr_meta_ins);
                }
            }
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.data_found');
        }
        else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);

    }

    public function cust_contact_store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['first_name'] = 'required';
        $arr_rules['last_name']  = 'required';
        // $arr_rules['email']      = 'required';
        $arr_rules['mobile_no']  = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
        }

        // $email = $request->input('email');
        // $is_exist_email = $this->UserModel->where('email',$email)->count();
        // if($is_exist_email > 0)
        // {
        //     $arr_resp['status']         = 'error';
        //     $arr_resp['message']        = "Email already exist.";
        //     return response()->json($arr_resp, 200);
        // }

        $arr_data['role_id']    = config('app.roles_id.contact');
        $arr_data['first_name'] = $request->input('first_name');
        $arr_data['last_name']  = $request->input('last_name');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        // $arr_data['email']      = $request->input('email');
        // $arr_data['password']   = \Hash::make($request->input('password'));
        $arr_data['is_active']  = '1';

        if($obj_contact = $this->UserModel->create($arr_data))
        {
            $arr_contact_details['cust_id']       = base64_decode($request->input('enc_id'));
            $arr_contact_details['user_id']       = $obj_contact->id;
            $arr_contact_details['role_position'] = $request->input('role_position');

            $this->CustomerContactModel->insert($arr_contact_details);

            $arr_resp['status']  = 'success';
            $arr_resp['message'] = 'Stored successfully !';
        }
        else
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.driver_add_error');
        }
        return response()->json($arr_resp, 200);
    }

    public function cust_contact_edit($enc_id)
    {
        if($enc_id !='')
        {
            $id = base64_decode($enc_id);
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->UserModel->with(['cust_contact'])->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data']   = $arr_data;
            $arr_response['msg']    = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.somthing_went_wrong_try_agin'); 
        }

        return response()->json($arr_response);
    }

    public function cust_contact_update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_cust = $this->UserModel->where('id', $id)->first();
        $user_id = $obj_cust->id;

        if($obj_cust){

            $arr_rules  = $arr_resp = array();

            $arr_rules['first_name'] = 'required';
            $arr_rules['last_name']  = 'required';
            $arr_rules['email']      = 'required';
            $arr_rules['mobile_no']  = 'required';
            if($request->has('password') && $request->input('password') != '') {
                $arr_rules['password']  = 'required';
                $arr_rules['confirm_password']  = 'required|same:password';
            }

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }
            $email = $request->input('email');
            $is_exist_email = $this->UserModel->where('id','<>',$id)
                                              ->where('email',$email)
                                              ->count();
            if($is_exist_email > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = "Email already exist !";
                return response()->json($arr_resp, 200);
            }

            $arr_data['first_name'] = $request->input('first_name');
            $arr_data['last_name']  = $request->input('last_name');
            $arr_data['mobile_no']  = $request->input('mobile_no');
            $arr_data['email']      = $email;
            if($request->has('password') && $request->input('password') != '') {
               $arr_data['password']   = \Hash::make($request->input('password'));
            }

            if($obj_cust->update($arr_data))
            {
                $role_position = $request->input('role_position');
                $this->CustomerContactModel->where('cust_id',$user_id)->update(['role_position'=>$role_position]);

                $arr_resp['status']  = 'success';
                $arr_resp['message'] = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.error_msg');
            }
        }
        else{

            $arr_resp['status']      = 'error';
            $arr_resp['message']     = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);    
    }

    public function enableDisableCust($enc_id, Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_cust = $this->UserModel->where('id', $id)->first();
        $inputStatus = $request['is_enable'] ?? '';
        $status = $inputStatus === '0' ? '1' : '0';
        if ($obj_cust) {
            $updated = $this->UserModel->where('id', $id)->update(['is_active' => $status]);
            if ($updated) {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        =  trans('admin.customer') . " " . trans('admin.updated_successfully');;
            } else {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
            }
        } else {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

}

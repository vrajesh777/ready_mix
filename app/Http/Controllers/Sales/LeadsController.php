<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\Common\Services\EmailService;
use App\Models\User;
use App\Models\LeadsModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;

class LeadsController extends Controller
{
    public function __construct()
    {
        $this->UserModel            = new User;
        $this->LeadsModel           = new LeadsModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Admin";
        $this->module_view_folder   = "sales.leads";
        // $this->EmailService         = new EmailService();
    }

    public function index() {

        $arr_leads = $arr_sales_user = [];

        $obj_leads = $this->LeadsModel
                                    ->with(['assigned_to'])
                                    ->get();

        if($obj_leads->count() > 0) {
            $arr_leads = $obj_leads->toArray();
        }

        // dd($arr_leads);

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->where('role_id', $this->auth->user()->role_id)
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_sales_user = $obj_users->toArray();
        }

        $this->arr_view_data['arr_leads']       = $arr_leads;
        $this->arr_view_data['arr_sales_user']  = $arr_sales_user;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create_lead(Request $request) {

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

            if($this->LeadsModel->insert($arr_ins)) {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.leads_create_success');
            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.leads_create_error');
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

            $arr_resp['status'] = 'success';
            $arr_resp['data'] = $obj_leads->toArray();
            $arr_resp['message'] = trans('admin.data_found');

        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.data_not_found');
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
                    $arr_resp['message']        = trans('admin.leads_update_success');
                }else{
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.leads_update_error');
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
}

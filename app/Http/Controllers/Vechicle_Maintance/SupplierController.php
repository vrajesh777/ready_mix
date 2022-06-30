<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\User;
use App\Models\PaymentMethodsModel;
use App\Models\TransactionsModel;
use App\Models\UserMetaModel;
use App\Common\Services\TranscationService;

use Validator;
use Session;
use Auth;

class SupplierController extends Controller
{
	use MultiActionTrait;
	public function __construct()
	{
        $this->UserModel           = new User();
        $this->BaseModel           = $this->UserModel;
        $this->PaymentMethodsModel = new PaymentMethodsModel;
        $this->TransactionsModel   = new TransactionsModel;
        $this->TranscationService  = new TranscationService;
        $this->UserMetaModel       = new UserMetaModel;
        //$this->RolesModel        = new RolesModel;
        //$this->DepartmentsModel  = new DepartmentsModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.supplier');
        $this->module_view_folder   = "vechicle_maintance.supplier";
        $this->module_url_path      = url('/vc_part_suppy');
        $this->department_id      = config('app.dept_id.vechicle_maintance');
	}

	public function index(Request $request)
    {
    	$arr_data = [];

    	$obj_data = $this->BaseModel->where('role_id',config('app.roles_id.vechicle_parts_supplier'))
    						        ->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

        $this->arr_view_data['arr_data']        = $arr_data;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['first_name'] = 'required';
        $arr_rules['last_name']  = 'required';
        $arr_rules['email']      = 'required|email|unique:users,email';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            if($request->ajax()) {
                return response()->json($arr_resp, 200);
            }else{
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
        }

        $email = $request->input('email');
        $is_exist_email = $this->BaseModel->where('email',$email)->count();
        if($is_exist_email > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.email')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
        }

        $arr_data['role_id']    = config('app.roles_id.vechicle_parts_supplier');
        $arr_data['first_name'] = $request->input('first_name');
        $arr_data['last_name']  = $request->input('last_name');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        $arr_data['email']      = $email;
        $arr_data['password']   = \Hash::make($request->input('password'));
        $arr_data['is_active']  = '1';
        $arr_data['department_id']  = config('app.dept_id.vechicle_maintance');

        if($obj_user = $this->BaseModel->create($arr_data)) {

            $arr_meta_ins[1]['user_id']    = $obj_user->id;
            $arr_meta_ins[1]['meta_key']   = 'company';
            $arr_meta_ins[1]['meta_value'] = $request->input('company');

            $arr_meta_ins[2]['user_id']    = $obj_user->id;
            $arr_meta_ins[2]['meta_key']   = 'phone';
            $arr_meta_ins[2]['meta_value'] = $request->input('phone');

            $arr_meta_ins[3]['user_id']    = $obj_user->id;
            $arr_meta_ins[3]['meta_key']   = 'vat_number';
            $arr_meta_ins[3]['meta_value'] = $request->input('vat_number');

            $this->UserMetaModel->insert($arr_meta_ins);

            if($request->ajax()) {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.supplier')." ".trans('admin.added_successfully');
                return response()->json($arr_resp, 200);
            }else{
                Session::flash('success',trans('admin.supplier').' '.trans('admin.added_successfully'));
                return redirect()->route('vc_part_suppy');
            }
        }else{
            if($request->ajax()) {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
                return response()->json($arr_resp, 200);
            }else{
                Session::flash('error',trans('admin.error_msg'));
                return redirect()->back();
            }
        }
    }

    public function edit($enc_id, Request $request)
    {
        $id = base64_decode($enc_id);

        $arr_data = [];
        $obj_data = $this->BaseModel->where('id',$id)->with('user_meta')->first();
        if($obj_data){

            $arr_data = $obj_data->toArray();

            if($request->ajax()) {
                $arr_resp_data['id']          = $arr_data['id']??'';
                $arr_resp_data['first_name']  = $arr_data['first_name']??'';
                $arr_resp_data['last_name']   = $arr_data['last_name']??'';
                $arr_resp_data['email']       = $arr_data['email']??'';
                $arr_resp_data['mobile_no']   = $arr_data['mobile_no']??'';
                $arr_resp_data['role_id']     = $arr_data['role_id']??'';
                $arr_resp_data['address']     = $arr_data['address']??'';
                $arr_resp_data['city']        = $arr_data['city']??'';
                $arr_resp_data['state']       = $arr_data['state']??'';
                $arr_resp_data['postal_code'] = $arr_data['postal_code']??'';
                $arr_resp_data['user_meta']   = $arr_data['user_meta']??'';
                $arr_response['status']       = 'SUCCESS';
                $arr_response['data']         = $arr_resp_data;
                $arr_response['msg']          = trans('admin.data_found');
                return response()->json($arr_response);
            }else{

                $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.customer'),config('app.roles_id.vechicle_parts_supplier')];

                $obj_users = $this->BaseModel->whereHas('role', function(){})
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->where('is_active', '1')->with('user_meta')->get();
                $arr_users = $obj_users->count() > 0 ? $obj_users->toArray() : [];

                $obj_depts = $this->DepartmentsModel->get();
                $arr_depts = $obj_depts->count() > 0 ? $obj_depts->toArray() : [];

                $obj_designs = $this->DesignationsModel->get();
                $arr_designs = $obj_designs->count() > 0 ? $obj_designs->toArray() : [];

                $obj_roles = $this->RolesModel->whereNotIn('id',$arr_exclude)->get();
                $arr_roles = $obj_roles->count() > 0 ? $obj_roles->toArray() : [];

                $this->arr_view_data['arr_users']       = $arr_users;
                $this->arr_view_data['arr_depts']       = $arr_depts;
                $this->arr_view_data['arr_designs']     = $arr_designs;
                $this->arr_view_data['arr_roles']       = $arr_roles;
                $this->arr_view_data['arr_user']        = $arr_data;

                $this->arr_view_data['module_title']    = $this->module_title;
                $this->arr_view_data['page_title']      = 'Edit '.$this->module_title;
                $this->arr_view_data['module_url_path'] = $this->module_url_path;

                return view($this->module_view_folder.'.edit',$this->arr_view_data);
            }

        }else{
            if($request->ajax()) {
                $arr_response['status'] = 'ERROR';
                $arr_response['msg'] = trans('admin.error_msg');
                return response()->json($arr_response);
            }else{
                Session::flash('success',trans('admin.invalid_request'));
                return redirect()->back();
            }
        }
    }

    public function update($enc_id, Request $request)
    {
        $arr_rules = $arr_resp = array();

        $id = base64_decode($enc_id);
        $obj_user = $this->BaseModel->where('id', $id)->first();

        if($obj_user) {
            $arr_rules['first_name'] = 'required';
            $arr_rules['last_name']  = 'required';
            $arr_rules['email']      = 'required|email|unique:users,email,'.$id;
            if($request->has('password') && $request->input('password') != '') {
                $arr_rules['password']  = 'required';
                $arr_rules['confirm_password']  = 'required|same:password';
            }

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails()) {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                if($request->ajax()) {
                    return response()->json($arr_resp, 200);
                }else{
                    return redirect()->back()->withErrors($validator)->withInput($request->all());
                }
            }

            $email = $request->input('email');

            //$arr_data['role_id']   = $request->input('role_id');
            $arr_data['first_name']  = $request->input('first_name');
            $arr_data['last_name']   = $request->input('last_name');
            $arr_data['mobile_no']   = $request->input('mobile_no');
            $arr_data['address']     = $request->input('address');
            $arr_data['city']        = $request->input('city');
            $arr_data['state']       = $request->input('state');
            $arr_data['postal_code'] = $request->input('postal_code');
            $arr_data['email']       = $email;
            $arr_data['address']     = $request->input('address');
            $arr_data['city']        = $request->input('city');
            $arr_data['state']       = $request->input('state');
            $arr_data['postal_code'] = $request->input('postal_code');
            
            if($request->has('password') && $request->input('password') != '') {
               $arr_data['password']   = \Hash::make($request->input('password'));
            }
            $arr_data['is_active']  = '1';
            if($this->BaseModel->where('id', $id)->update($arr_data)) {

                $arr_meta_ins[1]['user_id']    = $id;
                $arr_meta_ins[1]['meta_key']   = 'company';
                $arr_meta_ins[1]['meta_value'] = $request->input('company');

                $arr_meta_ins[2]['user_id']    = $id;
                $arr_meta_ins[2]['meta_key']   = 'phone';
                $arr_meta_ins[2]['meta_value'] = $request->input('phone');

                $arr_meta_ins[3]['user_id']    = $id;
                $arr_meta_ins[3]['meta_key']   = 'vat_number';
                $arr_meta_ins[3]['meta_value'] = $request->input('vat_number');

                $this->UserMetaModel->where('user_id',$id)->delete();
                $this->UserMetaModel->insert($arr_meta_ins);

                if($request->ajax()) {
                    $arr_resp['status']         = 'success';
                    $arr_resp['message']        = trans('admin.supplier')." ".trans('admin.updated_successfully');
                    return response()->json($arr_resp, 200);
                }else{
                    Session::flash('success',trans('admin.supplier')." ".trans('admin.updated_successfully'));
                    return redirect()->route('vc_part_suppy');
                }
            }else{
                if($request->ajax()) {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.error_msg');
                    return response()->json($arr_resp, 200);
                }else{
                    Session::flash('error',trans('admin.error_msg'));
                    return redirect()->back();
                }
            }
        }

    }

    public function view($enc_id,Request $request) {
        //dd($request->page);
        $arr_orders = [];

        $id = base64_decode($enc_id);

        $obj_supplier = $this->UserModel->whereHas('role', function(){})
                                    ->where('id', $id)
                                    ->where('role_id', config('app.roles_id.vechicle_parts_supplier'))
                                    ->first();

        if($obj_supplier) {

            $arr_data = $obj_supplier->toArray();

            /*$obj_orders = $this->OrdersModel->whereHas('invoice', function(){})
                                            ->with(['ord_details','invoice'])
                                            ->where('cust_id',$id)
                                            ->get();
            if($obj_orders)
            {
                $arr_orders = $obj_orders->toArray();
            }*/

            /*if($request->page!='' && $request->page == 'contacts')
            {
                $arr_contact = $this->get_all_contact($id);
                $this->arr_view_data['module_url_path'] = $this->module_url_path; 
                $this->arr_view_data['arr_contact'] = $arr_contact; 
            }*/
           /* elseif($request->page!='' && $request->page == 'account')
            {
                $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

                if($obj_pay_methods->count() > 0) {
                    $arr_pay_methods = $obj_pay_methods->toArray();
                }
                $arr_contract = $this->get_all_contract($id);
                
                $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;
                $this->arr_view_data['arr_contract']    = $arr_contract;
            }
            elseif($request->page!='' && $request->page == 'invoices')
            {
                $arr_invoices = $this->get_all_invoice($id);
                $this->arr_view_data['arr_invoices'] = $arr_invoices;
            }*/
            /*if($request->page!='' && $request->page == 'payments')
            {*/
                $arr_pay_methods = [];
                $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

                if($obj_pay_methods->count() > 0) {
                    $arr_pay_methods = $obj_pay_methods->toArray();
                }

                $this->arr_view_data['arr_trans']     = $this->get_all_transaction($id);
                $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;
                $this->arr_view_data['id'] = $id;
            /*}*/
            
            $this->arr_view_data['arr_cust']    = $arr_data;
            $this->arr_view_data['enc_id']      = $enc_id;
            $this->arr_view_data['page_title']  = $this->module_title;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }else{
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }
    }

    public function get_all_transaction($id)
    {
        $arr_trans = [];
        $obj_trans = $this->TransactionsModel->with(['vechicle_pur_order'])
                                             ->where('user_id',$id)
                                             ->where('dept_id',$this->department_id)
                                             ->get();
        if($obj_trans)
        {
            $arr_trans = $obj_trans->toArray();
        }

        return $arr_trans;
    }

    public function add_vc_supplier_payment(Request $request)
    {
        $arr_rules                  = $arr_resp = array();
        $arr_rules['amount']        = "required";
        $arr_rules['pay_method_id'] = "required";
        $arr_rules['pay_date']      = 'required';
        
        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            Session::flash('error',trans('admin.validation_error_msg'));
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
        $arr_store['contract_id']   = '';
        $arr_store['amount']        = $request->input('amount');
        $arr_store['type']          = 'credit';
        $arr_store['pay_method_id'] = $request->input('pay_method_id');
        $arr_store['pay_date']      = $request->input('pay_date');
        $arr_store['trans_no']      = $trans_id;
        $arr_store['note']          = $request->input('note');
        $arr_store['dept_id']        = config('app.dept_id.vechicle_maintance');

        if($this->TranscationService->store_payment($arr_store)) {
            Session::flash('success',trans('admin.payment_recorded_successfully'));
        }else{
            Session::flash('error',trans('admin.error_msg'));
        }
        return redirect()->back();
    }
}

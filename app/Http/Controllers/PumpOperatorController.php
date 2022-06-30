<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\User;
use App\Models\RolesModel;

use Validator;
use Session;
use Auth;

class PumpOperatorController extends Controller
{
    //pump_op
     use MultiActionTrait;
	public function __construct()
	{
        $this->UserModel = new User();
        $this->BaseModel = $this->UserModel;
        $this->RolesModel = new RolesModel();

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.pump_op');
        $this->module_view_folder   = "pump_op";
        $this->module_url_path      = url('/pump_op');
	}

    public function index()
    {
        $arr_data = [];

        $obj_data = $this->BaseModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->where('role_id', config('app.roles_id.pump_operator'))
                                    ->get();

        if($obj_data->count() > 0) {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data'] = $arr_data;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['first_name']      = 'required';
        $arr_rules['last_name']       = 'required';
        //$arr_rules['email']           = 'required';
        //$arr_rules['mobile_no']       = 'required';
        //$arr_rules['driving_licence'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
        }

        if($request->has('email') && $request->input('email')!=''){
            $email = $request->input('email');
            $is_exist_email = $this->BaseModel->where('email',$email)->count();
            if($is_exist_email > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.email_alredy_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['email']      = $email;
        } 

        if($request->has('id_number') && $request->input('id_number')!=''){
            $id_number = $request->input('id_number');
            $is_exist_id_number = $this->BaseModel->where('id_number',$id_number)->count();
            if($is_exist_id_number > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.id_num_alredy_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['id_number']  = $id_number;
        } 
        
        $role_id = config('app.roles_id.pump_operator');
        $arr_data['role_id']    = $role_id;
        $arr_data['first_name'] = $request->input('first_name');
        $arr_data['last_name']  = $request->input('last_name');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        
        $arr_data['password']   = \Hash::make(123456);
        $arr_data['is_active']  = '1';

        $status = $this->BaseModel->create($arr_data);
        if($status)
        {
            $obj_role = $this->RolesModel->where('id',$role_id)->first();
            $status->assignRole($obj_role->name);

            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.pump_operator').' '.trans('admin.added_successfully');
        }
        else
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.added_error').' '.trans('admin.pump_operator');
        }
        return response()->json($arr_resp, 200);
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
        $obj_data = $this->BaseModel->select('id','first_name','last_name','email','mobile_no','id_number')
        						    ->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
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

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_driver = $this->BaseModel->where('id', $id)->first();

        if($obj_driver){

            $arr_rules  = $arr_resp = array();

            $arr_rules['first_name'] = 'required';
	        $arr_rules['last_name']  = 'required';
	        //$arr_rules['email']      = 'required';
	        //$arr_rules['mobile_no']  = 'required';

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }

            if($request->has('email') && $request->input('email')!=''){
                $email = $request->input('email');
                $is_exist_email = $this->BaseModel->where('email',$email)
                                                  ->where('id','<>',$id)
                                                  ->count();
                if($is_exist_email > 0)
                {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.email_alredy_exist');
                    return response()->json($arr_resp, 200);
                }

                $arr_data['email']      = $email;
            } 

            if($request->has('id_number') && $request->input('id_number')!=''){
                $id_number = $request->input('id_number');
                $is_exist_id_number = $this->BaseModel->where('id_number',$id_number)
                                                      ->where('id','<>',$id)
                                                      ->count();
                if($is_exist_id_number > 0)
                {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.id_num_alredy_exist');
                    return response()->json($arr_resp, 200);
                }

                $arr_data['id_number']  = $id_number;
            } 

            $arr_data['first_name'] = $request->input('first_name');
	        $arr_data['last_name']  = $request->input('last_name');
	        $arr_data['mobile_no']  = $request->input('mobile_no');
	        //$arr_data['email']      = $email;
            $status = $this->BaseModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $obj_role = $this->RolesModel->where('id',$obj_driver->role_id)->first();
                $obj_driver->assignRole($obj_role->name);

                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.updated_error');
            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
        
    }
}

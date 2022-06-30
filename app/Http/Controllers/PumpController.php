<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\Traits\MultiActionTrait;

use App\Models\PumpModel;
use App\Models\User;

use Session;
use Validator;

class PumpController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
    	$this->PumpModel = new PumpModel();
    	$this->BaseModel = $this->PumpModel;
        $this->User      = new User;

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.pumps');
    	$this->module_view_folder = 'pumps';
    	$this->module_url_path    = url('/pumps');
    }

    public function index()
    {
    	$arr_data = $arr_helper = $arr_operator = $arr_operator_ids = $arr_helper_ids = $arr_driver = $arr_driver_ids = [];
    	$obj_data = $this->PumpModel->with(['operator','helper','driver'])->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();

            $arr_operator_ids = array_values(array_column($arr_data,'operator_id'));
            $arr_helper_ids   = array_values(array_column($arr_data,'helper_id'));
            $arr_driver_ids   = array_values(array_column($arr_data,'driver_id'));
    	}

        $obj_helper = $this->User->where('role_id', config('app.roles_id.pump_helper'))
                                    ->select('id','first_name','last_name')
                                    ->whereNotIn('id',$arr_helper_ids)
                                    ->get();
        // dd($obj_helper);

        if($obj_helper) {
            $arr_helper = $obj_helper->toArray();
        }

        $obj_operator = $this->User->where('role_id', config('app.roles_id.pump_operator'))
                                    ->select('id','first_name','last_name','id_number')
                                    ->whereNotIn('id',$arr_operator_ids)
                                    ->get();

        if($obj_operator) {
            $arr_operator = $obj_operator->toArray();
        }

        $arr_driver = [];

        $obj_driver = $this->User->where('role_id', config('app.roles_id.driver'))
                                ->select('id','first_name','last_name','id_number')
                                ->whereNotIn('id',$arr_driver_ids)
                                ->get();

        if($obj_driver->count() > 0) {
            $arr_driver = $obj_driver->toArray();
        }
        $this->arr_view_data['arr_data']         = $arr_data;
        $this->arr_view_data['arr_helper']       = $arr_helper;
        $this->arr_view_data['arr_operator']     = $arr_operator;
        $this->arr_view_data['arr_driver']       = $arr_driver;
        $this->arr_view_data['arr_operator_ids'] = $arr_operator_ids;
        $this->arr_view_data['arr_helper_ids']   = $arr_helper_ids;
        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();

    	$arr_rules['name']      = 'required';
    	$arr_rules['is_active'] = 'required';

    	$validator              = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.error_msg');
            return response()->json($arr_resp, 200);
    	}

    	$name    = $request->input('name');
    	$is_exit = $this->PumpModel->where('name',$name)->count();
    	if($is_exit)
    	{
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.already_exist');
    		return response()->json($arr_resp,200);
    	}

    	$arr_ins['name']         = $name;
    	$arr_ins['is_active']    = $request->input('is_active');
    	$arr_ins['lat']          = $request->input('lat');
    	$arr_ins['lng']          = $request->input('lng');
    	$arr_ins['location']     = trim($request->input('location'));
        $arr_ins['operator_id']  = $request->input('operator_id');
        $arr_ins['helper_id']    = $request->input('helper_id');
        $arr_ins['driver_id']    = $request->input('driver_id');
        
    	$status = $this->PumpModel->create($arr_ins);
    	if($status)
    	{
            $arr_resp['status']  = 'success';
            $arr_resp['message'] =  trans('admin.pump')." ".trans('admin.added_successfully');
    	}
    	else
    	{
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.error_msg');
    	}

    	return response()->json($arr_resp,200);
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
            $arr_response['msg']    = trans('admin.error_msg');
            return response()->json($arr_response);
        }

        $arr_data = $operator_id_ids = $helpers_id_ids = $arr_helper = $arr_operator = $arr_driver_ids = $arr_driver = [];
        $obj_data = $this->PumpModel->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $obj_all_op_pumps = $this->BaseModel->where('operator_id','<>',$arr_data['operator_id'])->select('operator_id')->get();
        if($obj_all_op_pumps)
        {
            $arr_all_op_pumps = $obj_all_op_pumps->toArray();
            $operator_id_ids = array_column($arr_all_op_pumps,'operator_id');
        }

        $obj_operator = $this->User->where('role_id', config('app.roles_id.pump_operator'))
                                    ->select('id','first_name','last_name','id_number')
                                    ->whereNotIn('id',$operator_id_ids)
                                    ->get();

        if($obj_operator) {
            $arr_operator = $obj_operator->toArray();
        }

        $obj_all_hp_pumps = $this->BaseModel->where('helper_id','<>',$arr_data['helper_id'])->select('helper_id')->get();
        if($obj_all_hp_pumps)
        {
            $arr_all_hp_pumps = $obj_all_hp_pumps->toArray();
            $helpers_id_ids = array_column($arr_all_hp_pumps,'helper_id');
        }

        $obj_helper = $this->User->where('role_id', config('app.roles_id.pump_helper'))
                                    //->select('id','first_name','last_name')
                                    ->whereNotIn('id',$helpers_id_ids)
                                    ->get();

        if($obj_helper) {
            $arr_helper = $obj_helper->toArray();
        }

        $obj_all_driver = $this->BaseModel->where('driver_id','<>',$arr_data['driver_id'])->select('driver_id')->get();
        if($obj_all_driver)
        {
            $arr_all_driver = $obj_all_driver->toArray();
            $driver_id_ids = array_column($arr_all_driver,'driver_id');
        }

        $obj_driver = $this->User->where('role_id', config('app.roles_id.driver'))
                                    //->select('id','first_name','last_name')
                                    ->whereNotIn('id',$driver_id_ids)
                                    ->get();

        if($obj_driver) {
            $arr_driver = $obj_driver->toArray();
        }

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
            $arr_data['arr_helper'] = $arr_helper;
            $arr_data['arr_operator'] = $arr_operator;
            $arr_data['arr_driver'] = $arr_driver;
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data']   = $arr_data;
            $arr_response['msg']    = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.error_msg'); 
        }

        return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_payment = $this->PumpModel->where('id',$id)->first();
        if($obj_payment)
        {
            $arr_rules = $arr_resp = array();

            $arr_rules['name']        = 'required';
            $arr_rules['is_active']   = 'required';
            $arr_rules['operator_id'] = 'required';
            $arr_rules['helper_id']   = 'required';

            $validator              = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_error_msg');
                return response()->json($arr_resp, 200);
            }

            $name    = $request->input('name');
            $is_exit = $this->PumpModel->where('name',$name)
                                                 ->where('id','<>',$id)
                                                 ->count();
            if($is_exit)
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.already_exist');
                return response()->json($arr_resp,200);
            }

            $arr_update['name']        = $name;
            $arr_update['is_active']   = $request->input('is_active');
            $arr_update['lat']         = $request->input('lat');
            $arr_update['lng']         = $request->input('lng');
            $arr_update['operator_id'] = $request->input('operator_id');
            $arr_update['helper_id']   = $request->input('helper_id');
            $arr_update['driver_id']   = $request->input('driver_id');
            $arr_update['location']    = trim($request->input('location'));

            $status = $this->PumpModel->where('id',$id)->update($arr_update);
            if($status)
            {
                $arr_resp['status']  = 'success';
                $arr_resp['message'] = trans('admin.pump').' '.trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] =  trans('admin.error_msg');
            }
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] =  trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }
}

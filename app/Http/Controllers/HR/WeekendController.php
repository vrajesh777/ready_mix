<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DepartmentsModel;
use App\Models\WeekendsModel;

use Session;
use Validator;
use Auth;

class WeekendController extends Controller
{
    public function __construct()
    {
    	$this->DepartmentsModel   = new DepartmentsModel();
    	$this->WeekendsModel      = new WeekendsModel();
    	$this->auth               = auth();
    	$this->arr_view_data      = [];
    	$this->module_title       = 'Weekends';
    	$this->module_view_folder = 'hr.weekends';
    	$this->module_url_path    = url('/weekends');
    }

    public function index()
    {
    	$arr_data = $arr_departments = [];

    	$obj_data = $this->WeekendsModel->get();
    	if($obj_data){
    		$arr_data = $obj_data->toArray();
    	}
    	
    	$obj_departments = $this->DepartmentsModel->get();
    	if($obj_departments)
    	{
    		$arr_departments = $obj_departments->toArray();
    	}

    	$this->arr_view_data['arr_departments'] = $arr_departments;
    	$this->arr_view_data['arr_data'] 		= $arr_data;
    	$this->arr_view_data['module_title']    = $this->module_title;
    	$this->arr_view_data['page_title']		= $this->module_title;
    	$this->arr_view_data['module_url_path']	= $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request){
    	$arr_rules          = $arr_resp = array();
    	$arr_rules['name']  = "required";
    	$arr_rules['depts'] = "required";
    	$arr_rules['days']  = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
        }
        
        $arr_ins['name']  = $request->input('name');
        $arr_ins['dept_id'] = json_encode($request->input('depts'));
        $arr_ins['days']  = json_encode($request->input('days'));

        $status = $this->WeekendsModel->create($arr_ins);
        if($status){
      		$arr_resp['status']    = 'success';
            $arr_resp['message']   = trans('admin.added_successfully');
        }else{
            $arr_resp['status']    = 'error';
            $arr_resp['message']   = trans('admin.error_occure');
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
            $arr_response['msg'] 	= trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
    	}

    	$arr_data = [];
    	$obj_data = $this->WeekendsModel->where('id',$id)->first();
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
    		$arr_response['msg']    = trans('admin.data_not_found');
    	}

    	return response()->json($arr_response);
    }

     public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_units = $this->WeekendsModel->where('id', $id)->first();

        if($obj_units){

        	$arr_rules          = $arr_resp = array();
	    	$arr_rules['name']  = "required";
	    	$arr_rules['depts'] = "required";
	    	$arr_rules['days']  = "required";

	        $validator = validator::make($request->all(),$arr_rules);

	        if($validator->fails()) 
	        {
	            $arr_resp['status']         = 'error';
	            $arr_resp['validation_err'] = $validator->messages()->toArray();
	            $arr_resp['message']        = trans('admin.validation_errors');
	        }
	        
	        $arr_data['name']  = $request->input('name');
	        $arr_data['dept_id'] = json_encode($request->input('depts'));
	        $arr_data['days']  = json_encode($request->input('days'));

        	$status = $this->WeekendsModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.added_successfully');
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    	
    }
}

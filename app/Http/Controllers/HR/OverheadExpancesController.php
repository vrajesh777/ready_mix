<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Common\Traits\MultiActionTrait;

use App\Models\OverheadExpancesModel;

use Validator;
use Session;

class OverheadExpancesController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
    	$this->OverheadExpancesModel = new OverheadExpancesModel();
        $this->BaseModel          = $this->OverheadExpancesModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.overhead_expances');
        $this->module_view_folder   = "hr.overhead_expances";
        $this->module_url_path      = url('/overhead_expances');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->OverheadExpancesModel->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

    	$this->arr_view_data['arr_data'] 		= $arr_data;
    	$this->arr_view_data['module_title']    = $this->module_title;
    	$this->arr_view_data['page_title']		= $this->module_title;
    	$this->arr_view_data['module_url_path']	= $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();

    	$arr_rules['name'] 	  = "required|unique:overhead_expances,name";
    	$arr_rules['type'] 	  = 'required';
    	$arr_rules['value']   = 'required';

    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
    	}

    	$name   = $request->input('name');
    	$type   = $request->input('type');
    	$value = $request->input('value');

    	$is_exist_code = $this->OverheadExpancesModel->where('name',$name)->count();
    	if($is_exist_code > 0)
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        =  trans('admin.already_exist');
            return response()->json($arr_resp, 200);
    	}

    	$arr_data['name']  = $name;
    	$arr_data['type']  = $type;
    	$arr_data['value'] = $value;

    	$status = $this->OverheadExpancesModel->create($arr_data);
    	if($status)
    	{
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.added_successfully');
    	}
    	else
    	{
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.error_msg');
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
    	$obj_data = $this->OverheadExpancesModel->where('id',$id)->first();
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
        $obj_units = $this->OverheadExpancesModel->where('id', $id)->first();

        if($obj_units){

        	$arr_rules = [];

			$arr_rules['name'] 	  = "required";
			$arr_rules['type'] 	  = 'required';
			$arr_rules['value']   = 'required';

        	$validator = Validator::make($request->all(),$arr_rules);
        	if($validator->fails())
        	{
        		$arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
        	}

        	$name    = $request->input('name');
        	$type    = $request->input('type');
        	$value 	 = $request->input('value');

        	$is_exist_code = $this->OverheadExpancesModel->where('id','<>',$id)
        											  ->where('name',$name)
        											  ->count();
        	if($is_exist_code > 0)
        	{
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.already_exist');
        	}

        	$arr_data['name']  = $name;
        	$arr_data['type']  = $type;
        	$arr_data['value'] = $value;

        	$status = $this->OverheadExpancesModel->where('id',$id)->update($arr_data);
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

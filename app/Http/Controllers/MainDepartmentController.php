<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;
use Illuminate\Support\Str;

use App\Models\ParentDepartmentModel;

use Validator;
use Session;

class MainDepartmentController extends Controller
{
     use MultiActionTrait;
    public function __construct()
    {
    	$this->ParentDepartmentModel = new ParentDepartmentModel();
        $this->BaseModel          = $this->ParentDepartmentModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.main_department');
        $this->module_view_folder   = "main_department";
        $this->module_url_path      = url('/main_department');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->ParentDepartmentModel->get();
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

    	$arr_rules['name'] 	= 'required';

    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
    	}

    	$name   = $request->input('name');
    	$slug   = Str::slug($name);
    	$is_slug = $this->ParentDepartmentModel->where('slug',$slug)->count();
    	if($is_slug > 0)
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        =  trans('admin.already_exist');
            return response()->json($arr_resp, 200);
    	}

    	$arr_data['name'] = $name;
    	$arr_data['slug'] = $slug;

    	$status = $this->ParentDepartmentModel->create($arr_data);
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
    	$obj_data = $this->ParentDepartmentModel->where('id',$id)->first();
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
        $obj_units = $this->ParentDepartmentModel->where('id', $id)->first();

        if($obj_units){

        	$arr_rules = [];

        	$arr_rules['name'] 	= 'required';
        	$validator = Validator::make($request->all(),$arr_rules);
        	if($validator->fails())
        	{
        		$arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
        	}

        	$name   	= $request->input('name');
        	$slug   	= Str::slug($name);
        	$name_exist = $this->ParentDepartmentModel->where('id','<>',$id)
        											  ->where('slug',$slug)
        											  ->count();
        	if($name_exist > 0)
        	{
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.already_exist');
        	}

        	$arr_data['name'] 		=  $name; 

        	$status = $this->ParentDepartmentModel->where('id',$id)->update($arr_data);
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

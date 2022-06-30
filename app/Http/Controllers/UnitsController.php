<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\PurchaseUnitsModel;

use Validator;
use Session;

class UnitsController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
    	$this->PurchaseUnitsModel = new PurchaseUnitsModel();
        $this->BaseModel          = $this->PurchaseUnitsModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.units');
        $this->module_view_folder   = "units";
        $this->module_url_path      = url('/units');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->PurchaseUnitsModel->get();
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

    	$arr_rules['unit_code'] 	= 'required';
    	$arr_rules['unit_name'] 	= 'required';
    	$arr_rules['unit_symbol'] 	= 'required';

    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
    	}

    	$unit_code   = $request->input('unit_code');
    	$unit_name   = $request->input('unit_name');
    	$unit_symbol = $request->input('unit_symbol');

    	$is_exist_code = $this->PurchaseUnitsModel->where('unit_code',$unit_code)->count();
    	if($is_exist_code > 0)
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        =  trans('admin.unit_code')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
    	}

    	$is_existd_name = $this->PurchaseUnitsModel->where('unit_name',$unit_name)->count();
    	if($is_existd_name > 0)
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.unit_name')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
    	}

    	$is_exist_symbol = $this->PurchaseUnitsModel->where('unit_symbol',$unit_symbol)->count();
    	if($is_exist_symbol > 0)
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.unit_symbol')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
    	}

    	$arr_data['unit_code'] 		=  $unit_code; 
    	$arr_data['unit_name'] 		=  $unit_name; 
    	$arr_data['unit_symbol'] 	=  $unit_symbol; 
    	$arr_data['note'] 	        =  trim($request->input('note'));

    	$status = $this->PurchaseUnitsModel->create($arr_data);
    	if($status)
    	{
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.unit')." ".trans('admin.added_successfully');
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
    	$obj_data = $this->PurchaseUnitsModel->where('id',$id)->first();
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
        $obj_units = $this->PurchaseUnitsModel->where('id', $id)->first();

        if($obj_units){

        	$arr_rules = [];

        	$arr_rules['unit_code'] 	= 'required';
        	$arr_rules['unit_name'] 	= 'required';
        	$arr_rules['unit_symbol'] 	= 'required';

        	$validator = Validator::make($request->all(),$arr_rules);
        	if($validator->fails())
        	{
        		$arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
        	}

        	$unit_code   	= $request->input('unit_code');
        	$unit_name   	= $request->input('unit_name');
        	$unit_symbol 	= $request->input('unit_symbol');

        	$is_exist_code = $this->PurchaseUnitsModel->where('id','<>',$id)
        											  ->where('unit_code',$unit_code)
        											  ->count();
        	if($is_exist_code > 0)
        	{
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.unit_code')." ".trans('admin.already_exist');
        	}

        	$is_existd_name = $this->PurchaseUnitsModel->where('id','<>',$id)
        											   ->where('unit_name',$unit_name)
        											   ->count();
        	if($is_existd_name > 0)
        	{
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.unit_name')." ".trans('admin.already_exist');
        	}

        	$is_exist_symbol = $this->PurchaseUnitsModel->where('id','<>',$id)
        												->where('unit_symbol',$unit_symbol)
        												->count();
        	if($is_exist_symbol > 0)
        	{
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.unit_symbol')." ".trans('admin.already_exist');
        	}

        	$arr_data['unit_code'] 		=  $unit_code; 
        	$arr_data['unit_name'] 		=  $unit_name; 
        	$arr_data['unit_symbol'] 	=  $unit_symbol; 
        	$arr_data['note'] 	        =  trim($request->input('note'));

        	$status = $this->PurchaseUnitsModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.units')." ".trans('admin.added_successfully');
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

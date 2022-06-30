<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\Traits\MultiActionTrait;

use App\Models\ItemModel;
use App\Models\TaxesModel;
use App\Models\PurchaseUnitsModel;
use App\Models\CommodityGroupsModel;
use App\Models\ItemImagesModel;

use Session;
use Validator;

class VechiclePartsController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
        $this->ItemModel            = new ItemModel();
        $this->BaseModel            = $this->ItemModel;

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.parts');
    	$this->module_view_folder = "vechicle_maintance.parts";
    	$this->module_url_path    = url('/vc_part');
        $this->department_id      = config('app.dept_id.vechicle_maintance');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->ItemModel->where('dept_id',$this->department_id)->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

        $this->arr_view_data['arr_data']            = $arr_data;

        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();
        $arr_rules['commodity_name'] = 'required';

    	$validator                      = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.validation_errors');

    		return response()->json($arr_resp);
    	}

    	$commodity_name = $request->input('commodity_name');
    	$is_exist = $this->ItemModel->where('commodity_name',$commodity_name)->count();
    	if($is_exist > 0)
    	{
    		$arr_resp['status'] = 'error';
    		$arr_resp['message'] = trans('admin.already_exist');

    		return response()->json($arr_resp);
    	}

        $arr_ins['commodity_name']      = $commodity_name;
        $arr_ins['dept_id']             = $this->department_id;
        $arr_ins['is_active']           = '1';
       
    	$status = $this->ItemModel->create($arr_ins);

    	if($status)
    	{
    		$arr_resp['status']  = 'success';
    		$arr_resp['message'] = trans('admin.added_successfully');
    	}
    	else
    	{
    		$arr_resp['status']  = 'error';
    		$arr_resp['message'] = trans('admin.error_msg');
    	}
    	return response()->json($arr_resp);
    }

    public function edit($enc_id)
    {
    	if($enc_id !='')
    	{
    		$id = base64_decode($enc_id);
    	}
    	else
    	{
    		$arr_response['status'] = 'ERROR';
            $arr_response['msg'] 	= trans('admin.validation_error_msg');
            return response()->json($arr_response);
    	}

    	$arr_data = [];
    	$obj_data = $this->ItemModel->where('id',$id)->first();
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
    		$arr_response['msg']    = trans('admin.error_msg');
    	}

    	return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
    	$id = base64_decode($enc_id);
    	$obj_data = $this->ItemModel->where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_rules = $arr_resp = array();

            $arr_rules['commodity_name'] = 'required';

            $validator                      = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');

                return response()->json($arr_resp);
            }

            $commodity_name = $request->input('commodity_name');
            $is_exist = $this->ItemModel->where('commodity_name',$commodity_name)
                                        ->where('id','<>',$id)
                                        ->count();
            if($is_exist > 0)
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.already_exist');

                return response()->json($arr_resp);
            }
            
            $arr_ins['commodity_name'] = $commodity_name;
            $arr_ins['dept_id']        = $this->department_id;
            $arr_ins['is_active']           = '1';
            
            $status = $this->ItemModel->where('id',$id)->update($arr_ins);
            if($status)
            {
                $arr_resp['status']  = 'success';
                $arr_resp['message'] = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.error_msg');
            }
    	}
    	else
    	{
    		$arr_resp['status']  = 'error';
	    	$arr_resp['message'] = trans('admin.invalid_request');
    	}

    	return response()->json($arr_resp);
    }
}

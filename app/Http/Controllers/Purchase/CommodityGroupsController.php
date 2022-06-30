<?php
namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\Traits\MultiActionTrait;

use App\Models\CommodityGroupsModel;

use Session;
use Validator;

class CommodityGroupsController extends Controller
{
	use MultiActionTrait;
    public function __construct()
    {
    	$this->CommodityGroupsModel = new CommodityGroupsModel();
    	$this->BaseModel            = $this->CommodityGroupsModel;

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.commodity_group');
    	$this->module_view_folder = "purchase.commodity_groups";
    	$this->module_url_path    = url('/commodity_groups');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->CommodityGroupsModel->get();
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
    	$arr_rules['name'] = 'required';
    	$arr_rules['is_active'] = 'required';
    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.validation_errors');

    		return response()->json($arr_resp);
    	}

    	$name = $request->input('name');
    	$slug = Str::slug($name);
    	$is_exist = $this->CommodityGroupsModel->where('slug',$slug)->count();
    	if($is_exist > 0)
    	{
    		$arr_resp['status'] = 'error';
    		$arr_resp['message'] = trans('admin.already_exist');

    		return response()->json($arr_resp);
    	}

    	$arr_ins['name'] = $name;
    	$arr_ins['slug'] = $slug;
    	$arr_ins['is_active'] = $request->input('is_active');

    	$status = $this->CommodityGroupsModel->create($arr_ins);
    	if($status)
    	{
    		$arr_resp['status']  = 'success';
    		$arr_resp['message'] = trans('admin.stored_successfully');
    	}
    	else
    	{
    		$arr_resp['status']  = 'error';
    		$arr_resp['message'] = trans('admin.prob_occured');
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
            $arr_response['msg'] 	= trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
    	}

    	$arr_data = [];
    	$obj_data = $this->CommodityGroupsModel->where('id',$id)->first();
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
    	$obj_data = $this->CommodityGroupsModel->where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_rules = $arr_resp = array();
	    	$arr_rules['name'] = 'required';
	    	$arr_rules['is_active'] = 'required';
	    	$validator = Validator::make($request->all(),$arr_rules);
	    	if($validator->fails())
	    	{
	    		$arr_resp['status']         = 'error';
	    		$arr_resp['validation_err'] = $validator->messages()->toArray();
	    		$arr_resp['message']        = trans('admin.validation_errors');

	    		return response()->json($arr_resp);
	    	}

	    	$name = $request->input('name');
	    	$slug = Str::slug($name);
	    	$is_exist = $this->CommodityGroupsModel->where('slug',$slug)
                                                   ->where('id','<>',$id)
                                                   ->count();
	    	if($is_exist > 0)
	    	{
	    		$arr_resp['status'] = 'error';
	    		$arr_resp['message'] = 'Already Exits !';

	    		return response()->json($arr_resp);
	    	}

	    	$arr_ins['name'] = $name;
	    	$arr_ins['slug'] = $slug;
	    	$arr_ins['is_active'] = $request->input('is_active');

	    	$status = $this->CommodityGroupsModel->where('id',$id)->update($arr_ins);
	    	if($status)
	    	{
	    		$arr_resp['status']  = 'success';
	    		$arr_resp['message'] = trans('admin.updated_successfully');
	    	}
	    	else
	    	{
	    		$arr_resp['status']  = 'error';
	    		$arr_resp['message'] = trans('admin.updated_error');
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

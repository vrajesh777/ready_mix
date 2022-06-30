<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\TaxesModel;

use Validator;
use Session;

class TaxesController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->TaxesModel = new TaxesModel();
        $this->BaseModel  = $this->TaxesModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.taxes');
        $this->module_view_folder   = "taxes";
        $this->module_url_path      = url('/taxes');
	}

    public function index()
    {
        $arr_data = [];
        $obj_data = $this->TaxesModel->get();
        if($obj_data)
        {
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

        $arr_rules['name']     = 'required';
        $arr_rules['tax_rate'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_error_msg');
            return response()->json($arr_resp, 200);
        }

        $name = $request->input('name');
        $is_exist_name = $this->TaxesModel->where('name',$name)->count();
        if($is_exist_name > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.tax')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
        }

        $arr_data['name']     = $name;
        $arr_data['tax_rate'] = $request->input('tax_rate');

        $status = $this->TaxesModel->create($arr_data);
        if($status)
        {
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.tax')." ".trans('admin.added_successfully');
        }
        else
        {
            $arr_resp['status']         = 'error';
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
            $arr_response['msg'] = trans('admin.error_msg');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->TaxesModel->select('id','name','tax_rate')->where('id',$id)->first();
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
            $arr_response['msg'] = trans('admin.error_msg');
        }

        return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_tax = $this->TaxesModel->where('id', $id)->first();

        if($obj_tax){

            $arr_rules  = $arr_resp = array();

            $arr_rules['name']     = 'required';
            $arr_rules['tax_rate'] = 'required';

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_error_msg');
                return response()->json($arr_resp, 200);
            }
            $name = $request->input('name');
            $is_exist_name = $this->TaxesModel->where('id','<>',$id)
                                              ->where('name',$name)
                                              ->count();
            if($is_exist_name > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.tax')." ".trans('admin.already_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['name']     = $name;
            $arr_data['tax_rate'] = $request->input('tax_rate');

            $status = $this->TaxesModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.tax')." ".trans('admin.updated_successfully');
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

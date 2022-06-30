<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\ManufacturerModel;

use Validator;
use Session;
use Auth;

class ManufacturerController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->ManufacturerModel = new ManufacturerModel();
        $this->BaseModel = $this->ManufacturerModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Manufacturer";
        $this->module_view_folder   = "vechicle_maintance.manufacturer";
        $this->module_url_path      = url('/manufacturer');

        $this->manufacturer_img_public_path = url('/').config('app.project.image_path.manufacturer_img');
        $this->manufacturer_img_base_path   = base_path().config('app.project.image_path.manufacturer_img');  
	}

    public function index()
    {
        $arr_data = [];

        $obj_data = $this->BaseModel->get();

        if($obj_data->count() > 0) {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data'] = $arr_data;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['manufacturer_img_public_path'] = $this->manufacturer_img_public_path;
        $this->arr_view_data['manufacturer_img_base_path'] = $this->manufacturer_img_base_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();
        $arr_rules['name']      = 'required';
     
        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
        }

        $name = $request->input('name');
        $is_exist_name = $this->BaseModel->where('name',$name)->count();
        if($is_exist_name > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.already_exist');
            return response()->json($arr_resp, 200);
        }

        $arr_data['name']  = $request->input('name');
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $file_name = $request->file('image');
            $file_extension = strtolower($image->getClientOriginalExtension());
            if(in_array($file_extension,['png','jpg','jpeg','pdf']))
            {
                $file_name                   = time().uniqid().'.'.$file_extension;
                $isUpload                    = $image->move($this->manufacturer_img_base_path , $file_name);
                $arr_data['image'] = $file_name;
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.invalid_file_type');
                return response()->json($arr_resp, 200);
            }
        }

        $status = $this->BaseModel->create($arr_data);
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
        $obj_data = $this->BaseModel->where('id',$id)->first();
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
        $obj_data = $this->BaseModel->where('id', $id)->first();

        if($obj_data){

            $arr_rules  = $arr_resp = array();

            $arr_rules['name'] = 'required';
	    
            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_error_msg');
                return response()->json($arr_resp, 200);
            }
            $name = $request->input('name');
            $is_exist_name = $this->BaseModel->where('id','<>',$id)
                                              ->where('name',$name)
                                              ->count();
            if($is_exist_name > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.already_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['name'] = $request->input('name');
            if($request->hasFile('image'))
            {
                $image = $request->file('image');
                $file_name = $request->file('image');
                $file_extension = strtolower($image->getClientOriginalExtension());
                if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                {
                    $file_name                   = time().uniqid().'.'.$file_extension;
                    $isUpload                    = $image->move($this->manufacturer_img_base_path , $file_name);
                    $arr_data['image'] = $file_name;
                }
                else
                {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.invalid_file_type');
                    return response()->json($arr_resp, 200);
                }
            }

            $status = $this->BaseModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.updated_successfully');
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

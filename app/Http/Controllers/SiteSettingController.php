<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSettingModel;

use Validator;
use Session;
class SiteSettingController extends Controller
{
    public function __construct()
    {
    	$this->SiteSettingModel = new SiteSettingModel();
    	$this->BaseModel        = $this->SiteSettingModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.site_setting');
        $this->module_url_path      = url('/site_setting');
    }

    public function index()
    {
    	$arr_data = [];
        $obj_data = $this->SiteSettingModel->where('id',1)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data'] = $arr_data;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view('site_setting',$this->arr_view_data);
    }

    public function update(Request $request)
    {
        $arr_rules                           = [];
        $arr_rules['enc_id']                 = 'required';
        $arr_rules['sales_with_workflow']    = 'required';
        $arr_rules['purchase_with_workflow'] = 'required';
        
        $validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		Session::flash('error',trans('admin.validation_error_msg'));
    		return redirect()->back()->withErrors($validator)->withInput($request->All());
    	}

        $id                                 = base64_decode($request->input('enc_id'));
        $arr_data['sales_with_workflow']    = $request->input('sales_with_workflow');
        $arr_data['purchase_with_workflow'] = $request->input('purchase_with_workflow');

    	$status = $this->SiteSettingModel->where('id',$id)->update($arr_data);
    	if($status)
    	{
    		Session::flash('success',trans('admin.site_setting').''.trans('admin.updated_successfully'));
    	}
    	else
    	{
    		Session::flash('error',trans('admin.error_msg'));
    	}

    	return redirect()->back();
    }
}

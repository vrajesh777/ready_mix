<?php

namespace App\Http\Controllers;

use App\Models\Maintenance_Category;
use Illuminate\Http\Request;
use Validator;

class MaintenanceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.category');
    	$this->module_view_folder = "vechicle_maintance.category";
    	$this->module_url_path    = url('/maintenance_category');
    }

    public function index()
    {
        $obj_data = Maintenance_Category::get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['name_arabic'] = 'required';
        $arr_rules['name_english'] = 'required';

        $validator  = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');

            return response()->json($arr_resp);
        }

        $params['name_arabic'] = $request->input('name_arabic');
        $params['name_english'] = $request->input('name_english');

        $status = Maintenance_Category::create($params);
        if($status)
        {
            $arr_resp['status']  = 'success';
            $arr_resp['message'] = trans('admin.created_successfully');
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.error_msg');
        }
        return response()->json($arr_resp);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maintenance_Category  $maintenance_Category
     * @return \Illuminate\Http\Response
     */
    public function show(Maintenance_Category $maintenance_Category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance_Category  $maintenance_Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$enc_id,Maintenance_Category $maintenance_Category)
    {
        $id = base64_decode($enc_id);
        $obj_data = Maintenance_Category::where('id',$id)->first();
        if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
            $arr_data['status'] = 'success';
    	}
    	return response()->json($arr_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance_Category  $maintenance_Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$enc_id, Maintenance_Category $maintenance_Category)
    {
    	$id = base64_decode($enc_id);
    	$obj_data = Maintenance_Category::where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_rules = $arr_resp = array();

            $arr_rules['name_arabic'] = 'required';
            $arr_rules['name_english'] = 'required';

            $validator  = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');

                return response()->json($arr_resp);
            }

            $params['name_arabic'] = $request->input('name_arabic');
            $params['name_english'] = $request->input('name_english');

            $status = Maintenance_Category::where('id',$id)->update($params);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance_Category  $maintenance_Category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance_Category $maintenance_Category)
    {
        //
    }
}

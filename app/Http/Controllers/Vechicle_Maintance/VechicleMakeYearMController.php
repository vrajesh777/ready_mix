<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\VechicleMakeModel;
use App\Models\VechicleModelModel;
use App\Models\VechicleYearModel;

use Validator;
use Session;
use Auth;

class VechicleMakeYearMController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->VechicleMakeModel  = new VechicleMakeModel;
        $this->VechicleModelModel = new VechicleModelModel;
        $this->VechicleYearModel  = new VechicleYearModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.make_model_year');
        $this->module_view_folder   = "vechicle_maintance.make_model_year";
        $this->module_url_path      = url('/vechicle_mym');
	}

	public function index(Request $request)
    {
    	$arr_make = $arr_model = $arr_year = [];

    	$obj_make = $this->VechicleMakeModel->get();
    	if($obj_make)
    	{
    		$arr_make = $obj_make->toArray();
    	}

    	$obj_model = $this->VechicleModelModel->with('make')->get();
    	if($obj_model)
    	{
    		$arr_model = $obj_model->toArray();
    	}

    	$obj_year = $this->VechicleYearModel->with(['make','model'])->get();
    	if($obj_year)
    	{
    		$arr_year = $obj_year->toArray();
    	}

        $this->arr_view_data['arr_make']  = $arr_make;
        $this->arr_view_data['arr_model'] = $arr_model;
        $this->arr_view_data['arr_year']  = $arr_year;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = [];
    	$arr_rules['type'] = 'required';
    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		Session::flash('error',trans('admin.validation_error_msg'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
    	}

    	$type = $request->input('type');
    	if($type == 'make'){

	    	$make_name     = $request->input('make_name') ?? '';
	    	$is_make_exist = $this->VechicleMakeModel->where('make_name',$make_name)->count();

	    	if($is_make_exist)
	    	{
	    		Session::flash('error',trans('admin.already_exist'));
	    		return redirect()->back();
	    	}

			$arr_data['make_name'] = $make_name ?? '';
			$status                = $this->VechicleMakeModel->create($arr_data);
    	}
    	elseif($type == 'model'){

	    	$make_id        = $request->input('make_id') ?? '';
	    	$model_name     = $request->input('model_name') ?? '';
	    	$is_model_exist = $this->VechicleModelModel
	    							->where('make_id',$make_id)
	    							->where('model_name',$model_name)
	    							->count();
	    	if($is_model_exist)
	    	{
	    		Session::flash('error',trans('admin.already_exist'));
	    		return redirect()->back();
	    	}

			$arr_data['model_name'] = $model_name ?? '';
			$arr_data['make_id']    = $make_id ?? '';
			$status                 = $this->VechicleModelModel->create($arr_data);
    	}
    	elseif($type == 'year'){

	    	$make_id        = $request->input('make_id') ?? '';
	    	$model_id       = $request->input('model_id') ?? '';
	    	$Year           = $request->input('Year') ?? '';
	    	$is_model_exist = $this->VechicleYearModel
	    							->where('make_id',$make_id)
	    							->where('model_id',$model_id)
	    							->where('year',$Year)
	    							->count();
	    	if($is_model_exist)
	    	{
	    		Session::flash('error',trans('admin.already_exist'));
	    		return redirect()->back();
	    	}

			$arr_data['make_id']  = $make_id ?? '';
			$arr_data['model_id'] = $model_id ?? '';
			$arr_data['year']     = $Year ?? '';
			$status               = $this->VechicleYearModel->create($arr_data);
    	}

    	if($status)
    	{
    		Session::flash('success',trans('admin.added_successfully'));
    	}
    	else
    	{
    		Session::flash('error',trans('admin.error_msg'));
    	}
    	
    	return redirect()->back();
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);

        $arr_rules = [];
        $arr_rules['type'] = 'required';
        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.validation_error_msg'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $type = $request->input('type');
        if($type == 'make'){

            $make_name     = $request->input('make_name') ?? '';
            $is_make_exist = $this->VechicleMakeModel
                                  ->where('make_name',$make_name)
                                  ->where('id','<>',$id)
                                  ->count();

            if($is_make_exist)
            {
                Session::flash('error',trans('admin.already_exist'));
                return redirect()->back();
            }

            $arr_data['make_name'] = $make_name ?? '';
            $status = $this->VechicleMakeModel->where('id',$id)
                                            ->update($arr_data);
        }
        elseif($type == 'model'){

            $make_id        = $request->input('make_id') ?? '';
            $model_name     = $request->input('model_name') ?? '';
            $is_model_exist = $this->VechicleModelModel
                                    ->where('make_id',$make_id)
                                    ->where('model_name',$model_name)
                                    ->where('id','<>',$id)
                                    ->count();
            if($is_model_exist)
            {
                Session::flash('error',trans('admin.already_exist'));
                return redirect()->back();
            }

            $arr_data['model_name'] = $model_name ?? '';
            $arr_data['make_id']    = $make_id ?? '';
            $status = $this->VechicleModelModel->where('id',$id)
                                               ->update($arr_data);
        }
        elseif($type == 'year'){

            $make_id        = $request->input('make_id') ?? '';
            $model_id       = $request->input('model_id') ?? '';
            $Year           = $request->input('Year') ?? '';
            $is_model_exist = $this->VechicleYearModel
                                    ->where('make_id',$make_id)
                                    ->where('model_id',$model_id)
                                    ->where('year',$Year)
                                    ->where('id','<>',$id)
                                    ->count();
            if($is_model_exist)
            {
                Session::flash('error',trans('admin.already_exist'));
                return redirect()->back();
            }

            $arr_data['make_id']  = $make_id ?? '';
            $arr_data['model_id'] = $model_id ?? '';
            $arr_data['year']     = $Year ?? '';
            $status = $this->VechicleYearModel->where('id',$id)
                                              ->update($arr_data);
        }

        if($status)
        {
            Session::flash('success',trans('admin.updated_successfully'));
        }
        else
        {
            Session::flash('error',trans('admin.error_msg'));
        }
        return redirect()->back();
    }

    public function make_edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_make = $this->VechicleMakeModel->select('make_name')->where('id',$id)->first();
        if($obj_make){

            $arr_make = $obj_make->toArray();
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
            $arr_resp['data'] = $arr_make ?? [];
        }
        else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }

    public function model_edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_model = $this->VechicleModelModel->select('make_id','model_name')->where('id',$id)->first();
        if($obj_model){

            $arr_model = $obj_model->toArray();
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
            $arr_resp['data'] = $arr_model ?? [];
        }
        else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }

    public function year_edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_year = $this->VechicleYearModel->select('make_id','model_id','year')->where('id',$id)->first();
        if($obj_year){

            $arr_year = $obj_year->toArray();
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
            $arr_resp['data'] = $arr_year ?? [];
        }
        else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }

    public function make_activate($enc_id)
    {
        $id = base64_decode($enc_id);
        if(!$id)
        {
            return redirect()->back();
        }

        $obj_data = $this->VechicleMakeModel->where('id',$id)->first();
        
        if($obj_data)
        {
            $status =  $obj_data->update(['is_active'=>'1']);
            if($status)
            {
                 Session::flash('success',trans('admin.activated_successfully'));
            }
            else
            {
                Session::flash('error',trans('admin.error_msg'));
            }
        }

        return redirect()->back();
    }

    public function make_deactivate($enc_id)
    {
        $id = base64_decode($enc_id);
        if(!$id)
        {
            return redirect()->back();
        }

        $obj_data = $this->VechicleMakeModel->where('id',$id)->first();
        
        if($obj_data)
        {
            $status =  $obj_data->update(['is_active'=>'0']);
            if($status)
            {
                 Session::flash('success',trans('admin.activated_successfully'));
            }
            else
            {
                Session::flash('error',trans('admin.problem_occured_while_activation'));
            }
        }

        return redirect()->back();
    }

    public function model_activate($enc_id)
    {
        $id = base64_decode($enc_id);
        if(!$id)
        {
            return redirect()->back();
        }

        $obj_data = $this->VechicleModelModel->where('id',$id)->first();
        
        if($obj_data)
        {
            $status =  $obj_data->update(['is_active'=>'1']);
            if($status)
            {
                 Session::flash('success',trans('admin.activated_successfully'));
            }
            else
            {
                Session::flash('error',trans('admin.problem_occured_while_activation'));
            }
        }

        return redirect()->back();
    }

    public function model_deactivate($enc_id)
    {
        $id = base64_decode($enc_id);
        if(!$id)
        {
            return redirect()->back();
        }

        $obj_data = $this->VechicleModelModel->where('id',$id)->first();
        
        if($obj_data)
        {
            $status =  $obj_data->update(['is_active'=>'0']);
            if($status)
            {
                 Session::flash('success',trans('admin.deactivated_successfully'));
            }
            else
            {
                Session::flash('error',trans('admin.problem_occured_while_activation'));
            }
        }

        return redirect()->back();
    }

    public function year_activate($enc_id)
    {
        $id = base64_decode($enc_id);
        if(!$id)
        {
            return redirect()->back();
        }

        $obj_data = $this->VechicleYearModel->where('id',$id)->first();
        
        if($obj_data)
        {
            $status =  $obj_data->update(['is_active'=>'1']);
            if($status)
            {
                 Session::flash('success',trans('admin.activated_successfully'));
            }
            else
            {
                Session::flash('error',trans('admin.problem_occured_while_activation'));
            }
        }

        return redirect()->back();
    }

    public function year_deactivate($enc_id)
    {
        $id = base64_decode($enc_id);
        if(!$id)
        {
            return redirect()->back();
        }

        $obj_data = $this->VechicleYearModel->where('id',$id)->first();
        
        if($obj_data)
        {
            $status =  $obj_data->update(['is_active'=>'0']);
            if($status)
            {
                 Session::flash('success',trans('admin.deactivated_successfully'));
            }
            else
            {
                Session::flash('error',trans('admin.problem_occured_while_activation'));
            }
        }

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\VechicleMakeModel;
use App\Models\VechicleModelModel;
use App\Models\VechicleYearModel;
use App\Models\VehicleModel;
use Session;
use App;
class CommonDataController extends Controller
{
	public function __construct()
	{
		$this->VechicleMakeModel  = new VechicleMakeModel();
		$this->VechicleModelModel = new VechicleModelModel();
        $this->VechicleYearModel  = new VechicleYearModel();
		$this->VehicleModel       = new VehicleModel();
	}

    public function load_model($enc_id)
    {	
    	$id = base64_decode($enc_id);
    	if($id!='')
    	{
    		$obj_model = $this->VechicleModelModel->where('make_id',$id)
    											  ->get();
    		if($obj_model)
    		{
    			$arr_model = $obj_model->toArray();

    			$arr_resp['status']    = 'success';
    			$arr_resp['message']   = trans('admin.data_found');
    			$arr_resp['arr_model'] = $arr_model;

    		}
    		else
    		{
    			$arr_resp['status'] = 'error';
    			$arr_resp['message'] = trans('admin.data_not_found');
    		}
    	}
    	else
    	{
    		$arr_resp['status'] = 'error';
    		$arr_resp['message'] = trans('admin.invalid_request');
    	}

    	return response()->json($arr_resp,200);
    }

    public function load_year(Request $request)
    {
        $make_id = base64_decode($request->input('make_id'));
        $model_id = base64_decode($request->input('model_id'));
        if($make_id!='' && $model_id!='')
        {
        	$obj_year = $this->VechicleYearModel->where('make_id',$make_id)
        									    ->where('model_id',$model_id)
        									    ->where('is_active','1')
        									    ->select('id','year')
        									    ->get();
        	if($obj_year)
        	{
        		$arr_year = $obj_year->toArray();

        		$arr_resp['status']    = 'success';
    			$arr_resp['message']   = trans('admin.data_found');
    			$arr_resp['arr_year'] = $arr_year;

    		}
    		else
    		{
    			$arr_resp['status'] = 'error';
    			$arr_resp['message'] = trans('admin.data_not_found');
    		}						
        }
        else
    	{
    		$arr_resp['status'] = 'error';
    		$arr_resp['message'] = trans('admin.invalid_request');
    	}

    	return response()->json($arr_resp,200);
    }

    public function vechicle_details($enc_id)
    {
        $id = base64_decode($enc_id);
        if($id!='')
        {
            $obj_vechicle = $this->VehicleModel->with(['make','model'])
                                               ->where('id',$id)
                                               ->first();
            if($obj_vechicle)
            {
                $arr_vechicle = $obj_vechicle->toArray();
                //dd($arr_vechicle);
                $arr_resp['status']    = 'success';
                $arr_resp['message']   = trans('admin.data_found');
                $arr_resp['arr_vechicle'] = $arr_vechicle;

            }
            else
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.data_not_found');
            }
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }
    public function set_locale($locale=false)
    {
        if( isset($locale) ) {
            Session::put('locale',$locale);
            App::setLocale($locale);

        }
        $locale = App::currentLocale();
        return redirect()->back();   
    }
}

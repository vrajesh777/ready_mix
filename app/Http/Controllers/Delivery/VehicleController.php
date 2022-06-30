<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\VehicleModel;
use App\Models\User;
use App\Models\VechicleMakeModel;
use App\Models\VechicleModelModel;
use App\Models\VechicleYearModel;

use Validator;

class VehicleController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->VehicleModel       = new VehicleModel();
        $this->BaseModel          = $this->VehicleModel;
        $this->User               = new User;
        $this->VechicleMakeModel  = new VechicleMakeModel;
        $this->VechicleModelModel = new VechicleModelModel;
        $this->VechicleYearModel  = new VechicleYearModel;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.vehicle');
        $this->module_view_folder   = "delivery.vehicle";
        $this->module_url_path      = url('/vehicle');

        $this->vehicle_reg_public_path = url('/').config('app.project.image_path.vehicle_registration');
        $this->vehicle_reg_base_path   = base_path().config('app.project.image_path.vehicle_registration'); 
	}

    public function index()
    {
        $arr_data = $driver_ids = $arr_driver = [];
        $obj_data = $this->BaseModel->with(['driver_details'])->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
            $driver_ids = array_column($arr_data,'driver_id');
        }

        $obj_driver = $this->User->where('role_id', config('app.roles_id.driver'))
                                    ->select('id','first_name','last_name')
                                    ->whereNotIn('id',$driver_ids)
                                    ->get();

        if($obj_driver->count() > 0) {
            $arr_driver = $obj_driver->toArray();
        }

        $arr_make = [];
        $obj_make = $this->VechicleMakeModel->where('is_active','1')
                                            ->select('id','make_name')
                                            ->get();
        if($obj_make)
        {
            $arr_make = $obj_make->toArray();
        }

        $this->arr_view_data['arr_data']   = $arr_data;
        $this->arr_view_data['arr_driver'] = $arr_driver;
        $this->arr_view_data['driver_ids'] = $driver_ids;
        $this->arr_view_data['arr_make']   = $arr_make;

        $this->arr_view_data['module_title']            = $this->module_title;
        $this->arr_view_data['page_title']              = $this->module_title;
        $this->arr_view_data['module_url_path']         = $this->module_url_path;
        $this->arr_view_data['vehicle_reg_public_path'] = $this->vehicle_reg_public_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['name']         = 'required';
        $arr_rules['plate_no']     = 'required';
        $arr_rules['plate_letter'] = 'required';
        $arr_rules['driver_id']    = 'required';
        $arr_rules['vehicle_reg']  = 'required';
        $arr_rules['maker']        = 'required';
        $arr_rules['model']        = 'required';
        $arr_rules['year']         = 'required';
        $arr_rules['chasis_no']    = 'required';
        $arr_rules['regs_no']      = 'required';
        $arr_rules['vin_no']       = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
        }

        $plate_no = $request->input('plate_no');
        $is_exist_plate_no = $this->BaseModel->where('plate_no',$plate_no)->count();
        if($is_exist_plate_no > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.already_exist');
            return response()->json($arr_resp, 200);
        }

        $driver_id = $request->input('driver_id');
        $is_exist_driver = $this->BaseModel->where('driver_id',$driver_id)->count();
        if($is_exist_driver > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.select_driver_already_assign');
            return response()->json($arr_resp, 200);
        }

        $arr_data['name']         = $request->input('name');
        $arr_data['plate_no']     = $plate_no;
        $arr_data['plate_letter'] = $request->input('plate_letter');
        $arr_data['driver_id']    = $request->input('driver_id');
        $arr_data['maker']        = $request->input('maker');
        $arr_data['model']        = $request->input('model');
        $arr_data['year']         = $request->input('year');
        $arr_data['chasis_no']    = $request->input('chasis_no');
        $arr_data['regs_no']      = $request->input('regs_no');
        $arr_data['vin_no']       = $request->input('vin_no');

        if($request->hasFile('vehicle_reg'))
        {
            $vehicle_reg = $request->file('vehicle_reg');
            $file_name = $request->file('vehicle_reg');
            $file_extension = strtolower($vehicle_reg->getClientOriginalExtension());
            if(in_array($file_extension,['png','jpg','jpeg','pdf']))
            {
                $file_name                   = time().uniqid().'.'.$file_extension;
                $isUpload                    = $vehicle_reg->move($this->vehicle_reg_base_path , $file_name);
                $arr_data['vehicle_reg'] = $file_name;
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
            $arr_resp['message']        = trans('admin.added_error');
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
            $arr_response['msg'] = trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->BaseModel->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $driver_ids = $arr_driver = [];
        $obj_all_vehicle = $this->BaseModel->where('driver_id','<>',$arr_data['driver_id'])->select('driver_id')->get();
        if($obj_all_vehicle)
        {
            $arr_all_vehicle = $obj_all_vehicle->toArray();
            $driver_ids = array_column($arr_all_vehicle,'driver_id');
        }

        $obj_driver = $this->User->where('role_id', config('app.roles_id.driver'))
                                    ->select('id','first_name','last_name')
                                    ->whereNotIn('id',$driver_ids)
                                    ->get();

        if($obj_driver->count() > 0) {
            $arr_driver = $obj_driver->toArray();
        }

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
            $arr_data['arr_driver'] = $arr_driver;
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data'] = $arr_data;
            $arr_response['msg'] = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg'] = trans('admin.data_not_found');
        }

        return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_tax = $this->BaseModel->where('id', $id)->first();

        if($obj_tax){

            $arr_rules  = $arr_resp = array();

            $arr_rules['name']         = 'required';
            $arr_rules['plate_no']     = 'required';
            $arr_rules['plate_letter'] = 'required';
            $arr_rules['driver_id']    = 'required';
            //$arr_rules['vehicle_reg']  = 'required';
            $arr_rules['maker']        = 'required';
            $arr_rules['model']        = 'required';
            $arr_rules['year']         = 'required';
            $arr_rules['chasis_no']    = 'required';
            $arr_rules['regs_no']      = 'required';
            $arr_rules['vin_no']       = 'required';

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }
            $plate_no = $request->input('plate_no');
            $is_exist_plate_no = $this->BaseModel->where('id','<>',$id)
                                              ->where('plate_no',$plate_no)
                                              ->count();
            if($is_exist_plate_no > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.already_exist');
                return response()->json($arr_resp, 200);
            }

            $driver_id = $request->input('driver_id');
            $is_exist_driver = $this->BaseModel->where('driver_id',$driver_id)
                                               ->where('id','<>',$id)
                                               ->count();
            if($is_exist_driver > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.select_driver_already_assign');
                return response()->json($arr_resp, 200);
            }

            $arr_data['name']         = $request->input('name');
            $arr_data['plate_no']     = $plate_no;
            $arr_data['plate_letter'] = $request->input('plate_letter');
            $arr_data['driver_id']    = $request->input('driver_id');
            $arr_data['maker']        = $request->input('maker');
            $arr_data['model']        = $request->input('model');
            $arr_data['year']         = $request->input('year');
            $arr_data['chasis_no']    = $request->input('chasis_no');
            $arr_data['regs_no']      = $request->input('regs_no');
            $arr_data['vin_no']       = $request->input('vin_no');

            if($request->hasFile('vehicle_reg'))
            {
                $vehicle_reg = $request->file('vehicle_reg');
                $file_name = $request->file('vehicle_reg');
                $file_extension = strtolower($vehicle_reg->getClientOriginalExtension());
                if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                {
                    $file_name                   = time().uniqid().'.'.$file_extension;
                    $isUpload                    = $vehicle_reg->move($this->vehicle_reg_base_path , $file_name);
                    $arr_data['vehicle_reg'] = $file_name;
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
                $arr_resp['message']        = trans('admin.updated_error');
            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
        
    }
}

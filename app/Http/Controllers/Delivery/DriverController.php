<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;
use App\Models\DeliveryNoteModel;
use App\Models\User;
use App\Models\RolesModel;

use Validator;
use Session;
use Auth;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->UserModel = new User();
        $this->BaseModel = $this->UserModel;
        $this->RolesModel = new RolesModel();
        $this->DeliveryNoteModel = new DeliveryNoteModel;
		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.driver');
        $this->module_view_folder   = "delivery.driver";
        $this->module_url_path      = url('/driver');

        $this->driving_licence_public_path = url('/').config('app.project.image_path.driving_licence');
        $this->driving_licence_base_path   = base_path().config('app.project.image_path.driving_licence');  
	}

    public function index(Request $request)
    {
        $arr_data = [];
        $driver   = config('app.roles_id.driver');
        $operator = config('app.roles_id.pump_operator');
        $helper   = config('app.roles_id.pump_helper');
       
        // DB::enableQueryLog();
        // $obj_data = $this->DeliveryNoteModel->whereHas('driver', function ($query) use ($driver){
        //                 $query->where('users.role_id', '=', $driver);
        //             })
        //     ->with(['driver'])
        //     ->get();

        // group by query 
        $report_by = 'dn.driver_id';
        $role = $driver;
        if(!empty($request->get('role'))){
            if($request->get('role')==$operator){
                $report_by = 'dn.operator_id';
                $role =  $operator;
            } else if($request->get('role')==$helper){
                $report_by = 'dn.helper_id';
                $role = $helper;
            }
        }
        if(!empty($request->get('fromDate')) && !empty($request->get('toDate'))){
            $fromDate = $request->get('fromDate');
            $toDate   = $request->get('toDate');

            // $fromDate = date('Y-m-d', strtotime($fromDate));
            //\Carbon::parse($fromDate)->format('Y-m-d');
        
            // $toDate   = date('Y-m-d', strtotime($toDate));
            // $toDate   = \Carbon::parse($fromDate)->format('Y-m-d');
            // $toDate = strtotime($toDate,'Y-m-d');
            $obj_data = DB::table('delivery_note','dn')
                    ->select('u.id','u.id_number','u.first_name','u.last_name','dn.load_no','u.initial_trip','u.initial_rate','u.additional_trip','u.additional_rate'
                        ,DB::raw('DATE_FORMAT(dn.created_at,"%d %M %Y") as date'), DB::raw('count(dn.id) as tripCount'))
                    ->join('users as u',$report_by,'=','u.id')
                    ->groupBy('date','u.id')
                    ->where('u.role_id', '=', $role)
                    ->whereBetween('dn.delivery_date', [$fromDate,$toDate])
                    ->get();

        } else{
            $obj_data = DB::table('delivery_note','dn')
                    ->select('u.id','u.id_number','u.first_name','u.last_name','dn.load_no','u.initial_trip','u.initial_rate','u.additional_trip','u.additional_rate'
                        ,DB::raw('DATE_FORMAT(dn.created_at,"%d %M %Y") as date'), DB::raw('count(dn.id) as tripCount'))
                    ->join('users as u',$report_by,'=','u.id')
                    ->groupBy('date','u.id')
                    ->where('u.role_id', '=', $role)
                    ->get();
        }
      
        // $obj_data = DB::table('delivery_note','dn')
        //             ->select('u.id','u.first_name','u.last_name','dn.load_no','u.initial_trip','u.initial_rate','u.additional_trip','u.additional_rate'
        //                 ,DB::raw('DATE_FORMAT(dn.created_at,"%d %M %Y") as date'))
        //             ->join('users as u','dn.driver_id','=','u.id')
        //             ->where('u.role_id', '=', $driver)
        //             ->get();

        if($obj_data->count() > 0) {
            $arr_data = $obj_data->toArray();
        }
        // dd(DB::getQueryLog());
        // dd($arr_data);
        $this->arr_view_data['arr_data'] = json_decode(json_encode($arr_data), true);;
        $this->arr_view_data['role']            = $role;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['driving_licence_public_path'] = $this->driving_licence_public_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['first_name']      = 'required';
        $arr_rules['last_name']       = 'required';
        //$arr_rules['email']           = 'required';
        //$arr_rules['mobile_no']       = 'required';
        //$arr_rules['driving_licence'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
        }

        if($request->has('email') && $request->input('email')!=''){
            $email = $request->input('email');
            $is_exist_email = $this->BaseModel->where('email',$email)->count();
            if($is_exist_email > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.email_alredy_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['email']      = $email;
        } 

        if($request->has('id_number') && $request->input('id_number')!=''){
            $id_number = $request->input('id_number');
            $is_exist_id_number = $this->BaseModel->where('id_number',$id_number)->count();
            if($is_exist_id_number > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.id_num_alredy_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['id_number']  = $id_number;
        } 
        
        $role_id = config('app.roles_id.driver');
        $arr_data['role_id']    = $role_id;
        $arr_data['first_name'] = $request->input('first_name');
        $arr_data['last_name']  = $request->input('last_name');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        
        $arr_data['password']   = \Hash::make(123456);
        $arr_data['is_active']  = '1';

        if($request->hasFile('driving_licence'))
        {
            $driving_licence = $request->file('driving_licence');
            $file_name = $request->file('driving_licence');
            $file_extension = strtolower($driving_licence->getClientOriginalExtension());
            if(in_array($file_extension,['png','jpg','jpeg','pdf']))
            {
                $file_name                   = time().uniqid().'.'.$file_extension;
                $isUpload                    = $driving_licence->move($this->driving_licence_base_path , $file_name);
                $arr_data['driving_licence'] = $file_name;
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
            $obj_role = $this->RolesModel->where('id',$role_id)->first();
            $status->assignRole($obj_role->name);

            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.driver_add_success');
        }
        else
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.driver_add_error');
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
            $arr_response['msg'] = trans('admin.somthing_went_wrong');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->BaseModel->select('id','first_name','last_name','email','mobile_no','driving_licence','id_number')
        						    ->where('id',$id)->first();
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
            $arr_response['msg'] = trans('admin.data_not_found');
        }

        return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_driver = $this->BaseModel->where('id', $id)->first();

        if($obj_driver){

            $arr_rules  = $arr_resp = array();

            $arr_rules['first_name'] = 'required';
	        $arr_rules['last_name']  = 'required';
	        //$arr_rules['email']      = 'required';
	        //$arr_rules['mobile_no']  = 'required';

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }

            if($request->has('email') && $request->input('email')!=''){
                $email = $request->input('email');
                $is_exist_email = $this->BaseModel->where('email',$email)
                                                  ->where('id','<>',$id)
                                                  ->count();
                if($is_exist_email > 0)
                {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.email_alredy_exist');
                    return response()->json($arr_resp, 200);
                }

                $arr_data['email']      = $email;
            } 

            if($request->has('id_number') && $request->input('id_number')!=''){
                $id_number = $request->input('id_number');
                $is_exist_id_number = $this->BaseModel->where('id_number',$id_number)
                                                      ->where('id','<>',$id)
                                                      ->count();
                if($is_exist_id_number > 0)
                {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.id_num_alredy_exist');
                    return response()->json($arr_resp, 200);
                }

                $arr_data['id_number']  = $id_number;
            } 

            $arr_data['first_name'] = $request->input('first_name');
	        $arr_data['last_name']  = $request->input('last_name');
	        $arr_data['mobile_no']  = $request->input('mobile_no');
	        //$arr_data['email']      = $email;

            if($request->hasFile('driving_licence'))
            {
                $driving_licence = $request->file('driving_licence');
                $file_name = $request->file('driving_licence');
                $file_extension = strtolower($driving_licence->getClientOriginalExtension());
                if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                {
                    $file_name                   = time().uniqid().'.'.$file_extension;
                    $isUpload                    = $driving_licence->move($this->driving_licence_base_path , $file_name);
                    $arr_data['driving_licence'] = $file_name;
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
                $obj_role = $this->RolesModel->where('id',$obj_driver->role_id)->first();
                $obj_driver->assignRole($obj_role->name);

                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('addmin.updated_error');
            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
        
    }
}

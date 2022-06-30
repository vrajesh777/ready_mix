<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\User;
use App\Models\ParentDepartmentModel;
use App\Models\DepartmentsModel;
use DB;
use Validator;
use App\Common\Traits\MultiActionTrait;
class DepartmentController extends Controller
{
	 use MultiActionTrait;
    public function __construct()
    {
        $this->User                        = new User();
        $this->ParentDepartmentModel       = new ParentDepartmentModel();
        $this->DepartmentsModel            = new DepartmentsModel();
        $this->BaseModel                   = $this->DepartmentsModel;
     
		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.department');
        $this->module_view_folder   = "department";
        $this->module_url_path      = url('/department');
    }

    public function index()
    {
    	$arr_lead = $arr_parent_dept=$arr_dept=[];

        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];
    	$obj_lead = $this->User->select('id','first_name','last_name')
                               ->whereNotIn('role_id',$arr_exclude)
                               ->get();
    	if($obj_lead)
    	{
    		$arr_lead = $obj_lead->toArray();
    	}

    	$obj_parent_dept = $this->ParentDepartmentModel->get();
    	if($obj_parent_dept)
    	{
    		$arr_parent_dept = $obj_parent_dept->toArray();
    	}
    	$obj_dept = $this->DepartmentsModel->with(['lead_user','parent_dept'])->get();
    	if($obj_dept)
    	{
    		$arr_dept = $obj_dept->toArray();
    	}
    	//dd($arr_dept);
    	$this->arr_view_data['arr_dept']        = $arr_dept;
    	$this->arr_view_data['arr_parent_dept'] = $arr_parent_dept;
    	$this->arr_view_data['arr_lead']        = $arr_lead;
    	$this->arr_view_data['module_title']    = $this->module_title;
    	$this->arr_view_data['page_title']		= $this->module_title;
    	$this->arr_view_data['module_url_path']	= $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	
    	$arr_rules = $arr_resp = array();

        $arr_rules['department_name']    = 'required';
        $arr_rules['department_lead']    = 'required';
        //$arr_rules['parent_department'] = 'required';

    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
    	}

    	
    	 $user = \Auth::user();
        $arr_data['name']            = trim($request->input('department_name'));
        $arr_data['mail_alias']      = $request->input('mail_alias','');
        $arr_data['lead_user_id']    = trim($request->input('department_lead'));
        $arr_data['parent_id']       = trim($request->input('parent_department'));
        $arr_data['added_by']        = isset($user->id)?$user->id:'';
       	if($this->chk_exist_record($arr_data['name'])==false)
       	{
       		$arr_resp['status']    = 'error';
            $arr_resp['message']   = trans('admin.department')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
       	}

    	$status = $this->DepartmentsModel->create($arr_data);
    	if($status)
    	{
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.department')." ".trans('admin.added_successfully');
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
            $arr_response['msg'] 	=  trans('admin.error_msg');
            return response()->json($arr_response);
    	}

    	$arr_data = [];
    	$obj_data = $this->DepartmentsModel->where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

    	if(isset($arr_data) && sizeof($arr_data)>0)
    	{
    		$arr_response['status'] = 'SUCCESS';
    		$arr_response['data']   = $arr_data;
    		$arr_response['msg']    = 'Data get successfully.';
    	}
    	else
    	{
    		$arr_response['status'] = 'ERROR';
    		$arr_response['msg']    =  trans('admin.error_msg'); 
    	}

    	return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
    
        $id = base64_decode($enc_id);
        $user = \Auth::user();
        
        $obj_department = $this->DepartmentsModel->where('id', $id)->first();
        if($obj_department)
        {
            $arr_rules = $arr_data =[];

             $arr_rules['department_name']    = 'required';
        	 $arr_rules['department_lead']    = 'required';
             //$arr_rules['parent_department'] = 'required';
            
            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }

        
            $arr_data['name']            = trim($request->input('department_name'));
            $arr_data['mail_alias']      = $request->input('mail_alias','');
        	$arr_data['lead_user_id']    = trim($request->input('department_lead'));
        	$arr_data['parent_id']       = trim($request->input('parent_department'));

        	if($this->chk_exist_record($arr_data['name'],$obj_department->id)==false)
	       	{
	       		$arr_resp['status']    = 'error';
	            $arr_resp['message']   = trans('admin.department')." ".trans('admin.already_exist');
	            return response()->json($arr_resp, 200);
	       	}


            $status = $this->DepartmentsModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        =  trans('admin.department')." ". trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        =  trans('admin.error_msg');

            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        =  trans('admin.invalid_request');
        }

    	return response()->json($arr_resp, 200);
    }
    public function chk_exist_record($name,$dept_id='')
    {
    	$is_exist_flag = true;
    	$obj_data = $this->DepartmentsModel;
    	if($dept_id!="")
    	{
    		$obj_data = $obj_data->where('id','<>',$dept_id);
    	}
    	$is_name_exist = $obj_data->where('name',$name)->first();
    	if($is_name_exist)
    	{
    		$is_exist_flag = false;
    	}
    	return $is_exist_flag;	
    }

}

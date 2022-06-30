<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\ReimbursementTypeModel;
use App\Models\MasterReimbursementModel;

use Session;
use Validator;

class MasterReimbursementController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
    	$this->MasterReimbursementModel = new MasterReimbursementModel();
    	$this->BaseModel                = $this->MasterReimbursementModel;
    	$this->ReimbursementTypeModel   = new ReimbursementTypeModel();

    	$this->arr_view_data      = [];
    	$this->module_title       = 'Reimbursement';
    	$this->module_view_folder = 'hr.reimbursement';
    	$this->module_url_path    = url('/salary_component/reimbursement');
    }

    public function index()
    {
    	$arr_reims_type = $arr_data = [];
    	/*$obj_reims_type = $this->ReimbursementTypeModel->where('is_active','1')->get();
    	if($obj_reims_type)
    	{
    		$arr_reims_type = $obj_reims_type->toArray();
    	}*/
    	$obj_data = $this->MasterReimbursementModel->with(['reimbursement_type'])->get();
    	if($obj_data){
    		$arr_data = $obj_data->toArray();
    	}
        
        //$this->arr_view_data['arr_reims_type']   = $arr_reims_type;
        $this->arr_view_data['arr_data']         = $arr_data;

        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();

    	//$arr_rules['reimbursement_type_id'] = 'required';
    	$arr_rules['name_payslip']          = 'required';
    	$arr_rules['amount']                = 'required';
    	$arr_rules['is_active']             = 'required';

    	$validator              = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.error_msg');
            return response()->json($arr_resp, 200);
    	}

    	//$arr_ins['reimbursement_type_id'] = trim($request->input('reimbursement_type_id'));
    	$arr_ins['name_payslip']          = trim($request->input('name_payslip'));
    	$arr_ins['amount']                = trim($request->input('amount'));
    	$arr_ins['is_active']             = trim($request->input('is_active'));

    	$status = $this->MasterReimbursementModel->create($arr_ins);
    	if($status)
    	{
            $arr_resp['status']  = 'success';
            $arr_resp['message'] =  'Stored successfully.';
    	}
    	else
    	{
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.error_msg');
    	}

    	return response()->json($arr_resp,200);
    }

    public function edit($enc_id)
    {
    	$arr_reims_type = [];
        if($enc_id!='')
        {
            $id = base64_decode($enc_id);
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.error_msg');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->MasterReimbursementModel->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        /*$obj_reims_type = $this->ReimbursementTypeModel->where('is_active','1')->get();
    	if($obj_reims_type)
    	{
    		$arr_reims_type = $obj_reims_type->toArray();
    	}*/

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
        	//$arr_data['arr_reims_type'] = $arr_reims_type;
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data']   = $arr_data;
            $arr_response['msg']    = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.error_msg'); 
        }

        return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_payment = $this->MasterReimbursementModel->where('id',$id)->first();
        if($obj_payment)
        {
            $arr_rules = $arr_resp = array();

            //$arr_rules['reimbursement_type_id'] = 'required';
	    	$arr_rules['name_payslip']          = 'required';
	    	$arr_rules['amount']                = 'required';
	    	$arr_rules['is_active']             = 'required';

            $validator              = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_error_msg');
                return response()->json($arr_resp, 200);
            }

            /*$name    = $request->input('name');
            $is_exit = $this->MasterReimbursementModel->where('name',$name)
                                                 ->where('id','<>',$id)
                                                 ->count();
            if($is_exit)
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.already_exist');
                return response()->json($arr_resp,200);
            }*/

            $arr_update['name_payslip'] = trim($request->input('name_payslip'));
            $arr_update['amount']       = trim($request->input('amount'));
            $arr_update['is_active']    = trim($request->input('is_active'));

            $status = $this->MasterReimbursementModel->where('id',$id)->update($arr_update);
            if($status)
            {
                $arr_resp['status']  = 'success';
                $arr_resp['message'] = 'Updated successfully.';
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] =  trans('admin.error_msg');
            }
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] =  trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }
}

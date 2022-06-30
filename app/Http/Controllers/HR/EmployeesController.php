<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\MasterEarningModel;
use App\Models\MasterSalaryModel;
use App\Models\MasterSalaryDetailsModel;
use App\Models\OverheadExpancesModel;

use Session;
use Validator;
use Auth;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->User                     = new User();
        $this->MasterEarningModel       = new MasterEarningModel();
        $this->MasterSalaryModel        = new MasterSalaryModel();
        $this->MasterSalaryDetailsModel = new MasterSalaryDetailsModel();
        $this->OverheadExpancesModel    = new OverheadExpancesModel();

    	$this->auth                 = auth();
    	$this->arr_view_data      = [];
    	$this->module_title       = 'Employees';
    	$this->module_view_folder = 'hr.pay_employees';
    	$this->module_url_path    = url('/pay_employees');
    }

    public function index()
    {
        $arr_data = [];
        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];

        $obj_data = $this->User->whereHas('role', function(){})
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->with(['department','salary_details'])
                                    ->get();
        if($obj_data){
        	$arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data']         = $arr_data;

        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function salary_details($enc_id)
    {
        $arr_salary = $arr_overhed_exp = [];
        $user_id = base64_decode($enc_id) ?? 0;
        $obj_salary = $this->MasterSalaryModel->where('user_id',$user_id)
                                              ->with(['salary_details'])
                                              ->first();
        if($obj_salary){
            $arr_salary = $obj_salary->toArray();
        }

        $obj_overhed_exp = $this->OverheadExpancesModel->where('is_active','1')
                                                  ->get();
        if($obj_overhed_exp){
            $arr_overhed_exp = $obj_overhed_exp->toArray();
        }

        $arr_master_earning = [];
        $obj_master_earning = $this->MasterEarningModel->where('is_active','1')->get();
        if($obj_master_earning){
            $arr_master_earning = $obj_master_earning->toArray();
        }

        $obj_user = $this->User->where('id',$user_id)->select('id','emp_id','first_name','last_name','nationality_id')->first();
        if($obj_user){
            $arr_user = $obj_user->toArray();
        }

        $this->arr_view_data['arr_salary']         = $arr_salary;
        $this->arr_view_data['arr_master_earning'] = $arr_master_earning;
        $this->arr_view_data['arr_user']           = $arr_user;
        $this->arr_view_data['arr_overhed_exp']    = $arr_overhed_exp;

    	$this->arr_view_data['enc_id']           = $enc_id;
    	$this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

        if(isset($arr_salary) && sizeof($arr_salary)>0){
    	   return view($this->module_view_folder.'.salary_details',$this->arr_view_data);
        }
        else{
            return view($this->module_view_folder.'.edit_salary_details',$this->arr_view_data);
        }
    }

    public function edit_salary_details($enc_id)
    {
        $arr_salary = [];
        $user_id = base64_decode($enc_id) ?? 0;
    	$arr_master_earning = [];
    	$obj_master_earning = $this->MasterEarningModel->where('is_active','1')->get();
    	if($obj_master_earning){
    		$arr_master_earning = $obj_master_earning->toArray();
    	}

        $obj_user = $this->User->where('id',$user_id)->select('id','emp_id','first_name','last_name','nationality_id')->first();
        if($obj_user){
            $arr_user = $obj_user->toArray();
        }

        $obj_salary = $this->MasterSalaryModel->where('user_id',$user_id)
                                              ->with(['salary_details'])
                                              ->first();
        if($obj_salary){
            $arr_salary = $obj_salary->toArray();
        }

        $this->arr_view_data['arr_salary']         = $arr_salary;
        $this->arr_view_data['enc_id']             = $enc_id;
        $this->arr_view_data['arr_master_earning'] = $arr_master_earning;
        $this->arr_view_data['arr_user']           = $arr_user;
        $this->arr_view_data['module_title']       = $this->module_title;
        $this->arr_view_data['page_title']         = $this->module_title;
        $this->arr_view_data['module_url_path']    = $this->module_url_path;

    	return view($this->module_view_folder.'.edit_salary_details',$this->arr_view_data);
    }

    public function update_salary_details(Request $request){
        $arr_rules                      = [];
        $arr_rules['enc_id']            = 'required';
        $arr_rules['per_month']         = 'required';
        $arr_rules['total_monthly_amt'] = 'required';
        $arr_rules['total_annualy_amt'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $user_id = base64_decode($request->input('enc_id'));

        $arr_salary['user_id']       = $user_id;
        $arr_salary['basic']         = $request->input('per_month');
        $arr_salary['monthly_total'] = $request->input('total_monthly_amt');
        $arr_salary['annualy_total'] = $request->input('total_annualy_amt');

        $earning_id  = $request->input('earning_id');
        $cal_value   = $request->input('cal_value');
        $monthly_amt = $request->input('monthly_amt');

        $status                      = $this->MasterSalaryModel->updateOrCreate(['user_id'=>$user_id],$arr_salary);
        if($status){
            $id = $status->id;
            if(is_array($earning_id) && count($earning_id)>0){
                foreach ($earning_id as $key => $value) {

                    $arr_sal_details['master_sal_id'] = $id ?? 0;
                    $arr_sal_details['earning_id']    = $value ?? 0;
                    $arr_sal_details['cal_value']     = $cal_value[$key] ?? '';
                    $arr_sal_details['monthly_amt']   = $monthly_amt[$key] ?? '';
                        
                    $this->MasterSalaryDetailsModel->updateOrCreate(['master_sal_id'=>$id,'earning_id'=>$value],$arr_sal_details);
                }
            }

            Session::flash('success','Salary details saved successfully.');
            return redirect()->back();  
        }
        else
        {
            Session::flash('success','Something went wrong , please try again.');
            return redirect()->back(); 
        }
    }
}

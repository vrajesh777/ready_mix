<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PayScheduleModel;
use App\Models\PayRunModel;
use App\Models\MasterSalaryModel;
use App\Models\MasterSalaryDetailsModel;
use App\Models\SalaryModel;
use App\Models\SalaryDetailsModel;
use App\Models\LeaveApplicationModel;
use App\Models\AppliedLeaveDaysModel;
use App\Models\AttendanceModel;
use App\Models\User;
use App\Models\MasterEarningModel;
use App\Common\Services\ERP\ApiService;
use Session;
use Validator;
use Auth;

class PayRunController extends Controller
{
    public function __construct()
    {
        $this->PayScheduleModel         = new PayScheduleModel();
        $this->PayRunModel              = new PayRunModel();
        $this->MasterSalaryModel        = new MasterSalaryModel();
        $this->MasterSalaryDetailsModel = new MasterSalaryDetailsModel();
        $this->SalaryModel              = new SalaryModel();
        $this->SalaryDetailsModel       = new SalaryDetailsModel();
        $this->LeaveApplicationModel    = new LeaveApplicationModel();
        $this->AppliedLeaveDaysModel    = new AppliedLeaveDaysModel();
        $this->AttendanceModel          = new AttendanceModel();
        $this->User                     = new User();
        $this->MasterEarningModel       = new MasterEarningModel();
        $this->ApiService               = new ApiService();

        $this->auth               = auth();
        $this->arr_view_data      = [];
        $this->module_title       = 'Pay Run';
        $this->module_view_folder = 'hr.pay_run';
        $this->module_url_path    = url('/pay_run');
    }

    public function index()
    {
        $arr_data = $arr_pay_schedule = $arr_pay_run = $arr_prev_pay_run = $arr_payroll_history = [];
        $obj_pay_schedule = $this->PayScheduleModel->first();
        if($obj_pay_schedule){
        	$arr_pay_schedule = $obj_pay_schedule->toArray();
        }

        if(!empty($arr_pay_schedule)){

            $obj_pay_run = $this->PayRunModel->get();
            if($obj_pay_run){
                $arr_pay_run = $obj_pay_run->toArray();
            }

            if(empty($arr_pay_run)){
                $pay_run['pay_date']  = $arr_pay_schedule['first_pay_date'] ?? '';
                $pay_run['for_month'] = date('m',strtotime($arr_pay_schedule['first_pay_date'])) ?? '';
                $pay_run['for_year']  = date('Y',strtotime($arr_pay_schedule['first_pay_date'])) ?? '';
                $pay_run['net_pay']   = '10000';
                $pay_run['no_of_emp'] = '3';
                $this->PayRunModel->create($pay_run);
            }

            $obj_prev_pay_run = $this->PayRunModel->orderBy('id','DESC')->first();
            if($obj_prev_pay_run){
                $arr_prev_pay_run = $obj_prev_pay_run->toArray();
            }

            if(isset($arr_prev_pay_run) && sizeof($arr_prev_pay_run)>0){
                if($arr_prev_pay_run['status'] == '0'){
                    $arr_pay = $arr_prev_pay_run;
                }elseif($arr_prev_pay_run['status'] == '1'){
                    $month_year = date('Y-m', strtotime($arr_pay_schedule['first_pay_date']. ' + 1 Month'));
                    $month = date('m',strtotime($month_year)) ?? '';
                    $year  = date('Y',strtotime($month_year)) ?? '';
                    
                    if($arr_pay_schedule['pay_on'] == 0){
                       $days = cal_days_in_month(CAL_GREGORIAN,$month,$year); // 31
                    }
                    else{
                        $days = $arr_pay_schedule['on_every_month'] ?? '';
                    }
                    $pay_date = $month_year.'-'.$days;
                   
                    $pay_run['pay_date']  = $pay_date ?? '';
                    $pay_run['for_month'] = $month ?? '';
                    $pay_run['for_year']  = $year ?? '';
                    $pay_run['net_pay']   = '10000';
                    $pay_run['no_of_emp'] = '3';
                    $this->PayRunModel->create($pay_run);
                }
            }

            $obj_current_pay_run = $this->PayRunModel->orderBy('id','DESC')->first();
            if($obj_current_pay_run){
                $arr_current_pay_run = $obj_current_pay_run->toArray();
            }

            $obj_payroll_history = $this->PayRunModel->where('status','1')->get();
            if($obj_payroll_history){
                $arr_payroll_history = $obj_payroll_history->toArray();
            }

            $arr_master_salary = [];
            $arr_master_salary = $this->recalculate_salary_details(base64_encode($arr_current_pay_run['id']));

            $arr_data = [];
            $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];

            $emp_count = $this->User->whereNotIn('role_id',$arr_exclude)
                                   ->count();
                                   
            $this->arr_view_data['payroll_cost']     = isset($arr_master_salary['payroll_cost'])?number_format($arr_master_salary['payroll_cost'],2):0.00;
            $this->arr_view_data['emp_net_pay']      = isset($arr_master_salary['emp_net_pay'])?number_format($arr_master_salary['emp_net_pay'],2):0.00;

            $this->arr_view_data['emp_count']           = $emp_count ?? 0;
            $this->arr_view_data['arr_master_salary']   = $arr_master_salary;
            $this->arr_view_data['arr_current_pay_run'] = $arr_current_pay_run;
            $this->arr_view_data['arr_payroll_history'] = $arr_payroll_history;
            $this->arr_view_data['module_title']        = $this->module_title;
            $this->arr_view_data['page_title']          = $this->module_title;
            $this->arr_view_data['module_url_path']     = $this->module_url_path;

        	return view($this->module_view_folder.'.index',$this->arr_view_data);
        }
        else
        {
            Session::flash('error','Please set pay schedule first.');
            return redirect()->route('pay_schedule');
        }
    }

    public function pay_preview($enc_id)
    {   
        $arr_pay_run = $arr_pay_schedule = [];
        $obj_pay_run = $this->PayRunModel->where('id',base64_decode($enc_id))->first();
        if($obj_pay_run){
            $arr_pay_run = $obj_pay_run->toArray();
        }

        $obj_pay_schedule = $this->PayScheduleModel->first();
        if($obj_pay_schedule){
            $arr_pay_schedule = $obj_pay_schedule->toArray();
        }

        $obj_master_salary = $this->MasterSalaryModel->with(['user_details','salary_details'])->get();
        if($obj_master_salary){
            $arr_master_salary = $obj_master_salary->toArray();
        }

        $arr_extra_earning = [];
        $obj_extra_earning = $this->MasterEarningModel->where('is_extra','1')->get();
        if($obj_extra_earning){
            $arr_extra_earning = $obj_extra_earning->toArray();
        }

        $arr_master_salary = $this->recalculate_salary_details($enc_id);

        $this->arr_view_data['payroll_cost']     = isset($arr_master_salary['payroll_cost'])?number_format($arr_master_salary['payroll_cost'],2):0.00;
        $this->arr_view_data['emp_net_pay']      = isset($arr_master_salary['emp_net_pay'])?number_format($arr_master_salary['emp_net_pay'],2):0.00;
        $this->arr_view_data['arr_pay_run']      = $arr_pay_run;
        $this->arr_view_data['arr_pay_schedule'] = $arr_pay_schedule;
        $this->arr_view_data['arr_master_salary']= isset($arr_master_salary['arr_master_salary'])?$arr_master_salary['arr_master_salary']:[];
        $this->arr_view_data['arr_extra_earning']= $arr_extra_earning ?? [];
        $this->arr_view_data['enc_id']           = $enc_id;
        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

        return view($this->module_view_folder.'.regular_payroll',$this->arr_view_data);
    }

    public function record_payment_preview(Request $request)
    {   
        $enc_id = $request->input('enc_id');
        if($request->has('is_extra')){
            $is_extra_ids = $request->input('is_extra');
        }
        $id = base64_decode($enc_id);
        $obj_pay_run = $this->PayRunModel->where('id',$id)->first();
        if($obj_pay_run){
            $arr_emp_salary = $this->recalculate_salary_details_with_extra_earning_condi($enc_id,$is_extra_ids);


            $arr_pay_run = $arr_pay_schedule = [];
            $obj_pay_run = $this->PayRunModel->where('id',base64_decode($enc_id))->first();
            if($obj_pay_run){
                $arr_pay_run = $obj_pay_run->toArray();
            }

            $obj_pay_schedule = $this->PayScheduleModel->first();
            if($obj_pay_schedule){
                $arr_pay_schedule = $obj_pay_schedule->toArray();
            }

            $arr_extra_earning = [];
            $obj_extra_earning = $this->MasterEarningModel->where('is_extra','1')->get();
            if($obj_extra_earning){
                $arr_extra_earning = $obj_extra_earning->toArray();
            }

            $this->arr_view_data['arr_emp_salary'] = $arr_emp_salary;

            $this->arr_view_data['payroll_cost']     = isset($arr_emp_salary['payroll_cost'])?number_format($arr_emp_salary['payroll_cost'],2):0.00;
            $this->arr_view_data['emp_net_pay']      = isset($arr_emp_salary['emp_net_pay'])?number_format($arr_emp_salary['emp_net_pay'],2):0.00;
            $this->arr_view_data['arr_pay_run']      = $arr_pay_run;
            $this->arr_view_data['arr_pay_schedule'] = $arr_pay_schedule;
            $this->arr_view_data['arr_master_salary']= isset($arr_emp_salary['arr_master_salary'])?$arr_emp_salary['arr_master_salary']:[];
            $this->arr_view_data['arr_extra_earning']= $arr_extra_earning ?? [];
            $this->arr_view_data['enc_id']           = $enc_id;
            $this->arr_view_data['module_title']     = $this->module_title;
            $this->arr_view_data['page_title']       = $this->module_title;
            $this->arr_view_data['module_url_path']  = $this->module_url_path;

            return view($this->module_view_folder.'.record_payment_preview',$this->arr_view_data);
        }
        else{
            Session::flash('error','Invalid request');
            return redirect()->back();
        }
    }

    public function recalculate_salary_details($enc_id){

        $arr_pay_run = $arr_pay_schedule = [];
        $obj_pay_run = $this->PayRunModel->where('id',base64_decode($enc_id))->first();
        if($obj_pay_run){
            $arr_pay_run = $obj_pay_run->toArray();
        }

        $obj_pay_schedule = $this->PayScheduleModel->first();
        if($obj_pay_schedule){
            $arr_pay_schedule = $obj_pay_schedule->toArray();
        }

        $obj_master_salary = $this->MasterSalaryModel->with(['user_details','salary_details'])->get();
        if($obj_master_salary){
            $arr_master_salary = $obj_master_salary->toArray();
        }

        $payable_days = 0;
        if(isset($arr_pay_schedule['salary_on']) && $arr_pay_schedule['salary_on']!='' && $arr_pay_schedule['salary_on'] == 0){
            $payable_days = cal_days_in_month(CAL_GREGORIAN,$arr_pay_run['for_month'],$arr_pay_run['for_year']);
        }elseif(isset($arr_pay_schedule['salary_on']) && $arr_pay_schedule['salary_on']!='' && $arr_pay_schedule['salary_on'] == 1){
            $payable_days = $arr_pay_schedule['days_per_month'] ?? 0;
        }

        $month_days = cal_days_in_month(CAL_GREGORIAN,$arr_pay_run['for_month'],$arr_pay_run['for_year']);

        $payroll_cost = $emp_net_pay = 0;

        foreach ($arr_master_salary as $key => $value) {
            $lop_days = $unpaid_days = $absent_days = 0;

            $from_date = $arr_pay_run['for_year'].'-'.$arr_pay_run['for_month'].'-'.'01';
            $to_date = $arr_pay_run['for_year'].'-'.$arr_pay_run['for_month'].'-'.$month_days;

            $unpaid_days      = $this->count_unpaid_days($from_date,$to_date,$value['user_id']);
            $absent_days      = $this->count_absent_days($from_date,$to_date,$value['user_id']);

            $lop_days         = $unpaid_days + $absent_days;
            
            $paid_days = $payable_days - $lop_days;

            $earning_total = 0;
            foreach ($value['salary_details'] as $sal_key => $salary) {
                $amt_per_day = $salary['monthly_amt'] / $payable_days;
                $new_amt = $amt_per_day * $paid_days;
                $value['salary_details'][$sal_key]['new_amt'] = round($new_amt,2);

                $earning_total += $new_amt;
                unset($salary[$sal_key]['created_at']);
                unset($salary[$sal_key]['updated_at']);
            }

            $basic_per_day = $value['basic'] / $payable_days;
            $basic = round($basic_per_day * $paid_days,2);
            $arr_extra_hour = $arr_deducted_hour = [];
            if($value['user_details']['pay_overtime'] == 'yes'){
                $arr_extra_hour = $this->count_extra_hour($from_date,$to_date,$value['user_id']);
            }

            $arr_deducted_hour = $this->count_deducted_hour($from_date,$to_date,$value['user_id']);

            $basic_per_hour = $basic_per_day / 8;
            $overtime_pay = $lac_pay = 0;
            if(isset($arr_extra_hour) && !empty($arr_extra_hour)){
                $overtime_pay = $basic_per_hour * ($arr_extra_hour['extra_hour'] ?? 0);
            }

            if(isset($arr_deducted_hour) && !empty($arr_deducted_hour)){
                $lac_pay = $basic_per_hour * ($arr_deducted_hour['less_hour'] ?? 0);
            }            
            $new_basic = round((floatval($overtime_pay) + $basic - floatval($lac_pay)),2);
   
            $arr_master_salary[$key]['new_basic']         = $new_basic;
            $arr_master_salary[$key]['overtime_pay']      = $overtime_pay;
            $arr_master_salary[$key]['lac_pay']           = $lac_pay;
            $arr_master_salary[$key]['new_monthly_total'] = $new_monthly_total  = round($new_basic + $earning_total,2);
            $arr_master_salary[$key]['payment_status']    = '';
            $arr_master_salary[$key]['payment_date']      = $arr_pay_run['pay_date'];
            $arr_master_salary[$key]['paid_days']         = $paid_days;
            $arr_master_salary[$key]['unpaid_days']       = $lop_days;
            $arr_master_salary[$key]['salary_details']    = $value['salary_details'];
            unset($arr_master_salary[$key]['created_at']);
            unset($arr_master_salary[$key]['updated_at']);

            $payroll_cost += $value['monthly_total'] ?? 0;
            $emp_net_pay += $new_monthly_total ?? 0;
        }

        $arr_data['arr_master_salary'] = $arr_master_salary ?? [];
        $arr_data['payroll_cost']      = $payroll_cost ?? [];
        $arr_data['emp_net_pay']       = $emp_net_pay ?? [];

        return $arr_data;
    }

    public function recalculate_salary_details_with_extra_earning_condi($enc_id,$is_extra_ids){
        $arr_pay_run = $arr_pay_schedule = [];
        $obj_pay_run = $this->PayRunModel->where('id',base64_decode($enc_id))->first();
        if($obj_pay_run){
            $arr_pay_run = $obj_pay_run->toArray();
        }

        $obj_pay_schedule = $this->PayScheduleModel->first();
        if($obj_pay_schedule){
            $arr_pay_schedule = $obj_pay_schedule->toArray();
        }

        $obj_master_salary = $this->MasterSalaryModel->with(['user_details','salary_details'])->get();
        if($obj_master_salary){
            $arr_master_salary = $obj_master_salary->toArray();
        }

        $payable_days = 0;
        if(isset($arr_pay_schedule['salary_on']) && $arr_pay_schedule['salary_on']!='' && $arr_pay_schedule['salary_on'] == 0){
            $payable_days = cal_days_in_month(CAL_GREGORIAN,$arr_pay_run['for_month'],$arr_pay_run['for_year']);
        }elseif(isset($arr_pay_schedule['salary_on']) && $arr_pay_schedule['salary_on']!='' && $arr_pay_schedule['salary_on'] == 1){
            $payable_days = $arr_pay_schedule['days_per_month'] ?? 0;
        }

        $month_days = cal_days_in_month(CAL_GREGORIAN,$arr_pay_run['for_month'],$arr_pay_run['for_year']);

        $payroll_cost = $emp_net_pay = 0;

        foreach ($arr_master_salary as $key => $value) {
            $lop_days = $unpaid_days = $absent_days = 0;

            $from_date = $arr_pay_run['for_year'].'-'.$arr_pay_run['for_month'].'-'.'01';
            $to_date = $arr_pay_run['for_year'].'-'.$arr_pay_run['for_month'].'-'.$month_days;

            $unpaid_days = $this->count_unpaid_days($from_date,$to_date,$value['user_id']);
            $absent_days = $this->count_absent_days($from_date,$to_date,$value['user_id']);
            $lop_days = $unpaid_days + $absent_days;
            
            $paid_days = $payable_days - $lop_days;

            $earning_total = 0;
            foreach ($value['salary_details'] as $sal_key => $salary) {
                if(!in_array($salary['earning_id'],$is_extra_ids[$value['user_id']]))
                {
                    $amt_per_day = $salary['monthly_amt'] / $payable_days;
                    $new_amt = $amt_per_day * $paid_days;
                    $value['salary_details'][$sal_key]['new_amt'] = round($new_amt,2);

                    $earning_total += $new_amt;
                    unset($value['salary_details'][$sal_key]['created_at']);
                    unset($value['salary_details'][$sal_key]['updated_at']);
                }
                else{
                    unset($value['salary_details'][$sal_key]);
                }
            }
       
            $basic_per_day = $value['basic'] / $payable_days;
            $basic = round($basic_per_day * $paid_days,2);
            $arr_extra_hour = $arr_deducted_hour = [];
            if($value['user_details']['pay_overtime'] == 'yes'){
                $arr_extra_hour = $this->count_extra_hour($from_date,$to_date,$value['user_id']);
            }
            
            $arr_deducted_hour = $this->count_deducted_hour($from_date,$to_date,$value['user_id']);

            $basic_per_hour = $basic_per_day / 8;
            $overtime_pay = $lac_pay = 0;
            if(isset($arr_extra_hour) && !empty($arr_extra_hour)){
                $overtime_pay = $basic_per_hour * ($arr_extra_hour['extra_hour'] ?? 0);
            }

            if(isset($arr_deducted_hour) && !empty($arr_deducted_hour)){
                $lac_pay = $basic_per_hour * ($arr_deducted_hour['less_hour'] ?? 0);
            }            
            $new_basic = round((floatval($overtime_pay) + $basic - floatval($lac_pay)),2);

            $arr_master_salary[$key]['new_basic']         = $new_basic;
            $arr_master_salary[$key]['overtime_pay']      = $overtime_pay;
            $arr_master_salary[$key]['lac_pay']           = $lac_pay;
            $arr_master_salary[$key]['new_monthly_total'] = $new_monthly_total  = round($new_basic + $earning_total,2);
            $arr_master_salary[$key]['payment_status']    = '';
            $arr_master_salary[$key]['payment_date']      = $arr_pay_run['pay_date'];
            $arr_master_salary[$key]['paid_days']         = $paid_days;
            $arr_master_salary[$key]['unpaid_days']       = $lop_days;
            $arr_master_salary[$key]['salary_details']    = $value['salary_details'];
            unset($arr_master_salary[$key]['created_at']);
            unset($arr_master_salary[$key]['updated_at']);

            $payroll_cost += $value['monthly_total'] ?? 0;
            $emp_net_pay += $new_monthly_total ?? 0;
        }

        $arr_data['arr_master_salary'] = $arr_master_salary ?? [];
        $arr_data['payroll_cost']      = $payroll_cost ?? [];
        $arr_data['emp_net_pay']       = $emp_net_pay ?? [];

        return $arr_data;
    }

    public function count_unpaid_days($from_date,$to_date,$user_id){
        $unpaid_days = 0;
        $obj_leave = $this->LeaveApplicationModel->where('user_id',$user_id)
                                                 ->whereHas('leave_days',function($qry)use($from_date,$to_date){
                                                    $qry->whereDate('date','>=', $from_date);
                                                    $qry->whereDate('date','<=', $to_date);
                                                })
                                                ->with(['leave_days'])
                                                ->where('leave_type_id','2')
                                                ->get();

        if($obj_leave){
            $arr_leave = $obj_leave->toArray();
            if(isset($arr_leave) && sizeof($arr_leave)>0){
                foreach ($arr_leave as $key => $value) {
                    $unpaid_days += count($value['leave_days']) ?? 0;
                }
            }
        }

        return $unpaid_days;
    }

    public function count_absent_days($from_date,$to_date,$user_id){
        $absent_days = 0;
        $absent_days = $this->AttendanceModel->where('user_id',$user_id)
                                           ->whereDate('date','>=', $from_date)
                                           ->whereDate('date','<=', $to_date)
                                           ->where('status','Absent')
                                           ->count();
        return $absent_days;
    }

    public function count_extra_hour($from_date,$to_date,$user_id){
        $extra_hour = [];
        $obj_extra_hour = $this->AttendanceModel->where('user_id',$user_id)
                                           ->whereDate('date','>=', $from_date)
                                           ->whereDate('date','<=', $to_date)
                                           ->where('extra_hour','>','0')
                                           ->get();
        if($obj_extra_hour){
            $arr_extra_hour = $obj_extra_hour->toArray();
            $extra_hour['extra_hour'] = array_sum(array_column($arr_extra_hour,'extra_hour'));
            $extra_hour['extra_min'] = array_sum(array_column($arr_extra_hour,'extra_min'));
        }
        return $extra_hour;
    }

    public function count_deducted_hour($from_date,$to_date,$user_id){
        $less_hour = [];
        $obj_less_hour = $this->AttendanceModel->where('user_id',$user_id)
                                           ->whereDate('date','>=', $from_date)
                                           ->whereDate('date','<=', $to_date)
                                           ->where('less_hour','>','0')
                                           ->get();
        if($obj_less_hour){
            $arr_less_hour = $obj_less_hour->toArray();
            $less_hour['less_hour'] = array_sum(array_column($arr_less_hour,'less_hour'));
            $less_hour['min_min'] = array_sum(array_column($arr_less_hour,'min_min'));
        }
        return $less_hour;
    }


    


    public function record_payment(Request $request){
        $enc_id = $request->input('enc_id');
        $id = base64_decode($enc_id);
        $obj_pay_run = $this->PayRunModel->where('id',$id)->first();
        if($obj_pay_run){
            $arr_emp_salary = json_decode($request->input('arr_emp_salary'),true);

            if(isset($arr_emp_salary['arr_master_salary']) && sizeof($arr_emp_salary['arr_master_salary'])>0){
                foreach ($arr_emp_salary['arr_master_salary'] as $key => $value) {
                    $arr_salary = [];
                    $arr_salary['user_id']        = $value['user_id'] ?? '';
                    $arr_salary['basic']          = $value['new_basic'] ?? '';
                    $arr_salary['overtime_pay']   = $value['overtime_pay'] ?? '';
                    $arr_salary['lac_pay']        = $value['lac_pay'] ?? '';
                    $arr_salary['monthly_total']  = $value['new_monthly_total'] ?? '';
                    $arr_salary['gross_total']    = $value['monthly_total'] ?? '';
                    $arr_salary['payment_status'] = 'paid';
                    $arr_salary['payment_date']   = $value['payment_date'] ?? '';
                    $arr_salary['paid_days']      = $value['paid_days'] ?? '';
                    $arr_salary['unpaid_days']    = $value['unpaid_days'] ?? '';
                    $arr_salary['pay_run_id']     = $id ?? '';
                    $obj_salary = $this->SalaryModel->create($arr_salary);
                    if($obj_salary){
                        foreach ($value['salary_details'] as $sal_det => $sal_det_val) {
                            $arr_sal_details[$sal_det]['master_sal_id'] = $obj_salary->id ?? '';
                            $arr_sal_details[$sal_det]['earning_id'] = $sal_det_val['earning_id'] ?? '';
                            $arr_sal_details[$sal_det]['cal_value'] = $sal_det_val['cal_value'] ?? '';
                            $arr_sal_details[$sal_det]['monthly_amt'] = $sal_det_val['new_amt'] ?? '';
                        }
                        if(isset($arr_sal_details) && sizeof($arr_sal_details)>0){
                            $this->SalaryDetailsModel->insert($arr_sal_details);
                        }
                    }
                }

                $this->PayRunModel->where('id',$id)->update(['status'=>'1']);
                
                Session::flash('success','Payment recorded successfully.');
                return redirect()->route('pay_summary',$enc_id);
            }
        }
        else{
            Session::flash('error','Invalid request');
            return redirect()->back();
        }
    }

    public function pay_summary($enc_id){

        $id = base64_decode($enc_id);
        $obj_pay_run = $this->PayRunModel->where('id',$id)
                                        ->where('status','1')
                                        ->with(['emp_salary.emp_salary_details','emp_salary.user_details'])
                                        ->first();
        if($obj_pay_run)
        {
            $arr_pay_run = $obj_pay_run->toArray();
            $obj_pay_schedule = $this->PayScheduleModel->first();
            if($obj_pay_schedule){
                $arr_pay_schedule = $obj_pay_schedule->toArray();
            }

            $this->arr_view_data['arr_pay_run'] = $arr_pay_run;
            $this->arr_view_data['arr_pay_schedule'] = $arr_pay_schedule;
            $this->arr_view_data['module_title']     = $this->module_title;
            $this->arr_view_data['page_title']       = $this->module_title;
            $this->arr_view_data['module_url_path']  = $this->module_url_path;

            return view($this->module_view_folder.'.pay_summary',$this->arr_view_data);

        }else
        {
            Session::flash('error','Invalid request');
            return redirect()->back();
        }
    }

    public function view_payslip($enc_id){

        $id = base64_decode($enc_id);

        $obj_salary = $this->SalaryModel->where('id',$id)->with(['emp_salary_details.earning_details','user_details'])->first();
        if($obj_salary){

            $arr_salary = $obj_salary->toArray();
            $this->arr_view_data['arr_salary']      = $arr_salary;
            $this->arr_view_data['module_title']    = $this->module_title;
            $this->arr_view_data['page_title']      = $this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;

            return view($this->module_view_folder.'.view_payslip',$this->arr_view_data);
        }
        else{
            Session::flash('error','Invalid request');
            return redirect()->back();
        }

       
    }
    public function pay_run_push_to_erp($enc_id)
    {
        $arr_salary = $arr_grn=[];
        $salary_id  = base64_decode($enc_id);
        $obj_salary = $this->SalaryModel->where('id',$salary_id)->with(['emp_salary_details.earning_details','user_details'])->first();
        if($obj_salary){
            $arr_salary = $obj_salary->toArray();
        }
        $emp_fname = $arr_salary['user_details']['first_name']??'';
        $emp_lname = $arr_salary['user_details']['last_name']??'';
        $emp_name  = $emp_fname." ".$emp_lname;
        $gross_salary_total = $arr_salary['gross_total']??'';
        $invoice_ref_no = genrate_transaction_unique_number();
        $salary_month   = date("F",strtotime($arr_salary['payment_date']));
 

        $arr_grn['document_ref']               = $invoice_ref_no;
        $arr_grn['currency']                   = 'SAR';
        $arr_grn['memo']                       =  $emp_name??'';
        $arr_grn['items'][0]['account_code']   = '1250';
        $arr_grn['items'][0]['amount']         =  $gross_salary_total;
        $arr_grn['items'][0]['memo']           = 'Employee Salary for month '.$salary_month.' of employee '.$emp_name;

        $gl_response =  $this->ApiService->execute_curl('journal',$arr_grn);
        if($gl_response!="")
        {
            $obj_salary->update(['is_added_on_erp'=>'1']);
             Session::flash('success','Payment entry successfully pushed in erp');
        }
        else
        {
              Session::flash('error','Error occure');
        }
        return redirect()->back();
    }
}

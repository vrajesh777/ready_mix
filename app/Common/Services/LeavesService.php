<?php

namespace App\Common\Services;

use \Session;
use \Mail;
use App\Models\User;
use App\Models\AppliedLeaveDaysModel;
use App\Models\LeaveApplicationModel;
use App\Models\LeaveTypesModel;
use App\Models\LeaveBalanceModel;
use App\Models\EmpLeavePolicyModel;
use Exception;
use Carbon\Carbon;

class LeavesService
{
	public function __construct() 
	{
        $this->UserModel             = new User;
        $this->AppliedLeaveDaysModel = new AppliedLeaveDaysModel;
        $this->LeaveApplicationModel = new LeaveApplicationModel;
        $this->LeaveTypesModel       = new LeaveTypesModel;
        $this->LeaveBalanceModel     = new LeaveBalanceModel;
        $this->EmpLeavePolicyModel   = new EmpLeavePolicyModel;
	}

    public function validate_leave_criteria($user_id, $leave_type_id, $from_date, $to_date,$leave_count) {
        $args = func_get_args();
        $arr_ret = $arr_leave_type = $employee = [];

        /*$obj_leave_type = $this->LeaveTypesModel
                                            ->with([
                                                'entitlement',
                                                'applicable',
                                                'exceptions',
                                                'restrictions',
                                            ])
                                            ->where('id', $leave_type_id)->first();*/

        $valid_start_year = date('Y');
        $valid_end_year = date('Y',strtotime('+1 year',strtotime($valid_start_year)));

        $obj_leave_type = $this->EmpLeavePolicyModel->where('leave_types_id', $leave_type_id)
                                                    ->where('user_id',$user_id)
                                                    ->whereYear('start',$valid_start_year)
                                                    ->whereYear('end',$valid_end_year)
                                                    ->first();
        if(!$obj_leave_type) {
            $arr_ret['status'] = 'error';
            $arr_ret['message'] = 'Leave type not found!';
            return $arr_ret;
        }else{
            $arr_leave_type = $obj_leave_type->toArray();
        }

        $obj_empl = $this->UserModel
                                    ->with(['department','designation','role'])
                                    ->where('id', $user_id)->first();

        if(!$obj_empl) {
            $arr_ret['status'] = 'error';
            $arr_ret['message'] = 'Employee not found!';
            return $arr_ret;
        }else{
            $employee = $obj_empl->toArray();
        }

        $check_leave_validity = $this->check_leave_validity($arr_leave_type, $from_date, $to_date);
        if($check_leave_validity['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_leave_validity['message']??'';
            return $arr_ret;
        }

        $check_effective_from_criteria = $this->check_effective_from_criteria($employee, $arr_leave_type);
        if($check_effective_from_criteria['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_effective_from_criteria['message']??'';
            return $arr_ret;
        }

        $check_gender_criteria = $this->check_gender_criteria($employee, $arr_leave_type);
        if($check_gender_criteria['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_gender_criteria['message']??'';
            return $arr_ret;
        }

        $check_marital_status_criteria = $this->check_marital_status_criteria($employee, $arr_leave_type);
        if($check_marital_status_criteria['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_marital_status_criteria['message']??'';
            return $arr_ret;
        }

        $check_empl_department_criteria = $this->check_empl_department_criteria($employee, $arr_leave_type);
        if($check_empl_department_criteria['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_empl_department_criteria['message']??'';
            return $arr_ret;
        }

        $check_empl_designation_criteria = $this->check_empl_designation_criteria($employee, $arr_leave_type);
        if($check_empl_designation_criteria['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_empl_designation_criteria['message']??'';
            return $arr_ret;
        }

        $check_empl_roles_criteria = $this->check_empl_roles_criteria($employee, $arr_leave_type);
        if($check_empl_roles_criteria['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_empl_roles_criteria['message']??'';
            return $arr_ret;
        }

        $check_user_leaves_between_dates = $this->check_user_leaves_between_dates($user_id,$from_date,$to_date);
        if($check_user_leaves_between_dates['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_user_leaves_between_dates['message']??'';
            return $arr_ret;
        }

        $check_user_together_leaves = $this->check_user_together_leaves($from_date,$to_date,$employee,$arr_leave_type);
        if($check_user_together_leaves['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_user_together_leaves['message']??'';
            return $arr_ret;
        }

        $check_future_date_restriction = $this->check_future_date_restriction($from_date,$to_date,$arr_leave_type);
        if($check_future_date_restriction['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_future_date_restriction['message']??'';
            return $arr_ret;
        }

        $check_exceed_leave_balance = $this->check_exceed_leave_balance($user_id,$arr_leave_type,$leave_count);
        if($check_exceed_leave_balance['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_exceed_leave_balance['message']??'';
            return $arr_ret;
        }

        $check_min_leave_per_application = $this->check_min_leave_per_application($user_id,$arr_leave_type,$leave_count);
        if($check_min_leave_per_application['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_min_leave_per_application['message']??'';
            return $arr_ret;
        }

        $check_max_leave_per_application = $this->check_max_leave_per_application($user_id,$arr_leave_type,$leave_count);
        if($check_max_leave_per_application['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_max_leave_per_application['message']??'';
            return $arr_ret;
        }

        $check_max_consecutive_application = $this->check_max_consecutive_application($user_id,$arr_leave_type,$leave_count);
        if($check_max_consecutive_application['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_max_consecutive_application['message']??'';
            return $arr_ret;
        }

        $check_min_gap_between_two_application = $this->check_min_gap_between_two_application($user_id,$from_date,$to_date,$arr_leave_type);
        if($check_min_gap_between_two_application['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_min_gap_between_two_application['message']??'';
            return $arr_ret;
        }

        $check_request_for_past_date = $this->check_request_for_past_date($user_id,$from_date,$to_date,$arr_leave_type);
        if($check_request_for_past_date['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_request_for_past_date['message']??'';
            return $arr_ret;
        }

        $check_request_for_future_date = $this->check_request_for_future_date($user_id,$from_date,$to_date,$arr_leave_type);
        if($check_request_for_future_date['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_request_for_future_date['message']??'';
            return $arr_ret;
        }     

        $check_past_date_limit = $this->check_past_date_limit($user_id,$from_date,$to_date,$arr_leave_type);
        if($check_past_date_limit['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_past_date_limit['message']??'';
            return $arr_ret;
        }

        $check_future_date_limit = $this->check_future_date_limit($user_id,$from_date,$to_date,$arr_leave_type);
        if($check_future_date_limit['status'] != 'valid') {
            $arr_ret['status'] = 'invalid';
            $arr_ret['message'] = $check_future_date_limit['message']??'';
            return $arr_ret;
        }
    }

    public function check_leave_validity($arr_leave_type, $from_date, $to_date) {

        $arr_resp = [];
        $valid_from = $arr_leave_type['start']??'';
        $valid_till = $arr_leave_type['end']??'';
        $nowDate = Carbon::now();

        if(trim($valid_from) != '') {
            $valid_from = Carbon::createFromFormat('Y-m-d', $valid_from);
            $result = $valid_from->gt($nowDate);

            if($valid_from->gt($nowDate)) {
                $arr_resp['status'] = ['invalid'];
                $arr_resp['message'] = "This leave is valid from date: ".$valid_from->format('d-M-Y');
                return $arr_resp;
            }
        }
        if(trim($valid_till) != '') {
            $valid_till = Carbon::createFromFormat('Y-m-d', $valid_till);
            $result = $nowDate->gt($valid_till);

            if($nowDate->gt($valid_till)) {
                $arr_resp['status'] = ['invalid'];
                $arr_resp['message'] = "This leave is valid till date: ".$valid_till->format('d-M-Y');
                return $arr_resp;
            }
        }

        $arr_resp['status'] = 'valid';
        return $arr_resp;
    }

    public function check_effective_from_criteria($employee, $arr_leave_type) {
        $arr_resp = [];
        //$arr_entitlement = $arr_leave_type['entitlement']??[];
        $effective_unit = $arr_leave_type['effective_unit']??'';
        $effective_period = $arr_leave_type['effective_period']??'';
        $exp_field = $arr_leave_type['exp_field']??'';

        $effctv_date = '';
        if($exp_field == 'date_of_join') {
            $effctv_date = $employee['join_date']??'';
        }elseif($exp_field == 'date_of_conf') {
            $effctv_date = $employee['confirm_date']??'';
        }

        if($effctv_date!='') {
            $effctv_date = Carbon::createFromFormat('Y-m-d', trim($effctv_date));
            if($effective_period > 0) {
                switch ($effective_unit) {
                    case 'months':
                        $effctv_date = $effctv_date->addMonths($effective_period);
                        break;
                    case 'days':
                        $effctv_date = $effctv_date->addDays($effective_period);
                        break;
                    case 'years':
                        $effctv_date = $effctv_date->addYear($effective_period);
                        break;
                }
            }
            if($effctv_date->isPast()) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'You are applicable for this leave from date '.$effctv_date->format('d-M-Y');
            }
        }else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_gender_criteria($employee, $arr_leave_type) {
        $arr_resp = [];
        $user_gender = $employee['gender']??'';
        //$arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_genders = json_decode($arr_leave_type['genders']??'');

        if(!empty($arr_appl_genders)) {
            // $arr_resp['status'] = in_array($user_gender, $arr_appl_genders)?'valid':'invalid';
            if(in_array($user_gender, $arr_appl_genders)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for gender ".ucfirst($user_gender);
            }
        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_marital_status_criteria($employee, $arr_leave_type) {
        $arr_resp = [];
        $user_marital_status = $employee['marital_status']??'';
        //$arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_marital_status = json_decode($arr_leave_type['marital_status']??'');

        if(!empty($arr_appl_marital_status)) {
            if(in_array($user_marital_status, $arr_appl_marital_status)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for Marital status: ".ucfirst($user_marital_status);
            }
        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_empl_department_criteria($employee, $arr_leave_type) {
        $arr_resp = [];
        $user_dept_id = $employee['department_id']??'';
        $user_department = $employee['department']??[];
        //$arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_departments = json_decode($arr_leave_type['departments']??'');
        //$arr_exception = $arr_leave_type['exceptions']??[];
        $arr_excpt_departments = json_decode($arr_leave_type['departments']??'');

        if(!empty($arr_appl_departments)) {
            if(in_array($user_dept_id, $arr_appl_departments)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for department: ".($user_department['name']??'');
            }
        }if(!empty($arr_excpt_departments)) {
            if(!in_array($user_dept_id, $arr_excpt_departments)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for department: ".($user_department['name']??'');
            }
        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_empl_designation_criteria($employee, $arr_leave_type) {
        $arr_resp = [];
        $user_desgn_id = $employee['designation_id']??'';
        $user_designation = $employee['designation']??[];
        //$arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_departments = json_decode($arr_leave_type['designations']??'');
        //$arr_exception = $arr_leave_type['exceptions']??[];
        $arr_excpt_designations = json_decode($arr_leave_type['designations']??'');

        if(!empty($arr_appl_departments)) {
            if(in_array($user_desgn_id, $arr_appl_departments)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for designation: ".($user_designation['name']??'');
            }
        }if(!empty($arr_excpt_designations)) {
            if(!in_array($user_desgn_id, $arr_excpt_designations)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for designation: ".($user_designation['name']??'');
            }
        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_empl_roles_criteria($employee, $arr_leave_type) {
        $arr_resp = [];
        $user_role_id = $employee['role_id']??'';
        $user_role = $employee['role']??[];
        //$arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_employee_types = json_decode($arr_leave_type['employee_types']??'');
        //$arr_exception = $arr_leave_type['exceptions']??[];
        //$arr_excpt_employee_types = json_decode($arr_leave_type['employee_types']??'');

        if(!empty($arr_appl_employee_types)) {
            if(in_array($user_role_id, $arr_appl_employee_types)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for role: ".($user_role['name']??'');
            }
        }/*elseif(!empty($arr_excpt_employee_types)) {
            if(!in_array($user_role_id, $arr_excpt_employee_types)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for role: ".($user_role['name']??'');
            }
        }*/else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_user_leaves_between_dates($user_id, $start_date, $end_date) {
        $pre_leaves = $this->get_user_leaves_between_dates($user_id, $start_date, $end_date);

        if(!empty($pre_leaves)) {

            $leave_type_details = $pre_leaves['leave_type_details']??[];
            $leave_days = $pre_leaves['leave_days']??[];

            $msg = "Sorry, You've already applied for ";

            if(!empty($leave_type_details)) {
                $msg .= $leave_type_details['title'].' ';
            }
            if(!empty($leave_days)) {
                $leave_days = array_values($leave_days);
                if(count($leave_days) > 1) {
                    $startDt = date('d-M-Y', strtotime($leave_days[0]['date']??''));
                    $endDt = date('d-M-Y', strtotime(end($leave_days)['date']??''));
                    $msg .= 'from '.$startDt.' to '.$endDt;
                }elseif(count($leave_days) == 1){
                    $msg .= 'on '.$leave_days[0]['date']??'';
                }
            }
            $msg .= ' !';

            $arr_resp['status']         = 'invalid';
            $arr_resp['message']        = $msg;
        }else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

	public function get_user_leaves_between_dates($user_id, $start_date, $end_date) {

        $arr_resp = [];

        $from_date = Carbon::createFromFormat('d/m/Y', trim($start_date))->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d/m/Y', trim($end_date))->format('Y-m-d');

        $obj_leave_appl = $this->LeaveApplicationModel->whereHas('leave_days', function($q)use($from_date,$to_date){
                                                   $q->whereBetween('date',[$from_date,$to_date]);
                                                })
                                                ->with([
                                                    'leave_type_details',
                                                    'leave_days'=>function($q)use($from_date,$to_date){
                                                        $q->whereBetween('date',[$from_date,$to_date]);
                                                    }
                                                ])
                                                ->where('user_id', $user_id)
                                                ->first();

        if($obj_leave_appl) {
            $arr_emp_shifts = $obj_leave_appl->toArray();
            $arr_resp = $arr_emp_shifts;
        }

        return $arr_resp;
	}

    public function check_user_together_leaves($from_date,$to_date,$employee,$arr_leave_type) {

        $arr_resp = [];
        $user_id = $employee['id']??'';
        //$arr_restrictions = $arr_leave_type['restrictions']??[];
        $arr_restr_leaves = json_decode($arr_leave_type['blocked_clubs']??'');

        if(!empty($arr_restr_leaves)) {

            $obj_leave_types = $this->LeaveTypesModel->whereIn('id', $arr_restr_leaves)->get();

            if($obj_leave_types->count() > 0) {

                $date_before = Carbon::createFromFormat('d/m/Y',$from_date)->subDays(1);
                $date_after = Carbon::createFromFormat('d/m/Y',$to_date)->addDays(1);

                $pre_leaves = $this->get_user_leaves_between_dates($user_id, $date_before->format('d/m/Y'), $date_after->format('d/m/Y'));

                if(in_array(($pre_leaves['leave_type_id']??''), $arr_restr_leaves)) {

                    $appl_leave_type_dtls = $pre_leaves['leave_type_details']??[];

                    $arr_resp['status'] = 'invalid';
                    $arr_resp['message'] = "Can't have leave together with ".($appl_leave_type_dtls['title']??'');
                }else{
                    $arr_resp['status'] = 'valid';
                }
            }

        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_future_date_restriction($from_date,$to_date,$arr_leave_type) {
        $arr_resp = [];
        //$arr_restrictions = $arr_leave_type['restrictions']??[];

        $from_date = Carbon::createFromFormat('d/m/Y',$from_date);
        $nowDate = Carbon::now();

        if(isset($arr_leave_type['futurebooking_notice_enable']) && $arr_leave_type['futurebooking_notice_enable']== '1') {
            $futurebooking_notice = $arr_leave_type['futurebooking_notice']??0;
            if($futurebooking_notice > 0) {
                $diff = $from_date->diffInDays($nowDate);
                if($diff < $futurebooking_notice) {
                    $arr_resp['status'] = 'invalid';
                    $arr_resp['message'] = 'You have to apply before '.$futurebooking_notice.' days for this leave!';
                }else{
                    $arr_resp['status'] = 'valid';
                }
            }else{
                $arr_resp['status'] = 'valid';
            }

        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function check_exceed_leave_balance($user_id,$arr_leave_type,$leave_count){
        $arr_resp = [];
        $obj_empl = $this->LeaveBalanceModel->where('user_id',$user_id)
                                            ->where('leave_type_id',$arr_leave_type['leave_types_id'])
                                            ->orderBy('id','DESC')
                                            ->first();
        $balance = $obj_empl->balance ?? 0;
        $paid_days = $obj_empl->paid_days ?? 0;

        if(isset($arr_leave_type['exceed_maxcount']) && $arr_leave_type['exceed_maxcount']!='' && $arr_leave_type['exceed_maxcount'] == 0){
            if($leave_count > $paid_days || $leave_count > $balance){
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'Sorry! your leave limit is exceeded.';
            }else{
                $arr_resp['status'] = 'valid';
            }
        }else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_min_leave_per_application($user_id,$arr_leave_type,$leave_count){
        $min_leave_enable  = $arr_leave_type['min_leave_enable'] ?? 0;
        $min_leave_per_app = $arr_leave_type['min_leave'] ?? 0;
        if($min_leave_enable == 1){
            if($min_leave_per_app < $leave_count){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'Min leave per application : '.$min_leave_per_app.' days.';
            }
        }
        else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_max_leave_per_application($user_id,$arr_leave_type,$leave_count){
        $max_leave_enable  = $arr_leave_type['max_leave_enable'] ?? 0;
        $max_leave_per_app = $arr_leave_type['max_leave'] ?? 0;
        if($max_leave_enable == 1){
            if($max_leave_per_app > $leave_count){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'Max leave per application : '.$max_leave_per_app.' days.';
            }
        }
        else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_max_consecutive_application($user_id,$arr_leave_type,$leave_count){
        $max_consecutive_enable  = $arr_leave_type['max_consecutive_enable'] ?? 0;
        $max_consecutive = $arr_leave_type['max_consecutive'] ?? 0;
        if($max_consecutive_enable == 1){
            if($max_consecutive > $leave_count){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'Max consecutive leave per application : '.$max_consecutive.' days.';
            }
        }
        else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_min_gap_between_two_application($user_id,$from_date,$to_date,$arr_leave_type){
        $obj_leave_application = $this->LeaveApplicationModel->where('user_id',$user_id)
                                                             ->with(['leave_days'=>function($qry){
                                                                $qry->orderBy('id','DESC');
                                                                $qry->first();
                                                             }])
                                    ->orderBy('id','DESC')
                                    ->first();
        $recent_app_date = $obj_leave_application->leave_days[0]['date'] ?? '';

        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $diff_in_days = $from_date->diffInDays($recent_app_date);

        $min_gap_enable  = $arr_leave_type['min_gap_enable'] ?? 0;
        $min_gap = $arr_leave_type['min_gap'] ?? 0;
        if($min_gap_enable == 1){
            if($min_gap < $diff_in_days){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'Min gap between two application : '.$min_gap.' days.';
            }
        }
        else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_request_for_past_date($user_id,$from_date,$to_date,$arr_leave_type){
        $pastbooking_enable = $arr_leave_type['pastbooking_enable'] ?? 0;

        $nowDate = Carbon::now();
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $diff_in_days = $nowDate->diffInDays($from_date);
        if($pastbooking_enable == 1){
            if(0 <= $diff_in_days){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "You can't request leave for past days.";
            }
        }
        elseif($pastbooking_enable == 0 && 0 == $diff_in_days){
            $arr_resp['status'] = 'valid';
        }
        else{
            $arr_resp['status'] = 'invalid';
            $arr_resp['message'] = "You can't request leave for past days.";
        }
        return $arr_resp;
    }

    public function check_request_for_future_date($user_id,$from_date,$to_date,$arr_leave_type){
        $futurebooking_enable = $arr_leave_type['futurebooking_enable'] ?? 0;

        $nowDate = Carbon::now();
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $diff_in_days = $nowDate->diffInDays($from_date);
        if($futurebooking_enable == 1){
            if(0 <= $diff_in_days){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "You can't request leave for future days.";
            }
        }
        elseif($futurebooking_enable == 0 && 0 == $diff_in_days){
            $arr_resp['status'] = 'valid';
        }
        else{
            $arr_resp['status'] = 'invalid';
            $arr_resp['message'] = "You can't request leave for future days.";
        }
        return $arr_resp;
    }

    public function check_past_date_limit($user_id,$from_date,$to_date,$arr_leave_type){
        $pastbooking_limit_enable  = $arr_leave_type['pastbooking_limit_enable'] ?? 0;
        $pastbooking_limit = $arr_leave_type['pastbooking_limit'] ?? 0;

        $nowDate = Carbon::now();
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $diff_in_days = $nowDate->diffInDays($from_date);

        if($pastbooking_limit_enable == 1){
            if($pastbooking_limit > $diff_in_days){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'You can request leave only for the past : '.$pastbooking_limit.' days.';
            }
        }
        else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function check_future_date_limit($user_id,$from_date,$to_date,$arr_leave_type){
        $futurebooking_limit_enable  = $arr_leave_type['futurebooking_limit_enable'] ?? 0;
        $futurebooking_limit = $arr_leave_type['futurebooking_limit'] ?? 0;

        $nowDate = Carbon::now();
        $from_date = Carbon::createFromFormat('d/m/Y', $from_date);
        $diff_in_days = $nowDate->diffInDays($from_date);

        if($futurebooking_limit_enable == 1){
            if($futurebooking_limit > $diff_in_days){
                $arr_resp['status'] = 'valid';
            }
            else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = 'You can request leave only for the future : '.$futurebooking_limit.' days from todays.';
            }
        }
        else{
            $arr_resp['status'] = 'valid';
        }
        return $arr_resp;
    }

    public function get_employees_leave_balance($arr_users,$arr_request) {

        $arr_ret = $arr_leave_type = $arr_applcns = [];

        $obj_leave_type = $this->LeaveTypesModel->with([
                                                    'entitlement',
                                                    'applicable',
                                                    'exceptions',
                                                    'restrictions',
                                                ])->get();
        if($obj_leave_type->count() > 0) { $arr_leave_type = $obj_leave_type->toArray(); }

        /*$obj_applcns = $this->LeaveApplicationModel->with(['leave_days','leave_type_details'])->get();
        if($obj_applcns->count() > 0) { $arr_applcns = $obj_applcns->toArray(); }*/

        if(!empty($arr_users)) {
            foreach($arr_users as $index => $user) {
                $arr_temp = $this->caculate_user_leaves($user, $arr_leave_type,$arr_request);

                $arr_users[$index]['leave_type_bal'] = $arr_temp['leave_type_bal'] ?? [];
                $arr_users[$index]['taken_leave'] = $arr_temp['taken_leave'] ?? [];
            }
        }
        //dd($arr_users);
        return $arr_users;
    }

    public function caculate_user_leaves($user, $arr_leave_type,$arr_request) {
        $arr_ret = $arr_leave_bal = [];

        $user_id = $user['id']??'';

        $year = date('Y', strtotime('+1 year'));
        $obj_leave_bal = $this->LeaveBalanceModel->whereYear('valid_till', '=', $year)
                                                 ->get();
        if($obj_leave_bal)
        {
            $arr_leave_bal = $obj_leave_bal->toArray();
        }

        if(!empty($arr_leave_type)) {
            foreach ($arr_leave_type as $key => $leave_type) {

                $type_id = $leave_type['id']??'';
                $applied_leave_count = 0;
                $applied_leave_count = $this->calculate_applied_leaves($type_id,$user_id,$arr_request);

                //$arr_ret[$type_id] = $leave_type['paid_days']??0;
                foreach($arr_leave_bal as $bal) {
                    $appld_type_id = $bal['leave_type_id']??'';
                    $appld_user_id = $bal['user_id']??'';
                    if( $appld_user_id == $user_id && $appld_type_id == $type_id ) {
                        $arr_ret['leave_type_bal'][$type_id] = $bal['balance'] ?? 0;
                        $arr_ret['taken_leave'][$type_id] = $applied_leave_count ?? 0;
                        //$arr_ret['taken_leave'][$type_id] = $bal['taken_leave'] ?? 0;
                    }
                }
            }
        }
        return $arr_ret;
    }

    public function calculate_applied_leaves($type_id,$user_id,$arr_request){
        $leave_days = 0;
        $start_date = $arr_request['start_date'] ?? '';
        $end_date = $arr_request['end_date'] ?? '';
        $obj_applcns = $this->LeaveApplicationModel->with(['leave_days',
                                                            'leave_type_details'])
                                                    ->where('leave_type_id',$type_id)
                                                    ->where('user_id',$user_id);

        if($start_date!='' && $end_date!=''){
            $obj_applcns = $obj_applcns->whereHas('leave_days',function($qry)use($start_date,$end_date){
                                                    $qry->whereDate('date','>=', $start_date);
                                                    $qry->whereDate('date','<=', $end_date);
                                                })->with(['leave_days'=>function($qry)use($start_date,$end_date){
                                                    $qry->whereDate('date','>=', $start_date);
                                                    $qry->whereDate('date','<=', $end_date);
                                                }]);
        }

        $obj_applcns = $obj_applcns->get();
        if($obj_applcns){ 
            $arr_applcns = $obj_applcns->toArray(); 
            if(!empty($arr_applcns)){
                foreach ($arr_applcns as $key => $value) {
                    $leave_days +=  isset($value['leave_days'])?count($value['leave_days']) :0; 
                }
            }
           
        }
        return $leave_days;
    }

    public function working_get_employees_leave_balance($arr_users,$arr_request) {

        $arr_ret = $arr_leave_type = $arr_applcns = [];

        $obj_leave_type = $this->LeaveTypesModel->with([
                                                    'entitlement',
                                                    'applicable',
                                                    'exceptions',
                                                    'restrictions',
                                                ])->get();
        if($obj_leave_type->count() > 0) { $arr_leave_type = $obj_leave_type->toArray(); }

        /*$obj_applcns = $this->LeaveApplicationModel->with(['leave_days','leave_type_details'])->get();
        if($obj_applcns->count() > 0) { $arr_applcns = $obj_applcns->toArray(); }*/

        if(!empty($arr_users)) {
            foreach($arr_users as $index => $user) {
                $arr_temp = $this->caculate_user_leaves($user, $arr_leave_type);

                $arr_users[$index]['leave_type_bal'] = $arr_temp['leave_type_bal'] ?? [];
                $arr_users[$index]['taken_leave'] = $arr_temp['taken_leave'] ?? [];
            }
        }
        //dd($arr_users);
        return $arr_users;
    }

    public function working_caculate_user_leaves($user, $arr_leave_type) {

        //dump($arr_applcns);
        $arr_ret = $arr_leave_bal = [];

        $user_id = $user['id']??'';

        $year = date('Y', strtotime('+1 year'));
        $obj_leave_bal = $this->LeaveBalanceModel->whereYear('valid_till', '=', $year)
                                                 ->get();
        if($obj_leave_bal)
        {
            $arr_leave_bal = $obj_leave_bal->toArray();
        }

        if(!empty($arr_leave_type)) {
            foreach ($arr_leave_type as $key => $leave_type) {

                $type_id = $leave_type['id']??'';
                //$arr_ret[$type_id] = $leave_type['paid_days']??0;
                foreach($arr_leave_bal as $bal) {
                    $appld_type_id = $bal['leave_type_id']??'';
                    $appld_user_id = $bal['user_id']??'';
                    if( $appld_user_id == $user_id && $appld_type_id == $type_id ) {
                        $arr_ret['leave_type_bal'][$type_id] = $bal['balance'] ?? 0;
                        $arr_ret['taken_leave'][$type_id] = $bal['taken_leave'] ?? 0;
                    }
                }
            }
        }
        return $arr_ret;
    }
}

?>
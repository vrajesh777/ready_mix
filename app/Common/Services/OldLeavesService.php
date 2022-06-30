<?php

namespace App\Common\Services;

use \Session;
use \Mail;
use App\Models\User;
use App\Models\AppliedLeaveDaysModel;
use App\Models\LeaveApplicationModel;
use App\Models\LeaveTypesModel;
use Exception;
use Carbon\Carbon;

class OldLeavesService
{
	public function __construct() 
	{
        $this->UserModel                = new User;
        $this->AppliedLeaveDaysModel    = new AppliedLeaveDaysModel;
        $this->LeaveApplicationModel    = new LeaveApplicationModel;
        $this->LeaveTypesModel          = new LeaveTypesModel;
	}

    public function validate_leave_criteria($user_id, $leave_type_id, $from_date, $to_date) {
        $args = func_get_args();
        $arr_ret = $arr_leave_type = $employee = [];

        $obj_leave_type = $this->LeaveTypesModel
                                            ->with([
                                                'entitlement',
                                                'applicable',
                                                'exceptions',
                                                'restrictions',
                                            ])
                                            ->where('id', $leave_type_id)->first();

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
        $arr_entitlement = $arr_leave_type['entitlement']??[];
        $effective_unit = $arr_entitlement['effective_unit']??'';
        $effective_period = $arr_entitlement['effective_period']??'';
        $exp_field = $arr_entitlement['exp_field']??'';

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
        $arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_genders = json_decode($arr_applicable['genders']??'');

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
        $arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_marital_status = json_decode($arr_applicable['marital_status']??'');

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
        $arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_departments = json_decode($arr_applicable['departments']??'');
        $arr_exception = $arr_leave_type['exceptions']??[];
        $arr_excpt_departments = json_decode($arr_exception['departments']??'');

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
        $arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_departments = json_decode($arr_applicable['designations']??'');
        $arr_exception = $arr_leave_type['exceptions']??[];
        $arr_excpt_designations = json_decode($arr_exception['designations']??'');

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
        $arr_applicable = $arr_leave_type['applicable']??[];
        $arr_appl_employee_types = json_decode($arr_applicable['employee_types']??'');
        $arr_exception = $arr_leave_type['exceptions']??[];
        $arr_excpt_employee_types = json_decode($arr_exception['employee_types']??'');

        if(!empty($arr_appl_employee_types)) {
            if(in_array($user_role_id, $arr_appl_employee_types)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for role: ".($user_role['name']??'');
            }
        }elseif(!empty($arr_excpt_employee_types)) {
            if(!in_array($user_role_id, $arr_excpt_employee_types)) {
                $arr_resp['status'] = 'valid';
            }else{
                $arr_resp['status'] = 'invalid';
                $arr_resp['message'] = "Leave isn't applicable for role: ".($user_role['name']??'');
            }
        }else{
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
        $arr_restrictions = $arr_leave_type['restrictions']??[];
        $arr_restr_leaves = json_decode($arr_restrictions['blocked_clubs']??'');

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
        $arr_restrictions = $arr_leave_type['restrictions']??[];

        $from_date = Carbon::createFromFormat('d/m/Y',$from_date);
        $nowDate = Carbon::now();

        if(isset($arr_restrictions['futurebooking_notice_enable']) && $arr_restrictions['futurebooking_notice_enable']== '1') {
            $futurebooking_notice = $arr_restrictions['futurebooking_notice']??0;
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

    public function get_employees_leave_balance($arr_users) {

        $arr_ret = $arr_leave_type = $arr_applcns = [];

        $obj_leave_type = $this->LeaveTypesModel->with([
                                                    'entitlement',
                                                    'applicable',
                                                    'exceptions',
                                                    'restrictions',
                                                ])->get();
        if($obj_leave_type->count() > 0) { $arr_leave_type = $obj_leave_type->toArray(); }

        $obj_applcns = $this->LeaveApplicationModel->with(['leave_days','leave_type_details'])->get();
        if($obj_applcns->count() > 0) { $arr_applcns = $obj_applcns->toArray(); }

        if(!empty($arr_users)) {
            foreach($arr_users as $index => $user) {

                $keys = array_keys(array_column($arr_applcns, 'user_id'), $user['id']);

                $matches = array_intersect_key($arr_applcns, array_flip($keys));

                $arr_users[$index]['leave_type_bal'] = $this->caculate_user_leaves($user, $arr_leave_type, $arr_applcns);
                $arr_users[$index]['taken_leave'] = $this->caculate_user_taken_leaves($user, $arr_leave_type, $matches);
            }
        }
        return $arr_users;
    }

    public function caculate_user_leaves($user, $arr_leave_type, $arr_applcns) {

        //dump($arr_applcns);
        $arr_ret = [];

        $user_id = $user['id']??'';

        if(!empty($arr_leave_type)) {
            foreach ($arr_leave_type as $key => $leave_type) {

                $type_id = $leave_type['id']??'';
                $arr_ret[$type_id] = $leave_type['paid_days']??0;
                foreach($arr_applcns as $application) {
                    //dd($application);
                    $appld_type_id = $application['leave_type_id']??'';
                    $appld_user_id = $application['user_id']??'';
                    if( $appld_user_id == $user_id && $appld_type_id==$type_id ) {
                    
                        $taken_period = 0;

                        if($application['leave_type_details']['unit'] == 'days') {
                            $taken_period = count($application['leave_days']);
                        }elseif($application['leave_type_details']['unit'] == 'hours'){
                            $arr_time = [];
                            foreach($leave_days as $row) {
                                $datetime1 = new DateTime($row['from_time']);
                                $datetime2 = new DateTime($row['to_time']);
                                $interval = $datetime1->diff($datetime2);
                                $arr_time[] = $interval->format('%h:%i');
                            }
                            $taken_period = sum_time($arr_time);
                        }

                        if(isset($arr_ret[$type_id])) {
                            $arr_ret[$type_id] -= $taken_period;
                        }
                    }
                }

                $chk_gndr = $this->check_gender_criteria($user, $leave_type);

                if(isset($chk_gndr['status']) && $chk_gndr['status'] == 'invalid') {
                    $arr_ret[$type_id] = '-';
                }

                $chk_mrtl_status = $this->check_marital_status_criteria($user, $leave_type);
                if(isset($chk_mrtl_status['status']) && $chk_mrtl_status['status'] == 'invalid') {
                    $arr_ret[$type_id] = '-';
                }

                $chk_department = $this->check_empl_department_criteria($user, $leave_type);
                if(isset($chk_department['status']) && $chk_department['status'] == 'invalid') {
                    $arr_ret[$type_id] = '-';
                }

                $chk_desgn = $this->check_empl_designation_criteria($user, $leave_type);
                if(isset($chk_desgn['status']) && $chk_desgn['status'] == 'invalid') {
                    $arr_ret[$type_id] = '-';
                }

                $chk_role = $this->check_empl_roles_criteria($user, $leave_type);
                if(isset($chk_role['status']) && $chk_role['status'] == 'invalid') {
                    $arr_ret[$type_id] = '-';
                }

            }
        }

        return $arr_ret;
    }

    public function caculate_user_taken_leaves($user, $arr_leave_type, $arr_applcns) {

        $arr_ret = [];

        $user_id = $user['id'] ?? '';

        if(!empty($arr_leave_type)) {
            foreach ($arr_leave_type as $key => $leave_type) {

                $type_id = $leave_type['id']??'';
                //$arr_ret[$type_id] = $leave_type['paid_days']??0;
                $arr_ret[$type_id] = 0;

                if(!empty($arr_applcns)) {
                    foreach($arr_applcns as $application) {
                        $appld_type_id = $application['leave_type_id']??'';
                        $appld_user_id = $application['user_id']??'';
                        if( $appld_user_id == $user_id && $appld_type_id == $type_id ) {
                            $taken_period = 0;

                            if($application['leave_type_details']['unit'] == 'days') {
                                $taken_period = count($application['leave_days']);
                            }elseif($application['leave_type_details']['unit'] == 'hours'){
                                $arr_time = [];
                                foreach($leave_days as $row) {
                                    $datetime1 = new DateTime($row['from_time']);
                                    $datetime2 = new DateTime($row['to_time']);
                                    $interval = $datetime1->diff($datetime2);
                                    $arr_time[] = $interval->format('%h:%i');
                                }
                                $taken_period = sum_time($arr_time);
                            }
                            
                            //if(isset($arr_ret[$type_id])) {
                                $arr_ret[$type_id] = $taken_period;
                            //}
                        }
                    }
                }else{
                    $arr_ret[$type_id] = 0;
                }

            }
        }

        return $arr_ret;
    }

}

?>
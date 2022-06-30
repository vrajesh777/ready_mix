<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\WorkShiftService;
use App\Common\Services\LeavesService;
use App\Models\User;
use App\Models\BreakModel;
use App\Models\RolesModel;
use App\Models\DepartmentsModel;
use App\Models\DesignationsModel;
use App\Models\LeaveTypesModel;
use App\Models\LeaveEntitlemantModel;
use App\Models\LeaveApplicableModel;
use App\Models\LeaveExceptionsModel;
use App\Models\LeaveApplicationModel;
use App\Models\AppliedLeaveDaysModel;
use App\Models\LeaveRestrictionsModel;
use App\Models\EmpLeavePolicyModel;
use App\Models\LeaveBalanceModel;
use App\Models\HolidaysModel;

use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class LeaveApplicationController extends Controller
{
    public function __construct()
    {
        $this->WorkShiftService       = new WorkShiftService();
        $this->LeavesService          = new LeavesService();
        $this->UserModel              = new User;
        $this->BreakModel             = new BreakModel;
        $this->RolesModel             = new RolesModel;
        $this->DepartmentsModel       = new DepartmentsModel;
        $this->DesignationsModel      = new DesignationsModel;
        $this->LeaveTypesModel        = new LeaveTypesModel;
        $this->LeaveEntitlemantModel  = new LeaveEntitlemantModel;
        $this->LeaveApplicableModel   = new LeaveApplicableModel;
        $this->LeaveExceptionsModel   = new LeaveExceptionsModel;
        $this->LeaveApplicationModel  = new LeaveApplicationModel;
        $this->AppliedLeaveDaysModel  = new AppliedLeaveDaysModel;
        $this->LeaveRestrictionsModel = new LeaveRestrictionsModel;
        $this->EmpLeavePolicyModel    = new EmpLeavePolicyModel;
        $this->LeaveBalanceModel      = new LeaveBalanceModel;
        $this->HolidaysModel          = new HolidaysModel;
        $this->auth                   = auth();
        $this->arr_view_data          = [];
        $this->module_title           = "Leave Application";
        $this->module_view_folder     = "hr.leave_application";
    }

    public function index() {

        $arr_leave_apps = $arr_leave_types = $arr_departments = $arr_designations = $arr_roles = $arr_employees = [];

        $obj_leavetypes = $this->LeaveTypesModel->get();

        if($obj_leavetypes->count() > 0) { $arr_leave_types = $obj_leavetypes->toArray(); }

        $obj_depts = $this->DepartmentsModel->get();

        if($obj_depts->count() > 0) { $arr_departments = $obj_depts->toArray(); }

        $obj_desgns = $this->DesignationsModel->get();

        if($obj_desgns->count() > 0) { $arr_designations = $obj_desgns->toArray(); }

        $obj_roles = $this->RolesModel->get();

        if($obj_roles->count() > 0) { $arr_roles = $obj_roles->toArray(); }

        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];

        $obj_empls = $this->UserModel->whereNotIn('role_id',$arr_exclude)->get();

        if($obj_empls->count() > 0) { $arr_employees = $obj_empls->toArray(); }

        $obj_leave_apps = $this->LeaveApplicationModel->whereHas('employee', function(){})
                                                    ->whereHas('leave_days', function(){})
                                                    ->whereHas('leave_type_details', function(){})
                                                    ->with([
                                                        'employee',
                                                        'leave_days',
                                                        'leave_type_details',
                                                    ])
                                                    ->get();

        if($obj_leave_apps->count() > 0) {
            $arr_leave_apps = $obj_leave_apps->toArray();
        }

        $this->store_emp_leaves_policy();

        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['arr_leave_types']     = $arr_leave_types;
        $this->arr_view_data['arr_departments']     = $arr_departments;
        $this->arr_view_data['arr_designations']    = $arr_designations;
        $this->arr_view_data['arr_roles']           = $arr_roles;
        $this->arr_view_data['arr_employees']       = $arr_employees;
        $this->arr_view_data['arr_leave_apps']      = $arr_leave_apps;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function get_leave_schedule_form(Request $request) {

        $leave_type = $request->input('leave_type');
        $user_id = $request->input('employee');
        $applied_with = $request->input('applied_with');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $applied_with = $request->input('applied_with');

        $obj_leave_type = $this->LeaveTypesModel
                                            ->with(['restrictions'])
                                            ->where('id', $leave_type)->first();

        if($obj_leave_type) {

            $arr_leave_type = $obj_leave_type->toArray();

            $unit = $arr_leave_type['unit'];

            /*$start = Carbon::createFromFormat('d/m/Y', $from_date);
            $end = Carbon::createFromFormat('d/m/Y', $to_date);

            $period = \Carbon\CarbonPeriod::create($start->format('Y-m-d'), $end->format('Y-m-d'));
            foreach ($period as $date) {
                // dump($date->format('Y-m-d'));
            }*/
            $arr_holidays = [];
            $obj_holidays = $this->HolidaysModel->get();
            if($obj_holidays){
                $arr_holidays = $obj_holidays->toArray();
            }

            $this->arr_view_data['from_date']       = $from_date;
            $this->arr_view_data['to_date']         = $to_date;
            $this->arr_view_data['arr_leave_type']  = $arr_leave_type;
            $this->arr_view_data['arr_holidays']    = $arr_holidays;

            if($unit=='days') {

                $html=view($this->module_view_folder.'.leave_schedule_days',$this->arr_view_data)->render();

                $arr_resp['html'] = $html;

            }elseif($unit=='hours') {

                $arr_shifts = $this->WorkShiftService->get_user_shift_data($from_date, $to_date, $user_id);

                $this->arr_view_data['applied_with']  = $applied_with;
                $this->arr_view_data['arr_shifts']  = $arr_shifts;

                if($applied_with == 'startend') {
                    $html=view($this->module_view_folder.'.leave_schedule_startend',$this->arr_view_data)->render();
                }elseif($applied_with == 'hours') {
                    $html=view($this->module_view_folder.'.leave_schedule_hours',$this->arr_view_data)->render();
                }
                $arr_resp['html'] = $html;
            }

            $arr_resp['status']         = 'success';
            $arr_resp['message']        = "";

        }else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');;
        }
        return response()->json($arr_resp, 200);
    }

    public function store(Request $request) {
        $arr_rules                  = $arr_resp = array();
        $arr_rules['employee']      = "required";
        $arr_rules['leave_type']    = "required";
        $arr_rules['from_date']     = "required";
        $arr_rules['to_date']       = "required";

        $validator = validator::make($request->all(),$arr_rules);

        $valid_start_year = date('Y');
        $valid_end_year = date('Y',strtotime('+1 year',strtotime($valid_start_year)));

        if($validator->fails()) 
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
        }else{
            $leave_type_id = $request->input('leave_type');
            $user_id = $request->input('employee');
            //$obj_leave_type = $this->LeaveTypesModel->where('id', $leave_type_id)->first();
            $obj_leave_type = $this->EmpLeavePolicyModel->where('leave_types_id',$leave_type_id)->whereYear('start',$valid_start_year)
                ->whereYear('end',$valid_end_year)
                ->where('user_id',$user_id)
                ->first();

            if($obj_leave_type) {
                $arr_leave_type = $obj_leave_type->toArray();
                $unit = $arr_leave_type['unit']??'';

                $from_date = $request->input('from_date');
                $to_date = $request->input('to_date');

                $start = Carbon::createFromFormat('d/m/Y', $from_date);
                $end = Carbon::createFromFormat('d/m/Y', $to_date);

                $period = \Carbon\CarbonPeriod::create($start->format('Y-m-d'),$end->format('Y-m-d'));

                
                $leave_schd_dates = $request->input('leave_schd_dates');
                $leave_count = count($leave_schd_dates) ?? 0;

                $validate_leave = $this->LeavesService->validate_leave_criteria($user_id, $leave_type_id, $from_date, $to_date,$leave_count);

                if($validate_leave['status'] == 'invalid') {
                    $arr_resp['status']     = 'error';
                    $arr_resp['message']    = $validate_leave['message'];
                }else{

                    $pre_leaves = $this->LeavesService->get_user_leaves_between_dates($user_id, $from_date, $to_date);

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

                        $arr_resp['status']         = 'error';
                        $arr_resp['message']        = $msg;
                    }else{
                        $arr_ins['user_id'] = $request->input('employee');
                        $arr_ins['leave_type_id'] = $request->input('leave_type');
                        $arr_ins['type'] = $unit == 'days'?'date':'hours';
                        $arr_ins['reason'] = $request->input('reason');

                        if($obj_leave_appl = $this->LeaveApplicationModel->create($arr_ins)) {

                            $arr_leave_schd_dates = $arr_appld_days = [];
                            $week_off_count = $holiday_count = 0;

                            if($unit == 'days') {
                                $leave_schd_dates = $request->input('leave_schd_dates');
                                foreach ($period as $index => $date) {
                                    $date = $date->format('Y-m-d');
                                    $arr_leave_schd_dates[$date] = $leave_schd_dates[$index]??'';
                                }
                                $index = $week_off_count = $holiday_count = 0;
                                foreach($arr_leave_schd_dates as $date => $row) {
                                    $arr_appld_days[$index]['application_id'] = $obj_leave_appl->id??'';
                                    $arr_appld_days[$index]['date'] = $date;
                                    $arr_appld_days[$index]['period'] = $row;
                                    if($row == 'week_off'){
                                        $week_off_count = $week_off_count + 1;
                                    }

                                    if($row == 'holiday'){
                                        $holiday_count = $holiday_count + 1;
                                    }

                                    $index++;
                                }
                            }elseif($unit == 'hours'){
                                $leave_schd_time = $request->input('leave_schd_time');
                                $arr_start = $leave_schd_time['start']??[];
                                $arr_end = $leave_schd_time['end']??[];
                                foreach ($period as $index => $date) {
                                    $date = $date->format('Y-m-d');
                                    $arr_appld_days[$index]['application_id'] = $obj_leave_appl->id??'';
                                    $arr_appld_days[$index]['date'] = $date;
                                    $arr_appld_days[$index]['from_time'] = $arr_start[$index]??'';
                                    $arr_appld_days[$index]['to_time'] = $arr_end[$index]??'';
                                    if(($arr_start[$index]??'')=='' && ($arr_end[$index]??'')=='') {
                                        $arr_appld_days[$index]['period'] = 'week_off';
                                    }else{
                                        $arr_appld_days[$index]['period'] = 'hourly';
                                    }
                                }
                            }

                            /*--------------Update in leave balance table---------*/
                            $include_weekends = $obj_leave_type->include_weekends ?? '';
                            $inc_holidays = $obj_leave_type->inc_holidays ?? '';
                            $inc_weekends_after = $obj_leave_type->inc_weekends_after ?? '';
                            $incholidays_after = $obj_leave_type->incholidays_after ?? '';
                            $exceed_maxcount = $obj_leave_type->exceed_maxcount ?? '';
                            $exceed_allow_opt = $obj_leave_type->exceed_allow_opt ?? '';

                            $take_leave  = count($arr_appld_days) ?? 0;

                            if(isset($include_weekends) && $include_weekends!='' && $include_weekends == 0){
                                $take_leave = $take_leave - $week_off_count;
                            }
                            else{
                                if(isset($inc_weekends_after) && $inc_weekends_after!='' && ($inc_weekends_after > $take_leave)){
                                    $take_leave = $take_leave - $week_off_count;
                                }
                            }

                            if(isset($inc_holidays) && $inc_holidays!='' && $inc_holidays == 0){
                                $take_leave = $take_leave - $holiday_count;
                            }
                            else{
                                if(isset($incholidays_after) && $incholidays_after!='' && ($incholidays_after > $take_leave)){
                                    $take_leave = $take_leave - $holiday_count;
                                }
                            }

                            $lop = 0;
                            $obj_leave_bal = $this->LeaveBalanceModel->where('user_id',$request->input('employee'))
                                                    ->where('leave_type_id',$request->input('leave_type'))
                                                    //->whereYear('valid_till', '=', date('Y'))
                                                    ->orderBy('id','DESC')
                                                    ->first();

                            if(isset($exceed_maxcount) && $exceed_maxcount!='' && $exceed_maxcount == 1){
                               
                                $prev_balance = $obj_leave_bal->balance ?? 0;
                                if(isset($exceed_allow_opt) && $exceed_allow_opt!='' && $exceed_allow_opt == 3){
                                    if($leave_count > $prev_balance){
                                        $lop = $prev_balance - $take_leave;
                                        $take_leave = $leave_count - $lop;
                                        $update_leave_bal['lop'] = $lop;
                                    }
                                }
                            }

                            if($obj_leave_bal)
                            {   
                                $taken_leave = $obj_leave_bal->taken_leave ?? 0;
                                $take_leave  = $taken_leave + $take_leave;
                                $update_leave_bal['taken_leave'] = $take_leave;
                                $obj_leave_bal->update($update_leave_bal);   
                            }
                            /*--------------Update in leave balance table---------*/

                            $this->AppliedLeaveDaysModel->insert($arr_appld_days);

                            $arr_resp['status']         = 'success';
                            $arr_resp['message']        = trans('admin.leave_application')." ".trans('stored_successfully');
                        }else{
                            $arr_resp['status']         = 'error';
                            $arr_resp['message']        = trans('admin.error_msg');
                        }
                    }
                }

            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = "Leave isn't applicable for selected employee!";
            }

        }

        return response()->json($arr_resp, 200);
    }

    public function edit_leave_type($enc_id) {

        $id = base64_decode($enc_id);

        $arr_lead = $arr_resp = [];

        $obj_leave_type = $this->LeaveTypesModel
                                            ->with(['applicable','entitlement','restrictions','exceptions'])
                                            ->where('id', $id)
                                            ->first();

        if($obj_leave_type) {

            $arr_leave_type = $obj_leave_type->toArray();

            $arr_leave_type['start'] = Carbon::createFromFormat('Y-m-d',$arr_leave_type['start'])->format('d/m/Y');
            $arr_leave_type['end'] = Carbon::createFromFormat('Y-m-d',$arr_leave_type['end'])->format('d/m/Y');

            foreach($arr_leave_type['entitlement'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            foreach($arr_leave_type['applicable'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            foreach($arr_leave_type['restrictions'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            foreach($arr_leave_type['exceptions'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            unset($arr_leave_type['entitlement']);
            unset($arr_leave_type['applicable']);
            unset($arr_leave_type['restrictions']);
            unset($arr_leave_type['exceptions']);

            // $arr_leave_type['applicable_shifts'] = json_decode($arr_leave_type['applicable_shifts']);

            $arr_resp['status'] = 'success';
            $arr_resp['data'] = $arr_leave_type;
            $arr_resp['message'] = trans('admin.data_found');

        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.data_not_found');
        }

        return response()->json($arr_resp, 200);
    }

    public function update_leave_type($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_leave_type = $this->LeaveTypesModel
                                        ->with(['applicable','entitlement','restrictions','exceptions'])
                                        ->where('id', $id)
                                        ->first();
        if($obj_leave_type) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['title']         = "required";
            $arr_rules['type']          = "required";
            $arr_rules['leaveunit']     = "required";

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) 
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                $arr_ins['title']           = $request->input('title');
                $arr_ins['code']            = $request->input('code');
                $arr_ins['type']            = $request->input('type');
                $arr_ins['unit']            = $request->input('leaveunit');
                $arr_ins['description']     = $request->input('description');

                if($request->has('start') && $request->input('start') != '') {
                    $arr_ins['start']           = Carbon::createFromFormat('d/m/Y',$request->input('start'))->format('Y-m-d');
                }
                if($request->has('end') && $request->input('end') != '') {
                    $arr_ins['end']             = Carbon::createFromFormat('d/m/Y',$request->input('end'))->format('Y-m-d');
                }

                if($this->LeaveTypesModel->where('id', $id)->update($arr_ins)) {

                    $arr_ins_ent['leave_type_id']       = $obj_leave_type->id??'';
                    $arr_ins_ent['effective_period']    = $request->input('effective_period');
                    $arr_ins_ent['effective_unit']      = $request->input('effective_unit');
                    $arr_ins_ent['exp_field']           = $request->input('exp_field');

                    if($request->has('accrual') && $request->input('accrual') == '1') {
                        $arr_ins_ent['accrual']             = $request->input('accrual');
                        $arr_ins_ent['accrual_period']      = $request->input('accrual_period');
                        $arr_ins_ent['accrual_time']        = $request->input('accrual_time');
                        $arr_ins_ent['accrual_month']       = $request->input('accrual_month');
                        $arr_ins_ent['accrual_no_days']     = $request->input('accrual_no_days');
                        $arr_ins_ent['accrual_mode']        = $request->input('accrual_mode');
                    }

                    if($request->has('reset') && $request->input('reset') == '1') {
                        $arr_ins_ent['reset']               = $request->input('reset');
                        $arr_ins_ent['reset_period']        = $request->input('reset_period');
                        $arr_ins_ent['reset_time']          = $request->input('reset_time');
                        $arr_ins_ent['reset_month']         = $request->input('reset_month');
                        $arr_ins_ent['cf_mode']             = $request->input('cf_mode');
                        $arr_ins_ent['reset_carry']         = $request->input('reset_carry');
                        $arr_ins_ent['reset_carry_type']    = $request->input('reset_carry_type');
                        $arr_ins_ent['reset_carry_limit']   = $request->input('reset_carry_limit');
                        $arr_ins_ent['reset_encash_num']    = $request->input('reset_encash_num');
                        $arr_ins_ent['encash_type']         = $request->input('encash_type');
                        $arr_ins_ent['reset_encash_limit']  = $request->input('reset_encash_limit');
                    }

                    $this->LeaveEntitlemantModel->where('id', $obj_leave_type->entitlement->id)->update($arr_ins_ent);

                    $arr_applcbl = $arr_excpt = [];

                    /* Applicable / Exception Data */

                    if($request->has('genders') && !empty($request->input('genders'))) {
                        $arr_applcbl['genders'] = json_encode($request->input('genders'));
                    }
                    if($request->has('marital_status') && !empty($request->input('marital_status'))) {
                        $arr_applcbl['marital_status'] = json_encode($request->input('marital_status'));
                    }
                    if($request->has('applc_depts') && !empty($request->input('applc_depts'))) {
                        $arr_applcbl['departments'] = json_encode($request->input('applc_depts'));
                    }else{
                        if($request->has('except_depts') && !empty($request->input('except_depts'))) {
                            $arr_excpt['departments'] = json_encode($request->input('except_depts'));
                        }
                    }
                    if($request->has('applc_designations') && !empty($request->input('applc_designations'))) {
                        $arr_applcbl['designations'] = json_encode($request->input('applc_designations'));
                    }else{
                        if($request->has('except_designations')&&!empty($request->input('except_designations'))) {
                            $arr_excpt['designations'] = json_encode($request->input('except_designations'));
                        }
                    }
                    if($request->has('applc_roles') && !empty($request->input('applc_roles'))) {
                        $arr_applcbl['employee_types'] = json_encode($request->input('applc_roles'));
                    }else{
                        if($request->has('except_roles') && !empty($request->input('except_roles'))) {
                            $arr_excpt['employee_types'] = json_encode($request->input('except_roles'));
                        }
                    }

                    if(empty(array_filter($arr_applcbl))) {
                        if($request->has('applc_users') && !empty($request->input('applc_users'))) {
                            $arr_applcbl['users'] = json_encode($request->input('users'));
                        }else{
                            $arr_applcbl['users'] = json_encode(['all']);
                        }
                    }
                    $arr_applcbl['leave_type_id'] = $obj_leave_type->id??'';

                    if(!empty($arr_applcbl)) {
                        $this->LeaveApplicableModel->where('id',$obj_leave_type->applicable->id)->update($arr_applcbl);
                    }

                    if(!empty($arr_excpt)) {
                        $arr_excpt['leave_type_id'] = $obj_leave_type->id??'';
                        $this->LeaveExceptionsModel->where('id',$obj_leave_type->exceptions->id)->update($arr_excpt);
                    }

                    /* Applicable / Exception Data */

                    /* Restriction Data */

                    $arr_restr['leave_type_id'] = $obj_leave_type->id??'';
                    $arr_restr['include_weekends'] = $request->input('include_weekends');
                    if($request->has('leave_type_id') && $request->input('leave_type_id')==1) {
                        $arr_restr['inc_weekends_after'] = $request->input('inc_weekends_after');
                    }
                    $arr_restr['inc_holidays'] = $request->input('inc_holidays');
                    if($request->has('inc_holidays') && $request->input('inc_holidays')==1) {
                        $arr_restr['incholidays_after'] = $request->input('incholidays_after');
                    }
                    $arr_restr['exceed_maxcount'] = $request->input('exceed_maxcount');
                    if($request->has('exceed_maxcount') && $request->input('exceed_maxcount')==1) {
                        $arr_restr['exceed_allow_opt'] = $request->input('exceed_allow_opt');
                    }
                    if( $request->has('duration_allowed') && !empty($request->input('duration_allowed')) ) {
                        $arr_restr['duration_allowed'] = json_encode($request->input('duration_allowed'));
                    }
                    $arr_restr['report_display'] = $request->input('report_display');
                    $arr_restr['balance_display'] = $request->input('balance_display');
                    $arr_restr['pastbooking_enable'] = $request->input('pastbooking_enable');
                    if($request->has('pastbooking_enable') && $request->input('pastbooking_enable')==1) {
                        if($request->has('pastbooking_limit_enable') && $request->input('pastbooking_limit_enable')==1) {
                            $arr_restr['pastbooking_limit_enable'] = $request->input('pastbooking_limit_enable');
                            $arr_restr['pastbooking_limit'] = $request->input('pastbooking_limit');
                        }
                    }
                    if($request->has('futurebooking_enable') && $request->input('futurebooking_enable')==1) {
                        $arr_restr['futurebooking_enable'] = $request->input('futurebooking_enable');
                        if($request->has('futurebooking_limit_enable') && $request->input('futurebooking_limit_enable')==1) {
                            $arr_restr['futurebooking_limit_enable'] = $request->input('futurebooking_limit_enable');
                            $arr_restr['futurebooking_limit'] = $request->input('futurebooking_limit');
                        }
                        if($request->has('futurebooking_notice_enable') && $request->input('futurebooking_notice_enable')==1) {
                            $arr_restr['futurebooking_notice_enable'] = $request->input('futurebooking_notice_enable');
                            $arr_restr['futurebooking_notice'] = $request->input('futurebooking_notice');
                        }
                    }
                    if($request->has('min_leave_enable') && $request->input('min_leave_enable')==1) {
                        $arr_restr['min_leave_enable'] = $request->input('min_leave_enable');
                        $arr_restr['min_leave'] = $request->input('min_leave');
                    }
                    if($request->has('max_leave_enable') && $request->input('max_leave_enable')==1) {
                        $arr_restr['max_leave_enable'] = $request->input('max_leave_enable');
                        $arr_restr['max_leave'] = $request->input('max_leave');
                    }
                    if($request->has('max_consecutive_enable') && $request->input('max_consecutive_enable')==1) {
                        $arr_restr['max_consecutive_enable'] = $request->input('max_consecutive_enable');
                        $arr_restr['max_consecutive'] = $request->input('max_consecutive');
                    }
                    if($request->has('min_gap_enable') && $request->input('min_gap_enable')==1) {
                        $arr_restr['min_gap_enable'] = $request->input('min_gap_enable');
                        $arr_restr['min_gap'] = $request->input('min_gap');
                    }
                    if($request->has('show_fileupload_after_enable') && $request->input('show_fileupload_after_enable')==1) {
                        $arr_restr['show_fileupload_after_enable'] = $request->input('show_fileupload_after_enable');
                        $arr_restr['show_fileupload_after'] = $request->input('show_fileupload_after');
                    }
                    $arr_restr['frequency_count'] = $request->input('frequency_count');
                    $arr_restr['frequency_period'] = $request->input('frequency_period');
                    if($request->has('applydates') && count($request->input('applydates')) > 0 ) {
                        $arr_restr['applydates'] = json_encode($request->input('applydates'));
                    }
                    if($request->has('blocked_clubs') && count($request->input('blocked_clubs')) > 0 ) {
                        $arr_restr['blocked_clubs'] = json_encode($request->input('blocked_clubs'));
                    }

                    $this->LeaveRestrictionsModel->where('id', $obj_leave_type->restrictions->id)->update($arr_restr);

                    /* Restriction Data */

                    $arr_resp['status']         = 'success';
                    $arr_resp['message']        = trans('admin.leave_application')." ".trans('admin.updated_successfully');
                }else{
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.error_msg');
                }
            }
        }else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

    public function leave_balance(Request $request) {
        
        $arr_leave_type = $arr_users = $dept_ids = $emp_ids = $leave_type_ids = [];
        $type = $start_date = $end_date = '';

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }
        /*else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }*/

        $obj_leave_type = $this->LeaveTypesModel->orderby('type');

        if($request->has('leave_type') && $request->input('leave_type')!=''){
            $leave_type_ids = $request->input('leave_type');
            $obj_leave_type = $obj_leave_type->whereIn('id',$leave_type_ids);
        }

        $obj_leave_type = $obj_leave_type->get();

        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];

        if($obj_leave_type->count() > 0) {
            $arr_leave_type = $obj_leave_type->toArray();

            $obj_empls = $this->UserModel->with(['leaves',
                                                 'department',
                                                 'designation',
                                                 'role'])
                                         ->whereNotIn('role_id',$arr_exclude)
                                         ->orderBy('id','DESC');

            if($request->has('department') && $request->input('department')!=''){
                $dept_ids = $request->input('department');
                $obj_empls = $obj_empls->whereIn('department_id',$dept_ids);
            }

            if($request->has('employee') && $request->input('employee')!=''){
                $emp_ids = $request->input('employee');
                $obj_empls = $obj_empls->whereIn('id',$emp_ids);
            }

            if($request->has('type') && $request->input('type')!=''){
                $type = $request->input('type');
                /*$obj_empls = $obj_empls->whereHas('leaves',function($qry)use($type){
                                            $qry->where('type',$type);
                                        });*/
            }

            if($start_date!='' && $end_date!=''){
                //$leave_type_ids = $request->input('leave_type');
                /*$obj_empls = $obj_empls->whereHas('leaves.leave_days',function($qry)use($start_date,$end_date){
                                        $qry->whereDate('date','>=', $start_date);
                                        $qry->whereDate('date','<=', $end_date);
                                    });*/
            }
                                         
            $obj_empls = $obj_empls->get();
            if($obj_empls->count() > 0) {
                $arr_users = $obj_empls->toArray();
            }
        }

        $this->store_emp_leaves_policy();
        $obj_depts = $this->DepartmentsModel->get();
        if($obj_depts->count() > 0) { $arr_departments = $obj_depts->toArray(); }

        $obj_empls = $this->UserModel->get();
        if($obj_empls->count() > 0) { $arr_employees = $obj_empls->toArray(); }

        $arr_request               = $request->all();
        $arr_request['start_date'] = $start_date;
        $arr_request['end_date']   = $end_date;

        $arr_users = $this->LeavesService->get_employees_leave_balance($arr_users,$arr_request);
        //dd($arr_users);
        $this->arr_view_data['arr_leave_type']  = $arr_leave_type;
        $this->arr_view_data['arr_users']       = $arr_users;
        $this->arr_view_data['arr_departments'] = $arr_departments;
        $this->arr_view_data['arr_employees']   = $arr_employees;
        $this->arr_view_data['start_date']      = $start_date;
        $this->arr_view_data['end_date']        = $end_date;
        $this->arr_view_data['dept_ids']        = $dept_ids;
        $this->arr_view_data['emp_ids']         = $emp_ids;
        $this->arr_view_data['leave_type_ids']  = $leave_type_ids;
        $this->arr_view_data['type']            = $type;

        return view($this->module_view_folder.'.leave_balance_calender',$this->arr_view_data);
    }

    public function store_emp_leaves_policy()
    {
        $obj_leave_type = $this->LeaveTypesModel->with(['applicable',
                                                        'exceptions',
                                                        'entitlement',
                                                        'restrictions'])->get();
        if($obj_leave_type->count() > 0) {
            $arr_leave_type = $obj_leave_type->toArray();

            $obj_empls = $this->UserModel
                                        ->with(['leaves','department','designation','role'])
                                        ->whereNotNull('join_date')
                                        ->whereNotNull('confirm_date')
                                        ->orderBy('id','DESC')
                                        ->get();

            if($obj_empls->count() > 0) {
                $arr_users = $obj_empls->toArray();
            }

            foreach ($arr_leave_type as $l_key => $l_val) {
               foreach ($arr_users as $key => $val) {
                    $is_exist = 0;

                    $user_id = $val['id'] ?? 0;

                    $check_effective_from_criteria = $this->check_effective_from_criteria($val, $l_val);
                    $chk_gndr                      = $this->check_gender_criteria($val, $l_val);
                    $chk_mrtl_status               = $this->check_marital_status_criteria($val, $l_val);
                    $chk_department                = $this->check_empl_department_criteria($val, $l_val);
                    $chk_desgn                     = $this->check_empl_designation_criteria($val, $l_val);
                    $chk_role                      = $this->check_empl_roles_criteria($val, $l_val);

                    if($check_effective_from_criteria ['status'] == 'valid' &&
                        $chk_gndr['status'] == 'valid' && 
                        $chk_mrtl_status['status'] == 'valid' && 
                        $chk_department['status'] == 'valid' && 
                        $chk_desgn['status'] == 'valid' && 
                        $chk_role['status'] == 'valid')
                    {
                        $emp_join_date = $val['join_date'] ?? '';
                        $emp_confirm_date = $val['confirm_date'] ?? '';
                        if(isset($l_val['entitlement']['exp_field']) && $l_val['entitlement']['exp_field']!='' && $l_val['entitlement']['exp_field'] == 'date_of_join')
                        {
                            $year       = date('Y');
                            $temp_date  = date('m-d', strtotime($emp_join_date));
                            $new_start  = $year . '-' . $temp_date;
                            $new_end    = date('Y-m-d', strtotime('+1 year', strtotime($new_start)) );
                        }

                        if(isset($l_val['entitlement']['exp_field']) && $l_val['entitlement']['exp_field']!='' && $l_val['entitlement']['exp_field'] == 'date_of_conf')
                        {
                            $year       = date('Y');
                            $temp_date  = date('m-d', strtotime($emp_confirm_date));
                            $new_start  = $year . '-' . $temp_date;
                            $new_end    = date('Y-m-d', strtotime('+1 year', strtotime($new_start)) );
                        }

                        /*$is_exist = $this->EmpLeavePolicyModel->where('user_id',$val['id'])
                                              ->whereDate('start',$new_start)
                                              ->whereDate('end',$new_end)
                                              ->where('leave_types_id',$l_val['id'])
                                              ->get();*/
                        $is_exist = true;
                        $obj_policy = $this->EmpLeavePolicyModel->where('user_id',$user_id)
                                              ->where('leave_types_id',$l_val['id'])
                                              ->orderBy('id','DESC')
                                              ->first();
                        if($obj_policy == false){
                            $is_exist = false;
                        }

                        if($obj_policy){
                            if(isset($new_end) && (strtotime($new_end) != strtotime($obj_policy->end)))
                            {
                                $is_exist = false;
                            }
                            /*$current_date  = date('Y-m-d');
                            $new_end_date  = date('m-d', strtotime($obj_policy->end));
                            $new_end_date  = date('Y') . '-' . $new_end_date;
                            if( strtotime($current_date) < strtotime($new_end_date)){
                                $is_exist = false;
                            }*/
                        }

                        if($is_exist == false ){

                            $accrual_no_days = $forword_leave = $leave_days = 0;
                            if(isset($l_val['entitlement']['accrual_mode']) && $l_val['entitlement']['accrual_mode']!='' && $l_val['entitlement']['accrual_mode'] == 'accrual_mode')
                            {
                                $accrual_no_days = $l_val['entitlement']['accrual_no_days'] ?? 0;
                            }

                            if(isset($obj_policy->accrual_mode) && $obj_policy->accrual_mode!='' && $obj_policy->accrual_mode == 'next_accrual'){
                                $accrual_no_days = $obj_policy->accrual_no_days ?? 0;
                            }

                            if(isset($obj_policy->reset) && $obj_policy->reset!='' && $obj_policy->reset == '1')
                            {
                                $arr_reset_data = $this->calculate_reset_functionality($obj_policy,$user_id);

                                $forword_leave = $arr_reset_data['forword_leave'] ?? 0;
                            }
                            
                            $leave_days = $l_val['paid_days'] + $accrual_no_days + $forword_leave;
                                
                            $arr_insert['user_id']        = $val['id'] ?? 0;
                            $arr_insert['leave_types_id'] = $l_val['id'] ?? 0;
                            $arr_insert['type']           = $l_val['type'] ?? 0;
                            $arr_insert['unit']           = $l_val['unit'] ?? 0;
                            $arr_insert['description']    = $l_val['description'] ?? 0;
                            $arr_insert['start']          = $new_start;
                            $arr_insert['end']            = $new_end;
                            $arr_insert['paid_days']      = $leave_days;
                            $arr_insert['unpaid_days']    = $l_val['unpaid_days'] ?? 0;
                            
                            $obj_store = $this->EmpLeavePolicyModel->create($arr_insert);

                            unset($l_val['applicable']['id']);
                            unset($l_val['applicable']['leave_type_id']);
                            unset($l_val['applicable']['created_at']);
                            unset($l_val['applicable']['updated_at']);
                            $arr_applicable = $l_val['applicable'] ?? [];
                            $obj_store->update($arr_applicable);
                            $obj_store->save();

                            unset($l_val['entitlement']['id']);
                            unset($l_val['entitlement']['leave_type_id']);
                            unset($l_val['entitlement']['created_at']);
                            unset($l_val['entitlement']['updated_at']);
                            $arr_entitlement = $l_val['entitlement'] ?? [];
                            $obj_store->update($arr_entitlement);
                            $obj_store->save();

                            unset($l_val['restrictions']['id']);
                            unset($l_val['restrictions']['leave_type_id']);
                            unset($l_val['restrictions']['created_at']);
                            unset($l_val['restrictions']['updated_at']);
                            $arr_restrictions = $l_val['restrictions'] ?? [];
                            $obj_store->update($arr_restrictions);
                            $obj_store->save();

                            if(isset($obj_policy->cf_mode) && $obj_policy->cf_mode!='' && $obj_policy->cf_mode == 'carry_forward_with_expiry'){
                                $arr_leave_bal['expire_count'] = $forword_leave ?? 0;
                            }

                            $arr_leave_bal['user_id'] = $val['id'] ?? 0;
                            $arr_leave_bal['leave_type_id'] = $l_val['id'] ?? 0;
                            $arr_leave_bal['valid_from'] = $new_start ?? 0;
                            $arr_leave_bal['valid_till'] = $new_end ?? 0;
                            $arr_leave_bal['balance'] = $leave_days ?? 0;
                            $is_leave_bal_exist = $this->LeaveBalanceModel->where('user_id',$val['id'])
                                              ->whereDate('valid_from',$new_start)
                                              ->whereDate('valid_till',$new_end)
                                              ->where('leave_type_id',$l_val['id'])
                                              ->get();
                            if(count($is_leave_bal_exist) == 0)
                            {
                                $this->LeaveBalanceModel->create($arr_leave_bal);
                            }
                        }
                    }
                    
                }
            }
        }
    }

    public function calculate_reset_functionality($obj_policy,$user_id)
    {
        $forword_leav = $balance = $taken_leave = $total_leaves = $forword_leave = $carry_forword_leave = 0;

        $leave_type_id = $obj_policy->id ?? 0;
        
        $obj_leave_bal = $this->LeaveBalanceModel->where('leave_type_id',$leave_type_id)
                                                 ->where('user_id',$user_id)
                                                 ->orderBy('id','DESC')
                                                 ->first();
        $balance = $obj_leave_bal->balance ?? 0;
        $taken_leave = $obj_leave_bal->taken_leave ?? 0;
        $total_leaves = $balance + $taken_leave ?? 0;

        $forword_type = $obj_policy->cf_mode ?? '';
        $reset_carry = $obj_policy->reset_carry ?? '';
        $reset_carry_type = $obj_policy->reset_carry_type ?? '';
        $reset_carry_limit = $obj_policy->reset_carry_limit ?? '';
        if($reset_carry_type == 'unit'){
            $forword_leave = $reset_carry;
        }elseif($reset_carry_type == 'percentage'){
            $forword_leave = $total_leaves * ($reset_carry / 100);
            if($reset_carry_limit < $forword_leave){
                $forword_leave = $reset_carry_limit ?? 0;
            }
        }

        if(isset($forword_type) && $forword_type!='' && $forword_type == 'carry_forward'){
            $arr_data['forword_leave'] = $forword_leave ?? 0;
        }elseif(isset($forword_type) && $forword_type!='' && $forword_type == 'carry_forward_with_expiry'){
            $arr_data['forword_leave'] = $forword_leave ?? 0;
        }elseif(isset($forword_type) && $forword_type!='' && $forword_type == 'Carry_forward_with_overall_limit'){
            $take_overall_limit = $obj_policy->take_overall_limit ?? 0;
            $carry_forword_overall_limit = $obj_policy->carry_forword_overall_limit ?? 0;
            if($take_overall_limit <= $carry_forword_overall_limit){
                $carry_forword_leave = $forword_leave ?? 0;
                $arr_data['take_overall_limit'] = $take_overall_limit + $forword_leave ?? 0;
            }
            $arr_data['forword_leave'] = $forword_leave ?? 0;
        }
        return $arr_data;
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

}
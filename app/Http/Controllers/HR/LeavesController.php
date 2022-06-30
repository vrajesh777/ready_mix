<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BreakModel;
use App\Models\RolesModel;
use App\Models\DepartmentsModel;
use App\Models\DesignationsModel;
use App\Models\LeaveTypesModel;
use App\Models\LeaveEntitlemantModel;
use App\Models\LeaveApplicableModel;
use App\Models\LeaveExceptionsModel;
use App\Models\LeaveRestrictionsModel;
use App\Models\EmpLeavePolicyModel;

use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use Carbon\Carbon;

class LeavesController extends Controller
{
    public function __construct()
    {
        $this->UserModel                = new User;
        $this->BreakModel               = new BreakModel;
        $this->RolesModel               = new RolesModel;
        $this->DepartmentsModel         = new DepartmentsModel;
        $this->DesignationsModel        = new DesignationsModel;
        $this->LeaveTypesModel          = new LeaveTypesModel;
        $this->LeaveEntitlemantModel    = new LeaveEntitlemantModel;
        $this->LeaveApplicableModel     = new LeaveApplicableModel;
        $this->LeaveExceptionsModel     = new LeaveExceptionsModel;
        $this->LeaveRestrictionsModel   = new LeaveRestrictionsModel;
        $this->EmpLeavePolicyModel      = new EmpLeavePolicyModel;
        $this->auth                     = auth();
        $this->arr_view_data            = [];
        $this->module_title             = "Leaves";
        $this->module_view_folder       = "hr.leaves";
    }

    public function index() {

        $arr_leave_types = $arr_departments = $arr_designations = $arr_roles = [];

        $obj_leavetypes = $this->LeaveTypesModel->get();

        if($obj_leavetypes->count() > 0) { $arr_leave_types = $obj_leavetypes->toArray(); }

        $obj_depts = $this->DepartmentsModel->get();

        if($obj_depts->count() > 0) { $arr_departments = $obj_depts->toArray(); }

        $obj_desgns = $this->DesignationsModel->get();

        if($obj_desgns->count() > 0) { $arr_designations = $obj_desgns->toArray(); }

        $obj_roles = $this->RolesModel->get();

        if($obj_roles->count() > 0) { $arr_roles = $obj_roles->toArray(); }

        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['arr_leave_types']     = $arr_leave_types;
        $this->arr_view_data['arr_departments']     = $arr_departments;
        $this->arr_view_data['arr_designations']    = $arr_designations;
        $this->arr_view_data['arr_roles']           = $arr_roles;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store_leave_type(Request $request) {
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
            $arr_ins['paid_days']       = $request->input('paid_days');
            //$arr_ins['unpaid_days']     = 0;
            /*if($request->input('type') == 'unpaid'){
                $arr_ins['unpaid_days']     = $request->input('paid_days');
                $arr_ins['paid_days']       = 0;
            }*/

            /*if($request->has('start') && $request->input('start') != '') {
                $arr_ins['start']           = Carbon::createFromFormat('d/m/Y',$request->input('start'))->format('Y-m-d');
            }
            if($request->has('end') && $request->input('end') != '') {
                $arr_ins['end']             = Carbon::createFromFormat('d/m/Y',$request->input('end'))->format('Y-m-d');
            }*/

            if($obj_leave_type = $this->LeaveTypesModel->create($arr_ins)) {

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
                    $arr_ins_ent['reset_carry_expire_in']  = $request->input('reset_carry_expire_in');
                    $arr_ins_ent['reset_carry_expire_unit']  = $request->input('reset_carry_expire_unit');
                }
                
                $this->LeaveEntitlemantModel->insert($arr_ins_ent);

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
                    $this->LeaveApplicableModel->create($arr_applcbl);
                }

                if(!empty($arr_excpt)) {
                    $arr_excpt['leave_type_id'] = $obj_leave_type->id??'';
                    $this->LeaveExceptionsModel->create($arr_excpt);
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

                $this->LeaveRestrictionsModel->insert($arr_restr);

                /* Restriction Data */

                $arr_resp['status']    = 'success';
                $arr_resp['message']   = trans('admin.leave_type')." ".trans('admin.added_successfully');
            }else{
                $arr_resp['status']    = 'error';
                $arr_resp['message']   = trans('admin.error_occure');
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

            /*$arr_leave_type['start'] = Carbon::createFromFormat('Y-m-d',$arr_leave_type['start'])->format('d/m/Y');
            $arr_leave_type['end'] = Carbon::createFromFormat('Y-m-d',$arr_leave_type['end'])->format('d/m/Y');*/

            foreach($arr_leave_type['entitlement'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            foreach($arr_leave_type['applicable'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            foreach($arr_leave_type['restrictions'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            if(!empty($arr_leave_type['exceptions'])) {
                foreach($arr_leave_type['exceptions'] as $key=>$row) {$arr_leave_type[$key]=$row;}
            }
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
                $arr_ins['paid_days']       = $request->input('paid_days');
                $arr_ins['unpaid_days']     = $request->input('unpaid_days');
                $arr_ins['paid_days']       = $request->input('paid_days');
                /*$arr_ins['unpaid_days']     = 0;
                if($request->input('type') == 'unpaid'){
                    $arr_ins['unpaid_days']     = $request->input('paid_days');
                    $arr_ins['paid_days']       = 0;
                }*/
                /*if($request->has('start') && $request->input('start') != '') {
                    $arr_ins['start']           = Carbon::createFromFormat('d/m/Y',$request->input('start'))->format('Y-m-d');
                }
                if($request->has('end') && $request->input('end') != '') {
                    $arr_ins['end']             = Carbon::createFromFormat('d/m/Y',$request->input('end'))->format('Y-m-d');
                }*/

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
                        $arr_excpt['departments'] = '';
                    }else{
                        if($request->has('except_depts') && !empty($request->input('except_depts'))) {
                            $arr_applcbl['departments'] = '';
                            $arr_excpt['departments'] = json_encode($request->input('except_depts'));
                        }
                    }
                    if($request->has('applc_designations') && !empty($request->input('applc_designations'))) {
                        $arr_applcbl['designations'] = json_encode($request->input('applc_designations'));
                        $arr_excpt['designations'] = '';
                    }else{
                        if($request->has('except_designations')&&!empty($request->input('except_designations'))) {
                            $arr_applcbl['designations'] = '';
                            $arr_excpt['designations'] = json_encode($request->input('except_designations'));
                        }
                    }
                    if($request->has('applc_roles') && !empty($request->input('applc_roles'))) {
                        $arr_applcbl['employee_types'] = json_encode($request->input('applc_roles'));
                        $arr_excpt['employee_types'] = '';
                    }else{
                        if($request->has('except_roles') && !empty($request->input('except_roles'))) {
                            $arr_applcbl['employee_types'] = '';
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
                    $arr_resp['message']        = trans('admin.leave_type')." ".trans('admin.updated_successfully');
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

    public function get_emp_leave_type($enc_id)
    {
        $id = base64_decode($enc_id);

        $obj_data = $this->EmpLeavePolicyModel->where('user_id',$id)
                                              ->orderBy('id','DESC')
                                              ->first();
        $valid_till = $obj_data->end ?? '';

        if($valid_till!='')
        {
            $obj_leave_type = $this->EmpLeavePolicyModel->with(['leave_type'=>function($qry){
                                                            $qry->select('id','title');
                                                        }])
                                                        ->where('user_id',$id)
                                                        ->whereDate('end',$valid_till)
                                                        ->select('id','leave_types_id')
                                                        ->get();
            if($obj_leave_type){
                $arr_leave_type = $obj_leave_type->toArray();

                $arr_resp['status'] = 'SUCCESS';
                $arr_resp['message'] = 'Leave type found';
                $arr_resp['arr_leave_type'] = $arr_leave_type;
            }
        }
        else
        {
            $arr_resp['status'] = 'ERROR';
            $arr_resp['message'] = 'Leave type not found.';
            $arr_resp['arr_leave_type'] = [];
        }

        return response()->json($arr_resp,200);
    }

}

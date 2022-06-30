<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\EmpShiftsModel;
use App\Models\WorkShiftsModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use Carbon\Carbon;

class WorkShiftsController extends Controller
{
    public function __construct()
    {
        $this->UserModel            = new User;
        $this->LeadsModel           = new LeadsModel;
        $this->EmpShiftsModel       = new EmpShiftsModel;
        $this->WorkShiftsModel      = new WorkShiftsModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Shifts";
        $this->module_view_folder   = "hr.shift";
    }

    public function index() {

        $arr_shifts = [];

        $obj_shifts = $this->WorkShiftsModel->get();

        if($obj_shifts->count() > 0) {
            $arr_shifts = $obj_shifts->toArray();
        }

        $this->arr_view_data['page_title']  = $this->module_title;
        $this->arr_view_data['arr_shifts']  = $arr_shifts;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store_shift(Request $request) {

        $arr_rules                  = $arr_resp = array();
        $arr_rules['name']          = "required";
        $arr_rules['from']          = "required";
        $arr_rules['to']            = "required";
        $arr_rules['shift_margin']  = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
        }else{

            $arr_ins = [];
            $arr_ins['name']            = $request->input('name');
            $arr_ins['from']            = Carbon::parse($request->input('from'))->format('H:i');
            $arr_ins['to']              = Carbon::parse($request->input('to'))->format('H:i');
            $arr_ins['shift_margin']    = $request->input('shift_margin');
            $arr_ins['margin_before']   = $request->input('margin_before');
            $arr_ins['margin_after']    = $request->input('margin_after');
            $arr_ins['color_code']      = $request->input('color_code');
            // $arr_ins['user_id']         = $this->auth->user()->id;

            if($this->WorkShiftsModel->insert($arr_ins)) {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.shift')." ".trans('admin.added_successfully');
            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
            }
        }

        return response()->json($arr_resp, 200);
    }

    public function edit_shift(Request $request) {

        $enc_id = $request->input('enc_id');
        $id = base64_decode($enc_id);

        $arr_lead = $arr_resp = [];

        $obj_shift = $this->WorkShiftsModel->where('id', $id)->first();

        if($obj_shift) {

            $arr_resp['status'] = 'success';
            $arr_resp['data'] = $obj_shift->toArray();
            $arr_resp['message'] = 'Data Found!';

        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = 'No Data Found!';
        }

        return response()->json($arr_resp, 200);
    }

    public function update_shift($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_shift = $this->WorkShiftsModel->where('id', $id)->first();

        if($obj_shift) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['name']          = "required";
            $arr_rules['from']          = "required";
            $arr_rules['to']            = "required";
            $arr_rules['shift_margin']  = "required";

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) 
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                $arr_ins = [];
                $arr_ins['name']            = $request->input('name');
                $arr_ins['from']            = Carbon::parse($request->input('from'))->format('H:i');
                $arr_ins['to']              = Carbon::parse($request->input('to'))->format('H:i');
                $arr_ins['shift_margin']    = $request->input('shift_margin');
                $arr_ins['margin_before']   = $request->input('margin_before');
                $arr_ins['margin_after']    = $request->input('margin_after');
                $arr_ins['color_code']      = $request->input('color_code');

                if($this->WorkShiftsModel->where('id', $id)->update($arr_ins)) {
                    $arr_resp['status']         = 'success';
                    $arr_resp['message']        = trans('admin.shift')." ".trans('admin.updated_successfully');
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

    public function shift_calender(Request $request) {

        $arr_shifts = $arr_users = $arr_emp_shifts = $def_shift = [];

        $obj_shifts = $this->WorkShiftsModel->get();

        if($obj_shifts->count() > 0) {
            $arr_shifts = $obj_shifts->toArray();
            $def_shift = $arr_shifts[0]??[];
        }

        if(($request->has('start') && $request->input('start')) && ($request->has('end') && $request->input('end'))) {
            $week_start = date("Y-m-d",strtotime($request->input('start')));
            $week_end = date("Y-m-d",strtotime($request->input('end')));
        }elseif($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $week_start = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $week_end = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $current_dayname = date("l");
            $week_start = date("Y-m-d",strtotime('monday this week'));
            $week_end = date("Y-m-d",strtotime("sunday this week"));
        }

        $s = Carbon::parse($week_start);
        $e = Carbon::parse($week_end);
        $diff = $s->diffInDays($e);

        $obj_emp_shifts = $this->EmpShiftsModel->whereHas('shift_details', function(){})
                                                ->with(['shift_details'/*,'user_detail'*/])
                                                ->where(function($q)use($week_start,$week_end){
                                                    $q->whereBetween('from_date',[$week_start,$week_end]);
                                                    $q->orWhereBetween('to_date',[$week_start,$week_end]);
                                                })
                                                ->get();

        if($obj_emp_shifts->count() > 0) {
            $arr_emp_shifts = $obj_emp_shifts->toArray();
        }

        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.customer')];

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->orderBy('id', 'DESC')
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_users = $obj_users->toArray();
        }

        for($i=0;$i<=$diff;$i++) {
            $date = date('Y-m-d', strtotime("+$i day", strtotime($week_start)));

            $day_cnt = $i+1;

            foreach($arr_users as $key => $user) {

                $arr_ass_shifts = [];

                foreach($arr_emp_shifts as $ass_shift) {
                    if($ass_shift['user_id'] == $user['id']) {
                        $arr_ass_shifts[] = $ass_shift;
                    }
                }

                if(!empty($arr_ass_shifts)) {
                    $ret = $this->is_date_in_assigned_shift($date, $arr_ass_shifts);
                    if(!empty($ret)) {
                        $arr_users[$key]['shift'][$day_cnt]    = $ret;
                        $arr_users[$key]['shift'][$day_cnt]['today'] = $date;
                    }else{
                        $ass_shift["id"]                    = '';
                        $ass_shift["user_id"]               = $user['id']??'';
                        $ass_shift["shift_id"]              = $def_shift['id']??'';
                        $ass_shift["shift_details"]         = $def_shift;
                        $arr_users[$key]['shift'][$date]    = $ass_shift;
                        $arr_users[$key]['shift'][$date]['today'] = $date;
                    }

                }else{
                    $ass_shift["id"]                    = '';
                    $ass_shift["user_id"]               = $user['id']??'';
                    $ass_shift["shift_id"]              = $def_shift['id']??'';
                    $ass_shift["shift_details"]         = $def_shift;
                    $arr_users[$key]['shift'][$date]    = $ass_shift;
                    $arr_users[$key]['shift'][$date]['today'] = $date;
                }

            }
        }

        $this->arr_view_data['page_title']  = $this->module_title;
        $this->arr_view_data['week_start']  = $week_start;
        $this->arr_view_data['week_end']    = $week_end;
        $this->arr_view_data['arr_shifts']  = $arr_shifts;
        $this->arr_view_data['arr_users']   = $arr_users;

        return view($this->module_view_folder.'.shift_calender_new',$this->arr_view_data);
    }

    public function store_emp_shift(Request $request) {

        $arr_rules                  = $arr_resp = array();
        $arr_rules['users']         = "required|array|min:1";
        $arr_rules['shift']         = "required";
        $arr_rules['from_date']     = "required";
        $arr_rules['to_date']       = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
        }else{

            $from_date = Carbon::parse($request->input('from_date'))->format('Y-m-d');
            $to_date = Carbon::parse($request->input('to_date'))->format('Y-m-d');

            $arr_ins = [];
            foreach($request->input('users') as $key => $user_id) {
                $arr_ins[$key]['user_id']     = $user_id;
                $arr_ins[$key]['shift_id']    = $request->input('shift');
                $arr_ins[$key]['from_date']   = $from_date;
                $arr_ins[$key]['to_date']     = $to_date;
            }

            $conflict_resp = $this->check_shift_conflict($arr_ins);

            if(isset($conflict_resp['status']) && $conflict_resp['status'] == 'valid')
            {
                if($this->EmpShiftsModel->insert($arr_ins)) {
                    $arr_resp['status']     = 'success';
                    $arr_resp['message']    = trans('admin.shift')." ".trans('admin.added_successfully');
                }else{
                    $arr_resp['status']     = 'error';
                    $arr_resp['message']    = trans('admin.error_msg');
                }
            }else{
                $conflict_resp['req_shift_id'] = $request->input('shift');
                $conflict_resp['from_date']   = $from_date;
                $conflict_resp['to_date']     = $to_date;

                $conflict_resp_html = $this->create_shift_conflict_view($conflict_resp);
                $arr_resp['status']         = 'error';
                $arr_resp['conflict_html']  = $conflict_resp_html;
                $arr_resp['message']        = "Shift conflicts Found!";
            }
        }

        return response()->json($arr_resp, 200);
    }

    public function check_shift_conflict($arr_data) {

        $arr_conflict = [];

        $arr_user_id = array_column($arr_data, 'user_id');

        $obj_emp_shifts = $this->EmpShiftsModel->whereIn('user_id', $arr_user_id)->get();

        if($obj_emp_shifts->count() > 0) {
            $arr_shifts = $obj_emp_shifts->toArray();
            foreach($arr_shifts as $shift) {
                $key = array_search($shift['user_id'], array_column($arr_data, 'user_id'));
                if(isset($arr_data[$key]) && !empty($arr_data[$key])) {
                    $arr_user = $arr_data[$key];

                    $frm_dt_req = date('Y-m-d', strtotime($arr_user['from_date']));
                    $to_dt_req = date('Y-m-d', strtotime($arr_user['to_date']));

                    $frm_dt_ext = date('Y-m-d', strtotime($shift['from_date']));
                    $to_dt_ext = date('Y-m-d', strtotime($shift['to_date']));

                    if (($frm_dt_req >= $frm_dt_ext) && ($frm_dt_req <= $to_dt_ext)){
                        $arr_conflict[] = $shift;
                    }elseif (($to_dt_req >= $frm_dt_ext) && ($to_dt_req <= $to_dt_ext)){
                        $arr_conflict[] = $shift;
                    }
                }
            }
            if(!empty($arr_conflict)) {
                $arr_resp['conflicts'] = $arr_conflict;
                $arr_resp['status'] = 'invalid';
            }else{
                $arr_resp['status'] = 'valid';
            }
        }else{
            $arr_resp['status'] = 'valid';
        }

        return $arr_resp;
    }

    public function create_shift_conflict_view($arr_data) {

        $arr_conflicts = $arr_data['conflicts']??[];

        $html = '';

        $arr_user_id = array_column($arr_conflicts, 'user_id');
        $arr_shift_id = array_unique(array_column($arr_conflicts, 'shift_id'));
        $arr_shift_id[] = (int) $arr_data['req_shift_id']??'';

        $obj_users = $this->UserModel->whereIn('id', $arr_user_id)->get();

        if($obj_users->count() > 0) {

            $obj_shifts = $this->WorkShiftsModel->whereIn('id', $arr_shift_id)->get();

            $arr_shift_dtls = $obj_shifts->toArray();

            $arr_users = $obj_users->toArray();

            $this->arr_view_data['req_shift_id']    = $arr_data['req_shift_id'];
            $this->arr_view_data['req_from_date']   = $arr_data['from_date'];
            $this->arr_view_data['req_to_date']     = $arr_data['to_date'];
            $this->arr_view_data['arr_shifts']      = $arr_conflicts;
            $this->arr_view_data['arr_shift_dtls']  = $arr_shift_dtls;
            $this->arr_view_data['arr_users']       = $arr_users;

            $html = view($this->module_view_folder.'.shift_conflict_view',$this->arr_view_data)->render();

        }

        return $html;
    }

    public function update_emp_shift(Request $request) {

        $req_date = $request->input('chng-date');
        $user_id = $request->input('user_id');
        $shift_id = $request->input('shift');

        $obj_emp_shift = $this->EmpShiftsModel
                                            ->where('user_id', $user_id)
                                            ->where(function($q) use($req_date) {
                                                $q->where('from_date', '<=', $req_date);
                                                $q->where('to_date', '>=', $req_date);
                                            })
                                            ->first();

        if($obj_emp_shift) {

            $arr_exist = $obj_emp_shift->toArray();

            $last = Carbon::parse($req_date)->previous('day')->format('Y-m-d');

            $arr_ins[0]['user_id']     = $user_id;
            $arr_ins[0]['shift_id']    = $obj_emp_shift->shift_id;
            $arr_ins[0]['from_date']   = $obj_emp_shift->from_date;
            $arr_ins[0]['to_date']     = $last;

            $arr_ins[1]['user_id']     = $user_id;
            $arr_ins[1]['shift_id']    = $request->input('shift');
            $arr_ins[1]['from_date']   = Carbon::parse($req_date)->format('Y-m-d');
            $arr_ins[1]['to_date']     = Carbon::parse($req_date)->format('Y-m-d');

            $rest_start_obj = Carbon::parse($req_date??'');
            $rest_end_obj = Carbon::parse($arr_exist['to_date']??'');

            if($rest_start_obj->diffInDays($rest_end_obj) > 0) {
                $arr_ins[2]['user_id']     = $user_id;
                $arr_ins[2]['shift_id']    = $obj_emp_shift->shift_id;
                $arr_ins[2]['from_date']   = $rest_start_obj->addDay()->format('Y-m-d');
                $arr_ins[2]['to_date']     = $rest_end_obj->format('Y-m-d');
            }

            if($this->EmpShiftsModel->insert($arr_ins)) {
                $obj_emp_shift->delete();
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.shift')." ".trans('admin.updated_successfully');
            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = "Failed to update Shift!";
            }
        }else{
            $obj_shift = $this->WorkShiftsModel->where('id', $shift_id)->first();

            $arr_ins['user_id']     = $user_id;
            $arr_ins['shift_id']    = $shift_id;
            $arr_ins['from_date']   = Carbon::parse($req_date)->format('Y-m-d');
            $arr_ins['to_date']     = Carbon::parse($req_date)->format('Y-m-d');

            if($obj_shift) {
                if($this->EmpShiftsModel->insert($arr_ins)) {
                    $arr_resp['status']     = 'success';
                    $arr_resp['message']    = trans('admin.shift')." ".trans('admin.updated_successfully');
                }else{
                    $arr_resp['status']     = 'error';
                    $arr_resp['message']    = trans('admin.failed_to_update_shift');
                }
            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.invalid_request');
            }
        }
        return response()->json($arr_resp, 200);
    }

    public function is_date_in_assigned_shift($date, $arr_ass_shifts) {

        $ret = null;

        $date = date('Y-m-d', strtotime($date));

        // dd($date, $arr_ass_shifts);

        foreach($arr_ass_shifts as $row) {

            $shiftDateBegin = date('Y-m-d', strtotime($row['from_date']));
            $shiftDateEnd = date('Y-m-d', strtotime($row['to_date']));

            if (($date >= $shiftDateBegin) && ($date <= $shiftDateEnd)){
                $ret = $row;
                break;
            }
        }

        return $ret;
    }

}

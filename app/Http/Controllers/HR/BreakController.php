<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\EmpShiftsModel;
use App\Models\WorkShiftsModel;
use App\Models\BreakModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use Carbon\Carbon;

class BreakController extends Controller
{
    public function __construct()
    {
        $this->UserModel            = new User;
        $this->LeadsModel           = new LeadsModel;
        $this->EmpShiftsModel       = new EmpShiftsModel;
        $this->WorkShiftsModel      = new WorkShiftsModel;
        $this->BreakModel           = new BreakModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Break";
        $this->module_view_folder   = "hr.break";
    }

    public function index() {

        $arr_breaks = $arr_shifts = [];

        $obj_break = $this->BreakModel->get();

        if($obj_break->count() > 0) {
            $arr_breaks = $obj_break->toArray();
        }

        $obj_shifts = $this->WorkShiftsModel->get();

        if($obj_shifts->count() > 0) {
            $arr_shifts = $obj_shifts->toArray();
        }

        $this->arr_view_data['page_title']  = $this->module_title;
        $this->arr_view_data['arr_breaks']  = $arr_breaks;
        $this->arr_view_data['arr_shifts']  = $arr_shifts;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store_break(Request $request) {

        $arr_rules                  = $arr_resp = array();
        $arr_rules['title']         = "required";
        $arr_rules['pay_type']      = "required";
        $arr_rules['mode']          = "required";
        $arr_rules['start']         = "required";
        $arr_rules['end']           = "required";
        $arr_rules['applicable_shifts'] = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
        }else{
            $arr_ins['title']           = $request->input('title');
            $arr_ins['start']           = Carbon::parse($request->input('start'))->format('H:i');
            $arr_ins['end']             = Carbon::parse($request->input('end'))->format('H:i');
            $arr_ins['pay_type']        = $request->input('pay_type');
            $arr_ins['mode']            = $request->input('mode');
            $arr_ins['applicable_shifts']   = json_encode($request->input('applicable_shifts'));
            // $arr_ins['user_id']         = $this->auth->user()->id;

            if($this->BreakModel->insert($arr_ins)) {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.break').' '.trans('admin.added_successfully');
            }else{
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
            }
        }

        return response()->json($arr_resp, 200);
    }

    public function edit_break($enc_id) {

        $id = base64_decode($enc_id);

        $arr_lead = $arr_resp = [];

        $obj_break = $this->BreakModel->where('id', $id)->first();

        if($obj_break) {

            $arr_break = $obj_break->toArray();

            $arr_break['applicable_shifts'] = json_decode($arr_break['applicable_shifts']);

            $arr_resp['status'] = 'success';
            $arr_resp['data'] = $arr_break;
            $arr_resp['message'] = trans('admin.data_found');

        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.data_not_found');
        }

        return response()->json($arr_resp, 200);
    }

    public function update_break($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_shift = $this->BreakModel->where('id', $id)->first();

        if($obj_shift) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['title']         = "required";
            $arr_rules['pay_type']      = "required";
            $arr_rules['mode']          = "required";
            $arr_rules['start']         = "required";
            $arr_rules['end']           = "required";
            $arr_rules['applicable_shifts'] = "required";

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) 
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                $arr_ins = [];
                $arr_ins['title']           = $request->input('title');
                $arr_ins['start']           = Carbon::parse($request->input('start'))->format('H:i');
                $arr_ins['end']             = Carbon::parse($request->input('end'))->format('H:i');
                $arr_ins['pay_type']        = $request->input('pay_type');
                $arr_ins['mode']            = $request->input('mode');
                $arr_ins['applicable_shifts']   = json_encode($request->input('applicable_shifts'));

                if($this->BreakModel->where('id', $id)->update($arr_ins)) {
                    $arr_resp['status']     = 'success';
                    $arr_resp['message']    = trans('admin.break')." ".trans('admin.updated_successfully');
                }else{
                    $arr_resp['status']     = 'error';
                    $arr_resp['message']    = trans('admin.error_msg');
                }
            }
        }else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

}

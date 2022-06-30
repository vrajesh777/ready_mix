<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\Traits\MultiActionTrait;

use App\Models\User;
use App\Models\AttendanceModel;
use App\Models\EmpActiveStatusModel;

use Session;
use Validator;
use DateInterval;
use DateTime;
use DatePeriod;

class AttendanceController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
        $this->AttendanceModel      = new AttendanceModel;
        $this->BaseModel            = $this->AttendanceModel;
        $this->EmpActiveStatusModel = new EmpActiveStatusModel;
        $this->UserModel            = new User;

        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.attendace');
        $this->module_view_folder   = 'attendace';
        $this->module_url_path      = url('/attendace');
        $this->auth                 = auth();
    }

    public function attend_calender_view()
    {
        $arr_data = $arr_emp = [];
        $user_id = $this->auth->user()->id ?? 0;

        $obj_data = $this->AttendanceModel->where('user_id',$user_id)->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $obj_emp = $this->UserModel->where('role_id', '!=', config('app.roles_id.customer'))->get();

        if($obj_emp->count() > 0) {
            $arr_emp = $obj_emp->toArray();
        }

        $this->arr_view_data['arr_data'] = $arr_data;
        $this->arr_view_data['arr_emp'] = $arr_emp;
        $this->arr_view_data['auth_user_id'] = $this->auth->user()->id;
       // $this->arr_view_data['arr_data'] = json_encode($arr_data,true);

        return view($this->module_view_folder.'.calender_view',$this->arr_view_data);
    }

    public function user_attend($status)
    {
        $arr_data = $arr_resp = [];
        $user_data = $this->auth->user()->toArray();

        $user_id   = $user_data['id'] ?? '';
        $curr_date = date('Y-m-d');

        if($status!='' && $status == 'check_in')
        {
            $arr_data['user_id']    = $user_id ?? '';
            $arr_data['start_time'] = date('H:i:s') ?? '';
            $arr_data['date']       = $curr_date ?? '';

            $is_attend_today = $this->AttendanceModel->where('user_id',$user_id)
                                                  ->whereDate('date',$curr_date)
                                                  ->count();

            if($is_attend_today == 0)
            {
                $chk_is_exit = $this->EmpActiveStatusModel->where('user_id',$user_id)
                                                  ->whereDate('date',$curr_date)
                                                  ->count();
                if($chk_is_exit == 0)
                {
                    $this->EmpActiveStatusModel->create($arr_data);

                    $start_time        = date('H:i:s');
                    $date              = date('M d, Y');
                    $data['date_time'] = $date.' '.$start_time;

                    $arr_resp['status']  = 'success';
                    $arr_resp['message'] = trans('admin.check_in_successfully');
                    $arr_resp['data']    = $data;
                }
                else
                {
                    $arr_resp['status'] ='error';
                    $arr_resp['message'] = trans('admin.today_already_check_in');
                }  
            }     
            else
            {
                $arr_resp['status'] ='error';
                $arr_resp['message'] = trans('admin.todays_attendance_already_given');
            }                               
        }
        elseif($status!='' && $status == 'check_out')
        {
            $obj_active_status = $this->EmpActiveStatusModel->where('user_id',$user_id)
                                       ->whereDate('date',$curr_date)
                                       ->first();

            if($obj_active_status)
            {
                $obj_active_status->update(['end_time'=> date('H:i:s')]);
                $obj_active_status->save();

                $this->store_attendance($obj_active_status);

                $arr_resp['status']  ='success';
                $arr_resp['message'] = trans('admin.check_out_successfully');
            }
            else
            {
                $arr_resp['status']  ='error';
                $arr_resp['message'] = trans('admin.somthing_went_wrong');
            }
        }
        else
        {
            $arr_resp['status'] ='error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);  
    }

    public function store_attendance($obj_active_status)
    {
        $arr_data['user_id']    = $obj_active_status->user_id ?? '';
        $arr_data['start_time'] = $obj_active_status->start_time ?? '';
        $arr_data['end_time']   = $obj_active_status->end_time ?? '';
        $arr_data['date']       = $obj_active_status->date ?? '';

        $status = $this->AttendanceModel->create($arr_data);
        if($status)
        {
            $this->EmpActiveStatusModel->where('id',$obj_active_status->id)->delete();
        }
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();

    	$arr_rules['name']      = 'required';
    	$arr_rules['is_active'] = 'required';

    	$validator              = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
    	}

    	$name    = $request->input('name');
    	$is_exit = $this->AttendanceModel->where('name',$name)->count();
    	if($is_exit)
    	{
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.already_exist');
    		return response()->json($arr_resp,200);
    	}

    	$arr_ins['name']      = $name;
    	$arr_ins['is_active'] = $request->input('is_active');
    	$arr_ins['lat']       = $request->input('lat');
    	$arr_ins['lng']       = $request->input('lng');
    	$arr_ins['location']  = trim($request->input('location'));

    	$status = $this->AttendanceModel->create($arr_ins);
    	if($status)
    	{
            $arr_resp['status']  = 'success';
            $arr_resp['message'] = 'Attendance store successfully!';
    	}
    	else
    	{
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = 'Probblem occured while , storing attendance!';
    	}

    	return response()->json($arr_resp,200);
    }

    public function get_cal_data(Request $request) {

        $arr_rules = $arr_resp = $arr_attnd = array();

        $arr_rules['start']     = 'required';
        $arr_rules['end']       = 'required';
        $arr_rules['user_id']   = 'required';

        $validator              = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
        }

        $arr_data = [];

        $user_id = $request->input('user_id');
        $start_date = $request->input('start');
        $end_date = $request->input('end');

        $obj_attnd = $this->AttendanceModel
                                        ->where('user_id',$user_id)
                                        ->whereDate('date','>=', $start_date)
                                        ->whereDate('date','<=', $end_date)
                                        ->get();

        if($obj_attnd->count() > 0) {
            $arr_attnd = $obj_attnd->toArray();
        }

        $start_date = \Carbon::create($start_date);
        $end_date = \Carbon::create($end_date);

        for($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');

            $key = array_search($date->format('Y-m-d'), array_column($arr_attnd, 'date'));

            if($key) {
                $attnd = $arr_attnd[$key]??[];
                $arr['title'] = "Present";
                $arr['color'] = "#5cb85c";
                $arr['textColor'] = "white";
                $arr['start'] = $attnd['date'].' '.$attnd['start_time'];
                $arr['end'] = $attnd['date'].' '.$attnd['end_time'];
            }
            elseif($date->dayOfWeek == \Carbon::SUNDAY)
            {
                $arr['title'] = "Week Off";
                $arr['color'] = "#3a77a3";
                $arr['textColor'] = "white";
                $arr['start'] = $date->format('Y-m-d');
            }else{
                $arr['title'] = "Absent";
                $arr['color'] = "#f52d2d";
                $arr['textColor'] = "white";
                $arr['start'] = $date->format('Y-m-d');
            }
            $arr_data[] = $arr;
        }

        $arr_resp['status'] = 'success';
        $arr_resp['data']   = $arr_data;

        return response()->json($arr_resp, 200);
    }

    public function save_attendance(){
        $arr_emp = [];
        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];

        $obj_emp = $this->UserModel->whereHas('role', function(){})
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->with(['department'])
                                    ->get();
        if($obj_emp){
            $arr_emp = $obj_emp->toArray();
        }

        foreach ($arr_emp as $key => $value) {
            
            $arr_dates = $this->getDatesFromRange(date('Y-m').'-01',date('Y-m-d'));

            if(isset($arr_dates) && sizeof($arr_dates)>0){
                foreach ($arr_dates as $date) {
                    $exit = $this->AttendanceModel->whereDate('date',$date)
                                                  ->where('user_id',$value['id'])
                                          ->count();
                    if($exit <= 0){
                        $arr_insert['user_id']       = $value['id'];
                        $arr_insert['start_time']    = '09:00';
                        $arr_insert['end_time']      = '04:00';
                        $arr_insert['date']          = $date;
                        $arr_insert['note']          = '';
                        $arr_insert['total_work_hr'] = 8;
                        $arr_insert['status']        = 'Present';
                        $this->AttendanceModel->create($arr_insert);
                    }
                }
            } 
        }
    }


    function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        //dd($start,$end);
        // Declare an empty array
        $array = array();
          
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
      
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
      
        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }
      
        // Return the array elements
        return $array;
    }

}
  

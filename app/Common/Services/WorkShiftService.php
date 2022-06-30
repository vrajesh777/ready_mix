<?php

namespace App\Common\Services;

use \Session;
use \Mail;
use App\Models\User;
use App\Models\EmpShiftsModel;
use App\Models\WorkShiftsModel;
use Exception;
use Carbon\Carbon;

class WorkShiftService
{
	public function __construct() 
	{
		$this->UserModel            = new User;
        $this->EmpShiftsModel       = new EmpShiftsModel;
        $this->WorkShiftsModel      = new WorkShiftsModel;
	}

	public function get_users_shift_data($start_date, $end_date) {

		$arr_shifts = $arr_users = $arr_emp_shifts = $def_shift = [];

        $week_start = Carbon::createFromFormat('d/m/Y', trim($start_date))->format('Y-m-d');
        $week_end = Carbon::createFromFormat('d/m/Y', trim($end_date))->format('Y-m-d');

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

		return $arr_users;
	}

	public function get_user_shift_data($start_date, $end_date, $user_id) {

		$arr_users = $arr_emp_shifts = $def_shift = $arr_ret = [];

		$obj_shifts = $this->WorkShiftsModel->get();

        if($obj_shifts->count() > 0) {
            $arr_shifts = $obj_shifts->toArray();
            $def_shift = $arr_shifts[0]??[];
        }

        $week_start = Carbon::createFromFormat('d/m/Y', trim($start_date))->format('Y-m-d');
        $week_end = Carbon::createFromFormat('d/m/Y', trim($end_date))->format('Y-m-d');

        $s = Carbon::parse($week_start);
        $e = Carbon::parse($week_end);
        $diff = $s->diffInDays($e);

        $obj_emp_shifts = $this->EmpShiftsModel->whereHas('shift_details', function(){})
                                                ->with(['shift_details'/*,'user_detail'*/])
                                                ->where(function($q)use($week_start,$week_end){
                                                    $q->whereBetween('from_date',[$week_start,$week_end]);
                                                    $q->orWhereBetween('to_date',[$week_start,$week_end]);
                                                })
                                                ->where('user_id', $user_id)
                                                ->get();

        if($obj_emp_shifts->count() > 0) {
            $arr_emp_shifts = $obj_emp_shifts->toArray();
        }

        $obj_users = $this->UserModel->where('id', $user_id)->first();

        if($obj_users) {
            $arr_users = $obj_users->toArray();
        }

        for($i=0;$i<=$diff;$i++) {

            $date = date('Y-m-d', strtotime("+$i day", strtotime($week_start)));

            $day_cnt = $i+1;

            $arr_ass_shifts = [];

            foreach($arr_emp_shifts as $ass_shift) {
				$arr_ass_shifts[] = $ass_shift;
            }

            if(!empty($arr_ass_shifts)) {
                $ret = $this->is_date_in_assigned_shift($date, $arr_ass_shifts);
                if(!empty($ret)) {
                    $arr_ret[$date]    = $ret;
                    $arr_ret[$date]['today'] = $date;
                }else{
                    $ass_shift["id"]                    = '';
                    $ass_shift["user_id"]               = $user_id??'';
                    $ass_shift["shift_id"]              = $def_shift['id']??'';
                    $ass_shift["shift_details"]         = $def_shift;
                    $arr_ret[$date]    = $ass_shift;
                    $arr_ret[$date]['today'] = $date;
                }
            }else{
                $ass_shift["id"]                    = '';
                $ass_shift["user_id"]               = $user_id??'';
                $ass_shift["shift_id"]              = $def_shift['id']??'';
                $ass_shift["shift_details"]         = $def_shift;
                $arr_ret[$date]    = $ass_shift;
                $arr_ret[$date]['today'] = $date;
            }
        }

		return $arr_ret;
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

?>
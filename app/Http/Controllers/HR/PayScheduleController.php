<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PayScheduleModel;

use Session;
use Validator;

class PayScheduleController extends Controller
{
    public function __construct()
    {
    	$this->PayScheduleModel = new PayScheduleModel();
    	$this->BaseModel          = $this->PayScheduleModel;

    	$this->arr_view_data      = [];
    	$this->module_title       = 'Pay Schedule';
    	$this->module_view_folder = 'hr.pay_schedule';
    	$this->module_url_path    = url('/pay_schedule');
    }

    public function index()
    {
        $arr_data = [];
        $obj_data = $this->PayScheduleModel->first();
        if($obj_data){
            $arr_data = $obj_data->toArray();
        }
        $this->arr_view_data['arr_data']         = $arr_data;

        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function edit()
    {
        $arr_data = [];
        $obj_data = $this->PayScheduleModel->first();
        if($obj_data){
            $arr_data = $obj_data->toArray();
        }
        $this->arr_view_data['arr_data']         = $arr_data;
        $this->arr_view_data['module_title']     = $this->module_title;
        $this->arr_view_data['page_title']       = $this->module_title;
        $this->arr_view_data['module_url_path']  = $this->module_url_path;

    	return view($this->module_view_folder.'.edit',$this->arr_view_data);
    }

    public function update(Request $request){
        
        $arr_rules = [];
        $arr_rules['start_payroll']                = 'required';
        $arr_rules['first_pay_date']               = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $myDateTime = \Carbon::createFromFormat('d/m/Y', $request->input('first_pay_date'));
        $newDateString = $myDateTime->format('Y-m-d');

        $arr_insert['salary_on']      = trim($request->input('salary_on'));
        $arr_insert['days_per_month'] = trim($request->input('days_per_month'));
        $arr_insert['pay_on']         = trim($request->input('pay_on'));
        $arr_insert['on_every_month'] = trim($request->input('on_every_month'));
        $arr_insert['start_payroll']  = trim($request->input('start_payroll'));
        $arr_insert['first_pay_date'] = $newDateString;

        $enc_id = trim($request->input('enc_id'));
        $status = $this->PayScheduleModel->updateOrCreate(['id'=>$enc_id],$arr_insert);
        if($status){
            Session::flash('success','Updated successfully.');
            return redirect()->back();  
        }
        else
        {
            Session::flash('success','Something went wrong , please try again.');
            return redirect()->back(); 
        }

    }
}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\Common\Services\EmailService;
use App\Models\User;
use App\Models\InquiryModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use Illuminate\Support\Str;

class InquiryController extends Controller
{
     public function __construct()
    {
        $this->UserModel            = new User;
        $this->InquiryModel         = new InquiryModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.inquiries');
        $this->module_view_folder   = "sales.inquiry";
        // $this->EmailService         = new EmailService();
    }

    public function index(Request $request)
    {
        $arr_data = [];
        $date = '';

        $obj_data = $this->InquiryModel;

        if($request->has('date')) {
            $date = $request->input('date', date('Y-m-d'));
            $date = date('Y-m-d', strtotime($date));
            $obj_data = $obj_data->whereDate('created_at', $date);
        }

        $obj_data = $obj_data->orderBy('id', 'DESC')->get();

        if($obj_data->count() > 0) {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['page_title'] = $this->module_title;
        $this->arr_view_data['date']            = $date;
        $this->arr_view_data['arr_data'] = $arr_data;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create()
    {
        $this->arr_view_data['page_title'] = Str::singular($this->module_title);
        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function submit_inuiry(Request $request) {

        $arr_rules['subject']       = "required";
        $arr_rules['medium']        = "required";
        $arr_rules['email']         = "required|email";
        $arr_rules['requirement']   = "required";

        $validator = validator::make($request->all(),$arr_rules);
        if($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $arr_ins['subject']         = $request->input('subject');
        $arr_ins['medium']          = $request->input('medium');
        $arr_ins['email']           = $request->input('email');
        $arr_ins['from_name']       = $request->input('cust_name');
        $arr_ins['requirement']     = $request->input('requirement');
        $arr_ins['note']            = $request->input('note');

        if($this->InquiryModel->insert($arr_ins)) {
            Session::flash('success',trans('admin.inquiry_submitted_success'));
        }else{
            Session::flash('error',trans('admin.inquiry_submitted_error'));
        }

        return redirect()->back();
    }
}

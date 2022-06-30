<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\EmailService;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ResetPassTokenModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->UserModel            = new User;
        $this->ResetPassTokenModel  = new ResetPassTokenModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.admin');
        $this->module_view_folder   = "auth";
        $this->EmailService         = new EmailService();
    }

    public function verify_email($token) {

        $user = $this->UserModel->where('email_token', $token)->first();

        if($user) {

            if($user->is_email_verified == '1') {
                Session::flash('info',trans('admin.email_already_verify'));
            }else{
                $update = $this->UserModel->where('email_token', $token)->update([
                                                                                'email_verified_at' => now(),
                                                                                'is_email_verified' => '1'
                                                                            ]);
                Session::flash('success',trans('admin.email_verify_success'));
            }

            return redirect(url('/login'));
        }else{
            Session::flash('error',trans('admin.invalid_token'));
        }
    }

    public function login()
    {
        if($this->auth->check()) {
            return redirect()->route('dashboard');
        }

        $this->arr_view_data['page_title'] = 'Sign In';
        return view($this->module_view_folder.'.login',$this->arr_view_data);
    }

    public function process_login(Request $request)
    {
        $arr_rules                   = $arr_json = array();
        $status                      = false;
        $arr_rules['email']          = "required|email";
        $arr_rules['password']       = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $obj_user = $this->UserModel->where('email',$request->only('email'))->first();

        if($obj_user) 
        {
            if($this->auth->attempt($request->only('email', 'password')))
            {
               /* if(Session::has('login_rdirect') && Session::get('login_rdirect') != '') {
                    $url = Session::get('login_rdirect');
                    Session::forget('login_rdirect');
                    return redirect($url);
                }*/
                
                if($request->ajax())
                {
                    $arr_json['status'] = 'success';
                    $arr_json['msg']    = trans('admin.success_login');
                    return response()->json($arr_json);
                }
                else
                {
                    Session::flash('success',trans('admin.success_login'));
                    return redirect(url('/'));
                    /*if($obj_user->role == 'agent') {
                        return redirect(url('/'));
                    }
                    elseif($obj_user->role == 'user') {
                        return redirect(url('/'.$this->cust_panel_slug));
                    }else{
                        return redirect(url('/'));
                    }*/
                }
            }
            else
            {
                if($request->ajax())
                {
                    $arr_json['status'] = 'error';
                    $arr_json['msg']    = trans('admin.inv_login_cred');
                    return response()->json($arr_json);
                }
                else
                {
                    Session::flash('error',trans('admin.inv_login_cred'));
                }
            }
        }
        else
        {
            if($request->ajax())
            {
                $arr_json['status'] = 'error';
                $arr_json['msg']    = trans('admin.inv_login_cred');
                return response()->json($arr_json);
            }
            else
            {
                Session::flash('error',trans('admin.inv_login_cred'));
            }
        }
        return redirect()->back();
    }

    public function logout()
    {
        $this->auth->logout();
        Session::flush();
        return redirect(url('/login'));
    }

    public function forgot_password(Request $request) {

        if($this->auth->check()) {
            return redirect(url('/login'));
        }

        return view($this->module_view_folder.'.forgot_password',$this->arr_view_data);
    }

    public function process_forgot_password(Request $request) { 

        $arr_rules                   = array();
        $status                      = false;
        $arr_rules['email']          = "required|email";

        $validator = validator::make($request->all(),$arr_rules);
        if($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $obj_user = $this->UserModel->where('email',$request->only('email'))->first();

        if($obj_user) 
        {
            if($obj_user->email_verified_at == '') {
                Session::flash('error',trans('admin.email_not_verify_error'));
            }
            else
            {
                $token = bin2hex(random_bytes(5));
                $url = url('/reset-password/'.$token);
                $reset_url = '<a target="_blank" href="'.$url.'">Click here</a>';

                $new_time = date("Y-m-d H:i:s", strtotime('+3 hours'));

                $create_arr['cust_id']      = $obj_user->id;
                $create_arr['token']        = $token;
                $create_arr['expire_at']    = $new_time;

                $create_token = $this->ResetPassTokenModel->create($create_arr);

                if($create_token) {

                    $arr_mail_data['username']       = ucfirst($obj_user->first_name)." ".ucfirst($obj_user->last_name);
                    $arr_mail_data['email']          = $obj_user->email;
                    $arr_mail_data['link']           = $reset_url;
                    $arr_mail_data['password']       = $request->input('password');
                    $arr_mail_data['template_from']  = config('app.project.name');
                    $arr_mail_data['email_template'] = 'emails.reset_pass';
                    $arr_mail_data['subject']        = 'Reset Password';

                    $email_status = $this->EmailService->send_mail($arr_mail_data);

                    if($email_status) {
                        Session::flash('success',trans('admin.reset_link_success'));
                    }else{
                        Session::flash('error',trans('admin.error_send_email'));
                    }

                }else{
                    Session::flash('error',trans('admin.somthing_went_wrong'));
                }
            }
        }
        else
        {
            Session::flash('error',trans('admin.email_not_exit'));
        }

        return redirect()->back();
    }

    public function reset_password($token) {
        $token_obj = $this->ResetPassTokenModel->where('token', $token)->first();

        if($token_obj){

            $now = date("Y-m-d H:i:s");
            $expire_at = $token_obj->expire_at;

            if($token_obj->is_used == '1') {
                Session::flash('error',trans('admin.reset_password_already_link'));
            }
            elseif ($now < $expire_at)
            {
                $obj_user = $this->UserModel->where('id', $token_obj->cust_id)->first();

                if($obj_user) {

                    $this->arr_view_data['enc_id'] = base64_encode($obj_user->id);
                    $this->arr_view_data['token'] = $token;

                }else{
                    Session::flash('error',trans('admin.user_not_exist'));
                }
            }else{
                Session::flash('error',trans('admin.token_expired'));
            }


        }else{
            Session::flash('error',trans('admin.invalid_request'));
        }

        return view($this->module_view_folder.'.reset_pass',$this->arr_view_data);

    }

    public function process_reset_pass(Request $request) {

        $arr_rules                  = array();

        $arr_rules['enc_id']            = "required";
        $arr_rules['token']             = "required";
        $arr_rules['password']          = "required";
        $arr_rules['confirm_password']  = "required|same:password";

        $validator = validator::make($request->all(),$arr_rules);
        if($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $enc_id = $request->input('enc_id');
        $id = base64_decode($enc_id);

        $is_update = $this->UserModel->where('id', $id)
                                ->update([
                                    'password' => Hash::make($request->input('password'))
                                ]);

        if($is_update) {

            $update = $this->ResetPassTokenModel->where('token', $request->input('token'))->update(['is_used'=> '1']);

            Session::flash('success',trans('admin.pass_reset_success'));
            return redirect(url('/login'));
        }else{
            Session::flash('error',trans('admin.error_reset_password'));
            return redirect()->back();
        }

    }

}

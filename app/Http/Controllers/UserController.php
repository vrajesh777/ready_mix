<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\User;
use App\Models\RolesModel;
use App\Models\UserMetaModel;
use App\Models\DepartmentsModel;
use App\Models\DesignationsModel;
use App\Models\EmpEducationModel;
use App\Models\EmpExperienceModel;
use App\Models\CountryModel;
use App\Models\EmpIqamaModel;
use Validator;
use Session;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->UserModel            = new User();
        $this->BaseModel            = $this->UserModel;
        $this->RolesModel           = new RolesModel;
        $this->UserMetaModel        = new UserMetaModel;
        $this->DepartmentsModel     = new DepartmentsModel;
        $this->DesignationsModel    = new DesignationsModel;
        $this->EmpEducationModel    = new EmpEducationModel;
        $this->EmpExperienceModel   = new EmpExperienceModel;
        $this->CountryModel         = new CountryModel;
        $this->EmpIqamaModel        = new EmpIqamaModel;
		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Employee";
        $this->module_view_folder   = "user";
        $this->module_url_path      = url('/employee');
	}

    public function index(Request $request)
    {
        $arr_data = $arr_roles = [];
        $role = '';

        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.vechicle_parts_supplier'),config('app.roles_id.customer')];

        $obj_data = $this->BaseModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->where('last_name', 'not like', '%Dummy%');
        
        if($request->has('type') && $request->type !='')
        {
        	$role = base64_decode($request->type);
        	$obj_data = $obj_data->where('role_id',$role);
        }

        $obj_data = $obj_data->orderBy('id', 'DESC')->get();

        if($obj_data->count() > 0) {
            $arr_data = $obj_data->toArray();
        }

        $obj_roles = $this->RolesModel->whereNotIn('id',$arr_exclude)->get();
        if($obj_roles)
        {
        	$arr_roles = $obj_roles->toArray();
        }

        $this->arr_view_data['arr_data']  = $arr_data;
        $this->arr_view_data['arr_roles'] = $arr_roles;
        $this->arr_view_data['roles']      = $role;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create() {

        $obj_depts = $this->DepartmentsModel->get();
        $arr_depts = $obj_depts->count() > 0 ? $obj_depts->toArray() : [];

        $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.customer'),config('app.roles_id.vechicle_parts_supplier')];

        $obj_users = $this->BaseModel->whereHas('role', function(){})
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->where('is_active', '1')->get();
        $arr_users = $obj_users->count() > 0 ? $obj_users->toArray() : [];

        $arr_country = [];
        $obj_country = $this->CountryModel->where('is_active','1')->get();
        if($obj_country){
            $arr_country = $obj_country->toArray();
        }

        $obj_designs = $this->DesignationsModel->get();
        $arr_designs = $obj_designs->count() > 0 ? $obj_designs->toArray() : [];

        $obj_roles = $this->RolesModel->whereNotIn('id',$arr_exclude)->get();
        $arr_roles = $obj_roles->count() > 0 ? $obj_roles->toArray() : [];

        $this->arr_view_data['arr_users']       = $arr_users;
        $this->arr_view_data['arr_depts']       = $arr_depts;
        $this->arr_view_data['arr_designs']     = $arr_designs;
        $this->arr_view_data['arr_roles']       = $arr_roles;
        $this->arr_view_data['arr_country']     = $arr_country;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = 'Add '.$this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['first_name'] = 'required';
        $arr_rules['last_name']  = 'required';
        // $arr_rules['email']      = 'required|email|unique:users,email';
        // $arr_rules['mobile_no']  = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            // dd($validator->messages()->toArray());
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            if($request->ajax()) {
                return response()->json($arr_resp, 200);
            }else{
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            }
        }

        $email = $request->input('email');
        /*$is_exist_email = $this->BaseModel->where('email',$email)->count();
        if($is_exist_email > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = "Email already exist.";
            return response()->json($arr_resp, 200);
        }*/

        $arr_data['role_id']    = $request->input('role_id');
        $arr_data['first_name'] = $request->input('first_name');
        $arr_data['last_name']  = $request->input('last_name');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        $arr_data['email']      = $email;
        $arr_data['password']   = \Hash::make($request->input('password'));
        $arr_data['is_active']  = '1';
        $arr_data['department_id']  = $request->input('department');
        $arr_data['report_to_id']  = $request->input('reporting_to');
        $arr_data['source_of_hire']  = $request->input('source_of_hire');
        $arr_data['designation_id']  = $request->input('designation');
        $arr_data['join_date']  = $request->input('join_date');
        $arr_data['status']  = $request->input('status');
        $arr_data['emp_type']  = $request->input('emp_type');
        $arr_data['address']  = $request->input('address');
        $arr_data['city']  = $request->input('city');
        $arr_data['state']  = $request->input('state');
        $arr_data['country_id']  = '1';
        $arr_data['postal_code']  = $request->input('postal_code');
        $arr_data['dob']  = $request->input('dob');
        $arr_data['marital_status']  = $request->input('marital_status');
        $arr_data['gender']  = $request->input('gender');
        $arr_data['id_number']  = $request->input('id_number');
        $arr_data['nationality_id']  = $request->input('nationality_id');
        $arr_data['pay_overtime']  = $request->input('pay_overtime');

        $probation_count = $request->input('probation_count',0);
        $probation_unit = $request->input('probation_unit','day');

        if($request->has('join_date') && $request->input('join_date') != '') {
            $confirm_dt = Carbon::createFromFormat('Y-m-d', trim($request->input('join_date')));
            if($probation_unit > 0) {
                switch ($probation_unit) {
                    case 'month':
                        $confirm_dt = $confirm_dt->addMonths($probation_count);
                        break;
                    case 'day':
                        $confirm_dt = $confirm_dt->addDays($probation_count);
                        break;
                    case 'year':
                        $confirm_dt = $confirm_dt->addYear($probation_count);
                        break;
                }
            }
            $arr_data['confirm_date']  = $confirm_dt->format('Y-m-d');
        }
        // trip rate and count
        $arr_data['initial_trip']    = $request->input('initial_trip')??'';
        $arr_data['initial_rate']    = $request->input('initial_rate')??'';
        $arr_data['additional_trip'] = $request->input('additional_trip')??'';
        $arr_data['additional_rate'] = $request->input('additional_rate')??'';

        if($obj_user = $this->BaseModel->create($arr_data))
        {   
            $obj_role = $this->RolesModel->where('id',$request->input('role_id'))->first();

            $obj_user->assignRole($obj_role->name);

            $empNo = str_pad($obj_user->id??'', 5, '0', STR_PAD_LEFT);
            $obj_user->emp_id = $empNo;
            $obj_user->save();

            $u_meta[0]['user_id'] = $obj_user->id;
            $u_meta[0]['meta_key'] = 'probation_count';
            $u_meta[0]['meta_value'] = $probation_count;
            $u_meta[1]['user_id'] = $obj_user->id;
            $u_meta[1]['meta_key'] = 'probation_unit';
            $u_meta[1]['meta_value'] = $probation_unit;

            $this->UserMetaModel->insert($u_meta);

            // insert iqama details
            if(!empty($request->input('iqama_no'))) {
                $input = $request->input();
                $iqamaInput['iqama_no']             = $input['iqama_no'];
                $iqamaInput['iqama_expiry_date']    = Carbon::parse($input['iqama_expiry_date'])->format('Y-m-d');
                $iqamaInput['passport_no']          = $input['passport_no'];
                $iqamaInput['passport_expiry_date'] = Carbon::parse($input['passport_expiry_date'])->format('Y-m-d');
                $iqamaInput['gosi_no']              = $input['gosi_no'];
                $iqamaInput['contract_period']      = $input['contract_period'];
                $iqamaInput['user_id']              =  $obj_user->id;
                // DB::enableQueryLog();
                $this->EmpIqamaModel->insert($iqamaInput);
                // dd(DB::getQueryLog());
            }
            
            if($request->has('comp_name') && !empty($request->input('comp_name'))) {
                $arr_exp = [];
                foreach($request->input('comp_name') as $key => $exp) {
                    $arr_exp[$key]['user_id'] = $obj_user->id??'';
                    $arr_exp[$key]['comp_name'] = $exp;
                    $arr_exp[$key]['job_title'] = $request->input('job_title')[$key]??'';
                    $arr_exp[$key]['from_date'] = $request->input('from_date')[$key]??null;
                    $arr_exp[$key]['to_date'] = $request->input('to_date')[$key]??null;
                    $arr_exp[$key]['description'] = $request->input('exp_description')[$key]??'';
                }
                $this->EmpExperienceModel->insert($arr_exp);
            }

            if($request->has('org_name') && !empty($request->input('org_name'))) {
                $arr_edu = [];
                foreach($request->input('org_name') as $key => $org) {
                    $arr_edu[$key]['user_id'] = $obj_user->id??'';
                    $arr_edu[$key]['org_name'] = $org;
                    $arr_edu[$key]['degree_name'] = $request->input('degree_name')[$key]??'';
                    $arr_edu[$key]['faculty_name'] = $request->input('faculty_name')[$key]??'';
                    $arr_edu[$key]['completion_date'] = $request->input('completion_date')[$key]??null;
                    $arr_edu[$key]['additional_note'] = $request->input('additional_note')[$key]??'';
                }
                $this->EmpEducationModel->insert($arr_edu);
            }

            if($request->ajax()) {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.user').' '.trans('admin.added_successfully');
                return response()->json($arr_resp, 200);
            }else{
                Session::flash('success',trans('admin.user').' '.trans('admin.added_successfully'));
                return redirect()->route('employee');
            }
        }else{
            if($request->ajax()) {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.problem_occured_while_add_user');
                return response()->json($arr_resp, 200);
            }else{
                Session::flash('error', trans('admin.problem_occured_while_add_user'));
                return redirect()->back();
            }
        }

    }

    public function edit($enc_id, Request $request)
    {
        $id = base64_decode($enc_id);

        $arr_data = [];
        $obj_data = $this->BaseModel
                            ->with(['experience','education','designation','user_meta','iqama'])
                            ->where('id',$id)->first();
        if($obj_data){

            $arr_data = $obj_data->toArray();

            if($request->ajax()) {
                $arr_resp_data['id'] = $arr_data['id']??'';
                $arr_resp_data['first_name'] = $arr_data['first_name']??'';
                $arr_resp_data['last_name'] = $arr_data['last_name']??'';
                $arr_resp_data['email'] = $arr_data['email']??'';
                $arr_resp_data['mobile_no'] = $arr_data['mobile_no']??'';
                $arr_resp_data['role_id'] = $arr_data['role_id']??'';
                $arr_response['status'] = 'SUCCESS';
                $arr_response['data'] = $arr_resp_data;
                $arr_response['msg'] = 'Data get successfully.';
                return response()->json($arr_response);
            }else{

                $arr_exclude = [config('app.roles_id.vendor'),config('app.roles_id.admin'),config('app.roles_id.customer'),config('app.roles_id.vechicle_parts_supplier')];

                $obj_users = $this->BaseModel->whereHas('role', function(){})
                                    ->whereNotIn('role_id',$arr_exclude)
                                    ->where('is_active', '1')->get();
                $arr_users = $obj_users->count() > 0 ? $obj_users->toArray() : [];

                $obj_depts = $this->DepartmentsModel->get();
                $arr_depts = $obj_depts->count() > 0 ? $obj_depts->toArray() : [];

                $obj_designs = $this->DesignationsModel->get();
                $arr_designs = $obj_designs->count() > 0 ? $obj_designs->toArray() : [];

                $obj_roles = $this->RolesModel->whereNotIn('id',$arr_exclude)->get();
                $arr_roles = $obj_roles->count() > 0 ? $obj_roles->toArray() : [];

                $arr_country = [];
                $obj_country = $this->CountryModel->where('is_active','1')->get();
                if($obj_country){
                    $arr_country = $obj_country->toArray();
                }

                $this->arr_view_data['arr_users']       = $arr_users;
                $this->arr_view_data['arr_depts']       = $arr_depts;
                $this->arr_view_data['arr_designs']     = $arr_designs;
                $this->arr_view_data['arr_roles']       = $arr_roles;
                $this->arr_view_data['arr_user']        = $arr_data;
                $this->arr_view_data['arr_country']     = $arr_country;

                $this->arr_view_data['module_title']    = $this->module_title;
                $this->arr_view_data['page_title']      = 'Edit '.$this->module_title;
                $this->arr_view_data['module_url_path'] = $this->module_url_path;

                return view($this->module_view_folder.'.edit',$this->arr_view_data);
            }

        }else{
            if($request->ajax()) {
                $arr_response['status'] = 'ERROR';
                $arr_response['msg'] = trans('admin.somthing_went_wrong_try_agin');
                return response()->json($arr_response);
            }else{
                Session::flash('success',trans('admin.invalid_request'));
                return redirect()->back();
            }
        }
    }

    public function update($enc_id, Request $request)
    {
        $arr_rules = $arr_resp = array();

        $id = base64_decode($enc_id);
        $obj_user = $this->BaseModel->where('id', $id)->first();

        if($obj_user) {
            $arr_rules['first_name'] = 'required';
            $arr_rules['last_name']  = 'required';
            // $arr_rules['email']      = 'required|email|unique:users,email,'.$id;
            // if($request->has('password') && $request->input('password') != '') {
            //     $arr_rules['password']  = 'required';
            //     $arr_rules['confirm_password']  = 'required|same:password';
            // }

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails()) {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                if($request->ajax()) {
                    return response()->json($arr_resp, 200);
                }else{
                    return redirect()->back()->withErrors($validator)->withInput($request->all());
                }
            }

            $arr_user = $obj_user->count() > 0 ? $obj_user->toArray() : [];
            $role_id = $request->input('role_id');
            if(!$role_id){
                $role_id = $arr_user['role_id'];
            }
            $email = $request->input('email');

            $arr_data['role_id']    = $role_id;
            $arr_data['first_name'] = $request->input('first_name');
            $arr_data['last_name']  = $request->input('last_name');
            $arr_data['mobile_no']  = $request->input('mobile_no');
            $arr_data['email']      = $email;
            if($request->has('password') && $request->input('password') != '') {
               $arr_data['password']   = \Hash::make($request->input('password'));
            }
            $arr_data['is_active']  = '1';
            $arr_data['department_id']  = $request->input('department');
            $arr_data['report_to_id']  = $request->input('reporting_to');
            $arr_data['source_of_hire']  = $request->input('source_of_hire');
            $arr_data['designation_id']  = $request->input('designation');
            $arr_data['join_date']  = $request->input('join_date');
            $arr_data['status']  = $request->input('status');
            $arr_data['emp_type']  = $request->input('emp_type');
            $arr_data['address']  = $request->input('address');
            $arr_data['city']  = $request->input('city');
            $arr_data['state']  = $request->input('state');
            $arr_data['country_id']  = '1';
            $arr_data['postal_code']  = $request->input('postal_code');
            $arr_data['dob']  = $request->input('dob');
            $arr_data['marital_status']  = $request->input('marital_status');
            $arr_data['gender']  = $request->input('gender');
            $arr_data['nationality_id']  = $request->input('nationality_id');
            $arr_data['pay_overtime']  = $request->input('pay_overtime');

            $probation_count = $request->input('probation_count',0);
            $probation_unit = $request->input('probation_unit','day');

            if($request->has('join_date') && $request->input('join_date') != '') {
                $confirm_dt = Carbon::createFromFormat('Y-m-d', trim($request->input('join_date','')));
                if($probation_count > 0) {
                    switch ($probation_unit) {
                        case 'month':
                            $confirm_dt = $confirm_dt->addMonths($probation_count);
                            break;
                        case 'day':
                            $confirm_dt = $confirm_dt->addDays($probation_count);
                            break;
                        case 'year':
                            $confirm_dt = $confirm_dt->addYear($probation_count);
                            break;
                    }
                }
                $arr_data['confirm_date']  = $confirm_dt->format('Y-m-d');
            }
            // trip rate and count
            $arr_data['initial_trip']    = $request->input('initial_trip')??'';
            $arr_data['initial_rate']    = $request->input('initial_rate')??'';
            $arr_data['additional_trip'] = $request->input('additional_trip')??'';
            $arr_data['additional_rate'] = $request->input('additional_rate')??'';

            if($this->BaseModel->where('id', $id)->update($arr_data)) {
                $exist_roles                = $obj_user->getRoleNames();
                $permission                 = $obj_user->getAllPermissions();
                $this->revoke_permission($obj_user,$exist_roles);
                $obj_role = $this->RolesModel->where('id',$role_id)->first();
                $obj_user->assignRole($obj_role->name);

                $obj_meta =  $this->UserMetaModel->firstOrNew([
                                                    'user_id'=>$id,
                                                    'meta_key'=>'probation_count'
                                                ]);
                $obj_meta->meta_value = $probation_count;
                $obj_meta->save();

                $obj_meta =  $this->UserMetaModel->firstOrNew([
                                                    'user_id'=>$id,
                                                    'meta_key'=>'probation_unit'
                                                ]);
                $obj_meta->meta_value = $probation_unit;
                $obj_meta->save();
                // update iqama details
                if($request->has('iqama_no') && !empty($request->input('iqama_id'))) {
                    $input = $request->input();
                    $iqamaInput['iqama_no']             = $input['iqama_no'];
                    $iqamaInput['iqama_expiry_date']    = Carbon::parse($input['iqama_expiry_date'])->format('Y-m-d');
                    $iqamaInput['passport_no']          = $input['passport_no'];
                    $iqamaInput['passport_expiry_date'] = Carbon::parse($input['passport_expiry_date'])->format('Y-m-d');
                    $iqamaInput['gosi_no']              = $input['gosi_no'];
                    $iqamaInput['contract_period']      = $input['contract_period'];
                    $iqamaInput['user_id']              = $id;
                    $iqama_id                       = $input['iqama_id'];
                    
                    $this->EmpIqamaModel->where('id',$iqama_id)->update($iqamaInput);
                }
                if($request->has('comp_name') && !empty($request->input('comp_name'))) {
                    $arr_exp = [];
                    $this->EmpExperienceModel->where('user_id', $id)->delete();
                    foreach($request->input('comp_name') as $key => $exp) {
                        $arr_exp[$key]['user_id'] = $id;
                        $arr_exp[$key]['comp_name'] = $exp;
                        $arr_exp[$key]['job_title'] = $request->input('job_title')[$key]??'';
                        $arr_exp[$key]['from_date'] = $request->input('from_date')[$key]??'';
                        $arr_exp[$key]['to_date'] = $request->input('to_date')[$key]??'';
                        $arr_exp[$key]['description'] = $request->input('exp_description')[$key]??'';
                    }
                    $this->EmpExperienceModel->insert($arr_exp);
                }

                if($request->has('org_name') && !empty($request->input('org_name'))) {
                    $arr_edu = [];
                    $this->EmpEducationModel->where('user_id', $id)->delete();
                    foreach($request->input('org_name') as $key => $org) {
                        $arr_edu[$key]['user_id'] = $id;
                        $arr_edu[$key]['org_name'] = $org;
                        $arr_edu[$key]['degree_name'] = $request->input('degree_name')[$key]??'';
                        $arr_edu[$key]['faculty_name'] = $request->input('faculty_name')[$key]??'';
                        $arr_edu[$key]['completion_date'] = $request->input('completion_date')[$key]??'';
                        $arr_edu[$key]['additional_note'] = $request->input('additional_note')[$key]??'';
                    }
                    $this->EmpEducationModel->insert($arr_edu);
                }

                if($request->ajax()) {
                    $arr_resp['status']         = 'success';
                    $arr_resp['message']        = trans('admin.user').' '.trans('admin.updated_successfully');
                    return response()->json($arr_resp, 200);
                }else{
                    Session::flash('success',trans('admin.user').' '.trans('admin.updated_successfully'));
                    return redirect()->route('employee');
                }
            }else{
                if($request->ajax()) {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.error_msg');
                    return response()->json($arr_resp, 200);
                }else{
                    Session::flash('error',trans('admin.error_msg'));
                    return redirect()->back();
                }
            }
        }

    }

    public function update_old($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_driver = $this->BaseModel->where('id', $id)->first();

        if($obj_driver){

            $arr_rules  = $arr_resp = array();

            $arr_rules['first_name'] = 'required';
	        $arr_rules['last_name']  = 'required';
	        $arr_rules['email']      = 'required';
	        $arr_rules['mobile_no']  = 'required';
            if($request->has('password') && $request->input('password') != '') {
                $arr_rules['password']  = 'required';
                $arr_rules['confirm_password']  = 'required|same:password';
            }

            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }
            $email = $request->input('email');
            $is_exist_email = $this->BaseModel->where('id','<>',$id)
                                              ->where('email',$email)
                                              ->count();
            if($is_exist_email > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.email_alredy_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['first_name'] = $request->input('first_name');
	        $arr_data['last_name']  = $request->input('last_name');
	        $arr_data['mobile_no']  = $request->input('mobile_no');
	        $arr_data['email']      = $email;
            if($request->has('password') && $request->input('password') != '') {
	           $arr_data['password']   = \Hash::make($request->input('password'));
            }

            $status = $this->BaseModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.error_msg');
            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
        
    }

    public function store_desgn(Request $request) {

        $arr_rules = $arr_resp = array();

        $arr_rules['name'] = 'required|unique:designation,name';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            // dd($validator->messages()->toArray());
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            
            return response()->json($arr_resp, 200);
        }

        $arr_desgn['name'] = $request->input('name');
        $arr_desgn['added_by'] = $this->auth->user()->id;

        if($obj_data = $this->DesignationsModel->create($arr_desgn)) {
            $arr_resp['status']         = 'success';
            $arr_resp['id']             = $obj_data->id??'';
            $arr_resp['name']           = $obj_data->name??'';
            $arr_resp['message']        = trans('admin.designation_add_success');
        }else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.designation_add_error');
        }

        return response()->json($arr_resp, 200);
    }

    public function store_department(Request $request){
        $arr_rules = $arr_resp = array();

        $arr_rules['name'] = 'required|unique:department,name';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            
            return response()->json($arr_resp, 200);
        }

        $arr_desgn['name'] = $request->input('name');
        $arr_desgn['added_by'] = $this->auth->user()->id;

        if($obj_data = $this->DepartmentsModel->create($arr_desgn)) {
            $arr_resp['status']         = 'success';
            $arr_resp['id']             = $obj_data->id??'';
            $arr_resp['name']           = $obj_data->name??'';
            $arr_resp['message']        = trans('admin.department_add_success');
        }else{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.department_add_error');
        }

        return response()->json($arr_resp, 200);
    }
    public function revoke_permission($obj_user,$roles)
    {
        $obj_user->roles()->detach();
    }
}

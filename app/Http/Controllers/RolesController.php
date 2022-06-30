<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\DepartmentsModel;

use DB;
use Validator;
use Session;

class RolesController extends Controller
{
    public function __construct()
    {
    	$this->DepartmentsModel     = new DepartmentsModel();

        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.roles');
        $this->module_view_folder   = "roles";
        $this->module_url_path      = url('/roles');
    }

    public function index()
    {
    	$arr_data = [];

        $roles = Role::orderBy('id','DESC')->get();

        $arr_dept = [];
        $obj_dept = $this->DepartmentsModel->get();
        if($obj_dept){
            $arr_dept = $obj_dept->toArray();
        }
        
        $this->arr_view_data['roles']           = $roles;
        $this->arr_view_data['arr_dept']        = $arr_dept;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create()
    {
    	$arr_permission = [];
        $permission = Permission::get();
        if($permission)
        {
            $arr_permission = $permission->toArray();
        }

        $arr_dept = [];
        $obj_dept = $this->DepartmentsModel->get();
        if($obj_dept){
            $arr_dept = $obj_dept->toArray();
        }

        $this->arr_view_data['arr_dept']        = $arr_dept;
    	$this->arr_view_data['arr_permission'] 	= $arr_permission;
    	$this->arr_view_data['module_title']    = $this->module_title;
    	$this->arr_view_data['page_title']		= $this->module_title;
    	$this->arr_view_data['module_url_path']	= $this->module_url_path;

    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules                  = [];
        $arr_rules['name']          = 'required';
        $arr_rules['permission']    = 'required';
        $arr_rules['department_id'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $slug = \Str::slug($request->input('name'));
        $department_id = $request->input('department_id');

        $is_exist = Role::where('slug',$slug)->where('department_id',$department_id)->count();
        if($is_exist)
        {
            Session::flash('error',trans('admin.role').' '.trans('admin.already_exist'));
            return redirect()->back();
        }

        $arr_create['name'] = trim($request->input('name'));
        $arr_create['slug'] = $slug;
        $arr_create['department_id'] = $department_id;

        $role = Role::create($arr_create);
        $role->syncPermissions($request->input('permission'));

        Session::flash('success',trans('admin.role').' '.trans('admin.created_successfully'));
        return redirect()->back();             
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $role            = Role::find(base64_decode($enc_id));
        $permission      = Permission::get();
        if($permission)
        {
            $arr_permission = $permission->toArray();
        }

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        $arr_dept = [];
        $obj_dept = $this->DepartmentsModel->get();
        if($obj_dept){
            $arr_dept = $obj_dept->toArray();
        }

        $this->arr_view_data['page_title']      = 'Edit Roles';
        $this->arr_view_data['module_title']    = 'Roles';
        $this->arr_view_data['rolePermissions'] = $rolePermissions;
        $this->arr_view_data['arr_permission']  = $arr_permission;
        $this->arr_view_data['role']            = $role;
        $this->arr_view_data['arr_dept']        = $arr_dept;
        $this->arr_view_data['arr_dept']        = $arr_dept;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.edit',$this->arr_view_data);
    }

    public function update(Request $request)
    {
        $arr_rules               = [];
        $arr_rules['role_id']    = 'required';
        $arr_rules['name']       = 'required';
        $arr_rules['permission'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
             Session::flash('error',trans('admin.validation_error_msg'));
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = $request->input('role_id');
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        Session::flash('success',trans('admin.role').' '.trans('admin.updated_successfully'));
        return redirect()->back();
    }
}

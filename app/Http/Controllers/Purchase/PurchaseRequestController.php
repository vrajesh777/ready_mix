<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ItemModel;
use App\Models\RolesModel;
use App\Models\PurchaseUnitsModel;
use App\Models\PurchaseRequestModel;
use App\Models\PurchaseRequestDetailsModel;

use Session;
use Validator;


class PurchaseRequestController extends Controller
{
    public function __construct()
    {
        $this->ItemModel                    = new ItemModel();
        $this->RolesModel                   = new RolesModel();
        $this->PurchaseUnitsModel           = new PurchaseUnitsModel();
        $this->PurchaseRequestModel         = new PurchaseRequestModel();
        $this->BaseModel                    = $this->PurchaseRequestModel;
        $this->PurchaseRequestDetailsModel  = new PurchaseRequestDetailsModel();

    	$this->arr_view_data      = [];
    	$this->module_title       = 'Purchase Request';
    	$this->module_view_folder = "purchase.purchase_request";
    	$this->module_url_path    = url('/purchase_request');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->PurchaseRequestModel->with('user_detail')->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

        $this->arr_view_data['arr_data']            = $arr_data;
        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create()
    {
        $arr_items = $arr_units = [];

        $obj_items = $this->ItemModel->get();

        if($obj_items->count() > 0) {
            $arr_items = $obj_items->toArray();
        }

        $obj_units = $this->PurchaseUnitsModel->get();

        if($obj_units) {
            $arr_units = $obj_units->toArray();
        }

    	$this->arr_view_data['module_title']        = trans('admin.manage').' '.$this->module_title;
        $this->arr_view_data['page_title']          = trans('admin.add_new').' '.$this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;
        $this->arr_view_data['arr_items']     = $arr_items;
        $this->arr_view_data['arr_units']     = $arr_units;

    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function get_department_id($role_id)
    {
        $obj_roles = $this->RolesModel->where('id',$role_id)->first();
        $department_id = $obj_roles->department_id ?? '';
        return $department_id;
    }

    public function store(Request $request)
    {
        $arr_rules = [];

        $arr_rules['purchase_request_name'] = 'required';
        $arr_rules['request_detail'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $request_detail = $request->input('request_detail');
        $arr_req_details = array_filter(json_decode($request_detail, true));

        foreach($arr_req_details as $key => $row) {
            if(empty(array_filter($row))) {
                unset($arr_req_details[$key]);
            }
        }

        $user = \Auth::user();

        $arr_insert['department_id']         = $this->get_department_id($user->role_id);
        $arr_insert['user_id']               = $user->id;
        $arr_insert['purchase_request_name'] = $request->input('purchase_request_name');
        $arr_insert['description']           = trim($request->input('description'));

        if($obj_prm = $this->PurchaseRequestModel->create($arr_insert)) {

            $purchase_request_code = format_purchase_request_number($obj_prm->id);
            $obj_prm->purchase_request_code = $purchase_request_code;
            $obj_prm->save();

            $arr_det_ins = [];

            if(!empty($arr_req_details)) {
                foreach($arr_req_details as $key => $row) {
                    $arr_det_ins[$key]['pur_req_id'] = $obj_prm->id;
                    $arr_det_ins[$key]['item_id'] = (int) $row[0]??0;
                    $arr_det_ins[$key]['unit_id'] = $row[1]??0;
                    $arr_det_ins[$key]['unit_price'] = $row[2]??0;
                    $arr_det_ins[$key]['quantity'] = $row[3]??0;
                    $arr_det_ins[$key]['total'] = $row[4]??0;
                }

                $this->PurchaseRequestDetailsModel->insert($arr_det_ins);
            }

            Session::flash('success',trans('admin.purchase_request_create_success'));
            return redirect()->route('purchase_request');
        }
    }

    public function view($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseRequestModel
                                        ->with([
                                            'user_detail',
                                            'purchase_request_details',
                                            'purchase_request_details.item_detail',
                                            'purchase_request_details.tax_detail'
                                        ])
                                        ->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = [];
            $arr_data = $obj_data->toArray();
            //dd($arr_data);
            $this->arr_view_data['arr_data'] = $arr_data;

            $this->arr_view_data['module_title']    = trans('admin.manage').' '.$this->module_title;
            $this->arr_view_data['page_title']      = 'View '.$this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }
    }

    public function pur_req_change_status($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseRequestModel->where('id',$id)->first();
        if($obj_data)
        {
            $status = base64_decode($request->status) ?? 0;
            $obj_data->status = $status;
            $obj_data->save();

            $arr_resp['status']  = 'success';
            $arr_resp['message'] = trans('admin.status_changed_successfully');
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }

}

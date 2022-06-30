<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseEstimateModel;
use App\Models\PurchaseEstimateDetailsModel;
use App\Models\User;
use App\Models\PurchaseRequestModel;
use App\Models\ItemModel;
use App\Models\PurchaseUnitsModel;
use App\Models\TaxesModel;
use App\Models\PurchaseRequestDetailsModel;

use Validator;
use Session;

class EstimateController extends Controller
{
    //estimate
    public function __construct()
    {
        $this->PurchaseEstimateModel        = new PurchaseEstimateModel();
        $this->BaseModel                    = $this->PurchaseEstimateModel;
        $this->PurchaseEstimateDetailsModel = new PurchaseEstimateDetailsModel();
        $this->User                         = new User();
        $this->PurchaseRequestModel         = new PurchaseRequestModel();
        $this->ItemModel                    = new ItemModel();
        $this->PurchaseUnitsModel           = new PurchaseUnitsModel();
        $this->TaxesModel                   = new TaxesModel();
        $this->PurchaseRequestDetailsModel  = new PurchaseRequestDetailsModel();

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.estimates');
    	$this->module_view_folder = "purchase.estimate";
    	$this->module_url_path    = url('/estimate');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->PurchaseEstimateModel->with(['user_meta'=>function($qry){
                                $qry->where('meta_key','company');
                                $qry->select('user_id','meta_value');
                            },'pur_request'])->get();
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

    	$arr_vendor = $arr_pur_request = [];

    	$obj_pur_request = $this->PurchaseRequestModel->whereDoesntHave('estimate')
                                                    ->select('id','purchase_request_code','purchase_request_name')
                                                    ->where('status','2')
                                                    ->get();
    	if($obj_pur_request)
    	{
    		$arr_pur_request = $obj_pur_request->toArray();
    	}

    	$obj_vendor = User::where('is_active','1')
    						->where('role_id',config('app.roles_id.vendor'))
    						->whereHas('user_meta',function($qry){
    							$qry->where('meta_key','company');
    						})
    						->with(['user_meta'=>function($qry){
    							$qry->where('meta_key','company');
    							$qry->select('user_id','meta_value');
    						}])
    						->select('id')
			 				->get();
		if($obj_vendor)
		{
			$arr_vendor = $obj_vendor->toArray();
		}

        $arr_items = $arr_units = $arr_taxes = [];

        $obj_items = $this->ItemModel->get();

        if($obj_items->count() > 0) {
            $arr_items = $obj_items->toArray();
        }

        $obj_units = $this->PurchaseUnitsModel->get();

        if($obj_units) {
            $arr_units = $obj_units->toArray();
        }

        $obj_taxes = $this->TaxesModel->get();

        if($obj_taxes) {
            $arr_taxes = $obj_taxes->toArray();
        }

        $this->arr_view_data['arr_items']       = $arr_items;
        $this->arr_view_data['arr_units']       = $arr_units;
        $this->arr_view_data['arr_taxes']       = $arr_taxes;
        $this->arr_view_data['arr_vendor']      = $arr_vendor;
        $this->arr_view_data['arr_pur_request'] = $arr_pur_request;

        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = [];

        $arr_rules['vendor_id']                = 'required';
        $arr_rules['pur_req_id']               = 'required';
        $arr_rules['estimate_date']            = 'required';
        $arr_rules['expiry_date']              = 'required';
        $arr_rules['purchase_estimate_detail'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $vendor_id = trim($request->input('vendor_id'));
        $pur_req_id = trim($request->input('pur_req_id'));
        $is_exist = $this->PurchaseEstimateModel->where('vendor_id',$vendor_id)
                                                ->where('pur_req_id',$pur_req_id)
                                                ->count();
        if($is_exist > 0)
        {
            Session::flash('error',trans('admin.estimate_already_exit'));
            return redirect()->back();
        }

        $purchase_estimate_detail = $request->input('purchase_estimate_detail');
        $arr_pur_est_request_details = array_filter(json_decode($purchase_estimate_detail, true));

        foreach($arr_pur_est_request_details as $key => $row) {
            if(empty(array_filter($row))) {
                unset($arr_pur_est_request_details[$key]);
            }
        }

        $user = \Auth::user();

        $arr_insert['vendor_id']     = $vendor_id;
        $arr_insert['pur_req_id']    = $pur_req_id;
        $arr_insert['user_id']       = $user->id;
        $arr_insert['estimate_date'] = trim($request->input('estimate_date'));
        $arr_insert['expiry_date']   = trim($request->input('expiry_date'));
        
        $total_mn = $dc_percent = $dc_total = $after_discount = 0;
        $total_mn       = str_replace(",","", $request->input('total_mn',0));
        $dc_percent     = str_replace(",","", $request->input('dc_percent',0));
        $dc_total       = str_replace(",","", $request->input('dc_total',0));
        $after_discount = str_replace(",","", $request->input('after_discount',0));

        $total = (int) $total_mn - (int) $dc_total;
       
        $arr_insert['sub_total']      = (int) $total_mn;
        $arr_insert['dc_percent']     = (int) $dc_percent;
        $arr_insert['dc_total']       = (int) $dc_total;
        $arr_insert['after_discount'] = (int) $after_discount;
        $arr_insert['total']          = (int) $total;

        if($obj_estimate = $this->PurchaseEstimateModel->create($arr_insert)) {

            $pur_estimate_id = $obj_estimate->id;
            $estimate_no = format_purchase_estimate_number($pur_estimate_id);
            $obj_estimate->estimate_no = $estimate_no;
            $obj_estimate->save();

            $arr_det_ins = [];

            if(!empty($arr_pur_est_request_details)) {
                foreach($arr_pur_est_request_details as $key => $row) {

                    $arr_det_ins[$key]['pur_estimate_id']     = $pur_estimate_id;
                    $arr_det_ins[$key]['item_id']             = (int) $row[0]??0;
                    $arr_det_ins[$key]['unit_id']             = $row[1]??0;
                    $arr_det_ins[$key]['unit_price']          = $row[2]??0;
                    $arr_det_ins[$key]['quantity']            = $row[3]??0;
                    $arr_det_ins[$key]['net_total']           = $row[4]??0;
                    $arr_det_ins[$key]['tax_id']              = (int) $row[5]??0;
                    //$arr_det_ins[$key]['tax_rate']            = '';
                    $arr_det_ins[$key]['net_total_after_tax'] = $row[6]??0;
                    $arr_det_ins[$key]['discount_per']        = $row[7]??0;
                    $arr_det_ins[$key]['discount_money']      = $row[8]??0;
                    $arr_det_ins[$key]['total']               = $row[9]??0;
                }
                $this->PurchaseEstimateDetailsModel->insert($arr_det_ins);
            }

            Session::flash('success',trans('admin.estimate_create_success'));
            return redirect()->route('estimate');
        }
    }

    public function view($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseEstimateModel
                                        ->with(['purchase_estimate_details.item_detail'])
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

    public function estimate_change_status($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseEstimateModel->where('id',$id)->first();
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

    public function pur_req_detail($enc_id)
    {
        $arr_req_data = [];
        $id = base64_decode($enc_id);
        $obj_req_data = $this->PurchaseRequestDetailsModel->where('pur_req_id',$id)->select('item_id','unit_id','unit_price','quantity','total')->get();
        if($obj_req_data)
        {
            $arr_req_data = $obj_req_data->toArray();
            foreach ($arr_req_data as $key => $value) 
            {
                $arr_req_data[$key]['item_code']   = $value['item_id'];
                $arr_req_data[$key]['total_money'] = $value['total'];
                $arr_req_data[$key]['into_money']  = $value['total'];
                $arr_req_data[$key]['total']       = $value['total'];

                unset($arr_req_data[$key]['item_id']);
            }

            $arr_resp['status']  = 'success';
            $arr_resp['data'] = $arr_req_data;
            $arr_resp['message'] = trans('admin.data_found');

        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
        
    }
}

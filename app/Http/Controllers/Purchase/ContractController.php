<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseContractModel;
use App\Models\PurchaseContractAttachmentModel;
use App\Models\PurchaseOrderModel;
use App\Models\User;

use Validator;
use Session;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->PurchaseContractModel           = new PurchaseContractModel();
        $this->PurchaseContractAttachmentModel = new PurchaseContractAttachmentModel();
        $this->PurchaseOrderModel              = new PurchaseOrderModel();
        $this->User                            = new User();

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.estimates');
    	$this->module_view_folder = "purchase.contract";
    	$this->module_url_path    = url('/contract');

        $this->purchase_contract_public_path = url('/').config('app.project.image_path.purchase_contract');
        $this->purchase_contract_base_path   = base_path().config('app.project.image_path.purchase_contract');  
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->PurchaseContractModel->with(['user_meta'=>function($qry){
                                $qry->where('meta_key','company');
                                $qry->select('user_id','meta_value');
                            },'user_details','pur_order_details'])->get();
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

    public function create(Request $request)
    {
    	$arr_vendor = $arr_pur_order = [];
    	$obj_vendor = User::where('is_active','1')
    						->whereDoesntHave('contract', function(){})
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

        $obj_pur_order = $this->PurchaseOrderModel->where('status','2') 
                                                  ->select('id','name','order_number','total','vendor_id')
                                                  ->where('status','2')
                                                  ->get();
        if($obj_pur_order)
        {
            $arr_pur_order = $obj_pur_order->toArray();
        }
   
        $this->arr_view_data['arr_vendor']      = $arr_vendor;
        $this->arr_view_data['arr_pur_order']   = $arr_pur_order;
        $this->arr_view_data['vendor_id']       = $request->vendor_id ?? '';

        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        //dd($request->All());
        $arr_rules                   = [];
        $arr_rules['vendor_id']      = 'required';
        $arr_rules['start_date']     = 'required';
        //$arr_rules['contract_no']    = 'required';
        //$arr_rules['pur_order_id']   = 'required';
        //$arr_rules['contract_value'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $user = \Auth::user();

        $arr_data['user_id']        = $user->id;
        //$arr_data['contract_no']    = $request->input('contract_no');
        //$arr_data['pur_order_id']   = $request->input('pur_order_id');
        $arr_data['vendor_id']      = $request->input('vendor_id');
        $arr_data['contract_value'] = $request->input('contract_value');
        $arr_data['start_date']     = $request->input('start_date');
        $arr_data['end_date']       = $request->input('end_date');
        $arr_data['pay_days']       = $request->input('pay_days');
        $arr_data['sign_status']    = $request->input('sign_status');
        $arr_data['signed_date']    = $request->input('signed_date');
        $arr_data['description']    = $request->input('description');

        $status = $this->PurchaseContractModel->create($arr_data);
        if($status)
        {
            $contract_id    = format_purchase_contract_number($status->id);
            $status->contract_id = $contract_id;
            $status->contract_no = $contract_id;
            $status->save();

            if($request->hasFile('attach'))
            {
                foreach ($request->file('attach') as $attach) {
                    $og_name = $attach->getClientOriginalName();
                    $file_extension = strtolower($attach->getClientOriginalExtension());
                    $file_name      = time().uniqid().'.'.$file_extension;
                    $isUpload       = $attach->move($this->purchase_contract_base_path , $file_name);
                    $arr_attach['pur_contract_id'] = $status->id;
                    $arr_attach['name'] = $og_name;
                    $arr_attach['file'] = $file_name;

                    $this->PurchaseContractAttachmentModel->create($arr_attach);
                }
            }

            Session::flash('success',trans('admin.contract_stored_success'));
        }
        else
        {
            Session::flash('error',trans('admin.contract_stored_error'));
        }

        return redirect()->back();
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseContractModel->with(['attachment'])->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
            $arr_vendor = $arr_pur_order = [];
            $obj_vendor = User::where('is_active','1')
                                ->where('role_id','4')
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

            $obj_pur_order = $this->PurchaseOrderModel->where('status','2') 
                                                      ->select('id','name','order_number','total','vendor_id')
                                                      ->get();
            if($obj_pur_order)
            {
                $arr_pur_order = $obj_pur_order->toArray();
            }
       
            $this->arr_view_data['enc_id']                        = $enc_id;
            $this->arr_view_data['arr_data']                      = $arr_data;
            $this->arr_view_data['arr_vendor']                    = $arr_vendor;
            $this->arr_view_data['arr_pur_order']                 = $arr_pur_order;
            $this->arr_view_data['purchase_contract_public_path'] = $this->purchase_contract_public_path;
            $this->arr_view_data['purchase_contract_base_path']   = $this->purchase_contract_base_path;

            $this->arr_view_data['module_title']        = $this->module_title;
            $this->arr_view_data['page_title']          = $this->module_title;
            $this->arr_view_data['module_url_path']     = $this->module_url_path;

            return view($this->module_view_folder.'.edit',$this->arr_view_data);
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $arr_rules                   = [];
        $arr_rules['enc_id']         = 'required';
        // $arr_rules['vendor_id']      = 'required';
        $arr_rules['start_date']     = 'required';
        //$arr_rules['contract_no']    = 'required';
        //$arr_rules['pur_order_id']   = 'required';
        //$arr_rules['contract_value'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $id = base64_decode($request->input('enc_id'));
        $user = \Auth::user();

        //$arr_data['contract_no']    = $request->input('contract_no');
        //$arr_data['pur_order_id']   = $request->input('pur_order_id');
        // $arr_data['vendor_id']      = $request->input('vendor_id');
        $arr_data['contract_value'] = $request->input('contract_value');
        $arr_data['start_date']     = $request->input('start_date');
        $arr_data['end_date']       = $request->input('end_date');
        $arr_data['pay_days']       = $request->input('pay_days');
        $arr_data['sign_status']    = $request->input('sign_status');
        $arr_data['signed_date']    = $request->input('signed_date');
        $arr_data['description']    = $request->input('description');

        if($request->hasFile('attach'))
        {
            foreach ($request->file('attach') as $attach) {
                $og_name = $attach->getClientOriginalName();
                $file_extension = strtolower($attach->getClientOriginalExtension());
                $file_name      = time().uniqid().'.'.$file_extension;
                $isUpload       = $attach->move($this->purchase_contract_base_path , $file_name);
                $arr_attach['pur_contract_id'] = $id;
                $arr_attach['name'] = $og_name;
                $arr_attach['file'] = $file_name;
                
                $this->PurchaseContractAttachmentModel->create($arr_attach);
            }
        }

        $status = $this->PurchaseContractModel->where('id',$id)->update($arr_data);
        if($status)
        {
            Session::flash('success',trans('admin.contract_update_success'));
        }
        else
        {
            Session::flash('error',trans('admin.contract_update_error'));
        }

        return redirect()->back();
    }

    public function attachment_delete($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseContractAttachmentModel->where('id',$id)->first();
        if($obj_data)
        {
            if($obj_data->delete())
            {
                Session::flash('success',trans('admin.contract_attach_delete_success'));
            }
            else
            {
                Session::flash('error',trans('admin.contract_attach_delete_error'));
            }
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
        }

        return redirect()->back();
    }
}

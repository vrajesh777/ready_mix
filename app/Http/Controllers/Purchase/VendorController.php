<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\Traits\MultiActionTrait;

use App\Models\User;
use App\Models\UserMetaModel;
use App\Models\VendorContactModel;
use App\Models\VendorNoteModel;
use App\Models\VendorAttachmentModel;
use App\Models\PurchaseContractModel;
use App\Models\PurchaseOrderModel;
use App\Models\VendorPaymentModel;

use Validator;
use Session;

class VendorController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
        $this->User                  = new User();
        $this->BaseModel             = $this->User;
        $this->UserMetaModel         = new UserMetaModel();
        $this->VendorContactModel    = new VendorContactModel();
        $this->VendorNoteModel       = new VendorNoteModel();
        $this->VendorAttachmentModel = new VendorAttachmentModel();
        $this->PurchaseContractModel = new PurchaseContractModel();
        $this->PurchaseOrderModel    = new PurchaseOrderModel();
        $this->VendorPaymentModel    = new VendorPaymentModel();
 
    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.vendor');
    	$this->module_view_folder = "purchase.vendor";
    	$this->module_url_path    = url('/vendors');

        $this->vendor_attachment_public_path = url('/').config('app.project.image_path.vendor_attachment');
        $this->vendor_attachment_base_path   = base_path().config('app.project.image_path.vendor_attachment');

        $this->purchase_contract_public_path = url('/').config('app.project.image_path.purchase_contract');
        $this->purchase_contract_base_path   = base_path().config('app.project.image_path.purchase_contract');  
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->User->with('user_meta')
    						   ->where('role_id',config('app.roles_id.vendor'))
    						   ->get(); //4- Vendor
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

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();

    	$arr_rules['company'] = 'required';
    	$validator            = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.validation_errors');

    		return response()->json($arr_resp);
    	}

    	$email = $request->input('email');
    	$is_email_exist = $this->User->where('email',$email)->count();
    	if($is_email_exist > 0)
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['message']        = trans('admin.already_exist');

    		return response()->json($arr_resp);
    	}

        $arr_ins['role_id']     = config('app.roles_id.vendor');
        $arr_ins['email']       = $email;
        $arr_ins['address']     = $request->input('address');
        $arr_ins['city']        = $request->input('city');
        $arr_ins['state']       = $request->input('state');
        $arr_ins['postal_code'] = $request->input('postal_code');
        $arr_ins['password']    = \Hash::make(123456);
        $arr_ins['is_active']   = '1';

        if($obj_vendor = $this->User->create($arr_ins))
        {
            $arr_meta_ins[1]['user_id']    = $obj_vendor->id;
            $arr_meta_ins[1]['meta_key']   = 'company';
            $arr_meta_ins[1]['meta_value'] = $request->input('company');

            $arr_meta_ins[2]['user_id']    = $obj_vendor->id;
            $arr_meta_ins[2]['meta_key']   = 'website';
            $arr_meta_ins[2]['meta_value'] = $request->input('website');

            $arr_meta_ins[3]['user_id']    = $obj_vendor->id;
            $arr_meta_ins[3]['meta_key']   = 'phone';
            $arr_meta_ins[3]['meta_value'] = $request->input('phone');

            $arr_meta_ins[4]['user_id']    = $obj_vendor->id;
            $arr_meta_ins[4]['meta_key']   = 'vat_number';
            $arr_meta_ins[4]['meta_value'] = $request->input('vat_number');

	        $this->UserMetaModel->insert($arr_meta_ins);

	        $arr_resp['status']  = 'success';
    		$arr_resp['message'] = trans('admin.stored_successfully');
        }
    	else
    	{
    		$arr_resp['status']  = 'error';
    		$arr_resp['message'] = trans('admin.prob_occured');
    	}

    	return response()->json($arr_resp);
    }

    public function edit($enc_id)
    {
    	if($enc_id !='')
    	{
    		$id = base64_decode($enc_id);
    	}
    	else
    	{
    		$arr_response['status'] = 'ERROR';
            $arr_response['msg'] 	= trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
    	}

    	$arr_data = [];
    	$obj_data = $this->User->with('user_meta')
                               ->where('id',$id)
                               ->first();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

    	if(isset($arr_data) && sizeof($arr_data)>0)
    	{
    		$arr_response['status'] = 'SUCCESS';
    		$arr_response['data']   = $arr_data;
    		$arr_response['msg']    = trans('admin.data_found');
    	}
    	else
    	{
    		$arr_response['status'] = 'ERROR';
    		$arr_response['msg']    = trans('admin.data_not_found');
    	}

    	return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
    	$id = base64_decode($enc_id);
    	$obj_data = $this->User->where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_rules = $arr_resp = array();

            $arr_rules['company'] = 'required';
            $validator                      = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');

                return response()->json($arr_resp);
            }

            $email = $request->input('email');
            $is_email_exist = $this->User->where('id','<>',$id)->where('email',$email)->count();
            if($is_email_exist > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.already_exist');

                return response()->json($arr_resp);
            }

            $arr_update['email']       = $email;
            $arr_update['address']     = $request->input('address');
            $arr_update['city']        = $request->input('city');
            $arr_update['state']       = $request->input('state');
            $arr_update['postal_code'] = $request->input('postal_code');

            if($obj_vendor = $this->User->where('id',$id)->update($arr_update))
            {
                $arr_meta_ins[1]['user_id']    = $id;
                $arr_meta_ins[1]['meta_key']   = 'company';
                $arr_meta_ins[1]['meta_value'] = $request->input('company');

                $arr_meta_ins[2]['user_id']    = $id;
                $arr_meta_ins[2]['meta_key']   = 'website';
                $arr_meta_ins[2]['meta_value'] = $request->input('website');

                $arr_meta_ins[3]['user_id']    = $id;
                $arr_meta_ins[3]['meta_key']   = 'phone';
                $arr_meta_ins[3]['meta_value'] = $request->input('phone');

                $arr_meta_ins[4]['user_id']    = $id;
                $arr_meta_ins[4]['meta_key']   = 'vat_number';
                $arr_meta_ins[4]['meta_value'] = $request->input('vat_number');

                $this->UserMetaModel->where('user_id',$id)->delete();
                $this->UserMetaModel->insert($arr_meta_ins);

                $arr_resp['status']  = 'success';
                $arr_resp['message'] = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.updated_error');
            }

    	}
    	else
    	{
    		$arr_resp['status']  = 'error';
	    	$arr_resp['message'] = trans('admin.invalid_request');
    	}

    	return response()->json($arr_resp);
    }

    public function view($enc_id)
    {
        $arr_conatct = [];
        $id = base64_decode($enc_id);
        $obj_conatct = $this->User->whereHas('contact_detail',function($qry)use($id){
                                        $qry->where('vendor_id',$id);
                                  })
                                  ->with(['contact_detail'])
                                  ->where('role_id',config('app.roles_id.contact'))
                                  ->get();
        if($obj_conatct)
        {
            $arr_conatct = $obj_conatct->toArray();
        }

        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details(base64_decode($enc_id));
        $this->arr_view_data['enc_id']      = $enc_id;
        $this->arr_view_data['arr_conatct'] = $arr_conatct;
        
        $this->arr_view_data['module_title']        = 'Contract';
        $this->arr_view_data['page_title']          = 'Contract';
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

        return view($this->module_view_folder.'.contact',$this->arr_view_data);
    }

    public function get_item_details($enc_id) {

        $arr_resp = [];

        $id = base64_decode($enc_id);

        $obj_item = $this->User->where('id', $id)->first();

        if($obj_item) {
            $arr_item = $obj_item->toArray();

            $arr_resp['status']                 = 'success';
            $arr_resp['data']['item_id']        = $arr_item['id'];
            $arr_resp['data']['unit_id']        = $arr_item['units'];
            $arr_resp['data']['purchase_price'] = $arr_item['purchase_price'];
            $arr_resp['data']['inventory']      = '';
        }else{
            $arr_resp['status']                 = 'error';
        }

        return response()->json($arr_resp);
    }

    /*---------------------------Contact-----------------------------------------*/
    public function contact($enc_id)
    {
        $arr_conatct = [];
        $id = base64_decode($enc_id);
        $obj_conatct = $this->User->whereHas('contact_detail',function($qry)use($id){
                                        $qry->where('vendor_id',$id);
                                  })
                                  ->with(['contact_detail'])
                                  ->where('role_id',config('app.roles_id.contact'))
                                  ->get();
        if($obj_conatct)
        {
            $arr_conatct = $obj_conatct->toArray();
        }

        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details(base64_decode($enc_id));
        $this->arr_view_data['enc_id']      = $enc_id;
        $this->arr_view_data['arr_conatct'] = $arr_conatct;
        
        $this->arr_view_data['module_title']        = 'Contract';
        $this->arr_view_data['page_title']          = 'Contract';
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

        return view($this->module_view_folder.'.contact',$this->arr_view_data);
    }

    public function contact_store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['first_name']    = 'required';
        $arr_rules['last_name']     = 'required';
        $arr_rules['email']         = 'required';
        $arr_rules['mobile_no']     = 'required';
        $arr_rules['role_position'] = 'required';
        $validator = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');

            return response()->json($arr_resp);
        }

        $email = $request->input('email');
        $is_email_exist = $this->User->where('email',$email)->count();
        if($is_email_exist > 0)
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.email_alredy_exist');

            return response()->json($arr_resp);
        }

        $arr_ins['role_id']       = config('app.roles_id.contact');
        $arr_ins['first_name']    = $request->input('first_name');
        $arr_ins['last_name']     = $request->input('last_name');
        $arr_ins['email']         = $email;
        $arr_ins['mobile_no']     = $request->input('mobile_no');
        $arr_ins['password']      = \Hash::make(123456);
        $arr_ins['is_active']     = '1';

        if($obj_contact = $this->User->create($arr_ins))
        {
            $arr_contact_details['vendor_id']     = base64_decode($request->input('vendor_id'));
            $arr_contact_details['user_id']       = $obj_contact->id;
            $arr_contact_details['role_position'] = $request->input('role_position');
            $this->VendorContactModel->insert($arr_contact_details);

            $arr_resp['status']  = 'success';
            $arr_resp['message'] = trans('admin.stored_successfully');
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.prob_occured');
        }

        return response()->json($arr_resp);
    }

    public function contact_edit($enc_id)
    {
        if($enc_id !='')
        {
            $id = base64_decode($enc_id);
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->User->with(['contact_detail'])->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data']   = $arr_data;
            $arr_response['msg']    = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.data_not_found');
        }

        return response()->json($arr_response);
    }

    public function contact_update($enc_id , Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_user = $this->User->where('id',$id)->first();
        $user_id = $obj_user->id;
        if($obj_user)
        {
            $arr_rules = $arr_resp = array();

            $arr_rules['first_name']    = 'required';
            $arr_rules['last_name']     = 'required';
            $arr_rules['email']         = 'required';
            $arr_rules['mobile_no']     = 'required';
            $arr_rules['role_position'] = 'required';
            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');

                return response()->json($arr_resp);
            }

            $email = $request->input('email');
            $is_email_exist = $this->User->where('email',$email)
                                         ->where('id','<>',$id)
                                         ->count();
            if($is_email_exist > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.email_alredy_exist');

                return response()->json($arr_resp);
            }

            $arr_ins['first_name']    = $request->input('first_name');
            $arr_ins['last_name']     = $request->input('last_name');
            $arr_ins['email']         = $email;
            $arr_ins['mobile_no']     = $request->input('mobile_no');

            if($obj_user->update($arr_ins))
            {
                $role_position = $request->input('role_position');
                $this->VendorContactModel->where('user_id',$user_id)->update(['role_position'=>$role_position]);

                $arr_resp['status']  = 'success';
                $arr_resp['message'] = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.updated_error');
            }
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp);
    }

    /*---------------------------End of Contact-----------------------------------*/

    /*---------------------------Note---------------------------------------------*/
    
    public function note($enc_id)
    {
        $arr_note = [];
        $id = base64_decode($enc_id);
        $obj_note = $this->VendorNoteModel->where('vendor_id',$id)->with('user_detail')->get();
        if($obj_note)
        {
            $arr_note = $obj_note->toArray();
        }

        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details($id);
        $this->arr_view_data['enc_id']   = $enc_id;
        $this->arr_view_data['arr_note'] = $arr_note;
        
        $this->arr_view_data['module_title']        = trans('admin.note');
        $this->arr_view_data['page_title']          = trans('admin.note');
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

        return view($this->module_view_folder.'.note',$this->arr_view_data);
    }

    public function note_store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['vendor_id']   = 'required';
        $arr_rules['description'] = 'required';
        $validator                = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            $arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');

            return response()->json($arr_resp);
        }

        $user = \Auth::user();

        $arr_ins['added_by']    = $user->id;
        $arr_ins['vendor_id']   = base64_decode($request->input('vendor_id'));
        $arr_ins['description'] = $request->input('description');
        $status = $this->VendorNoteModel->create($arr_ins);
        if($status)
        {
            $arr_resp['status']  = 'success';
            $arr_resp['message'] = trans('admin.stored_successfully');
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.prob_occured');
        }

        return response()->json($arr_resp);
    }

    public function note_edit($enc_id)
    {
        if($enc_id !='')
        {
            $id = base64_decode($enc_id);
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.somthing_went_wrong_try_agin');
            return response()->json($arr_response);
        }

        $arr_data = [];
        $obj_data = $this->VendorNoteModel->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        if(isset($arr_data) && sizeof($arr_data)>0)
        {
            $arr_response['status'] = 'SUCCESS';
            $arr_response['data']   = $arr_data;
            $arr_response['msg']    = trans('admin.data_found');
        }
        else
        {
            $arr_response['status'] = 'ERROR';
            $arr_response['msg']    = trans('admin.data_not_found');
        }

        return response()->json($arr_response);
    }

    public function note_update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_note = $this->VendorNoteModel->where('id',$id)->first();
        if($obj_note)
        {
            $arr_rules = $arr_resp = array();
            $arr_rules['description'] = 'required';
            $validator                = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');

                return response()->json($arr_resp);
            }

            $arr_ins['description'] = $request->input('description');
            $status = $obj_note->update($arr_ins);
            if($status)
            {
                $arr_resp['status']  = 'success';
                $arr_resp['message'] = trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']  = 'error';
                $arr_resp['message'] = trans('admin.updated_error');
            }
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp);
    }

    /*---------------------------End of Note---------------------------------------*/

    public function attachment($enc_id)
    {
        $arr_attachment = [];
        $id = base64_decode($enc_id);
        $attachment = $this->VendorAttachmentModel->where('vendor_id',$id)->get();
        if($attachment)
        {
            $arr_attachment = $attachment->toArray();
        }

        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details($id);
        $this->arr_view_data['enc_id']   = $enc_id;
        $this->arr_view_data['arr_attachment'] = $arr_attachment;
        
        $this->arr_view_data['module_title']        = trans('admin.attachments');
        $this->arr_view_data['page_title']          = trans('admin.attachments');
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

        $this->arr_view_data['vendor_attachment_public_path']     = $this->vendor_attachment_public_path;
        $this->arr_view_data['vendor_attachment_base_path']     = $this->vendor_attachment_base_path;

        return view($this->module_view_folder.'.attachment',$this->arr_view_data);
    }

    public function attachment_store(Request $request)
    {
        $arr_rules = $arr_resp = array();

        $arr_rules['vendor_id']   = 'required';
        $arr_rules['attach']      = 'required';
        $validator                = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        if($request->hasFile('attach'))
        {
            foreach ($request->file('attach') as $attach) {
                $og_name = $attach->getClientOriginalName();
                $file_extension = strtolower($attach->getClientOriginalExtension());
                $file_name      = time().uniqid().'.'.$file_extension;
                $isUpload       = $attach->move($this->vendor_attachment_base_path , $file_name);
               
                $arr_attach['vendor_id'] = base64_decode($request->input('vendor_id'));
                $arr_attach['og_name']   = $og_name;
                $arr_attach['file']      = $file_name;

                $this->VendorAttachmentModel->create($arr_attach);
            }

            Session::flash('success',trans('admin.attachments_update_success'));
        }
        else
        {
            Session::flash('error',trans('admin.attachments_update_error'));
        }

        return redirect()->back();
    }

    public function attachment_delete($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->VendorAttachmentModel->where('id',$id)->first();
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

    public function contract($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_data = [];
        $obj_data = $this->PurchaseContractModel->where('vendor_id',$id)
                                                ->with(['user_meta'=>function($qry){
                                                        $qry->where('meta_key','company');
                                                        $qry->select('user_id','meta_value');
                                                    },
                                                    'user_details',
                                                    'pur_order_details',
                                                    'attachment',
                                                ])
                                                ->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['purchase_contract_public_path'] = $this->purchase_contract_public_path;
        $this->arr_view_data['purchase_contract_base_path']   = $this->purchase_contract_base_path;

        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details($id);
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.contracts',$this->arr_view_data);
    }

    public function purchase_orders($enc_id)
    {
        $id = base64_decode($enc_id);
        $arr_data = [];
        $obj_data = $this->PurchaseOrderModel->with(['user_meta'=>function($qry){
                                $qry->where('meta_key','company');
                                $qry->select('user_id','meta_value');
                            },'vendor_payment'])
                        ->where('vendor_id',$id)
                        ->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }
        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details($id);
        $this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['enc_id']          = $enc_id;
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;

        return view($this->module_view_folder.'.purchase_orders',$this->arr_view_data);
    }

    public function get_vendor_details($id)
    {
        $arr_vendor = [];
        $obj_vendor = $this->User->with(['user_meta'=>function($qry){
                                $qry->where('meta_key','company');
                                $qry->select('user_id','meta_value');
                            }])
                            ->select('id')
                            ->where('id',$id)
                            ->first();
        if($obj_vendor)
        {
            $arr_vendor = $obj_vendor->toArray();
        }
        return $arr_vendor; 
    }

    public function vendor_payment($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_payment = $this->VendorPaymentModel->with(['payment_method_detail','order_detail'])->where('vendor_id',$id)->get();
        if($obj_payment)
        {
            $arr_payment = $obj_payment->toArray();
        }

        $this->arr_view_data['arr_vendor_details'] = $this->get_vendor_details($id);
        $this->arr_view_data['arr_payment']        = $arr_payment;
        $this->arr_view_data['enc_id']             = $enc_id;
        $this->arr_view_data['module_title']       = $this->module_title;
        $this->arr_view_data['page_title']         = $this->module_title;
        $this->arr_view_data['module_url_path']    = $this->module_url_path;

        return view($this->module_view_folder.'.payment',$this->arr_view_data);
    }


}

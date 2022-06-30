<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\PurchaseOrderModel;
use App\Models\VechiclePurchasePartsDetailsModel;
use App\Models\VechicleMakeModel;
use App\Models\VechicleModelModel;
use App\Models\VechicleYearModel;
use App\Models\User;
use App\Models\ManufacturerModel;
use App\Models\ItemModel;
use App\Models\TransactionsModel;

use App\Common\Services\TranscationService;

use Validator;
use Session;
use Auth;

class PurchasePartsController extends Controller
{
    use MultiActionTrait;
	public function __construct()
	{
        $this->PurchaseOrderModel        = new PurchaseOrderModel;
        $this->VechiclePurchasePartsDetailsModel = new VechiclePurchasePartsDetailsModel;
        $this->VechicleMakeModel                 = new VechicleMakeModel;
        $this->VechicleModelModel                = new VechicleModelModel;
        $this->VechicleYearModel                 = new VechicleYearModel;
        $this->User                              = new User;
        $this->ManufacturerModel                 = new ManufacturerModel;
        $this->ItemModel                         = new ItemModel;
        $this->TransactionsModel                 = new TransactionsModel;
        $this->TranscationService                = new TranscationService;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Purchase Parts";
        $this->module_view_folder   = "vechicle_maintance.purchase_parts";
        $this->module_url_path      = url('/vhc_purchase_parts');

        $this->department_id      = config('app.dept_id.vechicle_maintance');

        $this->vechicle_img_public_path = url('/').config('app.project.image_path.vechicle_img');
        $this->vechicle_img_base_path   = base_path().config('app.project.image_path.vechicle_img');  
	}

	public function index(Request $request)
    {
    	$arr_data = [];

    	$obj_data = $this->PurchaseOrderModel->with('part')->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

        $this->arr_view_data['arr_data']        = $arr_data;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create(Request $request)
    {
        $id = '';
        if($request->has('id'))
        {
            $id = base64_decode($request->input('id'));
        }

        $arr_make = $arr_model = $arr_year = $arr_supplier = $arr_manufacturer = $arr_items =  [];

        $obj_items = $this->ItemModel->where('is_active','1')
                                    ->where('dept_id',$this->department_id)
                                    ->select('id','commodity_name')
                                    ->get();
        if($obj_items)
        {
            $arr_items = $obj_items->toArray();
        }

        $obj_make = $this->VechicleMakeModel->where('is_active','1')
                                            ->select('id','make_name')
                                            ->get();
        if($obj_make)
        {
            $arr_make = $obj_make->toArray();
        }

        $obj_model = $this->VechicleModelModel->where('is_active','1')->with('make')->get();
        if($obj_model)
        {
            $arr_model = $obj_model->toArray();
        }

        $obj_year = $this->VechicleYearModel->where('is_active','1')->with(['make','model'])->get();
        if($obj_year)
        {
            $arr_year = $obj_year->toArray();
        }

        $obj_supplier = $this->User->where('role_id',config('app.roles_id.vechicle_parts_supplier'))
                                    ->where('is_active','1')
                                    ->get();
        if($obj_supplier)
        {
            $arr_supplier = $obj_supplier->toArray();
        }

        $obj_manufacturer = $this->ManufacturerModel->where('is_active','1')->get();
        if($obj_manufacturer)
        {
            $arr_manufacturer = $obj_manufacturer->toArray();
        }

        $obj_existing = $this->PurchaseOrderModel->where('dept_id',$this->department_id)->with('part')->get();
        if($obj_existing)
        {
            $arr_existing_parts = $obj_existing->toArray();
        }

        $this->arr_view_data['arr_items']          = $arr_items;
        $this->arr_view_data['arr_make']           = $arr_make;
        $this->arr_view_data['arr_model']          = $arr_model;
        $this->arr_view_data['arr_year']           = $arr_year;
        $this->arr_view_data['arr_supplier']       = $arr_supplier;
        $this->arr_view_data['arr_manufacturer']   = $arr_manufacturer;
        $this->arr_view_data['arr_existing_parts'] = $arr_existing_parts;
        $this->arr_view_data['id']                 = $id;

    	$this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseOrderModel->with('parts_details')->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
            $arr_make = $arr_model = $arr_year = $arr_supplier = $arr_manufacturer = $arr_items =[];

            $obj_items = $this->ItemModel->where('is_active','1')
                                ->where('dept_id',$this->department_id)
                                ->select('id','commodity_name')
                                ->get();
            if($obj_items)
            {
                $arr_items = $obj_items->toArray();
            }

            $obj_make = $this->VechicleMakeModel->where('is_active','1')
                                                ->select('id','make_name')
                                                ->get();
            if($obj_make)
            {
                $arr_make = $obj_make->toArray();
            }

            $obj_model = $this->VechicleModelModel->where('is_active','1')->with('make')->get();
            if($obj_model)
            {
                $arr_model = $obj_model->toArray();
            }

            $obj_year = $this->VechicleYearModel->where('is_active','1')->with(['make','model'])->get();
            if($obj_year)
            {
                $arr_year = $obj_year->toArray();
            }

            $obj_supplier = $this->User->where('role_id',config('app.roles_id.vechicle_parts_supplier'))
                                        ->where('is_active','1')
                                        ->get();
            if($obj_supplier)
            {
                $arr_supplier = $obj_supplier->toArray();
            }

            $obj_manufacturer = $this->ManufacturerModel->where('is_active','1')->get();
            if($obj_manufacturer)
            {
                $arr_manufacturer = $obj_manufacturer->toArray();
            }

            $this->arr_view_data['arr_items']        = $arr_items;
            $this->arr_view_data['arr_make']         = $arr_make;
            $this->arr_view_data['arr_model']        = $arr_model;
            $this->arr_view_data['arr_year']         = $arr_year;
            $this->arr_view_data['arr_supplier']     = $arr_supplier;
            $this->arr_view_data['arr_manufacturer'] = $arr_manufacturer;
            $this->arr_view_data['arr_data']         = $arr_data;
            $this->arr_view_data['enc_id']           = $enc_id;
            //dd($arr_data);
            $this->arr_view_data['module_title']    = $this->module_title;
            $this->arr_view_data['page_title']      = $this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;
            return view($this->module_view_folder.'.edit',$this->arr_view_data);
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
        }
        return redirect()->back();
    }

    public function existing_part($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseOrderModel->with('parts_details')->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
            $arr_make = $arr_model = $arr_year = $arr_supplier = $arr_manufacturer = $arr_items = [];

            $obj_items = $this->ItemModel->where('is_active','1')
                                ->where('dept_id',$this->department_id)
                                ->select('id','commodity_name')
                                ->get();
            if($obj_items)
            {
                $arr_items = $obj_items->toArray();
            }

            $obj_make = $this->VechicleMakeModel->where('is_active','1')
                                                ->select('id','make_name')
                                                ->get();
            if($obj_make)
            {
                $arr_make = $obj_make->toArray();
            }

            $obj_model = $this->VechicleModelModel->where('is_active','1')->with('make')->get();
            if($obj_model)
            {
                $arr_model = $obj_model->toArray();
            }

            $obj_year = $this->VechicleYearModel->where('is_active','1')->with(['make','model'])->get();
            if($obj_year)
            {
                $arr_year = $obj_year->toArray();
            }

            $obj_supplier = $this->User->where('role_id',config('app.roles_id.vechicle_parts_supplier'))
                                        ->where('is_active','1')
                                        ->get();
            if($obj_supplier)
            {
                $arr_supplier = $obj_supplier->toArray();
            }

            $obj_manufacturer = $this->ManufacturerModel->where('is_active','1')->get();
            if($obj_manufacturer)
            {
                $arr_manufacturer = $obj_manufacturer->toArray();
            }

            $this->arr_view_data['arr_items']        = $arr_items;
            $this->arr_view_data['arr_make']         = $arr_make;
            $this->arr_view_data['arr_model']        = $arr_model;
            $this->arr_view_data['arr_year']         = $arr_year;
            $this->arr_view_data['arr_supplier']     = $arr_supplier;
            $this->arr_view_data['arr_manufacturer'] = $arr_manufacturer;
            $this->arr_view_data['arr_data']         = $arr_data;
            $this->arr_view_data['enc_id']           = $enc_id;
            //dd($arr_data);
            $this->arr_view_data['module_title']    = $this->module_title;
            $this->arr_view_data['page_title']      = $this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;
            return view($this->module_view_folder.'.existing',$this->arr_view_data);
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
        }
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $arr_rules                   = [];
        $arr_rules['part_id']        = 'required';
        $arr_rules['supply_id']      = 'required';
        $arr_rules['manufact_id']    = 'required';
        $arr_rules['condition']      = 'required';
        $arr_rules['buy_price']      = 'required';
        $arr_rules['quantity']       = 'required';
        $arr_rules['part_no']        = 'required';
        $arr_rules['total_amount']   = 'required';
        $arr_rules['given_amount']   = 'required';
        $arr_rules['pending_amount'] = 'required';
        //$arr_rules['partsfilter'] = 'required';

        $validator = Validator::make($request->All(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.validation_error_msg'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $user = \Auth::user();

        $arr_data['user_id']        = $user->id;
        $arr_data['part_id']        = $request->input('part_id');
        $arr_data['vendor_id']      = $request->input('supply_id');
        $arr_data['manufact_id']    = $request->input('manufact_id');
        $arr_data['condition']      = $request->input('condition');
        $arr_data['buy_price']      = $request->input('buy_price');
        $arr_data['quantity']       = $request->input('quantity');
        $arr_data['sell_price']     = $request->input('sell_price');
        $arr_data['part_no']        = $request->input('part_no');
        $arr_data['order_date']     = date('Y-m-d',strtotime($request->input('purch_date')));
        $arr_data['warrenty']       = $request->input('warrenty');
        $arr_data['total']          = $request->input('total_amount');
        $arr_data['given_amount']   = $request->input('given_amount');
        $arr_data['pending_amount'] = $request->input('pending_amount');
        $arr_data['dept_id']        = $this->department_id;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $file_name = $request->file('image');
            $file_extension = strtolower($image->getClientOriginalExtension());
            if(in_array($file_extension,['png','jpg','jpeg','pdf']))
            {
                $file_name                   = time().uniqid().'.'.$file_extension;
                $isUpload                    = $image->move($this->vechicle_img_base_path , $file_name);
                $arr_data['image'] = $file_name;
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        = trans('admin.invalid_file_type');
                return response()->json($arr_resp, 200);
            }
        }

        $status = $this->PurchaseOrderModel->create($arr_data);
        if($status)
        {


            $status->order_number = format_order_number($status->id);
            $status->save();
            
            $id = $status->id;

            $arr_store['dept_id']     = $this->department_id;
            $arr_store['user_id']     = $request->input('supply_id');
            $arr_store['order_id']    = $id;
            $arr_store['amount']      = $request->input('given_amount');
            $arr_store['type']        = 'credit';
            $arr_store['pay_date']    = date('Y-m-d');

            $this->TranscationService->store_payment($arr_store);

            if($request->has('partsfilter'))
            {
                $partsfilter = $request->input('partsfilter');
                if(sizeof($partsfilter) && count($partsfilter)>0)
                {
                    foreach ($partsfilter as $part_key => $part_value) {

                        $arr_parts['pur_order_id'] = $id;
                        $arr_parts['part_id']     = $request->input('part_id') ?? 0;
                        $arr_parts['make_id']     = $part_value['make'] ?? 0;
                        $arr_parts['model_id']    = $part_value['model'] ?? 0;
                        $arr_parts['year_id']     = $part_value['year'] ?? 0;
                        
                        $this->VechiclePurchasePartsDetailsModel->create($arr_parts);
                    }
                } 
            }
            Session::flash('success',trans('admin.deactivated_successfully')." ".trans('admin.added_successfully'));
        }
        else
        {
            Session::flash('error','Problem occured while storing.');
        }

        return redirect()->back();
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseOrderModel->where('id',$id)->first();
        if($obj_data)
        {
            $arr_rules                   = [];
            $arr_rules['part_id']        = 'required';
            $arr_rules['supply_id']      = 'required';
            $arr_rules['manufact_id']    = 'required';
            $arr_rules['condition']      = 'required';
            $arr_rules['buy_price']      = 'required';
            $arr_rules['quantity']       = 'required';
            $arr_rules['part_no']        = 'required';
            $arr_rules['total_amount']   = 'required';
            $arr_rules['given_amount']   = 'required';
            $arr_rules['pending_amount'] = 'required';
            //$arr_rules['partsfilter'] = 'required';

            $validator = Validator::make($request->All(),$arr_rules);
            if($validator->fails())
            {
                Session::flash('error','Please fill all the required fields.');
                return redirect()->back()->withErrors($validator)->withInputs($request->all());
            }

            $arr_data['part_id']        = $request->input('part_id');
            $arr_data['vendor_id']      = $request->input('supply_id');
            $arr_data['manufact_id']    = $request->input('manufact_id');
            $arr_data['condition']      = $request->input('condition');
            $arr_data['buy_price']      = $request->input('buy_price');
            $arr_data['quantity']       = $request->input('quantity');
            $arr_data['sell_price']     = $request->input('sell_price');
            $arr_data['part_no']        = $request->input('part_no');
            $arr_data['order_date']     = date('Y-m-d',strtotime($request->input('purch_date')));
            $arr_data['warrenty']       = $request->input('warrenty');
            $arr_data['total']   = $request->input('total_amount');
            $arr_data['given_amount']   = $request->input('given_amount');
            $arr_data['pending_amount'] = $request->input('pending_amount');

            if($request->hasFile('image'))
            {
                $image = $request->file('image');
                $file_name = $request->file('image');
                $file_extension = strtolower($image->getClientOriginalExtension());
                if(in_array($file_extension,['png','jpg','jpeg','pdf']))
                {
                    $file_name                   = time().uniqid().'.'.$file_extension;
                    $isUpload                    = $image->move($this->vechicle_img_base_path , $file_name);
                    $arr_data['image'] = $file_name;
                }
                else
                {
                    $arr_resp['status']         = 'error';
                    $arr_resp['message']        = trans('admin.invalid_file_type');
                    return response()->json($arr_resp, 200);
                }
            }

            $status = $this->PurchaseOrderModel->where('id',$id)->update($arr_data);
            if($status)
            {
                if($request->input('pending_amount') != $obj_data->pending_amount)
                {
                    $arr_trans['amount']      = $request->input('given_amount');
                    $arr_trans['type']        = 'credit';
                    $arr_trans['pay_date']    = date('Y-m-d');

                    $this->TransactionsModel->where('order_id',$id)
                                        ->where('dept_id',$this->department_id)
                                        ->update($arr_trans);
                }
                
                if($request->has('partsfilter'))
                {
                    $partsfilter = array_values($request->input('partsfilter'));
                    if(sizeof($partsfilter) && count($partsfilter)>0)
                    {
                        $this->VechiclePurchasePartsDetailsModel->where('pur_order_id',$id)->delete();
                        foreach ($partsfilter as $part_key => $part_value) {

                            $arr_parts['pur_order_id'] = $id;
                            $arr_parts['part_id']     = $request->input('part_id') ?? 0;
                            $arr_parts['make_id']     = $part_value['make'] ?? 0;
                            $arr_parts['model_id']    = $part_value['model'] ?? 0;
                            $arr_parts['year_id']     = $part_value['year'] ?? 0;
                            
                            $this->VechiclePurchasePartsDetailsModel->create($arr_parts);
                        }
                    } 
                }
                Session::flash('success',trans('admin.pur_part_create_success'));
            }
            else
            {
                Session::flash('error',trans('admin.pur_part_create_error'));
            }
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
        }
        

        return redirect()->back();
    }

    public function get_model_html($id)
    {   
        $option = '<option value="">'.trans('admin.select_model').'</option>'; 
        if($id!='')
        {
            $obj_model = $this->VechicleModelModel->where('make_id',$id)
                                                  ->where('is_active','1')
                                                  ->get();
            if($obj_model)
            {
                $arr_model = $obj_model->toArray();
                foreach ($arr_model as $key => $value) { 
                    $option .= '<option value="'.$value['id'].'">'.$value['model_name'].'</option>'; 
                }
                $arr_resp['status']    = 'success';
                $arr_resp['message']   = trans('admin.data_found');
                $arr_resp['data'] = $option;
            }
            else
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.data_not_found');
                $arr_resp['data'] = $option;
            }
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
            $arr_resp['data'] = $option;
        }

        return response()->json($arr_resp,200);
    }

    public function get_year_html(Request $request)
    {
        $option = '<option value="">'.trans('admin.select_year').'</option>'; 
        $model_id = $request->input('model_id');
        $make_id = $request->input('make_id');
        if($model_id!='' && $make_id !='')
        {
            $obj_year = $this->VechicleYearModel->where('make_id',$make_id)
                                                 ->where('model_id',$model_id)
                                                 ->where('is_active','1')
                                                 ->first();
            if($obj_year)
            {
                $arr_year = $obj_year->toArray();

                $start = $arr_year['year'] ?? 0;
                $end = date('Y');
                $yearArray = range($start,$end);

                /*foreach ($arr_year as $key => $value) { 
                    $option .= '<option value="'.$value['year'].'">'.$value['year'].'</option>'; 
                }*/

                foreach ($yearArray as $value) { 
                    $option .= '<option value="'.$value.'">'.$value.'</option>'; 
                }
                $arr_resp['status']    = 'success';
                $arr_resp['message']   = trans('admin.data_found');
                $arr_resp['data'] = $option;
            }
            else
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.data_not_found');
                $arr_resp['data'] = $option;
            }
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
            $arr_resp['data'] = $option;
        }

        return response()->json($arr_resp,200);
    }

    public function get_parts_html(Request $request)
    {
        $option = '<option value="">'.trans('admin.select_part').'</option>'; 
        $model_id = $request->input('model_id');
        $make_id = $request->input('make_id');
        $year_id = $request->input('year_id');
        if($model_id!='' && $make_id !='' && $year_id!='')
        {
            $obj_part = $this->VechiclePurchasePartsDetailsModel->where('make_id',$make_id)
                                                                ->where('model_id',$model_id)
                                                                ->with(['part'=>function($qry1){
                                                                        $qry1->select('id','commodity_name');
                                                                    }])
                                                                ->groupBy('part_id')
                                                                ->get();
            if($obj_part)
            {
                $arr_parts = $obj_part->toArray();
                foreach ($arr_parts as $key => $value) { 
                    $option .= '<option value="'.$value['part_id'].'">'.$value['part']['commodity_name'].'</option>'; 
                }
                $arr_resp['status']    = 'success';
                $arr_resp['message']   = trans('admin.data_found');
                $arr_resp['data'] = $option;
            }
            else
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.data_not_found');
                $arr_resp['data'] = $option;
            }
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
            $arr_resp['data'] = $option;
        }

        return response()->json($arr_resp,200);
    }

    public function view($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseOrderModel->with('parts_details',
                                                    'supplier_details',
                                                    'manufacturer_details',
                                                    'part')
                                            ->where('id',$id)
                                            ->first();
        if($obj_data)
        {
            $arr_details = $obj_data->toArray();

            $arr_details['code'] = '<p class="pname m-0">'.$arr_details['part']['commodity_name'].'</p><p class="pprice m-0">Price :'.$arr_details['buy_price'].'</p>'.\DNS1D::getBarcodeHTML($arr_details['part_no'], "C128",1.4,22).'<p class="pid m-0">'.$arr_details['part_no'].'</p>';
            $arr_resp['status']    = 'success';
            $arr_resp['message']   = trans('admin.data_found');
            $arr_resp['arr_details']  = $arr_details;
        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }
}

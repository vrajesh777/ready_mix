<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Common\Traits\MultiActionTrait;

use App\Models\ItemModel;
use App\Models\TaxesModel;
use App\Models\PurchaseUnitsModel;
use App\Models\CommodityGroupsModel;
use App\Models\ItemImagesModel;

use Session;
use Validator;

class ItemController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
        $this->ItemModel            = new ItemModel();
        $this->BaseModel            = $this->ItemModel;
        $this->TaxesModel           = new TaxesModel();
        $this->PurchaseUnitsModel   = new PurchaseUnitsModel();
        $this->CommodityGroupsModel = new CommodityGroupsModel();
        $this->ItemImagesModel      = new ItemImagesModel();

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.items');
    	$this->module_view_folder = "purchase.items";
    	$this->module_url_path    = url('/items');

        $this->department_id      = config('app.dept_id.purchase');
        $this->item_image_public_path = url('/').config('app.project.image_path.item_image');
        $this->item_image_base_path   = base_path().config('app.project.image_path.item_image');
    }

    public function index()
    {
    	$arr_data = [];
    	// $obj_data = $this->ItemModel->where('dept_id',$this->department_id)
        $obj_data = $this->ItemModel
                                    ->with(['tax_detail',
                                            'unit_detail',
                                            'commodity_group_detail',
                                            'item_images'
                                           ])
                                    ->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

        $arr_taxes = [];
        $obj_taxes = $this->TaxesModel->where('is_active','1')->get();
        if($obj_taxes)
        {
            $arr_taxes = $obj_taxes->toArray();
        }

        $arr_units = [];
        $obj_units = $this->PurchaseUnitsModel->where('is_active','1')->get();
        if($obj_units)
        {
            $arr_units = $obj_units->toArray();
        }

        $arr_commodity_group = [];
        $obj_commodity_group = $this->CommodityGroupsModel->where('is_active','1')->get();
        if($obj_commodity_group)
        {
            $arr_commodity_group = $obj_commodity_group->toArray();
        }

        $this->arr_view_data['arr_data']            = $arr_data;
        $this->arr_view_data['arr_taxes']           = $arr_taxes;
        $this->arr_view_data['arr_units']           = $arr_units;
        $this->arr_view_data['arr_commodity_group'] = $arr_commodity_group;
        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;
        
        $this->arr_view_data['item_image_public_path']   = $this->item_image_public_path;
        $this->arr_view_data['item_image_base_path']     = $this->item_image_base_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = array();

        //$arr_rules['commodity_code'] = 'required';
        $arr_rules['commodity_name'] = 'required';
        $arr_rules['purchase_price'] = 'required';
        $arr_rules['units']          = 'required';

    	$validator                      = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
    		$arr_resp['validation_err'] = $validator->messages()->toArray();
    		$arr_resp['message']        = trans('admin.validation_errors');

    		return response()->json($arr_resp);
    	}

    	$commodity_name = $request->input('commodity_name');
    	$is_exist = $this->ItemModel->where('commodity_name',$commodity_name)->count();
    	if($is_exist > 0)
    	{
    		$arr_resp['status'] = 'error';
    		$arr_resp['message'] = 'Already Exits !';

    		return response()->json($arr_resp);
    	}

        $arr_ins['commodity_name']    = $commodity_name;
        $arr_ins['description']       = $request->input('description');
        $arr_ins['commodity_group']   = $request->input('commodity_group');
        $arr_ins['purchase_price']    = $request->input('purchase_price');
        $arr_ins['units']             = $request->input('units');
        $arr_ins['tax_id']            = $request->input('tax_id');
        $arr_ins['rate']              = $request->input('purchase_price');
        $arr_ins['dept_id']             = $this->department_id;

        //$arr_ins['commodity_barcode'] = $request->input('commodity_barcode');
        //$arr_ins['sku_code']          = $request->input('sku_code');
        //$arr_ins['sku_name']          = $request->input('sku_name');
       
    	$status = $this->ItemModel->create($arr_ins);

        if($request->has('file'))
        {
            $arr_file = $request->input('file');
            foreach ($arr_file as $key => $value) 
            {
                $image_64 = $value; //your base64 encoded data
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
                // find substring fro replace here eg: data:image/png;base64,
                $image = str_replace($replace, '', $image_64); 
                $image = str_replace(' ', '+', $image); 
                $imageName = Str::random(10).'.'.$extension;
                file_put_contents($this->item_image_base_path.$imageName, base64_decode($image));
                $arr_image_store['item_id'] = $status->id ?? '';
                $arr_image_store['image'] = $imageName ?? '';

                $this->ItemImagesModel->create($arr_image_store);
            }
        }

    	if($status)
    	{
            $commodity_code    = format_item_commodity_code($status->id);
            $status->commodity_code = $commodity_code;
            $status->save();

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
    	$obj_data = $this->ItemModel->with(['tax_detail','unit_detail','commodity_group_detail','item_images'])->where('id',$id)->first();
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
    	$obj_data = $this->ItemModel->where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_rules = $arr_resp = array();

            $arr_rules['commodity_name'] = 'required';
            $arr_rules['purchase_price'] = 'required';
            $arr_rules['units']          = 'required';

            $validator                      = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');

                return response()->json($arr_resp);
            }

            $commodity_name = $request->input('commodity_name');
            $is_exist = $this->ItemModel->where('commodity_name',$commodity_name)
                                        ->where('id','<>',$id)
                                        ->count();
            if($is_exist > 0)
            {
                $arr_resp['status'] = 'error';
                $arr_resp['message'] = trans('admin.already_exist');

                return response()->json($arr_resp);
            }
            
            $arr_ins['commodity_name']    = $commodity_name;
            $arr_ins['description']       = $request->input('description');
            $arr_ins['commodity_group']   = $request->input('commodity_group');
            $arr_ins['purchase_price']    = $request->input('purchase_price');
            $arr_ins['units']             = $request->input('units');
            $arr_ins['tax_id']            = $request->input('tax_id');
            $arr_ins['rate']              = $request->input('purchase_price');
            $arr_ins['dept_id']             = $this->department_id;

            //$arr_ins['commodity_barcode'] = $request->input('commodity_barcode');
            //$arr_ins['sku_code']          = $request->input('sku_code');
            //$arr_ins['sku_name']          = $request->input('sku_name');
            //$arr_ins['rate']              = $request->input('rate');
            
            $status = $this->ItemModel->where('id',$id)->update($arr_ins);
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

    public function view($enc_id)
    {
        $arr_data = [];
        $obj_data = $this->ItemModel->with(['tax_detail','unit_detail','commodity_group_detail'])->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data']            = $arr_data;
        $this->arr_view_data['module_title']        = trans('admin.manage').' '.$this->module_title;
        $this->arr_view_data['page_title']          = 'View '.$this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

        return view($this->module_view_folder.'.view',$this->arr_view_data);
    }

    public function get_item_details($enc_id) {

        $arr_resp = [];

        $id = base64_decode($enc_id);

        $obj_item = $this->ItemModel->with(['unit_detail'])->where('id', $id)->first();

        if($obj_item) {
            $arr_item = $obj_item->toArray();

            $arr_resp['status']                 = 'success';
            $arr_resp['data']['item_id']        = $arr_item['id'];
            $arr_resp['data']['commodity_code'] = $arr_item['commodity_code'];
            $arr_resp['data']['unit_id']        = $arr_item['units'];
            $arr_resp['data']["unit_code"]      = $arr_item['unit_detail']['unit_code']??'';
            $arr_resp['data']["unit_name"]      = $arr_item['unit_detail']['unit_name']??'';
            $arr_resp['data']["unit_symbol"]    = $arr_item['unit_detail']['unit_symbol']??'';
            $arr_resp['data']['purchase_price'] = $arr_item['purchase_price'];
            $arr_resp['data']['inventory']      = '';
        }else{
            $arr_resp['status']                 = 'error';
        }

        return response()->json($arr_resp);
    }

    public function get_tax_details($enc_id) {

        $arr_resp = [];

        $id = base64_decode($enc_id);

        $obj_item = $this->ItemModel->with('tax_detail')->where('id', $id)->first();

        if($obj_item) {
            $arr_item = $obj_item->toArray();

            $arr_resp['status']                 = 'success';
            $arr_resp['data']['item_id']        = $arr_item['id'];
            $arr_resp['data']['unit_id']        = $arr_item['units'];
            $arr_resp['data']['purchase_price'] = $arr_item['purchase_price'];
            $arr_resp['data']['inventory']      = '';
            $arr_resp['data']['total_tax']      = $arr_item['tax_detail']['tax_rate'];
        }else{
            $arr_resp['status']                 = 'error';
        }

        return response()->json($arr_resp);
    }

}

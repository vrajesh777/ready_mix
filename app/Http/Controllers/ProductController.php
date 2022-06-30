<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Common\Traits\MultiActionTrait;

use App\Models\ProductModel;
use App\Models\TaxesModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductAttributeValuesModel;
use App\Common\Services\ERP\ItemService;
use Validator;
use Session;

class ProductController extends Controller
{
    use MultiActionTrait;
    public function __construct()
    {
        $this->ProductModel                = new ProductModel();
        $this->TaxesModel                  = new TaxesModel();
        $this->BaseModel                   = $this->ProductModel;
        $this->ProductAttributesModel      = new ProductAttributesModel();
        $this->ProductAttributeValuesModel = new ProductAttributeValuesModel();
        $this->ItemService                 = new ItemService();

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.product');
        $this->module_view_folder   = "product";
        $this->module_url_path      = url('/product');
    }

    public function index()
    {
    	$arr_data = [];
    	$obj_data = $this->ProductModel->with('tax_detail')->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

    	$arr_tax = [];
    	$obj_tax = $this->TaxesModel->where('is_active','1')->get();
    	if($obj_tax)
    	{
    		$arr_tax = $obj_tax->toArray();
    	}

        $arr_attribute = [];
        $obj_attribute = $this->ProductAttributesModel->orderBy('order_number','asc')->get();
        if($obj_attribute)
        {
            $arr_attribute = $obj_attribute->toArray();
        }

        $this->arr_view_data['arr_data']        = $arr_data;
    	$this->arr_view_data['arr_tax'] 		= $arr_tax;
        $this->arr_view_data['arr_attribute']   = $arr_attribute;
    	$this->arr_view_data['module_title']    = $this->module_title;
    	$this->arr_view_data['page_title']		= $this->module_title;
    	$this->arr_view_data['module_url_path']	= $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store(Request $request)
    {
    	$arr_rules = $arr_resp = $arr_item_data=array();

        $arr_rules['name']      = 'required';
        $arr_rules['min_quant'] = 'required';

        $user = \Auth::user();
        if($user->hasPermissionTo('product-price-update'))
        {
            $arr_rules['rate']      = 'required';
            $arr_rules['tax_id']    = 'required';
        }

    	$validator = Validator::make($request->all(),$arr_rules);
    	if($validator->fails())
    	{
    		$arr_resp['status']         = 'error';
            $arr_resp['validation_err'] = $validator->messages()->toArray();
            $arr_resp['message']        = trans('admin.validation_errors');
            return response()->json($arr_resp, 200);
    	}

    	$mix_code   = $request->input('mix_code');
    	/*$is_exist_code = $this->ProductModel->where('mix_code',$mix_code)->count();
    	if($is_exist_code > 0)
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.product')." ".trans('admin.already_exist');
            return response()->json($arr_resp, 200);
    	}*/

        $arr_data['name']          = trim($request->input('name'));
        $arr_data['name_english']  = trim($request->input('name_english'));
        $arr_data['mix_code']    = $mix_code;
        $arr_data['min_quant']   = trim($request->input('min_quant'));
        $arr_data['description'] = trim($request->input('description'));
        if($user->hasPermissionTo('product-price-update'))
        {
            $arr_data['rate']        = trim($request->input('rate'));
            $arr_data['tax_id']      = trim($request->input('tax_id'));
            $arr_data['opc_1_rate']  = trim($request->input('opc_1_rate'));
            $arr_data['src_5_rate']  = trim($request->input('src_5_rate'));
        }

        $arr_dynamic_att = $request->input('dynamic_att') ?? [];

        // dd($arr_data);
    	$status = $this->ProductModel->create($arr_data);
    	if($status)
    	{
            $arr_item_data['stock_id']         = $mix_code;
            $arr_item_data['description']      = $arr_data['name'];
            $arr_item_data['long_description'] = $arr_data['description'];
            $this->ItemService->store($arr_item_data);

            if(isset($arr_dynamic_att) && sizeof($arr_dynamic_att)>0)
            {
                foreach ($arr_dynamic_att as $key => $value) 
                {
                    $arr_attr_insert[$key]['product_id'] = $status->id;
                    $arr_attr_insert[$key]['product_attr_id'] = $key;
                    $arr_attr_insert[$key]['value'] = $value;
                    $arr_attr_insert[$key]['other_val'] = isset($arr_dynamic_att['other-'.$key])?$arr_dynamic_att['other-'.$key]:'';
                }

                $this->ProductAttributeValuesModel->insert($arr_attr_insert);
            }

            $arr_resp['status']         = 'success';
            $arr_resp['message']        = trans('admin.product')." ".trans('admin.added_successfully');
    	}
    	else
    	{
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.error_msg');
    	}
        
    	return response()->json($arr_resp, 200);
    }

    public function edit($enc_id)
    {
    	if($enc_id!='')
    	{
    		$id = base64_decode($enc_id);
    	}
    	else
    	{
    		$arr_response['status'] = 'ERROR';
            $arr_response['msg'] 	=  trans('admin.error_msg');
            return response()->json($arr_response);
    	}

    	$arr_data = [];
    	$obj_data = $this->ProductModel->with(['attr_values'])->where('id',$id)->first();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}

    	if(isset($arr_data) && sizeof($arr_data)>0)
    	{
    		$arr_response['status'] = 'SUCCESS';
    		$arr_response['data']   = $arr_data;
    		$arr_response['msg']    = 'Data get successfully.';
    	}
    	else
    	{
    		$arr_response['status'] = 'ERROR';
    		$arr_response['msg']    =  trans('admin.error_msg'); 
    	}

    	return response()->json($arr_response);
    }

    public function update($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $user = \Auth::user();
        
        $obj_product = $this->ProductModel->where('id', $id)->first();
        if($obj_product)
        {
            $arr_rules = [];

            $arr_rules['name']      = 'required';
            $arr_rules['min_quant'] = 'required';
            if($user->hasPermissionTo('product-price-update')){
                $arr_rules['rate']      = 'required';
                $arr_rules['tax_id']    = 'required';
            }
            
            $validator = Validator::make($request->all(),$arr_rules);
            if($validator->fails())
            {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
                return response()->json($arr_resp, 200);
            }

            $mix_code   = $request->input('mix_code');
            $is_exist_code = $this->ProductModel->where('id','<>',$id)
                                                ->where('mix_code',$mix_code)
                                                ->count();
            if($is_exist_code > 0)
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        =  trans('admin.product')." ". trans('admin.already_exist');
                return response()->json($arr_resp, 200);
            }

            $arr_data['name']        = trim($request->input('name'));
            $arr_data['name_english']= trim($request->input('name_english'));
            $arr_data['mix_code']    = $mix_code;
            $arr_data['min_quant']   = trim($request->input('min_quant'));
            $arr_data['description'] = trim($request->input('description'));
            if($user->hasPermissionTo('product-price-update')){
                $arr_data['rate']        = trim($request->input('rate'));
                $arr_data['tax_id']      = trim($request->input('tax_id'));
                $arr_data['opc_1_rate'] = trim($request->input('opc_1_rate'));
                $arr_data['src_5_rate'] = trim($request->input('src_5_rate'));
            }
            
            $arr_dynamic_att = $request->input('dynamic_att') ?? [];
            if(isset($arr_dynamic_att) && sizeof($arr_dynamic_att)>0)
            {
                $this->ProductAttributeValuesModel->where('product_id',$id)->delete();
                
                foreach ($arr_dynamic_att as $key => $value) 
                {
                    $arr_attr_insert[$key]['product_id'] = $id;
                    $arr_attr_insert[$key]['product_attr_id'] = $key;
                    $arr_attr_insert[$key]['value'] = $value;
                    $arr_attr_insert[$key]['other_val'] = isset($arr_dynamic_att['other-'.$key])?$arr_dynamic_att['other-'.$key]:'';
                }

                $this->ProductAttributeValuesModel->insert($arr_attr_insert);
            }

            $status = $this->ProductModel->where('id',$id)->update($arr_data);
            if($status)
            {
                $arr_resp['status']         = 'success';
                $arr_resp['message']        =  trans('admin.product')." ". trans('admin.updated_successfully');
            }
            else
            {
                $arr_resp['status']         = 'error';
                $arr_resp['message']        =  trans('admin.error_msg');

            }
        }
        else{

            $arr_resp['status']         = 'error';
            $arr_resp['message']        =  trans('admin.invalid_request');
        }

    	return response()->json($arr_resp, 200);
    }

    public function search(Request $request) {

        $key = $request->input('keyword','');

        $arr_resp['results'] = [];

        $obj_prod = $this->ProductModel->where('is_active', '1')
                                        ->where(function($q) use($key){
                                            $q->where('name','like', '%'.$key.'%');
                                            $q->orWhere('description','like', '%'.$key.'%');
                                        })
                                        ->get();

        if($obj_prod->count() > 0) {
            foreach($obj_prod->toArray() as $key => $row) {
                $arr_resp['results'][$key] = array('id'=> $row['id'], 'text'=> $row['name']);
            }
        }

        return response()->json($arr_resp, 200);
    }
}

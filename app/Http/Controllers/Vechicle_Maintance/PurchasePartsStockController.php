<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ItemModel;
use App\Models\PurchaseOrderModel;
use App\Models\VechiclePurchasePartsDetailsModel;
use App\Models\VhcPartSupplyDetailModel;

class PurchasePartsStockController extends Controller
{
    public function __construct()
	{
		$this->ItemModel                		 = new ItemModel;
		$this->PurchaseOrderModel                = new PurchaseOrderModel;
		$this->VechiclePurchasePartsDetailsModel = new VechiclePurchasePartsDetailsModel;
		$this->VhcPartSupplyDetailModel          = new VhcPartSupplyDetailModel;

		$this->auth               = auth();
		$this->arr_view_data      = [];
		$this->module_title       = trans('admin.parts_stock');
		$this->module_view_folder = "vechicle_maintance.parts_stocks";
		$this->module_url_path    = url('/vhc_parts_stocks');
		$this->department_id      = config('app.dept_id.vechicle_maintance');
	}

	public function index()
	{
		$arr_data = [];
		$obj_items = $this->ItemModel->where('dept_id',$this->department_id)
									 ->with(['vhc_supply_detail'=> function($qry1){
										$qry1->where('status','2');
									 },'vhc_purchase_orders'=>function($qry){
										 $qry->where('status','2');
									 }])
								     ->get();
		if($obj_items)
		{
			$arr_data = $obj_items->toArray();
		}

		// dd($arr_data);
		
		$this->arr_view_data['arr_data']        = $arr_data;
		$this->arr_view_data['module_title']    = $this->module_title;
		$this->arr_view_data['page_title']      = $this->module_title;
		$this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
	}
}

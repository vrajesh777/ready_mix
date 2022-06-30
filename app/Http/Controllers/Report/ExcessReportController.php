<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeliveryNoteModel;
use Carbon\Carbon;

class ExcessReportController extends Controller
{
    public function __construct()
    {
    	$this->DeliveryNoteModel          = new DeliveryNoteModel();

    	$this->arr_view_data        = [];
        $this->module_title         = "Excess/Resell Report";
        $this->module_view_folder   = "report";
        $this->module_url_path      = url('/excess_rpt');
    }

    public function index(Request $request)
    {
    	$arr_delivery = [];
    	$from_id = $to_id = '';
    	if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        $arr_from_customer = $arr_to_customer = [];

        $obj_delivery = $this->DeliveryNoteModel->where('reject_by','3')
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date)
                                    ->with(['order_details.product_details'])
                                    ->with(['from_customer'=>function($qry){
                                    	$qry->select('id','first_name','last_name');
                                	},'to_customer'=>function($qry1){
                                		$qry1->select('id','first_name','last_name');
                                	},'to_delivery.order_details.product_details']);
                                	
        if($request->has('from_id') && $request->input('from_id')!='')
        {
        	$from_id = $request->input('from_id');
        	$obj_delivery = $obj_delivery->where('from_customer_id',$from_id);
        }

        if($request->has('to_id') && $request->input('to_id')!='')
        {
        	$to_id = $request->input('to_id');
        	$obj_delivery = $obj_delivery->where('to_customer_id',$to_id);
        }

        $obj_delivery = $obj_delivery->get();

        if($obj_delivery)
        {
        	$arr_delivery = $obj_delivery->toArray();
        	foreach ($arr_delivery as $key => $value) {
        		$arr_from_customer[] = $value['from_customer'] ?? [];
        		$arr_to_customer[] = $value['to_customer'] ?? [];
        	}
        }
        //dd($arr_delivery);
    	$this->arr_view_data['start_date']        = $start_date;
    	$this->arr_view_data['end_date']          = $end_date;
    	$this->arr_view_data['arr_delivery']      = $arr_delivery;
    	$this->arr_view_data['arr_from_customer'] = $arr_from_customer;
    	$this->arr_view_data['arr_to_customer']   = $arr_to_customer;
    	$this->arr_view_data['from_id']           = $from_id;
    	$this->arr_view_data['to_id']             = $to_id;
    	$this->arr_view_data['page_title']        = $this->module_title;
        return view($this->module_view_folder.'.excess_rpt',$this->arr_view_data);
    }
}

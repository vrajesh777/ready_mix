<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrdersModel;
use Carbon\Carbon;

class ResrvProgressiveReportController extends Controller
{
    public function __construct()
    {
    	$this->OrdersModel          = new OrdersModel();

    	$this->arr_view_data        = [];
        $this->module_title         = trans('admin.reservations_progressive_report');
        $this->module_view_folder   = "report";
        $this->module_url_path      = url('/resrv_progressive_rpt');
    }

    public function index(Request $request)
    {
    	$arr_orders = [];

    	if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','ord_details.product_details','invoice','cust_details','pump_details','transactions','contract','ord_details.del_notes'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date)
                                    ->get();
        if($obj_orders)
        {
        	$arr_orders = $obj_orders->toArray();
        }
        //dd($arr_orders);
    	$this->arr_view_data['start_date']      = $start_date;
    	$this->arr_view_data['end_date']        = $end_date;
    	$this->arr_view_data['arr_orders']      = $arr_orders;
    	$this->arr_view_data['page_title']      = $this->module_title;
        return view($this->module_view_folder.'.resrv_progressive_rpt',$this->arr_view_data);
    }

}

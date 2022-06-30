<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeliveryNoteModel;
use App\Models\VehicleModel;

use Carbon\Carbon;

class DalivOutPutMixerReportController extends Controller
{
    public function __construct()
    {
        $this->DeliveryNoteModel    = new DeliveryNoteModel();
        $this->VehicleModel    = new VehicleModel();

    	$this->arr_view_data        = [];
        $this->module_title         = trans('admin.daliv_out_put_mix_report');
        $this->module_view_folder   = "report";
        $this->module_url_path      = url('/daliv_output_mix_rpt');
    }

    public function index(Request $request)
    {
        //dd($request->all());
        $arr_data = [];
        $start_time = $end_time = $start_date_time = $end_date_time = '';

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            //dump($arr_range);
            $start_date_time = Carbon::createFromFormat('d/m/Y h:i A', trim($arr_range[0]??''))->format('Y-m-d h:i A');
            $end_date_time = Carbon::createFromFormat('d/m/Y h:i A', trim($arr_range[1]??''))->format('Y-m-d h:i A');

            $start_date = Carbon::createFromFormat('d/m/Y h:i A', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y h:i A', trim($arr_range[1]??''))->format('Y-m-d');
            $start_time = Carbon::createFromFormat('d/m/Y h:i A', trim($arr_range[0]??''))->format('H:i');
            $end_time = Carbon::createFromFormat('d/m/Y h:i A', trim($arr_range[1]??''))->format('H:i');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        $obj_data = $this->DeliveryNoteModel->whereHas('order_details.order',function($qry)use($start_time,$end_time){
                                        $qry->where('delivery_time','>=', $start_time);
                                        $qry->where('delivery_time','<=', $end_time);
                                    })
                                    ->with(['driver','vehicle','order_details.order'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date)
                                    ->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $arr_driver = [];
        foreach ($arr_data as $key => $value) {
            $arr_driver[$value['driver_id']][] = $value;
        }

        $this->arr_view_data['start_date']      = $start_date;
        $this->arr_view_data['end_date']        = $end_date;
        $this->arr_view_data['start_date_time'] = $start_date_time;
        $this->arr_view_data['end_date_time']   = $end_date_time;
        $this->arr_view_data['arr_driver']      = $arr_driver;
        $this->arr_view_data['page_title']      = $this->module_title;
        return view($this->module_view_folder.'.daliv_output_mix_rpt',$this->arr_view_data);
    }
}

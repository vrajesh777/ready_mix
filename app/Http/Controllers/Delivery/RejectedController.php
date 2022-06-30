<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeliveryNoteModel;

use Carbon\Carbon;

class RejectedController extends Controller
{
	//rejected_del
    
    public function __construct()
	{
		$this->DeliveryNoteModel    = new DeliveryNoteModel();

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.rejected');
        $this->module_view_folder   = "delivery.rejected_del";
        $this->module_url_path      = url('/rejected_del');
	}

    public function index(Request $request)
    {
        $arr_data = [];

        $reject_by = '';
       	if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }



        $obj_data = $this->DeliveryNoteModel->with(['driver',
        											'vehicle',
        											'order_details.order.cust_details'
        										  ])
        										->whereDate('delivery_date','>=', $start_date)
                                    			->whereDate('delivery_date','<=', $end_date)
        										->whereNotNull('reject_by');

        if($request->has('reject_by') && $request->has('reject_by')!='null')
        {
        	$reject_by = $request->input('reject_by');
        	$obj_data = $obj_data->where('reject_by',$reject_by);
        }
        $obj_data = $obj_data->get();

        if($obj_data->count() > 0) {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data']   = $arr_data;
        $this->arr_view_data['start_date'] = $start_date;
        $this->arr_view_data['end_date']   = $end_date;
        $this->arr_view_data['reject_by']   = $reject_by;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
}

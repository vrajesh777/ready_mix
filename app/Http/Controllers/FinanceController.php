<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryNoteModel;
use Validator;
use Session;
use Carbon\Carbon;
use App\Common\Services\ERP\SalesService;
class FinanceController extends Controller
{
    public function __construct(DeliveryNoteModel $DeliveryNoteModel)
    {
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Finance";
        $this->module_view_folder   = "finance";
        $this->DeliveryNoteModel    = $DeliveryNoteModel;
        $this->SalesService         = new SalesService();
        $this->module_url_path      = url('/finance');
    }
    public function index(Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        $end_date   = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range  = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date   = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }
        $arr_delivery_note = $this->load_delivery_note($start_date,$end_date);

        $this->arr_view_data['start_date'] = $start_date;
        $this->arr_view_data['end_date']   = $end_date;
        $this->arr_view_data['arr_delivery_note'] = $arr_delivery_note;
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['page_title']        = $this->module_title;
		return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    public function confirmed_invoice(Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        $end_date   = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range  = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date   = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }
        $arr_delivery_note = $this->load_delivery_note($start_date,$end_date,'delivered');
        //$this->module_url_path = url('/finance/confirmed_invoice');

        $this->arr_view_data['start_date'] = $start_date;
        $this->arr_view_data['end_date']   = $end_date;
        $this->arr_view_data['arr_delivery_note'] = $arr_delivery_note;
        $this->arr_view_data['module_url_path']   = $this->module_url_path;
        $this->arr_view_data['page_title']        = $this->module_title;
        return view($this->module_view_folder.'.confirmed_invoice',$this->arr_view_data);
    }
    public function load_delivery_note($start_date,$end_date,$status='')
    {

        $obj_user  = \Auth::user();
        $user      = $obj_user->role??'';
        $user_role = $user->slug??'';
        $user_id   = $obj_user->id??'';
        $arr_delivery_note = [];
      
        $obj_delivery_note = $this->DeliveryNoteModel->whereDate('delivery_date','>=',$start_date)
                                                     ->whereDate('delivery_date','<=',$end_date)
                                                     ->with(['driver','vehicle']);
        if($status!="")
        {
            $obj_delivery_note = $obj_delivery_note->where('status',$status);
        }
        if($user_role=='customer')
        {
            $obj_delivery_note = $obj_delivery_note->whereHas('order_details.order',function($q1)use($user_id){
                $q1->where('cust_id',$user_id);
            });
        }
        $obj_delivery_note = $obj_delivery_note->get();                                           

        $arr_delivery_note = $obj_delivery_note->toArray();
        return $arr_delivery_note;
        //$this->arr_view_data['arr_delivery_note'] = $arr_delivery_note;                                    
        //$view = view($this->module_view_folder.".delivery_note",$this->arr_view_data)->render();
        //return response()->json(['delivery_note_html'=>$view]);
    }
    public function change_delivery_status(Request $request)
    {   
 
        $update_status   = '';
        $enc_order_id    = $request->input('enc_order_id');
        $delivery_status = 'cancelled';
        $reason          = $request->input('reason');
        $order_id        = base64_decode($enc_order_id);
        $obj_delivery_note = $this->DeliveryNoteModel->where('id','=',$order_id)->first();
         
        if($obj_delivery_note)
        {
            $update_status=$obj_delivery_note->update(['status'=>$delivery_status,'canceled_reason'=>$reason]);
        }
        if($update_status)
        {
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = 'Delivery status updated successfully.';
        }
        else
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.error_msg');
        }
        return response()->json($arr_resp, 200);
    }
    public function change_confirm_invoice($enc_id)
    {

        $update_status   = '';
        $delivery_status = 'delivered';
        $order_id        = base64_decode($enc_id);
        $obj_delivery_note = $this->DeliveryNoteModel->where('id','=',$order_id)->first();
         
        if($obj_delivery_note)
        {
            $update_status=$obj_delivery_note->update(['status'=>$delivery_status]);
        }

        if($update_status)
        {
            $arr_resp['status']         = 'success';
            $arr_resp['message']        = 'Delivery status updated successfully.';
        }
        else
        {
            $arr_resp['status']         = 'error';
            $arr_resp['message']        = trans('admin.error_msg');
        }
        return response()->json($arr_resp, 200);
    }
    public function add_to_erp($enc_id)
    {
        $arr_data = [];
        $order_id        = base64_decode($enc_id);
        $obj_delivery_note = $this->DeliveryNoteModel->where('id','=',$order_id)->with(['order_details.product_details','order_details.order.cust_details'])->first();
         
        if($obj_delivery_note)
        {
            $arr_delivery_note=$obj_delivery_note->toArray();
        }
        $product = $arr_delivery_note['order_details']['product_details']??'';
        $customer = $arr_delivery_note['order_details']['order']['cust_details']??'';

        $arr_data['delivery_note_id']  = $arr_delivery_note['id']??'';
        $arr_data['order_id']          = $order_id;
        $arr_data['stock_id']          = $product['mix_code']??'';
        $arr_data['description']       = $product['description']??'';
        $arr_data['quantity']          = $product['min_quant']??'';
        $arr_data['price']             = $product['rate']??0;
        $arr_data['cust_first_name']   = $customer['first_name']??'';
        $arr_data['cust_last_name']    = $customer['last_name']??'';
        $arr_data['address']           = $customer['address']??'';
        $arr_data['city']              = $customer['city']??'';
        $arr_data['state']             = $customer['state']??'';
        $arr_data['postal_code']       = $customer['postal_code']??'';
        $arr_data['ref']               = $arr_delivery_note['delivery_no']??'';
        $arr_data['delivary_date']     =  date("d/m/Y", strtotime($arr_delivery_note['delivery_date']));

        $status = $this->SalesService->store($arr_data);
        if($status)
        {
            Session::flash('success','Sales details pushed successfully in ERP');
        }
        else
        {
            Session::flash('error','Error occure');
        }
        return redirect()->back();
    }
}

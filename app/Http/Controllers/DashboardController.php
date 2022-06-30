<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\Common\Services\EmailService;
use App\Http\Controllers\Controller;
use App\Models\User;
// use App\Models\ResetPassTokenModel;
use App\Models\OrderDetailsModel;
use App\Models\OrdersModel;
use App\Models\DeliveryNoteModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->UserModel             = new User;
        $this->OrderDetailsModel     = new OrderDetailsModel;
        $this->OrdersModel           = new OrdersModel;
        $this->DeliveryNoteModel     = new DeliveryNoteModel;
        // $this->ResetPassTokenModel  = new ResetPassTokenModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Dashboard";
        $this->module_view_folder   = "dashboard";
        $this->module_url_path      = url('/');
        // $this->EmailService         = new EmailService();
    }

    public function index(Request $request) 
    {
        $arr_customer=[];
        $date        = $statement_date= date('Y-m-d');
        if($request->has('date'))
        {
            $date = $request->input('date', date('Y-m-d'));
            $date = date('Y-m-d', strtotime($date));
        }
         if($request->has('statementRange') && $request->input('statementRange')) {
            $arr_range  = explode('-', $request->input('statementRange'));
            $booking_start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $booking_end_date   = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $booking_start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $booking_end_date   = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }
        $customer_id   = $request->input('customer_id','');
        $arr_delivery  = $this->get_delivery_orders($request,$date);
        $arr_statement = $this->get_booking_statement($request,$booking_start_date,$booking_end_date,$customer_id);
      
         if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

         if($request->has('salesdateRange') && $request->input('salesdateRange')) {
            $arr_range = explode('-', $request->input('salesdateRange'));
            $sales_start_date= Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $sales_end_date= Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $sales_start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $sales_end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }


        if($request->has('rejPumpDateRange') && $request->input('rejPumpDateRange')) {
            $arr_range = explode('-', $request->input('rejPumpDateRange'));
            $pump_start_date=Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $pump_end_date=Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $pump_start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $pump_end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        if($request->has('exccessDateRange') && $request->input('exccessDateRange')) {
            $arr_range = explode('-', $request->input('exccessDateRange'));
         $excess_start_date=Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
         $excess_end_date=Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
          $excess_start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
          $excess_end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
        }

        $arr_pump_data     = $this->get_pumps_data($start_date,$end_date);
        $arr_sales_data    = $this->get_sales_data($sales_start_date,$sales_end_date);
        $arr_rej_pump_data = $this->get_rej_pumps_data($pump_start_date,$pump_end_date);
        $total_excess      = $this->get_excess_data($excess_start_date,$excess_end_date);
        $booking_statement_str = $this->get_booking_chart_data($booking_start_date,$booking_end_date);
    
        //pump bar chart
        $pump_chart_str ='';
        $arr_pump_json = $arr_json_data=[];
        if(isset($arr_pump_data['arr_final_data']) && count($arr_pump_data['arr_final_data'])>0)
        {
            $arr_pump_json =array(['Name','Total Qty', 'Total Del Qty','Remaining Qty']);
            foreach($arr_pump_data['arr_final_data'] as $key=>$data)
            {
                $pump_name = "Pump ".$key;
                $arr_pump_json[] = array($pump_name,$data['total_qty'],$data['tot_delivered_quant'],$data['remain_qty']);
                $arr_json_data = $arr_pump_json;

            }
            $pump_chart_str = json_encode($arr_json_data);
        }

        //rejected pump bar chart
        $rej_pump_chart_str ='';
        $arr_rej_pump_json = $arr_rej_json_data =[];
        if(isset($arr_rej_pump_data['arr_cust_rej_pump_data']) && count($arr_rej_pump_data['arr_cust_rej_pump_data'])>0)
        {
            $arr_rej_json_data =array(['Name','Total Cust Rej Qty', 'Total Int Rej Qty']);
            foreach($arr_rej_pump_data['arr_cust_rej_pump_data'] as $rej=>$data)
            {
                $rej_pump_name = "Pump ".$rej;
                $arr_rej_json_data[] = array($rej_pump_name,$data['tot_cust_rejected_qty'],$data['tot_int_rejected_qty']);
                $arr_rej_json_data = $arr_rej_json_data;

            }
            $rej_pump_chart_str = json_encode($arr_rej_json_data);
        }
     
        $obj_customer = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->get();

        if($obj_customer->count() > 0) {
            $arr_customer = $obj_customer->toArray();
        }

        $this->arr_view_data['booking_statement_str']   = $booking_statement_str;
        $this->arr_view_data['rej_pump_chart_str']   = $rej_pump_chart_str;
        $this->arr_view_data['arr_customer']         = $arr_customer;
        $this->arr_view_data['arr_statement']        = $arr_statement;
        $this->arr_view_data['pump_chart_str']  = $pump_chart_str;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['arr_order_dtls']  = $arr_delivery;
        $this->arr_view_data['arr_pump_data']   = $arr_pump_data;
        $this->arr_view_data['arr_sales_data']  = $arr_sales_data;
        $this->arr_view_data['date']            = $date;
        $this->arr_view_data['start_date']      = $start_date;
        $this->arr_view_data['end_date']        = $end_date;
        $this->arr_view_data['sales_start_date']   = $sales_start_date;
        $this->arr_view_data['sales_end_date']     = $sales_end_date;
        $this->arr_view_data['pump_start_date']    = $pump_start_date;
        $this->arr_view_data['pump_end_date']      = $pump_end_date;
        $this->arr_view_data['arr_rej_pump_data']  = $arr_rej_pump_data;
        $this->arr_view_data['total_excess']       = $total_excess;
        $this->arr_view_data['excess_start_date']  = $excess_start_date;
        $this->arr_view_data['excess_end_date']    = $excess_end_date;
        $this->arr_view_data['booking_start_date'] = $booking_start_date;
        $this->arr_view_data['booking_end_date']   = $booking_end_date;
        //return view($this->module_view_folder.'.index',$this->arr_view_data);
        if($request->has('is_ajax'))
        {
             $view = view($this->module_view_folder.".dashboard_view",$this->arr_view_data)->render();
             return response()->json(['html'=>$view]);
        }
        else
        {
            return view($this->module_view_folder.'.index',$this->arr_view_data);
        }
    }
    public function get_delivery_orders($request,$date)
    {
        $arr_order_dtls = [];
        
        $obj_orders = $this->OrderDetailsModel->whereHas('order', function($q) use($date){
                                                    //$q->where('delivery_date', $date);
                                                    $q->where('delivery_date','<=', $date);
                                                    $q->where('extended_date','>=', $date);

                                                })
                                            ->whereHas('product_details', function(){})
                                            ->with(['order',
                                                    'del_notes.driver',
                                                    'del_notes.vehicle',
                                                    'order.invoice',
                                                    'order.cust_details',
                                                    'product_details',
                                                    'del_notes'=>function($qry)use($date){
                                                        //$qry->whereDate('delivery_date',$date);
                                                    }
                                                ])
                                            ->get();

        if($obj_orders->count() > 0) {
            $arr_order_dtls = $obj_orders->toArray();
        }
        return $arr_order_dtls;
    }
    public function get_booking_statement($request,$start_date,$end_date,$customer_id)
    {
        $arr_orders = $arr_json_data=$arr_statement_json_data=[];
         $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','invoice','cust_details','pump_details','transactions','sales_agent_details'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date);
        $obj_statement = $obj_orders;
        if($customer_id!="")
        {
             $obj_orders = $obj_orders->where('cust_id', $customer_id);
        }
        $obj_orders = $obj_orders->orderBy('id', 'ASC')->get();

      
        if($obj_orders->count() > 0) {
            $arr_orders = $obj_orders->toArray();
        }
        return $arr_orders;
    }
    public function get_booking_chart_data($start_date,$end_date)
    {
        $arr_json_data=$arr_statement_json_data=[];
        $bookingStatementQuery = "SELECT `orders`.`cust_id`,SUM(`orders`.`balance`) as balance,SUM(`orders`.`grand_tot`) as booking_amt,`users`.`first_name`,`users`.`last_name` FROM `orders`,`users` WHERE `orders`.`cust_id`=`users`.`id` AND `orders`.`delivery_date`>='".$start_date."' AND `orders`.`delivery_date`<='".$end_date."' GROUP BY `cust_id`";
        $obj_statement = DB::select(DB::raw($bookingStatementQuery));
        if($obj_statement)
        {
            $arr_statement  = json_decode(json_encode($obj_statement),true);
        }
        $statement_chart_str='';
        if(isset($arr_statement) && count($arr_statement)>0)
        {
            $arr_json_data =array(['Customer', 'Booking Amount', 'Balance']);
            foreach($arr_statement as $key=>$data)
            {
                $cust_name = $data['first_name']." ".$data['last_name'];

                $arr_json_data[]         = array($cust_name,$data['booking_amt'],$data['balance']);
                $arr_statement_json_data = $arr_json_data;

            }
            $statement_chart_str = json_encode($arr_statement_json_data);
        }
        return $statement_chart_str;
    } 
    public function get_pumps_data($start_date,$end_date,$is_ajax=0)
    {
        $glob_delivered_quant = $glob_remaing_qty=0;
        $glob_qty_total = $total_qty = $tot_remaing_qty=$tot_delivered_quant=$cancelled_qty=0;
        $arr_orders     = $arr_pump_data = $arr_order_dtls = $arr_pump_order=$arr_pump=[];
        //get pumps record
      
        //get total delivered & remaining pumps

         $obj_orders = $this->OrderDetailsModel->whereHas('order', function($q) use($start_date,$end_date){
                                                    $q->whereDate('delivery_date',">=",$start_date);
                                                    $q->whereDate('delivery_date',"<=",$end_date);

                                                })
                                            ->whereHas('product_details', function(){})
                                            ->with(['order',
                                                    'del_notes.driver',
                                                    'del_notes.vehicle',
                                                    'order.invoice',
                                                    'order.cust_details',
                                                    'product_details',
                                                   
                                                ])
                                            ->get();

        if($obj_orders->count() > 0) {
            $arr_order_dtls = $obj_orders->toArray();
        }
        
        $arr_title =array(['Pump Name','Total Qty','Total Del Qty','Remaining Qty']);
        $tot_int_rejected_qty =$delivered_quant= $tot_delivered_quant= $tot_cust_rejected_qty=0;

        if(isset($arr_order_dtls) && !empty($arr_order_dtls))
        {
            foreach ($arr_order_dtls as $key => $row) 
            {
                $order = $row['order']??[];
                $enc_id = base64_encode($order['id']);
                $tax_amnt = $remain_qty = $total_qty = 0;

                $invoice = $order['invoice'] ?? [];
                $product = $row['product_details'] ?? [];
                $del_notes = $row['del_notes'] ?? [];

                $tot_delivered_quant = $tot_int_rejected_qty = $tot_cust_rejected_qty = $cancelled_qty = $delivered_quant = 0;
                foreach ($del_notes as $del_key => $del_val) 
                {
                    if($del_val['reject_by']!='' && $del_val['reject_by'] == '1')
                    {
                        $tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
                    }
                    elseif($del_val['reject_by']!='' && $del_val['reject_by'] == '2')
                    {
                        $tot_cust_rejected_qty += $del_val['reject_qty'] ?? 0;
                        $tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
                    }

                    if($del_val['status'] == 'cancelled'){
                        $cancelled_qty += $del_val['quantity'] ?? 0;
                    }

                    if($del_val['status'] != 'cancelled'){
                        $delivered_quant += $del_val['quantity'] ?? 0;
                    }
                }
                $tot_delivered_quant = $delivered_quant - $tot_int_rejected_qty;

                $remain_qty = $row['quantity'] - $tot_delivered_quant - $cancelled_qty;

                if($row['edit_quantity']!='')
                {
                    $remain_qty = $row['edit_quantity'] - $tot_delivered_quant - $cancelled_qty;
                }

                if(isset($row['edit_quantity']) && $row['edit_quantity']!=''){
                    $total_qty = ($row['edit_quantity'] ?? 0) - $cancelled_qty;
                }
                else{
                    $total_qty = ($row['quantity'] ?? 0) - $cancelled_qty;
                }
                $remain_qty = abs($remain_qty);
                $glob_delivered_quant = $glob_delivered_quant+$tot_delivered_quant;
                $glob_remaing_qty     = $glob_remaing_qty+$remain_qty;
                $glob_qty_total       = $glob_qty_total+$total_qty;
                $arr_pump_order[$key]['pump']                 = $order['pump']??'';
                $arr_pump_order[$key]['total_qty']            = $total_qty??'';
                $arr_pump_order[$key]['tot_delivered_quant']  = $tot_delivered_quant??'';
                $arr_pump_order[$key]['remain_qty']           = $remain_qty;
            }
        }
        
        $arr_final_data = [];
        $total_qty = $tot_delivered_quant=$tot_remaing_qty=0;

        if(isset($arr_pump_order) && count($arr_pump_order)>0)
        {
            foreach ($arr_pump_order as $key => $value) 
            {
                $pump = $value['pump'];

              //echo "<pre>"; print_r($arr_final_data);
                if(isset($arr_final_data[$pump]) && $arr_final_data[$pump]!="")
                {

                    $total_qty =$arr_final_data[$pump]['total_qty']+$value['total_qty'];
                    $tot_delivered_quant =$arr_final_data[$pump]['tot_delivered_quant']+$value['tot_delivered_quant'];
                    $tot_remaing_qty =$arr_final_data[$pump]['remain_qty']+$value['remain_qty'];

                    $arr_final_data[$pump]['total_qty']          = $total_qty;
                    $arr_final_data[$pump]['tot_delivered_quant']= $tot_delivered_quant;
                    $arr_final_data[$pump]['remain_qty'] =  $tot_remaing_qty;
                  
                }
                else
                {
                    $arr_final_data[$pump] = $value;
               
                }
                
            }
        }
       
        $arr_pump_data['tot_delivered_qty']     = $glob_delivered_quant;
        $arr_pump_data['tot_remaing_qty']       = $glob_remaing_qty;
        $arr_pump_data['total_orders']          = $glob_qty_total;
        $arr_pump_data['arr_final_data']        = $arr_final_data;
     

        return $arr_pump_data;

    }
    public function get_sales_data($start_date,$end_date)
    {
        $arr_sales_data = [];
        $tax_amnt = $tot_qty = $cr_amnt = $qty_sum=$bk_amnt_sum=$bal_sum=$advance_sum=0;
         $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','invoice','cust_details','pump_details','transactions','sales_agent_details'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date);
         $obj_orders = $obj_orders->orderBy('id', 'ASC')->get();
        if($obj_orders->count() > 0) {
            $arr_orders = $obj_orders->toArray();
        }

        if(isset($arr_orders) && !empty($arr_orders))
        {
            foreach($arr_orders as $sr => $order)
            {
                $invoice = $order['invoice'] ?? [];
                foreach($order['ord_details'] as $row) {
                    $tot_price = $row['quantity']*$row['rate'];
                    $tax_rate = $row['tax_rate'];
                    $tax_amnt += ( $tax_rate / 100 ) * $tot_price;
                    $tot_qty += $row['quantity'] ?? 0;
                }

                $qty_sum += $tot_qty;
                $tot_sal_amnt = ($invoice['net_total']+$tax_amnt);
                $bk_amnt_sum += $tot_sal_amnt;
                $bal_sum += $order['balance'] ?? 0;
                $advance_sum += $order['advance_payment'] ?? 0;

            }

        }
        $arr_sales_data['total_sales'] = $qty_sum??0;
        $arr_sales_data['invoice_amount'] = $bk_amnt_sum??0;
        $arr_sales_data['need_to_collect'] = abs($bal_sum)??0;

        return $arr_sales_data;
    }
    public function get_rej_pumps_data($start_date,$end_date)
    {
         
         $arr_pump_data = $arr_delivery_data=$arr_rej_order=$arr_rej_pump_data=[];
         $obj_orders    = $this->DeliveryNoteModel->whereDate('delivery_date','>=', $start_date)
                                                  ->whereDate('delivery_date','<=', $end_date)
                                                  ->get();

        if($obj_orders->count() > 0) {
            $arr_delivery_data = $obj_orders->toArray();
        }
        $glob_int_rejected_qty = $glob_cust_rejected_qty=0;
        if(isset($arr_delivery_data) && !empty($arr_delivery_data))
        {
            foreach($arr_delivery_data as $key => $row) 
            {
                $tot_cust_rejected_qty=$tot_int_rejected_qty=0;
                if($row['reject_by']!='' && $row['reject_by'] == '1')
                {
                    $tot_int_rejected_qty = $row['reject_qty'] ?? 0;
                }
                elseif($row['reject_by']!='' && $row['reject_by'] == '2')
                {
                    $tot_cust_rejected_qty = $row['reject_qty'] ?? 0;
                    $tot_int_rejected_qty  = $row['reject_qty'] ?? 0;
                }
                if($tot_cust_rejected_qty>0 || $tot_int_rejected_qty>0)
                {
                    $arr_rej_order[$key]['pump']                  = $row['pump']??'';
                    $arr_rej_order[$key]['tot_int_rejected_qty']  = $tot_int_rejected_qty??'';
                    $arr_rej_order[$key]['tot_cust_rejected_qty'] = $tot_cust_rejected_qty??'';
                    

                }
        
            }
        }
        $glob_cust_rejected_qty = array_sum(array_column($arr_rej_order,'tot_cust_rejected_qty'));
        $glob_int_rejected_qty  = array_sum(array_column($arr_rej_order,'tot_int_rejected_qty'));

         $tot_int_rejected_qty = $tot_cust_rejected_qty=0;
        if(isset($arr_rej_order) && count($arr_rej_order)>0)
        {
            foreach ($arr_rej_order as $key => $value) 
            {
                $pump = $value['pump'];
                if(isset($arr_rej_pump_data[$pump]) && $arr_rej_pump_data[$pump]!="")
                {

                    $tot_int_rejected_qty =$arr_rej_pump_data[$pump]['tot_int_rejected_qty']+$value['tot_int_rejected_qty'];
                    $tot_cust_rejected_qty =$arr_rej_pump_data[$pump]['tot_cust_rejected_qty']+$value['tot_cust_rejected_qty'];
                   
                    $arr_rej_pump_data[$pump]['tot_int_rejected_qty'] = $tot_int_rejected_qty;
                    $arr_rej_pump_data[$pump]['tot_cust_rejected_qty']= $tot_cust_rejected_qty;
                    
                }
                else
                {
                    $arr_rej_pump_data[$pump] = $value;
                }
                
            }
        }

        $arr_pump_data['glob_int_rejected_qty']   = $glob_int_rejected_qty;
        $arr_pump_data['glob_cust_rejected_qty']   = $glob_cust_rejected_qty;
        $arr_pump_data['arr_cust_rej_pump_data']        = $arr_rej_pump_data;
       
        return $arr_pump_data;

    }
    public function get_excess_data($start_date,$end_date)
    {
        $total_excess    = $this->DeliveryNoteModel->whereDate('delivery_date','>=',$start_date)
                                                  ->whereDate('delivery_date','<=',$end_date)
                                                  ->sum('excess_qty');
                                              
        return $total_excess;
    }

}

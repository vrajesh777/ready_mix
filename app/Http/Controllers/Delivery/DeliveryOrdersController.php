<?php
namespace App\Http\Controllers\Delivery;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\TranscationService;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\ProductModel;
use App\Models\SalesEstimateModel;
use App\Models\TaxesModel;
use App\Models\PaymentMethodsModel;
use App\Models\SalesEstimateProdQuantModel;
use App\Models\InvoicePayMethodsModel;
use App\Models\SalesProposalModel;
use App\Models\SalesProposalDetailsModel;
use App\Models\SalesInvoiceModel;
use App\Models\SalesInvoiceDetailsModel;
use App\Models\OrdersModel;
use App\Models\OrderDetailsModel;
use App\Models\DeliveryNoteModel;
use App\Models\VehicleModel;
use App\Models\PumpModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;
use \Mpdf\Mpdf as Mpdf;
use Carbon\Carbon;
use Illuminate\Routing\RouteUri;
use Illuminate\Support\Facades\Redirect;

class DeliveryOrdersController extends Controller
{
    public function __construct()
    {
        $this->UserModel                   = new User;
        $this->LeadsModel                  = new LeadsModel;
        $this->ProductModel                = new ProductModel;
        $this->SalesEstimateModel          = new SalesEstimateModel;
        $this->PaymentMethodsModel         = new PaymentMethodsModel;
        $this->SalesEstimateProdQuantModel = new SalesEstimateProdQuantModel;
        $this->InvoicePayMethodsModel      = new InvoicePayMethodsModel;
        $this->SalesProposalModel          = new SalesProposalModel;
        $this->SalesProposalDetailsModel   = new SalesProposalDetailsModel;
        $this->SalesInvoiceModel           = new SalesInvoiceModel;
        $this->SalesInvoiceDetailsModel    = new SalesInvoiceDetailsModel;
        $this->TaxesModel                  = new TaxesModel;
        $this->OrdersModel                 = new OrdersModel;
        $this->OrderDetailsModel           = new OrderDetailsModel;
        $this->VehicleModel                = new VehicleModel;
        $this->DeliveryNoteModel           = new DeliveryNoteModel;
        $this->PumpModel                   = new PumpModel;
        $this->auth                        = auth();
        $this->arr_view_data               = [];
        $this->module_title                = trans('admin.delivery_orders');
        $this->module_view_folder          = "delivery.delivery_orders";
        $this->TranscationService              = new TranscationService();
    }

    public function index(Request $request) {

        $arr_order_dtls = $arr_sales_user = [];
        $show_all = 0;
        $date = date('Y-m-d');
        if($request->has('date'))
        {
            $date = $request->input('date', date('Y-m-d'));
            $date = date('Y-m-d', strtotime($date));
        }

        if($request->has('show_all'))
        {
            $show_all = $request->input('show_all');
        }
        
        $obj_orders = $this->OrderDetailsModel->whereHas('order', function($q) use($date){
                                                    //$q->where('delivery_date', $date);
                                                    $q->where('delivery_date','<=', $date);
                                                    $q->where('extended_date','>=', $date);
                                                    $q->where('order_status','!=','cancelled');
                                                    $q->orderBy('orders.id', 'DESC');
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


        $this->arr_view_data['arr_order_dtls']  = $arr_order_dtls;
        $this->arr_view_data['date']            = $date;
        $this->arr_view_data['show_all']        = $show_all;
        $this->arr_view_data['page_title']      = $this->module_title;
        // dd($arr_order_dtls);
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function store_order(Request $request) {

        $arr_rules                  = $arr_resp = array();
        $arr_rules['cust_id']       = "required";
        $arr_rules['invoice_date']  = "required";
        $arr_rules['delivery_date'] = "required";
        $arr_rules['prod_id']       = 'required|array|min:1';
        $arr_rules['prod_id.*']     = 'required|integer';

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            if($validator->errors()->has('prod_id')) {
                Session::flash('error',trans('admin.select_at_least_one_product'));
            }
            // dd($validator->errors()->has('prod_id'), $validator->messages()->toArray());
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        else
        {
            $calc_resp = $this->calculate_inv_amnt($request);

            $calc = json_decode($calc_resp->content(), true);

            $arr_ins = [];

            $arr_ins['cust_id']             = $request->input('cust_id');
            $arr_ins['delivery_date']       = $request->input('delivery_date');
            $arr_ins['sales_agent']         = $request->input('sales_agent');
            $arr_ins['status']              = $request->input('status');
            $arr_ins['admin_note']          = $request->input('admin_note');
            $arr_ins['client_note']         = $request->input('client_note');
            $arr_ins['terms_conditions']    = $request->input('terms_n_cond');
            $arr_ins['order_status']        = $request->input('status');

            if($request->has('estimation_id'))
            {
                $arr_ins['estimation_id'] = $request->input('estimation_id');
            }

            if($obj_order = $this->OrdersModel->create($arr_ins)) {

                $obj_order->order_no = format_order_number($obj_order->id);
                $obj_order->save();

                $arr_req = $request->all();

                $arr_taxes = [];

                $arr_tax_id = $request->input('unit_tax');
                $arr_tax_id = array_unique($arr_tax_id);
                $obj_taxes = $this->TaxesModel->whereIn('id', $arr_tax_id)->get();

                if($obj_taxes->count() > 0) { $arr_taxes = $obj_taxes->toArray(); }

                $arr_ins = [];
                foreach($arr_req['prod_id'] as $key => $row) {

                    $tax_det = [];

                    $tax_id = $arr_req['unit_tax'][$key] ?? '';

                    foreach($arr_taxes as $tax) {
                        if($tax_id == $tax['id']) {
                            $tax_det = $tax;
                        }
                    }

                    $arr_ins[$key]['order_id']      = $obj_order->id;
                    $arr_ins[$key]['product_id']    = $row;
                    $arr_ins[$key]['quantity']      = $arr_req['unit_quantity'][$key] ?? 1;
                    $arr_ins[$key]['rate']          = $arr_req['unit_rate'][$key] ?? 1;
                    $arr_ins[$key]['tax_id']        = $tax_id;
                    $arr_ins[$key]['tax_rate']      = $tax_det['tax_rate']??0;
                }

                $flag = $this->OrderDetailsModel->insert($arr_ins);

                $arr_ins_inv['order_id']            = $obj_order->id;
                $arr_ins_inv['invoice_number']      = 'INV-DRAFT';
                $arr_ins_inv['invoice_date']        = $request->input('invoice_date');
                $arr_ins_inv['due_date']            = $request->input('due_date');
                $arr_ins_inv['net_total']           = $calc['sub_tot'] ?? 0;
                $arr_ins_inv['discount']            = $request->input('discount_num');
                $arr_ins_inv['discount_type']       = $request->input('disc_type');
                $arr_ins_inv['grand_tot']           = $calc['grand_tot'] ?? 0;
                $arr_ins_inv['billing_street']      = $request->input('billing_street');
                $arr_ins_inv['billing_city']        = $request->input('billing_city');
                $arr_ins_inv['billing_state']       = $request->input('billing_state');
                $arr_ins_inv['billing_zip']         = $request->input('billing_zip');
                $arr_ins_inv['billing_country']     = 1;
                $arr_ins_inv['include_shipping']    = $request->input('include_shipping','0');
                $arr_ins_inv['shipping_street']     = $request->input('shipping_street');
                $arr_ins_inv['shipping_city']       = $request->input('shipping_city');
                $arr_ins_inv['shipping_state']      = $request->input('shipping_state');
                $arr_ins_inv['shipping_zip']        = $request->input('shipping_zip');
                $arr_ins_inv['shipping_country']    = 1;

                $obj_inv = $this->SalesInvoiceModel->create($arr_ins_inv);

                if(isset($arr_req['pay_modes']) && !empty($arr_req['pay_modes'])) {

                    foreach($arr_req['pay_modes'] as $index => $row) {
                        $arr_pay_ins[$index]['invoice_id'] = $obj_inv->id;
                        $arr_pay_ins[$index]['pay_method_id'] = $row;
                    }

                    $pay_flag = $this->InvoicePayMethodsModel->insert($arr_pay_ins);
                }

                Session::flash('success',trans('admin.invoice_create_success'));
            }else{
                Session::flash('error',trans('admin.invoice_create_error'));
            }
        }

        return redirect()->route('orders');
    }

    public function del_note_det($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $arr_vehicles = $arr_data = $arr_drivers = [];

        $obj_del_det = $this->OrderDetailsModel->whereHas('order', function(){})
                                            ->whereHas('product_details', function(){})
                                            ->with(['order',
                                                    'del_notes',
                                                    'order.invoice',
                                                    'order.cust_details',
                                                    'order.contract',
                                                    'product_details',
                                                    'product_details.attr_values',
                                                    'product_details.attr_values.attribute',
                                                ])
                                            ->where('id', $id)
                                            ->first();

        if($obj_del_det) {

            $arr_data = $obj_del_det->toArray();

            $obj_vehicles = $this->VehicleModel->with(['driver_details'])->get();

            if($obj_vehicles->count() > 0) {
                $arr_vehicles = $obj_vehicles->toArray();
            }

            $obj_drivers = $this->UserModel->where('role_id', config('app.roles_id.driver'))
                            ->whereNotIn('id',NOT_A_MIXER_DRIVER)
                            ->get();

            if($obj_drivers->count() > 0) {
                $arr_drivers = $obj_drivers->toArray();
            }

            // helper 
            $arr_helper = $arr_operator = [];
            $obj_helper = $this->UserModel->where('role_id', config('app.roles_id.pump_helper'))
                                        ->select('id','first_name','last_name')
                                        ->get();

            if($obj_helper->count() > 0) {
                $arr_helper = $obj_helper->toArray();
            }
            //operator
            $obj_opertaor = $this->UserModel->where('role_id', config('app.roles_id.pump_operator'))
                                        ->select('id','first_name','last_name')
                                        ->get();

            if($obj_opertaor->count() > 0) {
                $arr_operator = $obj_opertaor->toArray();
            }
            
            $this->arr_view_data['arr_drivers'] = $arr_drivers;
            $this->arr_view_data['date'] = date('Y-m-d');
            $this->arr_view_data['arr_data'] = $arr_data;
            $this->arr_view_data['arr_vehicles'] = $arr_vehicles;
            $this->arr_view_data['arr_helper']      = $arr_helper;
            $this->arr_view_data['arr_operator']    = $arr_operator;
            
            $arr_resp['status'] = 'success';

            // return view($this->module_view_folder.'.delivery_note',$this->arr_view_data);

            $arr_resp['html'] = view($this->module_view_folder.'.delivery_note',$this->arr_view_data)->render();
        }else{
            $arr_resp['status'] = 'error';
        }
        return response()->json($arr_resp, 200);

    }

    public function store_del_note($enc_id, Request $request) {
        $input = $request->input();
        $arr_resp = [];
        if($input){
        $id = base64_decode($enc_id);
        $obj_del_det = $this->OrderDetailsModel->where('id', $id)->first();

        if(!$obj_del_det) {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }
        $delivered_qty = $obj_del_det->quantity_delivered;
        $arr_driver_session = [];
        $arr_driver_session['driver_id'] = $input['driver'];
        $arr_driver_session['delivery_date'] = $input['del_date'];
        $arr_driver_session['vehicle_id'] = $input['vehicle'];

        Session::put('curr_driver_del_details',$arr_driver_session);

        $arr_ins['order_detail_id'] = $id;
        $arr_ins['vehicle_id']      = $input['vehicle'];
        $arr_ins['driver_id']       = $input['driver'];
        $arr_ins['quantity']        = $input['loaded_quant'];
        $arr_ins['pump']            = $input['pump'];
        $arr_ins['delivery_date']   = $input['del_date'];
        $arr_ins['load_no']         = $input['load_num'];
        $arr_ins['gate']            = $input['gate'];
        $arr_ins['operator_id']     = $input['pump_op_id'];
        $arr_ins['helper_id']       = $input['pump_helper_id'];

        $pump_op_id        =    $input['pump_op_id'];
        $pump_helper_id    =    $input['pump_helper_id'];

        $status = $this->DeliveryNoteModel->create($arr_ins);

        if($status) {

            $order_estimate_id = $status->id;
            $delivery_no = format_purchase_delivery_no($order_estimate_id);
            $status->delivery_no = $delivery_no;
            $status->save();

            $obj_data = $this->OrdersModel->where('id',$obj_del_det['order_id'])->first();
            if($obj_data){
                $obj_data->update(['pump_op_id'=>$pump_op_id,'pump_helper_id'=>$pump_helper_id]);
                $obj_data->save();
            }
            //calculate and update total delivered qty
            $total_delivered_qty = $delivered_qty+ $arr_ins['quantity']??0;

            $this->OrderDetailsModel->where('id', $id)->update(['quantity_delivered'=>$total_delivered_qty]);
            $arr_resp['status'] = 'success';
            $arr_resp['message'] = "Delivery note added successfully";
            $arr_resp['id'] = base64_encode($order_estimate_id);
            $arr_resp['pdfUrl'] = route('dowload_del_note',$arr_resp['id']);
        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.dlv_note_error');
        }
    } else {
        $arr_resp['status'] = 'error';
        $arr_resp['message'] = trans('admin.dlv_note_error');
    }

        return response()->json($arr_resp, 200);
    }

    public function dowload_del_note($enc_id)
    {
        $id = base64_decode($enc_id);

        $obj_del_note = $this->DeliveryNoteModel->with(['driver'=>function($qry){
                                                $qry->select('id','first_name','last_name');
                                            },'vehicle'=>function($qry){
                                                $qry->select('id','driver_id','plate_no','plate_letter','name');
                                            }, 'order_details.product_details.attr_values.attribute','order_details.order.cust_details.user_meta','order_details.order.contract'])
                                            ->where('id',$id)->first();

        if(!$obj_del_note) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_del_note = $obj_del_note->toArray();
            $this->arr_view_data['arr_del_note'] = $arr_del_note;

            $view = view($this->module_view_folder.'.delivery_note_pdf',$this->arr_view_data);
            //return $view;
            $html = $view->render();

            $img_file = asset('/images/image--000.png');
            // PDF::SetTitle($arr_del_note['delivery_no']);
            // PDF::AddPage();
            // PDF::SetAlpha(0.08);
            // PDF::Image($img_file, 35, 70, 140, 140, '', '', '', false, 300, '', false, false, 0);
            // PDF::SetAlpha(1);
            // PDF::setPageMark();
            // PDF::writeHTML($html, true, false, true, false, '');
            // $js = <<<EOD
            // // if(window){
            // //     window.focus();
            // //     window.print();
            // //     window.close();
            // // } else app(app){
            // //     app.focus();
            // //     app.print();
            // //     app.close();
            // // }
            // EOD;
            // $js = 'print(true);';
            // // set javascript
            // PDF::IncludeJS($js);
            // PDF::Output($arr_del_note['delivery_no'].'.pdf','I');

      ////========///mpdf=====///
      //Generate pdf

      
    //   $body = view('sale_pos.receipts.'.$blade_file)
    //   ->with(compact('receipt_details', 'location_details', 'is_email_attachment'))
    //   ->render();
                // dd('hi');
        $mpdf = new Mpdf(['tempDir' => public_path('uploads/temp'), 
            'mode' => 'utf-8', 
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'autoVietnamese' => true,
            'autoArabic' => true,
            'showWatermarkImage' =>true,
            // 'margin_top' => 8,
            // 'margin_bottom' => 8,
            // 'format' => 'A4'
        ]);

        $mpdf->useSubstitutions=true;
        $mpdf->SetWatermarkImage($img_file, 0.1,
        '',
        array(5,100));
        $mpdf->showWatermarkText = true;
        $mpdf->SetTitle($arr_del_note['delivery_no']);
        $mpdf->WriteHTML($html);
        $mpdf->Output($arr_del_note['delivery_no'].'.pdf','I');
        }
    }

    public function edit_del_qty(Request $request)
    {
        $arr_rules                 = [];
        $arr_rules['enc_order_id'] = 'required';
        $arr_rules['quantity']     = 'required';

        $validator = Validator::make($request->All(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = base64_decode($request->input('enc_order_id'));
        $quantity = $request->input('quantity');

        $status = $this->OrderDetailsModel->where('id',$id)
                                          ->update(['edit_quantity'=>$quantity]);
        if($status)
        {
            Session::flash('success',trans('admin.qty_update_success'));
        }
        else
        {
            Session::flash('error',trans('admin.qty_update_error'));
        }

        return redirect()->back();
    }

    public function reject_del_qty(Request $request)
    {
        $arr_rules                = [];
        $arr_rules['enc_note_id'] = 'required';
        $arr_rules['reject_qty']  = 'required';
        $arr_rules['reject_by']   = 'required';

        $validator = Validator::make($request->All(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error',trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = base64_decode($request->input('enc_note_id'));

        $obj_note = $this->DeliveryNoteModel->with(['order_details.order'])->where('id',$id)->first();

        if($request->input('reject_by') == '3')
        {
            $extra_qty = $load_qty = $reject_qty = 0;
            $arr_update['excess_qty'] = $request->input('reject_qty');
            $arr_update['extra_qty'] = $request->input('load_qty');
        }
        else
        {
            $arr_update['reject_qty'] = $request->input('reject_qty');
        }
        
        $arr_update['reject_by']  = $request->input('reject_by');
        $arr_update['remark']     = $request->input('remark');
        
        $arr_update['is_transfer']    = $request->input('is_transfer');

        if($request->has('transfer_to') && $request->input('transfer_to')!=''){
            $arr_update['transfer_to']    = $request->input('transfer_to');
        }

        if($request->has('to_customer_id') && $request->input('to_customer_id')!=''){
            $arr_update['to_customer_id'] = $request->input('to_customer_id');   
            $arr_update['from_customer_id'] = $obj_note->order_details->order->cust_id ?? 0;
        }

        /*-------After transfer to same customer again new entry same data*/
        if($request->has('transfer_to') && $request->input('transfer_to')!='' && $request->input('transfer_to')=='2'){
            $obj_del_note = $this->DeliveryNoteModel->where('id',$id)->first();
            $obj_del_note_old = $obj_del_note;
            if($obj_del_note)
            {
                $arr_del_note = $obj_del_note->toArray();
                $arr_del_note['quantity'] = $request->input('reject_qty') ?? 0; 
                unset($arr_del_note['created_at']);
                unset($arr_del_note['updated_at']);
                $new_del = $this->DeliveryNoteModel->create($arr_del_note);
                if($new_del){
                    $new_del_id = $new_del->id ?? 0;
                    $delivery_no = format_purchase_delivery_no($new_del_id);
                    $new_del->delivery_no = $delivery_no;
                    $new_del->save();
                }  
                $obj_del_note_old->update(['status'=>'cancelled']);
            }
        }
        elseif($request->has('transfer_to') && $request->input('transfer_to')!='' && $request->input('transfer_to')=='1')
        {
            $to_customer_id = $request->input('to_customer_id');
            $ord_details_id = $request->input('ord_details_id');

            $obj_del_note = $this->DeliveryNoteModel->where('id',$id)->first();
            if($obj_del_note)
            {
                $arr_del_note = $obj_del_note->toArray();
                $arr_del_note['order_detail_id'] = $ord_details_id ?? 0;
                $arr_del_note['quantity'] = $request->input('reject_qty') ?? 0;

                if($request->has('load_qty') && $request->has('load_qty')!=''){
                    $load_qty = $request->input('load_qty') ?? 0;
                    $reject_qty = $request->input('reject_qty') ?? 0;
                    $arr_del_note['quantity'] =  ($load_qty + $reject_qty)  ?? 0;
                }

                unset($arr_del_note['created_at']);
                unset($arr_del_note['updated_at']);
                $new_del = $this->DeliveryNoteModel->create($arr_del_note);
                if($new_del){
                    $new_del_id = $new_del->id ?? 0;
                    $delivery_no = format_purchase_delivery_no($new_del_id);
                    $new_del->delivery_no = $delivery_no;
                    $new_del->save();
                }  
                
                $arr_update['to_delivery_id'] = $new_del->id ?? 0;
            }
        }


        $status = $this->DeliveryNoteModel->where('id',$id)->update($arr_update);
        if($status)
        {
            Session::flash('success',trans('admin.qty_update_success'));
        }
        else
        {
            Session::flash('error',trans('admin.qty_update_error'));
        }

        return redirect()->back();
    }


    public function get_same_product_customer($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_deatils = $this->DeliveryNoteModel->with(['order_details.order'])->where('id',$id)->first();
        if($obj_deatils)
        {
            $arr_details = $obj_deatils->toArray();
        }

        $delivery_date    = $arr_details['delivery_date'] ?? 0;
        $product_id       = $arr_details['order_details']['product_id'] ?? 0;
        $curr_customer_id = $arr_details['order_details']['order']['cust_id'] ?? 0;

        $arr_cust = $arr_order = [];

        $obj_order = $this->OrdersModel->whereHas('ord_details',function($qry)use($product_id){
                                            //$qry->where('product_id',$product_id);
                                        })
                                       ->whereDate('extended_date',$delivery_date)
                                       ->with(['cust_details'=>function($qry1){
                                            $qry1->select('id','first_name','last_name');
                                        },'ord_details.product_details','contract'])
                                       ->select('id','cust_id','contract_id')
                                       ->where('cust_id','<>',$curr_customer_id)
                                       ->get();
        if($obj_order)
        {
            $arr_order = $obj_order->toArray();
            //dd($arr_order);
            foreach ($arr_order as $key => $value) {
                $arr_cust[$key]['id'] = $value['cust_id'] ?? 0;
                $arr_cust[$key]['first_name'] = $value['cust_details']['first_name'] ?? 0;
                $arr_cust[$key]['last_name'] = $value['cust_details']['last_name'] ?? 0;
                $arr_cust[$key]['ord_details_id'] = $value['ord_details'][0]['id'] ?? 0;
                $arr_cust[$key]['product_name'] = $value['ord_details'][0]['product_details']['name'] ?? '';
                $arr_cust[$key]['location'] = $value['contract']['title'] ?? 0;
            }

            $arr_resp['status'] = 'success';
            $arr_resp['message'] = trans('admin.data_found');
            $arr_resp['arr_cust'] = $arr_cust;

        }
        else
        {
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.data_not_found');
        }

        return response()->json($arr_resp,200);
    }

    public function cancel_note($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->DeliveryNoteModel->where('id',$id)->first();
        if($obj_data){
            $obj_data->update(['status'=>'cancelled']);
            $obj_data->save();
            
            Session::flash('success',trans('admin.dlv_cancel_success'));
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
        }

        return redirect()->back();
    }
    
}

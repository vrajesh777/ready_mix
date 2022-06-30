<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseOrderModel;
use App\Models\PurchaseOrderDetailModel;
use App\Models\User;
use App\Models\ItemModel;
use App\Models\PurchaseUnitsModel;
use App\Models\TaxesModel;
use App\Models\PaymentMethodsModel;
use App\Models\VendorPaymentModel;
use App\Models\PurchaseEstimateModel;
use App\Models\SiteSettingModel;
use App\Models\PurchaseEstimateDetailsModel;

use Validator;
use Session;
use PDF;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->PurchaseOrderModel           = new PurchaseOrderModel();
        $this->PurchaseOrderDetailModel     = new PurchaseOrderDetailModel();
        $this->PaymentMethodsModel          = new PaymentMethodsModel();
        $this->User                         = new User();
        $this->ItemModel                    = new ItemModel();
        $this->PurchaseUnitsModel           = new PurchaseUnitsModel();
        $this->TaxesModel                   = new TaxesModel();
        $this->VendorPaymentModel           = new VendorPaymentModel();
        $this->PurchaseEstimateModel        = new PurchaseEstimateModel();
        $this->SiteSettingModel             = new SiteSettingModel();
        $this->PurchaseEstimateDetailsModel = new PurchaseEstimateDetailsModel();

    	$this->arr_view_data      = [];
    	$this->module_title       = trans('admin.purchase_orders');
    	$this->module_view_folder = "purchase.purchase_order";
    	$this->module_url_path    = url('/purchase_order');
    }

    public function index()
    {
    	$arr_data = [];

        $workflow = $this->get_purchase_workflow();
        
    	$obj_data = $this->PurchaseOrderModel->with(['user_meta'=>function($qry){
                                $qry->where('meta_key','company');
                                $qry->select('user_id','meta_value');
                            },'vendor_payment']);

        if($workflow == '1'){
            $obj_data = $obj_data->whereNotNull('estimate_id');
        }
        else{
            $obj_data = $obj_data->whereNull('estimate_id');
        }

        $obj_data = $obj_data->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }

        $this->arr_view_data['arr_data']            = $arr_data;

        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function create()
    {
    	$arr_vendor = $arr_pur_request = $arr_items = $arr_units = $arr_taxes = $arr_estimate = [];
    	$obj_vendor = User::where('is_active','1')
    						->where('role_id',config('app.roles_id.vendor'))
    						->whereHas('user_meta',function($qry){
    							$qry->where('meta_key','company');
    						})
    						->with(['user_meta'=>function($qry){
    							$qry->where('meta_key','company');
    							$qry->select('user_id','meta_value');
    						}])
    						->select('id')
			 				->get();
		if($obj_vendor)
		{
			$arr_vendor = $obj_vendor->toArray();
		}

        $obj_items = $this->ItemModel->get();
        if($obj_items->count() > 0) {
            $arr_items = $obj_items->toArray();
        }

        $obj_units = $this->PurchaseUnitsModel->get();
        if($obj_units) {
            $arr_units = $obj_units->toArray();
        }

        $obj_taxes = $this->TaxesModel->get();
        if($obj_taxes) {
            $arr_taxes = $obj_taxes->toArray();
        }

        $obj_estimate = $this->PurchaseEstimateModel->whereDoesntHave('purchase_order_detail')->where('status','2')->get();
        if($obj_estimate)
        {
            $arr_estimate = $obj_estimate->toArray();
        }
        //dd($arr_estimate);

        $this->arr_view_data['arr_items']       = $arr_items;
        $this->arr_view_data['arr_units']       = $arr_units;
        $this->arr_view_data['arr_taxes']       = $arr_taxes;
        $this->arr_view_data['arr_vendor']      = $arr_vendor;
        $this->arr_view_data['arr_estimate']    = $arr_estimate;

        $this->arr_view_data['module_title']        = $this->module_title;
        $this->arr_view_data['page_title']          = $this->module_title;
        $this->arr_view_data['module_url_path']     = $this->module_url_path;

    	return view($this->module_view_folder.'.create',$this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = [];

        $arr_rules['vendor_id']             = 'required';
        $arr_rules['order_date']            = 'required';
        $arr_rules['purchase_order_detail'] = 'required';

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error',trans('admin.validation_error_msg'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $purchase_order_detail = $request->input('purchase_order_detail');
        $arr_pur_order_details = array_filter(json_decode($purchase_order_detail, true));

        foreach($arr_pur_order_details as $key => $row) {
            if(empty(array_filter($row))) {
                unset($arr_pur_order_details[$key]);
            }
        }

        $user = \Auth::user();

        $arr_insert['name']             = trim($request->input('name'));
        $arr_insert['vendor_id']        = trim($request->input('vendor_id'));
        $arr_insert['order_date']       = trim($request->input('order_date'));
        $arr_insert['no_of_days_owned'] = trim($request->input('no_of_days_owned'));
        $arr_insert['delivery_Date']    = trim($request->input('delivery_Date'));
        $arr_insert['vendor_note']      = trim($request->input('vendor_note'));
        $arr_insert['terms_conditions'] = trim($request->input('terms_conditions'));
        $arr_insert['user_id']          = $user->id;

        if($request->input('estimate_id'))
        {
            $arr_insert['estimate_id']          = $request->input('estimate_id');
        }
        
        $total_mn = $dc_percent = $dc_total = $after_discount = 0;
        $total_mn       = str_replace(",","", $request->input('total_mn',0));
        $dc_percent     = str_replace(",","", $request->input('dc_percent',0));
        $dc_total       = str_replace(",","", $request->input('dc_total',0));
        $after_discount = str_replace(",","", $request->input('after_discount',0));

        $total = (int) $total_mn - (int) $dc_total;
        
        $arr_insert['sub_total']      = (int) $total_mn;
        $arr_insert['dc_percent']     = (int) $dc_percent;
        $arr_insert['dc_total']       = (int) $dc_total;
        $arr_insert['after_discount'] = (int) $after_discount;
        $arr_insert['total']          = (int) $total;

        if($obj_order = $this->PurchaseOrderModel->create($arr_insert)) {

            $order_estimate_id = $obj_order->id;
            $order_number = format_purchase_order_number($order_estimate_id);
            $obj_order->order_number = $order_number;
            $obj_order->save();

            $arr_det_ins = [];

            if(!empty($arr_pur_order_details)) {
                foreach($arr_pur_order_details as $key => $row) {

                    $arr_det_ins[$key]['pur_ord_id']     = $order_estimate_id;
                    $arr_det_ins[$key]['item_id']             = (int) $row[0]??0;
                    $arr_det_ins[$key]['unit_id']             = $row[1]??0;
                    $arr_det_ins[$key]['unit_price']          = $row[2]??0;
                    $arr_det_ins[$key]['quantity']            = $row[3]??0;
                    $arr_det_ins[$key]['net_total']           = $row[4]??0;
                    $arr_det_ins[$key]['tax_id']              = (int) $row[5]??0;
                    //$arr_det_ins[$key]['tax_rate']            = '';
                    $arr_det_ins[$key]['net_total_after_tax'] = $row[6]??0;
                    $arr_det_ins[$key]['discount_per']        = $row[7]??0;
                    $arr_det_ins[$key]['discount_money']      = $row[8]??0;
                    $arr_det_ins[$key]['total']               = $row[9]??0;
                }
                $this->PurchaseOrderDetailModel->insert($arr_det_ins);
            }

            Session::flash('success',trans('admin.purchase_order').' '.trans('admin.created_successfully'));
            return redirect()->route('purchase_order');
        }
    }

    public function view($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseOrderModel
                                        ->with(['purchase_order_details.item_detail','vendor_payment'])
                                        ->where('id',$id)->first();
        if($obj_data)
        {
            $arr_data = $arr_pay_methods = $arr_payment = [];
            $arr_data = $obj_data->toArray();

            $obj_pay_methods = $this->PaymentMethodsModel->where('is_active', '1')->get();

            if($obj_pay_methods->count() > 0) {
                $arr_pay_methods = $obj_pay_methods->toArray();
            }

            $obj_payment = $this->VendorPaymentModel->with('payment_method_detail')->where('pur_order_id',$id)->get();
            if($obj_payment)
            {
                $arr_payment = $obj_payment->toArray();
            }

            $this->arr_view_data['arr_payment']     = $arr_payment;
            $this->arr_view_data['arr_data']        = $arr_data;
            $this->arr_view_data['arr_pay_methods'] = $arr_pay_methods;

            $this->arr_view_data['module_title']    = trans('admin.manage').' '.$this->module_title;
            $this->arr_view_data['page_title']      = 'View '.$this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;
            
            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
        else
        {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }
    }

    public function add_po_payment($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_order = $this->PurchaseOrderModel->where('id', $id)->first();

        if($obj_order) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['amount']        = "required";
            $arr_rules['pay_method_id'] = "required";
            $arr_rules['pay_date']      = 'required';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                $arr_store['pur_order_id']  = $id;
                $arr_store['vendor_id']     = $obj_order->vendor_id;
                $arr_store['amount']        = $request->input('amount');
                $arr_store['pay_method_id'] = $request->input('pay_method_id');
                $arr_store['pay_date']      = $request->input('pay_date');
                $arr_store['trans_id']      = $request->input('trans_id');
                $arr_store['note']          = $request->input('note');

                if($this->VendorPaymentModel->create($arr_store)) {
                    $arr_resp['status'] = 'success';
                    $arr_resp['message'] = trans('admin.payment_recorded_successfully');
                }else{
                    $arr_resp['status'] = 'error';
                    $arr_resp['message'] = trans('admin.error_msg');
                }
            }
        }else{
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

    public function get_purchase_workflow()
    {
        $with_workflow = 0;
        $obj_with_workflow = SiteSettingModel::where('id',1)
                                        ->select('purchase_with_workflow')
                                        ->first();
        if($obj_with_workflow)
        {
            $with_workflow = $obj_with_workflow->purchase_with_workflow ?? 0;
        }

        return $with_workflow;
    }

    public function dowload_purchase_order($enc_id)
    {
        $id = base64_decode($enc_id);

        $obj_po = $this->PurchaseOrderModel->with(['purchase_order_details.item_detail',
                                                'vendor_payment','user_meta'])
                                            ->where('id',$id)->first();

        if(!$obj_po) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_po                                 = $obj_po->toArray();
            $this->arr_view_data['arr_po']          = $arr_po;
            $amount_in_worrd                        = $this->numberTowords($arr_po['total']);
            $this->arr_view_data['amount_in_worrd'] = $amount_in_worrd;

            $view = view($this->module_view_folder.'.download_pdf',$this->arr_view_data);
            //return $view;
            $html = $view->render();

            $img_file = asset('/images/image--000.png');
            PDF::SetTitle($arr_po['order_number']);
            PDF::AddPage();
            PDF::SetAlpha(0.08);
            PDF::Image($img_file, 35, 70, 140, 140, '', '', '', false, 300, '', false, false, 0);
            PDF::SetAlpha(1);
            PDF::setPageMark();
            PDF::writeHTML($html, true, false, true, false, '');
            PDF::Output($arr_po['order_number'].'.pdf');
        }
    }

    public function numberTowords(float $amount)
    {
       $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
       // Check if there is any number after decimal
       $amt_hundred = null;
       $count_length = strlen($num);
       $x = 0;
       $string = array();
       $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
         3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
         7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
         10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
         13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
         16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
         19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
         40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
         70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
      $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
      while( $x < $count_length ) {
           $get_divider = ($x == 2) ? 10 : 100;
           $amount = floor($num % $get_divider);
           $num = floor($num / $get_divider);
           $x += $get_divider == 10 ? 1 : 2;
           if ($amount) {
             $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
             $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
             $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
             '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
             '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
             }else $string[] = null;
           }
       $implode_to_Rupees = implode('', array_reverse($string));
       $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
       " . $change_words[$amount_after_decimal % 10]) . ' Riyal' : '';
       return ($implode_to_Rupees ? $implode_to_Rupees . 'Riyal ' : '') . $get_paise;
    }

    public function po_change_status($enc_id,Request $request)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->PurchaseOrderModel->where('id',$id)->first();
        if($obj_data)
        {
            $status = base64_decode($request->status) ?? 0;
            $obj_data->status = $status;
            $obj_data->save();

            $arr_resp['status']  = 'success';
            $arr_resp['message'] = trans('admin.status_changed_successfully');
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }

    public function get_estimate_deatils($enc_id)
    {
        $arr_estimate = [];
        $id = base64_decode($enc_id);
        $obj_estimate = $this->PurchaseEstimateDetailsModel
                                                    ->with([
                                                        'estimate',
                                                        'estimate.vendor',
                                                        'estimate.vendor.contract',
                                                    ])
                                                    ->where('pur_estimate_id',$id)->get();
        if($obj_estimate)
        {
            $arr_estimate = $obj_estimate->toArray();
            foreach ($arr_estimate as $key => $value) 
            {
                $estimate = $value['estimate']??[];
                $vendor = $estimate['vendor']??[];
                $contract = $vendor['contract']??[];

                unset($value['estimate']);

                $arr_estimate[$key]['item_code']      = $value['item_id'] ?? 0;
                $arr_estimate[$key]['unit_id']        = $value['unit_id'] ?? 0;
                $arr_estimate[$key]['unit_price']     = $value['unit_price'] ?? 0;
                $arr_estimate[$key]['quantity']       = $value['quantity'] ?? 0;
                $arr_estimate[$key]['into_money']     = $value['net_total'] ?? 0;
                $arr_estimate[$key]['tax']            = $value['tax_id'] ?? 0;
                $arr_estimate[$key]['total']          = $value['net_total_after_tax'] ?? 0;
                $arr_estimate[$key]['total_money']    = $value['total'] ?? 0;
                $arr_estimate[$key]['discount_%']     = $value['discount_per'] ?? 0;
                $arr_estimate[$key]['discount_money'] = $value['discount_money'] ?? 0;

                unset($arr_estimate[$key]['estimate']);
                unset($arr_estimate[$key]['id']);
                unset($arr_estimate[$key]['pur_estimate_id']);
                unset($arr_estimate[$key]['item_id']);
                unset($arr_estimate[$key]['net_total']);
                unset($arr_estimate[$key]['tax_id']);
                unset($arr_estimate[$key]['tax_rate']);
                unset($arr_estimate[$key]['net_total_after_tax']);
                unset($arr_estimate[$key]['discount_per']);
                unset($arr_estimate[$key]['created_at']);
                unset($arr_estimate[$key]['updated_at']);
            }

            $arr_base_estimate['sub_total']      = $value['estimate']['sub_total'] ?? 0;
            $arr_base_estimate['dc_percent']     = $value['estimate']['dc_percent'] ?? 0;
            $arr_base_estimate['dc_total']       = $value['estimate']['dc_total'] ?? 0;
            $arr_base_estimate['after_discount'] = $value['estimate']['after_discount'] ?? 0;
            $arr_base_estimate['total']          = $value['estimate']['total'] ?? 0;
            $arr_base_estimate['days_owed']      = $contract['pay_days']??0;

            $data['arr_estimate'] = $arr_estimate;
            $data['arr_base_estimate'] = $arr_base_estimate;

            $arr_resp['status']  = 'success';
            $arr_resp['data']  = $data;
            $arr_resp['message'] = trans('admin.data_found');
        }
        else
        {
            $arr_resp['status']  = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp,200);
    }
}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\TranscationService;
use App\Models\User;
use App\Models\OrdersModel;
use App\Models\TransactionsModel;
use App\Models\SalesContractModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;
use Carbon\Carbon;

class TransactionsController extends Controller
{
    public function __construct()
    {
        $this->UserModel            = new User;
        $this->OrdersModel          = new OrdersModel;
        $this->TransactionsModel    = new TransactionsModel;
        $this->SalesContractModel   = new SalesContractModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.account_statements');
        $this->module_view_folder   = "sales.transactions";
        $this->TranscationService   = new TranscationService();
    }

    public function index(Request $request) {

        $arr_orders = $arr_sorted_orders = $arr_sales_user = $arr_trans = $arr_pump = $arr_user_trans = $arr_contracts = [];

        $contract_id = $sales_user = $custm_id = '';

        /* Order Mode Query */

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = date('Y-m-d', strtotime($start_date . ' +2 years'));
        }

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','invoice','cust_details','pump_details','transactions','sales_agent_details','contract'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date);

        if($this->auth->user()->role_id != config('app.roles_id.admin')) {
            $obj_orders = $obj_orders->where('sales_agent', $this->auth->user()->id);
        }
        if($request->has('status') && $request->input('status') != '') {
            $obj_orders = $obj_orders->where('order_status', $request->input('status'));
        }
        if($request->has('custm_id') && $request->input('custm_id') != '') {
            $custm_id = $request->input('custm_id');
            $obj_orders = $obj_orders->where('cust_id', $custm_id);
        }
        if($request->has('contract') && $request->input('contract') != '') {
            $contract_id = $request->input('contract');
            $obj_orders = $obj_orders->where('contract_id', $contract_id);
        }
        if($request->has('sales_user') && $request->input('sales_user') != '') {
            $sales_user = $request->input('sales_user');
            $obj_orders = $obj_orders->where('sales_agent', $sales_user);
        }
        $obj_orders = $obj_orders->orderBy('id', 'ASC')->get();
        if($obj_orders->count() > 0) {
            $arr_orders = $obj_orders->toArray();
        }
        /* Order Mode Query */

        $obj_trans = $this->TransactionsModel->whereHas('contract', function(){})
                                            ->with(['contract'])
                                            ->whereNotNull('contract_id')->get();

        if($obj_trans->count() > 0) { $arr_trans = $obj_trans->toArray(); }

        if(!empty($arr_trans)) {
            foreach($arr_trans as $trans) {
                $contract = $trans['contract']??[];
                if(!empty($contract)) {
                    $cust_id = $contract['cust_id']??0;
                    unset($trans['contract']);
                    $arr_user_trans[$cust_id][] = $trans;
                }
            }
        }

        $obj_contracts = $this->SalesContractModel->whereHas('cust_details', function(){})
                                                ->with(['cust_details'])
                                                ->get();

        if($obj_contracts->count() > 0) {
            $arr_contracts = $obj_contracts->toArray();
        }

        $obj_customer = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->get();

        if($obj_customer->count() > 0) {
            $arr_customer = $obj_customer->toArray();
        }

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.sales'))
                                    ->get();

        if($obj_users->count() > 0) {
            $arr_sales_user = $obj_users->toArray();
        }

        $this->arr_view_data['arr_orders']      = $arr_orders;
        $this->arr_view_data['arr_user_trans']  = $arr_user_trans;
        $this->arr_view_data['arr_contracts']   = $arr_contracts;
        $this->arr_view_data['arr_sales_user']  = $arr_sales_user;
        $this->arr_view_data['start_date']      = $start_date;
        $this->arr_view_data['end_date']        = $end_date;
        $this->arr_view_data['contract_id']     = $contract_id;
        $this->arr_view_data['sales_user']      = $sales_user;
        $this->arr_view_data['arr_customer']    = $arr_customer;
        $this->arr_view_data['custm_id']        = $custm_id;
        
        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    
    public function nonBooking(){
        $arr_customers = $obj_trans = [];

        $obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role','transactions','sale_contracts'])
                                    ->where('id', '!=', $this->auth->user()->id)
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->get();
        // $users =$this->UserModel->join('transactions', 'transactions.user_id', '=', 'users.id','left')
        // ->join('sales_contract', 'sales_contract.cust_id', '=', 'users.id')
        // ->where('users.role_id', config('app.roles_id.customer'))
        // ->get(['users.*', 'sales_contract.*','transactions.*']);
        // dd($users->toArray());
        if($obj_users->count() > 0) {
            $arr_customers = $obj_users->toArray();
        }
        if($obj_users->count() > 0) {
            $arr_customers = $obj_users->toArray();
        }

        $this->arr_view_data['arr_customers']   = $arr_customers;
        $this->arr_view_data['page_title']      = $this->module_title;
        // dd($arr_customers[510]);
        // dd($arr_customers[510]['sale_contracts']);
        // dd($arr_customers[0]['transactions']);
        return view($this->module_view_folder.'.non_booking',$this->arr_view_data);
    }

    public function satement_details($enc_id) {

        $arr_order = [];

        $id = base64_decode($enc_id);

        $obj_order = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details',
                                            'ord_details.del_notes',
                                            'ord_details.del_notes.driver',
                                            'ord_details.del_notes.vehicle',
                                            'ord_details.product_details',
                                            'invoice',
                                            'cust_details',
                                            'pump_details',
                                            'transactions',
                                            'sales_agent_details'])
                                    ->where('id', $id)->first();

        if(!$obj_order) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_order = $obj_order->toArray();

            $this->arr_view_data['arr_order'] = $arr_order;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
    }

    public function monthly_booking_statement(Request $request)
    {
        $arr_trans = [];
        $custm_id = '';

        if($request->has('dateRange') && $request->input('dateRange')) {
            $arr_range = explode('-', $request->input('dateRange'));
            $start_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[0]??''))->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d/m/Y', trim($arr_range[1]??''))->format('Y-m-d');
        }else{
            $start_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            //$end_date = Carbon::createFromFormat('d/m/Y',date('d/m/Y'))->format('Y-m-d');
            $end_date = date('Y-m-d', strtotime($start_date . ' +30 day'));
            
        }

        $obj_orders = $this->OrdersModel->whereHas('ord_details', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['ord_details','cust_details','transactions'])
                                    ->whereDate('delivery_date','>=', $start_date)
                                    ->whereDate('delivery_date','<=', $end_date);

        if($request->has('custm_id') && $request->input('custm_id')!='')
        {
            $custm_id = $request->input('custm_id');
            $obj_orders = $obj_orders->where('cust_id',$custm_id);
        }

        $obj_orders = $obj_orders->get();

        if($obj_orders)
        {
            $arr_orders = $obj_orders->toArray();
        }

        $arr_user_trans = [];

        if(isset($arr_orders) && sizeof($arr_orders)>0){
            foreach($arr_orders as $key => $order){
                $arr_user_trans[$order['cust_id']][] = $order ?? 0;
            }
        }

        $obj_customer = $this->UserModel->whereHas('role', function(){})
                                    ->with(['role'])
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->get();

        if($obj_customer->count() > 0) {
            $arr_customer = $obj_customer->toArray();
        }

        $this->arr_view_data['arr_user_trans']  = $arr_user_trans;
        $this->arr_view_data['arr_customer']  = $arr_customer;
        $this->arr_view_data['start_date'] = $start_date;
        $this->arr_view_data['end_date']   = $end_date;
        $this->arr_view_data['custm_id']   = $custm_id;

        return view($this->module_view_folder.'.monthly_booking_statement',$this->arr_view_data);
    }

}

<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Common\Services\TranscationService;
use App\Models\User;
use App\Models\LeadsModel;
use App\Models\ProductModel;
use App\Models\SalesEstimateModel;
use App\Models\TaxesModel;
use App\Models\TransactionsModel;
use App\Models\PaymentMethodsModel;
use App\Models\SalesEstimateProdQuantModel;
use App\Models\InvoicePayMethodsModel;
use App\Models\SalesProposalModel;
use App\Models\SalesProposalDetailsModel;
use App\Models\SalesInvoiceModel;
use App\Models\SalesInvoiceDetailsModel;
use Validator;
use Session;
use Cookie;
use DB;
use Auth;
use PDF;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->UserModel                   = new User;
        $this->LeadsModel                  = new LeadsModel;
        $this->ProductModel                = new ProductModel;
        $this->SalesEstimateModel          = new SalesEstimateModel;
        $this->PaymentMethodsModel         = new PaymentMethodsModel;
        $this->TransactionsModel           = new TransactionsModel;
        $this->SalesEstimateProdQuantModel = new SalesEstimateProdQuantModel;
        $this->InvoicePayMethodsModel      = new InvoicePayMethodsModel;
        $this->SalesProposalModel          = new SalesProposalModel;
        $this->SalesProposalDetailsModel   = new SalesProposalDetailsModel;
        $this->SalesInvoiceModel           = new SalesInvoiceModel;
        $this->SalesInvoiceDetailsModel    = new SalesInvoiceDetailsModel;
        $this->TaxesModel                  = new TaxesModel;
        $this->auth                        = auth();
        $this->arr_view_data               = [];
        $this->module_title                = "Admin";
        $this->module_view_folder          = "sales.payments";
        $this->TranscationService              = new TranscationService();
    }

    public function index() {

        $arr_inv_pay = $arr_sales_user = [];

        $obj_inv_pay = $this->TransactionsModel->whereHas('pay_method_details', function(){})
                                    ->with(['pay_method_details','invoice.order.cust_details','contract.cust_details'])
                                    ->get();

        if($obj_inv_pay->count() > 0) {
            $arr_inv_pay = $obj_inv_pay->toArray();
        }

        //dd($arr_inv_pay);

        $this->arr_view_data['arr_inv_pay']   = $arr_inv_pay;

        return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function view_payment($enc_id) {

        $arr_payment = [];

        $id = base64_decode($enc_id);

        $obj_inv_pay = $this->TransactionsModel->whereHas('pay_method_details', function(){})
                                    ->whereHas('invoice', function(){})
                                    ->with([
                                            'pay_method_details',
                                            'invoice',
                                            'invoice.inv_payments',
                                            'invoice.pay_methods',
                                            'invoice.pay_methods.method_details'
                                        ])
                                    ->where('id', $id)->first();

        if(!$obj_inv_pay) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_payment = $obj_inv_pay->toArray();

            // dd($arr_payment);

            $this->arr_view_data['arr_payment'] = $arr_payment;

            return view($this->module_view_folder.'.view',$this->arr_view_data);
        }
    }

    public function dowload($enc_id) {

        $id = base64_decode($enc_id);

        $obj_payment = $this->TransactionsModel->whereHas('pay_method_details', function(){})
                                        ->whereHas('invoice', function(){})
                                        ->with([
                                            'pay_method_details',
                                            'invoice',
                                            'invoice.inv_payments',
                                            'invoice.pay_methods',
                                            'invoice.pay_methods.method_details'
                                        ])
                                        ->where('id', $id)->first();

        if(!$obj_payment) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{
            $arr_payment = $obj_payment->toArray();

            $this->arr_view_data['arr_payment'] = $arr_payment;

            $view = view($this->module_view_folder.'.download_pdf',$this->arr_view_data);

            // return $view;

            $html = $view->render();

            PDF::SetTitle(format_sales_invoice_number($arr_payment['id']));
            PDF::AddPage();
            PDF::writeHTML($html, true, false, true, false, '');
            PDF::Output(format_sales_invoice_number($arr_payment['id']).'.pdf');
        }
    }

    public function update_payment($enc_id, Request $request) {

        $id = base64_decode($enc_id);

        $obj_payment = $this->TransactionsModel->where('id', $id)->first();

        if($obj_payment) {

            $arr_rules                  = $arr_resp = array();
            $arr_rules['amount']        = "required";
            $arr_rules['pay_method']    = "required";
            $arr_rules['payment_date']  = 'required';

            $validator = validator::make($request->all(),$arr_rules);

            if($validator->fails()) {
                $arr_resp['status']         = 'error';
                $arr_resp['validation_err'] = $validator->messages()->toArray();
                $arr_resp['message']        = trans('admin.validation_errors');
            }else{
                $arr_update['amount'] = $request->input('amount');
                $arr_update['pay_method_id'] = $request->input('pay_method');
                $arr_update['pay_date'] = $request->input('payment_date');
                $arr_update['trans_id'] = $request->input('trans_id');
                $arr_update['note'] = $request->input('admin_note');

                if($this->TransactionsModel->where('id', $id)->update($arr_update)) {
                    $arr_resp['status'] = 'success';
                    $arr_resp['message'] = trans('admin.payment_update_success');
                }else{
                    $arr_resp['status'] = 'error';
                    $arr_resp['message'] = trans('admin.payment_update_error');
                }
            }
        }else{
            $arr_resp['status'] = 'error';
            $arr_resp['message'] = trans('admin.invalid_request');
        }

        return response()->json($arr_resp, 200);
    }

    public function delete($enc_id) {

        $id = base64_decode($enc_id);

        $obj_inv_pay = $this->TransactionsModel->where('id', $id)->first();

        if(!$obj_inv_pay) {
            Session::flash('error',trans('admin.invalid_request'));
            return redirect()->back();
        }else{

            if($obj_inv_pay->delete()) {
                Session::flash('success',trans('admin.payment_delete_success'));
                return redirect()->route('payments');
            }else{
                Session::flash('error',trans('admin.payment_delete_error'));
                return redirect()->back();
            }
        }
    }
}

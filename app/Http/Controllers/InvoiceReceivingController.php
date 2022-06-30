<?php

namespace App\Http\Controllers;

use App\Models\InvoiceReceiving;
use App\Models\PurchaseOrderModel;
use App\Models\User;
use Illuminate\Http\Request;

use Validator;
use Session;
use Auth;

class InvoiceReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
	{
        $this->PurchaseOrderModel   = new PurchaseOrderModel;
        $this->User                 = new User;

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Invoice Receiving";
        $this->module_view_folder   = "vechicle_maintance.purchase_parts";
        $this->module_url_path      = url('/invoice_receiving');

	}
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        $arr_purchase_order = $arr_supplier = $arr_make = [];
        $obj_purchase_order =  PurchaseOrderModel::where('status','1')->get();
        if($obj_purchase_order)
        {
            $arr_purchase_order = $obj_purchase_order->toArray();
        }

        $obj_supplier = $this->User->where('role_id',config('app.roles_id.vechicle_parts_supplier'))
                                    ->where('is_active','1')
                                    ->get();
        if($obj_supplier)
        {
            $arr_supplier = $obj_supplier->toArray();
        }

        $this->arr_view_data['arr_purchase_order']  = $arr_purchase_order;
        $this->arr_view_data['arr_supplier'] = $arr_supplier;
        
        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        return view($this->module_view_folder.'.invoice_receiving',$this->arr_view_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $arr_rules['p_order_id'] = 'required';
          $arr_rules['invoice_id'] = 'required';
          $arr_rules['bin_id']     = 'required';

          $validator = Validator::make($request->All(),$arr_rules);
          if($validator->fails())
          {
              Session::flash('error',trans('admin.validation_error_msg'));
              return redirect()->back()->withErrors($validator)->withInputs($request->all());
          }
          
          $inputParams   = $request->input();
        //   $user = \Auth::user();
        $created = InvoiceReceiving::create($inputParams);

        if($created && $created->p_order_id){
            $params['status'] = '2'; //approved and update qunatity
            if($inputParams['received']=='NO'){
                $params['status'] = '3'; // rejected
                Session::flash('success',trans('admin.invoice_receiving').trans('admin.rejected'));
            }
            $updatedResp = PurchaseOrderModel::where('id',$created->p_order_id)->update($params);
            Session::flash('success',trans('admin.invoice_create_success'));
            return redirect()->route('vhc_parts_stocks');
        }
        else{
            Session::flash('error',trans('admin.invoice_create_error'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceReceiving  $invoiceReceiving
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceReceiving $invoiceReceiving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceReceiving  $invoiceReceiving
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceReceiving $invoiceReceiving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceReceiving  $invoiceReceiving
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceReceiving $invoiceReceiving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceReceiving  $invoiceReceiving
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceReceiving $invoiceReceiving)
    {
        //
    }
}

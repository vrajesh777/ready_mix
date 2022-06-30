<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    protected $table = 'orders';
    protected $fillable = [
                            'cust_id',
                            'estimation_id',
                            'contract_id',
    						'order_no',
    						'delivery_date',
                            'delivery_time',
                            'pump',
    						'sales_agent',
    						'admin_note',
                            'client_note',
                            'terms_conditions',
                            'order_status',
                            'sub_total',
                            'disc_amnt',
                            'grand_tot',
                            'structure',
                            'remark',
                            'advance_payment',
                            'adv_plus_bal',
                            'balance',
                            'extended_date',    
                            'pump_op_id',
                            'pump_helper_id',
                            'driver_id',
    					  ];

    public function invoice()
    {
        return $this->hasOne('App\Models\SalesInvoiceModel','order_id','id');
    }

    public function ord_details()
    {
        return $this->hasMany('App\Models\OrderDetailsModel','order_id','id');
    }

    public function cust_details()
    {
        return $this->hasOne('App\Models\User','id','cust_id');
    }

    public function sales_agent_details()
    {
        return $this->hasOne('App\Models\User','id','sales_agent');
    }

    public function pay_methods()
    {
        return $this->hasMany('App\Models\InvoicePayMethodsModel','invoice_id','id');
    }

    public function pump_details()
    {
        return $this->hasOne('App\Models\PumpModel','id','pump')->select('id','name');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\TransactionsModel','order_id','id');
    }

    public function contract()
    {
        return $this->hasOne('App\Models\SalesContractModel','id','contract_id');
    }
    
}

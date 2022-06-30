<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceModel extends Model
{
    protected $table = 'invoice';
    protected $fillable = [
    						'order_id',
    						'invoice_number',
    						'invoice_date',
    						'due_date',
    						'currency',
                            'net_total',
                            'discount',
                            'discount_type',
                            'grand_tot',
                            'adjustment',
                            'billing_street',
                            'billing_city',
                            'billing_state',
                            'billing_zip',
                            'billing_country',
                            'include_shipping',
                            'shipping_street',
                            'shipping_city',
                            'shipping_state',
                            'shipping_zip',
                            'shipping_country',
    					  ];

    public function inv_details()
    {
        return $this->hasMany('App\Models\SalesInvoiceDetailsModel','invoice_id','id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\OrdersModel','id','order_id');
    }

    public function pay_methods()
    {
        return $this->hasMany('App\Models\InvoicePayMethodsModel','invoice_id','id');
    }

    public function inv_payments()
    {
        return $this->hasMany('App\Models\InvoicePaymentModel','invoice_id','id');
    }
}

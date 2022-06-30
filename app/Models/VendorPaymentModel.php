<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VendorPaymentModel extends Model
{
    protected $table = 'vendor_payment';
    protected $fillable = [
    						'pur_order_id',
    						'vendor_id',
    						'amount',
    						'pay_method_id',
    						'trans_id',
    						'pay_date',
    						'note'
    					  ];

    public function payment_method_detail()
    {
        return $this->belongsTo('App\Models\PaymentMethodsModel','pay_method_id','id');
    }

    public function order_detail()
    {
        return $this->belongsTo('App\Models\PurchaseOrderModel','pur_order_id','id');
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePaymentModel extends Model
{
    use SoftDeletes;
    protected $table = 'invoice_payment';

    protected $fillable = [
    						'invoice_id',
    						'amount',
    						'pay_method_id',
    						'pay_date',
    						'trans_id',
    						'note',
    					  ];

    public function invoice()
    {
        return $this->hasOne('App\Models\SalesInvoiceModel','id','invoice_id');
    }

    public function pay_method_details()
    {
        return $this->hasOne('App\Models\PaymentMethodsModel','id','pay_method_id');
    }
}

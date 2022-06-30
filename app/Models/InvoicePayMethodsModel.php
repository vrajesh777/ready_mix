<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InvoicePayMethodsModel extends Model
{
    protected $table = 'invoice_payments_methods';
    protected $fillable = [
    						'invoice_id',
    						'pay_method_id',
    					  ];

    public function method_details()
    {
        return $this->hasOne('App\Models\PaymentMethodsModel','id','pay_method_id');
    }

}

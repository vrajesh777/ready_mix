<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionsModel extends Model
{
    use SoftDeletes;
    protected $table = 'transactions';

    protected $fillable = [
                            'dept_id',
    						'invoice_id',
                            'user_id',
                            'contract_id',
                            'order_id',
    						'amount',
    						'type',
    						'pay_method_id',
    						'pay_date',
    						'trans_no',
                            'note',
                            'is_show'
    					  ];

    public function invoice()
    {
        return $this->hasOne('App\Models\SalesInvoiceModel','id','invoice_id');
    }

    public function contract()
    {
        return $this->hasOne('App\Models\SalesContractModel','id','contract_id');
    }

    public function pay_method_details()
    {
        return $this->hasOne('App\Models\PaymentMethodsModel','id','pay_method_id');
    }

    public function vechicle_pur_order()
    {
        return $this->hasOne('App\Models\PurchaseOrderModel','id','order_id');
    }
}

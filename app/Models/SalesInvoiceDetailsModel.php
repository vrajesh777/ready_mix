<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceDetailsModel extends Model
{
    protected $table = 'sales_invoice_details';
    protected $fillable = [
    						'invoice_id',
    						'product_id',
    						'quantity',
    						'rate',
                            'tax_id',
                            'tax_rate',
    					  ];

    public function product_details()
    {
        return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }

}

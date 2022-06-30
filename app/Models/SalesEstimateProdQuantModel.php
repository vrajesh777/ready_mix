<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesEstimateProdQuantModel extends Model
{
    protected $table = 'sales_estimate_product_quantity';
    protected $fillable = [
    						'proposal_id',
    						'product_id',
    						'quantity',
                            'rate',
                            'opc_1_rate',
                            'src_5_rate',
                            'tax_id',
                            'tax_rate',
    					  ];

    public function product_details()
    {
    	return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }
}

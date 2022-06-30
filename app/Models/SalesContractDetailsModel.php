<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesContractDetailsModel extends Model
{
    protected $table = 'sales_contract_details';
    protected $fillable = [
    						'contr_id',
    						'product_id',
    						'quantity',
    						'rate',
    						'tax_id',
    						'tax_rate',
    						'opc_1_rate',
    						'src_5_rate'
    					  ];

    public function product_details()
    {
        return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }
}

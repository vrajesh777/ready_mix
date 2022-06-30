<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseEstimateDetailsModel extends Model
{
    protected $table = 'purchase_estimate_details';
    protected $fillable = [
    						'pur_estimate_id',
    						'item_id',
    						'unit_id',
    						'unit_price',
    						'quantity',
                            'net_total',
    						'tax_id',
    						'tax_rate',
                            'net_total_after_tax',
                            'discount_per',
                            'discount_money',
    						'total'
    					  ];

    public function item_detail()
    {
        return $this->belongsTo('App\Models\ItemModel','item_id','id');
    }

    public function estimate()
    {
        return $this->belongsTo('App\Models\PurchaseEstimateModel','pur_estimate_id','id');
    }
}

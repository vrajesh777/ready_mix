<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VechiclePurchasePartsModel extends Model
{
    protected $table = 'vhc_purchase_parts';
    protected $fillable = [
    						'part_id',
    						'supply_id',
    						'manufact_id',
    						'condition',
    						'buy_price',
    						'quantity',
    						'sell_price',
    						'part_no',
    						'purch_date',
    						'warrenty_days',
    						'warrenty_in',
    						'warrenty',
    						'total_amount',
    						'given_amount',
    						'pending_amount',
    						'image'
    		    		  ];

    public function parts_details()
    {
        return $this->hasMany('App\Models\VechiclePurchasePartsDetailsModel','pur_part_id','id');
    }

    public function part()
    {
        return $this->belongsTo('App\Models\ItemModel','part_id','id')->select('id','commodity_name');
    }

    public function supplier_details()
    {
        return $this->belongsTo('App\Models\User','supply_id','id')->select('id','first_name','last_name');
    }

    public function manufacturer_details()
    {
        return $this->belongsTo('App\Models\ManufacturerModel','manufact_id','id')->select('id','name');
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VhcPartSupplyDetailModel extends Model
{
    protected $table = 'vhc_part_supply_detail';
    protected $fillable = [
    				'supply_order_id',
    				'item_id',
    				'quantity'
    			];

    public function item()
    {
        return $this->belongsTo('App\Models\ItemModel','item_id','id');
    }
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VechiclePurchasePartsDetailsModel extends Model
{
    protected $table = 'vhc_pur_parts_details';
    protected $fillable = [
                            'part_id',
                						'pur_order_id',
                						'make_id',
                						'model_id',
                						'year_id'
    		    		          ];

   	public function purchase_order()
   	{
   		return $this->hasMany('App\Models\PurchaseOrderModel','id','pur_order_id');
   	}

    public function part()
    {
      return $this->belongsTo('App\Models\ItemModel','part_id','id');
    }
}

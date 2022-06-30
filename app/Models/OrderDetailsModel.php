<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderDetailsModel extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
    						'order_id',
    						'product_id',
    						'quantity',
                            'edit_quantity',
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

    public function order()
    {
        return $this->hasOne('App\Models\OrdersModel','id','order_id');
    }

    public function del_notes()
    {
        return $this->hasMany('App\Models\DeliveryNoteModel','order_detail_id','id');
    }

}

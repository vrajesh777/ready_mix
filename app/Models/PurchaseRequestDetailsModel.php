<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetailsModel extends Model
{
    protected $table = 'purchase_request_details';
    protected $fillable = [
    						'pur_req_id',
    						'item_id',
    						'unit_id',
    						'unit_price',
    						'qunatity',
    						'total',
    						'desciption'
    					  ];

    public function item_detail()
    {
        return $this->belongsTo('App\Models\ItemModel','item_id','id');
    }

    public function tax_detail()
    {
        return $this->belongsTo('App\Models\TaxesModel','unit_id','id');
    }
}

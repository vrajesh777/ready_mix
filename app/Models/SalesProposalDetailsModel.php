<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesProposalDetailsModel extends Model
{
    protected $table = 'sales_proposal_details';
    protected $fillable = [
    						'estimation_id',
    						'product_id',
    						'quantity',
    						'rate',
                            'opc_1_rate',
                            'src_5_rate'
    					  ];

    public function product_details()
    {
        return $this->belongsTo('App\Models\ProductModel','product_id','id');
    }

}

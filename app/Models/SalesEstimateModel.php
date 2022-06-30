<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesEstimateModel extends Model
{
    protected $table = 'sales_estimate';
    protected $fillable = [
    						'subject',
    						'related',
    						'assigned_to',
    						'lead_id',
    						'cust_id',
    						'date',
                            'open_till',
                            'tags',
                            'allow_comments',
                            'status',
                            'to',
                            'address',
                            'city',
                            'state',
                            'postal_code',
                            'country',
                            'email',
                            'phone',
                            'net_total',
                            'product_id',
                            'quantity',
                            'discount',
                            'discount_type',
                            'grand_tot',
                            'adjustment',
    					  ];

    public function product_quantity()
    {
        return $this->hasMany('App\Models\SalesEstimateProdQuantModel','proposal_id','id');
    }
}

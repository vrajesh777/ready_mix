<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseEstimateModel extends Model
{
    protected $table = 'purchase_estimate';
    protected $fillable = [
    						'estimate_no',
    						'vendor_id',
    						'pur_req_id',
    						'user_id',
    						'estimate_date',
    						'expiry_date',
    						'status',
                            'sub_total',
                            'dc_percent',
                            'dc_total',
                            'after_discount',
                            'total'
    					  ];

    /*public function vendor_details()
    {
        return $this->belongsTo('App\Models\User','vendor_id','id')->select('id','role_id');
    }*/

    public function user_meta()
    {
        return $this->hasMany('App\Models\UserMetaModel','user_id','vendor_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\User','vendor_id','id');
    }

    public function pur_request()
    {
        return $this->belongsTo('App\Models\PurchaseRequestModel','pur_req_id','id');
    }

    public function purchase_estimate_details()
    {
        return $this->hasMany('App\Models\PurchaseEstimateDetailsModel','pur_estimate_id','id');
    }

    public function purchase_order_detail()
    {
        return $this->belongsTo('App\Models\PurchaseOrderModel','id','estimate_id');
    }
}

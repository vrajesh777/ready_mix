<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestModel extends Model
{
    protected $table = 'purchase_request';
    protected $fillable = [
    						'purchase_request_code',
    						'purchase_request_name',
    						'department_id',
    						'user_id',
    						'description'
    					  ];

    public function user_detail()
    {
    	return $this->belongsTo('App\Models\User','user_id','id')->select('id','first_name','last_name');
    }

    public function purchase_request_details()
    {
        return $this->hasMany('App\Models\PurchaseRequestDetailsModel','pur_req_id','id');
    }

    public function estimate()
    {
        return $this->belongsTo('App\Models\PurchaseEstimateModel','id','pur_req_id');
    }
}

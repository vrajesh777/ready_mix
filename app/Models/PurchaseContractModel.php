<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseContractModel extends Model
{
    protected $table = 'purchase_contract';
    protected $fillable = [
    						'user_id',
    						'contract_no',
    						'contract_id',
    						'pur_order_id',
    						'vendor_id',
    						'contract_value',
    						'start_date',
    						'end_date',
    						'pay_days',
    						'sign_status',
    						'signed_date',
    						'description'
                          ];

    public function user_meta()
    {
        return $this->hasMany('App\Models\UserMetaModel','user_id','vendor_id');
    }

    public function user_details()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select('id','first_name','last_name');
    }

    public function pur_order_details()
    {
        return $this->belongsTo('App\Models\PurchaseOrderModel','pur_order_id','id')->select('id','name','order_number');
    }
    
    public function attachment()
    {
        return $this->hasMany('App\Models\PurchaseContractAttachmentModel','pur_contract_id','id');
    }
}

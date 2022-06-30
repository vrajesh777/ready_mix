<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderModel extends Model
{
    protected $table = 'purchase_orders';
    protected $fillable = [
                            'dept_id',
                            'estimate_id',
    						'name',
    						'vendor_id',
    						'order_date',
    						'user_id',
    						'order_number',
    						'no_of_days_owned',
    						'delivery_Date',
    						'vendor_note',
    						'terms_conditions',
    						'status',
    						'sub_total',
    						'dc_percent',
    						'dc_total',
    						'after_discount',
                            'total',
                            'part_id',
                            'manufact_id',
                            'condition',
                            'buy_price',
                            'quantity',
                            'sell_price',
                            'part_no',
                            'warrenty',
                            'given_amount',
    						'pending_amount',
                            'image'
    					  ];

    public function user_meta()
    {
        return $this->hasMany('App\Models\UserMetaModel','user_id','vendor_id');
    }
    
    public function purchase_order_details()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetailModel','pur_ord_id','id');
    }

    public function vendor_payment()
    {
        return $this->hasMany('App\Models\VendorPaymentModel','pur_order_id','id');
    }

    public function part()
    {
        return $this->belongsTo('App\Models\ItemModel','part_id','id');
    }

    public function parts_details()
    {
        return $this->hasMany('App\Models\VechiclePurchasePartsDetailsModel','pur_order_id','id');
    }
    
    public function supplier_details()
    {
        return $this->belongsTo('App\Models\User','vendor_id','id')->select('id','first_name','last_name');
    }
    
    public function manufacturer_details()
    {
        return $this->belongsTo('App\Models\ManufacturerModel','manufact_id','id')->select('id','name');
    }
    
}

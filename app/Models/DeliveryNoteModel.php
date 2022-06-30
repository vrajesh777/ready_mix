<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DeliveryNoteModel extends Model
{
    protected $table = 'delivery_note';
    protected $fillable = [
    						'order_detail_id',
    						'vehicle_id',
    						'driver_id',
    						'quantity',
                            'pump',
    						'delivery_date',
    						'status',
                            'delivery_no',
                            'load_no',
                            'reject_qty',
                            'reject_by',
                            'remark',
                            'excess_qty',
                            'is_transfer',
                            'transfer_to',
                            'to_customer_id',
                            'extra_qty',
                            'slump',
                            'no_of_cubes',
                            'comp_method',
                            'air_content',
                            'sampled_by',
                            'avg_at_days',
                            'cylinder_slump',
                            'cylinder_no_of_cubes',
                            'cylinder_comp_method',
                            'cylinder_air_content',
                            'cylinder_sampled_by',
                            'cylinder_avg_at_days',
                            'from_customer_id',
                            'to_delivery_id',
                            'gate',
                            'canceled_reason','is_pushed_to_erp',
                            'helper_id',
                            'operator_id'
    					  ];

    public function driver()
    {
        return $this->hasOne('App\Models\User','id','driver_id');
    }

    public function vehicle()
    {
        return $this->hasOne('App\Models\VehicleModel','id','vehicle_id');
    }

    public function order_details()
    {
        return $this->hasOne('App\Models\OrderDetailsModel','id','order_detail_id');
    }
    public function cube_details()
    {
        return $this->hasMany('App\Models\DelNoteQcCubeDetailModel','delivery_note_id','id');
    }

    public function from_customer()
    {
        return $this->hasOne('App\Models\User','id','from_customer_id');
    }

    public function to_customer()
    {
        return $this->hasOne('App\Models\User','id','to_customer_id');
    }

    public function to_delivery()
    {
        return $this->hasOne('App\Models\DeliveryNoteModel','id','to_delivery_id');
    }

    

    
    
}

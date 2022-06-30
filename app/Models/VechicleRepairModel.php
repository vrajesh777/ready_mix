<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VechicleRepairModel extends Model
{
    protected $table = 'vechicle_repair';
    protected $fillable = [
    						'dept_id',
    						'order_no',
    						'delivery_date',
    						'vechicle_id',
    						'status',
    						'note',
    						'assignee_id',
    						'created_date',
    						'time',
    						'jobcard_no',
                            'door_no',
                            'km_count',
                            'hours_meter',
                            'complaint',
                            'diagnosis',
                            'action',
                            'remark',
    					  ];

    public function vechicle_details()
    {
        return $this->belongsTo('App\Models\VehicleModel','vechicle_id','id');
    }

    public function vhc_parts()
    {
        return $this->hasMany('App\Models\VhcPartSupplyDetailModel','supply_order_id','id');
    }
}

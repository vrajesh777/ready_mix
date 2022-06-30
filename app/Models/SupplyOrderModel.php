<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SupplyOrderModel extends Model
{
    protected $table = 'supply_order';
    protected $fillable = [
		    				'dept_id',
		    				'order_no',
		    				'delivery_date',
		    				'vechicle_id',
		    				'status',
                            'note',
                            'jobcard_no',
                            'door_no',
                            'km_count',
                            'time',
                            'complaint',
                            'diagnosis',
                            'action',
                            'remark',
                            'assignee_id',
                            'hours_meter',
		    			 ];

    public function vechicle_details()
    {
    	return $this->belongsTo('App\Models\VehicleModel','vechicle_id','id');
    }

    public function vhc_part_detail()
    {
    	return $this->hasMany('App\Models\VhcPartSupplyDetailModel','supply_order_id','id');
    }
}

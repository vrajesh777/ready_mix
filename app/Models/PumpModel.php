<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PumpModel extends Model
{
    protected $table = "pump";
    protected $fillable = [
    						'name',
    						'location',
    						'lat',
    						'lng',
    						'is_active',
    						'operator_id',
    						'helper_id',
                            'driver_id'
    					  ];

    public function operator()
    {
        return $this->belongsTo('App\Models\User','operator_id','id');
    }

    public function helper()
    {
        return $this->belongsTo('App\Models\User','helper_id','id');
    }

    public function driver()
    {
        return $this->belongsTo('App\Models\User','driver_id','id');
    }
}

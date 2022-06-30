<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicle';
    protected $fillable = [
                            'driver_id',
                            'name',
                            'plate_no',
                            'plate_letter',
                            'vehicle_reg',
                            'vin_no',
                            'regs_no',
    						'chasis_no',
                            'maker',
                            'model',
                            'year',
                            'engine_type',
                            'horse_power',
                            'type',
                            'color',
    						'avg',
    						'license_plate',
    						'initial_mileage',
    						'license_expiry_date',
    						'registration_expiry_date',
                            'is_active'
    					];

    public function driver_details()
    {
        return $this->belongsTo('App\Models\User','driver_id','id');
    }

    public function make()
    {
        return $this->belongsTo('App\Models\VechicleMakeModel','maker','id')->select('id','make_name');
    }

    public function model()
    {
        return $this->belongsTo('App\Models\VechicleModelModel','model','id')->select('id','model_name');
    }

    public function year()
    {
        return $this->belongsTo('App\Models\VechicleYearModel','year','id')->select('id','year');
    }
}

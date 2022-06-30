<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VechicleYearModel extends Model
{
    protected $table = 'vechicle_year';
    protected $fillable = [
    						'make_id',
    						'model_id',
    						'year',
    						'is_active'
    					  ];

    public function make()
    {
    	return $this->belongsTo('App\Models\VechicleMakeModel','make_id','id');
    }

    public function model()
    {
    	return $this->belongsTo('App\Models\VechicleModelModel','model_id','id');
    }
}

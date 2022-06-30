<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VechicleModelModel extends Model
{
    protected $table = 'vechicle_model';
    protected $fillable = [
    						'make_id',
    						'model_name',
    						'is_active'
    					  ];

    public function make()
    {
    	return $this->belongsTo('App\Models\VechicleMakeModel','make_id','id');
    }
}

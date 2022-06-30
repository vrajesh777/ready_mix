<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VechicleMakeModel extends Model
{
    protected $table = 'vechicle_make';
    protected $fillable = [
    						'make_name',
    						'is_active'
    					  ];
}

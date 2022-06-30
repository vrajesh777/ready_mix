<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekendsModel extends Model
{
    protected $table = "weekends";
    protected $fillable = [
    						'name',
    						'dept_id',
    						'days'
    					  ];
}

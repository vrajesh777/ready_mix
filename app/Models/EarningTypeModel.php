<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningTypeModel extends Model
{
    protected $table = 'earning_type';
    protected $fillable = [
    						'name',
    						'is_cal_type',
    						'is_cal_val',
    						'is_pay_type',
    						'is_active'
    					  ];
}

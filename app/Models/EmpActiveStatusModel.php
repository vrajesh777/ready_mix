<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmpActiveStatusModel extends Model
{
    protected $table = 'emp_active_status';
    protected $fillable = [
    						'user_id',
    						'start_time',
    						'end_time',
    						'date'
    					  ];
}

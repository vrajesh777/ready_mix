<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AttendanceModel extends Model
{
    protected $table = 'attendance';
    protected $fillable = [
    						'user_id',
    						'start_time',
    						'end_time',
    						'date',
    						'note',
    						'total_work_hr',
    						'status',
                            'extra_hour',
                            'extra_min',
                            'less_min',
                            'less_hour'
    					  ];
}

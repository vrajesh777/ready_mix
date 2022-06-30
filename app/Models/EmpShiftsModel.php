<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpShiftsModel extends Model
{
    use HasFactory;

    protected $table = 'emp_shifts';

    protected $fillable = [
    						'user_id',
    						'shift_id',
    						'from_date',
    						'to_date',
    					];

    public function shift_details()
    {
        return $this->hasOne('App\Models\WorkShiftsModel','id','shift_id');
    }

    public function user_detail()
    {
    	return $this->belongsTo('App\Models\User','user_id','id')->select('id','first_name','last_name');
    }
}

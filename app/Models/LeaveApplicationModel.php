<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicationModel extends Model
{
    use HasFactory;

    protected $table = 'leave_application';

    protected $fillable = [
                            'user_id',
                            'leave_type_id',
                            'type',
                            'applied_with',
                            'reason',
    					];

    public function employee()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function leave_type_details()
    {
        return $this->hasOne('App\Models\LeaveTypesModel','id','leave_type_id');
    }

    public function leave_days()
    {
        return $this->hasMany('App\Models\AppliedLeaveDaysModel','application_id','id');
    }
}

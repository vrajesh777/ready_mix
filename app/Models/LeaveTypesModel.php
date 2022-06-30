<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveTypesModel extends Model
{
    use HasFactory;

    protected $table = 'leave_types';

    protected $fillable = [
    						'title',
                            'code',
    						'type',
    						'unit',
    						'description',
    						'start',
    						'end',
                            'paid_days',
                            'unpaid_days',
    					];


    public function applicable()
    {
        return $this->hasOne('App\Models\LeaveApplicableModel','leave_type_id','id');
    }

    public function exceptions()
    {
        return $this->hasOne('App\Models\LeaveExceptionsModel','leave_type_id','id');
    }

    public function entitlement()
    {
        return $this->hasOne('App\Models\LeaveEntitlemantModel','leave_type_id','id');
    }

    public function restrictions()
    {
        return $this->hasOne('App\Models\LeaveRestrictionsModel','leave_type_id','id');
    }
}

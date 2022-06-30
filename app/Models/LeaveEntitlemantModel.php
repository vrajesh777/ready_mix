<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEntitlemantModel extends Model
{
    use HasFactory;

    protected $table = 'leave_entitlement';

    protected $fillable = [
                            'leave_type_id',
                            'effective_period',
                            'effective_unit',
                            'exp_field',
                            'accrual',
                            'accrual_period',
                            'accrual_time',
                            'accrual_month',
                            'accrual_no_days',
                            'accrual_mode',
                            'reset',
                            'reset_period',
                            'reset_time',
                            'reset_month',
                            'cf_mode',
                            'reset_carry',
                            'reset_carry_type',
                            'reset_carry_limit',
                            'reset_carry_expire_in',
                            'reset_carry_expire_unit',
                            'reset_encash_num',
                            'encash_type',
                            'reset_encash_limit',
    					];
}

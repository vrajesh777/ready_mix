<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmpLeavePolicyModel extends Model
{
    protected $table = 'emp_leave_policy';
    protected $fillable = [
    						'user_id',
    						'leave_types_id',
    						'type',
    						'unit',
    						'description',
    						'start',
    						'end',
    						'paid_days',
    						'unpaid_days',
    						'genders',
    						'marital_status',
    						'departments',
    						'designations',
    						'employee_types',
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
                            'carry_forword_overall_limit',
                            'take_overall_limit',
    						'reset_encash_num',
    						'encash_type',
    						'reset_encash_limit',
    						'include_weekends',
    						'inc_weekends_after',
    						'inc_holidays',
    						'incholidays_after',
    						'exceed_maxcount',
    						'exceed_allow_opt',
    						'duration_allowed',
    						'report_display',
    						'balance_display',
    						'pastbooking_enable',
    						'pastbooking_limit_enable',
    						'pastbooking_limit',
    						'futurebooking_enable',
    						'futurebooking_limit_enable',
    						'futurebooking_limit',
    						'futurebooking_notice_enable',
    						'futurebooking_notice',
    						'min_leave_enable',
    						'min_leave',
    						'max_leave_enable',
    						'max_leave',
    						'max_consecutive_enable',
    						'max_consecutive',
    						'min_gap_enable',
    						'min_gap',
    						'show_fileupload_after_enable',
    						'show_fileupload_after',
    						'frequency_count',
    						'frequency_period',
    						'applydates',
    						'blocked_clubs'
    					  ];

    public function leave_type(){
        return $this->hasOne('App\Models\LeaveTypesModel','id','leave_types_id');
    }
}

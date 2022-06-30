<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRestrictionsModel extends Model
{
    use HasFactory;

    protected $table = 'leave_restrictions';

    protected $fillable = [
                            'leave_type_id',
                            'include_weekends',
                            'inc_weekends_after',
                            'inc_holidays',
                            'incholidays_after',
                            'exceed_maxcount',
                            'exceed_allow_opt',
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
                            'blocked_clubs',
    					];
}

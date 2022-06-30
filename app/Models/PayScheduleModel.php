<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PayScheduleModel extends Model
{
    protected $table = 'pay_schedule';
    protected $fillable = [
    						'salary_on',
    						'days_per_month',
    						'pay_on',
    						'on_every_month',
    						'start_payroll',
    						'first_pay_date'
    					];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalaryModel extends Model
{
    protected $table = 'salary';
    protected $fillable = [
    						'user_id',
                            'pay_run_id',
    						'basic',
                            'overtime_pay',
                            'lac_pay',
    						'monthly_total',
                            'gross_total',
    						'payment_status',
    						'payment_date',
    						'paid_days',
    						'unpaid_days',
                            'is_added_on_erp'
    					  ];

    public function emp_salary_details(){
        return $this->hasMany('App\Models\SalaryDetailsModel','master_sal_id','id');
    }

    public function user_details(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}

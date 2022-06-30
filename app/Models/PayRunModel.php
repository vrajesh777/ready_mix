<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PayRunModel extends Model
{
    protected $table = 'pay_run';
    protected $fillable = [
    						'pay_date',
    						'for_month',
    						'for_year',
    						'net_pay',
    						'no_of_emp',
    						'status'
    					  ];

  	public function emp_salary(){
  		return $this->hasMany('App\Models\SalaryModel','pay_run_id','id');
  	}

}

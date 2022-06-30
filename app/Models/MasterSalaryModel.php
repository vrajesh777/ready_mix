<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterSalaryModel extends Model
{
    protected $table = "master_salary";
    protected $fillable = [
    						'user_id',
    						'basic',
    						'monthly_total',
    						'annualy_total'
    					  ];

    public function salary_details()
    {
        return $this->hasMany('App\Models\MasterSalaryDetailsModel','master_sal_id','id');
    }

    public function user_details(){
        return $this->belongsTo('App\Models\User','user_id','id')->select('id','emp_id','first_name','last_name','pay_overtime');
    }
}

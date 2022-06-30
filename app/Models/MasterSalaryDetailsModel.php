<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterSalaryDetailsModel extends Model
{
    protected $table = "master_salary_details";
    protected $fillable = [
    						'master_sal_id',
    						'earning_id',
    						'cal_value',
    						'monthly_amt'
    					  ];

    /*public function operator()
    {
        return $this->belongsTo('App\Models\User','operator_id','id');
    }*/

}

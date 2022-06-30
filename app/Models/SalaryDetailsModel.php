<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalaryDetailsModel extends Model
{
    protected $table = 'salary_details';
    protected $fillable = [
    						'master_sal_id',
    						'earning_id',
    						'cal_value',
    						'monthly_amt'
    					  ];

    public function earning_details(){
        return $this->belongsTo('App\Models\MasterEarningModel','earning_id','id');
    }
}

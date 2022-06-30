<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEarningModel extends Model
{
    protected $table = 'master_earning';
    protected $fillable = [
    						'earning_type_id',
    						'name',
    						'name_payslip',
                            'type',
    						'cal_type',
    						'cal_value',
    						'is_active',
                            'pay_on',
                            'is_extra'
    					  ];

    /*public function earning_type(){
        return $this->belongsTo('App\Models\EarningTypeModel','earning_type_id','id');
    }*/

}

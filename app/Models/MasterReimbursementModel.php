<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterReimbursementModel extends Model
{
    protected $table = 'master_reimbursement';
    protected $fillable = [
    						'reimbursement_type_id',
    						'name_payslip',
    						'amount',
    						'is_active'
    					  ];

   	public function reimbursement_type(){
   		return $this->belongsTo('App\Models\ReimbursementTypeModel','reimbursement_type_id','id');
   	}
}

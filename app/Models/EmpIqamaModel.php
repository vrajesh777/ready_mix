<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpIqamaModel extends Model
{
    use HasFactory;

    protected $table = 'iqamas';

    protected $fillable = [
    						'user_id',
    						'iqama_no',
    						'iqama_expiry_date',
    						'passport_no',
    						'passport_expiry_date',
    						'gosi_no',
							'contract_period',
    					];
}
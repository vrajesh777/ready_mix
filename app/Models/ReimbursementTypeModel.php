<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimbursementTypeModel extends Model
{
    protected $table = 'reimbursement_type';
    protected $fillable = [
    						'name',
    						'is_active'
    					  ];
}

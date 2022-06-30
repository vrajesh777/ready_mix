<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverheadExpancesModel extends Model
{
    protected $table = 'overhead_expances';
    protected $fillable = [
    						'name',
    						'type',
    						'value',
    						'is_active'
    					  ];
}

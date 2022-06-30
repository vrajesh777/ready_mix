<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseUnitsModel extends Model
{
    protected $table = 'purchase_units';
    protected $fillable = [
    						'unit_code',
    						'unit_name',
    						'unit_symbol',
    						'note',
    						'is_active'
    					  ];
}

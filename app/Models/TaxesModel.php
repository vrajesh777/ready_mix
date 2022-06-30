<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxesModel extends Model
{
    protected $table = 'taxes';
    protected $fillable = [
    						'name',
    						'tax_rate',
    						'is_active'
    					  ];
}

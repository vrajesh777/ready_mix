<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ManufacturerModel extends Model
{
    protected $table = 'manufacturer';
    protected $fillable = [
    						'name',
    						'image',
    						'is_active'
    					  ];
}

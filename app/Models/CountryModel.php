<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    protected $table = 'countries';
    protected $fillable = [
    						'id',
    						'sortname',
    						'name_en',
    						'name_ar',
    						'phonecode',
    						'is_active'
    					  ]; 
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance_Category extends Model
{
    use HasFactory;
    
    protected $table = 'maintenance_categories';

    protected $fillable = [
    						'name_arabic',
                            'name_english'
    					];
}

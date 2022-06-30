<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidaysModel extends Model
{
    protected $table = 'holidays';
    protected $fillable = [
    						'title',
    						'start',
    						'end',
    						'for',
    						'desc',
    					  ];
}

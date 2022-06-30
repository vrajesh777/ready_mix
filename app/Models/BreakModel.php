<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakModel extends Model
{
    use HasFactory;

    protected $table = 'break';

    protected $fillable = [
    						'title',
    						'pay_type',
    						'mode',
    						'start',
    						'end',
    						'allowed_duration',
                            'applicable_shifts',
    					];
}

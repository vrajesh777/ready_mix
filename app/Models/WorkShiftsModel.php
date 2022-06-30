<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftsModel extends Model
{
    use HasFactory;

    protected $table = 'work_shift';

    protected $fillable = [
    						'name',
    						'from',
    						'to',
    						'shift_margin',
    						'margin_before',
    						'margin_after',
                            'departments',
                            'color_code',
    					];
}

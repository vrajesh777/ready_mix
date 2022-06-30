<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedLeaveDaysModel extends Model
{
    use HasFactory;

    protected $table = 'applied_leave_days';

    protected $fillable = [
                            'application_id',
                            'date',
                            'from_time',
                            'to_time',
                            'period',
    					];
}

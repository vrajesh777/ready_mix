<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveExceptionsModel extends Model
{
    use HasFactory;

    protected $table = 'leave_exceptions';

    protected $fillable = [
                            'leave_type_id',
                            'departments',
                            'designations',
                            'employee_types',
                            'users',
    					];
}

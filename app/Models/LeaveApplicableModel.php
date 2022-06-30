<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicableModel extends Model
{
    use HasFactory;

    protected $table = 'leave_applicables';

    protected $fillable = [
                            'leave_type_id',
                            'genders',
                            'marital_status',
                            'departments',
                            'designations',
                            'employee_types',
                            'users',
    					];
}

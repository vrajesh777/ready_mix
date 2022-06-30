<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpEducationModel extends Model
{
    use HasFactory;

    protected $table = 'education';

    protected $fillable = [
    						'user_id',
    						'org_name',
    						'degree_name',
    						'faculty_name',
    						'completion_date',
    					];
}

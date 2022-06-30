<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpExperienceModel extends Model
{
    use HasFactory;

    protected $table = 'experiences';

    protected $fillable = [
    						'user_id',
    						'comp_name',
    						'job_title',
    						'from_date',
    						'to_date',
    						'description',
    					];
}

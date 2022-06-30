<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ParentDepartmentModel extends Model
{
    protected $table = 'parent_department';

    protected $fillable = [
    						'name',
    						'slug',
    						'is_active'
    					];
}

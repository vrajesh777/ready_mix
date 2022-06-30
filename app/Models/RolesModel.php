<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    protected $table = 'roles';

    protected $fillable = [
    						'slug',
    						'name',
    						'department_id'
    					];

}

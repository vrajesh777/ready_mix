<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentsModel extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable = [
    						'name',
    						'lead_user_id',
    						'parent_id',
    						'added_by',
                            'mail_alias',
                            'is_active'
    					];

    public function lead_user()
    {
        return $this->belongsTo('App\Models\User','lead_user_id','id');
    }

    public function parent_dept()
    {
        return $this->hasOne('App\Models\ParentDepartmentModel','id','parent_id');
    }
}

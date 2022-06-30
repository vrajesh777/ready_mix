<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMetaModel extends Model
{
    protected $table = 'user_meta';
    protected $fillable = [
    						'user_id',
    						'meta_key',
    						'meta_value'
    					  ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ResetPassTokenModel extends Model
{
    protected $table = 'reset_pass_token';
    protected $fillable = [
    						'cust_id',
    						'token',
    						'expire_at',
    						'is_used'
    					  ];
}

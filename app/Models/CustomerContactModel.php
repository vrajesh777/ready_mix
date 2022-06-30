<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustomerContactModel extends Model
{
    protected $table = 'customer_contact';
    protected $fillable = [
    						'cust_id',
    						'user_id',
    						'role_position'
    					  ];
}

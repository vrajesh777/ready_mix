<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VendorContactModel extends Model
{
    protected $table = 'vendor_contact';
    protected $fillable = [
    						'vendor_id',
    						'user_id',
    						'role_position'
    					  ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodsModel extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = [
    						'name',
    						'slug',
    						'description',
    						'is_active'
    					  ];
}

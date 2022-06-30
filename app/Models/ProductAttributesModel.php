<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductAttributesModel extends Model
{
    protected $table = 'product_attributes';
    protected $fillable = [
    						'product_type',
    						'name',
    						'slug',
    						'is_required',
    						'order_number'
    					  ];
}

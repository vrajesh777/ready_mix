<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValuesModel extends Model
{
    protected $table = 'product_attribute_values';
    protected $fillable = [
    						'product_id',
    						'product_attr_id',
    						'value',
                            'other_val'
    					  ];

    public function attribute()
    {
        return $this->hasOne('App\Models\ProductAttributesModel','id','product_attr_id');
    }
}

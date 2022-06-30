<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $fillable = [
    						'name',
                            'name_english',
                            'mix_code',
    						'description',
    						'rate',
    						'tax_id',
    						'min_quant',
    						'is_active',
                            'opc_1_rate',
                            'src_5_rate'
    					  ];

   	public function tax_detail()
    {
    	return $this->belongsTo('App\Models\TaxesModel','tax_id','id')->select('id','name','tax_rate');
    }

    public function attr_values()
    {
        return $this->hasMany('App\Models\ProductAttributeValuesModel','product_id','id')->select('product_id','product_attr_id','value','other_val','id');
    }
}

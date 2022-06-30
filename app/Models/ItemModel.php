<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    protected $table = 'item';
    protected $fillable = [
                            'dept_id',
    						'commodity_code',
    						'commodity_name',
    						'commodity_barcode',
    						'sku_code',
    						'sku_name',
    						'description',
    						'units',
    						'commodity_group',
    						'sub_group',
    						'tags',
                            'rate',
                            'purchase_price',
                            'tax_id',
    						'is_active'
    					  ];

    public function tax_detail()
    {
        return $this->belongsTo('App\Models\TaxesModel','tax_id','id');
    }

    public function unit_detail()
    {
        return $this->belongsTo('App\Models\PurchaseUnitsModel','units','id');
    }

    public function commodity_group_detail()
    {
        return $this->belongsTo('App\Models\CommodityGroupsModel','commodity_group','id');
    }

    public function item_images()
    {
        return $this->hasMany('App\Models\ItemImagesModel','item_id','id')->select('id','item_id','image');
    }

    public function vhc_purchase_orders()
    {
        return $this->hasMany('App\Models\PurchaseOrderModel','part_id','id');
    }

    public function vhc_supply_detail()
    {
        return $this->hasMany('App\Models\VhcPartSupplyDetailModel','part_id','id');
    }

    
}

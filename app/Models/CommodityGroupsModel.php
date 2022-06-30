<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CommodityGroupsModel extends Model
{
    protected $table = 'commodity_groups';
    protected $fillable = [
    						'parent_id',
    						'name',
    						'slug',
    						'is_active'
    					  ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SiteSettingModel extends Model
{
    protected $table = 'site_setting';
    protected $fillable = [
    						'sales_with_workflow',
    						'purchase_with_workflow'
    					  ];

}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemImagesModel extends Model
{
    protected $table = 'item_images';
    protected $fillable = [
    						'item_id',
    						'image'
    					  ];
}

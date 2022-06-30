<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BarcodesModel extends Model
{
    protected $table = 'barcodes';
    protected $fillable = [
    						'name',
    						'description',
    						'width',
    						'height',
    						'paper_width',
    						'paper_height',
                            'top_margin',
                            'left_margin',
                            'row_distance',
                            'col_distance',
                            'stickers_in_one_row',
                            'is_default',
                            'is_continuous',
                            'stickers_in_one_sheet'
    					];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DelNoteQcCubeDetailModel extends Model
{
    protected $table = 'del_note_qc_cube_detail';
    protected $fillable = [
                            'type',
    						'delivery_note_id',
    						'date_tested',
    						'age_days',
    						'weight',
    						's_area',
    						'height',
    						'density',
    						'm_load',
    						'c_strength',
                            'c_strength_kg',
    						'type_of_fraction'
    					];
}

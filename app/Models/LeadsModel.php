<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeadsModel extends Model
{
    protected $table = 'leads';

    protected $fillable = [
    						'status',
    						'source',
    						'assigned',
    						'tags',
    						'name',
    						'address',
    						'position',
    						'city',
    						'email',
    						'state',
    						'website',
    						'country',
    						'phone',
    						'zip_code',
    						'lead_value',
    						'default_language',
    						'company',
    						'description',
    						'contacted_date',
    						'user_id',
    					];

    public function assigned_to()
    {
        return $this->belongsTo('App\Models\User','assigned','id');
    }

}

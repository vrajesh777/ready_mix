<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationsModel extends Model
{
    use HasFactory;

    protected $table = 'designation';

    protected $fillable = [
    						'name',
    						'added_by',
    					];
}

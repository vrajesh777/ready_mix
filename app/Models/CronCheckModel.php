<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CronCheckModel extends Model
{
	protected $table = 'cron_check';
    protected $fillable = [
    						'id',
    						'time'
    					  ];
}

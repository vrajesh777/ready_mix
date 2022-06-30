<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InquiryModel extends Model
{
    protected $table = 'inquiry';

    protected $fillable = [
    						'subject',
    						'medium',
    						'email',
    						'requirement',
    						'note',
    					];

}

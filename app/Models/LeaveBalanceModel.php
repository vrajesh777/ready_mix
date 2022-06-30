<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeaveBalanceModel extends Model
{
    protected $table = 'leave_balance';
    protected $fillable = [
		    				'user_id',
		    				'leave_type_id',
		    				'valid_from',
		    				'valid_till',
		    				'balance',
		    				'taken_leave',
		    				'expire_count',
		    				'lop',
		    			 ];
}

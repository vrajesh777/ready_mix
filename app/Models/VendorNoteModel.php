<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VendorNoteModel extends Model
{
	protected $table = 'vendor_note';
	protected $fillable = [
							'vendor_id',
							'added_by',
							'description'
						  ];

	public function user_detail()
	{
		return $this->belongsTo('App\Models\User','added_by','id')->select('id','first_name','last_name');
	}
}

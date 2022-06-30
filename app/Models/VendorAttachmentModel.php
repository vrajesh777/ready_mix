<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VendorAttachmentModel extends Model
{
   protected $table = 'vendor_attachment';
   protected $fillable = [
   							'vendor_id',
   							'og_name',
   							'file'
   						 ];
}

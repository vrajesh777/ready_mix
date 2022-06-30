<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseContractAttachmentModel extends Model
{
    protected $table = 'purchase_contract_attachments';
    protected $fillable = [
    						'pur_contract_id',
    						'name',
    						'file'
                          ];
}

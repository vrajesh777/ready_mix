<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CustContractAttachmentModel extends Model
{
   	protected $table = 'cust_contract_attachment';
   	protected $fillable = [
   							'cust_cont_id',
   							'contract',
   							'quotation',
   							'bala_per',
   							'owner_id',
   							'credit_form',
   							'purchase_order',
   							'pay_grnt'
   						  ];
}

<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesContractModel extends Model
{
    protected $table = 'sales_contract';
    protected $fillable = [
    						'contract_no',
    						'cust_id',
    						'title',
    						'sales_agent',
    						'admin_note',
    						'client_note',
    						'terms_conditions',
    						'status',
                            'site_location',
                            'excepted_m3',
                            'compressive_strength',
                            'structure_element',
                            'slump',
                            'concrete_temp',
                            'quantity',
                            'delivery_address'

    					  ];

    public function contr_details()
    {
        return $this->hasMany('App\Models\SalesContractDetailsModel','contr_id','id');
    }

    public function cust_details()
    {
        return $this->hasOne('App\Models\User','id','cust_id');
    }

    public function contract_attch()
    {
        return $this->hasOne('App\Models\CustContractAttachmentModel','cust_cont_id','id');
    }


}

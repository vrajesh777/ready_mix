<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SalesProposalModel extends Model
{
    protected $table = 'sales_proposal';
    protected $fillable = [
                            'proposal_id',
    						'cust_id',
    						'est_num',
    						'ref_num',
    						'status',
    						'assigned_to',
    						'date',
                            'expiry_date',
                            'tags',
                            'admin_note',
                            'client_note',
                            'terms_n_cond',
                            'net_total',
                            'discount',
                            'discount_type',
                            'grand_tot',
                            'adjustment',
                            'billing_street',
                            'billing_city',
                            'billing_state',
                            'billing_zip',
                            'billing_country',
                            'include_shipping',
                            'shipping_street',
                            'shipping_city',
                            'shipping_state',
                            'shipping_zip',
                            'shipping_country',
    					  ];

    public function prop_details()
    {
        return $this->hasMany('App\Models\SalesProposalDetailsModel','estimation_id','id');
    }

    public function cust_details()
    {
        return $this->hasOne('App\Models\User','id','cust_id');
    }
}

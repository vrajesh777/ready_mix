<?php
namespace App\Common\Services\ERP;
use App\Common\Services\ERP\ApiService;
use Session;
use DB;


class CustomerService
{
    public function __construct()
    {
       $this->ApiService  = new ApiService();

    }
    public function store($arr_data)
    {
        $arr_insert      = [];
      
        $first_name      = $arr_data['first_name']??'';
        $last_name       = $arr_data['last_name']??'';
        $address_line_1  = $arr_data['address']??'';
        $city            = $arr_data['city']??'';
        $state           = $arr_data['state']??'';
        $country         = $arr_data['country']??'';

        $credit_limit    = $arr_data['credit_limit']??10000;

        $arr_insert['custname']        = $first_name." ".$last_name;
        $arr_insert['address']         = $address_line_1.','.$city.','.$state.','.$country;
        $arr_insert['curr_code']       = 'SAR';
        $arr_insert['credit_status']   = 1;
        $arr_insert['payment_terms']   = 1;
        $arr_insert['discount']        = 0;
        $arr_insert['pymt_discount']   = 0;
        $arr_insert['credit_limit']    = $credit_limit;
        $arr_insert['sales_type']      = 3;
        $arr_insert['cust_ref']        = $first_name;
        $arr_insert['tax_id']          = 0;

       $response =  $this->ApiService->execute_curl('customers',$arr_insert);
      // dd( $response);
       return $response;

    }
   
}
?> 
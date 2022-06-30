<?php
namespace App\Common\Services\ERP;
use Session;
use DB;
use App\Common\Services\ERP\ApiService;
use App\Common\Services\ERP\CustomerService;
use App\Models\DeliveryNoteModel;

class SalesService
{
    public function __construct()
    {
          $this->ApiService          = new ApiService();
          $this->CustomerService     = new CustomerService();
          $this->DeliveryNoteModel   = new DeliveryNoteModel();
  
    }
    public function store($arr_data)
    {
        $response ='';
        $arr_insert      = $arr_items=$arr_customer_data=$arr_product=[];
        $arr_grn = [];
    
      if($arr_data!="" && count($arr_data)>0)
      {


        $arr_items[0]['stock_id']   = $arr_data['stock_id']??'';
        $arr_items[0]['qty']        = (int)$arr_data['quantity']??'';
        $arr_items[0]['price']      = number_format($arr_data['price'],2);
        $arr_items[0]['discount']   = 0;
        $arr_items[0]['description']= $arr_data['name']??'';
        
        $customer_name  = $arr_data['cust_first_name']." ".$arr_data['cust_last_name'];
        $invoice_ref_no = isset($arr_data['ref']) && $arr_data['ref']!=""?$arr_data['ref']:'';

        $address = $arr_data['address']??'';
        $postal_code = $arr_data['postal_code']??'';
        $state   = $arr_data['state']??'';
        $city    = $arr_data['city']??'';

        $delivary_date                   = date("d/m/Y", strtotime("+ 1 day"));
        $arr_insert['trans_type']        = 10;//sales_order
        $arr_insert['document_date']     = date('d/m/Y');
        $arr_insert['customer_id']       = $arr_data['cust_first_name']??'';
        $arr_insert['branch_id']         = '';
        $arr_insert['order_date']        = date('d/m/Y');
        $arr_insert['payment']           = 4;
        $arr_insert['deliver_to']        = $customer_name??'';
        $arr_insert['delivery_address']  = $address.','.$state.','.$city.','.$postal_code;
        $arr_insert['delivery_date']     = $delivary_date;
        $arr_insert['ref']               = $invoice_ref_no;
        $arr_insert['ship_via']          = 1;
        $arr_insert['order_type']        = 0;
        $arr_insert['sales_type']        = 3;
        $arr_insert['location']          = 'DEF';
        $arr_insert['dimension_id']      =  0;
        $arr_insert['dimension2_id']     =  0;
        $arr_insert['items']             =  $arr_items;
     
       $response = $this->ApiService->execute_curl('sales',$arr_insert);
       if($response)
       {

            $obj_delivery_note = DeliveryNoteModel::where('id',$arr_data['order_id'])->first();
            if($obj_delivery_note)
            {
                $obj_delivery_note->update(['is_pushed_to_erp'=>'1']);
            }
            return true;

       }
       else
       {
            return false;
       }
      }
       return $response;

    }
    public function get_customer_data($id)
    {
        $arr_customer = [];
         $business_id = request()->session()->get('user.business_id');
         $contact = $this->contactUtil->getContactInfo($business_id, $id);

         $arr_customer['first_name']   =  $contact->first_name??'';
         $arr_customer['last_name']    =  $contact->last_name??'';
         $arr_customer['shipping_address'] =  $contact->shipping_address??'';
         return $arr_customer;

    }
   

}
?> 
<?php
namespace App\Common\Services\ERP;
use App\Common\Services\ERP\ApiService;
use Session;
use DB;

class ItemService
{
    public function __construct()
    {
       $this->ApiService  = new ApiService();
    }
    public function store($arr_data)
    {

      $arr_item = [];
      $arr_item['stock_id']               = $arr_data['stock_id']??'';
      $arr_item['description']            = $arr_data['description']??'';
      $arr_item['description_ar']         = isset($arr_data['name_ar'])&& $arr_data['name_ar']!=""?$arr_data['name_ar']:$arr_data['description'];
      $arr_item['long_description']       = $arr_data['long_description']??'';
      $arr_item['long_description_ar']    =isset($arr_data['desc_ar'])&& $arr_data['desc_ar']!=""?$arr_data['desc_ar']:$arr_data['long_description'];
      $arr_item['category_id']            = '1';
      $arr_item['tax_type_id']            = '1';
      $arr_item['units']                  = 'each';
      $arr_item['mb_flag']                 = 'B';
      $arr_item['sales_account']           = '4010';
      $arr_item['cogs_account']            = '5010';
      $arr_item['adjustment_account']      = '5040';
      $arr_item['wip_account']             = '1530';
   
      $response = $this->ApiService->execute_curl('inventory',$arr_item);
      //dd( $arr_item,$response);
      return $response;
    }

}
?> 
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderDetailsModel;
use App\Models\DeliveryNoteModel;
class CustomerSummaryReportController extends Controller
{
    public function __construct()
    {
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Customer Summary Report";
        $this->module_view_folder   = "customer_summary_report";
        $this->module_url_path      = url('/customer_summary_report');
        $this->UserModel            = new User();
        $this->OrderDetailsModel    = new OrderDetailsModel();
        $this->DeliveryNoteModel    = new DeliveryNoteModel();
    }
    public function index($type='')
    {	
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['page_title']      = $this->module_title;
		return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    public function get_customer_suggestion(Request $request)
    {
    	$term = $request->input('term');
    	$obj_users = $this->UserModel->whereHas('role', function(){})
                                    ->where('role_id', config('app.roles_id.customer'))
                                    ->where('id', 'LIKE', "%{$term}%")
                                    ->get();

        
    	$output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    	if(isset($obj_users) && count($obj_users)>0)
    	{
		    foreach($obj_users as $row)
		    {
		        $output .= '<li><a style="cursor:pointer;" onclick="getCustomerDetails('.$row->id.')">'.$row->id.' ('.$row->first_name." ".$row->last_name.')'.'</a></li>';
		    }
    	}
    	else
    	{
    		$output .= '<li><a href="#">No Data found</a></li>';
    	}
    	$output .= '</ul>';
		echo $output;
    }
    public function get_customer_details(Request $request)
    {
    	$arr_data = [];
    	$customer_id  = $request->input('customer_id','');
    	$obj_customer = $this->UserModel->where('id',$customer_id)->first();
    	$first_name   = $obj_customer->first_name??'';
    	$last_name    = $obj_customer->last_name??'';
    	$cust_name    = $first_name." ".$last_name;

    	$obj_data    = $this->DeliveryNoteModel
    	                      ->whereHas('order_details',function($q1)use($customer_id){
    	                      	$q1->whereHas('order',function($q2)use($customer_id){
    	                      		$q2->where('cust_id',$customer_id);
    	                      	});
    	                      	
    	                      })
                               ->with(['order_details'=>function($q1)use($customer_id){
                               			$q1->whereHas('order',function($q2)use($customer_id){
		    	                      	  $q2->where('cust_id',$customer_id);
		    	                      	});  
                                     },'cube_details'])
                               ->get();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}
    	
    	$this->arr_view_data['page_title']                    = $this->module_title;
    	$this->arr_view_data['module_url_path']               = $this->module_url_path;
    	$this->arr_view_data['arr_data']                      = $arr_data;

    	$view = view($this->module_view_folder.".customer_report_view",$this->arr_view_data)->render();
        return response()->json(['html'=>$view,'customer_id'=>$customer_id,'cust_name'=>$cust_name]);
    }
}

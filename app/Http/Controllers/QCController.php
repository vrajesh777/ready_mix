<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryNoteModel;
use App\Models\DelNoteQcCubeDetailModel;
use Illuminate\Support\Facades\DB;

class QCController extends Controller
{
    public function __construct(DeliveryNoteModel $DeliveryNoteModel)
    {
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "QC report";
        $this->module_view_folder   = "qc_report";
        $this->module_url_path      = url('/qc');
        $this->DeliveryNoteModel    = $DeliveryNoteModel;
        $this->DelNoteQcCubeDetailModel    = new DelNoteQcCubeDetailModel();
    }
    public function index($type='')
    {	
        $this->arr_view_data['type']            = $type;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['page_title']      = $this->module_title;
		return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function cube_cylinder($type='')
    {	
        $this->arr_view_data['type']            = $type;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['page_title']      = $this->module_title;
		return view($this->module_view_folder.'.cube_cylinder',$this->arr_view_data);
    }
    
    public function get_delivery_no_suggestion(Request $request)
    {
    	$arr_data = [];
    	$term = $request->input('term','');
        $report_type = $request->input('report_type','');
        $obj_data = $this->DeliveryNoteModel->where('delivery_no', 'LIKE', "%{$term}%");
        $obj_data = $obj_data->whereHas('cube_details', function ($query) {
                                $query->whereIn('type',['cube','cylinder']);
                            });
        // DB::enableQueryLog(); 
    	$obj_data = $obj_data->get();
        // dd(DB::getQueryLog()); 
    	$output = '<ul class="dropdown-menu" style="display:block; position:relative">';
    	if(isset($obj_data) && count($obj_data)>0)
    	{
		    foreach($obj_data as $row)
		    {
		        $output .= '<li><a style="cursor:pointer;" onclick="getDeliveryDetails('.$row->id.')">'.$row->delivery_no.'</a></li>';
		    }
    	}
    	else
    	{
    		$output .= '<li><a href="#">No Data found</a></li>';
    	}
    	$output .= '</ul>';
		echo $output;
    	  
    }
    public function get_delivery_details(Request $request)
    {
    	$arr_data    = [];
    	$delivery_id = $request->input('delivery_id','');
    	$obj_data    = $this->DeliveryNoteModel->where('id',$delivery_id)
                                               ->with(['order_details.order',
                                                        'order_details.product_details',
                                                        'order_details.order.cust_details',
                                                        'order_details.order.contract',
                                                        'order_details.order.sales_agent_details',
                                                        // 'cube_details'
                                                        'cube_details'=>function($q1){
                                                            $q1->whereIn('type',['cube','cylinder']);
                                                        }
                                                        ])
                                               ->first();
    	if($obj_data)
    	{
    		$arr_data = $obj_data->toArray();
    	}
        
        $delivery_date = $arr_data['delivery_date']??'';
    	$delivery_no   = $arr_data['delivery_no']??'';
        $first_half_tested_date  = date('Y-m-d',strtotime($delivery_date."+7 days"));
        $second_half_tested_date = date('Y-m-d',strtotime($delivery_date."+28 days"));

    	$this->arr_view_data['page_title']      = $this->module_title;
    	$this->arr_view_data['module_url_path'] = $this->module_url_path;
    	$this->arr_view_data['arr_data']        = $arr_data;
        $this->arr_view_data['first_half_tested_date']        = $first_half_tested_date;
        $this->arr_view_data['second_half_tested_date']       = $second_half_tested_date;

    	$view = view($this->module_view_folder.".delivery_report_view",$this->arr_view_data)->render();
        return response()->json(['html'=>$view,'delivery_no'=>$delivery_no]);
    }
    
    public function calculate_tested_date(Request $request)
    {
    	$arr_json = [];
    	$delivery_date       = $request->input('delivery_date','');
    	if($delivery_date!="")
    	{
            $first_half_tested_date = date('Y-m-d',strtotime($delivery_date."+7 days"));
            $second_half_tested_date = date('Y-m-d',strtotime($delivery_date."+28 days"));
    	}
    	$arr_json['first_half_tested_date']  = $first_half_tested_date;
        $arr_json['second_half_tested_date'] = $second_half_tested_date;
        return response()->json($arr_json);
    	
    }
    public function calculate_avg_days(Request $request)
    {
    	$avg_html = '';
    	$arr_age = $arr_cube =[];
     
    	$age_days = $request->input('age_days','');
    	$cstrength = $request->input('cstrength','');
    	$cstrength_sum = 0;
    	if(isset($age_days) && count($age_days)>0)
    	{
    		foreach ($age_days as $key => $value) 
    		{
    			
    			if(isset($arr_age[$value]))
    			{
    				$arr_age[$value]['cstrength']+=$cstrength[$key];
    				$arr_age[$value]['count'] = count($arr_age[$value]);
    			}
    			else
    			{
    				if($cstrength[$key]!="")
    				{
    					$arr_age[$value]['cstrength']=$cstrength[$key];
    					$arr_age[$value]['count'] = 1;
    				}
    				
    			}
    			
    		}
    	}
        $arr_cube = $request->input('cube_data',[]);
        if(isset($arr_cube) && count($arr_cube)>0)
        {
            foreach($arr_cube as $cube)
            {
                $age_days = $cube['age_days']??'';
                if(isset($arr_age[$age_days]))
                {
                    $arr_age[$age_days]['cstrength']+=$cube['c_strength'];
                    $arr_age[$age_days]['count'] = count($arr_age[$age_days]);
                }
                else
                {
                    if(isset($cube['c_strength']) && $cube['c_strength']!="")
                    {
                        $arr_age[$age_days]['cstrength']=$cube['c_strength'];
                        $arr_age[$age_days]['count'] = 1;
                    }
                    
                }
            }

        }
        $json_avg_days = isset($arr_age)?json_encode($arr_age):'';
    	if(isset($arr_age) && count($arr_age)>0)
    	{
    		foreach ($arr_age as $key => $value) 
    		{
    			$age_days =  $key;
    			$avg      = number_format($value['cstrength']/$value['count'],2);
    		
                $avg_html.='<tr>';
                $avg_html.='<td colspan="3" style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;text-align:right;background-color: #d3d0de;">&nbsp;&nbsp;<strong>Average At '.$age_days.' Days</strong>&nbsp;&nbsp;</td>';
                $avg_html.='<td colspan="3" style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;'.$avg.' Mpa</td>';
                $avg_html.='</tr>';

    		}
    	}
        $avg_html.='<input type="hidden" name="avg_at_days" value='.$json_avg_days.'>';
        echo $avg_html;

    }
    
}

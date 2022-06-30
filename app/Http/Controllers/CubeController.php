<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryNoteModel;
use App\Models\DelNoteQcCubeDetailModel;
use Validator;
use Session;
class CubeController extends Controller
{
    public function __construct(DeliveryNoteModel $DeliveryNoteModel)
    {
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Cube";
        $this->module_view_folder   = "cube";
        $this->module_url_path      = url('/cube');
        $this->DeliveryNoteModel    = $DeliveryNoteModel;
        $this->DelNoteQcCubeDetailModel    = new DelNoteQcCubeDetailModel();
    }
    public function index($report_type='')
    {
        $this->arr_view_data['report_type']     = $report_type;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        $this->arr_view_data['page_title']      = $this->module_title;
		return view($this->module_view_folder.'.index',$this->arr_view_data);
    }
    public function get_delivery_no_suggestion(Request $request)
    {
    	$arr_data = [];
    	$term = $request->input('term','');
        $report_type = $request->input('report_type','');
        $obj_data = $this->DeliveryNoteModel->where('delivery_no', 'LIKE', "%{$term}%");
        if($report_type=="new")
        {
            $obj_data = $obj_data->whereDoesntHave('cube_details', function ($query) {
                            $query->where('type', '=', 'cube');
                        });
        }
        else
        {
            $obj_data = $obj_data->whereHas('cube_details', function ($query) {
                            $query->where('type', '=', 'cube');
                        });
        }
    	$obj_data = $obj_data->get();
    
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
                                                        'cube_details'=>function($q1){
                                                            $q1->where('type','=','cube');
                                                        }])
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
    public function store_cube_details(Request $request)
    {

        $status    = $update_status='';
        $arr_rules = $form_data=$arr_delivery_note = $arr_cube = [];
        $arr_rules['delivery_date']      = 'required';
        $arr_rules['slump']              = 'required';
        $arr_rules['no_of_cube_tested']  = 'required';
        $arr_rules['compaction']         = 'required';
        $arr_rules['air_content']        = 'required';
        $arr_rules['sampled_by']         = 'required';

        $validator              = Validator::make($request->all(),$arr_rules);
        if($validator->fails())
        {
            Session::flash('error','Fields are missing');
            return redirect()->back()->withInput();
        }
        $form_data = $request->all();
        $arr_delivery_note['slump']       = $form_data['slump']??'';
        $arr_delivery_note['no_of_cubes'] = $form_data['no_of_cube_tested']??'';
        $arr_delivery_note['comp_method'] = $form_data['compaction']??'';
        $arr_delivery_note['air_content'] = $form_data['air_content']??'';
        $arr_delivery_note['sampled_by']  = $form_data['sampled_by']??'';
        $arr_delivery_note['avg_at_days'] = $form_data['avg_at_days']??'';

        $obj_delivery_note = $this->DeliveryNoteModel->where('id',$form_data['delivery_id'])->first();
        if($obj_delivery_note)
        {
           $update_status =  $obj_delivery_note->update($arr_delivery_note);
        }
        $delivery_id      =  $obj_delivery_note->id??'';
        $delivery_no      =  $obj_delivery_note->delivery_no??'';

        if(isset($form_data['date_tested']) && count($form_data['date_tested'])>0)
        {
            foreach($form_data['date_tested'] as $key=>$data)
            {
              
                $arr_cube = [];
                if($data!="")
                {
                    $date_tested = date('Y-m-d', strtotime(str_replace('/', '-',$data)));
                    $arr_cube['type']             ='cube';
                    $arr_cube['delivery_note_id'] = $form_data['delivery_id']??'';
                    $arr_cube['date_tested']      = $date_tested;
                    $arr_cube['age_days']         = $form_data['age_days'][$key]??'';
                    $arr_cube['weight']           = $form_data['weight'][$key]??'';
                    $arr_cube['s_area']           = $form_data['sarea'][$key]??'';
                    $arr_cube['height']           = $form_data['height'][$key]??'';
                    $arr_cube['density']          = $form_data['density'][$key];
                    $arr_cube['m_load']           = $form_data['mload'][$key]??'';
                    $arr_cube['c_strength']       = $form_data['cstrength'][$key]??'';
                    $arr_cube['c_strength_kg']    = $form_data['cstrengt_kg'][$key]??'';
                    $arr_cube['type_of_fraction'] = $form_data['fraction_type'][$key]??'';

                    $this->DelNoteQcCubeDetailModel->create($arr_cube);
                }
                
            }
        }
        if(isset($form_data['cube_data']) && count($form_data['cube_data'])>0)
        {
            foreach($form_data['cube_data'] as $cube_id=>$update_data)
            {
                $arr_update  = [];
                $date_tested = date('Y-m-d', strtotime(str_replace('/', '-', $update_data['date_tested'])));
                $arr_update['date_tested']      = $date_tested;
                $arr_update['age_days']         = $update_data['age_days']??'';
                $arr_update['weight']           = $update_data['weight']??'';
                $arr_update['s_area']           = $update_data['s_area']??'';
                $arr_update['height']           = $update_data['height']??'';
                $arr_update['density']          = $update_data['density'];
                $arr_update['m_load']           = $update_data['m_load']??'';
                $arr_update['c_strength']       = $update_data['c_strength']??'';
                $arr_update['c_strength_kg']    = $update_data['c_strength_kg']??'';
                $arr_update['type_of_fraction'] = $update_data['fraction_type']??'';

                $obj_cube_data = $this->DelNoteQcCubeDetailModel->where('id',$cube_id)->update($arr_update);

            }
        }
        if($update_status || $obj_cube_data)
        {
            Session::flash('success',trans('admin.cube').' '.trans('admin.details').' '.trans('admin.updated_successfully'));
        }
        else
        {
             Session::flash('error',trans('admin.error_msg'));
        }
        return redirect()->back()->withInput(['delivery_no'=>$delivery_no,'delivery_id'=>$delivery_id]);

    }
    public function delete_cube_details($cube_id,$delivery_no)
    {
        $delete_status = '';
        $obj_cube_data = $this->DelNoteQcCubeDetailModel->where('id',$cube_id)->first();
        if($obj_cube_data)
        {
            $delete_status = $obj_cube_data->delete();
        }
        if($delete_status)
        {
            Session::flash('success',trans('admin.cube').' '.trans('admin.deleted_successfully')); 
        }
        else
        {
             Session::flash('error','Error Occure');
        }
        $obj_delivery_note = $this->DeliveryNoteModel->where('delivery_no',$delivery_no)->first();
        $delivery_id       = $obj_delivery_note->id??'';
        return redirect()->back()->withInput(['delivery_no'=>$delivery_no,'delivery_id'=>$delivery_id]);
    }
    public function calculate_density(Request $request)
    {
        $weight = $request->input('weight','');
        $area   = $request->input('area','');
        $height = $request->input('height','');

        $density = $weight/(($area*$height)/1000000000);
        return round($density);
    }

}

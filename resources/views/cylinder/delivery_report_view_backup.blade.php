<style type="text/css">
	.remove-strength
	{
		cursor: pointer;
	}
	.add-strength
	{
		cursor: pointer;
	}
</style>
<form method="post" id="frm_cube_id" name="frm_cube_id" action="{{ $module_url_path }}/store">
{{ csrf_field() }}

<input type="hidden" name="delivery_id" value="{{ $arr_data['id']??'' }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;border:1px solid #ccc;border-bottom:none">
	<tr>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;"><strong style="">&nbsp;&nbsp;Client:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['cust_details']['first_name'] ?? '' }} {{ $arr_data['order_details']['order']['cust_details']['last_name'] ?? '' }}&nbsp;&nbsp;</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Site:</strong> {{ $arr_data['order_details']['order']['contract']['site_location'] ?? '' }}&nbsp;&nbsp;</td> 
	</tr>
	<tr>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;"><strong style="">&nbsp;&nbsp;Consultant:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['sales_agent_details']['first_name'] ?? '' }} {{ $arr_data['order_details']['order']['sales_agent_details']['last_name'] ?? '' }}</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Project:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['title'] ?? '' }}</td> 
	</tr>

</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;">
	<tr><td colspan="3" style=""><strong style="line-height:30px">Required Concrete Mix Specification:</strong></td> </tr>
	<tr>
		<td colspan="2" style="line-height:30px;border:1px solid #ccc;"><strong style="">&nbsp;&nbsp;Compressive Strength On Cube:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['compressive_strength'] ?? '' }}&nbsp;&nbsp;</td>
		<td style="line-height:30px;border:1px solid #ccc;border-left:none">&nbsp;&nbsp;<strong style="">Structure Element:</strong>{{ $arr_data['order_details']['order']['contract']['structure_element'] ?? '' }}&nbsp;&nbsp;</td> 
	</tr>
	
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;border-top:none"><strong style="">&nbsp;&nbsp;Slump:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['slump'] ?? '' }} mm</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Concrete Temp:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['concrete_temp'] ?? '' }} °C</td> 
		<td style="line-height:30px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Bulding No:&nbsp;&nbsp;</strong>NA</td> 
	</tr>
</table>

<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;">
	<tr><td colspan="3" style=""><strong style="line-height:30px">Sampling:</strong></td> </tr>
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;"><strong style="">&nbsp;&nbsp;Pouring Date :&nbsp;&nbsp;</strong><input type="text" name="delivery_date"  id="delivery_date" class="form-control" value="{{ $arr_data['delivery_date']??'' }}" readonly="" >&nbsp;&nbsp;</td>
		<td style="line-height:30px;border:1px solid #ccc;border-left:none">&nbsp;&nbsp;<strong style="">Slump:</strong><input type="text" name="slump" value="{{ $arr_data['cylinder_slump']??'' }}"  id="slump" class="form-control" data-rule-number="true" placeholder="Slump" data-rule-required="true">&nbsp;&nbsp;</td> 
		<td style="line-height:30px;border:1px solid #ccc;border-left:none">&nbsp;&nbsp;<strong style="">No Of Cylinder Tested:</strong><input type="text" value="{{ $arr_data['cylinder_no_of_cubes'] }}" name="no_of_cube_tested"  id="no_of_cube_tested" class="form-control" placeholder="No Of Cubes Tested" data-rule-number="true"  data-rule-required="true">&nbsp;&nbsp;</td>
	</tr>
	
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;border-top:none"><strong style="">&nbsp;&nbsp;Mix Code:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['product_details']['mix_code'] ?? '' }}</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Concrete Temp:&nbsp;&nbsp;</strong>Na</td> 
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Method Of Compaction:&nbsp;&nbsp;</strong><input type="text" name="compaction"  id="compaction" class="form-control" placeholder="Method Of Compaction" value="{{ $arr_data['cylinder_comp_method'] }}" data-rule-maxlength="255" data-rule-required="true"></td> 
	</tr>
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;border-top:none"><strong style="">&nbsp;&nbsp;Mix Desgin:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['product_details']['name'] ?? '' }}</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Air Content:&nbsp;&nbsp;</strong><input type="text" name="air_content"  id="air_content" class="form-control" placeholder="Air Content" value="{{ $arr_data['cylinder_air_content']??'' }}" data-rule-number="true" data-rule-required="true"></td> 
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">Sampled By:&nbsp;&nbsp;</strong><input type="text" name="sampled_by"  id="sampled_by" class="form-control" data-rule-maxlength="255" value="{{ $arr_data['cylinder_sampled_by'] }}" placeholder="Sampled By" data-rule-required="true"></td> 
	</tr>
</table>
<br>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:14px; font-family:'Arial', sans-serif;" id="strength_table">
		
		  <tr>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;font-size:13px;border-right:1px solid #ccc;">&nbsp;&nbsp;Spec.<br>No.</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">Date<br>Tested</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;font-size:13px;border-right:1px solid #ccc;">Age<br>Days</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-size:13px;border-right:1px solid #ccc;">Weight<br>Kg</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">S/Area<br>MM2</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">Height<br>MM</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-size:13px;font-family:'Arial', sans-serif;border-right:1px solid #ccc;">Density<br>(Kg/M³)</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-size:13px;border-right:1px solid #ccc;">M/Load<br>KN</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">C. Strength<br>MPa</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">Type Of Fraction</th>
		      <th class="no-print" style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">Action</th>
		  </tr>
		  @if(isset($arr_data['cube_details']) && count($arr_data['cube_details'])>0)

		  	@foreach($arr_data['cube_details'] as $key=>$cube_data)
		  		<?php
		  		$cube_id = $cube_data['id']??'';
		  		?>
		  		 <tr>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $key+1 }}</td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][date_tested]"   id="old_date_tested" class="form-control datepicker date_tested" placeholder="Date" value="{{ isset($cube_data['date_tested'])?date('d/m/Y',strtotime($cube_data['date_tested'])):'' }}" data-rule-required="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][age_days]" value="{{ $cube_data['age_days']??'' }}"  id="old_age_days" class="form-control age_days" placeholder="Age Days" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][weight]"  id="old_weight" class="form-control weight" placeholder="weight" value="{{ $cube_data['weight']??'' }}" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][s_area]"  id="old_sarea" class="form-control area" placeholder="S/Area" value="{{ $cube_data['s_area']??'' }}" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][height]" value="{{ $cube_data['height']??'' }}"  id="old_height" class="form-control height" placeholder="Height" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][density]" value="{{ $cube_data['density']??'' }}" id="old_density" class="form-control density" placeholder="Density" data-rule-required="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][m_load]" value="{{ $cube_data['m_load']??'' }}" id="old_mload" class="form-control mload" placeholder="M/Load" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][c_strength]" value="{{ $cube_data['c_strength']??'' }}"  id="old_cstrength" class="form-control cstrength" placeholder="C.Strength" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][fraction_type]"  id="old_fraction_type" class="form-control" value="{{ $cube_data['type_of_fraction']??'' }}" placeholder="Fraction Type" data-rule-required="true"></td>
			        <td class="no-print" style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;"><a href="{{ $module_url_path }}/delete_cube/{{ $cube_id }}/{{ $arr_data['delivery_no'] }}" >Delete</a></td>
			  	  </tr>

		  	@endforeach

		  @endif
		  <?php
		  $arr_edit = isset($arr_data['cube_details'])?$arr_data['cube_details']:[];
		  $index_no = count($arr_edit)+1;
		  ?>
		  <input type="hidden" name="index_no" id="index_no" value="{{ $index_no }}">
	  	  <tr>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $index_no }}</td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="date_tested[]"   id="date_tested" class="form-control datepicker date_tested" placeholder="Date" @if(empty($arr_edit)) data-rule-required="true" @endif></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="age_days[]"  id="age_days" class="form-control age_days" placeholder="Age Days" @if(empty($arr_edit)) data-rule-required="true" @endif data-rule-number="true"></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="weight[]"  id="weight" class="form-control weight" placeholder="weight" @if(empty($arr_edit)) data-rule-required="true" @endif data-rule-number="true"></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="sarea[]"  id="sarea" class="form-control area" placeholder="S/Area" @if(empty($arr_edit)) data-rule-required="true" @endif data-rule-number="true"></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="height[]"  id="height" class="form-control height" placeholder="Height" @if(empty($arr_edit)) data-rule-required="true" @endif data-rule-number="true"></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="density[]"  id="density" class="form-control density" placeholder="Density" @if(empty($arr_edit)) data-rule-required="true" @endif></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="mload[]"  id="mload" class="form-control mload" placeholder="M/Load" @if(empty($arr_edit)) data-rule-required="true" @endif data-rule-number="true"></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cstrength[]"  id="cstrength" class="form-control cstrength" placeholder="C.Strength" @if(empty($arr_edit)) data-rule-required="true" @endif data-rule-number="true"></td>
	        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="fraction_type[]"  id="fraction_type" class="form-control" placeholder="Fraction Type" @if(empty($arr_edit)) data-rule-required="true" @endif></td>
	        <td class="no-print" style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;"><a class="add-strength">Add</a></td>
	  	  </tr>
	  	

		


</table>
<table>
	    <tr>
		  	<td colspan="10" style="line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;">&nbsp;</td>
		</tr>
		<div id="avg_html_div"></div>
	
		@if(isset($arr_data['cylinder_avg_at_days']) && $arr_data['cylinder_avg_at_days']!="")
		 <?php 
			$arr_avg_days = json_decode($arr_data['cylinder_avg_at_days'],true); 
		 ?> 
			@if(isset($arr_avg_days) && count($arr_avg_days)>0)
				@foreach($arr_avg_days as $days=>$avg_days)
					<?php
						$avg  = number_format($avg_days['cstrength']/$avg_days['count'],2);
					?>
					<tr class="exist_avg_days">
					  	<td colspan="3" style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;text-align:right;background-color: #d3d0de;">&nbsp;&nbsp;<strong>Average At {{ $days }} Days</strong>&nbsp;&nbsp;</td>
				        <td colspan="3" style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $avg }} Mpa</td>
				  	</tr>
				@endforeach
			@endif
		@endif

	  	<tr>
		  <td colspan="10" style="line-height:15px;">&nbsp;</td>
	    </tr>
		  
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:14px; font-family:'Arial', sans-serif;">	
		<tr>
		  	<td colspan="2" style="line-height:30px;">&nbsp;&nbsp;<strong>Remark: </strong></td>
	  	</tr>
	  	<tr>
		  <td colspan="2" style="line-height:15px;">&nbsp;</td>
		</tr>
		<tr>
		   <td colspan="2" style="line-height:20px;height:20px;">&nbsp;&nbsp;The Required Strength at 7 day is 75% from the target.&nbsp;&nbsp;</td>
		</tr>
		 
		  
		<tr><td colspan="2" style="line-height:50px;">&nbsp;</td></tr>
		<tr><td style="width:50%">&nbsp;&nbsp;</td> 
		      <td style="">&nbsp;&nbsp;<strong>Q.C. Mngr.&nbsp;&nbsp;</strong>&nbsp;&nbsp;Mohamed Al-Tohami </td>
		</tr>
		<tr>
		  <td colspan="2" style="line-height:15px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:right;">&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #ccc;margin-bottom:8px;display:block;width:50%;">&nbsp;&nbsp;<strong style="line-height:23px;">Signature:</strong></td> 
		</tr>
</table>
 <div class="text-center py-3 w-100">
<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded no-print">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
<button type="button" class="btn btn-secondary btn-rounded closeForm no-print">{{ trans('admin.cancel') }}</button>
</div>
</form>
<script type="text/javascript">
$(document).ready(function () 
{
	$(document).ready(function(){
    $('#frm_cube_id').validate();
  })
   $('.datepicker').datepicker({
   	format: 'dd/mm/yyyy'
   });
   var i=1;
   var index_no = parseInt($('#index_no').val())+1;
    $(".add-strength").click(function()
    {
        var html='';
        html+='<tr><td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;'+index_no+'</td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="date_tested['+i+']"  id="date_tested_'+i+'" class="form-control datepicker date_tested" placeholder="Date" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="age_days['+i+']"  id="age_days_'+i+'" class="form-control age_days" placeholder="Age Days" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="weight['+i+']"  id="weight_'+i+'" class="form-control weight" placeholder="weight" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="sarea['+i+']"  id="sarea_'+i+'" class="form-control area" placeholder="S/Area" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="height['+i+']"  id="height_'+i+'" class="form-control height" placeholder="Height" data-rule-required="true" data-rule-number="true"></td>';
        html+=' <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="density['+i+']"  id="density_'+i+'" class="form-control density" placeholder="Density" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="mload['+i+']"  id="mload_'+i+'" class="form-control mload" placeholder="M/Load" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cstrength['+i+']"  id="cstrength_'+i+'" class="form-control cstrength" placeholder="C.Strength" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="fraction_type['+i+']"  id="fraction_type_'+i+'" class="form-control" placeholder="Fraction Type" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;"><a class="remove-strength no-print">Remove</a></td></tr>';

        $("#strength_table").append(html);
        $('#strength_table').find(".datepicker").datepicker({});
        i++;
        index_no++;
    });
    $("#strength_table").on('click','.remove-strength',function(){
        $(this).parent().parent().remove();
    });

    $("#strength_table").on('change','.date_tested',function(){

    var currentRow = $(this).closest("tr");
	var currentDateTested   = $(this).val(); 
	/*var form = $('#frm_cube_id')[0];
    var data = new FormData(form);
    data.append('current_date_tested',currentDateTested);
    $.ajax({
            type: "POST",
            url: "{{ $module_url_path }}/get_valid_date",
            data:data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(response_date){
            	
              currentRow.find(".date_tested").val(response_date);
            }
        }); */

	});

	 $("#strength_table").on('change','.weight',function(){
	 	var curr_weight=0;
	 	var weight   = $(this).val(); 
	 	if(weight>0)
	 	{
	 		curr_weight = weight-0.012;
	 		$(this).val(curr_weight.toFixed(3));
	 	}
	 	var currentRow = $(this).closest("tr");
	 	calculate_density(currentRow);

	 });

	 $("#strength_table").on('change','.height',function(){

	 	var currentRow = $(this).closest("tr");
	 	calculate_density(currentRow);

	 });
	 $("#strength_table").on('change','.area',function(){

	 	var currentRow = $(this).closest("tr");
	 	calculate_density(currentRow);

	 });
	 $("#strength_table").on('change','.mload',function(){

	 	var currentRow = $(this).closest("tr");
	 	var mload = $(this).val();
	 	var c_strength = parseFloat(mload*1000/22500);
	 	currentRow.find(".cstrength").val(c_strength.toFixed(3));
	 	  calculate_avg_days();
	 });

	  $("#strength_table").on('change','.age_days',function(){

	  	calculate_avg_days();
	  });

	 
});
function calculate_density(currentRow)
{

     var weight = parseFloat(currentRow.find(".weight").val()); 
     var area   = parseFloat(currentRow.find(".area").val()); 
     var height = parseFloat(currentRow.find(".height").val()); 
     if(!isNaN(weight) && !isNaN(area) && !isNaN(height))
     {
     	//var density = parseFloat(weight/((area*height))/1000000000);
     	//currentRow.find(".density").val(density);
     	$.ajax({
            type: "GET",
            url: "{{ $module_url_path }}/calculate_density",
            data:{weight:weight,area:area,height:height},
            success: function(cal_density){
            	currentRow.find(".density").val(cal_density);
            }
        }); 
     }
   
}
function calculate_avg_days()
{

	var form = $('#frm_cube_id')[0];
    var data = new FormData(form);
    $.ajax({
            type: "POST",
            url: "{{ $module_url_path }}/calculate_avg_days",
            data:data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(response){
            	//$('.exist_avg_days').hide();
            	$('#avg_html_div').html(response);
            }
        }); 
}
</script>
<style type="text/css">
	.remove-strength{cursor:pointer;}
	.add-strength{cursor:pointer;}
	.table-input{width:100%}
	.table-input .form-control{border:none;width:auto;height: 30px;display: inline-block;border-radius:0;padding: 0;}
	.table-input.s-input .form-control{width:90px;}
	.table-input th{text-align:center;font-weight: 500;}
	@media print {	
  body,form{background-color:#fff!important;width:100%!important;}
  /*table{width:100%!important;}*/
 .page-wrapper{margin:0}
 th,td{font-size:14pt !important; font-family:'Arial', sans-serif;padding:2px;}


}
</style>

<form method="post" id="frm_cube_id" name="frm_cube_id" action="{{ $module_url_path }}/store">
{{ csrf_field() }}

<input type="hidden" name="delivery_id" value="{{ $arr_data['id']??'' }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;border:1px solid #ccc;border-bottom:none">
	<tr>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;"><strong style="">&nbsp;&nbsp;{{ trans('admin.client') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['cust_details']['first_name'] ?? '' }} {{ $arr_data['order_details']['order']['cust_details']['last_name'] ?? '' }}&nbsp;&nbsp;</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.site') }}:</strong> {{ $arr_data['order_details']['order']['contract']['site_location'] ?? '' }}&nbsp;&nbsp;</td> 
	</tr>
	<tr>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;"><strong style="">&nbsp;&nbsp;{{ trans('admin.consultant') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['sales_agent_details']['first_name'] ?? '' }} {{ $arr_data['order_details']['order']['sales_agent_details']['last_name'] ?? '' }}</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.project') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['title'] ?? '' }}</td> 
	</tr>

</table>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;">
	<tr><td colspan="3" style=""><strong style="line-height:30px">{{ trans('admin.required_concrete_mix_specification') }}:</strong></td> </tr>
	<tr>
		<td colspan="2" style="line-height:30px;border:1px solid #ccc;"><strong style="">&nbsp;&nbsp;{{ trans('admin.compressive_strength_on_cube') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['compressive_strength'] ?? '' }}&nbsp;&nbsp;</td>
		<td style="line-height:30px;border:1px solid #ccc;border-left:none">&nbsp;&nbsp;<strong style="">{{ trans('admin.structure_element') }}:</strong>{{ $arr_data['order_details']['order']['contract']['structure_element'] ?? '' }}&nbsp;&nbsp;</td> 
	</tr>
	
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;border-top:none"><strong style="">&nbsp;&nbsp;{{ trans('admin.slump') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['slump'] ?? '' }} mm</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.concrete_temp') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['concrete_temp'] ?? '' }} °C</td> 
		<td style="line-height:30px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.quantity') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['order']['contract']['quantity'] ?? '' }}</td> 
	</tr>
</table>

<br>
<table class="table-input" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;">
	<tr><td colspan="3" style=""><strong style="line-height:30px">{{ trans('admin.sampling') }}:</strong></td> </tr>
	<tr>
		<td class="" style="line-height:30px;border:1px solid #ccc;"><strong style="">&nbsp;&nbsp;{{ trans('admin.delivery') }} {{ trans('admin.date') }}:&nbsp;&nbsp;</strong><input type="text" name="delivery_date"  id="delivery_date" class="form-control" value="{{ $arr_data['delivery_date']??'' }}" readonly="" >&nbsp;&nbsp;</td>
		<td style="line-height:30px;border:1px solid #ccc;border-left:none">&nbsp;&nbsp;<strong style="">{{ trans('admin.slump') }}:</strong><input type="text" name="slump" value="{{ $arr_data['slump']??'' }}"  id="slump" class="form-control" data-rule-number="true" placeholder="Slump" data-rule-required="true">&nbsp;&nbsp;</td> 
		<td style="line-height:30px;border:1px solid #ccc;border-left:none">&nbsp;&nbsp;<strong style="">{{ trans('admin.no_of_cubes_tested') }}:</strong><input type="text" value="{{ $arr_data['no_of_cubes'] }}" name="no_of_cube_tested"  id="no_of_cube_tested" onchange="addCube(this.value)" class="form-control" placeholder="No Of Cubes Tested" data-rule-number="true"  data-rule-required="true">&nbsp;&nbsp;</td>
	</tr>
	
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;border-top:none"><strong style="">&nbsp;&nbsp;{{ trans('admin.mix_code') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['product_details']['mix_code'] ?? '' }}</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.concrete_temp') }}:&nbsp;&nbsp;</strong>Na</td> 
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.method_of_compaction') }}:&nbsp;&nbsp;</strong><input type="text" name="compaction"  id="compaction" class="form-control" placeholder="Method Of Compaction" value="Manual" readonly="" data-rule-maxlength="255" data-rule-required="true"></td> 
	</tr>
	<tr>
		<td style="line-height:30px;border:1px solid #ccc;border-top:none"><strong style="">&nbsp;&nbsp;{{ trans('admin.mix_design') }}:&nbsp;&nbsp;</strong>{{ $arr_data['order_details']['product_details']['name'] ?? '' }}</td>
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.air_content') }}:&nbsp;&nbsp;</strong><input type="text" name="air_content"  id="air_content" class="form-control" placeholder="Air Content" value="{{ $arr_data['air_content']??'' }}" data-rule-number="true" data-rule-required="true"></td> 
		<td style="line-height:30px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="">{{ trans('admin.sampled_by') }}:&nbsp;&nbsp;</strong><input type="text" name="sampled_by"  id="sampled_by" class="form-control" data-rule-maxlength="255" value="PWR Tech" placeholder="Sampled By" readonly="" data-rule-required="true"></td> 
	</tr>
</table>
<br>
<div class="table-responsive">
<table class="table-input s-input" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:14px; font-family:'Arial', sans-serif;" id="strength_table">
		
		  <tr>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;font-size:13px;border-right:1px solid #ccc;">&nbsp;&nbsp;{{ trans('admin.spec_no') }}<br>.</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.date') }}<br>{{ trans('admin.tested') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.age') }}<br>{{ trans('admin.days') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.weight') }}<br>{{ trans('admin.kg') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.s_area') }}<br>{{ trans('admin.mm2') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.height') }}<br>{{ trans('admin.mm') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-size:13px;font-family:'Arial', sans-serif;border-right:1px solid #ccc;">{{ trans('admin.density') }}<br>{{ trans('admin.Kg/M³') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.m_load') }}<br>{{ trans('admin.kn') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.c_strength') }}<br>{{ trans('admin.Kg/CM2') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.c_strength') }}<br>{{ trans('admin.MPa') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;font-size:13px;border-right:1px solid #ccc;">{{ trans('admin.type_of_fraction') }}</th>
		    
		  </tr>
		  @if(isset($arr_data['cube_details']) && count($arr_data['cube_details'])>0)

		  	@foreach($arr_data['cube_details'] as $key=>$cube_data)
		  		<?php
		  		$cube_id = $cube_data['id']??'';
		  		?>
		  		 <tr>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $key+1 }}</td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][date_tested]"   id="old_date_tested_{{ $key }}" class="form-control datepicker date_tested" placeholder="Date" value="{{ isset($cube_data['date_tested'])?date('d/m/Y',strtotime($cube_data['date_tested'])):'' }}" data-rule-required="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][age_days]" value="{{ $cube_data['age_days']??'' }}"  id="old_age_days_{{ $key }}" class="form-control age_days" placeholder="Age Days" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][weight]"  id="old_weight_{{ $key }}" class="form-control weight" placeholder="weight" value="{{ $cube_data['weight']??'' }}" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][s_area]"  id="old_sarea_{{ $key }}" class="form-control area" placeholder="S/Area" value="{{ $cube_data['s_area']??'' }}" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][height]" value="{{ $cube_data['height']??'' }}"  id="old_height_{{ $key }}" class="form-control height" placeholder="Height" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][density]" value="{{ $cube_data['density']??'' }}" id="old_density_{{ $key }}" class="form-control density" placeholder="Density" data-rule-required="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][m_load]" value="{{ $cube_data['m_load']??'' }}" id="old_mload_{{ $key }}" class="form-control mload" placeholder="M/Load" data-rule-required="true" data-rule-number="true"></td>
			         <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][c_strength_kg]" value="{{ $cube_data['c_strength_kg']??'' }}"  id="old_cstrength_kg_{{ $key }}" class="form-control cstrength" placeholder="C.Strength kg" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][c_strength]" value="{{ $cube_data['c_strength']??'' }}"  id="old_cstrength_{{ $key }}" class="form-control cstrength" placeholder="C.Strength" data-rule-required="true" data-rule-number="true"></td>
			        <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cube_data[{{ $cube_id }}][fraction_type]"  id="old_fraction_type_{{ $key }}" class="form-control" value="{{ $cube_data['type_of_fraction']??'' }}" placeholder="Fraction Type" data-rule-required="true"></td>
			     
			  	  </tr>

		  	@endforeach

		  @endif
		  <?php
		  $arr_edit = isset($arr_data['cube_details'])?$arr_data['cube_details']:[];
		  $index_no = count($arr_edit)+1;
		  ?>
		  <input type="hidden" name="index_no" id="index_no" value="{{ $index_no }}">

</table>
</div>
<table>
	    <tr>
		  	<td colspan="10" style="line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;">&nbsp;</td>
		</tr>
		<div id="avg_html_div"></div>
	
		@if(isset($arr_data['avg_at_days']) && $arr_data['avg_at_days']!="")
		 <?php 
			$arr_avg_days = json_decode($arr_data['avg_at_days'],true); 
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
		  	<td colspan="2" style="line-height:30px;">&nbsp;&nbsp;<strong>{{ trans('admin.remark') }}: </strong></td>
	  	</tr>
	  	<tr>
		  <td colspan="2" style="line-height:15px;">&nbsp;</td>
		</tr>
		<tr>
		   <td colspan="2" style="line-height:20px;height:20px;">&nbsp;&nbsp;{{ trans('admin.cube_remark') }}.&nbsp;&nbsp;</td>
		</tr>
		 
		  
		<tr><td colspan="2" style="line-height:50px;">&nbsp;</td></tr>
		<tr><td style="width:50%">&nbsp;&nbsp;</td> 
		      <td style="">&nbsp;&nbsp;<strong>{{ trans('admin.qc_mngr') }}.&nbsp;&nbsp;</strong>&nbsp;&nbsp;Mohamed Al-Tohami </td>
		</tr>
		<tr>
		  <td colspan="2" style="line-height:15px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="text-align:right;">&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #ccc;margin-bottom:8px;display:block;width:50%;">&nbsp;&nbsp;<strong style="line-height:23px;">{{ trans('admin.signature') }}:</strong></td> 
		</tr>
</table>
</div>
<input type="hidden" name="date_1" id="date_1">
<input type="hidden" name="date_2" id="date_2">
<div class="text-center py-3 w-100 no-print">
<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>

</form>
<script type="text/javascript">
$(document).ready(function () 
{
	
	if($('#no_of_cube_tested').val()>0)
	{
		addCube($('#no_of_cube_tested').val());
	}
 
   $('#frm_cube_id').validate();
   $('.datepicker').datepicker({
   	format: 'dd/mm/yyyy'
   });
   
    $("#strength_table").on('click','.remove-strength',function(){
        $(this).parent().parent().remove();
    });

    $("#strength_table").on('change','.date_tested',function(){

    var currentRow = $(this).closest("tr");
	var currentDateTested   = $(this).val(); 
	
	});

	 $("#strength_table").on('change','.weight',function(){
	 	var currentRow = $(this).closest("tr");
	 	calculate_density(currentRow);

	 });

	
	 $("#strength_table").on('change','.mload',function(){

	 	var currentRow = $(this).closest("tr");
	 	var mload = $(this).val();
	 	var c_strength   = parseFloat(mload*1000/22500);
	 	var cstrength_kg = mload*0.453;
	 	currentRow.find(".cstrength").val(c_strength.toFixed(3));
	 	currentRow.find(".cstrength_kg").val(cstrength_kg.toFixed(3));
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
     	/*var density = parseFloat(weight/((area*height))/1000000000);
     	var mod_density =  density.split('e')[0];
     	*/
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
            	$('.exist_avg_days').hide();
            	$('#avg_html_div').html(response);
            }
        }); 
}
function getCalculatedDays()
{
	var delivery_date = $('#delivery_date').val();
	var response = '';
	$.ajax({
            type: "GET",
            url: "{{ $module_url_path }}/calculate_tested_date",
            data:{delivery_date:delivery_date},
            success: function(data){
            	$('#date_1').val(data.first_half_tested_date);
            	$('#date_2').val(data.second_half_tested_date);
            }
        }); 
	return response;
}
function addCube(no_of_cubes)
{

	var exist_no_of_cubes = "{{ $arr_data['no_of_cubes'] }}";
	var exist_rows = "{{ count($arr_data['cube_details']) }}";
	
	if(parseInt(no_of_cubes)<parseInt(exist_no_of_cubes))
	{
		alert('Please enter no greater than '+exist_no_of_cubes);
		return false;
	}
	var skip_rows = parseInt(exist_rows);
	if(skip_rows==0)
	{
		$("#strength_table").find("tr:gt(0)").remove();
	}
	else
	{
		//$("#strength_table").find("tr:gt(0)").remove();
		$("#strength_table").find("tr:gt('"+skip_rows+"')").remove();
	}

	if(no_of_cubes>0)
	{
		var date_1 = "{{ $first_half_tested_date??'' }}";
		var date_2 =  "{{ $second_half_tested_date??'' }}";
		var no_of_rows = no_of_cubes/2;
		if(exist_rows>0)
		{
			var exist_no_of_rows  = parseInt(no_of_cubes)-parseInt(exist_rows);
			var no_of_rows = exist_no_of_rows/2;
		}
		var half_rows  = no_of_rows.toFixed();
		for(i=0;i<parseInt(half_rows);i++)
		{
		 var index = parseInt(exist_rows)+i+1;
		 var html = "";
        html+='<tr><td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;'+index+'</td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" value="'+date_1+'" name="date_tested['+i+']"  id="date_tested_'+i+'" class="form-control datepicker date_tested" placeholder="Date" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="age_days['+i+']"  id="age_days_'+i+'" class="form-control age_days" value="7" placeholder="Age Days" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="weight['+i+']"  id="weight_'+i+'" class="form-control weight" placeholder="weight" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="sarea['+i+']"  id="sarea_'+i+'" class="form-control area" value="22500" readonly="" placeholder="S/Area" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="height['+i+']"  id="height_'+i+'" class="form-control height" value="150" readonly="" placeholder="Height" data-rule-required="true" data-rule-number="true"></td>';
        html+=' <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="density['+i+']"  id="density_'+i+'" class="form-control density" placeholder="Density" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="mload['+i+']"  id="mload_'+i+'" class="form-control mload" placeholder="M/Load" data-rule-required="true" data-rule-number="true"></td>';
         html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cstrengt_kg['+i+']"  id="cstrength_kg_'+i+'" class="form-control cstrength_kg" placeholder="C.Strength kg/CM2" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cstrength['+i+']"  id="cstrength_'+i+'" class="form-control cstrength" placeholder="C.Strength" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="fraction_type['+i+']"  id="fraction_type_'+i+'" class="form-control" readonly value="Satisfactory" placeholder="Fraction Type" data-rule-required="true"></td>';
    		
    		$("#strength_table").append(html);
     		$('#strength_table').find(".datepicker").datepicker({});
        
      }
      var k =0;
      for(j=1;j<=parseInt(half_rows);j++)
	  {
	  	  k=i+j;
	  	 var index = parseInt(exist_rows)+i+j;
		 var html = "";
        html+='<tr><td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;'+index+'</td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" value="'+date_2+'" name="date_tested['+k+']"  id="date_tested_'+k+'" class="form-control datepicker date_tested" placeholder="Date" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="age_days['+k+']"  id="age_days_'+k+'" class="form-control age_days" value="28" placeholder="Age Days" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="weight['+k+']"  id="weight_'+k+'" class="form-control weight" placeholder="weight" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="sarea['+k+']"  id="sarea_'+k+'" class="form-control area" value="22500" readonly="" placeholder="S/Area" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="height['+k+']"  id="height_'+k+'" class="form-control height" value="150" readonly="" placeholder="Height" data-rule-required="true" data-rule-number="true"></td>';
        html+=' <td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="density['+k+']"  id="density_'+k+'" class="form-control density" placeholder="Density" data-rule-required="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="mload['+k+']"  id="mload_'+k+'" class="form-control mload" placeholder="M/Load" data-rule-required="true" data-rule-number="true"></td>';
         html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cstrengt_kg['+k+']"  id="cstrength_kg_'+k+'" class="form-control cstrength_kg" placeholder="C.Strength kg/CM2" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="cstrength['+k+']"  id="cstrength_'+k+'" class="form-control cstrength" placeholder="C.Strength" data-rule-required="true" data-rule-number="true"></td>';
        html+='<td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<input type="text" name="fraction_type['+k+']"  id="fraction_type_'+k+'" class="form-control" readonly value="Satisfactory" placeholder="Fraction Type" data-rule-required="true"></td>';
    		
    		$("#strength_table").append(html);
     		$('#strength_table').find(".datepicker").datepicker({});
        
      }
      
	}
	else
	{
		alert('Inavlid No');
		return false;
	}
	
}
</script>
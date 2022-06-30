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

@if(isset($arr_data) && count($arr_data)>0)
@foreach($arr_data as $data)
<input type="hidden" name="delivery_id" value="{{ $data['id']??'' }}">
<br>
<table class="table-input" width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;">
	
	<tr>
		<td class="" style="line-height:30px;border:1px solid #ccc;"><strong style="">&nbsp;&nbsp;Delivery No:&nbsp;&nbsp;</strong>{{ $data['delivery_no']??'' }}&nbsp;&nbsp;</td>

		<td class="" style="line-height:30px;border:1px solid #ccc;"><strong style="">&nbsp;&nbsp;Delivery Date:&nbsp;&nbsp;</strong>{{ $data['delivery_date']??'' }}&nbsp;&nbsp;</td>	
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
		  @if(isset($data['cube_details']) && count($data['cube_details'])>0)

		  	@foreach($data['cube_details'] as $key=>$cube_data)
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
		  @else
		  	<tr><td style="line-height:30px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;No Data Found</td></tr>

		  @endif
		  

</table>
</div>
<table>
	    <tr>
		  	<td colspan="10" style="line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;">&nbsp;</td>
		</tr>
		<div id="avg_html_div"></div>
	
		@if(isset($data['avg_at_days']) && $data['avg_at_days']!="")
		 <?php 
			$arr_avg_days = json_decode($data['avg_at_days'],true); 
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
		@if(isset($arr_data['cylinder_avg_at_days']) && $arr_data['cylinder_avg_at_days']!="")
		 <?php 
			$arr_cylinder_avg_days = json_decode($arr_data['cylinder_avg_at_days'],true); 
		 ?> 
			@if(isset($arr_cylinder_avg_days) && count($arr_cylinder_avg_days)>0)
				@foreach($arr_cylinder_avg_days as $days=>$avg_days)
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
@endforeach
@endif

<script type="text/javascript">

</script>
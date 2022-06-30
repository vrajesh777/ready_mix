 <div class="card-body px-0 d-flex">
	    <div class="table-responsive">
			<table class="table table-nowrap table-bordered">
	    		<tr><td colspan="2" class="bg-light"><b>All</b></td></tr>
	    		<tr>
	    			<td>Total Ordered </td>
	    			<td>{{ isset($arr_pump_data['total_orders'])&& $arr_pump_data['total_orders']!=""?$arr_pump_data['total_orders']:0 }} </td>
	    		</tr>
	    		<tr>
	    			<td>Delivered </td>
	    			<td>{{ isset($arr_pump_data['tot_delivered_qty'])&& $arr_pump_data['tot_delivered_qty']!=""?$arr_pump_data['tot_delivered_qty']:0 }}</td>
	    		</tr>
	    		<tr>
	    			<td>Remaining </td>
	    			<td>{{ isset($arr_pump_data['tot_remaing_qty'])&& $arr_pump_data['tot_remaing_qty']!=""?$arr_pump_data['tot_remaing_qty']:0 }}</td>
	    	
	    		</tr>
	    		<!-- <tr><td class="border-0" style="line-height:30px"></td></tr> -->	    			
	    	</table>
		</div>
		<div class="table-responsive ml-3">
			<table class="table table-nowrap table-bordered">
			    @if(isset($arr_pump_data['arr_final_data']) && count($arr_pump_data['arr_final_data'])>0)
		    	@foreach($arr_pump_data['arr_final_data'] as $key=>$row)
		    	
	    		<tr>
	    			<td colspan="2" class="bg-light"><b>Pump {{ $key ?? 0 }} :</b></td>
	    		</tr>
	    		<tr>
	    			<td>Total Ordered </td>
	    			<td>{{ $row['total_qty']??0 }}</td>
	    		</tr>
	    		<tr>
	    			<td>Delivered </td>
	    			<td>{{ $row['tot_delivered_quant']??0 }}</td>
	    		</tr>
	    		<tr>
	    			<td>Remaining </td>
	    			<td>{{ $row['remain_qty']??0 }}</td>
	    		</tr>

		    	@endforeach
				@endif
			</table>
		</div>
</div>
<div class="card-body p-0">
	<div class="row">
	   <div class="col-md-6 m-0 mt-md-0 mt-sm-2">
		     <div id="total_pump_pie_chart_id"></div>
	   </div>
	  <div class="col-md-6 m-0 mt-md-0 mt-sm-2">
	    <div id="pump_bar_chart_id"></div>
	 </div>
	</div>
</div>

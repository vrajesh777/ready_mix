@extends('layout.master')
@section('main_content')
<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');

	$sales_start_date = \Carbon::parse($sales_start_date??'')->format('d/m/Y');
	$sales_end_date = \Carbon::parse($sales_end_date??'')->format('d/m/Y');


	$pump_start_date = \Carbon::parse($pump_start_date??'')->format('d/m/Y');
	$pump_end_date   = \Carbon::parse($pump_end_date??'')->format('d/m/Y');

	$excess_start_date = \Carbon::parse($excess_start_date??'')->format('d/m/Y');
	$excess_end_date   = \Carbon::parse($excess_end_date??'')->format('d/m/Y');
?>

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />
<!-- Page Header -->
<div class="crms-title row bg-white mb-4">
	<div class="col">
		<h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
          <i class="fal fa-table"></i>
        </span> <span>Deals Dashboard</span></h3>
	</div>
	<div class="col text-right">
		<ul class="breadcrumb bg-white float-right m-0 pl-0 pr-0">
			<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
			<li class="breadcrumb-item active">Deals Dashboard</li>
		</ul>
	</div>
</div>
<!-- /Page Header -->

<div class="row graphs">
	<div class="col-md-12">
		@include('dashboard.delivery_orders')
	</div>
	
</div>
<form id="frmDashbaord">
<div class="row graphs">
	<div class="col-md-6">
		<div class="card h-100">
			<div class="card-body">
            	<h3 class="card-title">Pumps</h3>

            	 <div class="card-header">  
					<div class="row align-items-top">
						<div class="col-md-5">
							<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
						</div>
					
				    </div>			    </div>
			    <div class="card-body">
			    	<table>
			    		<tr><td><b>All</b></td></tr>
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
			    		
			    	@if(isset($arr_pump_data['arr_orders']) && count($arr_pump_data['arr_orders'])>0)
			    	@foreach($arr_pump_data['arr_orders'] as $row)
			    	<?php

			    			   $tot_delivered_quant = $tot_int_rejected_qty = $tot_cust_rejected_qty = $cancelled_qty = $delivered_quant = $total_qty=0;

								$order     = $row['order']??[];
								$del_notes = $row['del_notes'] ?? [];
								
								foreach ($del_notes as $del_key => $del_val) 
								{
									if($del_val['reject_by']!='' && $del_val['reject_by'] == '1')
									{
										$tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
									}
									elseif($del_val['reject_by']!='' && $del_val['reject_by'] == '2')
									{
										$tot_cust_rejected_qty += $del_val['reject_qty'] ?? 0;
										$tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
									}

									if($del_val['status'] == 'cancelled'){
										$cancelled_qty += $del_val['quantity'] ?? 0;
									}

									if($del_val['status'] != 'cancelled'){
										$delivered_quant += $del_val['quantity'] ?? 0;
									}
								}

								$tot_delivered_quant = $delivered_quant - $tot_int_rejected_qty;

								$remain_qty = $row['quantity'] - $tot_delivered_quant - $cancelled_qty;

								if($row['edit_quantity']!='')
								{
									$remain_qty = $row['edit_quantity'] - $tot_delivered_quant - $cancelled_qty;
								}

								if(isset($row['edit_quantity']) && $row['edit_quantity']!=''){
									$total_qty = ($row['edit_quantity'] ?? 0) - $cancelled_qty;
								}
								else{
									$total_qty = ($row['quantity'] ?? 0) - $cancelled_qty;
								}
							?>
			    		<tr>
			    			<td><b>Pump {{ $order['pump'] ?? 0 }} :</b></td>
			    		</tr>
			    		<tr>
			    			<td>Total Ordered </td>
			    			<td>{{ $total_qty??0 }}</td>
			    		</tr>
			    		<tr>
			    			<td>Delivered </td>
			    			<td>{{ $tot_delivered_quant??0 }}</td>
			    		</tr>
			    		<tr>
			    			<td>Remaining </td>
			    			<td>{{ $remain_qty??0 }}</td>
			    		</tr>

			    	@endforeach
					@endif			    			
			    	</table>
					
					
			    </div>
        	</div>
		</div>
	</div>
	<div class="col-md-6">
		
		<div class="card h-100">
            <div class="card-body">
            	<h3 class="card-title">Sales</h3>
            	 <div class="card-header">
		
					<div class="row align-items-top">
						<div class="col-md-5">
							<input type="text" name="salesdateRange" class="form-control text-center" id="salesdateRange" value="" >
						</div>
					
				   </div>
				   <div class="card-body">
			    	  <table>
			    		
			    		<tr>
			    			<td>Total Sales </td>
			    			<td>{{ $arr_sales_data['total_sales']??0 }} </td>
			    		</tr>
			    		<tr>
			    			<td>Invoice Amount </td>
			    			<td>{{ $arr_sales_data['invoice_amount']??0 }} </td>
			    		</tr>
			    		<tr>
			    			<td>Need to collect </td>
			    			<td>{{ $arr_sales_data['need_to_collect']??0 }} </td>
			    		</tr>
			    		</table>
				    </div>
			
			    </div>
           
            </div>
        </div>
	</div>
	<!-- <div class="col-md-4">
		
		<div class="card h-100">
            <div class="card-body">
            	<h3 class="card-title">Customers</h3>
            
            </div>
        </div>
	</div> -->
</div>
<div class="row graphs">
	<div class="col-md-6">
		<div class="card h-100">
			<div class="card-body">
            	<h3 class="card-title">Customer Rejected Pumps</h3>

            	 <div class="card-header">
				
					<div class="row align-items-top">
						<div class="col-md-5">
							<input type="text" name="rejPumpDateRange" class="form-control text-center" id="rejPumpDateRange" value="" >
						</div>
					
				    </div>
		
			    </div>
			    <div class="card-body">
			    	<table>
			    		
			    		<tr>
			    			<td>Cust Rejected </td>
			    			<td>{{ isset($arr_rej_pump_data['pump_tot_cust_rejected_qty'])&& $arr_rej_pump_data['pump_tot_cust_rejected_qty']!=""?$arr_rej_pump_data['pump_tot_cust_rejected_qty']:0 }} </td>
			    		</tr>
			    		<tr>
			    			<td>Int Rejected </td>
			    			<td>{{ isset($arr_rej_pump_data['pump_tot_int_rejected_qty'])&& $arr_rej_pump_data['pump_tot_int_rejected_qty']!=""?$arr_rej_pump_data['pump_tot_int_rejected_qty']:0 }}</>
			    		</tr>
			    		
			    		
			    	@if(isset($arr_rej_pump_data['arr_pump_orders']) && count($arr_rej_pump_data['arr_pump_orders'])>0)
			    	@foreach($arr_rej_pump_data['arr_pump_orders'] as $del_val)
			    	<?php

			    			   $tot_delivered_quant = $tot_int_rejected_qty = $tot_cust_rejected_qty = $cancelled_qty = $delivered_quant = $total_qty=0;
								
								if($del_val['reject_by']!='' && $del_val['reject_by'] == '1')
								{
									$tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
								}
								elseif($del_val['reject_by']!='' && $del_val['reject_by'] == '2')
								{
									$tot_cust_rejected_qty += $del_val['reject_qty'] ?? 0;
									$tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
								}

							?>
						@if($tot_int_rejected_qty!=0 || $tot_cust_rejected_qty!=0)
			    		<tr>
			    			<td><b>Pump {{ $del_val['pump'] ?? 0 }} :</b></td>
			    		</tr>
			    		<tr>
			    			<td>Cust Rejected </td>
			    			<td>{{ $tot_cust_rejected_qty??0 }}</td>
			    		</tr>
			    		<tr>
			    			<td>Int Rejected </td>
			    			<td>{{ $tot_int_rejected_qty??0 }}</td>
			    		</tr>
			    		@endif

			    	@endforeach
					@endif			    			
			    	</table>
					
					
			    </div>
        	</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card h-100">
			<div class="card-body">
            	<h3 class="card-title">Excess/Resell</h3>
            	 <div class="card-header">
				 
					<div class="row align-items-top">
						<div class="col-md-5">
							<input type="text" name="exccessDateRange" class="form-control text-center" id="exccessDateRange" value="" >
						</div>
						Total Excess/Resell : {{ $total_excess??0 }} (m3)
				    </div>
			 
            </div>
         </div>
    </div>
</div>	
	<!-- <div class="col-md-4">
		
		<div class="card h-100">
            <div class="card-body">
            	<h3 class="card-title">Customers</h3>
            
            </div>
        </div>
	</div> -->
</div>
</form>
<script src="{{ asset('/js/raphael.min.js') }}"></script>
<script src="{{ asset('/js/chart.js') }}"></script>
<script src="{{ asset('/js/linebar.min.js') }}"></script>
<script src="{{ asset('/js/piechart.js') }}"></script>
<script src="{{ asset('/js/apex.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sdt??''}}',
		    endDate: '{{$edt??''}}'
		})
		.on('changeDate', function(e) {
			$("#frmDashbaord").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$("#salesdateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sales_start_date??''}}',
		    endDate: '{{$sales_end_date??''}}'
		})
		.on('changeDate', function(e) {
			$("#frmDashbaord").submit();
		});
		$("#salesdateRange").change(function(){
			$('#salesdateRange').trigger('changeDate');
		});

		$("#rejPumpDateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$pump_start_date??''}}',
		    endDate: '{{$pump_end_date??''}}',
		     drops: 'up'
		})
		.on('changeDate', function(e) {
			$("#frmDashbaord").submit();
		});

		$("#rejPumpDateRange").change(function(){
			$('#rejPumpDateRange').trigger('changeDate');
		});

		$("#exccessDateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$excess_start_date??''}}',
		    endDate: '{{$excess_end_date??''}}',
		     drops: 'up'
		})
		.on('changeDate', function(e) {
			$("#frmDashbaord").submit();
		});

		$("#exccessDateRange").change(function(){
			$('#exccessDateRange').trigger('changeDate');
		});
	})
</script>
@stop
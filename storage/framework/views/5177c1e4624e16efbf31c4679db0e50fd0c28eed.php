<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');

	$sales_start_date = \Carbon::parse($sales_start_date??'')->format('d/m/Y');
	$sales_end_date = \Carbon::parse($sales_end_date??'')->format('d/m/Y');


	$pump_start_date = \Carbon::parse($pump_start_date??'')->format('d/m/Y');
	$pump_end_date   = \Carbon::parse($pump_end_date??'')->format('d/m/Y');

	$excess_start_date = \Carbon::parse($excess_start_date??'')->format('d/m/Y');
	$excess_end_date   = \Carbon::parse($excess_end_date??'')->format('d/m/Y');

	$booking_start_date = \Carbon::parse($booking_start_date??'')->format('d/m/Y');
	$booking_end_date   = \Carbon::parse($booking_end_date??'')->format('d/m/Y');
?>
<input type="hidden" name="sdt" id="sdt" value="<?php echo e($sdt); ?>"> 
<input type="hidden" name="edt" id="edt" value="<?php echo e($edt); ?>"> 

<input type="hidden" name="sales_start_date" id="sales_start_date" value="<?php echo e($sales_start_date); ?>"> 
<input type="hidden" name="sales_end_date" id="sales_end_date" value="<?php echo e($sales_end_date); ?>"> 

<input type="hidden" name="pump_start_date" id="pump_start_date" value="<?php echo e($pump_start_date); ?>"> 
<input type="hidden" name="pump_end_date" id="pump_end_date" value="<?php echo e($pump_end_date); ?>"> 

<input type="hidden" name="excess_start_date" id="excess_start_date" value="<?php echo e($excess_start_date); ?>"> 
<input type="hidden" name="excess_end_date" id="excess_end_date" value="<?php echo e($excess_end_date); ?>"> 

<input type="hidden" name="booking_start_date" id="booking_start_date" value="<?php echo e($booking_start_date); ?>"> 
<input type="hidden" name="booking_end_date" id="booking_end_date" value="<?php echo e($booking_end_date); ?>"> 

<input type="hidden" name="pump_chart_str" id="pump_chart_str" value="<?php echo e($pump_chart_str??''); ?>"> 
<input type="hidden" name="rej_pump_chart_str" id="rej_pump_chart_str" value="<?php echo e($rej_pump_chart_str??''); ?>"> 
<input type="hidden" name="booking_statement_str" id="booking_statement_str" value="<?php echo e($booking_statement_str??''); ?>"> 

<div class="row graphs">
	<div class="col-md-12">
		<?php echo $__env->make('dashboard.delivery_orders', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>	
</div>
<form id="frmDashbaord">
<div class="row graphs">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
            	 <div class="card-header p-0 pb-2">  
					<div class="row align-items-center justify-content-between">
						<h3 class="col-md-5 card-title m-0">Pumps</h3>
						<div class="col-md-4 col-xl-3">
						<div class="position-relative mt-md-0 mt-sm-2">
							<input type="text" name="dateRange" class="form-control" id="dateRange" value="" >
							<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
						</div>
						</div>
				    </div>			    
				</div>
			    <?php echo $__env->make('dashboard.pumps_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        	</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="card h-100">
            <div class="card-body">
            	 <div class="card-header p-0 pb-2">
					<div class="row align-items-center justify-content-between">
						<h3 class="col-md-5 card-title m-0">Sales</h3>
						<div class="col-md-7 col-xl-6">
							<div class="position-relative mt-md-0 mt-sm-2">
								<input type="text" name="salesdateRange" class="form-control" id="salesdateRange" value="" >
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
							</div>
						</div>
				   </div>
				   </div>
				   <div class="card-body table-responsive px-0">
			    	    <table class="table table-nowrap table-bordered mb-0">
				    		<tr>
				    			<td>Total Sales </td>
				    			<td><?php echo e($arr_sales_data['total_sales']??0); ?> </td>
				    		</tr>
				    		<tr>
				    			<td>Invoice Amount </td>
				    			<td><?php echo e($arr_sales_data['invoice_amount']??0); ?> </td>
				    		</tr>
				    		<tr>
				    			<td>Need to collect </td>
				    			<td><?php echo e($arr_sales_data['need_to_collect']??0); ?> </td>
				    		</tr>
			    		</table>
				    </div>
				     <div class="card-body">
				     	<div id="total_sales_pie_chart_id"></div>
				     </div>
			
			    
           
            </div>
        </div>
	</div>
	<div class="col-md-6">
		<div class="card h-100">
			<div class="card-body">
            	<div class="card-header p-0 pb-2">
					<div class="row align-items-center justify-content-between">
            			<h3 class="col-md-5 card-title m-0">Excess/Resell</h3>
						<div class="col-md-7 col-xl-6">
							<div class="position-relative mt-md-0 mt-sm-2">
								<input type="text" name="exccessDateRange" class="form-control" id="exccessDateRange" value="" >
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
							</div>
						</div>
				    </div>	
	            </div>
	            <h3 class="text-center my-5">Total Excess/Resell : <?php echo e($total_excess??0); ?> (m3)</h3>
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
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
            	 <div class="card-header p-0 pb-2">
					<div class="row align-items-center justify-content-between">
            			<h3 class="col-md-5 card-title m-0">Customer Rejected</h3>
						<div class="col-md-4 col-xl-3">
							<div class="position-relative mt-md-0 mt-sm-2">
								<input type="text" name="rejPumpDateRange" class="form-control" id="rejPumpDateRange" value="" >
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
							</div>
						</div>
					
				    </div>
		
			    </div>
			    <div class="card-body px-0 d-flex">
			    	<div class="table-responsive">
				    	<table class="table table-nowrap table-bordered">
				    		<tr>
				    			<td>Cust Rejected </td>
				    			<td><?php echo e($arr_rej_pump_data['glob_cust_rejected_qty']??0); ?> </td>
				    		</tr>
				    		<tr>
				    			<td>Int Rejected </td>
				    			<td><?php echo e($arr_rej_pump_data['glob_int_rejected_qty']??0); ?></>
				    		</tr>		    			
				    	</table>
			    	</div>
			    	<div class="table-responsive ml-3">
				    	<table class="table table-nowrap table-bordered">
				    		<?php if(isset($arr_rej_pump_data['arr_cust_rej_pump_data']) && count($arr_rej_pump_data['arr_cust_rej_pump_data'])>0): ?>
						    	<?php $__currentLoopData = $arr_rej_pump_data['arr_cust_rej_pump_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rej_pump=>$rej_pump_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				    		<tr>
				    			<td colspan="2" class="bg-light"><b>Pump <?php echo e($rej_pump ?? 0); ?> :</b></td>
				    		</tr>
				    		<tr>
				    			<td>Int Rejected </td>
				    			<td><?php echo e($rej_pump_data['tot_int_rejected_qty']??0); ?></td>
				    		</tr>
				    		<tr>
				    			<td>Cust Rejected </td>
				    			<td><?php echo e($rej_pump_data['tot_cust_rejected_qty']??0); ?></td>
				    		</tr>
					    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php endif; ?>
				    	</table>
			    	</div>	
			    </div>
			     <div class="card-body p-0">
			     	<div class="row">
			     		<div class="col-md-6 m-0 mt-md-0 mt-sm-2">
				     	<div id="cust_rej_pie_chart_id"></div>
				        </div>
				        <div class="col-md-6 m-0 mt-md-0 mt-sm-2">
				        	<div id="rej_pump_bar_chart_id"></div>
				        	
				        </div>
				     </div>
				 </div>
        	</div>
		</div>
	</div>
	<!-- <div class="graphs"> -->
	<div class="col-md-12">
		<?php echo $__env->make('dashboard.booking_statement', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>	
	<!-- </div> -->
	
</form>

<?php echo $__env->make('dashboard.chart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/dashboard/dashboard_view.blade.php ENDPATH**/ ?>
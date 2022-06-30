<?php $__env->startSection('main_content'); ?>
<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');

	$sales_start_date = \Carbon::parse($sales_start_date??'')->format('d/m/Y');
	$sales_end_date   = \Carbon::parse($sales_end_date??'')->format('d/m/Y');

	$pump_start_date = \Carbon::parse($pump_start_date??'')->format('d/m/Y');
	$pump_end_date   = \Carbon::parse($pump_end_date??'')->format('d/m/Y');

	$excess_start_date = \Carbon::parse($excess_start_date??'')->format('d/m/Y');
	$excess_end_date   = \Carbon::parse($excess_end_date??'')->format('d/m/Y');
?>

<script src="<?php echo e(asset('/js/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('/js')); ?>/daterangepicker.min.js"></script>
<link href="<?php echo e(asset('/css/')); ?>/daterangepicker.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo e(asset('/js/loader.js')); ?>"></script>
<!-- Page Header -->
<div class="crms-title row bg-white mb-2">
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


<div id="dashboard_view_id"></div>
<script src="<?php echo e(asset('/js/raphael.min.js')); ?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		// attachDaterangePicker();
		filterDashboardData();
	})
	function filterDashboardData()
	{
		var delivery_date    = $('#delivery_date').val();
		var salesdateRange   = $('#salesdateRange').val();
		var rejPumpDateRange = $('#rejPumpDateRange').val();
		var exccessDateRange = $('#exccessDateRange').val();
		var dateRange        = $('#dateRange').val();
		var StatementdateRange   = $('#StatementdateRange').val();
		var customer_id   = $('#customer_id').val();
		$.ajax({
                    type: "GET",
                    url: "<?php echo e($module_url_path); ?>",
                    data:{dateRange:dateRange,salesdateRange:salesdateRange,rejPumpDateRange:rejPumpDateRange,exccessDateRange:exccessDateRange,date:delivery_date,is_ajax:1,statementRange:StatementdateRange,customer_id:customer_id},
                    success: function(data)
                    {
                    	
                      $('#dashboard_view_id').html(data.html);
                      attachDaterangePicker();
                       google.charts.load("current", {packages:["corechart"]});
                       google.charts.setOnLoadCallback(drawPumpPieChart);
                       google.charts.setOnLoadCallback(drawSalesPieChart);
                       google.charts.setOnLoadCallback(drawCustRejPumpPieChart);
                       google.charts.setOnLoadCallback(drawStatementChart);

                       google.charts.load('current', {'packages':['bar']});
     				   google.charts.setOnLoadCallback(drawPumpBarChart);
     				   google.charts.setOnLoadCallback(drawRejPumpBarChart);
                    }
            }); 
	} 
	
	function attachDaterangePicker()
	{
		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: $('#sdt').val(),
		    endDate: $('#edt').val()
		})
		.on('changeDate', function(e) {
			filterDashboardData();
			
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$("#salesdateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: $('#sales_start_date').val(),
		    endDate: $('#sales_end_date').val()
		})
		.on('changeDate', function(e) {
			filterDashboardData();
		});
		$("#salesdateRange").change(function(){
			$('#salesdateRange').trigger('changeDate');
		});

		$("#rejPumpDateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: $('#pump_start_date').val(),
		    endDate: $('#pump_end_date').val(),
		     drops: 'up'
		})
		.on('changeDate', function(e) {
			filterDashboardData();
		});

		$("#rejPumpDateRange").change(function(){
			$('#rejPumpDateRange').trigger('changeDate');
		});

		$("#exccessDateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: $('#excess_start_date').val(),
		    endDate: $('#excess_end_date').val(),
		     drops: 'up'
		})
		.on('changeDate', function(e) {
			filterDashboardData();
		});

		$("#exccessDateRange").change(function(){
			$('#exccessDateRange').trigger('changeDate');
		});

		$('#BookingStatementTable').DataTable({});
 	    $("#StatementdateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: $('#booking_start_date').val(),
		    endDate: $('#booking_end_date').val(),
		}).on('changeDate', function(e) {
			filterDashboardData();
		});

		$("#StatementdateRange").change(function(){
			$('#StatementdateRange').trigger('changeDate');
		});


	}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/dashboard/index.blade.php ENDPATH**/ ?>
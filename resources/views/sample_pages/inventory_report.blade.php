@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Stock Summary Report</h4>
	</div>

	<div class="card mb-0">
		<div class="card-header">
			<div class="row align-items-center">
				<div class="col-md-2 offset-5">
					<div class="position-relative p-0">
						<input class="form-control datepicker pr-5" name="title" placeholder="From date">
						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
        			</div>
				</div>
				<div class="col-md-2">
					<div class="position-relative p-0">
						<input class="form-control datepicker pr-5" name="title" placeholder="To date">
						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
        			</div>
				</div>
				<div class="col-md-3 justify-content-between d-flex">
			<button type="button" class="border-0 btn btn-secondary btn-rounded mb-2">Dowload PDF</button>
			<button class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2 ml-2">ok</button>
		</div>
		    </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-stripped mb-0">
					<thead>
						<tr>
							<th>ID</th>
							<th>Commodity Code</th>
							<th>Commodity Name</th>
							<th>Unit Name</th>
							<th colspan="2" class="text-center">Opening Stock</th>
							<th colspan="2" class="text-center">Import In Period</th>
							<th colspan="2" class="text-center">Export In Period</th>
							<th colspan="2" class="text-center">Closing Stock</th>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="border-right">Quantity</td>
							<td class="border-right">Amount</td>
							<td class="border-right">Quantity</td>
							<td class="border-right">Amount</td>
							<td class="border-right">Quantity</td>
							<td class="border-right">Amount</td>
							<td class="border-right">Quantity</td>
							<td class="border-right">Amount</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
							<td>-----</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td class="font-weight-bold">Total:-</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- multiselect CSS -->
         <link rel="stylesheet" type="text/css" href="{{ asset('') }}css/jquery.multiselect.css"/>
			<!-- multiselect -->
		<script src="{{ asset('') }}js/jquery.multiselect.js"></script>
	    <script>
		    $('.multiselect').multiselect({
		        columns: 1,
		        // placeholder: 'Select Languages',
		        search: true,
		        selectAll: true
		    });
	    </script>
		<script type="text/javascript">
			$(document).ready(function() {
    		$('.datatables').DataTable({searching: true, paging: true, info: true});
			});
		</script>

@endsection
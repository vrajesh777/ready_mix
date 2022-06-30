@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Warehouse history</h4>
	</div>

	<div class="card mb-0">
		<div class="card-header">
			<div class="row align-items-center">
				<div class="col-md-3">
					<select class="multiselect" name="multiselect" multiple>
						<option value="1">Warehouse-1</option>
						<option value="2">Warehouse-2</option>
						<option value="3">Warehouse-3</option>
						<option value="4">Warehouse-4</option>
					</select>
				</div>
				<div class="col-md-3">
					<select class="multiselect" name="multiselect" multiple>
						<option value="1">Cancrete M15</option>
						<option value="2">UltraTech Cement</option>
					</select>
				</div>
				<div class="col-md-2">
					<select class="multiselect" name="multiselect" multiple>
						<option value="1">Stock import</option>
						<option value="2">Stock export</option>
						<option value="3">Increase</option>
						<option value="4">Reduction</option>
					</select>
				</div>
				<div class="col-md-2">
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
		    </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-stripped mb-0 datatables">
					<thead>
						<tr>
							<th>Form code</th>
							<th>Commodity Code</th>
							<th>Description</th>
							<th>Warehouse code</th>
							<th>Warehouse name</th>
							<th>Date add</th>
							<th>Old quantity</th>
							<th>New quantity</th>
							<th>Note</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>NK01</td>
							<td>2523</td>
							<td>UltraTech Cement</td>
							<td>DE#652</td>
							<td>Warehouse-1</td>
							<td>2021-01-28 15:45:48</td>
							<td>48</td>
							<td>7</td>
							<td>In publishing and graphic design, Lorem ipsum is a placeholder.</td>
							<td>Stock import</td>
						</tr>
						<tr>
							<td>NK01</td>
							<td>2523</td>
							<td>UltraTech Cement</td>
							<td>DE#652</td>
							<td>Warehouse-1</td>
							<td>2021-01-28 15:45:48</td>
							<td>48</td>
							<td>7</td>
							<td>Lorem ipsum is a placeholder.</td>
							<td>Stock import</td>
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
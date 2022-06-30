@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Warehouse history</h4>
	</div>

	<div class="card">
		<div class="card-body">
			<h3 class="card-title border-bottom pb-2 mt-0 mb-3"><i class="fal fa-receipt text-black-50 mr-1"></i>General infor</h3>
			<div class="row">
				
				<div class="form-group col-sm-3">
					<label class="col-form-label">date<span class="text-danger">*</span></label>
          		<div class="position-relative p-0">
    					<input class="form-control datepicker pr-5" name="title">
    					<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
					</div>
				</div>
				<div class="form-group col-sm-3 offset-6">
					<label class="col-form-label">Time<span class="text-danger">*</span></label>
					<div class="position-relative p-0">
						
    					<input class="form-control datepicker pr-5" name="title">
    					<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
					</div>
				</div>

				<div class="form-group col-sm-4">
					<label class="col-form-label">Delivery No</label>
       			 	<input type="text" class="form-control" name="title" placeholder="NK02">
				</div>
				<div class="form-group col-sm-4">
					<label class="col-form-label">R.S.N.</label>
       		 		<input type="text" class="form-control"  name="title" placeholder="254">
				</div>
	            <div class="form-group col-sm-4">
              		<label class="col-form-label">date</label>
              		<div class="d-flex align-items-center">
	                    <label class="container-checkbox">
						  	<input type="checkbox" checked="">
						  	<span class="checkmark"></span>
						</label>
						<div class="position-relative p-0 w-100">
	    					<input class="form-control datepicker pr-5" name="title">
	    					<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
						</div>
					</div>	
	            </div>

	            <div class="form-group col-sm-4">
					<label class="col-form-label">Delivery No</label>
       			 	<input type="text" class="form-control" name="title" placeholder="NK02">
				</div>
				<div class="form-group col-sm-4">
					<label class="col-form-label">R.S.N.</label>
       		 		<input type="text" class="form-control"  name="title" placeholder="254">
				</div>
	            <div class="form-group col-sm-4">
              		<label class="col-form-label">date</label>
              		<div class="d-flex align-items-center">
	                    <input type="text" class="form-control w-25 mr-2"  name="title" placeholder="254">
						<input type="text" class="form-control"  name="title" placeholder="254">
					</div>	
	            </div>

				<div class="form-group col-sm-6">
					<label class="col-form-label">Receiver</label>
					<input type="text" class="form-control"  name="title" placeholder="Receiver">
				</div>
	            <div class="form-group col-sm-6">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>


	            <div class="form-group col-sm-1 mw-12 pr-0">
					<label class="col-form-label">Receiver</label>
					<input type="text" class="form-control"  name="title" placeholder="Receiver">
				</div>
	            <div class="form-group col-sm-1 mw-12 pr-0 pl-1">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>
	            <div class="form-group col-sm-1 mw-12 pr-0 pl-1">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>
				<div class="form-group col-sm-1 mw-12 pr-0 pl-1">
					<label class="col-form-label"> Warehouse out<span class="text-danger">*</span></label>
					<select class="select">
						<option>No selected</option>
						<option value="1">Before Tax</option>
						<option value="2">After Tax</option>
					</select>
				</div>
				<div class="form-group col-sm-1 mw-12 pr-0 pl-1">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>
	            <div class="form-group col-sm-1 mw-12 pr-0 pl-1">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>
	            <div class="form-group col-sm-1 mw-12 pr-0 pl-1">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>
	            <div class="form-group col-sm-1 mw-12 pr-0 pl-1">
	              <label class="col-form-label">Address</label>
	                <input type="text" class="form-control"  name="title" placeholder="Address">
	            </div>


				<!-- <div class="form-group col-sm-12">
					<label class="col-form-label">Note</label>
        			<textarea rows="5" cols="5" class="form-control" placeholder="Enter Note"></textarea>
				</div>	 -->
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<div class="row align-items-center">
				<div class="col-md-3">
					<div class="position-relative p-0">
						<input class="form-control datepicker pr-5" name="title" placeholder="From date">
						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
        			</div>
				</div>
				
				
				<div class="col-md-2 offset-2">
					<div class="position-relative p-0">
						<input class="form-control datepicker pr-5" name="title" placeholder="Time">
						<div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
        			</div>
				</div>
				<div class="col-md-3 offset-2">
					<input class="form-control pr-5" name="title" placeholder="From date">
				</div>
		    </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-stripped mb-0 datatables">
					<thead>
						<tr>
							<th>S.</th>
							<th>C. Code</th>
							<th>Customer Name</th>
							<th>Cub.m</th>
							<th>Mix C.</th>
							<th>Mix time</th>
							<th>Batch</th>
							<th>Time</th>
							<th>P</th>
							<th>Int</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>01</td>
							<td>2523</td>
							<td>UltraTech Cement</td>
							<td>52</td>
							<td>105</td>
							<td>G30120c</td>
							<td>15:45</td>
							<td>7</td>
							<td>5</td>
							<td>AT</td>
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
<script>
   $('.timepicker').timepicker({
     });
</script>

@endsection
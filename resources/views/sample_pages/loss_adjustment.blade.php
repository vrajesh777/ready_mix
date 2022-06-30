@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Loss & Adjustment</h4>
		<div class="col-md-4 justify-content-end d-flex">
			<a href="{{ Route('loss_adjustment_create') }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2">Add</a>
			<!-- <a class="btn btn-primary">Add</a> -->
		</div>
	</div>

	<div class="card mb-0">
		<div class="card-header">
			<div class="row align-items-center">
				<div class="col-md-2">
					<label class="col-form-label p-0">Time (lost or adjustment )</label>
					<div class="position-relative p-0">
						<input class="form-control datepicker pr-5" name="title">
						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
        			</div>
				</div>
				<div class="col-md-2">
					<label class="col-form-label p-0">Date create</label>
					<div class="position-relative p-0">
						<input class="form-control datepicker pr-5" name="title">
						<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
        			</div>
				</div>
				<div class="col-md-2">
					<label class="col-form-label p-0">Status</label>
					<select class="select">
						<option>Alert</option>
						<option value="1">Draft</option>
						<option value="2">Adjusted</option>
						
					</select>
				</div>
				<div class="col-md-2">
					<label class="col-form-label p-0">Type</label>
					<select class="select">
						<option>Alert</option>
						<option value="1">Loss</option>
						<option value="2">adjustment</option>
						
					</select>
				</div>
				<div class="col-md-4">
					<ul class="pagination justify-content-end mb-0">
						<li class="page-item"><a class="page-link" href="#">Export</a></li>
						<li class="page-item"><a class="page-link" href="#">
							<i class="far fa-sync-alt"></i></a>
						</li>
					</ul>
				</div>
		    </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-stripped mb-0 datatables">
					<thead>
						<tr>
							<th>Type</th>
							<th>Time (lost or adjustment)</th>
							<th>Time (lost or adjustment)</th>
							<th>Type</th>
							<th>creator</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Loss</td>
							<td>2021-03-10 11:00:00</td>
							<td>2021-02-02</td>
							<td>In publishing and graphic design, Lorem ipsum is a placeholder.</td>
							<td>CRM Admin</td>
							<td><span class="btn btn-success btn-sm">Draft</span></td>
							<td class="text-center">
								<div class="btn-group">
								 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
								   <i class="fas fa-ellipsis-v"></i>
								  </a>
								  <div class="dropdown-menu dropdown-menu-right">
								    <a href="{{ Route('loss_adjustment_create') }}" class="dropdown-item">View</a>
								    <a href="{{ Route('loss_adjustment_create') }}" class="dropdown-item">Edit</a>
								    <button class="dropdown-item" type="button">Delete</button>
								  </div>
								</div>
							</td>
						</tr>
						<tr>
							<td>adjustment</td>
							<td>2021-01-30 12:20:45</td>
							<td>2021-01-30</td>
							<td>The passage is attributed to an unknown typesetter in the 15th century.</td>
							<td>CRM Admin</td>
							<td><span class="btn btn-success btn-sm">Draft</span></td>
							<td class="text-center">
								<div class="btn-group">
								 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
								   <i class="fas fa-ellipsis-v"></i>
								  </a>
								  <div class="dropdown-menu dropdown-menu-right">
								    <a href="{{ Route('loss_adjustment_create') }}" class="dropdown-item">View</a>
								    <a href="{{ Route('loss_adjustment_create') }}" class="dropdown-item">Edit</a>
								    <button class="dropdown-item" type="button">Delete</button>
								  </div>
								</div>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>

		<script type="text/javascript">
			$(document).ready(function() {
    		$('.datatables').DataTable({searching: true, paging: true, info: true});
			});
		</script>

@endsection
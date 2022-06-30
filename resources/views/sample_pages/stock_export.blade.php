@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Stock Export Manage</h4>
		<div class="col-md-4 justify-content-end d-flex">
			<a href="{{ Route('stock_export_create') }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2">Export ouput slip</a>
			<!-- <a class="btn btn-primary">Add</a> -->
		</div>
	</div>

	<div class="card mb-0">
		<div class="card-header">
			<ul class="pagination justify-content-end mb-0">
				<li class="page-item"><a class="page-link" href="#">Export</a></li>
				<li class="page-item"><a class="page-link" href="#">
					<i class="far fa-sync-alt"></i></a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-stripped mb-0 datatables">
					<thead>
						<tr>
							<th>Stock export code</th>
							<th>Customer code</th>
							<th>Customer name</th>
							<th>To</th>
							<th>Address</th>
							<th>HR Code</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>NK01</td>
							<td>DE#95237</td>
							<td>Ganesh</td>
							<td>Sharma</td>
							<td>Studio 103. The Business Centre 61 Wellfield Road Roath Cardiff CF24 3DG.</td>
							<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">Anil Sharma</td>
							<td><span class="btn btn-success btn-sm">Approved</span></td>
							<td><a href="{{ Route('stock_export_view') }}" class="btn btn-secondary btn-sm">View</a></td>
						</tr>
						<tr>
							<td>NK01</td>
							<td>DE#95237</td>
							<td>Ganesh</td>
							<td>Sharma</td>
							<td>Studio 103. The Business Centre 61 Wellfield Road Roath Cardiff CF24 3DG.</td>
							<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">Anil Sharma</td>
							<td><span class="btn btn-success btn-sm">Approved</span></td>
							<td><a href="{{ Route('stock_export_view') }}" class="btn btn-secondary btn-sm">View</a></td>
						</tr>
						<tr>
							<td>NK01</td>
							<td>DE#95237</td>
							<td>Ganesh</td>
							<td>Sharma</td>
							<td>Studio 103. The Business Centre 61 Wellfield Road Roath Cardiff CF24 3DG.</td>
							<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">Anil Sharma</td>
							<td><span class="btn btn-success btn-sm">Approved</span></td>
							<td><a href="{{ Route('stock_export_view') }}" class="btn btn-secondary btn-sm">View</a></td>
						</tr>
						<tr>
							<td>NK01</td>
							<td>DE#95237</td>
							<td>Ganesh</td>
							<td>Sharma</td>
							<td>Studio 103. The Business Centre 61 Wellfield Road Roath Cardiff CF24 3DG.</td>
							<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">Anil Sharma</td>
							<td><span class="btn btn-success btn-sm">Approved</span></td>
							<td><a href="{{ Route('stock_export_view') }}" class="btn btn-secondary btn-sm">View</a></td>
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
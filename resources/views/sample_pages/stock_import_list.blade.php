@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Stock received manage</h4>
		<div class="col-md-4 justify-content-end d-flex">
			<a href="{{ Route('stock_import_create') }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2">Stock received docket </a>
			<!-- <a class="btn btn-primary">Add</a> -->
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
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
									<th>Stock received docket code</th>
									<th>Supplier name</th>
									<th>Buyer</th>
									<th>Total tax money</th>
									<th>Total goods money</th>
									<th>Value of inventory</th>
									<th>Total payment</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>NK01</td>
									<td>Jay</td>
									<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">CRM Admin</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td><span class="btn btn-success btn-sm">Approved</span></td>
									<td><a href="{{ Route('stock_import_view') }}" class="btn btn-secondary btn-sm">View</a></td>
								</tr>
								<tr>
									<td>NK01</td>
									<td>Jay</td>
									<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">CRM Admin</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td><span class="btn btn-success btn-sm">Approved</span></td>
									<td><a href="{{ Route('stock_import_view') }}" class="btn btn-secondary btn-sm">View</a></td>
								</tr>
								<tr>
									<td>NK01</td>
									<td>Jay</td>
									<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">CRM Admin</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td><span class="btn btn-success btn-sm">Approved</span></td>
									<td><a href="{{ Route('stock_import_view') }}" class="btn btn-secondary btn-sm">View</a></td>
								</tr>
								<tr>
									<td>NK01</td>
									<td>Jay</td>
									<td class="d-flex align-items-center"><img src="{{ asset('/') }}images/avatar-05.jpg" alt="" width="30" class="rounded mr-1">CRM Admin</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00</td>
									<td><span class="btn btn-success btn-sm">Approved</span></td>
									<td><a href="{{ Route('stock_import_view') }}" class="btn btn-secondary btn-sm">View</a></td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
		<script type="text/javascript">
			$(document).ready(function() {
    		$('.datatables').DataTable({searching: true, paging: true, info: true});
			});
		</script>

@endsection
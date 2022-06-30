@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-8 card-title mt-0 mb-2">Vendor : #{{ $arr_vendor_details['id'] ?? '' }} {{ $arr_vendor_details['user_meta'][0]['meta_value'] ?? '' }}</h4>
	{{-- <div class="col-md-4 justify-content-end d-flex">
		<a href="{{ Route('purchase_order_create') }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2">New Purchase Order</a>
	</div> --}}
</div>


<div class="row all-reports m-0">
	
	@include('purchase.vendor._sidebar')

	<div class="col-md-9 pr-0 Reports">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 datatables">
						<thead>
							<tr>
								<th>Purchase order</th>
								<th>Total</th>
								<th>Vendors</th>
								<th>Order Date</th>
								<th>Payment Status</th>
								<th>Status</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['order_number'] ?? '' }}</td>
										<td>{{ number_format($value['total'],2) ?? '' }}</td>
										<td>{{ $value['user_meta'][0]['meta_value'] ?? '' }}</td>
										<td>{{ $value['order_date'] ?? '' }}</td>
										<td>
											@php
												$per_paid = 0;
												$paid_amount = $total_amount =  0;
												$paid_amount = array_sum(array_column($value['vendor_payment'], 'amount'));
												$total_amount = $value['total'] ?? 0;
												$per_paid = ($paid_amount / $total_amount) * 100;
											@endphp

											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format($per_paid,2) ?? '' }}%" aria-valuenow="{{ number_format($per_paid,2) ?? '' }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($per_paid,2) ?? '' }}%</div>
											</div>
										</td>
										<td>
											@if($value['status'] == '1')
												<button type="button" class="btn btn-info btn-sm">Not yet approve</button>
											@elseif($value['status'] == '2')
												<button type="button" class="btn btn-success btn-sm">Approved</button>
											@elseif($value['status'] == '3')
												<button type="button" class="btn btn-danger btn-sm">Reject</button>
											@endif
										</td>
	
										<td class="text-center">
											<a class="dropdown-item" href="{{ Route('purchase_order_view',base64_encode($value['id'])) }}"><i class="far fa-eye"></i></a>
										</td>

									</tr>
								@endforeach
							@endif
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
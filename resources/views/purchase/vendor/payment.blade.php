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
								<th>Amount</th>
								<th>Payment Mode</th>
								<th>Transaction ID</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_payment) && sizeof($arr_payment)>0)
								@foreach($arr_payment as $key => $value)
									<tr>
										<td>{{ $value['order_detail']['order_number'] ?? '' }}</td>
										<td>{{ number_format($value['amount'],2) ?? '' }}</td>
										<td>{{ $value['payment_method_detail']['name'] ?? '' }}</td>
										<td>{{ $value['trans_id'] ?? '' }}</td>
										<td>{{ $value['pay_date'] ?? '' }}</td>
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
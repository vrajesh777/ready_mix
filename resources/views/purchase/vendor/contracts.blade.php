@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-8 card-title mt-0 mb-2">Vendor : #{{ $arr_vendor_details['id'] ?? '' }} {{ $arr_vendor_details['user_meta'][0]['meta_value'] ?? '' }}</h4>
</div>


<div class="row all-reports m-0">
	
	@include('purchase.vendor._sidebar')

	<div class="col-md-9 pr-0 Reports">
		<div class="card">
			<div class="card-body">
				@if(isset($arr_data) && !empty($arr_data))
					<div class="row">

						<div class="col-md-12">

							<ul class="personal-info">
								<li>
									<div class="title">Contract #</div>
									<div class="text">{{ $arr_data['contract_no']??'N/A' }}</div>
								</li>
								<li>
									<div class="title">From Date</div>
									<div class="text">{{ $arr_data['start_date']??'N/A' }}</div>
								</li>

								<li>
									<div class="title">Signed Date</div>
									<div class="text">{{ $arr_data['signed_date']??'N/A' }}</div>
								</li>
								<li>
									<div class="title">Expire On</div>
									<div class="text">{{ $arr_data['end_date']??'N/A' }}</div>
								</li>
								<li>
									<div class="title">Details</div>
									<div class="text">{!! $arr_data['description']??'N/A' !!}</div>
								</li>
							</ul>

							@if(isset($arr_data['attachment']) && sizeof($arr_data['attachment'])>0)
							<div class="form-group col-sm-12">
							<div class="table-responsive">
								<table class="table table-striped table-nowrap custom-table mb-0">
									<thead>
										<tr>
											<th>#Id</th>
											<th>Name</th>
											<th>Download</th>
											<th class="text-right">Actions</th>
										</tr>
									</thead>
									
									<tbody>
										
										@foreach($arr_data['attachment'] as $key => $value)
											<tr>
												<td>{{ $key+1 }}</td>
												<td>{{ $value['name'] ?? '' }}</td>
												<td><a href="{{ $purchase_contract_public_path }}/{{ $value['file'] ?? '' }}" download><i class="fa fa-download"></i></a></td>
												@if($obj_user->hasPermissionTo('purchase-vendor-update'))
												<td><a href="{{ Route('contract_attach_delete',base64_encode($value['id'] ?? '')) }}" onclick="confirm_action(this,event,'Do you really want to delete this attachment ?');"><i class="fa fa-trash"></i></a></td>
												@endif
											</tr>
										@endforeach
										
									</tbody>
								</table>
							</div>
							</div>
							@endif


						</div>
					</div>
				@else
					<div class="text-center">

						<h4>Currently no Contract has created. Click below button to create Contract!</h4>
						<br>

						<a href="{{ Route('contract_create',['vendor_id'=>base64_encode($arr_vendor_details['id'])]) }}" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2">Create Contract</a>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		// $('.datatables').DataTable({searching: true, paging: true, info: true});
	});
</script>
@endsection
<div class="col-md-9">
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
					<thead>
						<tr>
							<th>{{ trans('admin.proposal') }} #</th>
							<th>{{ trans('admin.amount') }}</th>
							<th>{{ trans('admin.total') }} {{ trans('admin.tax') }}</th>
							<th>{{ trans('admin.date') }}</th>
							<th>{{ trans('admin.expiry') }} {{ trans('admin.date') }}</th>
							<th>Reference #</th>
							<th>Status</th>
							<th class="text-right notexport">Actions</th>
						</tr>
					</thead>
					<tbody>

						@if(isset($arr_props) && !empty($arr_props))

						@foreach($arr_props as $prop)

						<?php
							$enc_id = base64_encode($prop['id']);
							$status = $prop['status']??'';
							$tax_amnt = 0;

							foreach($prop['prop_details'] as $row) {
								$tot_price = $row['quantity']*$row['rate'];
								$tax_rate = $row['tax_rate'];
								$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
							}
						?>

						<tr>
							<td>
								<a href="{{ Route('view_proposal', $enc_id) }}" target="_blank">{{ format_proposal_number($prop['id']) ?? 'N/A' }}</a>
							</td>
							<td>{{ number_format($prop['net_total'],2) ?? 'N/A' }}</td>
							<td>{{ number_format($tax_amnt,2) ?? 'N/A' }}</td>
							<td>{{ $prop['date'] ?? 'N/A' }}</td>
							<td>{{ $prop['expiry_date'] ?? '' }}</td>
							<td>{{ $prop['ref_num'] ?? 'N/A' }}</td>
							<td>{{ ucfirst($status) }}</td>
                            <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" href="{{ Route('edit_proposal', $enc_id) }}">Edit</a>
										<a class="dropdown-item action-edit" href="{{ Route('view_proposal', $enc_id) }}">View</a>
										@if($status == 'open')
										<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'draft']) }}">Mark as Draft</a>
										@endif
										@if($status == 'draft' || $status == 'open')
										<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'sent']) }}">Mark as Sent</a>
										@endif
										@if($status == 'draft' || $status == 'sent')
										<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'open']) }}">Mark as Open</a>
										@endif
										@if($status == 'declined')
										<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'revised']) }}">Mark as Revised</a>
										@endif
										@if($status == 'sent' || $status == 'revised')
										<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'declined']) }}">Mark as Declined</a>
										<a class="dropdown-item action-edit" href="{{ Route('change_inv_status', [$enc_id,'accepted']) }}">Mark as Accepted</a>
										@endif
									</div>
								</div>
							</td>
						</tr>

						@endforeach

						@else

						<h3 align="center">No Records Found!</h3>

						@endif
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#leadsTable').DataTable({
		});
	});
</script>
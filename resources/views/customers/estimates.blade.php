<div class="col-md-9">
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
					<thead>
						<tr>
							<th>Estimate #</th>
							<th>Subject</th>
							<th>Total</th>
							<th>Date</th>
							<th>Open Till</th>
							<th>Date Created</th>
							<th>Status</th>
							<th class="text-right notexport">Actions</th>
						</tr>
					</thead>
					<tbody>

						@if(isset($arr_estim) && !empty($arr_estim))

						@foreach($arr_estim as $estim)

						<?php
							$enc_id = base64_encode($estim['id']);

							$status = $estim['status']??'';
						?>

						<tr>
							<td>
								<a href="{{ Route('view_estimate', $enc_id) }}" target="_blank" >{{ format_sales_estimation_number($estim['id']) ?? 'N/A' }}</a>
							</td>
							<td>{{ $estim['subject'] ?? 'N/A' }}</td>
							<td>{{ number_format($estim['grand_tot'],2) ?? 0 }}</td>
							<td>{{ $estim['date'] ?? 'N/A' }}</td>
							<td>{{ $estim['open_till'] }}</td>
							<td>{{ date('d-M-y h:i A', strtotime($estim['created_at'])) }}</td>
							<td>{{ ucfirst($status) }}</td>
                            <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" href="{{ Route('edit_estimate', $enc_id) }}">Edit</a>
										<a class="dropdown-item action-edit" href="{{ Route('view_estimate', $enc_id) }}">View</a>
										@if($status == 'open')
										<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'draft']) }}">Mark as Draft</a>
										@endif
										@if($status == 'draft' || $status == 'open')
										<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'sent']) }}">Mark as Sent</a>
										@endif
										@if($status == 'draft' || $status == 'sent')
										<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'open']) }}">Mark as Open</a>
										@endif
										@if($status == 'declined')
										<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'revised']) }}">Mark as Revised</a>
										@endif
										@if($status == 'sent' || $status == 'revised')
										<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'declined']) }}">Mark as Declined</a>
										<a class="dropdown-item action-edit" href="{{ Route('change_status', [$enc_id,'accepted']) }}">Mark as Accepted</a>
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

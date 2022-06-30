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
						<th>{{ trans('admin.status') }}</th>
						<th class="text-right notexport">{{ trans('admin.actions') }}</th>
					</tr>
				</thead>
				<tbody>

					@if(isset($arr_invoices) && !empty($arr_invoices))

					@foreach($arr_invoices as $invoice)

					<?php
						$enc_id = base64_encode($invoice['id']);
						$tax_amnt = 0;

						$order = $invoice['order']??[];
						$ord_details = $order['ord_details']??[];
						$cust_details = $order['cust_details']??[];

						foreach($ord_details as $row) {
							$tot_price = $row['quantity']*$row['rate'];
							$tax_rate = $row['tax_rate'];
							$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
						}
					?>

					<tr>
						<td>
							<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_sales_invoice_number($invoice['id']) ?? 'N/A' }}</a>
						</td>
						<td>{{ $invoice['net_total'] ?? 'N/A' }}</td>
						<td>{{ $tax_amnt ?? 'N/A' }}</td>
						<td>{{ $invoice['invoice_date'] ?? 'N/A' }}</td>
						<td>{{ $invoice['due_date'] ?? '' }}</td>
						<td>{{ ucfirst($invoice['status']) ?? 'N/A' }}</td>
                        <td class="text-center">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
									{{-- <a class="dropdown-item action-edit" href="{{ Route('edit_invoice', $enc_id) }}">Edit</a> --}}
									<a class="dropdown-item action-edit" href="{{ Route('view_invoice', $enc_id) }}">View</a>
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
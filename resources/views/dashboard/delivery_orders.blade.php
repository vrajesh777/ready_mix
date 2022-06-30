<div class="card">
          <div class="card-body">
          	
             <div class="card-header p-0 pb-2 mb-2">
				<form id="filterForm">
					<div class="row align-items-center justify-content-between">
						<h3 class="col-md-7 card-title m-0">Delivery Orders</h3>
						<!-- <label class="col-lg-2 col-form-label text-right">{{ trans('admin.date') }}</label> -->
						<div class="col-md-3">
							<div class="position-relative mt-md-0 mt-sm-2">
								<input class="form-control pr-5 mainDateInput" name="date" id="delivery_date" placeholder="{{ trans('admin.date') }}" value="{{ $date??'' }}">
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
							
		        			</div>
						</div>
				    </div>
			    </form>
			</div>

			<div class="">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								<th class="all">{{ trans('admin.cust') }} #</th>
								<th class="all">{{ trans('admin.pump') }}</th>
								<th class="all">{{ trans('admin.cust') }}</th>
								<th class="all">{{ trans('admin.mix') }}  {{ trans('admin.code') }}</th>
								<th class="all">{{ trans('admin.mix') }}  {{ trans('admin.type') }}</th>
								<th class="all">{{ trans('admin.total') }}</th>
								<th class="all">{{ trans('admin.rem') }}</th>
								<th class="all">{{ trans('admin.dlv') }}</th>
								<th class="all w-65">{{ trans('admin.cust_rej') }}</th>
								<th class="all">{{ trans('admin.int') }} {{ trans('admin.rej') }}</th>
								<th class="all w-65">{{ trans('admin.del') }} {{ trans('admin.time') }}</th>
								
							</tr>
						</thead>
						<tbody>

							@if(isset($arr_order_dtls) && !empty($arr_order_dtls))

							@foreach($arr_order_dtls as $row)

							<?php

								$order = $row['order']??[];
								$enc_id = base64_encode($order['id']);
								$tax_amnt = $remain_qty = $total_qty = 0;

								$invoice = $order['invoice'] ?? [];
								$product = $row['product_details'] ?? [];
								$del_notes = $row['del_notes'] ?? [];

								//$delivered_quant = array_sum(array_column($del_notes, 'quantity'));

								$tot_delivered_quant = $tot_int_rejected_qty = $tot_cust_rejected_qty = $cancelled_qty = $delivered_quant = 0;

								foreach ($del_notes as $del_key => $del_val) {
									if($del_val['reject_by']!='' && $del_val['reject_by'] == '1')
									{
										$tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
									}
									elseif($del_val['reject_by']!='' && $del_val['reject_by'] == '2')
									{
										$tot_cust_rejected_qty += $del_val['reject_qty'] ?? 0;
										$tot_int_rejected_qty += $del_val['reject_qty'] ?? 0;
									}

									if($del_val['status'] == 'cancelled'){
										$cancelled_qty += $del_val['quantity'] ?? 0;
									}

									if($del_val['status'] != 'cancelled'){
										$delivered_quant += $del_val['quantity'] ?? 0;
									}
								}

								$tot_delivered_quant = $delivered_quant - $tot_int_rejected_qty;

								$remain_qty = $row['quantity'] - $tot_delivered_quant - $cancelled_qty;

								if($row['edit_quantity']!='')
								{
									$remain_qty = $row['edit_quantity'] - $tot_delivered_quant - $cancelled_qty;
								}

								if(isset($row['edit_quantity']) && $row['edit_quantity']!=''){
									$total_qty = ($row['edit_quantity'] ?? 0) - $cancelled_qty;
								}
								else{
									$total_qty = ($row['quantity'] ?? 0) - $cancelled_qty;
								}
							?>

							<tr>
								
								<td>{{ $order['cust_details']['id'] ?? '' }}</td>
								<td>{{ $order['pump'] ?? 0 }}</td>
								<td>
									@php
									$first_name = $order['cust_details']['first_name'] ?? " ";
									$last_name = $order['cust_details']['last_name'] ?? " ";
									$cust_name = $first_name.' '.$last_name;
									@endphp
									{{ $order['cust_details']['id'] ?? '' }}-{{ \Str::limit($cust_name ,15) ?? 'N/A' }}
									</td>
								<td title="{{ $product['mix_code'] ?? '' }}">{{ \Str::limit($product['mix_code'],15) ?? 'N/A' }}</td>
								<td title="{{ $product['name'] ?? '' }}">{{ \Str::limit($product['name'],15) ?? 'N/A' }}</td>
								<td>{{ $total_qty ?? 0 }}</td>
								<td>{{ $remain_qty ?? 0 }}</td>
								<td>{{ $tot_delivered_quant ?? 0 }}</td>
								<td>{{ $tot_cust_rejected_qty ?? 0 }}</td>
								<td>{{ $tot_int_rejected_qty ?? 0 }}</td>
								<td>{{ date('H:i', strtotime($order['delivery_time']))??'' }}</td>
	                           
							</tr>

							@endforeach

							@else

							<h3 align="center">{{ trans('admin.no_record_found') }}</h3>

							@endif
							
						</tbody>
					</table>

				</div>
			</div>


          </div>
        </div>
 <script type="text/javascript">
 	$(document).ready(function(){

 	    $('#leadsTable').DataTable({});
 		$('.mainDateInput').datepicker({
			// setDate: new Date(),
			format: 'yyyy/mm/dd',
			// todayHighlight: true,
			// autoclose: true,
			// startDate: '-0m',
			// minDate: 0,
		}).on('changeDate', function(ev){
			filterDashboardData();
			//$('#filterForm').submit();
		});

 	})
 </script>
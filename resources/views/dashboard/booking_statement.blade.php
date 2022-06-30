
<div class="card">
          <div class="card-body">
          	
             <div class="card-header p-0 pb-2 mb-2">
				<div class="row align-items-center justify-content-between">
					<h3 class="col-md-5 col-xl-6 card-title m-0">Booking Statement</h3>
						<div class="col-md-4 col-xl-3">
							<div class="position-relative mt-md-0 mt-sm-2">
							<input type="text" name="StatementdateRange" class="form-control" id="StatementdateRange" value="" >
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
							</div>
						</div>
						<div class="col-md-3">
							 <select name="custm_id" class="select form-control" onchange="filterDashboardData()" id="customer_id">
			            	<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
			            	@if(isset($arr_customer) && sizeof($arr_customer)>0)
								@foreach($arr_customer as $cust)
									<option  value="{{$cust['id']??''}}" {{ ($cust['id']??'')==($custm_id??'')?'selected':'' }}>{{ $cust['first_name']??'' }} {{ $cust['last_name']??'' }}</option>
								@endforeach
							@endif
						</select>
						</div>
					
				   </div>
			</div>

			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="BookingStatementTable">
					<thead>
						<tr>
							<th>{{ trans('admin.date') }}</th>
							<th>{{ trans('admin.cust') }} #</th>
							<th>{{ trans('admin.account') }} #</th>
							<th>{{ trans('admin.customer') }} {{ trans('admin.name') }} </th>
							<th>{{ trans('admin.salesman') }} {{ trans('admin.name') }} </th>
						
							<th>{{ trans('admin.total') }} m³</th>
							<th>{{ trans('admin.booking') }} {{ trans('admin.amount') }} ({{ trans('admin.sar') }})</th>
							<th>{{ trans('admin.advance_payment') }} ({{ trans('admin.sar') }})</th>
							<th>{{ trans('admin.balance') }} ({{ trans('admin.sar') }})</th>
							
						</tr>
					</thead>
					<tbody>

						@if(isset($arr_statement) && !empty($arr_statement))
							@foreach($arr_statement as $sr => $statement)
								<?php
									$enc_id = base64_encode($statement['id']);
									$tax_amnt = $tot_qty = $cr_amnt = $start_index = $end_index = $adv_pay = 0;

									$cust_details = $statement['cust_details']??[];
									$sales_agent = $statement['sales_agent_details']??[];

									$invoice = $statement['invoice'] ?? [];

									foreach($statement['ord_details'] as $row) {
										$tot_price = $row['quantity']*$row['rate'];
										$tax_rate = $row['tax_rate'];
										$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
										$tot_qty += $row['quantity'] ?? 0;
									}
									$cust_id = $statement['cust_id'] ?? '';
									$contract_id = $statement['contract_id'] ?? '';

									$transactions = array_values($arr_user_trans[$cust_id]??[]);


									$end_index++;

									$arr_trans_till_ord = array_slice($transactions, $start_index,$end_index);
									$arr_user_trans[$cust_id] = array_diff_key($transactions, array_flip(array_keys($arr_trans_till_ord)));

								?>

								<tr>
								
									<td>{{ date('d-M-Y', strtotime($statement['delivery_date'])) }}</td>
									<td><a href="{{ Route('satement_details', $enc_id) }}" target="_blank">{{ $cust_id ?? '' }}</a></td>
									<td>{{ uniqid() }}</td>
									<td><a href="{{ Route('satement_details', $enc_id) }}" target="_blank">{{ $cust_details['first_name']??'' }} {{ $cust_details['last_name']??'' }}</a></td>
									<td>{{ $sales_agent['first_name']??'' }} {{ $sales_agent['last_name']??'' }}</td>
								
									<td>{{ $tot_qty ?? '' }}</td>
									<td>{{ number_format($statement['grand_tot']??0,2) }}</td>
									<td>{{ number_format($statement['advance_payment']??0,2) }}</td>
									<td>{{ number_format($statement['balance']??0,2) }}</td>
								</tr>
							@endforeach
						@endif
						
					</tbody>
				</table>
			</div>


          </div>
 </div>

<div class="card">
          <div class="card-body">
          		<div id="statement_chart_id"></div>
          </div>
</div>
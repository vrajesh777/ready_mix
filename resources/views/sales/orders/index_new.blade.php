@extends('layout.master')
@section('main_content')

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');

	$glob_qty_total = 0;
	if(isset($arr_orders) && !empty($arr_orders))
	{
		foreach($arr_orders as $itr => $order)
		{
			$glob_qty_total += $order['ord_details'][0]['quantity'] ?? 0;
		}
	}
?>
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		
		<div class="col-sm-12 col-lg-10 col-xl-10">
			<form action="" id="filterForm">
			<ul class="list-inline-item pl-0 d-flex">
				<li class="list-inline-item">
					<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
				</li>
                <li class="list-inline-item">
                    <select name="custm_id" class="select" id="customer">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
		            	@if(isset($arr_customer) && sizeof($arr_customer)>0)
							@foreach($arr_customer as $cust)
								<option  value="{{$cust['id']??''}}" {{ ($cust['id']??'')==($custm_id??'')?'selected':'' }}>{{ $cust['first_name']??'' }} {{ $cust['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>

                <li class="list-inline-item">
                    <select name="contract" class="select" id="contract">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
		            	{{-- @if(isset($arr_contracts) && sizeof($arr_contracts)>0)
							@foreach($arr_contracts as $site)
								<option  value="{{$site['id']??''}}" {{ ($site['id']??'')==($contract_id??'')?'selected':'' }} >{{ $site['site_location']??'' }}</option>
							@endforeach
						@endif --}}
					</select>
                </li>

                <li class="list-inline-item">
                    <select name="sales_user" class="select" id="sales_user">
		            	<option value="">{{ trans('admin.select') }} {{ trans('admin.saleman') }}</option>
		            	@if(isset($arr_sales_user) && sizeof($arr_sales_user)>0)
							@foreach($arr_sales_user as $user)
								<option  value="{{$user['id']??''}}" {{ ($user['id']??'')==($sales_user??'')?'selected':'' }} >{{ $user['first_name']??'' }} {{ $user['last_name']??'' }}</option>
							@endforeach
						@endif
					</select>
                </li>
                <li class="list-inline-item">
                	<input type="text" readonly class="form-control text-center" value="Total(M³) : {{ $glob_qty_total ?? 0 }}" >
                </li>
                <li class="list-inline-item">
                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
                </li>
            </ul>
        	</form>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('sales-bookings-create'))
					<li class="list-inline-item">
						<a href="{{ Route('create_order') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }}</a>
					</li>
				@endif
			</ul>
		</div>
		
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
<div class="col-sm-12">
<div class="row">
<div class="col-md-12 d-flex">
<div class="card profile-box flex-fill">
	<div class="card-body">
	
		@if($obj_user->hasPermissionTo('sales-bookings-create'))
			<form method="POST" action="{{ Route('store_order') }}" id="formAddProposal">
			{{ csrf_field() }}
				<div class="row">
					<div class="col-sm-12">
						@include('layout._operation_status')
						<div class="d-flex clone_master" id="clone_master">
							<div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.customer') }} <span class="text-danger">*</span></label>
	                            <select name="cust_id" class="select2" id="cust_id" data-rule-required="true">
									<option value="">{{ trans('admin.select_and_begin_typing') }}</option>
									@if(isset($arr_customer) && !empty($arr_customer))
									@foreach($arr_customer as $cust)
									<option value="{{$cust['id']??''}}" >{{ $cust['first_name'] ?? '' }} {{ $cust['last_name'] ?? '' }}</option>
									@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('cust_id') }}</div>
							</div>
							<div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.account') }} <span class="text-danger">*</span></label>
	                            <select name="contract_id" class="select2" id="contract_id" data-rule-required="true">
									<option value="">{{ trans('admin.select_and_begin_typing') }}</option>
								</select>
								<div class="error">{{ $errors->first('contract_id') }}</div>
							</div>
							<div class="form-group w-15 mr-2">
	                            <label class="col-form-label">{{ trans('admin.delivery_date') }}<span class="text-danger">*</span></label>
	                            <div class="position-relative p-0">
	                                <input class="form-control datepicker pr-5" name="delivery_date" id="delivery_date" data-rule-required="true" readonly>
	                                <div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
	                            </div>
	                            <div class="error">{{ $errors->first('delivery_date') }}</div>
	                        </div>

	                        <div class="form-group w-15 mr-2">
	                            <label class="col-form-label">{{ trans('admin.delivery_time') }}<span class="text-danger">*</span></label>
	                            <div class="position-relative p-0">
	                                <input class="form-control timepicker pr-5" name="delivery_time" id="delivery_time" data-rule-required="true" placeholder="HH:mm" data-date-format="HH:mm" value="09:00">
	                                <div class="input-group-append date-icon"><i class="fal fa-clock"></i></div>
	                            </div>
	                            <div class="error">{{ $errors->first('delivery_time') }}</div>
	                        </div>
	                        <div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.pump') }}</label>
	                            <select class="select2" name="pump" data-rule-required="false" id="pump">
	                            	<option value="">{{ trans('admin.select_default') }}</option>
	                            	@if(isset($arr_pump) && count($arr_pump)>0)
	                            		@foreach($arr_pump as $pump)
											<option value="{{ $pump['id'] ?? '' }}" data-operator-id="{{ $pump['operator_id'] ?? '' }}"  data-helper-id="{{ $pump['helper_id'] ?? '' }}" data-driver-id="{{ $pump['driver_id'] ?? '' }}">{{ $pump['name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						</div>
						</div>
						<div class="row">
						<div class="col-sm-12">
						<div class="d-flex clone_master">
							<div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.pump_op') }}
								<!-- <span class="text-danger">*</span> -->
								</label>
	                            <select class="select2" name="pump_op_id" data-rule-required="false" id="pump_op_id">
	                            	<option value="">{{ trans('admin.select_default') }}</option>
	                            	@if(isset($arr_operator) && count($arr_operator)>0)
	                            		@foreach($arr_operator as $op)
											<option value="{{ $op['id'] ?? '' }}">{{ $op['first_name'] ?? '' }} {{ $op['last_name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.pump_helper') }}
									<!-- <span class="text-danger">*</span> -->
								</label>
	                            <select class="select2" name="pump_helper_id" data-rule-required="false" id="pump_helper_id">
	                            	<option value="">{{ trans('admin.select_default') }}</option>
	                            	@if(isset($arr_helper) && count($arr_helper)>0)
	                            		@foreach($arr_helper as $helper)
											<option value="{{ $helper['id'] ?? '' }}">{{ $helper['first_name'] ?? '' }} {{ $helper['last_name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.driver') }}
									<!-- <span class="text-danger">*</span> -->
								</label>
	                            <select class="select2" name="driver_id" data-rule-required="false" id="driver_id">
	                            	<option value="">{{ trans('admin.select_default') }}</option>
	                            	@if(isset($arr_driver) && count($arr_driver)>0)
	                            		@foreach($arr_driver as $driver)
											<option value="{{ $driver['id'] ?? '' }}">{{ $driver['first_name'] ?? '' }} {{ $driver['last_name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
							</div>

							<div class="form-group w-15 mr-2">
								<label class="col-form-label">{{ trans('admin.select_item') }}
									<span class="text-danger">*</span>
								</label>
								<select name="prod_id[]" class="select2 productSrch" data-rule-required="true">
									<option>{{ trans('admin.add') }} {{ trans('admin.item') }}</option>
								</select>
								<div class="error">{{ $errors->first('product') }}</div>
							</div>
							<div class="form-group w-10 mr-2">
								<label class="col-form-label">{{ trans('admin.cubic_meter') }}<span class="text-danger">*</span></label>
								<input type="number" name="unit_quantity[]" value="1" class="form-control" min="1" id="unit_quantity" data-rule-required="true">
								<div class="error">{{ $errors->first('unit_quantity') }}</div>
							</div>
							<div class="d-none">
								<input type="number" name="unit_rate[]" class="form-control" min="0" readonly="readonly">
							</div>
							<div class="d-none">
								<input type="number" name="opc1_rate[]" class="form-control" min="0" id="opc1_rate_index" onchange="calculate_prop_amnt()" >
							</div>
							<div class="d-none">
								<input type="number" name="src5_rate[]" class="form-control" min="0" id="src5_rate_index" onchange="calculate_prop_amnt()" >
							</div>
							<div class="d-none">
								<input type="number" name="unit_tax[]" class="form-control unit_tax" min="0" id="unit_tax_index">		
							</div>
							<div class=" py-3">
						    	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded px-2">{{ trans('admin.save') }}</button>
						    </div>

						    <input type="hidden" name="disc_type" id="disc_type" value="percentage">
						    <input type="hidden" name="status" value="granted">
						</div>
					</div>
				</div>
			</form>
		@endif

		<div class="tab-content">

			<div class="tab-pane active show" id="pump_all">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 leadsTable">
						<thead>
							<tr>
								<th>{{ trans('admin.pump') }}</th>
								<th>{{ trans('admin.cust') }}</th>
								<th>{{ trans('admin.customer') }}</th>
								<th>{{ trans('admin.location') }}</th>
								<th>{{ trans('admin.delivery') }}</th>
								<th>M³</th>
								{{-- <th>Qty Actual M³</th> --}}
								<th>{{ trans('admin.mix') }}</th>
								<!-- <th>{{ trans('admin.structure') }}</th> -->
								<!-- <th>{{ trans('admin.cont') }}</th> -->
								<th>{{ trans('admin.remarks') }}</th>
								{{-- <th>Booking Amount</th>
								<th>Advance Payment</th> --}}
								{{-- <th>Adv+Bal</th> --}}
								{{-- <th>Balance Amount</th> --}}
								{{-- <th>Status</th> --}}
								{{-- <th>M³</th> --}}
								{{-- <th>M³ Actual</th> --}}
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $gobal_cr = 0; $arr_user_bal = []; ?>

							@if(isset($arr_sorted_orders) && !empty($arr_sorted_orders))
							@foreach($arr_sorted_orders as $arr_orders)

							<?php $pmp_tot_quant = $pmp_tot_actl_quant = 0; ?>

							@if(isset($arr_orders) && !empty($arr_orders))
							@foreach($arr_orders as $itr => $order)
								<?php
									$enc_id = base64_encode($order['id']);
									$tax_amnt = $tot_qty = $cr_amnt = $adv_pay = 0;

									$invoice = $order['invoice'] ?? [];
									$contract = $order['contract'] ?? [];

									$ord_dtls = current($order['ord_details'])??[];

									foreach($order['ord_details'] as $row) {
										$tot_price = $row['quantity']*$row['rate'];
										$tax_rate = $row['tax_rate'];
										$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
										$tot_qty += $row['quantity'] ?? 0;
									}

									$pmp_tot_quant += $tot_qty;

									$pmp_tot_actl_quant += $contract['excepted_m3']??0;

									$cust_id = $order['cust_id'] ?? '';
									$contract_id = $order['contract_id'] ?? '';

									$transactions = array_values($arr_user_trans[$cust_id]??[]);

									$arr_trans_till_ord = [];

									$start_index = 0;
									$end_index = 0;

									foreach($transactions as $key => $trans) {
										if($trans['order_id'] == $order['id'] && $trans['type'] == 'debit') {
											$end_index = $key;
										}
									}
									$end_index++;
									$arr_trans_till_ord = array_slice($transactions, $start_index,$end_index);
									$arr_user_trans[$cust_id] = array_diff_key($transactions, array_flip(array_keys($arr_trans_till_ord)));

									if(!empty($arr_trans_till_ord)) {
										foreach($arr_trans_till_ord as $tran) {
											if($tran['type']=='credit'){
												$cr_amnt += $tran['amount'];
											}elseif($tran['type']=='debit'){
												$cr_amnt -= $tran['amount'];
											}
										}
										foreach($arr_trans_till_ord as $tran) {
											if($tran['type']=='credit'){
												$adv_pay += $tran['amount'];
											}elseif($tran['type']=='debit'){
												break;
											}
										}
									}

									if(isset($arr_user_bal[$cust_id])) {
										$arr_user_bal[$cust_id] += $cr_amnt;
									}else{
										$arr_user_bal[$cust_id] = $cr_amnt;
									}
								?>

								<tr>
									@if($itr == 0)
									<td rowspan="{{ count($arr_orders) }}">{{ $order['pump_details']['name'] ?? '' }}</td>
									@endif
									<td>
										{{-- <a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_order_number($order['id']) ?? 'N/A' }}</a> --}}
										<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ $cust_id ?? 0 }}</a>
									</td>
									@if(\App::getLocale() == 'ar')
										<td>{{ $order['cust_details']['first_name'] ?? '' }}</td>
									@else
										<td> {{ $order['cust_details']['last_name'] ?? '' }}</td>
									@endif
									<td>{{ $contract['site_location']??'' }}</td>
									<td>{{ date_format_dd_mm_yy($order['delivery_date']) ?? '' }} {{ date('H:i', strtotime($order['delivery_time']))??'' }} </td>
									<td>{{ $tot_qty ?? '' }}</td>
									{{-- <td>{{ $contract['excepted_m3'] ?? '' }}</td> --}}
									<td>{{ $ord_dtls['product_details']['name']??'' }}</td>
									<!-- <td>{{ $order['structure']??'' }}</td> -->
									<!-- <td>{{ $order['cust_details']['mobile_no'] ?? 'N/A' }}</td> -->
									<td>{{ Str::limit($order['remark'],10) ?? 'N/A' }}</td>
									{{-- <td>{{ number_format($order['grand_tot'] ?? 0,2) ?? 'N/A' }}</td> --}}
									{{-- <td>{{ number_format($order['advance_payment'] ?? 0,2) }}</td> --}}
									{{-- <td>{{ number_format($order['adv_plus_bal']??0,2) }}</td> --}}
									{{-- <td>{{ number_format($order['balance']??0,2) }}</td> --}}
									{{-- <td>{{ ucfirst($order['order_status']) ?? 'N/A' }}</td> --}}
									{{-- <td></td>
									<td></td> --}}
		                            <td class="text-center">
		                            	@if($order['delivery_date'] > date('Y-m-d') )
		                            		<a  href="{{ Route('edit_order', $enc_id) }}"><i class="fas fa-edit" title="Edit Order"></i></a>
		                            	@endif
		                            	<a  href="{{ Route('view_order', $enc_id) }}"><i class="fa fa-eye" title="{{ trans('admin.view_details') }}"></i></a>
										<a class="btn btn-primary btn-sm btn-edit-qty" href="{{route('edit_order', base64_encode($order['id']))}}" id="edit_order"><i class="fa fa-edit" title="{{ trans('admin.edit_order') }}" aria-hidden="true"></i></a>
										@if($ord_dtls['quantity_delivered'] <= 0)
										<a class="btn btn-primary btn-sm btn-edit-qty" href="{{route('cancel_order', base64_encode($order['id']))}}" id="cancel_order"><i class="fa fa-trash" title="{{ trans('admin.cancel_order') }}" aria-hidden="true"></i></a>
										@endif
										{{-- <div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item action-edit edit-ord" href="{{ Route('edit_order', $enc_id) }}">Edit</a>
												<a class="dropdown-item action-edit" href="{{ Route('view_order', $enc_id) }}">View</a>
											</div>
										</div> --}}
									</td>
								</tr>
							@endforeach
							{{-- <tr>
								<td colspan="16"></td>
								<td>{{ $pmp_tot_quant??0 }}</td>
								<td>{{ ($pmp_tot_actl_quant-$pmp_tot_quant) }}</td>
								<td>{{ $pmp_tot_actl_quant??0 }}</td>
								<td></td>
							</tr> --}}
							@endif
							@endforeach
							@else
								<h3 align="center">{{ trans('admin.no_record_found') }}</h3>
							@endif
						</tbody>
					</table>
					<div>
						{{ $obj_orders->links() }}
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Content End -->

<!-- Modal -->
<div class="modal fade right" id="edit_ord_modal" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.edit_order') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div id="ordFormWrapp">
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->
<style type="text/css">
/*.modal.fade.right.show {opacity: 1;}*/
/*.show {display: block!important}*/
</style>

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

<script type="text/javascript">
// body add class for sidebar start
var body = document.body;
body.classList.add("mini-sidebar");
// body add class for sidebar end

	var custm_id = "{{ $custm_id ?? '' }}";
	$(document).ready(function() {

		$('.timepicker').datetimepicker({
			format : 'HH:mm'
        });

        $( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		});

		$('.select2').select2();

		if(custm_id!='')
		{
			load_sites(custm_id);
		}

		$(".edit-ord").click(function(e) {
			e.preventDefault();
			var action_url = $(this).attr('href');
			$("#edit_ord_modal").modal("show");
			$("#ordFormWrapp").html('');

			$.ajax({
				url: action_url,
				dataType:'json',
				beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status.toLowerCase() == 'success') {
						$("#ordFormWrapp").html(response.html);
					}
					displayNotification(response.status, response.message, 5000);
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sdt??''}}',
		    endDate: '{{$edt??''}}'
		})
		.on('changeDate', function(e) {
			$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$("#contract,#sales_user,#customer").change(function() {
			$("#filterForm").submit();
		});

		$("#cust_id").change(function(){
			get_contracts($(this).val());
		});

		$("#contract_id").change(function(){
			get_contracts_items($(this).val());
		});

		$('#formAddProposal').validate({});

		$('.productSrch').select2({
			placeholder: "Search for an Item",
			escapeMarkup: function(markup) {
				return markup;
			},
			templateResult: function(data) {
				return data.html;
			},
			templateSelection: function(data) {
				return data.text;
			}
		}).on('change', function (e) {
		    var prodId = $(".productSrch option:selected").val();
		    var prodName = $(".productSrch option:selected").text();

		    $('.prod_id').val(prodId);

		    var callUrl = "{{ Route('get_contract_item','') }}/"+btoa(prodId);

		    if($("input[name='prod_id[]']").length >= 1) {
				displayNotification('error', "Cannot add more than 1 Mix!", 5000);
				return false;
			}

		    $.ajax({
				url: callUrl,
  				type:'GET',
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(resp)
  				{
  					hideProcessingOverlay();
  					if(resp.status.toLowerCase() == 'success') {
  						$('.clone_master').find(".prod_id").val(resp.data.product_id);
  						$('.clone_master').find("#sel_prod_name").val(resp.data.product_details.name);
  						$('.clone_master').find("#sel_prod_descr").val(resp.data.product_details.description);

  						$('.clone_master').find("#unit_quantity").attr('min',resp.data.product_details.min_quant);
  						$('.clone_master').find("#unit_quantity").val(resp.data.product_details.min_quant);
  						$('.clone_master').find("#unit_rate").val(resp.data.rate);
  						$('.clone_master').find("#opc1_rate_index").val(resp.data.opc_1_rate);
  						$('.clone_master').find("#src5_rate_index").val(resp.data.src_5_rate);
  						$('.clone_master').find("#unit_tax_index").val(resp.data.tax_id);
  						/*$('.clone_master').find("#unit_tax option[value="+resp.data.tax_id+"]").prop('selected', true);
  						$('.clone_master').find("#unit_tax").select2().trigger('change');*/

  						var unitPrice = (resp.data.product_details.min_quant * resp.data.rate);

  						$('.clone_master').find('.unit_price').html(unitPrice);

  					}
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		});

		$('select[name=pump]').change(function(){
			var operator_id = $('select[name=pump] :selected').data('operator-id');
			var helper_id = $('select[name=pump] :selected').data('helper-id');
			var driver_id = $('select[name=pump] :selected').data('driver-id');

			$('select[name=pump_op_id]').val(operator_id);
    		$('select[name=pump_op_id]').select2().trigger('change');

    		$('select[name=pump_helper_id]').val(helper_id);
    		$('select[name=pump_helper_id]').select2().trigger('change');

			$('select[name=driver_id]').val(driver_id);
    		$('select[name=driver_id]').select2().trigger('change');
		});

	});

	$('#customer').change(function(){
		var cust_id = $(this).val();
		load_sites(cust_id);
	});

	$('#clear_btn').click(function(){
		window.location.href="{{ Route('booking') }}";
	});

	function load_sites(cust_id) {
		$.ajax({
			url:'{{ Route('load_sites','') }}/'+btoa(cust_id),
			method:'GET',
			dataType:'json',
			success:function(response){
				if(response.status == 'success'){
					if(typeof(response.arr_sites) == "object"){
						var option = '<option value="">Choose Site</option>';
						var slected_id = "{{ $contract_id ?? '' }}";
						$(response.arr_sites).each(function(index,contract){ 
							var selected = '';
							if(slected_id == contract.id)  
							{
								selected = 'selected';
							}
							console.log(selected)
	                        option+='<option value="'+contract.id+'" '+selected+'>'+contract.site_location+'</option>';
	                    });
	                    $('select[name="contract"]').html(option);
					}
				}
				return false;
			}
		});
	}

	var contract_id_label = "{{ trans('admin.select_and_begin_typing') }}";
	function get_contracts(user_id) {
		if(user_id!='') {

			var callUrl = "{{ Route('get_user_cotracts','') }}/"+btoa(user_id);

		    $.ajax({
				url: callUrl,
					type:'GET',
					dataType:'json',
					beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(resp)
				{
					$('#contract_id').empty();
					$('#contract_id').html('<option value="">'+contract_id_label+'</option>');
					hideProcessingOverlay();
					if(resp.status.toLowerCase() == 'success') {
						var data_contr = [];
						if(resp.contracts.length > 0) {
							$.each(resp.contracts, function( index, value ) {
								var location = '';
								if(value.site_location !== null && value.site_location !== '')
								{
									location = '- '+value.site_location;
								}
								data_contr.push({
									id:value.id,
									text:''+value.contract_no+' '+location
								});
							});
						}
						else
						{
							$('#contract_id').empty();
						}
						$('#contract_id').select2({
							data: data_contr
						});
						initiate_form_validate();

					}
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		}
	}

	function get_contracts_items(contract_id) {

		if(contract_id!='') {

			var callUrl = "{{ Route('get_contract_items','') }}/"+btoa(contract_id);

		    $.ajax({
				url: callUrl,
					type:'GET',
					dataType:'json',
					beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(resp)
				{
					hideProcessingOverlay();
					if(resp.status.toLowerCase() == 'success') {

						$('.productSrch').empty();
						$('.productSrch').html('<option>Add Item</option>');

						var data_items = [];
						if(resp.contracts.length > 0) {
							$.each(resp.contracts, function( index, value ) {
								data_items.push({
									id: value.product_details.id,
									text: value.product_details.name,
								});
							});
						}
						$('.productSrch').select2({
							data: data_items
						});
						initiate_form_validate();
					}
				},
				error:function(){
					hideProcessingOverlay();
				}
			});
		}
	}

	function calculate_prop_amnt() {
		$.ajax({
			url: "{{ Route('calculate_ord_amnt') }}",
			type:'POST',
			dataType:'json',
			data : $("#formAddProposal").serialize(),
			beforeSend: function() {
		        showProcessingOverlay();
		    },
			success:function(response)
			{
				hideProcessingOverlay();
				if(response.status.toLowerCase() == 'success') {
					$('.subtotal').html(response.sub_tot);
					$('.tot_disc').html("-"+response.disc_amnt);
					$('.grand_tot').html(response.grand_tot);
					$('input[name=grand_tot]').val(response.grand_tot);
				}
			},
			error:function(){
				hideProcessingOverlay();
			}
		});
	}

</script>
@stop
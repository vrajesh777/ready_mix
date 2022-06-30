@extends('layout.master')
@section('main_content')

<?php

use Carbon\Carbon;


$req_date = Carbon::parse($date)->format('Y-m-d');

$tot_cbm = 0;
$total_order_qty=0;
if(isset($arr_order_dtls) && !empty($arr_order_dtls)){
	foreach($arr_order_dtls as $row)
	{
		$total_order_qty += $row['quantity'];
		$del_notes = $row['del_notes'] ?? [];
		foreach($del_notes as $key => $note){
			$del_date = Carbon::parse($note['delivery_date'])->format('Y-m-d');
			if($del_date == $req_date && $note['status']!='cancelled'){
				$tot_cbm += ($note['quantity'] ?? 0) - ($note['reject_qty'] ?? 0);
			}
			elseif($show_all == '1' && $note['status']!='cancelled'){
				$tot_cbm += ($note['quantity'] ?? 0) - ($note['reject_qty'] ?? 0);
			}
		}
		
	}
}
?>

<script src="{{ asset('/js/print.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('/css/print.min.css') }}">

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		@include('layout._operation_status')

		{{-- <iframe id="pdf" name="pdf" hidden></iframe> --}}

		<div class="card mb-0">
			<div class="card-header">
				<form id="filterForm">
					<div class="row align-items-top">
						<div class="col-md-3">
							<label>{{ trans('admin.date') }}</label>
							<div class="position-relative p-0">
								<input class="form-control pr-5 mainDateInput" name="date" placeholder="{{ trans('admin.date') }}" value="{{ $date??'' }}">
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
								<input class="mr-2 mt-2" type="checkbox" value="1" id="show_all_del_note" name="show_all" @if(isset($show_all) && $show_all!='' && $show_all == '1') checked @endif>Show all delivery
		        			</div>
						</div>

						<div class="col-md-2 offset-2">
							<div class="position-relative p-0">
								<label>{{ trans('admin.time') }}</label>
								<input class="form-control pr-5 commonTime" disabled="">
		        			</div>
						</div>
						<div class="col-md-2">
							<div class="position-relative p-0">
								<label>{{ trans('admin.sum_of_total_order') }}</label>
								<input class="form-control pr-5" disabled="" value="{{$total_order_qty}}">
		        			</div>
						</div>
						<div class="col-md-3 ">
							<label>{{ trans('admin.total_cbm') }}</label>
							<input class="form-control pr-5" value="{{ $tot_cbm ?? 00 }}" disabled="">
						</div>
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								{{-- <th class="all">{{ trans('admin.ord') }}</th> --}}
								<th class="all">{{ trans('admin.cust') }} #</th>
								<th class="all">{{ trans('admin.cust') }}</th>
								{{-- <th class="all">Cust Name</th> --}}
								<!-- <th class="all">{{ trans('admin.mix') }}  {{ trans('admin.code') }}</th> -->
								<th class="all">{{ trans('admin.mix') }}  {{ trans('admin.type') }}</th>
								<th class="all">{{ trans('admin.total') }}</th>
								<th class="all">{{ trans('admin.rem') }}</th>
								<th class="all">{{ trans('admin.dlv') }}</th>
								<th class="all w-65">{{ trans('admin.cust_rej') }}</th>
								<th class="all">{{ trans('admin.int') }} {{ trans('admin.rej') }}</th>
								<th class="all">{{ trans('admin.pump') }}</th>
								<th class="all w-65">{{ trans('admin.del') }} {{ trans('admin.time') }}</th>
								<th class="all text-right notexport">{{ trans('admin.actions') }}</th>
								<th class="none"></th>
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

								$remain_qty = $row['quantity'] - $tot_delivered_quant;

								if($row['edit_quantity']!='')
								{
									$remain_qty = $row['edit_quantity'] - $tot_delivered_quant;
								}
								$remain_qty = $remain_qty<=0?0:$remain_qty;
								if(isset($row['edit_quantity']) && $row['edit_quantity']!=''){
									$total_qty = $row['edit_quantity'] ?? 0;
								}
								else{
									$total_qty = $row['quantity'] ?? 0 ;
								}
								
							?>
						<?php if(last(request()->segments()) !== 'all_delivered'? $remain_qty : !$remain_qty){?>
							<tr>
								{{-- <td>
									<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_order_number($order['id']) ?? 'N/A' }}ORD{{ str_pad($order['id'], 5, '0', STR_PAD_LEFT) }}</a>
								</td> --}}
								<td>{{ $order['cust_details']['id'] ?? '' }}</td>
								@if(\App::getLocale() == 'ar')
									<td>{{ $order['cust_details']['first_name'] ?? '' }}</td>
								@else
									<td> {{ $order['cust_details']['last_name'] ?? '' }}</td>
								@endif
								<!-- <td title="{{ $product['mix_code'] ?? '' }}">{{ \Str::limit($product['mix_code'],15) ?? 'N/A' }}</td> -->
								<td title="{{ $product['name'] ?? '' }}">{{ \Str::limit($product['name'],15) ?? 'N/A' }}</td>
								<td>{{ $total_qty ?? 0 }}</td>
								<td>{{ $remain_qty ?? 0 }}</td>
								<td>{{ $tot_delivered_quant ?? 0 }}</td>
								<td>{{ $tot_cust_rejected_qty ?? 0 }}</td>
								<td>{{ $tot_int_rejected_qty ?? 0 }}</td>
								<td>{{ $order['pump'] ?? 0 }}</td>
								<td>{{ date('H:i', strtotime($order['delivery_time']))??'' }}</td>
	                            <td class="text-center">
	                            	@if($row['edit_quantity']=='' && ($tot_delivered_quant??0) == ($row['quantity']??0))
	                            		<button class="btn btn-success btn-sm" type="button"><i class="fa fa-check" title="{{ trans('admin.delivered') }}"></i></button>
	                            	@elseif($row['edit_quantity']!='' && ($tot_delivered_quant??0) == ($row['edit_quantity']??0))
	                            		<button class="btn btn-success btn-sm" type="button"><i class="fa fa-check" title="{{ trans('admin.delivered') }}"></i></button>
	                            	@else
	                            		@if($obj_user->hasPermissionTo('dispatch-order-update'))
											@if(((date('Y-m-d') <= $order['extended_date']) && (date('Y-m-d') >= $order['extended_date'])) && ((date('Y-m-d') <= $date) && date('Y-m-d') >= $date))
												<button type="button" class="btn btn-primary btn-sm btn-del-note" data-ord-det_id="{{ base64_encode($row['id']) }}"><i class="fa fa-truck" aria-hidden="true" title="{{ trans('admin.delivery_note') }}"></i></button>
											@endif
										@endif

										@if($obj_user->hasPermissionTo('dispatch-order-update'))
											@if(date('Y-m-d') <= $order['extended_date'])
												<a class="btn btn-primary btn-sm btn-edit-qty pay_mod" href="javascript:void(0);" id="pay_mod" data-toggle="modal" data-target="#edit_qty_model" data-ord-det-id="{{ base64_encode($row['id']) }}" @if(isset($row['edit_quantity']) && $row['edit_quantity']!='') data-ord-qty="{{ $row['edit_quantity'] ?? 0 }}" @else data-ord-qty="{{ $row['quantity'] ?? 0 }}" @endif data-dlv-qty="{{ $tot_delivered_quant }}"><i class="fa fa-edit" title="{{ trans('admin.edit_qty') }}" aria-hidden="true"></i></a>
											@endif
										@endif
									@endif
								</td>
								<td>
									@if(isset($del_notes) && !empty($del_notes))
						            <table>
						            	<thead>
									        <tr>
									            <th>{{ trans('admin.load_no') }}</th>
									            <th>{{ trans('admin.truck') }}</th>
									            <th>{{ trans('admin.loaded_cbm') }}</th>
									            <th>Exess(M³)</th>
									            <th>{{ trans('admin.rej') }}(M³)</th>
									            <th>{{ trans('admin.rej_by') }}</th>
									            <th>{{ trans('admin.driver') }}</th>
									            <th>{{ trans('admin.del_date') }}</th>
									            <th>{{ trans('admin.status') }}</th>
									            <th>{{ trans('admin.actions') }}</th>
									        </tr>
									    </thead>
									    <tbody>
									    	@foreach($del_notes as $key => $note)
										    	<?php
										    		$driver = $note['driver']??[];
										    		$vehicle = $note['vehicle']??[];

										    		$del_date = Carbon::parse($note['delivery_date'])->format('Y-m-d');
										    	?>
										    	@if($del_date == $req_date)
											    	<tr>
											    		<td>{{ ($key+1) }}</td>
											            <td>{{ $vehicle['name']??'' }}&nbsp;
											            	({{$vehicle['plate_no']??''}} {{$vehicle['plate_letter']??''}})
											            </td>
											            <td>{{ $note['quantity']??'' }}</td>
											            <td>{{ $note['excess_qty']?? '' }}</td>
											            <td>{{ $note['reject_qty']?? 0 }}</td>
											            <td>
											           		@if($note['reject_by']!='' && $note['reject_by'] == '1')
											           			Readymix
											           		@elseif($note['reject_by']!='' && $note['reject_by'] == '2')
											           			Customer
											           		@endif
											            </td>
											            <td>{{ $driver['first_name']??'' }}&nbsp;
											            	{{ $driver['last_name']??'' }}
											            </td>
											            <td>{{ date_format_dd_mm_yy($note['delivery_date'] ?? '')??'' }}</td>
											            <td>{{ $note['status']??'' }}</td>
											            <td>
											            	<a class="btn btn-sm btn-info" href="{{ Route('dowload_del_note',base64_encode($note['id'])) }}" target="_blank" title="{{ trans('admin.download_delivery_note') }}" ><i class="fa fa-download"></i></a>

											            	@if($obj_user->hasPermissionTo('dispatch-order-update') && $note['reject_by'] == '')
											            		@if($del_date == date('Y-m-d'))
											            		<a class="btn btn-primary btn-sm rej_mod" href="javascript:void(0);" data-toggle="modal" data-target="#reject_qty_model" data-note-id="{{ base64_encode($note['id']) }}" data-qty="{{ $note['quantity']??'' }}" ><i class="fa fa-ban" title="{{ trans('admin.reject_excess_quantity') }}"></i></a>
											            		@endif
											            	@endif
											            	@if($note['reject_by']!='')
											            		<a class="btn btn-primary btn-sm rej_details" id="rej_details" href="javascript:void(0);" data-toggle="modal" data-target="#details_model" data-rejected-by="{{ $note['reject_by'] ?? '' }}" data-rejected-reason="{{ $note['remark']?? 0 }}" data-rejected-qty="{{ $note['reject_qty']?? 0 }}" data-excess-qty="{{ $note['excess_qty']?? 0 }}" data-note-id="{{ base64_encode($note['id']) }}"><i class="fa fa-eye" title="{{ trans('admin.details') }}"></i></a>
											            	@endif
											            	@if($obj_user->hasPermissionTo('dispatch-order-update') && $note['status']!='cancelled')
											            		@if($del_date == date('Y-m-d'))
											            		<a class="btn btn-primary btn-sm" href="{{ Route('cancel_note',base64_encode($note['id'])) }}" onclick="confirm_action(this,event,'Do you really want to cancel this note ?');"><i class="fa fa-window-close" title="Cancel"></i></a>
											            		@endif
											            	@endif
											            </td>
											    	</tr>
										    	@elseif($show_all!=0 && $show_all == '1')
											    	<tr>
											    		<td>{{ ($key+1) }}</td>
											            <td>{{ $vehicle['name']??'' }}&nbsp;
											            	({{$vehicle['plate_no']??''}} {{$vehicle['plate_letter']??''}})
											            </td>
											            <td>{{ $note['quantity']??'' }}</td>
											            <td>{{ $note['reject_qty']?? 0 }}</td>
											            <td>
											           		@if($note['reject_by']!='' && $note['reject_by'] == '1')
											           			{{ trans('admin.readymix') }}
											           		@elseif($note['reject_by']!='' && $note['reject_by'] == '2')
											           			{{ trans('admin.customer') }}
											           		@endif
											            </td>
											            <td>{{ $driver['first_name']??'' }}&nbsp;
											            	{{ $driver['last_name']??'' }}
											            </td>
											            <td>{{ date_format_dd_mm_yy($note['delivery_date'])??'' }}</td>
											            <td>{{ $note['status']??'' }}</td>
											            <td>
											            	<a class="btn btn-sm btn-info" href="{{ Route('dowload_del_note',base64_encode($note['id'])) }}" target="_blank" title="{{ trans('admin.download_delivery_note') }}" ><i class="fa fa-download"></i></a>

											            	@if($obj_user->hasPermissionTo('dispatch-order-update') && $note['reject_by'] == '')
											            		@if($del_date == date('Y-m-d'))
											            		<a class="btn btn-primary btn-sm rej_mod" href="javascript:void(0);" data-toggle="modal" data-target="#reject_qty_model" data-note-id="{{ base64_encode($note['id']) }}" data-qty="{{ $note['quantity']??'' }}" ><i class="fa fa-ban" title="{{ trans('admin.reject_excess_quantity') }}"></i></a>
											            		@endif
											            	@endif
											            	
											            	@if($note['reject_by']!='')
											            		<a class="btn btn-primary btn-sm rej_details" id="rej_details" href="javascript:void(0);" data-toggle="modal" data-target="#details_model" data-rejected-by="{{ $note['reject_by'] ?? '' }}" data-rejected-reason="{{ $note['remark']?? 0 }}" data-rejected-qty="{{ $note['reject_qty']?? 0 }}" data-note-id="{{ base64_encode($note['id']) }}"><i class="fa fa-eye" title="{{ trans('admin.details') }}"></i></a>
											            	@endif
											            </td>
											    	</tr>
										    	@endif
									    	@endforeach
									    </tbody>
						            </table>
						            @endif
					        	</td>
							</tr>
							<?php }?>
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
</div>
<!-- /Content End -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="fal fa-receipt text-black-50 mr-1"></i>{{ trans('admin.delivery_note') }}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="del_note_form_wrapp">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
				<button type="button" class="btn btn-primary del_note_form_submit">{{ trans('admin.save') }}</button>
			</div>
		</div>
	</div>
</div>

<!-- Edit Qty Modal -->
<div class="modal fade right" id="edit_qty_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.edit_quantity') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('edit_del_qty') }}" id="update_qty">
					{{ csrf_field() }}
					<input type="hidden" name="enc_order_id" id="enc_order_id">
					<div class="row">
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.quantity') }} (M³)</label>
							<input type="text" class="form-control quantity" name="quantity" placeholder="{{ trans('admin.quantity') }} (M³)" data-rule-required="true" data-rule-number="true">
							<label class="error" id="quantity_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
		                </div>
				           
				        </div>
					</div>

				</form>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<!-- Edit Qty Modal -->
<div class="modal fade right" id="reject_qty_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.reject_excess_quantity') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('reject_del_qty') }}" id="frmRejectQty">
					{{ csrf_field() }}
					<input type="hidden" name="enc_note_id" id="enc_note_id">
					<div class="row">
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.quantity') }} (M³)</label>
							<input type="text" class="form-control reject_qty" name="reject_qty" placeholder="{{ trans('admin.quantity') }} (M³)" data-rule-required="true" data-rule-number="true">
							<label class="error" id="reject_qty_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.rejected_excess_by') }}</label>
							<select name="reject_by" class="select2" id="reject_by" data-rule-required="true">
								<option value="">{{ trans('admin.select') }}</option>
								<option value="1">{{ trans('admin.internal_reason') }}</option>
								<option value="2">{{ trans('admin.customer_end') }}</option>
								<option value="3">{{ trans('admin.excess_qty') }}</option>
							</select>
							<label id="reject_by-error" class="error" for="reject_by"></label>
						</div>
						<div class="form-group col-sm-12">
							<label>{{ trans('admin.remark') }}</label>
							<textarea name="remark" rows="2" cols="2" class="form-control" placeholder="{{ trans('admin.remark') }}" ></textarea>
						</div>

						<div class="form-group col-sm-6 is_transfer" style="display:none">
							<label>{{ trans('admin.type') }}</label>
							<select name="is_transfer" class="select2" id="is_transfer">
								<option value="">{{ trans('admin.select') }}</option>
								<option value="1">{{ trans('admin.transfer') }}</option>
								<option value="2">{{ trans('admin.lost_wastage') }}</option>
							</select>
							<label id="is_transfer-error" class="error" for="is_transfer"></label>
						</div>

						<div class="form-group col-sm-6 transfer_to" style="display:none">
							<label>{{ trans('admin.transfer_to') }}</label>
							<select name="transfer_to" class="select2" id="transfer_to">
								<option value="">{{ trans('admin.select') }}</option>
								<option value="1">{{ trans('admin.new_customer') }}</option>
								<option class="same_customer" value="2">{{ trans('admin.same_customer') }}</option>
							</select>
							<label id="transfer_to-error" class="error" for="transfer_to"></label>
						</div>

						<div class="form-group col-sm-6 to_customer_id" style="display:none">
							<label>{{ trans('admin.select') }} {{ trans('admin.customer') }}</label>
							<select name="to_customer_id" class="select2" id="to_customer_id">
								<option value="">{{ trans('admin.select') }} {{ trans('admin.customer') }}</option>
							</select>
							<label id="to_customer_id-error" class="error" for="to_customer_id"></label>
						</div>

						<input type="hidden" name="ord_details_id" id="ord_details_id">

						<div class="form-group col-sm-6 load_qty" style="display:none">
							<label>{{ trans('admin.new') }} (M³)</label>
							<input type="text" class="form-control load_qty" name="load_qty" id="load_qty" placeholder="New (M³)" data-rule-number="true">
							<label class="error" id="load_qty_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
							<h4 style="color:red;">Note: Once you save you can't edit or cancel</h4>
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
		                </div>
				           
				        </div>
					</div>

				</form>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<!-- Edit Qty Modal -->
<div class="modal fade right" id="details_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.rejection_details') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<ul class="personal-info">
					<li>
						<div class="title">{{ trans('admin.rejected_by') }}</div>
						<div class="text" id="rej_by"></div>
					</li>
					<li>
						<div class="title">{{ trans('admin.rejected_reason') }}</div>
						<div class="text" id="rej_re"></div>
					</li>
					<li>
						<div class="title">{{ trans('admin.rejected') }} M³</div>
						<div class="text" id="rej_qt"></div>
					</li>
				</ul>

			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->



<script type="text/javascript">
// body add class for sidebar start
var body = document.body;
body.classList.add("mini-sidebar");
// body add class for sidebar end
	$(document).ready(function() {

		$('.select2').select2();

		var table = $('#leadsTable').DataTable({
			// "pageLength": 2
			'responsive': true,
			"order" : [[ 0, 'desc' ]],
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '{{ Config::get('app.project.title') }} Invoice',
				filename: '{{ Config::get('app.project.title') }} Invoice PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Invoice',
				filename: '{{ Config::get('app.project.title') }} Invoice EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Invoice CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		// Handle click on "Expand All" button
	    $('#btn-show-all-children').on('click', function(){
	        // Expand row details
	        console.log(table.rows(':not(.parent)').nodes().to$().find('td:first-child'));
	        table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
	    });

	    // Handle click on "Collapse All" button
	    $('#btn-hide-all-children').on('click', function(){
	        // Collapse row details
	        table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
	    });

		function time() {
			var d = new Date();
			var s = d.getSeconds();
			var m = d.getMinutes();
			var h = d.getHours();
			var inputTime = ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
			$('.commonTime').val(inputTime);
		}

		setInterval(time, 1000);

		$('.mainDateInput').datepicker({
			// setDate: new Date(),
			format: 'yyyy/mm/dd',
			// todayHighlight: true,
			// autoclose: true,
			// startDate: '-0m',
			// minDate: 0,
		}).on('changeDate', function(ev){
			$('#filterForm').submit();
		});

		$("#show_all_del_note").click(function(){
			$('#filterForm').submit();
		});

		$('body').on('click','.btn-del-note', function() {

			var enc_id = $(this).data('ord-det_id');

			$.ajax({
				url: "{{ Route('get_del_note_det','') }}/"+enc_id,
  				type:'POST',
  				data: {
  					_token : "{{ csrf_token() }}"
  				},
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					hideProcessingOverlay();
  					if(response.status.toLowerCase() == 'success') {
  						$("#exampleModal").modal("show");
  						$('#del_note_form_wrapp').html(response.html);
  					}
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
		});

		$('#update_qty').validate({});
		$('#frmRejectQty').validate({});

		$('.closeForm').click(function(){
			$("#update_qty").modal('hide');
			$("#reject_qty_model").modal('hide');
			form_reset();
		});

		function form_reset() {
			$('#update_qty')[0].reset();
			$('#frmRejectQty')[0].reset();
		}

		/*$(".transfer_to").hide();
		$(".to_customer_id").hide();
		$(".is_transfer").hide();
		$(".load_qty").hide();*/

		$('#reject_by').change(function(){
			$(".transfer_to").hide();
			$(".to_customer_id").hide();
			$(".is_transfer").hide();
			$(".load_qty").hide();
			var reject_by = $(this).val();
			if(reject_by!=''){
				$("#is_transfer").val('');
				$('#is_transfer').attr('data-rule-required',true);
				console.log('1');
				$(".is_transfer").show();
			}

			if(reject_by!='' && reject_by==3){
				document.getElementById("transfer_to").options[2] = null;
			}
		});

		$('#is_transfer').change(function(){
			var type = $(this).val();
			if(type!='' && type != 1)
			{
				$(".transfer_to").hide();
				$(".to_customer_id").hide();
				$('#transfer_to').attr('data-rule-required',false);
			}
			else if(type!='' && type == 1)
			{
				$('#transfer_to').attr('data-rule-required',true);
				$(".transfer_to").show();
			}
		});

		$('#to_customer_id').change(function(){
			var reject_by = $('#reject_by').val();
			var load_qty_max = 12 - reject_by; 
			if(reject_by!='' && reject_by == 3){
				$(".load_qty").show();
				$('#load_qty').attr('data-rule-required',true);
				$('#load_qty').attr('data-rule-max',load_qty_max);
			}
		});

		$('#transfer_to').change(function(){
			var transfer_to = $(this).val();
			var enc_note_id = $('#enc_note_id').val();
			$(".to_customer_id").hide();
			$('#to_customer_id').attr('data-rule-required',false);
			if(transfer_to == 1)
			{
				$.ajax({
						url:"{{ Route('get_same_product_customer','') }}/"+enc_note_id,
						type:'GET',
						dataType:'json',
						success:function(resp){
							if(resp.status == 'success'){
								if(typeof(resp.arr_cust) == "object"){
									var option ='<option value="">Select Customer</option>';
									$(resp.arr_cust).each(function(index,cust){   
				                        option+='<option value="'+cust.id+'">'+cust.id+' - '+cust.first_name+' '+cust.last_name+' - ('+cust.location+') - '+cust.product_name+'</option>';

				                        $('#ord_details_id').val(cust.ord_details_id);
				                    });
				                    $('select[name="to_customer_id"]').html(option);
								}
							}
						}
				});

				$('#to_customer_id').attr('data-rule-required',true);

				$(".to_customer_id").show();
			}
		});

	});

	function submitDelNote(e) {

		//isLoaded();

		e = e || window.event;
	    var target = e.target || e.srcElement;
	    e.preventDefault();

		var action = $("#del_note_form").attr('action');
		var postData = $("#del_note_form").serialize();

		if($("#del_note_form").valid()) {
			$.ajax({
				url: action,
  				type:'POST',
  				data: postData,
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					//location.reload(true);
  					$("#exampleModal").modal('hide');
  					$('.del_note_form_submit').hide();
  					
  					location.reload(true);
  					$('.del_note_form_submit').hide();
  					hideProcessingOverlay();
  					common_ajax_store_action(response);
  					

  					//var pdf_url = "{{ Route('dowload_del_note','') }}/"+response.id;
  					//$('#pdf').attr('src',pdf_url);
  					//isLoaded();

  					//printJS(pdf_url);
  					//hideProcessingOverlay();
  					//displayNotification(response.status, response.message, 5000);


  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});
			e.stopImmediatePropagation();
    		return false;
		}

	}

	var readymix = "{{ trans('admin.readymix') }}";
	var customer = "{{ trans('admin.customer') }}";
	var excess_qty = "{{ trans('admin.excess_qty') }}";
	$('.pay_mod').click(function(){
		var id = $(this).data('ord-det-id');
		var ord_qty = $(this).data('ord-qty');
		var dlv_qty = $(this).data('dlv-qty');
		$(".quantity").attr('min',dlv_qty);
		$('input[name="enc_order_id"]').val(id);
		$('input[name="quantity"]').val(ord_qty);
	});

	$('body').on('click','.rej_mod',function(){
		var enc_note_id = $(this).data('note-id');
		var qty = $(this).data('qty');
		$('input[name="enc_note_id"]').val(enc_note_id);
		$('.reject_qty').attr('data-rule-max',qty);
	});

	$('body').on('click','.rej_details',function(){
		var rej_by = $(this).data('rejected-by');
		var rej_re = $(this).data('rejected-reason');
		var rej_qt = $(this).data('rejected-qty');
		var excess_qt = $(this).data('excess-qty');
		if(rej_by == 1){
			var by = readymix;
			$('#rej_qt').html(rej_qt);
		}
		else if(rej_by == 2){
			var by = customer;
			$('#rej_qt').html(rej_qt);
		}
		else if(rej_by == 3){
			var by = excess_qty;
			$('#rej_qt').html(excess_qt);
		}
		$('#rej_by').html(by);
		$('#rej_re').html(rej_re);
	});

	function isLoaded()
	{
	  $('#pdf').attr('src','http://localhost/ready_mix/delivery_orders/dowload_del_note/Mzc=');
	  var pdfFrame = window.frames["pdf"];
	  pdfFrame.focus();
	  pdfFrame.print();
	}

</script>

@stop
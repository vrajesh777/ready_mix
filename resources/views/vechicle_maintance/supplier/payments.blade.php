@php
	//dd($arr_trans);
	$order_amt = $credit_amt = 0;
	if(isset($arr_trans) && !empty($arr_trans))
	{
		foreach($arr_trans as $key => $row)
		{
			$order_amt += $row['vechicle_pur_order']['total'] ?? 0;
		}
	}
	$credit_amt = array_sum(array_column($arr_trans,'amount'));
	$remaining_amt = $order_amt - $credit_amt;
@endphp
<div class="col-md-9">

	<div class="col text-right">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <a href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" data-toggle="modal" data-target="#payment_model" onclick="form_reset()">{{ trans('admin.add') }} {{ trans('admin.payment') }}</a>
            </li>
        </ul>
	</div>
	<div class="col">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <b>{{ trans('admin.total') }} {{ trans('admin.order_amount') }}({{ trans('admin.sar') }}) : {{ number_format($order_amt,2) ?? 0 }} |</b>
            </li>
            <li class="list-inline-item">
                <b>{{ trans('admin.paid_amount') }}({{ trans('admin.sar') }}) : {{ number_format($credit_amt,2) ?? 0 }} |</b>
            </li>
            <li class="list-inline-item">
                <b>{{ trans('admin.remaining_amt') }}({{ trans('admin.sar') }}) : {{ number_format($remaining_amt,2) ?? 0 }}</b>
            </li>
        </ul>
	</div>

	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
					<thead>
						<tr>
							<th>{{ trans('admin.sr_no') }}</th>
							<th>{{ trans('admin.transaction_id') }}</th>
							<th>{{ trans('admin.amount') }}</th>
							<th>{{ trans('admin.payment_mode') }}</th>
							<th>{{ trans('admin.type') }}</th>
							<th>{{ trans('admin.date') }}</th>
							{{-- <th class="notexport">Action</th> --}}
						</tr>
					</thead>
					<tbody>

						@if(isset($arr_trans) && !empty($arr_trans))

							@foreach($arr_trans as $key => $row)

							<?php
								$enc_id = base64_encode($row['id']);
							?>

							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $row['trans_no'] ?? 'N/A' }}</td>
								<td>{{ format_price($row['amount']) ?? 'N/A' }}</td>
								<td>{{ $row['pay_method_details']['name'] ?? 'N/A' }}</td>
								<td>{{ $row['type'] ?? '' }}</td>
								<td>{{ $row['pay_date'] ?? '' }}</td>
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

<!-- Modal -->
<div class="modal fade right" id="payment_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.payment') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<form method="POST" action="{{ Route('add_vc_supplier_payment') }}" id="add_payment">
					{{ csrf_field() }}
					<input type="hidden" name="cust_id" value="{{ $id ?? 0 }}">
					<div class="row">

				        <div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.amount_received') }} <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" min="1" class="form-control" placeholder="{{ trans('admin.amount_received') }}" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.transaction_id') }}</label>
							<input type="text" class="form-control" name="trans_id" placeholder="{{ trans('admin.transaction_id') }}">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.payment_date') }} <span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.payment_mode') }}<span class="text-danger">*</span></label></label>
	                        <select class="select" name="pay_method_id" data-rule-required="true">
								<option value="">No Selected</option>
								@if(isset($arr_pay_methods) && !empty($arr_pay_methods))
									@foreach($arr_pay_methods as $method)
										<option value="{{ $method['id'] }}">{{ $method['name'] ?? '' }}</option>
									@endforeach
								@endif
							</select>
							<label id="pay_method_id-error" class="error" for="pay_method_id"></label>
							<label class="error" id="pay_method_id_error"></label>
						</div>

						<div class="form-group col-md-12">
							<label class="col-form-label">{{ trans('admin.leave_a_note') }}</label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="{{ trans('admin.leave_a_note') }}" ></textarea>
	                        <label class="error" id="note_error"></label>
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

<script type="text/javascript">
	$(document).ready(function() {
		$('#leadsTable').DataTable({
		});

		$('.closeForm').click(function(){
			$("#add_payment").modal('hide');
			form_reset();
		});

		$('#add_payment').validate({});

	});

	function form_reset() {
		$('#add_payment')[0].reset();
	}
</script>
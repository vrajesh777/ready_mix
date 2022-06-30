<div class="col-md-9">

	<div class="col text-right">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <a href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" data-toggle="modal" data-target="#payment_model" onclick="form_reset()">Add Payment</a>
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

						@if(isset($arr_inv_pay) && !empty($arr_inv_pay))

						@foreach($arr_inv_pay as $key => $row)

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
							{{-- <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" href="{{ Route('delete_payment', $enc_id ) }}" onclick="return confirm('Are you sure want to delete this record?')" >Delete</a>
									</div>
								</div>
							</td> --}}
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
                <h4 class="modal-title text-center">Add Payment</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<form method="POST" action="{{ Route('add_contract_payment') }}" id="add_payment">
					{{ csrf_field() }}
					<input type="hidden" name="cust_id" value="{{ $id ?? 0 }}">
					<div class="row">

						<div class="form-group col-sm-6">
							<label class="col-form-label">Account<span class="text-danger">*</span></label></label>
	                        <select class="select" name="enc_id" data-rule-required="true">
								<option value="">Select</option>
								@if(isset($arr_contract) && !empty($arr_contract))
									@foreach($arr_contract as $contract)
										<option value="{{ base64_encode($contract['id'] ?? 0) }}">{{ $contract['contract_no'] ?? '' }} {{ $contract['site_location'] ?? '' }}</option>
									@endforeach
								@endif
							</select>
							<label id="enc_id-error" class="error" for="enc_id"></label>
							<label class="error" id="enc_id_error"></label>
						</div>

				        <div class="form-group col-md-6">
							<label class="col-form-label">Amount Received <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" min="1" class="form-control" placeholder="Enter Amount" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>Transaction ID</label>
							<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label">Payment Date <span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">Payment Mode <span class="text-danger">*</span></label></label>
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
							<label class="col-form-label"> Leave a note </label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="Note" ></textarea>
	                        <label class="error" id="note_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded closeForm">Cancel</button>
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
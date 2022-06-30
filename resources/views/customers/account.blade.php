<div class="col-sm-9">
	<div class="col text-right">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <a href="{{ Route('cust_create_contract',['id'=>$enc_id]) }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task">{{  trans('admin.add') }} {{  trans('admin.account') }}</a>
            </li>
        </ul>
	</div>
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0 datatable">
					<thead>
						<tr>
							<th>{{ trans('admin.contract') }} #</th>
							<th>{{ trans('admin.title') }}</th>
							<th>{{ trans('admin.status') }}</th>
							<th>{{ trans('admin.actions') }}</th>
						</tr>
					</thead>

					<tbody>
						@if(isset($arr_contract) && sizeof($arr_contract)>0 )
							@foreach($arr_contract as $data)
								<tr>
									<td>{{ $data['contract_no'] ?? '' }}</td>
									<td>{{ $data['title'] ?? '' }} {{ $data['last_name'] ?? '' }}</td>
									<td>{{ $data['status'] ?? '' }}</td>
									<td class="text-center">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item action-edit" href="{{ Route('cust_edit_contract',  base64_encode($data['id'])) }}">{{ trans('admin.edit') }}</a>
												<a class="dropdown-item action-edit" href="{{ Route('cust_view_contract', base64_encode($data['id'])) }}">{{ trans('admin.view') }}</a>
												<a class="dropdown-item pay_mod" href="javascript:void(0);" id="pay_mod" data-toggle="modal" data-target="#payment_model" data-cust-id="{{ $data['cust_id'] ?? '' }}" data-contract-id="{{ $data['id'] ?? '' }}">{{ trans('admin.payment') }}</a>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
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

				<form method="POST" action="{{ Route('add_contract_payment') }}" id="add_payment">
					{{ csrf_field() }}
					<input type="hidden" name="enc_id" id="enc_id">
					<input type="hidden" name="cust_id" id="cust_id">
					<div class="row">
				        <div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.amount_received') }} <span class="text-danger">*</span></label>
	                        <input type="number" name="amount" min="1" class="form-control" placeholder="Enter Amount" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.transaction_id') }}</label>
							<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID">
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
							<label class="col-form-label"> {{ trans('admin.leave_a_note') }} </label>
	                        <textarea name="note" rows="2" cols="5" class="form-control" placeholder="Note" ></textarea>
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
		$('.pay_mod').click(function(){
			var id = $(this).data('contract-id');
			var cust_id = $(this).data('cust-id');
			$('input[name="enc_id"]').val(btoa(id));
			$('input[name="cust_id"]').val(cust_id);
		});

		$('#add_payment').validate({});
	});
</script>

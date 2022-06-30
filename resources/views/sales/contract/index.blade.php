@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col">

			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false">{{ trans('admin.status') }}</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="{{Route('cust_contract')}}">{{ trans('admin.all') }}</a>
					<a class="dropdown-item" href="{{Route('cust_contract',['status'=>'unsigned'])}}">{{ trans('admin.unsigned') }}</a>
                    <a class="dropdown-item" href="{{Route('cust_contract',['status'=>'signed'])}}">{{ trans('admin.signed') }}</a>
				</div>
			</div>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('sales-account-create'))
	                <li class="list-inline-item">
	                	<a href="{{ Route('cust_create_contract') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.new') }} {{ trans('admin.account') }} </a>
	                </li>
	            @endif
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		@include('layout._operation_status')

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="contractTable">
						<thead>
							<tr>
								<th>{{ trans('admin.account') }} #</th>
								<th>{{ trans('admin.title') }}</th>
								<th>{{ trans('admin.customer') }}</th>
								<th>{{ trans('admin.site') }} {{ trans('admin.name') }} </th>
								<th>{{ trans('admin.site') }} {{ trans('admin.location') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_contract) && !empty($arr_contract))
							@foreach($arr_contract as $contract)
								<tr>
									<td>{{ $contract['contract_no'] ?? '' }}</td>
									<td>{{ $contract['title'] ?? '' }}</td>
									<td>{{ $contract['cust_details']['first_name'] ?? '' }} &nbsp; {{ $contract['cust_details']['last_name'] ?? '' }}</td>
									<td>{{ $contract['title'] ?? '' }}</td>
									<td>{{ $contract['site_location'] ?? '' }}</td>
									<td>{{ ucfirst($contract['status']) ?? 'N/A' }}</td>
		                            <td class="text-center">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
											<div class="dropdown-menu dropdown-menu-right">
												@if($obj_user->hasPermissionTo('sales-account-update'))
													<a class="dropdown-item action-edit" href="{{ Route('cust_edit_contract',  base64_encode($contract['id'])) }}">Edit</a>
													<a class="dropdown-item pay_mod" href="javascript:void(0);" id="pay_mod" data-toggle="modal" data-target="#payment_model" data-cust-id="{{ $contract['cust_id'] ?? '' }}" data-contract-id="{{ $contract['id'] ?? '' }}">Payment</a>
												@endif
												<a class="dropdown-item action-edit" href="{{ Route('cust_view_contract', base64_encode($contract['id'])) }}">View</a>
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
</div>

<!-- Modal -->
<div class="modal fade right" id="payment_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.payment') }}  </h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('add_contract_payment') }}" id="add_payment">
					{{ csrf_field() }}
					<input type="hidden" name="enc_id" id="enc_id">
					<input type="hidden" name="cust_id" id="cust_id">
					<div class="row">
				        <div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.amount_received') }}<span class="text-danger">*</span></label>
	                        <input type="number" name="amount" min="1" class="form-control" placeholder="Enter Amount" data-rule-required="true">
	                        <label class="error" id="amount_error"></label>
						</div>
						<div class="form-group col-sm-6">
							<label>{{ trans('admin.transaction_id') }}</label>
							<input type="text" class="form-control" name="trans_id" placeholder="Transaction ID">
							<label class="error" id="trans_id_error"></label>
						</div>

						<div class="form-group col-md-6">
							<label class="col-form-label">{{ trans('admin.payment_date') }}<span class="text-danger">*</span></label>
	                        <input type="text" name="pay_date" class="form-control datepicker" value="{{ date('Y-m-d') }}" data-rule-required="true">
	                        <label class="error" id="pay_date_error"></label>
						</div>

						<div class="form-group col-sm-6">
							<label class="col-form-label">{{ trans('admin.payment_mode') }} <span class="text-danger">*</span></label></label>
	                        <select class="select" name="pay_method_id" data-rule-required="true">
								<option value="">{{ trans('admin.amount_received') }}No Selected</option>
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
							<label class="col-form-label"> {{ trans('admin.leave_a_note ') }}</label>
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

<!-- /Content End -->

<script type="text/javascript">

	$(document).ready(function() {

		$('#contractTable').DataTable({
			// "pageLength": 2
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
				title: '{{ Config::get('app.project.title') }} Customer Contract',
				filename: '{{ Config::get('app.project.title') }} Customer Contract PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Customer Contract',
				filename: '{{ Config::get('app.project.title') }} Customer Contract EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Customer Contract CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		$('.pay_mod').click(function(){
			var id = $(this).data('contract-id');
			var cust_id = $(this).data('cust-id');
			$('input[name="enc_id"]').val(btoa(id));
			$('input[name="cust_id"]').val(cust_id);
		});

		$('#add_payment').validate({});

		$('.closeForm').click(function(){
			$("#add_payment").modal('hide');
			form_reset();
		});

		function form_reset() {
			$('#add_payment')[0].reset();
		}



	});


</script>

@stop
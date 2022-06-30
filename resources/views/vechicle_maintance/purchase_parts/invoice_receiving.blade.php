@extends('layout.master')
@section('main_content')

<form method="POST" action="{{ Route('invoice_receiving_store') }}" id="formAddUser" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="row">
		<div class="col-sm-12">

			@include('layout._operation_status')
			
			<div class="card">
				<div class="card-body">
					<div class="row">
                        <div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.purchase_order') }} <span class="text-danger">*</span></label>
	                            <select name="p_order_id" class="select2" id="purchase_order" data-rule-required="true">
									<option value="">{{ trans('admin.select') }} {{ trans('admin.purchase_order') }}</option>
									@if(isset($arr_purchase_order) && sizeof($arr_purchase_order)>0)
										@foreach($arr_purchase_order as $purchase_order)
											<option value="{{ $purchase_order['id'] ?? '' }}">{{ $purchase_order['order_number'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
								<input type="hidden" name="order_number" id="order_number"/>
								<div class="error">{{ $errors->first('purchase_order') }}</div>
	    					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.supplier') }} <span class="text-danger">*</span></label>
	                            <select name="supplier_id" class="select2" id="supplier_id" data-rule-required="true" disabled>
									<option value="">{{ trans('admin.select') }} {{ trans('admin.supplier') }}</option>
									@if(isset($arr_supplier) && sizeof($arr_supplier)>0)
										@foreach($arr_supplier as $supplier)
											<option value="{{ $supplier['id'] ?? '' }}">
												@if(\App::getLocale() == 'ar')
													<span>{{ $supplier['first_name'] ?? '' }}</span>
												@else
													<span> {{ $supplier['last_name'] ?? '' }}</span>
												@endif											</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('supplier_id') }}</div>
	    					</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.receiving_date') }}<span class="text-danger">*</span></label>
	                            <input class="form-control datepicker pr-5" name="receiving_date" value="{{date('d-M-Y')}}" id="receiving_date" data-rule-required="true" placeholder="Date" autocomplete="off" disabled>
								<div class="error">{{ $errors->first('receiving_date') }}</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.invoice_id') }}<span class="text-danger">*</span></label>
	                            <input class="form-control pr-5" name="invoice_id" id="invoice_id" data-rule-required="true" placeholder="{{ trans('admin.invoice_id') }}" autocomplete="off">
								<div class="error">{{ $errors->first('invoice_id') }}</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.received') }}<span class="text-danger">*</span></label>
	                            <select name="received" data-rule-required="true" class="form-control">
                                    <option>{{ trans('admin.yes') }}</option>
                                    <option>{{ trans('admin.no') }}</option>
                                </select>
	                            <div class="error">{{ $errors->first('received') }}</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.bin_id') }}<span class="text-danger">*</span></label>
	                            <input type="text" name="bin_id" data-rule-required="true" class="form-control" placeholder="{{ trans('admin.bin_id') }}">
	                            <div class="error">{{ $errors->first('bin_id') }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="order_details" style="display:none;">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h4><i class="fa fa-wrench"></i> {{ trans('admin.purchase_order') }} {{trans('admin.details')}}</h4>
					<div class="row">
						<table id="partsdata" class="table table-bordered">
							<thead>
								<tr>
									<th>{{ trans('admin.name') }}</th>
									<th>{{ trans('admin.condition') }}</th>
									<th>{{ trans('admin.qty') }}</th>
									<!-- <th></th> -->
								</tr>
							</thead>
							<tbody>
								<tr>
									<td id="name"></td>
									<td id="condition"></td>
									<td id="qty"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="text-center py-3 w-100">
    	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
    	<button type="button" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</button>
    </div>
</form>
<!-- /Page Header -->
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

<script type="text/javascript">

	$(document).ready(function() {

		initiate_form_validate();

		$('.select2').select2();

		$( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		});

		$('#purchase_order').change(function(){
			var purchase_order_id = $(this).val();
			$.ajax({
					url:"{{ Route('vhc_purchase_parts_view','') }}/"+btoa(purchase_order_id),
					type:'GET',
					dataType:'json',
					success:function(resp){

						if(resp.status == 'success')
						{
							if(typeof(resp.arr_details) == 'object')
							{
								let resData = resp.arr_details
								console.log(resData.supplier_details.id)
								$('#order_number').val(resData.order_number);
								$('#order_details').show();
								$('#name').html(resData.part.commodity_name);
								$('#condition').html(resData.condition);
								$('#qty').html(resData.quantity);
								$('#supplier_id').val(resData.supplier_details.id).trigger('change');;
							}
						}

					}
			});
		});

	});


	function initiate_form_validate() {
		$('#formAddUser').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});
	}
</script>

@stop
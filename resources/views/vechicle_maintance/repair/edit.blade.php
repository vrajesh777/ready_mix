@extends('layout.master')
@section('main_content')

@php
	$count = isset($arr_data['vhc_part_detail'])?count($arr_data['vhc_part_detail']):0;
@endphp
<form method="POST" action="{{ Route('vhc_repair_update',$enc_id) }}" id="formAddUser" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="row">
		<div class="col-sm-12">

			@include('layout._operation_status')

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.vehicle') }} <span class="text-danger">*</span></label>
	                            <select name="vechicle_id" class="select2" id="vechicle_id" data-rule-required="true" disabled>
									<option value="">{{ trans('admin.select') }} {{ trans('admin.vehicle') }}</option>
									@if(isset($arr_vechicle) && sizeof($arr_vechicle)>0)
										@foreach($arr_vechicle as $vechicle)
											<option value="{{ $vechicle['id'] ?? '' }}" @if(isset($arr_data['vechicle_id']) && $arr_data['vechicle_id']!='' && $arr_data['vechicle_id'] == $vechicle['id']) selected @endif>{{ $vechicle['name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('vechicle_id') }}</div>
	    					</div>
						</div>
						<input type="hidden" name="vechicle_id" value="{{ $arr_data['vechicle_id'] ?? 0 }}">
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.assignee') }} <span class="text-danger">*</span></label>
	                            <select name="assignee_id" class="select2" id="assignee_id" data-rule-required="true" disabled>
									<option value="">{{ trans('admin.select') }} {{ trans('admin.assignee') }}</option>
									@if(isset($arr_mechanics) && sizeof($arr_mechanics)>0)
										@foreach($arr_mechanics as $mechanic)
											<option value="{{ $mechanic['id'] ?? '' }}" @if(isset($arr_data['assignee_id']) && $arr_data['assignee_id']!='' && $arr_data['assignee_id'] == $mechanic['id']) selected @endif>
												@if(\App::getLocale() == 'ar')
													<span>{{ $mechanic['first_name'] ?? '' }}</span>
												@else
													<span> {{ $mechanic['last_name'] ?? '' }}</span>
												@endif
											</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('vechicle_id') }}</div>
	    					</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.delivery_date') }}<span class="text-danger">*</span></label>
	                            <input class="form-control datepicker pr-5" name="delivery_date" value="{{ $arr_data['delivery_date'] ?? '' }}" id="delivery_date" data-rule-required="true" placeholder="Date" autocomplete="off">
								<div class="error">{{ $errors->first('delivery_date') }}</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.time') }}<span class="text-danger">*</span></label>
	                            <input class="form-control timepicker pr-5" name="time" value="{{ $arr_data['time'] ?? '' }}" id="delivery_time" data-rule-required="true" placeholder="HH:mm" autocomplete="off">
								<div class="error">{{ $errors->first('time') }}</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.door_no') }}<span class="text-danger">*</span></label>
	                            <input type="text" name="door_no" value="{{ $arr_data['door_no'] ?? '' }}" data-rule-required="true" class="form-control" disabled>
	                            <div class="error">{{ $errors->first('door_no') }}</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.km_count') }}<span class="text-danger">*</span></label>
	                            <input type="text" name="km_count" value="{{ $arr_data['km_count'] ?? '' }}" data-rule-required="true" class="form-control" disabled>
	                            <div class="error">{{ $errors->first('km_count') }}</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.hours_meter') }}<span class="text-danger">*</span></label>
	                            <input type="text" name="hours_meter" value="{{ $arr_data['hours_meter'] ?? '' }}" data-rule-required="true" class="form-control">
	                            <div class="error">{{ $errors->first('hours_meter') }}</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.complaint') }}<span class="text-danger">*</span></label>
	                            <textarea name="complaint" value="{{ $arr_data['complaint'] ?? '' }}" data-rule-required="true" class="form-control" value="{{ date('Y-m-d') }}" disabled>{{ $arr_data['complaint'] ?? '' }}</textarea>
	                            <div class="error">{{ $errors->first('complaint') }}</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.diagnosis') }}<span class="text-danger">*</span></label>
	                            <textarea name="diagnosis" value="{{ $arr_data['diagnosis'] ?? '' }}" data-rule-required="true" class="form-control" value="{{ date('Y-m-d') }}" disabled>{{ $arr_data['diagnosis'] ?? '' }}</textarea>
	                            <div class="error">{{ $errors->first('diagnosis') }}</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.actions') }} <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="action" value="{{ $arr_data['action'] ?? '' }}" data-rule-required="true" disabled>{{ $arr_data['action'] ?? '' }}</textarea>
	                            <div class="error">{{ $errors->first('action') }}</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.note') }} <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="note" value="{{ $arr_data['note'] ?? '' }}" data-rule-required="true" disabled>{{ $arr_data['note'] ?? '' }}</textarea>
	                            <div class="error">{{ $errors->first('note') }}</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.remark') }} <span class="text-danger">*</span></label>
	                            <textarea class="form-control" name="remark" value="{{ $arr_data['remark'] ?? '' }}" data-rule-required="true">{{ $arr_data['remark'] ?? '' }}</textarea>
	                            <div class="error">{{ $errors->first('remark') }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row" id="vhc_details">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<h4><i class="fa fa-car"></i> {{ trans('admin.vehicle') }} {{ trans('admin.details') }}</h4>
					<div class="row">
						<div class="col-sm-3">
							{{ trans('admin.vehicle') }} {{ trans('admin.name') }} : <span id="vehicle_name"></span>
						</div>
						<div class="col-sm-3">
							{{ trans('admin.make') }} : <span id="make"></span>
						</div>
						<div class="col-sm-3">
							{{ trans('admin.model') }} : <span id="model"></span>
						</div>
						<div class="col-sm-3">
							{{ trans('admin.year') }} : <span id="year"></span>
						</div>
						<div class="col-sm-3">
							{{ trans('admin.chasis_no') }} : <span id="chasis_no"></span>
						</div>
						<div class="col-sm-3">
							{{ trans('admin.vin_no') }}# : <span id="vin_no"></span>
						</div>
						<div class="col-sm-3">
							{{ trans('admin.registration_no') }} : <span id="reg_no"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">

			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<h4><i class="fa fa-wrench"></i> {{ trans('admin.add') }} {{ trans('admin.parts') }}</h4>
						</div>
						<div class="col-sm-6">
							<button type="button" class="btn btn-primary float-right" id="addItemBtn" style="margin-bottom: 5px;"><i class="fa fa-plus-circle"></i></button>
						</div>
						<div class="col-sm-12">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>{{ trans('admin.item') }}</th>
										<th>{{ trans('admin.code') }}</th>
										<th>{{ trans('admin.unit') }}</th>
										<th>{{ trans('admin.qty') }}</th>
									</tr>
								</thead>
								<tbody class="items-wrapp">
									@if(isset($arr_parts) && count($arr_parts) > 0)
									@foreach($arr_parts as $part)
									<tr>
										<td>
											@if(isset($arr_items) && count($arr_items) > 0)
											@endif
											<select name="item[]" class="form-control item-inp">
												<option>-- Select Item --</option>
												@if(isset($arr_items) && count($arr_items) > 0)
												@foreach($arr_items as $item)
													<option value="{{ $item['id'] ?? '' }}" {{ $part['item_id'] == $item['id'] ? 'selected' : '' }} >{{ $item['commodity_name'] ?? 'N/A' }}</option>
												@endforeach
												@endif
											</select>
										</td>
										<td>
											<input type="text" name="code[]" class="form-control" value="{{ $part['item']['commodity_code'] ?? '' }}" readonly>
										</td>
										<td>
											<input type="text" name="unit[]" class="form-control" value="{{ $part['quantity'] ?? '' }}" readonly>
										</td>
										<td>
											<input type="number" name="quantity[]" class="form-control" min="1" placeholder='Enter Quantity' value="{{ $part['quantity'] ?? 0 }}">
										</td>
										<td>
											<button class="btn btn-danger btn-sm btn-rm"><i class="fa fa-trash"></i></button>
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

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(document).ready(function() {

		$("#addItemBtn").click(function() {
			$('.items-wrapp')
			var $html = '';
			$html += '<tr>'
				$html += '<td>'
					$html += '<select name="item[]" class="form-control item-inp">'
						$html += '<option>-- Select Item --</option>'
							@if(isset($arr_items) && count($arr_items) > 0)
							@foreach($arr_items as $item)
						$html += '<option value="'+"{{ $item['id'] ?? '' }}"+'">'+"{{ $item['commodity_name'] ?? 'N/A' }}"+'</option>'
							@endforeach
							@endif
					$html += '</select>'
				$html += '</td>'
				$html += '<td>'
					$html += '<input type="text" name="code[]" class="form-control" value="" readonly>'
				$html += '</td>'
				$html += '<td>'
					$html += '<input type="text" name="unit[]" class="form-control" value="" readonly>'
				$html += '</td>'
				$html += '<td>'
					$html += '<input type="number" name="quantity[]" class="form-control" min="1" value="1" placeholder="Enter Quantity">'
				$html += '</td>'
				$html += '<td>'
					$html += '<button class="btn btn-danger btn-sm btn-rm"><i class="fa fa-trash"></i></button>'
				$html += '</td>'
			$html += '</tr>'

			$(".items-wrapp").append($html);

		});

		$('body').on('click', '.btn-rm', function() {
			var that = $(this);
			that.parents('tr').remove();
		});

		$('body').on('change', '.item-inp', function() {
			var item_id = $(this).val();
			var that = $(this);
			$.ajax({
				url:"{{ Route('get_item_details','') }}/"+btoa(item_id),
				type:'POST',
				dataType:'json',
				success:function(resp) {
					if(resp.status == 'success')
					{
						if(typeof(resp.data) == 'object')
						{
							that.parents('tr').find('input[name="unit[]"]').val(resp.data.unit_name);
							that.parents('tr').find('input[name="code[]"]').val(resp.data.commodity_code);
						}
					}

				}
			});
		});

		initiate_form_validate();

		$('.select2').select2();

		$( '#delivery_date' ).datepicker({
			format:'yyyy-mm-dd',
			autoclose: true,
			startDate: "dateToday",
		});
		
		$('.timepicker').datetimepicker({
			format : 'HH:mm'
        });
		var vhc_id = $('#vechicle_id').val();
		vechicle_details(vhc_id);
		$('.decrement_repair_stock').change(function(){
			let isChecked = $(this).is(':checked');
			decrementRepairStockCall(vhc_id,isChecked)
		})
	});

	function vechicle_details(vhc_id)
	{
		$.ajax({
			url:"{{ Route('vechicle_details','') }}/"+btoa(vhc_id),
			type:'GET',
			dataType:'json',
			success:function(resp) {
				if(resp.status == 'success')
				{
					if(typeof(resp.arr_vechicle) == 'object')
					{
						$('#vhc_details').show();
						$('#vehicle_name').html(resp.arr_vechicle.name);
						$('#make').html(resp.arr_vechicle.make.make_name);
						$('#model').html(resp.arr_vechicle.model.model_name);
						$('#year').html(resp.arr_vechicle.year.year);
						$('#chasis_no').html(resp.arr_vechicle.chasis_no);
						$('#vin_no').html(resp.arr_vechicle.vin_no);
						$('#reg_no').html(resp.arr_vechicle.regs_no);
					}
				}
			}
		});
	}


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

	function decrementRepairStockCall(vhc_id,isChecked)
	{
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$.ajax({
			url:"{{ Route('decrement_repair_stock','') }}/"+btoa(vhc_id)+"?isChecked="+isChecked,
			type:'POST',
			dataType:'json',
			success:function(resp) {
				if(resp.message)
				{
					alert(resp.message)
				}
			}
		});
	}
</script>

@stop
@extends('layout.master')
@section('main_content')

<?php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
?>
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/js') }}/daterangepicker.min.js"></script>
<link href="{{ asset('/css/') }}/daterangepicker.css" rel="stylesheet" />
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col-sm-12">
			<form action="{{ $module_url_path }}/delivery_invoice" method="get" id="filterDeliveryForm" name="filterDeliveryForm">
				<ul class="list-inline-item pl-0">
					<li class="list-inline-item mb-2">
						<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
					</li>
	                <li class="list-inline-item mb-2">
	                	<a id="clear_btn" href="javascript:void(0);" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded px-3"><i class="fal fa-times" style="font-size:20px;"></i></a>
	                </li>
                
	            </ul>
        	</form>
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
					<table class="table table-stripped mb-0 deliveryNotesTable" id="deliveryNotesTable">
						<thead>
							<tr>
								
								<th>{{ trans('admin.delivery_no') }}</th>
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
  							@if(isset($arr_delivery_note) && count($arr_delivery_note)>0)
							@foreach($arr_delivery_note as $key => $note)
						    	<?php
						    		$driver = $note['driver']??[];
						    		$vehicle = $note['vehicle']??[];
						    		$is_added_on_erp = $note['is_pushed_to_erp']??0;
						    		$del_date = Carbon::parse($note['delivery_date'])->format('Y-m-d');
						    	?>
						    	
							    	<tr>
							    		<td>{{ $note['delivery_no']??'' }}</td>
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

							            	@if(isset($note['status']) && $note['status']=='pending')
							            	<a class="btn btn-primary btn-sm"  onclick="change_confirm_status('{{ base64_encode($note['id']) }}')">Confirm Invoice</a>

							            	<button type="button" class="btn btn-danger" onclick="change_cancel_status('{{ base64_encode($note['id']) }}')">Cancel Invoice
								            </button>					            	

							            	@endif

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
<div class="modal fade right" id="change_status_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">Change Invoice Status</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST"  id="frm_change_status">
					{{ csrf_field() }}
					<input type="hidden" name="enc_order_id" id="enc_order_id">
					<input type="hidden" name="delivery_status" id="delivery_status">
					<div class="row">
						<div class="form-group col-sm-6">
							<label>Enter Reason</label>
							<input type="text" class="form-control reason" name="reason" placeholder="Enter Reason" data-rule-required="true" data-rule-maxlength="255">
							<label class="error" id="reason_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
		                	<button type="button" onclick="window.location.href='{{ $module_url_path }}'" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
		                </div>
				           
				        </div>
					</div>

				</form>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<script type="text/javascript">

	$(document).ready(function() {

		$('#deliveryNotesTable').DataTable({});

		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: '{{$sdt??''}}',
		    endDate: '{{$edt??''}}'
		})
		.on('changeDate', function(e) {
			$('#filterDeliveryForm').submit();
			//load_delivery_note();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});

		$('#frm_change_status').validate();
		$('#frm_change_status').on('submit',function(event){
			 event.preventDefault()
			if($('#frm_change_status').valid())
			{

				    var form = $('#frm_change_status')[0];
		            var data = new FormData(form);
		            $.ajax({
		                    type: "POST",
		                    url: "{{ $module_url_path }}/change_delivery_status",
		                    data:data,
		                    processData: false,
		                    contentType: false,
		                    cache: false,
		                    beforeSend:function(){
							showProcessingOverlay();
						    },
		                    success: function(response){
		                       	hideProcessingOverlay();
								common_ajax_store_action(response);
		                    }
		                }); 
			}
		})
		
	});
	$('#clear_btn').click(function(){
		window.location.href="{{ Route('delivery_invoice') }}";
	});
	function change_cancel_status(enc_id)
	{
		$('#enc_order_id').val(enc_id);
		$('#change_status_model').modal('show');
	}
	function change_confirm_status(enc_id)
	{
		 if(enc_id!="")
		 {
		 	$.ajax({
						url:"{{ $module_url_path }}/change_confirm_invoice/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){
							showProcessingOverlay();
						},
						success:function(response){
							hideProcessingOverlay();
							common_ajax_store_action(response);
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		 }
	}
</script>

@stop
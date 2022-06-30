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
			<form action="{{ $module_url_path }}/confirmed_invoice" method="get" id="filterDeliveryForm" name="filterDeliveryForm">
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
											@if($note['is_pushed_to_erp']=='0')
											 <a class="btn btn-primary btn-sm"  id="add_to_erp" href="{{ Route('add_to_erp',base64_encode($note['id'])) }}">Push To ERP</a>
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

		$('.change_status').click(function(){

			var status = $(this).data('status');
			var enc_id = $(this).data('note-id');
			$('#enc_order_id').val(enc_id);
			$('#delivery_status').val(status);
		})
		$('#frm_change_status').validate();
	});
	


</script>

@stop
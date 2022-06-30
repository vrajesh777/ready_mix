@extends('layout.master')
@section('main_content')
@php
	$sdt = \Carbon::parse($start_date??'')->format('d/m/Y');
	$edt = \Carbon::parse($end_date??'')->format('d/m/Y');
@endphp
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
                    <select name="reject_by" class="select" id="reject_by">
		            	<option value="">{{ trans('admin.select') }}</option>
						<option value="1" @if(isset($reject_by) && $reject_by!='' && $reject_by == '1') selected @endif>{{ trans('admin.internal_reason') }}</option>
						<option value="2" @if(isset($reject_by) && $reject_by!='' && $reject_by == '2') selected @endif>{{ trans('admin.customer_end') }}</option>
					</select>
                </li>
                <li class="list-inline-item">
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
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="driverTable">
						<thead>
							<tr>
								<th>{{ trans('admin.cust') }}</th>
								<th>{{ trans('admin.customer') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.load_no') }}</th>
					            <th>{{ trans('admin.truck') }}</th>
					            <th>{{ trans('admin.loaded_cbm') }}</th>
					            <th>{{ trans('admin.rej') }}(M³)</th>
					            <th>{{ trans('admin.rej_by') }}</th>
					            <th>{{ trans('admin.driver') }}</th>
					            <th>{{ trans('admin.del_date') }}</th>
					            {{-- <th>{{ trans('admin.status') }}</th> --}}
					            <th>{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $note)
							    	<?php
							    		$driver = $note['driver']??[];
							    		$vehicle = $note['vehicle']??[];

							    		$del_date = Carbon::parse($note['delivery_date'])->format('Y-m-d');
							    	?>
							    	<tr>
							    		<td>{{ $note['order_details']['order']['cust_id'] ?? 0 }}</td>
							    		<td>{{ $note['order_details']['order']['cust_details']['first_name'] ?? '' }} {{ $note['order_details']['order']['cust_details']['last_name'] ?? '' }}</td>
							    		<td>{{ $note['load_no'] ?? 0 }}</td>
							            <td>{{ $vehicle['name']??'' }}&nbsp;
							            	({{$vehicle['plate_no']??''}} {{$vehicle['plate_letter']??''}})
							            </td>
							            <td>{{ $note['quantity']??'' }}</td>
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
							            {{-- <td>{{ $note['status']??'' }}</td> --}}
							            <td>
							            	<a class="btn btn-primary btn-sm rej_details" id="rej_details" href="javascript:void(0);" data-toggle="modal" data-target="#details_model" data-rejected-by="{{ $note['reject_by'] ?? '' }}" data-rejected-reason="{{ $note['remark']?? 0 }}" data-rejected-qty="{{ $note['reject_qty']?? 0 }}" data-note-id="{{ base64_encode($note['id']) }}"><i class="fa fa-eye" title="{{ trans('admin.details') }}"></i></a>
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
<!-- /Content End -->
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
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>

<script type="text/javascript">

	$(document).ready(function(){
		$('#driverTable').DataTable({
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

		$("#reject_by").change(function() {
			$("#filterForm").submit();
		});
	});

	var readymix = "{{ trans('admin.readymix') }}";
	var customer = "{{ trans('admin.customer') }}";

	$('body').on('click','.rej_details',function(){
		var rej_by = $(this).data('rejected-by');
		var rej_re = $(this).data('rejected-reason');
		var rej_qt = $(this).data('rejected-qty');
		if(rej_by == 1){
			var by = readymix;
		}
		else if(rej_by == 2){
			var by = customer;
		}
		$('#rej_by').html(by);
		$('#rej_re').html(rej_re);
		$('#rej_qt').html(rej_qt);
	});

	$('#clear_btn').click(function(){
		window.location.href="{{ Route('rejected_del') }}";
	});
</script>

@stop
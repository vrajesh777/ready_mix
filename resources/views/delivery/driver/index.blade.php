@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>
		
<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
			<div class="form-group col-sm-2 transfer_to">
				<label>{{ trans('admin.trip_report_by') }} - {{ trans('admin.role') }}</label>
				<select name="role" class="select2" id="role_id">
				<option value="">{{ trans('admin.select') }}</option>
					<option value="6" {{$role===6?'selected':''}}>{{ trans('admin.driver') }}</option>
					<option value="12" {{$role===12?'selected':''}}>{{ trans('admin.pump_op') }}</option>
					<option value="13" {{$role===13?'selected':''}}>{{ trans('admin.pump_helper') }}</option>
				</select>
				<label id="transfer_to-error" class="error" for="transfer_to"></label>
			</div>
			<div class="form-group col-sm-3 transfer_to">
				<label>{{ trans('admin.date_range') }} - {{ trans('admin.role') }}</label>
				<input type="text" name="dateRange" class="form-control text-center" id="dateRange" value="" >
			</div>
			<div class="form-group col-sm-3 transfer_to">
				<button id="search" class="border-0 m-3 btn btn-primary btn-gradient-primary btn-rounded">
					{{trans('admin.search')}}
				</button>
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
								<th>{{ trans('admin.id_number') }}</th>
								<th>{{ trans('admin.date') }}</th>
								<th>{{ trans('admin.name') }}</th>
								<th>{{ trans('admin.initial_trip') }}</th>
								<th>{{ trans('admin.initial_rate') }}</th>
								<th>{{ trans('admin.additional_trip') }}</th>
								<th>{{ trans('admin.additional_rate') }}</th>
								<th>{{ trans('admin.total') }}</th>
								<th>{{ trans('admin.amount') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
								<?php 
									$totalAmount = 0;
									$initial_trip = $value['initial_trip'] ?? 0;
									$initial_rate = $value['initial_rate'] ?? 0;
									$additional_trip = $value['additional_trip'] ?? 0;
									$additional_rate = $value['additional_rate'] ?? 0;
									if($value['tripCount']){
										if($value['tripCount'] <= $initial_trip)
											$totalAmount = $value['tripCount'] * $initial_rate;
										else{
											$totalAmount = $initial_trip * $initial_rate;
											$totalAmount += ($value['tripCount']-$initial_trip)* $additional_rate;
										}
									} ?>
									<tr>
										<td>{{ $value['id_number'] ?? '-' }}</td>
										<td>{{ $value['date'] ?? '-' }}</td>
										<td>{{ $value['first_name'] ?? '' }} {{ $value['last_name'] ?? '' }}</td>
										<td>{{ $value['initial_trip'] ?? '' }}</td>
										<td>{{ $value['initial_rate'] ?? '' }}</td>
										<td>{{ $value['additional_trip'] ?? '' }}</td>
										<td>{{ $value['additional_rate'] ?? '' }}</td>
										<td>{{ $value['tripCount'] ?? '' }}</td>
										<td>{{ $totalAmount ?? 00 }}</td>
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

<!-- Add Modal -->
<div class="modal right fade" id="add_driver" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{trans('admin.add')}} {{trans('admin.driver')}}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('driver_store') }}" id="frmAddDriver" enctype="multipart/form-data">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.first_name')}}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{trans('admin.first_name')}}" data-rule-required="true">
                					<label class="error" id="first_name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.last_name')}}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{trans('admin.last_name')}}" data-rule-required="true">
                					<label class="error" id="last_name_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.email')}}</label>
                					<input type="email" class="form-control" name="email" id="email" placeholder="{{trans('admin.email')}}">
                					<label class="error" id="email_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.mobile_no')}}</label>
                					<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="{{trans('admin.mobile_no')}}" data-rule-digits="true">
                					<label class="error" id="mobile_no_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.id_number')}}</label>
                					<input type="text" class="form-control" name="id_number" id="id_number" placeholder="{{trans('admin.id_number')}}" data-rule-digits="true" data-rule-maxlength="10" data-rule-minlength="3">
                					<label class="error" id="id_number_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{trans('admin.driving_licence')}}
									<a target="_blank" style="display:none" id="download"><i class="fa fa-download"></i></a>
									</label>
		                           	<div class="position-relative p-0">
		        						<input type="file" class="file-text form-control" name="driving_licence" id="driving_licence" accept="application/pdf,image/jpeg,image/jpg,image/png">
		    						</div>
								</div>
							</div>
							
			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{trans('admin.save')}}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{trans('admin.cancel')}}</button>
			                </div>
			            </form>
			        </div>
				</div>
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- Add modal -->
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet" />

<script type="text/javascript">

	var createUrl = "{{ Route('driver_store') }}";
	var updateUrl = "{{ Route('driver_update','') }}";

	$(document).ready(function(){
		$('#frmAddDriver').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#frmAddDriver").submit(function(e) {

			e.preventDefault();

			var formData = new FormData(this);

			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data: formData,
      				dataType:'json',
      				processData: false,
					contentType: false,
					beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
      				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#add_driver").modal('hide');
			form_reset();
		});

		$('#driverTable').DataTable({
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
				title: '{{ Config::get('app.project.title') }} Drivers',
				filename: '{{ Config::get('app.project.title') }} Drivers PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Drivers',
				filename: '{{ Config::get('app.project.title') }} Drivers EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Drivers CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
		$('.select2').select2();

		$(document).on('click','#search',function(){
			let url = "{{ Route('driver') }}";
			let role = $('#role_id').val();
			// let fromDate = $('#dateRange').val().slice(0,10);
			// 	fromDate = moment(fromDate).format('YYYY-MM-DD');
			// let toDate = $('#dateRange').val().slice(13,23);
			// 	toDate = moment(toDate).format('YYYY-MM-DD');

			let fromDate = $('#dateRange').data('daterangepicker').startDate;
				fromDate = moment(fromDate).format('YYYY-MM-DD');
			let toDate = $('#dateRange').data('daterangepicker').endDate;
				toDate = moment(toDate).format('YYYY-MM-DD');
			// toDate = moment(toDate,'yyyy-mm-dd');
			
			if(role){
				url += '?role='+role
				if(fromDate && toDate)
					url += '&fromDate='+fromDate+'&toDate='+toDate;
				window.location.href = url;
			}
		});
		var myStartDate = "{{Request::get('fromDate')}}";
		if(myStartDate)
			myStartDate = moment(myStartDate).format("DD-MM-YYYY")
		var myEndDate = "{{Request::get('toDate')}}";
		if(myEndDate)
			myEndDate = moment(myEndDate).format("DD-MM-YYYY")
		// console.log(myStartDate,myEndDate)
		$("#dateRange").daterangepicker({
			locale: {
		      format: 'DD/MM/YYYY'
		    },
		    startDate: myStartDate ? myStartDate :moment().startOf('year').format('DD-MM-YYYY'),
		    endDate:  myEndDate? myEndDate : moment(new Date()).format("DD-MM-YYYY"),
			minDate:  moment().startOf('year').format('DD-MM-YYYY'),
			maxDate:  moment(new Date()).format("DD-MM-YYYY"),
		})
		.on('changeDate', function(e) {
			$("#filterForm").submit();
		});

		$("#dateRange").change(function(){
			$('#dateRange').trigger('changeDate');
		});
	});

	function form_reset() {
		$('#frmAddDriver')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	var license_image_path = "{{ $driving_licence_public_path }}";
	function driver_edit(enc_id)
	{
		$('.top_title').html('Edit Driver');
		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'SUCCESS')
							{
								$('#frmAddDriver').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

  								$('#driving_licence').attr('data-rule-required',false);
  								$('#lic_req').hide();

								$('#first_name').val(response.data.first_name);
								$('#last_name').val(response.data.last_name);
								$('#email').val(response.data.email);
								$('#mobile_no').val(response.data.mobile_no);
								$('#id_number').val(response.data.id_number);

								if(response.data.driving_licence!=null)
								{
								 	var lic_path = license_image_path+response.data.driving_licence;
								 	$('#download').attr('href',lic_path);
								 	$('#download').show();
								}

							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}
</script>
@stop
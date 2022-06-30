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
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_manuf" onclick="form_reset()">{{ trans('admin.new') }} {{ trans('admin.manufacturer') }}</button>
                </li>
            </ul>
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
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.image') }}</th>
								<th>{{ trans('admin.name') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['id'] ?? '' }}</td>
										<td>
											@if($value['image']!='' && file_exists($manufacturer_img_base_path.$value['image']))
												<img src="{{ $manufacturer_img_public_path.$value['image'] }}" alt="" width="70">
											@else
												<img src="" alt="" width="70">
											@endif
										</td>
										<td>{{ $value['name'] ?? '' }}</td>
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('manufacturer_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('manufacturer_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>
										<td class="text-center">
											<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_manuf" onclick="manuf_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
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

<!-- Add Modal -->
<div class="modal right fade" id="add_manuf" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }}  {{ trans('admin.manufacturer') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('manufacturer_store') }}" id="frmAddDriver" enctype="multipart/form-data">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.manufacturer') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('admin.manufacturer') }} {{ trans('admin.name') }}" data-rule-required="true">
                					<label class="error" id="name_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.image') }}{{-- <span id="img_req" class="text-danger">*</span> --}}
									<a target="_blank" style="display:none" id="download"><i class="fa fa-download"></i></a>
									</label>
		                           	<div class="position-relative p-0">
		        						<input type="file" class="file-text form-control" name="image" id="image" accept="application/pdf,image/jpeg,image/jpg,image/png">
		    						</div>
								</div>
							</div>
							
			                <div class="py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div>
			            </form>
			        </div>
				</div>
			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- Add modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('manufacturer_store') }}";
	var updateUrl = "{{ Route('manufacturer_update','') }}";

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
			$("#add_manuf").modal('hide');
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


	});

	function form_reset() {
		$('#frmAddDriver')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	var image_path = "{{ $manufacturer_img_public_path }}";
	function manuf_edit(enc_id)
	{
		$('.top_title').html('Edit Manufacturer');
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

  								$('#image').attr('data-rule-required',false);
  								$('#img_req').hide();

								$('#name').val(response.data.name);
								if(response.data.image!=null)
								{
								 	var img_path = image_path+response.data.image;
								 	$('#download').attr('href',img_path);
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
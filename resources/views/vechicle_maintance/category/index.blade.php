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
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_item" onclick="form_reset()">{{ trans('admin.add') }} {{ trans('admin.category') }}</button>
                </li>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<div class="row">
	<div class="col-sm-12">
		<div class="card mb-0">
			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="itemsTable">
						<thead>
							<tr>
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.category') }}</th>
								<th class="notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0 )
								@foreach($arr_data as $data)
									<tr>
										<td>{{ $data['id'] ?? '' }}</td>
                                        @if(\App::getLocale() == 'ar')
                                        <td>{{ $data['name_arabic'] ?? '' }}</td>
                                        @else
                                        <td>{{ $data['name_english'] ?? '' }}</td>
                                        @endif
                                        </td>
										<td class="text-center">
											<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item" onclick="item_edit('{{base64_encode($data['id'] ?? '')}}')"><i class="fa fa-edit"></i></button>
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
			
<!-- Add Modal -->
<div class="modal right fade" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.category') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="post" action="{{ Route('maintenance_category_store') }}" id="frmAddItem">
		            {{ csrf_field() }}
					<div class="row">
		            	<input type="hidden" name="action" value="create">
				        <div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane show active">
									<div class="row">
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.category') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
			            					<input type="text" class="form-control"  name="name_arabic" id="name_arabic" placeholder="{{ trans('admin.category') }} {{ trans('admin.name') }} {{ trans('admin.arebic') }}" data-rule-required="true">
										</div>
                                        <div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.category') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"  name="name_english" id="name_english" placeholder="{{ trans('admin.category') }} {{ trans('admin.name') }} {{ trans('admin.english') }}" data-rule-required="true">
										</div>
									</div>
								</div>
							</div>

			                <div class="py-3">
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
	var createUrl = "{{ Route('maintenance_category_store') }}";
	var updateUrl = "{{ Route('maintenance_category_update','') }}";

	$(document).ready(function(){

		$('.select2').select2();

		$('#frmAddItem').validate({
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

		$("#frmAddItem").submit(function(e) {
			e.preventDefault();
			if($(this).valid()) {

				actionUrl = createUrl;
				if($('input[name=action]').val() == 'update') {
					actionUrl = updateUrl;
				}
				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
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
			$("#add_item").modal('hide');
			form_reset();
		});


		$('#itemsTable').DataTable({
			// "pageLength": 2
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
				title: '{{ Config::get('app.project.title') }} Items',
				filename: '{{ Config::get('app.project.title') }} Items PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Items',
				filename: '{{ Config::get('app.project.title') }} Items EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Items CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

	});

	function form_reset() {
		$('#frmAddItem')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function item_edit(enc_id)
	{
		var title = "{{ trans('admin.edit') }}"+" {{ trans('admin.category') }}";
		$('.top_title').html(title);
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
							console.log(response)

							if(response.status == 'success')
							{
								$('#frmAddItem').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#name_arabic').val(response.name_arabic);
                                $('#name_english').val(response.name_english);
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}
</script>
@endsection
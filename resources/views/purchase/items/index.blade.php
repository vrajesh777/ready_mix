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
				@if($obj_user->hasPermissionTo('purchase-item-create'))
	                <li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_item" onclick="form_reset()">{{ trans('add ') }} {{ trans('item ') }}</button>
	                </li>
                @endif
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
								<th>{{ trans('admin.image') }}</th>
								<th>{{ trans('admin.commodity_code') }}</th>
								<th>{{ trans('admin.commodity_name') }}</th>
								<th>{{ trans('admin.group_name') }}</th>
								<th>{{ trans('admin.unit_name') }}</th>
								<th>{{ trans('admin.price') }}</th>
								<th>{{ trans('admin.tax') }}</th>
								<th class="notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0 )
								@foreach($arr_data as $data)
									<tr>
										<td>
											@if(isset($data['item_images'][0]['image']) && $data['item_images'][0]['image']!='')
												@if(is_file($item_image_base_path.$data['item_images'][0]['image']))
													<img src="{{ $item_image_public_path.$data['item_images'][0]['image'] }}" alt="" width="70">
												@else
													<img src="" alt="" width="70">
												@endif
											@endif
										</td>
										<td>{{ $data['commodity_code'] ?? '' }}</td>
										<td>{{ $data['commodity_name'] ?? '' }}</td>
										<td>{{ $data['commodity_group_detail']['name'] ?? '' }}</td>
										<td>{{ $data['unit_detail']['unit_name'] ?? '' }}</td>
										<td>{{ number_format($data['purchase_price'],2) ?? '' }}</td>
										<td>{{ $data['tax_detail']['name'] ?? '' }}</td>
										<td class="text-center">
											<div class="btn-group">
											 	<a href="javascript:void(0)" data-toggle="dropdown" class="action">
											   		<i class="fas fa-ellipsis-v"></i>
											  	</a>
											  	<div class="dropdown-menu dropdown-menu-right">
											   		<button class="dropdown-item" type="button" data-toggle="modal" data-target="#view_item" onclick="item_view('{{base64_encode($data['id'] ?? '')}}')">{{ trans('admin.view') }}</button>
											   		@if($obj_user->hasPermissionTo('purchase-item-update'))
											    		<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item" onclick="item_edit('{{base64_encode($data['id'] ?? '')}}')">{{ trans('admin.edit') }}</button>
											    	@endif
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
			
<!-- Add Modal -->
<div class="modal right fade" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{ trans('admin.add') }} {{ trans('admin.item') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
					<form method="post" action="{{ Route('items_store') }}" id="frmAddItem" enctype="multipart/form-data">
		            {{ csrf_field() }}
		            	<input type="hidden" name="action" value="create">
				        <div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane show active">
									<div class="row">
										{{-- <div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.commodity_code') }} <span class="text-danger">*</span></label>
				                            <input type="text" class="form-control"  name="commodity_code" id="commodity_code" placeholder="{{ trans('admin.commodity_code') }}" data-rule-required="true">
				                            <label class="error" id="commodity_code_error"></label>
										</div> --}}
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.commodity_name') }} <span class="text-danger">*</span></label>
			            					<input type="text" class="form-control"  name="commodity_name" id="commodity_name" placeholder="{{ trans('admin.commodity_name') }}" data-rule-required="true">
										</div>
			                            {{-- <div class="form-group col-md-4">
			                            	<label class="col-form-label"> {{ trans('admin.commodity_barcode') }} <span class="text-danger">*</span></label>
			                                <input class="form-control" type="text" placeholder="Commodity Barcode" name="commodity_barcode" id="commodity_barcode" data-rule-required="true">
			                                <label class="error" id="commodity_barcode_error"></label>
			                            </div> --}}
			                            {{-- <div class="form-group col-md-4">
			                            	<label class="col-form-label">{{ trans('admin.sku_code') }} <span class="text-danger">*</span></label>
			                                <input class="form-control" type="text" placeholder="{{ trans('admin.sku_code') }}" name="sku_code" id="sku_code" data-rule-required="true">
			                                <label class="error" id="sku_code_error"></label>
			                            </div> --}}
			                            {{-- <div class="form-group col-md-4">
			                            	<label class="col-form-label">Sku Name<span class="text-danger">*</span></label>
			                                <input class="form-control" type="text" placeholder="Last name" name="sku_name" id="sku_name" data-rule-required="true">
			                                <label class="error" id="sku_name_error"></label>
			                            </div> --}}
			                      
								
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.commodity_group') }}</label>
				                            <select class="form-control select2" id="commodity_group" name="commodity_group">
												<option value="">{{ trans('admin.commodity_group') }}</option>
												@if(isset($arr_commodity_group) && sizeof($arr_commodity_group)>0)
													@foreach($arr_commodity_group as $group)
														<option value="{{ $group['id'] ?? '' }}">{{ $group['name'] ?? '' }}</option>
													@endforeach
												@endif
											</select>
										</div>

										{{-- <div class="form-group col-sm-6">
											<label class="col-form-label">Rate<span class="text-danger">*</span></label>
			            					<input type="text" class="form-control"  name="rate" id="rate" placeholder="Rate" data-rule-required="true" data-rule-number=true>
			            					<label class="error" id="rate_error"></label>
										</div> --}}
									
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.price') }}<span class="text-danger">*</span></label>
			            					<input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="{{ trans('admin.price') }}" data-rule-required="true" data-rule-number=true>
			            					<label class="error" id="purchase_price_error"></label>
										</div>
									
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.units') }}<span class="text-danger">*</span></label>
				                            <select class="form-control select2" id="units" name="units" data-rule-required="true">
												<option value="">{{ trans('admin.select') }} {{ trans('admin.units') }}</option>
												@if(isset($arr_units) && sizeof($arr_units)>0)
													@foreach($arr_units as $units)
														<option value="{{ $units['id'] ?? '' }}">{{ $units['unit_name'] ?? '' }}</option>
													@endforeach
												@endif
											</select>
											<label class="error" id="units_error"></label>
										</div>
												
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.taxes') }}</label>
				                            <select class="form-control" id="tax_id" name="tax_id">
				                                <option value="">{{ trans('admin.select') }} {{ trans('admin.tax') }}</option>
				                                @if(isset($arr_taxes) && sizeof($arr_taxes)>0)
				                                	@foreach($arr_taxes as $tax)
				                                		<option value="{{ $tax['id'] ?? '' }}">{{ $tax['name'] ?? '' }}</option>
				                                	@endforeach
				                                @endif
				                            </select>
										</div>

										<div class="form-group col-sm-12">
											<label>{{ trans('admin.description') }}</label>
											<textarea rows="5" cols="5" class="form-control" placeholder="{{ trans('admin.description') }}" name="description" id="description"></textarea>
										</div>
										
									</div>

									<div class="user-box user-box-upload-section">
								       
							            <div class="main-abt-title">
							                <label class="name-labell">{{ trans('admin.images') }}{{-- <span class="busine-span-smll"> ( Maximum 5 Images ) </span> --}}</label>
							            </div>
								       
							            <div class="add-busine-multi">
							                <span data-multiupload="3">
							                    <span data-multiupload-holder></span>
							                    <span class="upload-photo">
							                        <img src="{{ asset('/images/plus-img.jpg') }}" alt="plus img">
							                        <input data-multiupload-src class="upload_pic_btn" type="file" multiple="" data-rule-required="false"> 
							                        <span data-multiupload-fileinputs></span>
							                    </span>
							                </span>
							                <div class="clerfix"></div>
							            </div>
								     
								        <div class="clearfix"></div>   

								        <div class="photo-gallery mt-4">
										 	<div class="row photos item_images">

									            {{-- <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="images/desk.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="images/desk.jpg"></a></div> --}}
									            
									        </div>
									    </div>

								    </div>
								</div>
							</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div> 
				        </div>
			        </form>

				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<!-- View Modal -->
<div class="modal right fade" id="view_item" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.view') }} {{ trans('admin.item') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">

					<div class="col-md-12 d-flex">
						<div class="card profile-box flex-fill">
							<div class="card-body">
								<h3 class="card-title border-bottom pb-2 mt-0 mb-3">{{ trans('admin.details') }} {{-- <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a> --}}</h3>
								<ul class="personal-info border rounded">
									<li>
										<div class="title">{{ trans('admin.commodity_code') }}</div>
										<div class="text" id="view_commodity_code"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.commodity_name') }}</div>
										<div class="text" id="view_commodity_name"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.commodity_barcode') }}</div>
										<div class="text" id="view_commodity_barcode"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.sku_code') }}</div>
										<div class="text" id="view_sku_code"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.sku_name') }}</div>
										<div class="text" id="view_sku_name"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.commodity_group') }}</div>
										<div class="text" id="view_commodity_group"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.rate') }}</div>
										<div class="text" id="view_rate"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.purchase_price') }}</div>
										<div class="text" id="view_purchase_price"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.units') }}</div>
										<div class="text" id="view_units"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.tax') }}</div>
										<div class="text" id="view_tax_id"></div>
									</li>
									<li>
										<div class="title">{{ trans('admin.description') }}</div>
										<div class="text" id="view_description"></div>
									</li>
									
								</ul>
								<div class="photo-gallery mt-4">
								 	<div class="row photos item_images">

							            {{-- <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="images/desk.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="images/desk.jpg"></a></div> --}}
							            
							        </div>
							    </div>
							</div>
						</div>
					</div>

				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->

<script type="text/javascript">
	var createUrl = "{{ Route('items_store') }}";
	var updateUrl = "{{ Route('items_update','') }}";

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
		$('.top_title').html('Edit Item');
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
								$('#frmAddItem').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#commodity_code').val(response.data.commodity_code);
								$('#commodity_name').val(response.data.commodity_name);
								$('#commodity_barcode').val(response.data.commodity_barcode);
								$('#sku_code').val(response.data.sku_code);
								$('#sku_name').val(response.data.sku_name);
								$('#description').val(response.data.description);
								$('#rate').val(response.data.rate);
								$('#purchase_price').val(response.data.purchase_price);
								$('select[name^="commodity_group"] option[value="'+response.data.commodity_group+'"]').attr("selected","selected");
								$('.select2').trigger('change');
								$('select[name^="units"] option[value="'+response.data.units+'"]').attr("selected","selected");
								$('.select2').trigger('change');
								$('select[name^="tax_id"] option[value="'+response.data.tax_id+'"]').attr("selected","selected");

								var item_images = '';
								$.each(response.data.item_images, function( index, value ) {
								  	item_images += '<div class="col-sm-6 col-md-4 col-lg-3 item"><a href="'+item_image_public_path+value.image+'" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="'+item_image_public_path+value.image+'"></a></div>';
								});

								$('.item_images').html(item_images);
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}

	var item_image_public_path = "{{ $item_image_public_path ?? '' }}"; 
	function item_view(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){

						},
						success:function(response){
							if(response.status == 'SUCCESS')
							{
								$('#view_commodity_code').html(response.data.commodity_code);
								$('#view_commodity_name').html(response.data.commodity_name);
								$('#view_commodity_barcode').html(response.data.commodity_barcode);
								$('#view_sku_code').html(response.data.sku_code);
								$('#view_sku_name').html(response.data.sku_name);
								$('#view_description').html(response.data.description);
								$('#view_rate').html(response.data.rate);
								$('#view_purchase_price').html(response.data.purchase_price);

								$('#view_commodity_group').html(response.data.commodity_group_detail.name);
								$('#view_units').html(response.data.unit_detail.unit_name);
								$('#view_tax_id').html(response.data.tax_detail.name);

								
								var item_images = '';
								$.each(response.data.item_images, function( index, value ) {
								  	item_images += '<div class="col-sm-6 col-md-4 col-lg-3 item"><a href="'+item_image_public_path+value.image+'" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="'+item_image_public_path+value.image+'"></a></div>';
								});

								$('.item_images').html(item_images);

							}
						}
				  });
		}
	}
</script>
@endsection
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
				@if($obj_user->hasPermissionTo('purchase-vendor-create'))
	                <li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_vendor" onclick="form_reset()">{{ trans('admin.add') }} {{ trans('admin.vendor') }}</button>
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
					<table class="table table-striped table-nowrap custom-table mb-0 datatable">
						<thead>
							<tr>
								<th>{{ trans('admin.id') }}</th>
								<th>{{ trans('admin.company') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.email') }}</th>
								<th>{{ trans('admin.phone') }}</th>
								<th>{{ trans('admin.created_on') }}</th>
								@if($obj_user->hasPermissionTo('purchase-vendor-update'))
									<th>{{ trans('admin.status') }}</th>
									<th>{{ trans('admin.actions') }}</th>
								@endif
							</tr>
						</thead>

						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0 )
								@foreach($arr_data as $data)
									<tr>
										<td>{{ $data['id'] ?? '' }}</td>
										<td><a href="{{ Route('vendors_view',base64_encode($data['id'])) }}"> {{ search_in_user_meta($data['user_meta'], 'company') ?? '' }}</a></td>
										<td>{{ $data['email'] ?? '' }}</td>
										<td>{{ search_in_user_meta($data['user_meta'], 'phone') ?? '' }}</td>
										<td>{{ date('Y-m-d h:i A',strtotime($data['created_at'])) ?? '' }}</td>
										@if($obj_user->hasPermissionTo('purchase-vendor-update'))
										<td>
											@if($data['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('vendors_deactivate', base64_encode($data['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('vendors_activate',base64_encode($data['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>
										<td class="text-center">
											<div class="btn-group">
											 	<a href="javascript:void(0)" data-toggle="dropdown" class="action">
											   		<i class="fas fa-ellipsis-v"></i>
											  	</a>
											  	<div class="dropdown-menu dropdown-menu-right">
											    	<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_vendor" onclick="vendor_edit('{{base64_encode($data['id'] ?? '')}}')">{{ trans('admin.edit') }}</button>
											  	</div>
											</div>
										</td>
										@endif
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
<div class="modal right fade" id="add_vendor" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title top_title">{{ trans('admin.add') }} {{ trans('admin.vendor') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
					<form method="post" action="{{ Route('vendors_store') }}" id="frmAddVendor" enctype="multipart/form-data">
		            {{ csrf_field() }}
		            	<input type="hidden" name="action" value="create">
				        <div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane show active">
									<div class="row">
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.company') }}<span class="text-danger">*</span></label>
				                            <input type="text" class="form-control"  name="company" id="company" placeholder="{{ trans('admin.company') }}" data-rule-required="true">
				                            <label class="error" id="company_error"></label>
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.email') }}<span class="text-danger">*</span></label>
				                            <input type="email" class="form-control"  name="email" id="email" placeholder="{{ trans('admin.email') }}" data-rule-required="true" data-rule-email="true">
				                            <label class="error" id="email_error"></label>
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.vat_number') }}</label>
			            					<input type="text" class="form-control"  name="vat_number" id="vat_number" placeholder="{{ trans('admin.vat_number') }}" data-rule-number="true">
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.phone') }}</label>
			            					<input type="text" class="form-control"  name="phone" id="phone" placeholder="{{ trans('admin.phone') }}" data-rule-number="true">
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.website') }}</label>
			            					<input type="text" class="form-control"  name="website" id="website" placeholder="{{ trans('admin.website') }}">
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.address') }}</label>
			            					<input type="text" class="form-control"  name="address" id="address" placeholder="{{ trans('admin.address') }}">
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.city') }}</label>
			            					<input type="text" class="form-control"  name="city" id="city" placeholder="{{ trans('admin.city') }}">
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.state') }}</label>
			            					<input type="text" class="form-control"  name="state" id="state" placeholder="{{ trans('admin.state') }}">
										</div>
										<div class="form-group col-sm-6">
											<label class="col-form-label">{{ trans('admin.zip_code') }}</label>
			            					<input type="text" class="form-control"  name="postal_code" id="postal_code" placeholder="{{ trans('admin.zip_code') }}" data-rule-number="true" minlength="5" maxlength="6">
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


<script type="text/javascript">
	var createUrl = "{{ Route('vendors_store') }}";
	var updateUrl = "{{ Route('vendors_update','') }}";

	$(document).ready(function(){

		$('.select2').select2();

		$('#frmAddVendor').validate({
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

		$("#frmAddVendor").submit(function(e) {
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
			$("#add_vendor").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddVendor')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function vendor_edit(enc_id)
	{
		$('.top_title').html('Edit Vendor');
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
								$('#frmAddVendor').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

  								$('#email').val(response.data.email);
  								$('#address').val(response.data.address);
  								$('#city').val(response.data.city);
  								$('#state').val(response.data.state);
  								$('#postal_code').val(response.data.postal_code);
								
								var item_images = '';
								$.each(response.data.user_meta, function( index, value ) {
										$('#'+value.meta_key).val(value.meta_value);
								});
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
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
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
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}
</script>
@endsection
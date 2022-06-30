@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-8 card-title mt-0 mb-2">Vendor : #{{ $arr_vendor_details['id'] ?? '' }} {{ $arr_vendor_details['user_meta'][0]['meta_value'] ?? '' }}</h4>
	@if($obj_user->hasPermissionTo('purchase-vendor-update'))
		<div class="col-md-4 justify-content-end d-flex">
			<a href="javascript:void(0)" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2" data-toggle="modal" data-target="#add_contact">{{ trans('admin.new') }} {{ trans('admin.contact') }}</a>
		</div>
	@endif
</div>


<div class="row all-reports m-0">
	
	@include('purchase.vendor._sidebar')

	<div class="col-md-9 pr-0 Reports">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 datatables">
						<thead>
							<tr>
								<th>{{ trans('admin.full_name') }}</th>
								<th>{{ trans('admin.email') }}</th>
								<th>{{ trans('admin.mobile_no') }}</th>
								<th>{{ trans('admin.position') }}</th>
								@if($obj_user->hasPermissionTo('purchase-vendor-update'))
								<th>{{ trans('admin.status') }}</th>
								<th>{{ trans('admin.actions') }}</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_conatct) && sizeof($arr_conatct)>0)
								@foreach($arr_conatct as $key => $value)
									<tr>
										<td>{{ $value['first_name'] ?? '' }} {{ $value['last_name'] ?? '' }}</td>
										<td>{{ $value['email'] ?? '' }}</td>
										<td>{{ $value['mobile_no'] ?? '' }}</td>
										<td>{{ $value['contact_detail']['role_position'] ?? '' }}</td>
										@if($obj_user->hasPermissionTo('purchase-vendor-update'))
										<td>
											@if($value['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('vendors_deactivate', base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('vendors_activate',base64_encode($value['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>
										<td>
											<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_contact" onclick="contact_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="fa fa-edit"></i></button>
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

<!-- Modal -->
<div class="modal right fade" id="add_contact" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.contact') }}</h4>
				<button type="button" class="close xs-close" data-dismiss="modal">×</button>
			</div>

			<div class="modal-body">
				<div class="row">
					<form method="post" action="{{ Route('contact_store') }}" id="frmAddContact">
		            {{ csrf_field() }}
		            <input type="hidden" name="action" value="create">
		            <input type="hidden" name="vendor_id" value="{{ $enc_id }}">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="row">
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.first_name') }}<span class="text-danger">*</span></label>
			                            <input type="text" class="form-control"  name="first_name" id="first_name" placeholder="{{ trans('admin.first_name') }}" data-rule-required="true">
			                            <label class="error" id="first_name_error"></label>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.last_name') }}<span class="text-danger">*</span></label>
			                            <input type="text" class="form-control"  name="last_name" id="last_name" placeholder="{{ trans('admin.last_name') }}" data-rule-required="true">
			                            <label class="error" id="last_name_error"></label>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.email') }}<span class="text-danger">*</span></label>
			                            <input type="email" class="form-control"  name="email" id="email" placeholder="{{ trans('admin.email') }}" data-rule-required="true">
			                            <label class="error" id="email_error"></label>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.mobile_no') }}<span class="text-danger">*</span></label>
			                            <input type="text" class="form-control"  name="mobile_no" id="mobile_no" placeholder="{{ trans('admin.mobile_no') }}" data-rule-required="true" data-rule-number="true">
			                            <label class="error" id="mobile_no_error"></label>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.role_position') }}<span class="text-danger">*</span></label>
			                            <input type="text" class="form-control"  name="role_position" id="role_position" placeholder="{{ trans('admin.role_position') }}" data-rule-required="true">
			                            <label class="error" id="role_position_error"></label>
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
	$(document).ready(function() {
		$('.datatables').DataTable({searching: true, paging: true, info: true});
	});
</script>
<script type="text/javascript">
	var createUrl = "{{ Route('contact_store') }}";
	var updateUrl = "{{ Route('contact_update','') }}";

	$(document).ready(function(){

		$('#frmAddContact').validate({
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

		$("#frmAddContact").submit(function(e) {
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
      				success:function(response)
      				{
      					common_ajax_store_action(response);
      				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#add_contact").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddContact')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function contact_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/contact_edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){

						},
						success:function(response){
							if(response.status == 'SUCCESS')
							{
								$('#frmAddContact').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#first_name').val(response.data.first_name);
								$('#last_name').val(response.data.last_name);
								$('#email').val(response.data.email);
								$('#mobile_no').val(response.data.mobile_no);
								$('#role_position').val(response.data.contact_detail.role_position);
							}
						}
				  });
		}
	}

</script>

@endsection
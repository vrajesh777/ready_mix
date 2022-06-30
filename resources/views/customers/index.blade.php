@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				@if($obj_user->hasPermissionTo('customers-create'))
	                <li class="list-inline-item">
	                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-cust-btn">{{ trans('admin.new') }} {{ trans('admin.customer') }}</button>
	                </li>
                @endif
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="card mb-0">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
				<thead>
					<tr>
						{{-- <th class="notexport">
							<label class="container-checkbox">
							  	<input type="checkbox">
							  	<span class="checkmark"></span>
							</label>
						</th> --}}
						<th>{{ trans('admin.cust') }}#</th>
						<th>{{ trans('admin.arabic_name') }}</th>
						<th>{{ trans('admin.english_name') }}</th>
						<th>{{ trans('admin.phone') }}</th>
						<th>{{ trans('admin.email') }}</th>
						<th>{{ trans('admin.created_on') }}</th>
						@if($obj_user->hasPermissionTo('customers-update'))
							<th>{{ trans('admin.actions') }}</th>
						@endif
					</tr>
				</thead>
				<tbody>

					@if(isset($arr_customers) && !empty($arr_customers))

						@foreach($arr_customers as $customer)

						<tr>
							{{-- <td class="checkBox">
								<label class="container-checkbox">
								  	<input type="checkbox">
								  	<span class="checkmark"></span>
								</label>
							</td> --}}
							<td>{{ $customer['id'] ?? '' }}</td>
							<td>
								<!-- Name in Arabic-->
								<a href="{{ Route('view_customer', base64_encode($customer['id']??'')) }}" class="showLeadDetailsBtn" >{{ $customer['first_name'] ?? '' }}</a>
							</td>
							<td>{{ $customer['last_name'] ?? '' }}</td> <!-- Name in english-->
							<td>{{ $customer['mobile_no'] ?? 'N/A' }}</td>
							<td>{{ $customer['email'] ?? 'N/A' }}</td>
							<td>{{ date('d-M-y h:i A', strtotime($customer['created_at'])) }}</td>
							@if($obj_user->hasPermissionTo('customers-update'))
								<td class="text-center actions">
									<a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#add_user" onclick="user_edit('{{base64_encode($customer['id'] ?? '')}}')"><i class="far fa-edit"></i></a>
									@if($customer['role_id']==='15')
										<button  class="enable_disable btn btn-sm {{$customer['is_active']==='1'?'btn-success':'btn-danger'}}" 
										enc_id="{{base64_encode($customer['id'] ?? '')}}" is_enable = "{{$customer['is_active']==='1' ? '1' : '0'}}"
										>{{$customer['is_active'] === '1' ? 'Active' : 'Inactive'}}</button>
									@endif
								</td>
							@endif
						</tr>

						@endforeach

					@else

						<h3 align="center">No Records Found!</h3>

					@endif
					
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- /Content End -->

<!--convert users Modal -->
<div class="modal fade right" id="add_user" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog modal-lg" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-body">

				<form method="post" action="{{ Route('store_customer') }}" id="frmAddCustomer">

	            	{{ csrf_field() }}

	            	<input type="hidden" name="lead_id" id="input-lead-id">

					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.arabic_name') }}<span class="text-danger">*</span></label>
	    					<input type="text" name="u_first_name" id="u_first_name" class="form-control" placeholder="{{ trans('admin.arabic_name') }}" data-rule-required="true">
	    					<label class="error" id="u_first_name_error"></label>
							<label class="myTest"></label>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.english_name') }}<span class="text-danger"></span></label>
	    					<input type="text" name="u_last_name" id="u_last_name" class="form-control" placeholder="{{ trans('admin.english_name') }}" data-rule-required="false">
	    					<label class="error" id="u_last_name_error"></label>
						</div>
					</div>
					<div class="form-group row">
						<!-- <div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.email') }} <span class="text-danger"></span></label>
	    					<input type="text" class="form-control" name="u_email" id="u_email" placeholder="{{ trans('admin.email') }}" data-rule-required="false" data-rule-email="false" >
	    					<label class="error" id="u_email_error"></label>
						</div> -->
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.phone') }}</label>
	    					<input type="text" class="form-control" name="u_phone" id="u_phone" placeholder="{{ trans('admin.phone') }}">
	    					<label class="error" id="u_phone_error"></label>
						</div>
					</div>
					<div class="form-group row">
						
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.address') }}</label>
	    					<input type="text" name="u_address" id="u_address" class="form-control" placeholder="{{ trans('admin.address') }}">
	    					<label class="error" id="u_address_error"></label>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.city') }}</label>
	    					<input type="text" name="u_city" id="u_city" class="form-control" placeholder="{{ trans('admin.city') }}">
	    					<label class="error" id="u_city_error"></label>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.state') }}</label>
	    					<input type="text" name="u_state" id="u_state" class="form-control" placeholder="{{ trans('admin.state') }}">
	    					<label class="error" id="u_state_error"></label>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.zip_code') }}</label>
	    					<input type="text" name="u_zip_code" id="u_zip_code" class="form-control" placeholder="{{ trans('admin.zip_code') }}">
	    					<label class="error" id="u_zip_code_error"></label>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.website') }}</label>
	    					<input type="url" name="u_website" id="u_website" class="form-control" placeholder="{{ trans('admin.website') }}">
	    					<label class="error" id="u_website_error"></label>
						</div>

						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.company') }} <span class="text-danger">*</span></label>
	    					<input type="text" name="u_company" id="u_company" class="form-control" placeholder="{{ trans('admin.company') }}" data-rule-required="true">
	    					<label class="error" id="u_company_error"></label>
						</div>
					</div>

					<!-- <div class="form-group row cust-pass-wrapp">
						<div class="col-sm-12">
							<label class="col-form-label">{{ trans('admin.password') }} <span class="text-danger"></span></label>

	    					<div class="input-group">
								<input type="password" name="u_password" id="u_password" class="form-control password" placeholder="{{ trans('admin.password') }}" data-rule-required="false">
								<div class="input-group-append">
									<span class="input-group-text toggle_pass"><i class="fa fa-eye" aria-hidden="true"></i></span>
								</div>
								<div class="input-group-append">
									<span class="input-group-text generate_pass"><i class="fa fa-retweet" aria-hidden="true"></i></span>
								</div>
							</div>
							<label id="u_password-error" class="error" for="u_password"></label>
	    					<label class="error" id="u_password_error"></label>
						</div>
					</div> -->

					<div class="form-group row">

						<div class="col-sm-12">
							<div class="checkbox">
								<label class="d-flex align-items-center">
									<input class="mr-2" type="checkbox" name="u_send_set_pass_mail" id="u_send_set_pass_mail" value="" >{{ trans('admin.send_set_password_email') }}
								</label>
								<label class="error" id="u_send_set_pass_mail_error"></label>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="checkbox">
								<label class="d-flex align-items-center">
									<input class="mr-2" type="checkbox" name="u_send_welcome_mail" id="u_send_welcome_mail" value="" > {{ trans('admin.send_welcome_email') }}
								</label>
								<label class="error" id="u_send_welcome_mail_error"></label>
							</div>
						</div>

					</div>

	                <div class="text-center py-3">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
	                </div>

	            </form>

        	</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('store_customer') }}";
	var updateUrl = "{{ Route('update_customer','') }}";

	$(document).ready(function() {

		var table = $('#leadsTable').DataTable({
			   // "pageLength": 2
			"order" : [[ 4, 'desc' ]],
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
				title: '{{ Config::get('app.project.title') }} Leads',
				filename: '{{ Config::get('app.project.title') }} Leads PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Leads',
				filename: '{{ Config::get('app.project.title') }} Leads EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Leads CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		$("#add-cust-btn").click(function(){
			form_reset();
			$('input[name=u_password]').attr('data-rule-required', true);
			initiate_form_validate();
			$("#add_user").modal('show');
		});

		$('.closeForm').click(function(){
			$("#add_user").modal('hide');
			form_reset();
		});

		$('#u_first_name').blur(function(){
			isArabic($(this));
		});

		$("#frmAddCustomer").submit(function(e) {

			e.preventDefault();

			if($(this).valid()) {

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

		$('.toggle_pass').click(function(){
			$('.password').attr('type', function(index, attr){
			    return attr == 'password' ? 'text' : 'password';
			});
		});

		$('.generate_pass').click(function() {

			// Password Generator Ref Link : https://jsfiddle.net/RaviMakwana/tq6xwea2/

			// find elements
			var pwd = $("#pwd")
			var button = $("button")
			var len = $('#Length')
			var A_Z = $('#A-Z')
			var a_z = $('#a-z')
			var num = $('#0-1')
			var sc = $('#SpecialChars')

			// CreateRandomPassword( len.val() ,A_Z.is(":checked"),a_z.is(":checked"),num.is(":checked"),sc.val());
			var randPass = CreateRandomPassword( 8 , true, true, true, '@#$%');

			$('input[name=u_password]').val(randPass);

		});
	
		$(document).on('click','.enable_disable',function(e){
			if(!confirm_action('Do you really want to Proceed ?'))
				return false;
			e.preventDefault();
			var enc_id 		= $(this).attr('enc_id');
			var is_enable	= $(this).attr('is_enable');
			var clickedBtn = $(this)

			if(enc_id!='')
			{
				$.ajax({
					url: "{{ Route('cust_status_update','') }}"+'/'+enc_id,
					type:'POST',
					dataType:'json',
					data : {'is_enable':is_enable,"_token": "{{ csrf_token() }}"},
					beforeSend: function() {
						showProcessingOverlay();
					},
					success:function(response)
					{
						hideProcessingOverlay();
						if(response.status == 'success')
						{
							var btn_text = is_enable==='1'?'Inactive':'Active';
							$(clickedBtn).text(btn_text);
							if(is_enable==='1'){
								$(clickedBtn).attr('is_enable','0');
								$(clickedBtn).toggleClass('btn-success btn-danger');
							} else {
								$(clickedBtn).attr('is_enable','1');
								$(clickedBtn).toggleClass('btn-danger btn-success');
							}
								
						}
					},
					error:function(){
						hideProcessingOverlay();
					}
			});
			}
		});
	});

	function form_reset() {
		$('#frmAddCustomer')[0].reset();
	}

	function initiate_form_validate() {
		$('#frmAddCustomer').validate({
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
	}

	function user_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
				url: "{{ Route('cust_edit','') }}"+'/'+enc_id,
				type:'GET',
				dataType:'json',
				beforeSend: function() {
			        showProcessingOverlay();
			    },
				success:function(response)
				{
					hideProcessingOverlay();
					if(response.status == 'SUCCESS')
					{
						$('#frmAddCustomer').attr('action', updateUrl+'/'+enc_id);
						$('input[name=action]').val('update');

						$('input[name=u_password]').attr('data-rule-required', false);

						if(typeof response.data != 'undefined') {
				            $.each(response.data, function (key, val) {
				            	if(key == 'postal_code') {
				            		$("#u_zip_code").val(val);
				            	}else if(key == 'mobile_no') {
				            		$("#u_phone").val(val);
				            	}else{
				                	$("#u_"+key).val(val);
				            	}
				            });
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
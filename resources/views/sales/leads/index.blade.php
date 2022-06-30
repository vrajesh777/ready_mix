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
		<div class="col">

			<div class="dropdown">
				<a class="dropdown-toggle recently-viewed" href="#" role="button" data-toggle="dropdown" aria-expanded="false"> {{ trans('admin.all') }} {{ trans('admin.leads') }}</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">{{ trans('admin.recently_viewed') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.items_following') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.all') }} {{ trans('admin.leads') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.all') }} {{ trans('admin.closed') }} {{ trans('admin.leads') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.all') }} {{ trans('admin.open') }} {{ trans('admin.leads') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.converted') }} {{ trans('admin.leads') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.my_open') }} {{ trans('admin.leads') }}</a>
                    <a class="dropdown-item" href="#">{{ trans('admin.todays') }} {{ trans('admin.leads') }}</a>
				</div>
			</div>
		</div>
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
				
                <li class="dropdown list-inline-item add-lists">
					<a class="dropdown-toggle recently-viewed pr-2" href="#" role="button" data-toggle="dropdown" aria-expanded="false"> 
						<div class="nav-profile-text">
                          <i class="fal fa-cog" aria-hidden="true"></i>
                        </div>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="#">Choose Columns</a>
                        <a class="dropdown-item" href="#">Group Columns</a>
                        <a class="dropdown-item" href="#">Sharing Settings</a>
                        <a class="dropdown-item" href="#">Rename</a>
                        <a class="dropdown-item" href="#">Clone</a>
                        <a class="dropdown-item" href="#">Delete</a>
					</div>
				</li>
				<li class="dropdown list-inline-item add-lists">
					<a class="dropdown-toggle recently-viewed pr-2" href="#" role="button" data-toggle="dropdown" aria-expanded="false"> 
						<div class="nav-profile-text">
                          <i class="fal fa-th" aria-hidden="true"></i>
                        </div>
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="leads.html">List View</a>
                        <a class="dropdown-item" href="leads-kanban-view.html">Kanban View</a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#add-new-list">Add New List View</a>
					</div>
				</li>
                
                @if($obj_user->hasPermissionTo('leads-create'))
                <li class="list-inline-item">
                    <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_lead" onclick="form_reset()" >{{ trans('admin.new') }} {{ trans('admin.lead') }}</button>
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
							<th class="notexport">
								<label class="container-checkbox">
								  	<input type="checkbox">
								  	<span class="checkmark"></span>
								</label>
							</th>
							<th>{{ trans('admin.first_name') }}</th>
							<th>{{ trans('admin.company') }}</th>
							<th>{{ trans('admin.phone') }}</th>
							<th>{{ trans('admin.email') }}</th>
							<th>{{ trans('admin.status') }}</th>
							<th>{{ trans('admin.created_on') }}</th>
							<th>{{ trans('admin.lead_owner') }}</th>
							@if($obj_user->hasPermissionTo('leads-update'))
							<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							@endif
						</tr>
					</thead>
					<tbody>

						@if(isset($arr_leads) && !empty($arr_leads))

						@foreach($arr_leads as $lead)

						<tr>
							<td class="checkBox">
								<label class="container-checkbox">
								  	<input type="checkbox">
								  	<span class="checkmark"></span>
								</label>
							</td>
							<td>
								<a href="#"><span class="person-circle-a person-circle">{{ substr($lead['name'], 0, 1) }}</span></a>
								<a href="javascript:void(0)" class="showLeadDetailsBtn" data-id="{{ base64_encode($lead['id']) }}" >{{ $lead['name'] ?? 'N/A' }}</a>
							</td>
							<td>{{ $lead['company'] ?? 'N/A' }}</td>
							<td>{{ $lead['phone'] ?? 'N/A' }}</td>
							<td>{{ $lead['email'] ?? 'N/A' }}</td>
							<td>{{ ucfirst($lead['status']) }}</td>
							<td>{{ date('d-M-y h:i A', strtotime($lead['created_at'])) }}</td>
							<td>{{ $lead['assigned_to']['name'] ?? 'N/A' }}</td>
							@if($obj_user->hasPermissionTo('leads-update'))
                            <td class="text-center">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item action-edit" data-id="{{ base64_encode($lead['id']) }}" href="javascript:void(0);">Edit This Lead</a>
										<a class="dropdown-item action-convert-cust cnvrt-to-cust-btn" data-enc-id="{{ base64_encode($lead['id']) }}" href="javascript:void(0);">Convert to Customer</a>
									</div>
								</div>
							</td>
							@endif
						</tr>

						@endforeach

						@else

						<h3 align="center">{{ trans('admin.no_record_found') }}</h3>

						@endif
						
					</tbody>
				</table>
			</div>
		</div>
	</div>

<!-- /Content End -->

<!--system users Modal -->
<div class="modal right fade" id="leads-details" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content" id="lead_modal_content">

			

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<!--convert users Modal -->
<div class="modal fade" id="convert-to-user" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog modal-lg" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-body">

				<form method="post" action="{{ Route('store_customer') }}" id="createCustForm">

	            	{{ csrf_field() }}

	            	<input type="hidden" name="lead_id" id="input-lead-id">

					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.first_name') }}<span class="text-danger">*</span></label>
	    					<input type="text" name="u_first_name" id="u_first_name" class="form-control" placeholder="{{ trans('admin.first_name') }}" data-rule-required="true">
	    					<label class="error" id="u_first_name_error"></label>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.last_name') }}<span class="text-danger">*</span></label>
	    					<input type="text" name="u_last_name" id="u_last_name" class="form-control" placeholder="{{ trans('admin.last_name') }}" data-rule-required="true">
	    					<label class="error" id="u_last_name_error"></label>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label">{{ trans('admin.email') }} <span class="text-danger">*</span></label>
	    					<input type="text" class="form-control" name="u_email" id="u_email" placeholder="{{ trans('admin.email') }}" data-rule-required="true" data-rule-email="true" >
	    					<label class="error" id="u_email_error"></label>
						</div>
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

					<div class="form-group row cust-pass-wrapp">
						<div class="col-sm-12">
							<label class="col-form-label">{{ trans('admin.password') }} <span class="text-danger">*</span></label>

	    					<div class="input-group">
								<input type="password" name="u_password" id="u_password" class="form-control password" placeholder="{{ trans('admin.password') }}" data-rule-required="true">
								<div class="input-group-append">
									<span class="input-group-text toggle_pass"><i class="fa fa-eye" aria-hidden="true"></i></span>
								</div>
								<div class="input-group-append">
									<span class="input-group-text generate_pass"><i class="fa fa-retweet" aria-hidden="true"></i></span>
								</div>
							</div>

	    					<label class="error" id="u_company_error"></label>
						</div>
					</div>

					<div class="form-group row">

						<div class="col-sm-12">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="u_send_set_pass_mail" id="u_send_set_pass_mail" value="" > {{ trans('admin.send_set_password_email') }}
								</label>
								<label class="error" id="u_send_set_pass_mail_error"></label>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="u_send_welcome_mail" id="u_send_welcome_mail" value="" > {{ trans('admin.send_welcome_email') }}
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


<!-- Modal -->
<div class="modal right fade" id="add_lead" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">{{ trans('admin.add') }} {{ trans('admin.lead') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('create_lead') }}" id="createLeadForm">

			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">

			            	<h4>{{ trans('admin.lead') }} {{ trans('admin.information') }}</h4>

							<div class="form-group row">
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.status') }} <span class="text-danger">*</span></label>
									<div class="clearfix"></div>
		                            <select name="lead_status" class="form-control select2" data-rule-required="true">
		                                <option value="">{{ trans('admin.select') }}</option>
		                                <option value="warm">Warm</option>
		                                <option value="hot">Hot</option>
		                                <option value="junk">Junk</option>
		                            </select>
		                            <label class="error" id="lead_status_error"></label>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.source') }} <span class="text-danger">*</span></label>
		                            <select name="source" class="form-control select2" data-rule-required="true">
		                                <option value="">{{ trans('admin.select') }}</option>
		                                <option value="google">Google</option>
		                                <option value="facebook">Facebook</option>
		                                <option value="email">Email</option>
		                                <option value="physical">Physical</option>
		                            </select>
		                            <label class="error" id="source_error"></label>
								</div>
								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.user_responsible') }}</label>
		                            <select name="assigned_to" class="form-control select2">
		                                <option value="">{{ trans('admin.select') }}</option>
		                                @if(isset($arr_sales_user) && !empty($arr_sales_user))
		                                @foreach($arr_sales_user as $sales_user)
		                                <option value="{{ $sales_user['id'] }}">{{ $sales_user['name'] ?? '' }}</option>
		                                @endforeach
		                                @endif
		                            </select>
		                            <label class="error" id="assigned_to_error"></label>
								</div>
							</div>

							<h4>{{ trans('admin.additional') }} {{ trans('admin.information') }}</h4>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.name') }} <span class="text-danger">*</span></label>
                					<input type="text" name="name" class="form-control" placeholder="{{ trans('admin.name') }}" data-rule-required="true">
                					<label class="error" id="name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.email') }}</label>
                					<input type="text" class="form-control"  name="email" placeholder="{{ trans('admin.email') }}">
                					<label class="error" id="email_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.address') }}</label>
                					<input type="text" name="address" class="form-control" placeholder="{{ trans('admin.address') }}">
                					<label class="error" id="address_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.position') }}</label>
                					<input type="text" name="position" class="form-control" placeholder="{{ trans('admin.position') }}">
                					<label class="error" id="position_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.city') }}</label>
                					<input type="text" name="city" class="form-control" placeholder="{{ trans('admin.city') }}">
                					<label class="error" id="city_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.state') }}</label>
                					<input type="text" name="state" class="form-control" placeholder="{{ trans('admin.state') }}">
                					<label class="error" id="state_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.website') }}</label>
                					<input type="url" name="website" class="form-control" placeholder="{{ trans('admin.website') }}">
                					<label class="error" id="website_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.zip_code') }}</label>
                					<input type="text" name="zip_code" class="form-control" placeholder="{{ trans('admin.zip_code') }}">
                					<label class="error" id="zip_code_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.phone') }}</label>
                					<input type="text" class="form-control" name="phone" placeholder="{{ trans('admin.phone') }}">
                					<label class="error" id="phone_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.company') }}</label>
                					<input type="text" name="company" class="form-control" placeholder="{{ trans('admin.company') }}">
                					<label class="error" id="company_error"></label>
								</div>
							</div>

							<h4>{{ trans('admin.description') }} {{ trans('admin.information') }}</h4>
							<div class="form-group row">
								<div class="col-sm-12">
									<label class="col-form-label">{{ trans('admin.description') }} </label>
	                            	<textarea name="description" class="form-control" rows="3" id="description" placeholder="{{ trans('admin.description') }}"></textarea>
	                            	<label class="error" id="description_error"></label>
								</div>
							</div>

							<div class="form-group row">

								<div class="col-sm-4">
									<label class="col-form-label">{{ trans('admin.date') }} {{ trans('admin.contacted') }} </label>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="contacted_today" checked=""> {{ trans('admin.today') }} ?
										</label>
										<label class="error" id="contacted_today_error"></label>
									</div>
								</div>

								<div class="col-sm-6 contact_date_wrapp" style="display: none;">
									<label class="col-form-label">{{ trans('admin.date') }} {{ trans('admin.contacted') }}</label>
                					<input type="date" name="contact_date" class="form-control">
                					<label class="error" id="contact_date_error"></label>
								</div>

							</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{ trans('admin.cancel') }}</button>
			                </div>

			            </form>
			        </div>
				</div>

			</div>

		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<script type="text/javascript">

	var createUrl = "{{ Route('create_lead') }}";
	var updateUrl = "{{ Route('update_lead','') }}";

	$(document).ready(function() {

		$('.select2').select2();

		$('#createLeadForm').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$('#createCustForm').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
		            error.insertAfter(element.parent().parent());
		        }
		        else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
		            error.appendTo(element.parent().parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$('input[name="contacted_today"]').change(function(){
			if($(this).is(':checked')) {
				$('.contact_date_wrapp').fadeOut();
			}else{
				$('.contact_date_wrapp').fadeIn();
			}
		});

		// $('input[name="contact_date"]').datepicker();

		$("#createLeadForm").submit(function(e) {

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

		$("#createCustForm").submit(function(e) {

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

		var table = $('#leadsTable').DataTable({
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

		/*table.buttons().container()
        .appendTo( $('div.eight.column:eq(0)', table.table().container()) );*/

		$('.action-edit').click(function() {

			var enc_id = $(this).data('id');

			$.ajax({
				url: "{{ Route('get_lead_details') }}",
  				type:'GET',
  				data : {
  					'enc_id' : enc_id
  				},
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success:function(response)
  				{
  					hideProcessingOverlay();
  					if(response.status == 'success') {
  						$('#createLeadForm').attr('action', updateUrl+'/'+enc_id);
  						$('input[name=action]').val('update');
  						$("#add_lead").modal('show');
				        if(typeof response.data != 'undefined') {
				            $.each(response.data, function (key, val) {
				            	if(key == 'status') {
				            		$('select[name^="lead_status"] option[value="'+val+'"]').attr("selected","selected");
				            		$('.select2').trigger('change');
				            	}else if(key == 'source') {
				            		$('select[name^="source"] option[value="'+val+'"]').attr("selected","selected");
				            		$('.select2').trigger('change');
				            	}else if(key == 'assigned') {
				            		$('select[name^="assigned_to"] option[value="'+val+'"]').attr("selected","selected");
				            		$('.select2').trigger('change');
				            	}else if(key == 'description') {
				            		$("textarea[name="+ key +"]").html(val);
				            	}else if(key == 'contacted_date') {
				            		$('input[name=contacted_today]').prop('checked', false);
				            		$(".contact_date_wrapp").show();
				            		$("input[name='contact_date']").val(val);
				            	}else{
				                	$("input[name="+ key +"]").val(val);
				            	}
				            });
				        }
				    }
				    displayNotification(response.status, response.message, 5000);
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
			});

		});

		$('.closeForm').click(function(){
			$("#add_lead").modal('hide');
			form_reset();
		});

		$('.showLeadDetailsBtn').click(function(){
			var enc_id = $(this).data('id');
			$.ajax({
				url: "{{ Route('get_lead_details_html') }}",
  				type:'GET',
  				data : {
  					'enc_id' : enc_id
  				},
  				dataType:'json',
  				beforeSend: function() {
			        showProcessingOverlay();
			    },
  				success : function(resp) {
  					hideProcessingOverlay();
  					if(resp.status == 'success') {
  						$("#leads-details").modal('show');

  						$('#lead_modal_content').html(resp.html);
  					}
  					displayNotification(resp.status, resp.message, 5000);
  				},
  				error:function(){
  					hideProcessingOverlay();
  				}
  			});
		});

		// $("#convert-to-user").modal('show');

		$('body').on('click', '.cnvrt-to-cust-btn', function(){
			var enc_id = $(this).data('enc-id');

			if(confirm('Are you sure want to convert this lead as customer?')) {

				$('#input-lead-id').val(atob(enc_id));

				$.ajax({
					url: "{{ Route('get_lead_details') }}",
	  				type:'GET',
	  				data : {
	  					'enc_id' : enc_id
	  				},
	  				dataType:'json',
	  				beforeSend: function() {
				        showProcessingOverlay();
				    },
	  				success:function(response)
	  				{
	  					hideProcessingOverlay();
	  					if(response.status == 'success') {
					        if(typeof response.data != 'undefined') {
					            $.each(response.data, function (key, val) {
					            	if(key == 'name') {
					            		$("#u_first_name").val(val);
					            	}else{
					                	$("#u_"+key).val(val);
					            	}
					            });
					        }
					    }
					    displayNotification(response.status, response.message, 5000);
	  				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});

				$("#leads-details").modal('hide');
				$("#add_lead").modal('hide');
				setTimeout(function(){ $("#convert-to-user").modal('show'); }, 2000);
			}

		});

		$('.toggle_pass').click(function(){
			$('.password').attr('type', function(index, attr){
			    return attr == 'password' ? 'text' : 'password';
			});
		});

		$('.generate_pass').click(function(){

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

		$('input[name=send_set_pass_mail]').change(function(){
			if($(this).is(':checked')) {
				$('.cust-pass-wrapp').fadeOut();
			}else{
				$('.cust-pass-wrapp').fadeIn();
			}
		});

	});

	function form_reset() {
		$('#createLeadForm')[0].reset();
		$(".select2").val('').trigger('change');
		$("textarea[name=description]").html('');
	}
</script>

@stop
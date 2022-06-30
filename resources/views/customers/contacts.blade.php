<div class="col-sm-9">
	<div class="col text-right">
		<ul class="list-inline-item pl-0">
            <li class="list-inline-item">
                <button class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" id="add-task" data-toggle="modal" data-target="#add_cust_cont" onclick="form_reset()">{{  trans('admin.add') }} {{  trans('admin.contact') }}</button>
            </li>
        </ul>
	</div>
	<div class="card mb-0">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-nowrap custom-table mb-0 datatable">
					<thead>
						<tr>
							<th>{{  trans('admin.id') }}</th>
							<th>{{  trans('admin.name') }}</th>
							<th>{{  trans('admin.email') }}</th>
							<th>{{  trans('admin.mobile_no') }}</th>
							<th>{{  trans('admin.actions') }}</th>
						</tr>
					</thead>

					<tbody>
						@if(isset($arr_contact) && sizeof($arr_contact)>0 )
							@foreach($arr_contact as $data)
								<tr>
									<td>{{ $data['id'] ?? '' }}</td>
									<td>{{ $data['first_name'] ?? '' }} {{ $data['last_name'] ?? '' }}</td>
									<td>{{ $data['email'] ?? '' }}</td>
									<td>{{ $data['mobile_no'] ?? '' }}</td>
									<td class="text-center">
										<div class="btn-group">
										 	<a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   		<i class="fas fa-ellipsis-v"></i>
										  	</a>
										  	<div class="dropdown-menu dropdown-menu-right">
										    	<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_cust_cont" onclick="user_edit('{{base64_encode($data['id'] ?? '')}}')">{{  trans('admin.edit') }}</button>
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

			
<!-- Add Modal -->
<div class="modal right fade" id="add_cust_cont" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close closeForm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center top_title">{{  trans('admin.add') }} {{  trans('admin.user') }}</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<div class="row">
			        <div class="col-md-12">
			            <form method="post" action="{{ Route('cust_contact_store') }}" id="frmAddCustContact">
			            	{{ csrf_field() }}
			            	<input type="hidden" name="action" value="create">
			            	<input type="hidden" name="enc_id" value="{{ $enc_id ?? '' }}">
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.first_name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{  trans('admin.first_name') }}" data-rule-required="true">
                					<label class="error" id="first_name_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.last_name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{  trans('admin.last_name') }}" data-rule-required="true">
                					<label class="error" id="last_name_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.email') }}<span class="text-danger">*</span></label>
                					<input type="email" class="form-control" name="email" id="email" placeholder="{{  trans('admin.email') }}" data-rule-required="true">
                					<label class="error" id="email_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.mobile_no') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="{{  trans('admin.mobile_no') }}" data-rule-required="true" data-rule-digits="true">
                					<label class="error" id="mobile_no_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.password') }}<span class="text-danger">*</span></label>
                					<input type="password" class="form-control" name="password" id="password" placeholder="{{  trans('admin.password') }}" data-rule-required="true">
                					<label class="error" id="password_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.confirm') }} {{  trans('admin.password') }}<span class="text-danger">*</span></label>
                					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{  trans('admin.confirm') }} {{  trans('admin.password') }}" data-rule-required="true" data-rule-equalTo="#password">
                					<label class="error" id="confirm_password_error"></label>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{  trans('admin.role') }} {{  trans('admin.postition') }}</label>
	            					<input type="text" class="form-control" name="role_position" id="role_position" placeholder="{{  trans('admin.role') }} {{  trans('admin.postition') }}">
	            					<label class="error" id="last_name_error"></label>
								</div>
							</div>

			                <div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{  trans('admin.save') }}</button>&nbsp;&nbsp;
			                	<button type="button" class="btn btn-secondary btn-rounded closeForm">{{  trans('admin.cancel') }}</button>
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

	var createUrl = "{{ Route('cust_contact_store') }}";
	var updateUrl = "{{ Route('cust_contact_update','') }}";
	var module_url_path = "{{ $module_url_path ?? '' }}";

	$(document).ready(function(){

		$('.select2').select2();

		initiate_form_validate();

		$("#add-user-btn").click(function(){
			form_reset();
			$('.top_title').html('Add Contact');
			$('input[name=password]').attr('data-rule-required', true);
			$('input[name=confirm_password]').attr('data-rule-required', true);
			initiate_form_validate();
			$("#add_cust_cont").modal('show');
		});

		$("#frmAddCustContact").submit(function(e) {

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
			$("#add_cust_cont").modal('hide');
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

		$('#role').change(function(){
			var role = $("#role option:selected").val();
			window.location.href = module_url_path+'?type='+btoa(role);
		})
	});

	function form_reset() {
		$('#frmAddCustContact')[0].reset();
	}

	function user_edit(enc_id)
	{
		$('.top_title').html('Edit User');
		if(enc_id!='')
		{
			$.ajax({
				url:module_url_path+'/cust_contact_edit/'+enc_id,
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
						$('#frmAddCustContact').attr('action', updateUrl+'/'+enc_id);
						$('input[name=action]').val('update');

						$('input[name=password]').attr('data-rule-required', false);
						$('input[name=confirm_password]').attr('data-rule-required', false);

						$('#first_name').val(response.data.first_name);
						$('#last_name').val(response.data.last_name);
						$('#email').val(response.data.email);
						$('#mobile_no').val(response.data.mobile_no);
						$('#role_position').val(response.data.cust_contact.role_position);
					}
				},
				error:function(){
  					hideProcessingOverlay();
  				}
		  });
		}
	}

	function initiate_form_validate() {
		$('#frmAddCustContact').validate({
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
</script>
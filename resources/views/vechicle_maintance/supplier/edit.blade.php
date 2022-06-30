@extends('layout.master')
@section('main_content')

<?php

$designation = $arr_user['designation']??[];

?>

<div class="row">
	<form method="POST" action="{{ Route('user_update', base64_encode($arr_user['id']??'')) }}" id="formAddUser">

		{{ csrf_field() }}

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-6 border-right">
							<h5>Basic Info</h5><hr>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">First Name<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" data-rule-required="true" value="{{ $arr_user['first_name']??'' }}">
                					<label class="error" id="first_name_error"></label>
                					<div class="error">{{ $errors->first('first_name') }}</div>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">Last Name<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" data-rule-required="true" value="{{ $arr_user['last_name']??'' }}">
                					<label class="error" id="last_name_error"></label>
                					<div class="error">{{ $errors->first('last_name') }}</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">Email<span class="text-danger">*</span></label>
                					<input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule-required="true" value="{{ $arr_user['email']??'' }}">
                					<label class="error" id="email_error"></label>
                					<div class="error">{{ $errors->first('email') }}</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">Password</label>
                					<input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off">
                					<label class="error" id="password_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">Confirm Password</label>
                					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" data-rule-equalTo="#password">
                					<label class="error" id="confirm_password_error"></label>
								</div>
							</div>
						</div>

						<div class="col-sm-6">

							<h5>Work</h5><hr>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">Department</label>
                					<select class="select" name="department">
                						<option value="">Select</option>
                						@if(isset($arr_depts) && !empty($arr_depts))
                						@foreach($arr_depts as $dept)
										<option value="{{ $dept['id']??'' }}" {{ ($arr_user['department_id']??'')==($dept['id']??'')?'selected':'' }} >{{ ucfirst($dept['name']??'') }}</option>
                						@endforeach
                						@endif
									</select>
                					<label class="error" id="department_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">Reporting To</label>
                					<select class="select" name="reporting_to">
                						<option value="">Select</option>
                						@if(isset($arr_users) && !empty($arr_users))
                						@foreach($arr_users as $person)
										<option value="{{ $person['id']??'' }}" {{ ($arr_user['report_to_id']??'')==($person['id']??'')?'selected':'' }} >{{ ucfirst($person['first_name']??'') }} {{ ucfirst($person['last_name']??'') }}</option>
                						@endforeach
                						@endif
									</select>
                					<label class="error" id="reporting_to_error"></label>
								</div>
							</div>

							<div class="row">
								<div class="form-group col-sm-6">
									<label class="col-form-label">Source of hire</label>
		                            <select class="select" name="source_of_hire">
										<option value="">Select</option>
										<option value="direct" {{ ($arr_user['source_of_hire']??'')=='direct'?'selected':'' }} >Direct</option>
										<option value="referrel" {{ ($arr_user['source_of_hire']??'')=='referrel'?'selected':'' }} >Referrel</option>
										<option value="web" {{ ($arr_user['source_of_hire']??'')=='web'?'selected':'' }} >Web</option>
										<option value="newspaper" {{ ($arr_user['source_of_hire']??'')=='newspaper'?'selected':'' }} >Newspaper</option>
										<option value="advertisement" {{ ($arr_user['source_of_hire']??'')=='advertisement'?'selected':'' }} >Advertisement</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Title / Designation</label>
									<div class="d-flex">
		            					<select class="select" name="designation" id="designation">
											<option value="">No selected</option>
											@if(isset($arr_designs) && !empty($arr_designs))
											@foreach($arr_designs as $design)
											<option value="{{ $design['id']??'' }}" {{ ($designation['id']??'')==($design['id']??'')?'selected':'' }} >{{ $design['name'] ?? '' }}</option>
											@endforeach
											@endif
										</select>
										<div class="input-group-append cursor-pointer">
											<span class="input-group-text" data-toggle="modal" data-target="#add_desgn"><i class="far fa-plus"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group col-sm-12">
									<label class="col-form-label">Date of Joining</label>
		                            <input type="text" class="form-control datepicker" name="join_date" placeholder="Joining Date" value="{{ $arr_user['join_date']??'' }}">
		                            <div class="error">{{ $errors->first('join_date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Employee Status</label>
		                            <select class="select" name="status">
										<option value="">Select</option>
										<option value="active" {{ ($arr_user['status']??'')=='active'?'selected':'' }} >Active</option>
										<option value="terminated" {{ ($arr_user['status']??'')=='terminated'?'selected':'' }} >Terminated</option>
										<option value="deceased" {{ ($arr_user['status']??'')=='deceased'?'selected':'' }} >Deceased</option>
										<option value="resigned" {{ ($arr_user['status']??'')=='resigned'?'selected':'' }} >Resigned</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Employee Type</label>
		                            <select class="select" name="emp_type">
										<option value="">Select</option>
										<option value="permanant" {{ ($arr_user['emp_type']??'')=='permanant'?'selected':'' }} >Permanant</option>
										<option value="on-contract" {{ ($arr_user['emp_type']??'')=='on-contract'?'selected':'' }} >On Contract</option>
										<option value="temporary" {{ ($arr_user['emp_type']??'')=='temporary'?'selected':'' }} >Temporary</option>
										<option value="trainee" {{ ($arr_user['emp_type']??'')=='trainee'?'selected':'' }} >Trainee</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Role</label>
		                            <select class="form-control select2" id="role_id" name="role_id">
										<option value="">Select Role</option>
										@if(isset($arr_roles) && sizeof($arr_roles)>0)
											@foreach($arr_roles as $role)
												<option value="{{$role['id']??''}}" {{ ($arr_user['role_id']??'')==($role['id'])?'selected':'' }} >{{ $role['name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label class="error" id="role_id_error"></label>
								</div>
							</div>
						</div>
					</div>

					<hr><br><br>

					<div class="row">
						<div class="col-sm-12">
							<h5>Personal</h5><hr>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">Mobile No</label>
                					<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" data-rule-digits="true" value="{{ $arr_user['mobile_no']??'' }}" >
                					<label class="error" id="mobile_no_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">Address</label>
                					<textarea cols="5" class="form-control" name="address">{{ $arr_user['address']??'' }}</textarea>
                					<label class="error" id="address_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="form-group col-sm-6">
									<label class="col-form-label">City</label>
		                            <input type="text" class="form-control" name="city" placeholder="City" value="{{ $arr_user['city']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">State</label>
	            					<input type="text" class="form-control" name="state" placeholder="State" value="{{ $arr_user['state']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Zip Code</label>
	            					<input type="text" class="form-control" name="postal_code" placeholder="Zip Code" value="{{ $arr_user['postal_code']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Birth Date</label>
	            					<input type="text" class="form-control datepicker" name="dob" placeholder="Birth Date" value="{{ $arr_user['dob']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Marital Status</label>
		                            <select class="select" name="marital_status">
										<option value="">Select</option>
										<option value="single" {{ ($arr_user['marital_status']??'')=='single'?'selected':'' }} >Single</option>
										<option value="married" {{ ($arr_user['marital_status']??'')=='married'?'selected':'' }} >Married</option>
										<option value="divorcee" {{ ($arr_user['marital_status']??'')=='divorcee'?'selected':'' }} >Divorcee</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Gender</label>
		                            <select class="select" name="gender">
										<option value="">Select</option>
										<option value="male" {{ ($arr_user['gender']??'')=='male'?'selected':'' }} >Male</option>
										<option value="female" {{ ($arr_user['gender']??'')=='female'?'selected':'' }} >Female</option>
										<option value="other" {{ ($arr_user['gender']??'')=='other'?'selected':'' }} >Other</option>
									</select>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<h5>Work experience</h5><hr>

					<div class="table-responsive">
						<table class="table" id="tblExp">
							<thead>
								<tr>
									<th>Previous Company Name</th>
									<th>Job Title</th>
									<th>From Date</th>
									<th>To Date</th>
									<th width="20%">Job Description</th>
									<th><i class="fas fa-cog"></i></th>
								</tr>
							</thead>
							<tbody>
								<tr class="exp_clone_master" id="exp_clone_master">
									<td>
										<input type="text" id="comp_name" class="form-control">
									</td>
									<td>
										<input type="text" id="job_title" class="form-control">
									</td>
									<td>
										<input type="text" id="from_date" class="form-control datepicker">
									</td>
									<td>
										<input type="text" id="to_date" class="form-control datepicker">
									</td>
									<td>
										<textarea id="exp_description" cols="5" class="form-control"></textarea>
									</td>
									<td>
										<button class="btn btn-sm btn-primary" id="btnExpClone" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
									</td>
								</tr>
								@if(isset($arr_user['experience']) && !empty($arr_user['experience']))
								@foreach($arr_user['experience'] as $exp)
								<tr>
									<td><input type="text" name="comp_name[]" value="{{ $exp['comp_name']??'' }}" class="form-control"></td>
									<td><input type="text" name="job_title[]" value="{{ $exp['job_title']??'' }}" class="form-control"></td>
									<td><input type="text" name="from_date[]" value="{{ $exp['from_date']??'' }}" class="form-control datepicker"></td>
									<td><input type="text" name="to_date[]" value="{{ $exp['to_date']??'' }}" class="form-control datepicker"></td>
									<td><textarea name="exp_description[]" cols="5" class="form-control">{{ $exp['description']??'' }}</textarea></td>
									<td><button class="btn btn-sm btn-danger" id="btnExpRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
								</tr>
								@endforeach
								@endif

							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>

		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<h5>Education</h5><hr>

					<div class="table-responsive">
						<table class="table" id="tblEdu">
							<thead>
								<tr>
									<th>School Name</th>
									<th>Degree/Diploma</th>
									<th>Field of Study</th>
									<th>Date of Completion</th>
									<th width="20%">Additional Notes</th>
									<th><i class="fas fa-cog"></i></th>
								</tr>
							</thead>
							<tbody>
								<tr class="edu_clone_master" id="edu_clone_master">
									<td>
										<input type="text" id="org_name" class="form-control">
									</td>
									<td>
										<input type="text" id="degree_name" class="form-control">
									</td>
									<td>
										<input type="text" id="faculty_name" class="form-control">
									</td>
									<td>
										<input type="text" id="completion_date" class="form-control datepicker">
									</td>
									<td>
										<textarea id="additional_note" cols="5" class="form-control"></textarea>
									</td>
									<td>
										<button class="btn btn-sm btn-primary" id="btnEduClone" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
									</td>
								</tr>

								@if(isset($arr_user['education']) && !empty($arr_user['education']))
								@foreach($arr_user['education'] as $edu)
								<tr>
									<td><input type="text" name="org_name[]" value="{{ $edu['org_name']??'' }}" class="form-control"></td>
									<td><input type="text" name="degree_name[]" value="{{ $edu['degree_name']??'' }}" class="form-control"></td>
									<td><input type="text" name="faculty_name[]" value="{{ $edu['faculty_name']??'' }}" class="form-control"></td>
									<td><input type="text" name="completion_date[]" value="{{ $edu['completion_date']??'' }}" class="form-control datepicker"></td>
									<td><textarea name="additional_note[]" cols="5" class="form-control">{{ $edu['additional_note']??'' }}</textarea></td>
									<td><button class="btn btn-sm btn-danger" id="btnEduRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
								</tr>
								@endforeach
								@endif

							</tbody>
						</table>
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
	                	<a href="{{ Route('estimates') }}" class="btn btn-secondary btn-rounded">Cancel</a>
	                </div>
				</div>
			</div>
		</div>

	</form>
</div>
<!-- /Page Header -->

<!-- Modal -->
<div class="modal fade" id="add_desgn" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">Add New Designation</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">

				<form method="POST" action="{{ Route('store_emp_desgn') }}" id="createDesgnForm">

					{{ csrf_field() }}

					<div class="row">
				        <div class="form-group col-md-12">
							<label class="col-form-label">Designation Name <span class="text-danger">*</span></label>
	                        <input type="text" class="form-control" name="name" placeholder="Enter Designaton Name" data-rule-required="true">
	                        <label class="error" id="name_error"></label>
						</div>

		                <div class="text-center py-3 w-100">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
		                	<button type="button" class="btn btn-secondary btn-rounded">Cancel</button>
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

	$(document).ready(function() {

		initiate_form_validate();

		$('.select2').select2();

		$("#tblExp").delegate( '#btnExpClone', 'click', function () {

			// if($('.exp_clone_master').find(".prod_id").val() != '')

			var comp_name = $('#comp_name').val();
			var job_title = $('#job_title').val();
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var exp_description = $('#exp_description').val();

			var expCloneHtml = '<tr><td><input type="text" name="comp_name[]" value="'+comp_name+'" class="form-control"></td><td><input type="text" name="job_title[]" value="'+job_title+'" class="form-control"></td><td><input type="text" name="from_date[]" value="'+from_date+'" class="form-control datepicker"></td><td><input type="text" name="to_date[]" value="'+to_date+'" class="form-control datepicker"></td><td><textarea name="exp_description[]" cols="5" class="form-control">'+exp_description+'</textarea></td><td><button class="btn btn-sm btn-danger" id="btnExpRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';

			showProcessingOverlay();
			$("#exp_clone_master").after(expCloneHtml);
			$( '.exp_clone_master' ).find('input').val('');
			$( '.exp_clone_master' ).find('textarea').val('');
			hideProcessingOverlay();
			initiate_form_validate();

		});

		$("#tblExp").delegate( '#btnExpRemove', 'click', function () {
			$(this).closest('tr').remove();
		});

		$("#tblEdu").delegate( '#btnEduClone', 'click', function () {

			// if($('.exp_clone_master').find(".prod_id").val() != '')

			var org_name = $('#org_name').val();
			var degree_name = $('#degree_name').val();
			var faculty_name = $('#faculty_name').val();
			var completion_date = $('#completion_date').val();
			var additional_note = $('#additional_note').val();

			var eduCloneHtml = '<tr><td><input type="text" name="org_name[]" value="'+org_name+'" class="form-control"></td><td><input type="text" name="degree_name[]" value="'+degree_name+'" class="form-control"></td><td><input type="text" name="faculty_name[]" value="'+faculty_name+'" class="form-control"></td><td><input type="text" name="completion_date[]" value="'+completion_date+'" class="form-control datepicker"></td><td><textarea name="additional_note[]" cols="5" class="form-control">'+additional_note+'</textarea></td><td><button class="btn btn-sm btn-danger" id="btnEduRemove" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';

			showProcessingOverlay();
			$("#edu_clone_master").after(eduCloneHtml);
			$( '.edu_clone_master' ).find('input').val('');
			$( '.edu_clone_master' ).find('textarea').val('');
			hideProcessingOverlay();

			initiate_form_validate();

		});

		$("#tblExp").delegate( '#btnEduRemove', 'click', function () {
			$(this).closest('tr').remove();
		});

		$('#createDesgnForm').validate();

		$("#createDesgnForm").submit(function(e) {
			e.preventDefault();

			var actionUrl = $(this).attr('action');

			if($(this).valid()) {
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
      					common_ajax_store_action(response, false);
      					if(response.status == 'success') {
      						$("select[name=designation]").append($("<option></option>")
									                    .attr("value", response.id)
									                    .text(response.name));
      						$('#createDesgnForm')[0].reset();
      						$('#add_desgn').modal('hide');
      					}
	  				},
	  				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

	});

	function initiate_form_validate() {
		$('#formAddUser').validate({
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
	}

</script>

@stop
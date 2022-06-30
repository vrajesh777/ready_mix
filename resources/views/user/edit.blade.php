@extends('layout.master')
@section('main_content')

<?php

$designation = $arr_user['designation']??[];
$arr_meta = $arr_user['user_meta']??[];
$arr_iqama = $arr_user['iqama'][0]??[];
$probation_count = search_in_user_meta($arr_meta,'probation_count');
$probation_unit = search_in_user_meta($arr_meta,'probation_unit');

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
							<h5>{{ trans('admin.basic_info') }}</h5><hr>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.first_name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{ trans('admin.first_name') }}" data-rule-required="true" value="{{ $arr_user['first_name']??'' }}">
                					<label class="error" id="first_name_error"></label>
                					<div class="error">{{ $errors->first('first_name') }}</div>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.last_name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{ trans('admin.last_name') }}" data-rule-required="true" value="{{ $arr_user['last_name']??'' }}">
                					<label class="error" id="last_name_error"></label>
                					<div class="error">{{ $errors->first('last_name') }}</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.email') }}<span class="text-danger"></span></label>
                					<input type="email" class="form-control" name="email" id="email" placeholder="{{ trans('admin.email') }}" value="{{ $arr_user['email']??'' }}" autocomplete="new-email">
                					<label class="error" id="email_error"></label>
                					<div class="error">{{ $errors->first('email') }}</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.password') }}</label>
                					<input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('admin.password') }}" autocomplete="new-password">
                					<label class="error" id="password_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.confirm') }} {{ trans('admin.password') }}</label>
                					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{ trans('admin.confirm') }} {{ trans('admin.password') }}" data-rule-equalTo="#password">
                					<label class="error" id="confirm_password_error"></label>
								</div>
							</div>
						</div>

						<div class="col-sm-6">

							<h5>{{ trans('admin.work') }}</h5><hr>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.department') }}</label>
                					<select class="select" name="department">
                						<option value="">{{ trans('admin.select') }}</option>
                						@if(isset($arr_depts) && !empty($arr_depts))
                						@foreach($arr_depts as $dept)
										<option value="{{ $dept['id']??'' }}" {{ ($arr_user['department_id']??'')==($dept['id']??'')?'selected':'' }} >{{ ucfirst($dept['name']??'') }}</option>
                						@endforeach
                						@endif
									</select>
                					<label class="error" id="department_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.reporting_to') }}</label>
                					<select class="select" name="reporting_to">
                						<option value="">{{ trans('admin.select') }}</option>
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
									<label class="col-form-label">{{ trans('admin.source_of_hire') }}</label>
		                            <select class="select" name="source_of_hire">
										<option value="">{{ trans('admin.select') }}</option>
										<option value="direct" {{ ($arr_user['source_of_hire']??'')=='direct'?'selected':'' }} >Direct</option>
										<option value="referrel" {{ ($arr_user['source_of_hire']??'')=='referrel'?'selected':'' }} >Referrel</option>
										<option value="web" {{ ($arr_user['source_of_hire']??'')=='web'?'selected':'' }} >Web</option>
										<option value="newspaper" {{ ($arr_user['source_of_hire']??'')=='newspaper'?'selected':'' }} >Newspaper</option>
										<option value="advertisement" {{ ($arr_user['source_of_hire']??'')=='advertisement'?'selected':'' }} >Advertisement</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.title_designation') }}</label>
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
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.date_of_joining') }}</label>
		                            <input type="text" class="form-control datepicker" name="join_date" placeholder="{{ trans('admin.date_of_joining') }}" value="{{ $arr_user['join_date']??'' }}" data-rule-required="true">
		                            <div class="error">{{ $errors->first('join_date') }}</div>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.probation_period') }}</label>
									<div class="d-flex">
										<div class="input-group-prepend">
											<input type="number" name="probation_count" min="0" value="{{ $probation_count??'' }}" class="form-control w-75" data-rule-required="true">
										</div>
		            					<select class="select" name="probation_unit" id="probation_unit" data-rule-required="true">
											<option value="day" {{ $probation_unit=='day'?'selected':'' }} >Days</option>
											<option value="month" {{ $probation_unit=='month'?'selected':'' }} >Months</option>
											<option value="year" {{ $probation_unit=='year'?'selected':'' }} >Years</option>
										</select>
									</div>
									<label id="probation_count-error" class="error" for="probation_count"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.employee_status') }}</label>
		                            <select class="select" name="status">
										<option value="">{{ trans('admin.select') }}</option>
										<option value="active" {{ ($arr_user['status']??'')=='active'?'selected':'' }} >Active</option>
										<option value="terminated" {{ ($arr_user['status']??'')=='terminated'?'selected':'' }} >Terminated</option>
										<option value="deceased" {{ ($arr_user['status']??'')=='deceased'?'selected':'' }} >Deceased</option>
										<option value="resigned" {{ ($arr_user['status']??'')=='resigned'?'selected':'' }} >Resigned</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.employee_type') }}</label>
		                            <select class="select" name="emp_type" id="emp_type">
										<option value="">{{ trans('admin.select') }}</option>
										<option value="permanant" {{ ($arr_user['emp_type']??'')=='permanant'?'selected':'' }} >Permanant</option>
										<option value="on-contract" {{ ($arr_user['emp_type']??'')=='on-contract'?'selected':'' }} >On Contract</option>
										<option value="temporary" {{ ($arr_user['emp_type']??'')=='temporary'?'selected':'' }} >Temporary</option>
										<option value="trainee" {{ ($arr_user['emp_type']??'')=='trainee'?'selected':'' }} >Trainee</option>
									</select>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.role') }}</label>
		                            <select class="form-control select2" id="role_id" name="role_id" data-rule-required="true">
										<option value="">{{ trans('admin.select') }} {{ trans('admin.role') }}</option>
										@if(isset($arr_roles) && sizeof($arr_roles)>0)
											@foreach($arr_roles as $role)
												<option value="{{$role['id']??''}}" {{ ($arr_user['role_id']??'')==($role['id'])?'selected':'' }} >{{ $role['name'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label class="error" id="role_id_error"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">Pay Overtime</label>
		                            <select class="form-control select2" id="pay_overtime" name="pay_overtime" data-rule-required="true">
										<option value="">{{ trans('admin.select') }}</option>
										<option value="yes" {{ ($arr_user['pay_overtime']??'')=='yes'?'selected':'' }} >Yes</option>
										<option value="no" {{ ($arr_user['pay_overtime']??'')=='no'?'selected':'' }} >No</option>
									</select>
									<label class="error" id="pay_overtime_error"></label>
								</div>
							</div>
							<div class="row" id="trip_section" style="{{$arr_user['role_id'] != config('app.roles_id.driver') ? 'display:none;' : ''}}">
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.initial_trip') }}</label>
										<input type="text" value="{{$arr_user['initial_trip']??''}}" class="form-control" name="initial_trip" placeholder="{{ trans('admin.initial_trip') }}" data-rule-required="false">
										<div class="error">{{ $errors->first('initial_trip') }}</div>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.initial_rate') }}</label>
										<input type="text" value="{{$arr_user['initial_rate']??''}}" class="form-control" name="initial_rate" placeholder="{{ trans('admin.initial_rate') }}" data-rule-required="false">
										<div class="error">{{ $errors->first('initial_rate') }}</div>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.additional_trip') }}</label>
										<input type="text" value="{{$arr_user['additional_trip']}}" class="form-control" name="additional_trip" placeholder="{{ trans('admin.additional_trip') }}" data-rule-required="false">
										<div class="error">{{ $errors->first('additional_trip') }}</div>
									</div>
									<div class="form-group col-sm-6">
										<label class="col-form-label">{{ trans('admin.additional_rate') }}</label>
										<input type="text" value="{{$arr_user['additional_rate']}}" class="form-control" name="additional_rate" placeholder="{{ trans('admin.additional_rate') }}" data-rule-required="false">
										<div class="error">{{ $errors->first('additional_rate') }}</div>
									</div>
							</div>
						</div>
					</div>

					<hr><br><br>

					<div class="row">
						<div class="col-sm-12">
							<h5>{{ trans('admin.personal') }}</h5><hr>

							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.mobile_no') }}</label>
                					<input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="{{ trans('admin.mobile_no') }}" data-rule-digits="true" value="{{ $arr_user['mobile_no']??'' }}" >
                					<label class="error" id="mobile_no_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.address') }}</label>
                					<textarea cols="5" class="form-control" name="address">{{ $arr_user['address']??'' }}</textarea>
                					<label class="error" id="address_error"></label>
								</div>
							</div>
							<div class="form-group row">
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.city') }}</label>
		                            <input type="text" class="form-control" name="city" placeholder="{{ trans('admin.city') }}" value="{{ $arr_user['city']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.state') }}</label>
	            					<input type="text" class="form-control" name="state" placeholder="{{ trans('admin.state') }}" value="{{ $arr_user['state']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.zip_code') }}</label>
	            					<input type="text" class="form-control" name="postal_code" placeholder="{{ trans('admin.zip_code') }}" value="{{ $arr_user['postal_code']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.birth_date') }}</label>
	            					<input type="text" class="form-control datepicker" name="dob" placeholder="{{ trans('admin.birth_date') }}" value="{{ $arr_user['dob']??'' }}">
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.marital_status') }}</label>
		                            <select class="select" name="marital_status" data-rule-required="true">
										<option value="">{{ trans('admin.select') }}</option>
										<option value="single" {{ ($arr_user['marital_status']??'')=='single'?'selected':'' }} >Single</option>
										<option value="married" {{ ($arr_user['marital_status']??'')=='married'?'selected':'' }} >Married</option>
										<option value="divorcee" {{ ($arr_user['marital_status']??'')=='divorcee'?'selected':'' }} >Divorcee</option>
									</select>
									<label id="marital_status-error" class="error" for="marital_status"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.gender') }}</label>
		                            <select class="select" name="gender" data-rule-required="true">
										<option value="">{{ trans('admin.select') }}</option>
										<option value="male" {{ ($arr_user['gender']??'')=='male'?'selected':'' }} >{{ trans('admin.male') }}</option>
										<option value="female" {{ ($arr_user['gender']??'')=='female'?'selected':'' }} >{{ trans('admin.female') }}</option>
										<option value="other" {{ ($arr_user['gender']??'')=='other'?'selected':'' }} >{{ trans('admin.other') }}</option>
									</select>
									<label id="gender-error" class="error" for="gender"></label>
								</div>
								<div class="form-group col-sm-6">
									<label class="col-form-label">{{ trans('admin.nationality') }}</label>
		                            <select class="form-control select2" id="nationality_id" name="nationality_id" data-rule-required="true">
										<option value="">{{ trans('admin.select') }} {{ trans('admin.nationality') }}</option>
										@if(isset($arr_country) && sizeof($arr_country)>0)
											@foreach($arr_country as $country)
												<option value="{{ $country['id'] ?? '' }}" {{ ($arr_user['nationality_id']??'')==($country['id'])?'selected':'' }}>{{ $country['name_en'] ?? '' }}</option>
											@endforeach
										@endif
									</select>
									<label class="error" id="nationality_id_error"></label>
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

					<h5>{{ trans('admin.iqama') }}</h5><hr>

					<div class="table-responsive">
						<table class="table" id="iqama">
							<thead>
								<tr>
									<th>{{ trans('admin.iqama_no') }}</th>
									<th>{{ trans('admin.iqama_expiry_date') }}</th>
									<th>{{ trans('admin.passport_no') }}</th>
									<th>{{ trans('admin.passport_expiry_date') }}</th>
									<th>{{ trans('admin.gosi_no') }}</th>
									<th>{{ trans('admin.contract_period') }}</th>
								</tr>
							</thead>
							<tbody>
								<tr class="iqama_fields" id="iqama_fields">
									<td>
										<input type="text" name="iqama_no" value="{{$arr_iqama['iqama_no']??''}}" id="iqama_no" class="form-control">
									</td>
									<td>
										<input type="text" name="iqama_expiry_date" value="{{$arr_iqama['iqama_expiry_date']??''}}" id="iqama_expiry_date" class="form-control datepicker" autocomplete="off">
									</td>
									<td>
										<input type="text" name="passport_no" value="{{$arr_iqama['passport_no']??''}}" id="passport_no" class="form-control">
									</td>
									<td>
										<input type="text" name="passport_expiry_date" value="{{$arr_iqama['passport_expiry_date']??''}}" id="passport_expiry_date" class="form-control datepicker" autocomplete="off">
									</td>
									<td>
										<input name="gosi_no" value="{{$arr_iqama['gosi_no']??''}}" id="gosi_no" class="form-control"></input>
									</td>
									<td>
										<select class="form-control" name="contract_period" id="contract_period">
											<option value="" hidden>Select</option>
											<option value="1 Years" {{$arr_iqama['contract_period']??''==='1 Years'?'selected':''}}>1 Years</option>
											<option value="2 Years" {{$arr_iqama['contract_period']??''==='2 Years'?'selected':''}}>2 Years</option>
										</select>
										<input type="hidden" name="iqama_id" value="{{$arr_iqama['id']??''}}"/>
									</td>
								</tr>

							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					<h5>{{ trans('admin.work') }} {{ trans('admin.experience') }}</h5><hr>

					<div class="table-responsive">
						<table class="table" id="tblExp">
							<thead>
								<tr>
									<th>{{ trans('admin.previous_company_name') }}</th>
									<th>{{ trans('admin.job_title') }}</th>
									<th>{{ trans('admin.from_date') }}</th>
									<th>{{ trans('admin.to_date') }}</th>
									<th width="20%">{{ trans('admin.job_description') }}</th>
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

					<h5>{{ trans('admin.education') }}</h5><hr>

					<div class="table-responsive">
						<table class="table" id="tblEdu">
							<thead>
								<tr>
									<th>{{ trans('admin.school_name') }}</th>
									<th>{{ trans('admin.degree_diploma') }}</th>
									<th>{{ trans('admin.field_of_study') }}</th>
									<th>{{ trans('admin.date_of_completion') }}</th>
									<th width="20%">{{ trans('admin.additional_notes') }}</th>
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
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<a href="{{ Route('employee') }}" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</a>
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
		$('#iqama .datepicker').datepicker({
			startDate: new Date()
		});
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

		// per trip cost section
		$(document).on('change','#role_id',function(){
			var role = $(this).val();
			var driver  = "<?= config('app.roles_id.driver');?>";
			var pump_helper  = "<?= config('app.roles_id.pump_helper');?>";
			var pump_operator  = "<?= config('app.roles_id.pump_operator');?>";
			
			if(role && [driver,pump_helper,pump_operator].includes(role)){
				$('#trip_section').show();
			} else {
				$('#trip_section').hide();
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
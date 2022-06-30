@extends('layout.master')
@section('main_content')

<form method="POST" action="{{ Route('roles_update',$enc_id) }}" id="formAddRoles">
	<div class="row">
		{{ csrf_field() }}
		<?php 
	        $role_id = isset($role->id)?$role->id:'';
	     ?>
	      <input type="hidden" name="role_id" id="role_id" value="{{ $role_id }}">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">

					@include('layout._operation_status')

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.department') }}<span class="text-danger">*</span></label>
	                            <select name="department_id" class="select2" id="department_id" data-rule-required="true" disabled>
									<option value="">Select Department</option>
									@if(isset($arr_dept) && sizeof($arr_dept)>0)
										@foreach($arr_dept as $dept)
											<option value="{{ $dept['id'] ?? '' }}" @if(isset($role->department_id) && $role->department_id!='' && $role->department_id == $dept['id'] ) selected @endif>{{ $dept['name'] ?? '' }}</option>
										@endforeach
									@endif
								</select>
								<div class="error">{{ $errors->first('department_id') }}</div>
        					</div>
						</div>
						

						
						<div class="col-sm-4">
							<div class="form-group">
								<label class="col-form-label">{{ trans('admin.role') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
            					<input type="text" class="form-control ppcal" name="name" id="name" placeholder="Role Name" data-rule-required="true" value="{{ $role->name ?? '' }}" readonly>
            					<label class="error" id="name_error"></label>
            					<div class="error">{{ $errors->first('name') }}</div>
        					</div>
						</div>
						
					</div>

					<div class="row">
						@if(isset($arr_permission) && count($arr_permission)>0)
                       		@foreach($arr_permission as $value)
							<div class="col-sm-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="permission[]" value="{{ $value['id'] }}" @if(in_array($value['id'], $rolePermissions)) checked="" @endif> {{ ucwords(str_replace('-', ' ', $value['name'])) }}
									</label>
								</div>
							</div>
							@endforeach
						@endif
					</div>

					<div class="text-center py-3 w-100">
	                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
	                	<button type="button" class="btn btn-secondary btn-rounded">{{ trans('admin.cancel') }}</button>
	                </div>

				</div>
			</div>
		</div>
	</div>
</form>
<!-- /Page Header -->
<script type="text/javascript">
	$(document).ready(function(){
		$('.select2').select2();
		$('#formAddRoles').validate({});
	});
</script>
@stop
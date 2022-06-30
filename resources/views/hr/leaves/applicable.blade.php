<style type="text/css">
	/*.nav-tabs.nav-tabs-solid > li { width: 50%; text-align: center;}*/
</style>
<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded d-flex justify-content-center mb-2">
	<li class="nav-item">
		<a class="nav-link active" href="#inventory-stock" data-toggle="tab">{{ trans('admin.applicable') }}</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#expiry-date" data-toggle="tab">{{ trans('admin.exceptions') }}</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane active show" id="inventory-stock">
		<div class="form-group row">
			<label class="col-md-3 text-right">{{ trans('admin.gender') }} </label>
			<div class="col-md-6 d-flex">
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="genders[]" value="male">
					<span class="checkmark"></span>
					{{ trans('admin.male') }}
				</label>
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="genders[]" value="female">
					<span class="checkmark"></span>
					{{ trans('admin.female') }}
				</label>
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="genders[]" value="other">
					<span class="checkmark"></span>
					{{ trans('admin.other') }}
				</label>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-md-3 text-right">{{ trans('admin.marital_status') }}  </label>
			<div class="col-md-6 d-flex">
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="marital_status[]" value="single">
					<span class="checkmark"></span>
					{{ trans('admin.single') }}
				</label>
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="marital_status[]" value="married">
					<span class="checkmark"></span>
					{{ trans('admin.married') }}
				</label>
			</div>
		</div>
    	<div class="form-group row">
			<label class="col-sm-3 text-right">{{ trans('admin.department') }} </label>
			<div class="col-sm-6">
				<select name="applc_depts[]" class="select2" multiple="">
					@if(isset($arr_departments) && !empty($arr_departments))
					<option value="">All</option>
					@foreach($arr_departments as $dept)
					<option value="{{ $dept['id']??'' }}">{{ $dept['name']??'' }}</option>
					@endforeach
					@endif
				</select>
				<label class="error" id="applc_depts_error"></label>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-3 text-right"> {{ trans('admin.designations') }}</label>
			<div class="col-sm-6">
				<select name="applc_designations[]" class="select2" multiple="">
					@if(isset($arr_designations) && !empty($arr_designations))
					<option value="">All</option>
					@foreach($arr_designations as $desgn)
					<option value="{{ $desgn['id']??'' }}">{{ $desgn['name']??'' }}</option>
					@endforeach
					@endif
				</select>
				<label class="error" id="name_error"></label>
			</div>
		</div>
		{{-- <div class="form-group row">
			<label class="col-sm-3 text-right">Roles {{ trans('admin.single') }}</label>
			<div class="col-sm-6">
				<select name="applc_roles[]" class="select2" multiple="">
					@if(isset($arr_roles) && !empty($arr_roles))
					<option value="">All</option>
					@foreach($arr_roles as $role)
					<option value="{{ $role['id']??'' }}">{{ $role['name']??'' }}</option>
					@endforeach
					@endif
				</select>
				<label class="error" id="name_error"></label>
			</div>
		</div> --}}

		<div class="form-group row">
			<label class="col-sm-3 text-right"></label>
			<label class="col-sm-6 text-center"> {{ trans('admin.or') }}</label>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 text-right"> {{ trans('admin.employee') }}</label>
			<div class="col-sm-6">
				<select name="applc_users[]" class="select2" multiple="">
					<option value="all" selected> {{ trans('admin.all') }} {{ trans('admin.employee') }}</option>
				</select>
				<label class="error" id="name_error"></label>
			</div>
		</div>

	</div>
	<div class="tab-pane" id="expiry-date">
		<div class="table-responsive">
			<div class="form-group row mx-0 except_depts-wrap">
				<label class="col-sm-3 text-right"> {{ trans('admin.department') }}</label>
				<div class="col-sm-6">
					<select name="except_depts[]" class="select2" multiple="">
						@if(isset($arr_departments) && !empty($arr_departments))
						<option value="">All</option>
						@foreach($arr_departments as $dept)
						<option value="{{ $dept['id']??'' }}">{{ $dept['name']??'' }}</option>
						@endforeach
						@endif
					</select>
					<label class="error" id="except_depts_error"></label>
				</div>
			</div>
			<div class="form-group row mx-0 except_designations-wrap">
				<label class="col-sm-3 text-right"> {{ trans('admin.designations') }}</label>
				<div class="col-sm-6">
					<select name="except_designations[]" class="select2" multiple="">
						@if(isset($arr_designations) && !empty($arr_designations))
						<option value="">All</option>
						@foreach($arr_designations as $desgn)
						<option value="{{ $desgn['id']??'' }}">{{ $desgn['name']??'' }}</option>
						@endforeach
						@endif
					</select>
					<label class="error" id="name_error"></label>
				</div>
			</div>
			{{-- <div class="form-group row except_roles-wrap">
				<label class="col-sm-3 text-right"> {{ trans('admin.roles') }}</label>
				<div class="col-sm-6">
					<select name="except_roles[]" class="select2" multiple="">
						@if(isset($arr_roles) && !empty($arr_roles))
						<option value="">All</option>
						@foreach($arr_roles as $role)
						<option value="{{ $role['id']??'' }}">{{ $role['name']??'' }}</option>
						@endforeach
						@endif
					</select>
					<label class="error" id="name_error"></label>
				</div>
			</div> --}}
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){

		$('input[name="genders[]"]').change(function() {
			var total = $('input[name="genders[]"]:checked').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');
			}
		});

		$('input[name="marital_status[]"]').change(function() {
			var total = $('input[name="marital_status[]"]:checked').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');
			}
		});

		$('select[name="applc_depts[]"]').change(function() {
			var total = $('select[name="applc_depts[]"] option:selected').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');

				$('select[name="except_depts[]"]').val([]);
				$('select[name="except_depts[]"]').trigger('change');
				$('.except_depts-wrap').hide();
			}else{
				$('.except_depts-wrap').show();
			}
		});

		$('select[name="applc_designations[]"]').change(function() {
			var total = $('select[name="applc_designations[]"] option:selected').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');

				$('select[name="except_designations[]"]').val([]);
				$('select[name="except_designations[]"]').trigger('change');
				$('.except_designations-wrap').hide();
			}else{
				$('.except_designations-wrap').show();
			}
		});

		$('select[name="applc_roles[]"]').change(function() {
			var total = $('select[name="applc_roles[]"] option:selected').length;
			if(total > 0) {
				$('select[name="applc_users[]"]').val([]);
				$('select[name="applc_users[]"]').trigger('change');

				$('select[name="except_roles[]"]').val([]);
				$('select[name="except_roles[]"]').trigger('change');
				$('.except_roles-wrap').hide();
			}else{
				$('.except_roles-wrap').show();
			}
		});

	});
</script>
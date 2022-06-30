<style type="text/css">
	.nav-tabs.nav-tabs-solid > li { width: 50%; text-align: center;}
</style>
<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
	<li class="nav-item">
		<a class="nav-link active" href="#inventory-stock" data-toggle="tab">Applicable</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="#expiry-date" data-toggle="tab">Exceptions</a>
	</li>
</ul>
<div class="tab-content">
	<div class="tab-pane active show" id="inventory-stock">
		<div class="form-group row">
			<label class="col-md-3 text-right">Gender </label>
			<div class="col-md-6 d-flex">
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="genders[]" value="male">
					<span class="checkmark"></span>
					Male
				</label>
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="genders[]" value="female">
					<span class="checkmark"></span>
					Female
				</label>
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="genders[]" value="others">
					<span class="checkmark"></span>
					Others
				</label>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-md-3 text-right">Marital Status </label>
			<div class="col-md-6 d-flex">
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="marital_status[]" value="single">
					<span class="checkmark"></span>
					Single
				</label>
				<label class="container-checkbox font-size-14 pr-4">
					<input type="checkbox" name="marital_status[]" value="married">
					<span class="checkmark"></span>
					Married
				</label>
			</div>
		</div>
    	<div class="form-group row">
			<label class="col-sm-3 text-right">Department </label>
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
			<label class="col-sm-3 text-right">Designations </label>
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
		<div class="form-group row">
			<label class="col-sm-3 text-right">Roles </label>
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
		</div>

		<div class="form-group row">
			<label class="col-sm-3 text-right"></label>
			<label class="col-sm-6 text-center"> OR </label>
		</div>

		<div class="form-group row">
			<label class="col-sm-3 text-right">Employee </label>
			<div class="col-sm-6">
				<select name="applc_users[]" class="select2" multiple="">
					<option value="all" selected>All Employee</option>
				</select>
				<label class="error" id="name_error"></label>
			</div>
		</div>

	</div>
	<div class="tab-pane" id="expiry-date">
		<div class="table-responsive">
			<div class="form-group row except_depts-wrap">
				<label class="col-sm-3 text-right">Department </label>
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
			<div class="form-group row except_designations-wrap">
				<label class="col-sm-3 text-right">Designations </label>
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
			<div class="form-group row except_roles-wrap">
				<label class="col-sm-3 text-right">Roles </label>
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
			</div>
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
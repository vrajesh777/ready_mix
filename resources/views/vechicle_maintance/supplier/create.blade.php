@extends('layout.master')
@section('main_content')

<div class="row">
	<form method="POST" action="{{ Route('vc_part_suppy_store') }}" id="formAddUser">
		
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
                					<input type="text" class="form-control" name="first_name" id="first_name" placeholder="{{ trans('admin.first_name') }}" data-rule-required="true" value="{{ old('first_name') }}">
                					<label class="error" id="first_name_error"></label>
                					<div class="error">{{ $errors->first('first_name') }}</div>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.last_name') }}<span class="text-danger">*</span></label>
                					<input type="text" class="form-control" name="last_name" id="last_name" placeholder="{{ trans('admin.last_name') }}" data-rule-required="true" value="{{ old('last_name') }}">
                					<label class="error" id="last_name_error"></label>
                					<div class="error">{{ $errors->first('last_name') }}</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.email') }}<span class="text-danger">*</span></label>
                					<input type="email" class="form-control" name="email" id="email" placeholder="{{ trans('admin.email') }}" data-rule-required="true" value="{{ old('email') }}">
                					<label class="error" id="email_error"></label>
                					<div class="error">{{ $errors->first('email') }}</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-6">
									<label class="col-form-label">{{ trans('admin.password') }}<span class="text-danger">*</span></label>
                					<input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('admin.password') }}" data-rule-required="true">
                					<label class="error" id="password_error"></label>
								</div>
								<div class="col-sm-6">
									<label class="col-form-label"> {{ trans('admin.confirm') }} {{ trans('admin.password') }}<span class="text-danger">*</span></label>
                					<input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{ trans('admin.confirm') }}" data-rule-required="true" data-rule-equalTo="#password">
                					<label class="error" id="confirm_password_error"></label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /Page Header -->

<script type="text/javascript">

	$(document).ready(function() {

		initiate_form_validate();

		$('.select2').select2();

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
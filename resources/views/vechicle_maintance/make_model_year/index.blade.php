@extends('layout.master')
@section('main_content')

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		@include('layout._operation_status')
		<h4>{{ trans('admin.manage') }} {{ trans('admin.make') }}</h4>
		<div class="card mb-0">
			<div class="card-header">
				<form method="post" action="{{ Route('vechicle_mym_store') }}" id="frmAddMake">
			        {{ csrf_field() }}
			        <input type="hidden" name="type" value="make">
					<div class="row">
						<div class="col-md-4">
							<label class="col-form-label">{{ trans('admin.make') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
	    					<input type="text" class="form-control" name="make_name" id="make_name" placeholder="{{ trans('admin.make') }} {{ trans('admin.name') }}" data-rule-required="true">
	    					<label class="error" id="first_name_error"></label>
	    					<div class="error">{{ $errors->first('make_name') }}</div>
						</div>
						<div class="col-md-2">
							<div class="pt-md-0 pt-3">
								<label class="col-form-label d-md-block d-none">&nbsp;</label>
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="btn_make">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
							</div>
						</div>	
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="makeTable">
						<thead>
							<tr>
								<th>{{ trans('admin.make') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_make) && sizeof($arr_make)>0)
								@foreach($arr_make as $make)
									<tr>
										<td>{{ $make['make_name'] ?? '' }}</td>
										<td>
											@if($make['is_active'] == '1')
												<a class="btn btn-success btn-sm" href="{{ Route('make_deactivate', base64_encode($make['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
											@else
												<a class="btn btn-danger btn-sm" href="{{ route('make_activate',base64_encode($make['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
											@endif
										</td>
										<td><a class="dropdown-item action-edit" href="javascript:void(0);" onclick="make_edit('{{base64_encode($make['id'] ?? '')}}')"><i class="fa fa-edit"></i></a></td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<br><br>

		<h4>{{ trans('admin.manage') }} {{ trans('admin.model') }}</h4>
		<div class="card mb-0">
			<div class="card-header">
				<form method="post" action="{{ Route('vechicle_mym_store') }}" id="frmAddModel">
			        {{ csrf_field() }}
			        <input type="hidden" name="type" value="model">
					<div class="row">
						<div class="col-sm-4">
							<label class="col-form-label">{{ trans('admin.make') }}<span class="text-danger">*</span></label>
                            <select class="form-control" name="make_id" data-rule-required="true" id="m_make_id">
								<option value="">{{ trans('admin.select') }} {{ trans('admin.make') }}</option>
								@if(isset($arr_make) && sizeof($arr_make))
									@foreach($arr_make as $make_val)
										<option value="{{ $make_val['id'] ?? '' }}">{{ $make_val['make_name'] ?? 0 }}</option>
									@endforeach
								@endif
							</select>
							<label class="error" id="role_id_error"></label>
						</div>
						<div class="col-md-4">
							<label class="col-form-label">{{ trans('admin.model') }} {{ trans('admin.name') }}<span class="text-danger">*</span></label>
	    					<input type="text" class="form-control" name="model_name" id="model_name" placeholder="{{ trans('admin.model') }} {{ trans('admin.name') }}" data-rule-required="true">
	    					<label class="error" id="first_name_error"></label>
	    					<div class="error">{{ $errors->first('model_name') }}</div>
						</div>
						<div class="col-md-2">
							<div class="pt-md-0 pt-3">
								<label class="col-form-label d-md-block d-none">&nbsp;</label>
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="btn_model">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
							</div>
						</div>	
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="modelTable">
						<thead>
							<tr>
								<th>{{ trans('admin.make') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.model') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($arr_model) && sizeof($arr_model)>0)
							@foreach($arr_model as $model)
								<tr>
									<td>{{ $model['make']['make_name'] ?? '' }}</td>
									<td>{{ $model['model_name'] ?? '' }}</td>
									<td>
										@if($model['is_active'] == '1')
											<a class="btn btn-success btn-sm" href="{{ Route('model_deactivate', base64_encode($model['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
										@else
											<a class="btn btn-danger btn-sm" href="{{ route('model_activate',base64_encode($model['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
										@endif
									</td>
									<td><a class="dropdown-item action-edit" href="javascript:void(0);" onclick="model_edit('{{base64_encode($model['id'] ?? '')}}')"><i class="fa fa-edit"></i></a></td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<br><br>
		<h4>{{ trans('admin.manage') }} {{ trans('admin.year') }}</h4>
		<div class="card mb-0">
			<div class="card-header">
				<form method="post" action="{{ Route('vechicle_mym_store') }}" id="frmAddYear">
			        {{ csrf_field() }}
			        <input type="hidden" name="type" value="year">
					<div class="row">
						<div class="col-sm-3">
							<label class="col-form-label">{{ trans('admin.make') }}<span class="text-danger">*</span></label>
                            <select class="form-control" id="make_id" name="make_id" data-rule-required="true">
								<option value="">{{ trans('admin.select') }} {{ trans('admin.make') }}</option>
								@if(isset($arr_make) && sizeof($arr_make))
									@foreach($arr_make as $make_val)
										<option value="{{ $make_val['id'] ?? '' }}">{{ $make_val['make_name'] ?? 0 }}</option>
									@endforeach
								@endif
							</select>
							<label class="error" id="make_id_error"></label>
						</div>
						<div class="col-sm-3">
							<label class="col-form-label">{{ trans('admin.model') }}<span class="text-danger">*</span></label>
                            <select class="form-control" id="model_id" name="model_id" data-rule-required="true">
								<option value="">{{ trans('admin.select') }} {{ trans('admin.model') }}</option>
								@if(isset($arr_model) && sizeof($arr_model))
									@foreach($arr_model as $model_val)
										<option value="{{ $model_val['id'] ?? '' }}">{{ $model_val['model_name'] ?? 0 }}</option>
									@endforeach
								@endif
							</select>
							<label class="error" id="model_id_error"></label>
						</div>
						@php
							$start = date('Y');
							$end = date('Y', strtotime('-15 years'));
							$yearArray = range($start,$end);
						@endphp
						<div class="col-sm-3">
							<label class="col-form-label">{{ trans('admin.start') }} {{ trans('admin.year') }}<span class="text-danger">*</span></label>
                            <select class="form-control" id="Year" name="Year" data-rule-required="true">
								<option value="">{{ trans('admin.select') }} {{ trans('admin.start') }} {{ trans('admin.year') }}</option>
								@if(isset($yearArray) && sizeof($yearArray))
									@foreach($yearArray as $y)
										<option value="{{ $y ?? '' }}">{{ $y ?? '' }}</option>
									@endforeach
								@endif
							</select>
							<label class="error" id="Year_error"></label>
						</div>
						{{-- <div class="col-md-3">
							<label class="col-form-label">Year<span class="text-danger">*</span></label>
	    					<input type="text" class="form-control" name="Year" id="Year" placeholder="Year" data-rule-required="true" minlength="4" maxlength="4" data-rule-digits="true">
	    					<label class="error" id="first_name_error"></label>
	    					<div class="error">{{ $errors->first('Year') }}</div>
						</div> --}}
						<div class="col-md-2">
							<div class="pt-md-0 pt-3">
								<label class="col-form-label d-md-block d-none">&nbsp;</label>
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="btn_year">{{ trans('admin.save') }}</button>&nbsp;&nbsp;
							</div>
						</div>	
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="yearTable">
						<thead>
							<tr>
								<th>{{ trans('admin.make') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.model') }} {{ trans('admin.name') }}</th>
								<th>{{ trans('admin.year') }}</th>
								<th>{{ trans('admin.status') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($arr_year) && sizeof($arr_year)>0)
							@foreach($arr_year as $year)
								<tr>
									<td>{{ $year['make']['make_name'] ?? '' }}</td>
									<td>{{ $year['model']['model_name'] ?? '' }}</td>
									<td>{{ $year['year'] ?? '' }}</td>
									<td>
										@if($year['is_active'] == '1')
											<a class="btn btn-success btn-sm" href="{{ Route('year_deactivate', base64_encode($year['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Deactivate this record ?');" title="Deactive">{{ trans('admin.active') }}</a>
										@else
											<a class="btn btn-danger btn-sm" href="{{ route('year_activate',base64_encode($year['id'])) }}" onclick="confirm_action(this,event,'Do you really want to Activate this record ?');" title="Active">{{ trans('admin.deactive') }}</a>
										@endif
									</td>
									<td><a class="dropdown-item action-edit" href="javascript:void(0);" onclick="year_edit('{{base64_encode($year['id'] ?? '')}}')"><i class="fa fa-edit"></i></a></td>
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
<!-- /Content End -->

<script type="text/javascript">

	/*var createUrl = "{{ Route('vechicle_mym_store') }}";
	var updateUrl = "{{ Route('vc_part_suppy_update','') }}";
	var module_url_path = "{{ $module_url_path ?? '' }}";*/

	$(document).ready(function(){
		$('#frmAddMake').validate({});
		$('#frmAddModel').validate({});
		$('#frmAddYear').validate({});

		$('#makeTable').DataTable({
		});
		$('#modelTable').DataTable({
		});
		$('#yearTable').DataTable({
		});

		$('#make_id').change(function(){
			var make_id = $(this).val();
			$.ajax({
				url: "{{ Route('load_model','') }}/"+btoa(make_id),
				type:'GET',
				dataType:'json',
				success:function(resp)
				{
					if(typeof(resp.arr_model) == 'object')
					{
						var option = '<option value="">Select Model</option>'; 
						$(resp.arr_model).each(function(index,model){
							var select = '';

							option+='<option value="'+model.id+'" '+select+' >'+model.model_name+'</option>';
						})

						$('select[name="model_id"]').html(option);
					}
				}
			})
		});
	});

	var module_url_path = "{{ $module_url_path ?? '' }}";
	var updateUrl = "{{ Route('vechicle_mym_update','') }}"
	function make_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:"{{ Route('make_edit','') }}/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'success')
							{
  								$('#frmAddMake').attr('action', updateUrl+'/'+enc_id);
								$('#make_name').val(response.data.make_name);
								$('#btn_make').html('Update');
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}

	function model_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:"{{ Route('model_edit','') }}/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'success')
							{
  								$('#frmAddModel').attr('action', updateUrl+'/'+enc_id);
								$('#model_name').val(response.data.model_name);
								$('#m_make_id').val(response.data.make_id);
								$('#btn_model').html('Update');
							}
						},
						error:function(){
		  					hideProcessingOverlay();
		  				}
				  });
		}
	}

	function year_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:"{{ Route('year_edit','') }}/"+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend: function() {
					        showProcessingOverlay();
					    },
						success:function(response){
							hideProcessingOverlay();
							if(response.status == 'success')
							{
  								$('#frmAddYear').attr('action', updateUrl+'/'+enc_id);
								$('#Year').val(response.data.year);
								$('#make_id').val(response.data.make_id);
								$('#model_id').val(response.data.model_id);
								$('#btn_year').html('Update');
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
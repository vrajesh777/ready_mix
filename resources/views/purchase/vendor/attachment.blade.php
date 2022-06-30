@extends('layout.master')
@section('main_content')


<div class="row all-reports m-0">
	
	@include('purchase.vendor._sidebar')

	<div class="col-md-9 pr-0 Reports">
		<div class="card">

			@if($obj_user->hasPermissionTo('purchase-vendor-update'))
				<div class="modal-body">
					<form method="post" action="{{ Route('attachment_store') }}" id="frmAddAttach" enctype="multipart/form-data">
		            {{ csrf_field() }}
		            <input type="hidden" name="action" value="create">
		            <input type="hidden" name="vendor_id" value="{{ $enc_id }}">
						<div class="col-md-12">
							
							<div class="form-group col-sm-6">
								<label class="col-form-label">Attachments</label>
	                           	<div class="position-relative p-0">
	        						<input type="file" class="file-text form-control" name="attach[]" id="attach" data-rule-required="true">
	        						<button type="button" onclick="add_file();" class="input-group-append date-icon"><i class="fal fa-plus"></i></button>
	    						</div>
							</div>

							<div class="form-group col-sm-6" id="append_attach"></div>

							<div class="text-center py-3">
								<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
							</div>

						</div>
					</form>
				</div>
			@endif

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 datatables">
						<thead>
							<tr>
								<th>#Id</th>
								<th>Name</th>
								<th>Download</th>
								@if($obj_user->hasPermissionTo('purchase-vendor-update'))
									<th class="text-right">Actions</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_attachment) && sizeof($arr_attachment)>0)
								@foreach($arr_attachment as $key => $value)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $value['og_name'] ?? '' }}</td>
										<td><a href="{{ $vendor_attachment_public_path }}{{ $value['file'] ?? '' }}" download><i class="fa fa-download"></i></a></td>
										@if($obj_user->hasPermissionTo('purchase-vendor-update'))
											<td><a href="{{ Route('attachment_delete',base64_encode($value['id'] ?? '')) }}" onclick="confirm_action(this,event,'Do you really want to delete this attachment ?');"><i class="fa fa-trash"></i></a></td>
										@endif
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


<script type="text/javascript">
	$(document).ready(function() {
		$('.datatables').DataTable({searching: true, paging: true, info: true});

		$('#frmAddAttach').validate();
	});

	var count = 1;
	function add_file()
	{
		var obj = $('#append_attach');
		count++;
		var html = '<div id="dynamic_div_'+count+'"><label class="col-form-label">Attachments</label><div class="position-relative p-0"><input type="file" class="file-text form-control" name="attach[]" id="attach_'+count+'" data-rule-required="true"><button type="button" onclick="remove_file('+count+');" class="input-group-append date-icon"><i class="fal fa-minus"></i></button></div></div>';
		obj.append(html);
	}

	function remove_file(count)
	{
		$('#dynamic_div_'+count).remove();
	}
</script>
@endsection
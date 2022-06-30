@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-8 card-title mt-0 mb-2">Vendor : #{{ $arr_vendor_details['id'] ?? '' }} {{ $arr_vendor_details['user_meta'][0]['meta_value'] ?? '' }}</h4>
	@if($obj_user->hasPermissionTo('purchase-vendor-update'))
		<div class="col-md-4 justify-content-end d-flex">
			<a href="javascript:void(0)" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2" data-toggle="modal" data-target="#add_note">New Note</a>
		</div>
	@endif
</div>


<div class="row all-reports m-0">
	
	@include('purchase.vendor._sidebar')

	<div class="col-md-9 pr-0 Reports">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-stripped mb-0 datatables">
						<thead>
							<tr>
								<th>Description</th>
								<th>Added From</th>
								<th>Date</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_note) && sizeof($arr_note)>0)
								@foreach($arr_note as $key => $value)
									<tr>
										<td>{{ $value['description'] ?? '' }}</td>
										<td>{{ $value['user_detail']['first_name'] ?? '' }} {{ $value['user_detail']['last_name'] ?? '' }}</td>
										<td>{{ date('Y-m-d h:i A',strtotime($value['created_at'])) ?? '' }}</td>
										<td>
											<button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_note" onclick="note_edit('{{base64_encode($value['id'] ?? '')}}')"><i class="fa fa-edit"></i></button>
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
</div>

<!-- Modal -->
<div class="modal right fade" id="add_note" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title text-center">Add Note</h4>
				<button type="button" class="close xs-close" data-dismiss="modal">×</button>
			</div>

			<div class="modal-body">
				<form method="post" action="{{ Route('note_store') }}" id="frmAddNote">
	            {{ csrf_field() }}
	            <input type="hidden" name="action" value="create">
	            <input type="hidden" name="vendor_id" value="{{ $enc_id }}">
					<div class="col-md-12">
						
						<div class="form-group row">
							<div class="col-sm-12">
								<label class="col-form-label">Note Description<span class="text-danger">*</span></label>
                            	<textarea name="description" class="form-control" rows="6" id="description" placeholder="Note Description" data-rule-required="true"></textarea>
                            	<label class="error" id="description_error"></label>
							</div>
						</div>

						<div class="text-center py-3">
							<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
							<button type="button" class="btn btn-secondary btn-rounded closeForm">Cancel</button>
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
		$('.datatables').DataTable({searching: true, paging: true, info: true});
	});
</script>
<script type="text/javascript">
	var createUrl = "{{ Route('note_store') }}";
	var updateUrl = "{{ Route('note_update','') }}";

	$(document).ready(function(){

		$('#frmAddNote').validate({
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

		$("#frmAddNote").submit(function(e) {
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
      				success:function(response)
      				{
      					common_ajax_store_action(response);
      				}
				});
			}
		});

		$('.closeForm').click(function(){
			$("#add_note").modal('hide');
			form_reset();
		});

	});

	function form_reset() {
		$('#frmAddNote')[0].reset();
	}

	var module_url_path = "{{ $module_url_path ?? '' }}";
	function note_edit(enc_id)
	{
		if(enc_id!='')
		{
			$.ajax({
						url:module_url_path+'/note_edit/'+enc_id,
						type:'GET',
						dataType:'json',
						beforeSend:function(){

						},
						success:function(response){
							if(response.status == 'SUCCESS')
							{
								$('#frmAddNote').attr('action', updateUrl+'/'+enc_id);
  								$('input[name=action]').val('update');

								$('#description').val(response.data.description);
							}
						}
				  });
		}
	}

</script>

@endsection
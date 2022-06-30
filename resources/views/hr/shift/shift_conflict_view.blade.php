@if(isset($arr_shifts) && !empty($arr_shifts))
<div class="table-responsive">
	<table class="table table-stripped mb-0">
		<thead>
			<tr>
				<th>{{ trans('admin.user') }}</th>
				<th>{{ trans('admin.existing_shift') }}</th>
				<th>{{ trans('admin.changed_shift') }}</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($arr_shifts as $row)
			<?php
				$user_id = $row['user_id']??0;

				$key = array_search($user_id, array_column($arr_users, 'id'));

				$user = $arr_users[$key]??[];

				$ext_shift_key = array_search($row['shift_id']??'', array_column($arr_shift_dtls, 'id'));
				$req_shift_key = array_search($req_shift_id??'', array_column($arr_shift_dtls, 'id'));
				$ext_shft_dtls = $arr_shift_dtls[$ext_shift_key];
				$req_shft_dtls = $arr_shift_dtls[$req_shift_key];
			?>
			<tr class="conflict-row">
				<td>
					{{ $user['first_name']??'' }} {{ $user['last_name']??'' }} ( {{ $user['emp_id']??'' }} )
				</td>
				<td>
					<p><strong>{{ $ext_shft_dtls['name']??'' }}</strong></p>
					<p>({{ date('h:i A', strtotime($ext_shft_dtls['from']??'')) }} - {{ date('h:i A', strtotime($ext_shft_dtls['to']??'')) }})</p>
					<p>
						{{ Carbon::parse($row['from_date'])->format('d-M-Y') }} - {{ Carbon::parse($row['to_date'])->format('d-M-Y') }}
					</p>
				</td>
				<td>
					<p><strong>{{ $req_shft_dtls['name']??'' }}</strong>
					</p>
					<p>({{ date('h:i A', strtotime($req_shft_dtls['from']??'')) }} - {{ date('h:i A', strtotime($req_shft_dtls['to']??'')) }})</p>
				</td>
				<td>
					<button type="button" class="btn btn-sm btn-warning exclude-btn" data-user-id="{{ $user_id??'' }}">{{ trans('admin.exclude') }}</button>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

<script type="text/javascript">
	/*$('.conflict-row').mouseenter(function(){
		$('.exclude-btn').hide();
		$(this).find('.exclude-btn').show();
	});*/

	$(".exclude-btn").click(function() {
		var rem_user_id = $(this).data('user-id');

		var $select = $('#users');
		var idToRemove = $(this).data('user-id').toString();

		var values = $select.val();
		console.log(values);
		if (values) {
			var i = values.indexOf(idToRemove);
			console.log(i);
			if (i >= 0) {
				values.splice(i, 1);
				$select.val(values).change();
			}
		}

		// $('#users option[value="'+rem_user_id+'"]').prop("selected",false);

		$(this).closest('tr').remove();
	});
</script>


@endif
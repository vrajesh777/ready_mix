@extends('layout.master')
@section('main_content')

<!-- Content Starts -->

<div class="card mb-0">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-striped table-nowrap custom-table mb-0" id="shiftsTable">
				<thead>
					<tr>
						<th>{{ trans('admin.employee_name') }}</th>
						<th>{{ trans('admin.email') }}</th>
						<th>{{ trans('admin.department') }}</th>
						<th>{{ trans('admin.cost_to_emp') }} (SAR)</th>
						<th class="text-center notexport">{{ trans('admin.actions') }}</th>
					</tr>
				</thead>
				<tbody>

					@if(isset($arr_data) && !empty($arr_data))

					@foreach($arr_data as $key => $emp)

					<tr>
						<td>{{ $emp['first_name'] ?? '' }} {{ $emp['last_name'] ?? '' }}</td>
						<td>{{ $emp['email'] ?? '' }}</td>
						<td>{{ $emp['department']['name'] ?? '' }}</td>
						<td>{{ isset($emp['salary_details']['monthly_total'])?number_format($emp['salary_details']['monthly_total'],2):0.00 }}</td>
                        <td class="text-center">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item action-edit" href="{{ Route('salary_details',base64_encode($emp['id'])) }}">{{ trans('admin.salary_details') }}</a>
								</div>
							</div>
						</td>
					</tr>

					@endforeach
					@endif
					
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- /Content End -->


<script type="text/javascript">

	$(document).ready(function() {

		var table = $('#shiftsTable').DataTable({
		});

	});

</script>

@stop
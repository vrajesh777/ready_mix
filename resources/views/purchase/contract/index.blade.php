@extends('layout.master')
@section('main_content')

<style type="text/css">
	.select2-container {
		width: 100% !important;
	}
	.notification {
		z-index: 999999;
	}
</style>


<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <a class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" href="{{ Route('contract_create') }}">New Contract</a>
                </li>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">
		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="contractTable">
						<thead>
							<tr>
								<th>Contract Id</th>
								<th>Vendors</th>
								{{-- <th>Purchase Order</th> --}}
								<th>Contract Value</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th>Added By</th>
								<th class="text-right notexport">Actions</th>
							</tr>
						</thead>
						
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['contract_id'] ?? '' }}</td>
										<td>{{ $value['user_meta'][0]['meta_value'] ?? '' }}</td>
										{{-- <td>{{ $value['pur_order_details']['order_number'] ?? '' }}-{{ $value['pur_order_details']['name'] ?? '' }}</td> --}}
										<td>{{ number_format($value['contract_value'],2) ?? '' }}</td>
										
										<td>{{ $value['start_date'] ?? '' }}</td>
										<td>{{ $value['end_date'] ?? '' }}</td>
										<td>{{ $value['user_details']['first_name'] ?? '' }} {{ $value['user_details']['last_name'] ?? '' }}</td>
										<td class="text-center">
											<a class="dropdown-item" href="{{ Route('contract_edit',base64_encode($value['id'])) }}"><i class="far fa-edit"></i></a>
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
<!-- /Content End -->


<script type="text/javascript">
	$(document).ready(function(){
			$('#contractTable').DataTable({
			// "pageLength": 2
			dom:
			  "<'ui grid'"+
			     "<'row'"+
			        "<'col-sm-12 col-md-2'l>"+
			        "<'col-sm-12 col-md-6'B>"+
			        "<'col-sm-12 col-md-4'f>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-12'tr>"+
			     ">"+
			     "<'row'"+
			        "<'col-sm-6'i>"+
			        "<'col-sm-6'p>"+
			     ">"+
			  ">",
			buttons: [{
				extend: 'pdf',
				title: '{{ Config::get('app.project.title') }} Contract',
				filename: '{{ Config::get('app.project.title') }} Contract PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Contract',
				filename: '{{ Config::get('app.project.title') }} Contract EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Contract CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});
</script>

@stop
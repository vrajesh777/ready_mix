@extends('layout.master')
@section('main_content')

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		@include('layout._operation_status')

		<div class="card mb-0">
			<div class="card-header">
				<form id="filterForm">
					<div class="row align-items-center">
						<div class="col-md-3">
							<div class="position-relative p-0">
								<input class="form-control pr-5 mainDateInput" name="date" placeholder="Date" value="{{ $date??'' }}">
								<div class="input-group-append date-icon"><i class="fal fa-calendar-alt"></i></div>
		        			</div>
						</div>
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						@if($obj_user->hasPermissionTo('sales-inquirie-create'))
						<div class="col-md-3">
							<a href="{{ Route('create_estimate') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded pull-right" style="float: right;"><i class="fa fa-plus"></i> New Estimate</a>
						</div>
						@endif
				    </div>
			    </form>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
						<thead>
							<tr>
								<th>{{ trans('admin.sr_no') }}</th>
								<th>{{ trans('admin.from') }}</th>
								<th>{{ trans('admin.email') }}</th>
								<th>{{ trans('admin.date') }}</th>
								<th>{{ trans('admin.subject') }}</th>
								<th>{{ trans('admin.medium') }}</th>
								<th class="none"></th>
							</tr>
						</thead>
						<tbody>

							@if(isset($arr_data) && !empty($arr_data))

							@foreach($arr_data as $index => $row)

							<tr>
								<td>{{ ++$index }}</td>
								<td>{{ $row['from_name']??'' }}</td>
								<td>{{ $row['email']??'' }}</td>
								<td>{{ date('Y-m-d', strtotime($row['created_at']??'')) }}</td>
								<td>{{ $row['subject'] ?? 'N/A' }}</td>
								<td>{{ $row['medium'] ?? 'N/A' }}</td>
								<td>
						            <table>
						            	<thead>
									        <tr>
									            <th>{{ trans('admin.requirement') }}</th>
									            <th>{{ trans('admin.note') }}</th>
									        </tr>
									    </thead>
									    <tbody>
									    	<tr>
									    		<td class="table-initial">{{ $row['requirement']??'' }}</td>
									            <td class="table-initial">{{ $row['note'] }}</td>
									    	</tr>
									    </tbody>
						            </table>
					        	</td>
							</tr>

							@endforeach

							@else

							<h3 align="center">{{ trans('admin.no_record_found') }}</h3>

							@endif
							
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Content End -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="fal fa-receipt text-black-50 mr-1"></i>{{ trans('admin.delivery_note') }}</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="del_note_form_wrapp">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('admin.close') }}</button>
				<button type="button" class="btn btn-primary del_note_form_submit">{{ trans('admin.save') }}</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		var table = $('#leadsTable').DataTable({
			// "pageLength": 2
			'responsive': true,
			"order" : [[ 0, 'desc' ]],
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
				title: '{{ Config::get('app.project.title') }} Invoice',
				filename: '{{ Config::get('app.project.title') }} Invoice PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Invoice',
				filename: '{{ Config::get('app.project.title') }} Invoice EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Invoice CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});

		// Handle click on "Expand All" button
	    $('#btn-show-all-children').on('click', function(){
	        // Expand row details
	        console.log(table.rows(':not(.parent)').nodes().to$().find('td:first-child'));
	        table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
	    });

	    // Handle click on "Collapse All" button
	    $('#btn-hide-all-children').on('click', function(){
	        // Collapse row details
	        table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
	    });

		function time() {
			var d = new Date();
			var s = d.getSeconds();
			var m = d.getMinutes();
			var h = d.getHours();
			var inputTime = ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
			$('.commonTime').val(inputTime);
		}

		setInterval(time, 1000);

		$('.mainDateInput').datepicker({
			setDate: new Date(),
			// format: 'dd/mm/yyyy',
			todayHighlight: true,
			autoclose: true,
			startDate: '-0m',
			minDate: 0,
		}).on('changeDate', function(ev){
			$('#filterForm').submit();
		});

	});

</script>

@stop
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
				@if($obj_user->hasPermissionTo('purchase-orders-create'))
                <li class="list-inline-item">
                    <a class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded" href="{{ Route('purchase_order_create') }}">{{ trans('admin.new') }} {{ trans('admin.purchase_order') }}</a>
                </li>
                @endif
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
					<table class="table table-striped table-nowrap custom-table mb-0" id="poTable">
						<thead>
							<tr>
								<th>{{ trans('admin.purchase_order') }}</th>
								<th>{{ trans('admin.total') }}</th>
								<th>{{ trans('admin.vendor') }}</th>
								<th>{{ trans('admin.order') }} {{ trans('admin.date') }}</th>
								<th>{{ trans('admin.payment') }} {{ trans('admin.status') }}</th>
								@if($obj_user->hasPermissionTo('purchase-orders-update'))
								<th>{{ trans('admin.status') }}</th>
								@endif
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['order_number'] ?? '' }}</td>
										<td>{{ number_format($value['total'],2) ?? '' }}</td>
										<td>{{ $value['user_meta'][0]['meta_value'] ?? '' }}</td>
										<td>{{ $value['order_date'] ?? '' }}</td>
										<td>
											@php
												$per_paid = 0;
												$paid_amount = $total_amount =  0;
												$paid_amount = array_sum(array_column($value['vendor_payment'], 'amount'));
												$total_amount = $value['total'] ?? 0;
												$per_paid = ($paid_amount / $total_amount) * 100;
											@endphp

											<div class="progress">
												<div class="progress-bar bg-success" role="progressbar" style="width: {{ number_format($per_paid,2) ?? '' }}%" aria-valuenow="{{ number_format($per_paid,2) ?? '' }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($per_paid,2) ?? '' }}%</div>
											</div>
										</td>
										@if($obj_user->hasPermissionTo('purchase-orders-update'))
										<td>
											@if($value['status'] == '1')
												<button type="button" class="btn btn-info btn-sm">Not yet approve</button>
											@elseif($value['status'] == '2')
												<button type="button" class="btn btn-success btn-sm">Approved</button>
											@elseif($value['status'] == '3')
												<button type="button" class="btn btn-danger btn-sm">Reject</button>
											@endif
										</td>
										@endif
	
										<td class="text-center">
											<a class="dropdown-item" href="{{ Route('purchase_order_view',base64_encode($value['id'])) }}"><i class="far fa-eye"></i></a>
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
<!-- <style type="text/css">
	.custom-table tr{box-shadow:none;}
</style> -->
<!-- Content Starts -->
<!-- <div class="row">
	<div class="col-md-12">
		<div class="card mt-5">
			<div class="card-body">
				<img class="mx-auto d-block mb-4" src="{{ asset('/') }}images/logo.png" alt="" width="250">
				<div class="table-responsive" style="margin-bottom:1.5rem">
				 <h4 style="text-align:center;margin-bottom:1rem">Report On Compressive Strength Of Concrete Cube</h4>	
					<table class="table table-nowrap mb-0">
						<tbody>
							<tr style="box-shadow:none;">
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Client:-&nbsp;&nbsp;</b>Jeddah First Group</td>
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Site:-&nbsp;&nbsp;</b>Al Safa Dist- Jeddah.</td>
							</tr>
							<tr style="box-shadow:none;">
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Consultant:-&nbsp;&nbsp;</b>Na.</td>
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Project:-&nbsp;&nbsp;</b>Residential building</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="table-responsive" style="margin-bottom:1.5rem">
				 <h4>Required Concrete Mix Specification:</h4>	
					<table class="table table-nowrap mb-0">
						<tbody>
							<tr>
								<td colspan="2" style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Compressive Strength On Cube:-&nbsp;&nbsp;</b>30 MPa measured at 28days</td>
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Structure Element:-&nbsp;&nbsp;</b>Slab</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Slump:-&nbsp;&nbsp;</b>150 + 25 mm</td>
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Concrete Temp:-&nbsp;&nbsp;</b>Na °C</td>
								<td style="border-top:1px solid #dee2e6;padding:.5rem;"><b>Quantity :-&nbsp;&nbsp;</b>100</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="table-responsive" style="margin-bottom:1.5rem">
				    <h4>Sampling:</h4>	
					<table class="table table-nowrap mb-0">
						<tbody>
							<tr>
								<td><b>Pouring Date:-&nbsp;&nbsp;</b>12/5/2020</td>
								<td><b>Slump:-&nbsp;&nbsp;</b>160</td>
								<td><b>No Of Cubes Tested:-&nbsp;&nbsp;</b>6</td>
							</tr>
							<tr>
								<td><b>Mix Code:-&nbsp;&nbsp;</b>G30I20CUB</td>
								<td><b>Concrete Temp:-&nbsp;&nbsp;</b>Na</td>
								<td><b>Method Of Compaction:-&nbsp;&nbsp;</b>Manual</td>
							</tr>
							<tr>
								<td><b>Mix Desgin:-&nbsp;&nbsp;</b>30MPa-OPC-Cube</td>
								<td><b>Air Content:-&nbsp;&nbsp;</b>1.9%</td>
								<td><b>Sampled By :-&nbsp;&nbsp;</b>PWR Tech</td>
							</tr>

						</tbody>
					</table>
				</div>
				<div class="table-responsive" style="margin-bottom:1.5rem">
					 <h4>Compressive Strength Of Concrete Cube Results:</h4>	
					<table class="table table-striped table-nowrap custom-table mb-0">
						<thead>
							
							<tr>
								<th>Spec.<br>No.</th>
								<th>Date<br>Tested</th>
								<th>Age<br>Days</th>
								<th>Weight<br>Kg</th>
								<th>S/Area<br>MM2</th>
								<th>Height<br>MM</th>
								<th>Density<br>(Kg/M³)</th>
								<th>M/Load<br>KN</th>
								<th>C. Strength<br>MPa</th>
								<th>Type Of Fraction</th>
							</tr>
						</thead>
						
						<tbody>
							
							<tr>
								<td>1</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
							<tr>
								<td>2</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
							<tr>
								<td>3</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
							<tr>
								<td>4</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>

							<tr style="background-color:transparent;"><td style="border:none">&nbsp;&nbsp;</td></tr>
							<tr style="background-color:transparent;"><td style="border:none">&nbsp;&nbsp;</td></tr>
							<tr style="background-color:transparent;"><td style="border:none">&nbsp;&nbsp;</td></tr>

							<tr>
								<td>1</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
							<tr>
								<td>2</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
							<tr>
								<td>3</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
							<tr>
								<td>4</td>
								<td>##</td>
								<td>7</td>
								<td>8.234</td>
								<td>22500</td>
								<td>150</td>
								<td>2440</td>
								<td>669.447</td>
								<td>22500</td>
								<td>Satisfactory</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table-responsive" style="margin-bottom:1.5rem">
					<table class="table table-nowrap mb-0">
						<tbody>
							<tr>
								<td style="background-color:#ddd"><b>Average At 7 Days:-&nbsp;&nbsp;</b></td>
								<td>#VALUE! Mpa</td>
								<td style="background-color:#ddd"><b>Average At 7 Days:-&nbsp;&nbsp;</b></td>
								<td>34.19 Mpa</td>
							</tr>
							<tr>
								<td colspan="4"><h4 style="margin:10px 0 0">Remark:</h4></td>
							</tr>
							<tr>
								<td colspan="4" style="">The Required Strength at 7 day is 75% from the target. </td>
							</tr>
							<tr>
								<td colspan="4" style="border:none;">Note: 1 N/mm2 =145 PSI,  1Kg =2.20462 Pound, 1" =25.4 mm.</td>
							</tr>
							<tr>
								<td colspan="3" style="border:none;">&nbsp;&nbsp;</td>
								<td style="border:none;"><b>Q.C. Mngr.&nbsp;&nbsp;</b>Mohamed Al-Tohami </td>
							</tr>
							<tr>
								<td colspan="3" style="border:none;">&nbsp;&nbsp;</td>
								<td style="border:none;"><b>Signature :	</b></td>
							</tr>

						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div> -->
<!-- /Content End -->


<script type="text/javascript">
	$(document).ready(function(){
			$('#poTable').DataTable({
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
				title: '{{ Config::get('app.project.title') }} Purchase Order',
				filename: '{{ Config::get('app.project.title') }} Purchase Order PDF',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'excel',
				title: '{{ Config::get('app.project.title') }} Purchase Order',
				filename: '{{ Config::get('app.project.title') }} Purchase Order EXCEL',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}, {
				extend: 'csv',
				filename: '{{ Config::get('app.project.title') }} Purchase Order CSV',
				className: 'btn btn-sm btn-primary',
				exportOptions: {
		            columns: ':not(.notexport)',
		        }
			}]
		});
	});
</script>

@stop
@extends('layout.master')
@section('main_content')

<!-- Page Header -->
<div class="page-header pt-3 mb-0 ">
	<div class="row">
		<div class="col text-right">
			<ul class="list-inline-item pl-0">
                <li class="list-inline-item">
                    <a href="{{ Route('vhc_purchase_parts_create') }}" class="add btn btn-gradient-primary font-weight-bold text-white todo-list-add-btn btn-rounded">{{ trans('admin.add') }} {{$module_title??''}}</a>
                </li>
            </ul>
		</div>
	</div>
</div>
<!-- /Page Header -->

<!-- Content Starts -->
<div class="row">
	<div class="col-md-12">

		@include('layout._operation_status')

		<div class="card mb-0">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-nowrap custom-table mb-0" id="driverTable">
						<thead>
							<tr>
								<th>{{ trans('admin.order') }}</th>
								<th>{{ trans('admin.date') }}</th>
								<th>{{ trans('admin.name') }}</th>
								<th>{{ trans('admin.condition') }}</th>
								<th>{{ trans('admin.qty') }}</th>
								<th>{{ trans('admin.warranty') }}</th>
								<th class="text-right notexport">{{ trans('admin.actions') }}</th>
							</tr>
						</thead>
						<tbody>
							@if(isset($arr_data) && sizeof($arr_data)>0)
								@foreach($arr_data as $key => $value)
									<tr>
										<td>{{ $value['order_number'] ?? '' }}</td>
										<td>{{ $value['order_date'] ?? '' }}</td>
										<td>{{ $value['part']['commodity_name'] ?? '' }}</td>
										<td>{{ $value['condition'] ?? '' }}</td>
										<td>{{ $value['quantity'] ?? '' }}</td>
										<td>{{ $value['warrenty'] ?? '' }}</td>
										<td class="text-center">
											<div class="dropdown dropdown-action">
												<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item action-edit" href="{{ Route('vhc_purchase_parts_edit',base64_encode($value['id'] ?? 0)) }}">{{ trans('admin.edit') }}</a>
													<a class="dropdown-item action-edit details_model" href="javascript:void(0);" {{-- data-toggle="modal" data-target="#details_model" --}}  data-detail-id="{{ base64_encode($value['id']) }}">{{ trans('admin.view') }}</a>
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
	</div>
</div>
<!-- /Content End -->

<!-- Edit Qty Modal -->
<div class="modal fade right" id="details_model" tabindex="-1" role="dialog" aria-modal="true">
	<div class="modal-dialog" role="document">
		<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">

			<div class="modal-header">
                <h4 class="modal-title text-center">Parts Purchase Infromation</h4>
                <button type="button" class="close xs-close" data-dismiss="modal">×</button>
            </div>

			<div class="modal-body">
				<ul class="personal-info">
					<li>
						<div class="title">#Order</div>
						<div class="text" id="order"></div>
					</li>
					<li>
						<div class="title">Parts Name</div>
						<div class="text" id="parts_name"></div>
					</li>
					<li>
						<div class="title">Supplier Name</div>
						<div class="text" id="supplier_name"></div>
					</li>
					<li>
						<div class="title">Manufacturer Name</div>
						<div class="text" id="manufacturer_name"></div>
					</li>
					<li>
						<div class="title">Buy Price</div>
						<div class="text" id="buy_price"></div>
					</li>
					<li>
						<div class="title">Quantity</div>
						<div class="text" id="quantity"></div>
					</li>
					<li>
						<div class="title">Part no</div>
						<div class="text" id="part_no"></div>
					</li>
					<li>
						<div class="title">Condition</div>
						<div class="text" id="condition"></div>
					</li>
					<li>
						<div class="title">Added Date</div>
						<div class="text" id="added_date"></div>
					</li>
				</ul>

				<div class="barcode" style="max-width:145px;width:100%;text-align:center;">
				    {{-- <p class="pname m-0">Amol</p>
				    <p class="pprice m-0">Price: 1000</p>
				    {!! DNS1D::getBarcodeHTML("OIL123", "C128",1.4,22) !!}
				    <p class="pid m-0">OIL123</p> --}}
				</div>


			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div>
<!-- modal -->


<script type="text/javascript">

	$(document).ready(function(){
		$('#driverTable').DataTable({
		});

		$('.details_model').click(function(){
			var id = $(this).data('detail-id');
			$.ajax({
				url:"{{ Route('vhc_purchase_parts_view','') }}/"+id,
				type:'GET',
				dataType:'json',
				success:function(resp){
					if(resp.status == 'success')
					{
						if(typeof(resp.arr_details) == 'object')
						{
							$('#details_model').modal('show');

							$('#order').html(resp.arr_details.order_number);
							$('#parts_name').html(resp.arr_details.part.commodity_name);
							var supplier_fname = resp.arr_details.supplier_details.first_name;
							var supplier_lname = resp.arr_details.supplier_details.last_name;
							$('#supplier_name').html(supplier_fname+' '+supplier_lname);
							$('#manufacturer_name').html(resp.arr_details.manufacturer_details.name);
							$('#buy_price').html(resp.arr_details.buy_price);
							$('#quantity').html(resp.arr_details.quantity);
							$('#part_no').html(resp.arr_details.part_no);
							$('#condition').html(resp.arr_details.condition);
							$('#added_date').html(resp.arr_details.purch_date);
							
							$('.barcode').html(resp.arr_details.code);
						}
						else
						{
							$('#details_model').modal('hide');
						}
					}
				}
			});
		});
	});

</script>

@stop
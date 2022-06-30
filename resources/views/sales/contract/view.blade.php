@extends('layout.master')
@section('main_content')
<!-- Page Header -->
<div class="row">

	<div class="col-sm-12">

		@include('layout._operation_status')

		<div class="row align-items-center">
			<h4 class="col-md-8 card-title mt-0 mb-2"># {{ $arr_contract['contract_no'] }}</h4>
			<div class="col-md-4">
				{{-- <a href="{{ Route('view_invoice', base64_encode($invoice['id'])) }}" class="border-0 btn btn-success btn-gradient-success btn-rounded mb-2 {{ $total_left_to_pay==0?'disabled':'' }} " target="_blank" ><i class="fa fa-money"></i> Invoice</a> --}}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">
				<div class="card">
				<div class="card-body">
	                <div class="table-responsive">
		               	<table class="table">
		               		<thead>
		               			<tr>
		               				<th>{{ trans('admin.item') }}</th>
									<th>{{ trans('admin.OPC_1') }}</th>
									<th>{{ trans('admin.SRC_1') }}</th>
									<th><i class="fas fa-cog"></i></th>
		               			</tr>
		               		</thead>
		               		<tbody>
		               			@if(isset($arr_contract['contr_details']) && !empty($arr_contract['contr_details']))
			               			@foreach($arr_contract['contr_details'] as $index => $row)
			               			<tr>
			               				<td align="center">{{ ++$index }}</td>
			               				<td class="description">
			               					<span><strong>{{ $row['product_details']['name'] ?? '' }}</strong></span><br>
			               					<span>{{ $row['product_details']['description'] }}</span>
			               				</td>
			               				
			               				<td>{{ isset($row['opc_1_rate'])?number_format($row['opc_1_rate'],2):'' }}</td>
			               				<td>{{ isset($row['src_5_rate'])?number_format($row['src_5_rate'],2):'' }}</td>
			               				
			               			</tr>
			               			@endforeach
		               			@endif
				            </tbody>
		            	</table>
	                </div> 	
			 	</div>
		 		</div>
       		</div>
            <div class="col-md-4 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0">{{ trans('admin.summary') }}</h3>
					 	<p class="font-weight-bold">{{ trans('admin.customer') }}  : {{ $arr_contract['cust_details']['first_name'] ?? '' }}&nbsp;
						 	{{ $arr_contract['cust_details']['last_name'] ?? '' }}</p>
						<p class="font-weight-bold"> Site : {{ $arr_contract['title'] ?? '' }}</p>
						<p class="font-weight-bold"> Location : {{ $arr_contract['site_location'] ?? '' }}</p>
					</div>
				</div>
			</div>
        </div>
        <div class="row">
        	<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0">{{ trans('admin.admin_note') }}</h3>
					 	<p>{{ $arr_contract['admin_note'] ?? '' }}</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0">{{ trans('admin.client_note') }}</h3>
					 	<p>{{ $arr_contract['client_note'] ?? '' }}</p>
					</div>
				</div>
			</div>
			<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">
						<h3 class="card-title mt-0">{{ trans('admin.terms_&_conditions') }}</h3>
					 	<p>{{ $arr_contract['terms_conditions'] ?? '' }}</p>
					</div>
				</div>
			</div>

			<div class="col-md-6 d-flex">
				<div class="card profile-box flex-fill">
					<div class="card-body">

						<div class="table-responsive">
			               	<table class="table">
			               		<thead>
			               			<tr>
			               				<th width="4%">#</th>
			               				<th width="50%">{{ trans('admin.document') }}</th>
			               				<th width="27%">{{ trans('admin.actions') }}</th>
			               			</tr>
			               		</thead>
			               		<tbody>
			               			<tr>
			               				<td>1</td>
			               				<td>{{ trans('admin.contract') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['contract']) && $arr_contract['contract_attch']['contract'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['contract']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['contract'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>2</td>
			               				<td>{{ trans('admin.quotation') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['quotation']) && $arr_contract['contract_attch']['quotation'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['quotation']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['quotation'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>3</td>
			               				<td>{{ trans('admin.baladiya_permission') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['bala_per']) && $arr_contract['contract_attch']['bala_per'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['bala_per']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['bala_per'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>4</td>
			               				<td>{{ trans('admin.owner_id') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['owner_id']) && $arr_contract['contract_attch']['owner_id'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['owner_id']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['owner_id'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>5</td>
			               				<td>{{ trans('admin.credit_form') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['credit_form']) && $arr_contract['contract_attch']['credit_form'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['credit_form']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['credit_form'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>6</td>
			               				<td>{{ trans('admin.purchase_order') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['purchase_order']) && $arr_contract['contract_attch']['purchase_order'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['purchase_order']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['purchase_order'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>

			               			<tr>
			               				<td>7</td>
			               				<td>{{ trans('admin.pay_grnt') }}</td>
			               				<td>
			               					@if(isset($arr_contract['contract_attch']['pay_grnt']) && $arr_contract['contract_attch']['pay_grnt'] !='')
												@if(file_exists($cust_att_base_path.$arr_contract['contract_attch']['pay_grnt']))
													<a target="_blank" download href="{{ $cust_att_public_path }}{{ $arr_contract['contract_attch']['pay_grnt'] ?? '' }}"><i class="fa fa-download"></i></a>
												@endif	
											@endif
			               				</td>
			               			</tr>


					            </tbody>
			            	</table>
		                </div> 	
							

					</div>
				</div>
			</div>

        </div>
	</div>

</div>
<!-- /Page Header -->


<script type="text/javascript">

	$(document).ready(function(){

	});

</script>

@stop
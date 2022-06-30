@extends('layout.master')
@section('main_content')
<div class="card">
	<div class="card-header">
		<h4 class="card-title m-0">Salary Details
			<a href="#" class="edit-icon"><i class="fa fa-pencil"></i></a>
		</h4>
	</div>
	<div class="card-body payroll-detail">
					
			<div class="form-group row">
				<div class="col-sm-4">
					<label class="col-form-label">Annual CTC</label>
					<div class="font-weight-bold">$1,80,000.00 per year</div>
				</div>
				<div class="col-sm-4">
					<label class="col-form-label">Monthly Income</label>
                    <div class="font-weight-bold">$15,000.00</div>
				</div>
				<div class="col-sm-4">
					<ul class="pagination justify-content-end pt-3 px-3 mb-0">
						<li class="page-item"><a class="page-link" href="#">
							<i class="fal fa-print"></i></a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-responsive">
				<table class="table mb-0">
					<thead>
						<tr>
							<th>Salary Components</th>
							<th>Amount Monthly</th>
							<th>Amount Annually</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3" class="font-weight-bold">Earnings</td>
							
						</tr>
						<tr>
							<td>Basic<br>(50 % of CTC)</td>
							<td>₹ 7,500.00</td>
							<td>90000</td>
						</tr>
						<tr>
							<td>Basic<br>(50 % of CTC)</td>
							<td>₹ 7,500.00</td>
							<td>90000</td>
						</tr>
						

						<tr class="company-cost">
							<td colspan="">Cost to Company</td>
							<td class="">₹ 15000	</td>
							
							<td>₹ 180000</td>
						</tr>
					

					</tbody>
				</table>
				
			</div>
	</div>
</div>

@endsection
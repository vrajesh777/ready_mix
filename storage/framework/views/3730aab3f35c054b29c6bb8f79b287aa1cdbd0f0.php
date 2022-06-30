<?php $__env->startSection('main_content'); ?>

<div class="card">
	<div class="card-header">
		<h4 class="card-title m-0">Pay Runs</h4>
	</div>
	<div class="card-body">
			<ul class="nav nav-tabs">
				<li class="nav-item"><a class="nav-link active" href="#RunPayroll" data-toggle="tab">Run Payroll</a></li>
				<li class="nav-item"><a class="nav-link" href="#PayrollHistory" data-toggle="tab">Payroll History</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane show active" id="RunPayroll">
					<h5 class="mb-4">Process Pay Run for May 2021 DRAFT</h5>
					<div class="payrun-info-row row">
					      <div class="col-md-8 col-sm-12 col-lg-7">
					        <div class="row">
					          <div class="col-md-4 payrun-detail">
					            <p class="mb-2">Employees' Net Pay</p>
					              <span class="payrun-price font-weight-bold">₹64,400.00</span>
					          </div>
					          <div class="col-md-4 payrun-detail border-left pl-4">
					            <p class="mb-2">Payment Date</p>
					            <span class="payrun-data font-weight-bold"> 31/05/2021</span>
					          </div>
					            <div class="col-md-4 payrun-detail">
					              <p class="mb-2">No. of Employees</p>
					              <span class="payrun-data font-weight-bold"> 3</span>
					            </div>
					        </div>
					      </div>
					      	<div class="col-md-4 col-sm-12 col-lg-5 text-right">
					            <a href="#" id="ember111" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">View Details</a>
					        </div>
					</div>
					<p class="mt-3 mb-0"><i class="fas fa-info-circle mr-2 form-text"></i>Please approve this payroll before 31/05/2021 | 04:00 PM</p>
				</div>
				<div class="tab-pane" id="PayrollHistory">
					<div class="table-responsive">
	                    <table class="table table-striped custom-table">
	                        <thead>
	                          <tr>
	                            <th>Payment Date</th>
	                            <th>Payroll Type</th>
	                            <th>Details</th>
	                            <th></th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                          <tr>
	                            <td>30/04/2021</td>
	                            <td>Regular Payroll</td>
	                            <td>01/04/2021</td>
	                            <td class="text-success">Paid</td>
	                          </tr>
	                        </tbody>
	                    </table>
                    </div>
				</div>
			</div>
			
			

	</div>
</div>

<div class="card">
	<div class="card-header">
		<h4 class="card-title m-0">Regular Payroll</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-4 bg-light border btn d-block mx-3">
				    <div class="mb-3">
				      <span class="text-xs">Period:</span> <span class="font-weight-bold text-xs">May 2021</span> |
				      <span class="text-xs">25 Payable Days </span>
				    </div>
				    <div class="row net-pay-data-without-bt">
				      <div class="col-md-6">
				          <h4>₹65,000.00</h4>
				        <div class="text-uppercase text-xs">Payroll Cost</div>
				      </div>
				      <div class="col-md-6">
				          <h4>₹64,400.00</h4>
				        <div class="text-uppercase text-xs">Employees' Net Pay</div>
				      </div>
				    </div>
			</div>

			<div class="col-md-2 text-center border btn d-block mx-3">
			    <div class="text-uppercase text-muted">Pay Day</div>
			    <div class="font-light text-xl">31</div>
			    <div class="text-uppercase text-xs">May, 2021</div>
			    <hr class="my-2">
			      <div class="text-md">3 Employees</div>
			</div>
		  	<div class="col-md-3 deductions-section mx-3">
			    <h4 class="font-xmedium">Taxes &amp; Deductions</h4>
			    <table class="table noborder-table">
			      <tbody>
			          <tr>
			            <td class="payrun-label">Taxes</td>
			            <td class="text-right">₹600.00</td>
			          </tr>
			          <tr>
			            <td class="payrun-label">Pre-Tax Deductions</td>
			            <td class="text-right">₹0.00</td>
			          </tr>
			          <tr>
			            <td class="payrun-label">Post-Tax Deductions</td>
			            <td class="text-right">₹0.00</td>
			          </tr>
			      </tbody>
			    </table>
		  	</div>
		  	<div class="col-md-2"></div>

		</div>
		 <a href="#"  data-toggle="modal" data-target="#SubmitApprove" class="mt-3 border-0 btn btn-primary btn-gradient-primary btn-rounded">Submit and Approve</a>
	</div>
</div>

<!-- Modal -->
	<div class="modal fade" id="SubmitApprove" tabindex="-1" role="dialog" aria-modal="true">
		<div class="modal-dialog" role="document">
			<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-content">
				<div class="modal-header">
                    <h4 class="mb-0">Approve Payroll</h4>
                    <button type="button" class="close xs-close" data-dismiss="modal">×</button>
                </div>

				<div class="modal-body">

					<p>You are about to approve this payroll for May, 2021. Once you approve it, you can make payments for all your employees on the paydate 31/05/2021.</p>
					<div class="submit-section mt-0 text-left">
                      	<button type="button" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Create</button>&nbsp;&nbsp;
				        <button type="button" class="btn btn-secondary btn-rounded cancel-button">Cancel</button>
                    </div>
					

				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div>
<!-- modal -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sample_pages/payroll3.blade.php ENDPATH**/ ?>
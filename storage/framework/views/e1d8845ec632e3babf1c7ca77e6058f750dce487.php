<?php $__env->startSection('main_content'); ?>

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Commodity List</h4>
		<div class="col-md-4 justify-content-between d-flex">
			<button class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2" id="add-task" data-toggle="modal" data-target="#add_item">Add</button>
			<!-- <a class="btn btn-primary">Add</a> -->
			<button type="button" class="border-0 btn btn-success btn-rounded mb-2">Import Items</button>
			<button type="button" class="border-0 btn btn-secondary btn-rounded mb-2">Import opening stock</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card mb-0">
				<div class="card-header">
					<div class="row">
						<!-- <div class="col-md-4">
							<button class="border-0 btn btn-primary btn-gradient-primary btn-rounded" id="add-task" data-toggle="modal" data-target="#add_item">Add</button>
							<button type="button" class="border-0 btn btn-success btn-rounded">Import Items</button>
							<button type="button" class="border-0 btn btn-secondary btn-rounded">Import opening stock</button>
						</div> -->
						<div class="col-md-2">
							<select class="multiselect" name="multiselect" multiple>
								<option value="1">Tags</option>
								<option value="2">Blues Blazzer full suit</option>
								<option value="3">7core</option>
								<option value="4">This a test item by hayder</option>
								<option value="5">This a test item by hayder</option>
							</select>
						</div>
						
						<div class="col-md-2">
							<select class="select">
								<option>Alert</option>
								<option value="1">Out of stock</option>
								<option value="2">Expired</option>
								
							</select>
						</div>
						<div class="col-md-2">
							<select class="multiselect" name="multiselect" multiple>
								<option value="1">Warehouse</option>
								<option value="2">Warehouse Name HS</option>
								<option value="3">Main Warehouse</option>
								<option value="4">Oficina Lepe</option>
								<option value="5">CVCC</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="multiselect" name="multiselect" multiple>
								<option value="1">Commodity</option>
								<option value="2">Product-1</option>
								<option value="3">Product-2</option>
								<option value="4">Product-3</option>
								<option value="5">Product-4</option>
							</select>
						</div>
						<div class="col-md-4">
							<ul class="pagination justify-content-end mb-0">
								<li class="page-item"><a class="page-link" href="#">Export</a></li>
								<li class="page-item"><a class="page-link" href="#">Manipulation</a></li>
								<li class="page-item"><a class="page-link" href="#">Export items</a></li>
								<li class="page-item"><a class="page-link" href="#">
									<i class="far fa-sync-alt"></i></a>
								</li>
							</ul>
						</div>	
				    </div>
				</div>
				
				<div class="card-body">

					<div class="table-responsive">
						<table class="table table-stripped mb-0 datatables">
							<thead>
								<tr>
									<th>Image</th>
									<th>Commodity Code</th>
									<th>Commodity Name</th>
									<th>Group name</th>
									<th>Warehouse name</th>
									<th>Inventory</th>
									<th>Unit Name</th>
									<th>Rate</th>
									<th>Purchase Price</th>
									<th>Tax</th>
									<th>Status</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><img src="<?php echo e(asset('/')); ?>images/ultratech_cement.png" alt="" width="70"></td>
									<td>DE6258</td>
									<td>UltraTech Cement</td>
									<td>CommodityGroup1</td>
									<td>Warehouse</td>
									<td>Inventory</td>
									<td>Kilograms</td>
									<td>500.00</td>
									<td>0.00</td>
									<td>0.5</td>
									<td>pendding</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										    <a href="<?php echo e(Route('item_view')); ?>" class="dropdown-item">View</a>
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td><img src="<?php echo e(asset('/')); ?>images/acc-cement.jpg" alt="" width="70"></td>
									<td>BG7813</td>
									<td>acc Cement</td>
									<td>CommodityGroup2</td>
									<td>Warehouse</td>
									<td>Inventory</td>
									<td>Kilograms</td>
									<td>500.00</td>
									<td>0.00</td>
									<td>0.5</td>
									<td>pendding</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										  <a href="<?php echo e(Route('item_view')); ?>" class="dropdown-item">View</a>
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td><img src="<?php echo e(asset('/')); ?>images/ambuja-cement.jpg" alt="" width="70"></td>
									<td>RB3102</td>
									<td>Ambuja Cement</td>
									<td>CommodityGroup3</td>
									<td>Warehouse</td>
									<td>Inventory</td>
									<td>Kilograms</td>
									<td>500.00</td>
									<td>0.00</td>
									<td>0.5</td>
									<td>pendding</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										  <a href="<?php echo e(Route('item_view')); ?>" class="dropdown-item">View</a>
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td><img src="<?php echo e(asset('/')); ?>images/ultratech_cement.png" alt="" width="70"></td>
									<td>DE6258</td>
									<td>UltraTech Cement</td>
									<td>CommodityGroup1</td>
									<td>Warehouse</td>
									<td>Inventory</td>
									<td>Kilograms</td>
									<td>500.00</td>
									<td>0.00</td>
									<td>0.5</td>
									<td>pendding</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										  <a href="<?php echo e(Route('item_view')); ?>" class="dropdown-item">View</a>
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td><img src="<?php echo e(asset('/')); ?>images/acc-cement.jpg" alt="" width="70"></td>
									<td>BG7813</td>
									<td>acc Cement</td>
									<td>CommodityGroup2</td>
									<td>Warehouse</td>
									<td>Inventory</td>
									<td>Kilograms</td>
									<td>500.00</td>
									<td>0.00</td>
									<td>0.5</td>
									<td>pendding</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										  <a href="<?php echo e(Route('item_view')); ?>" class="dropdown-item">View</a>
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td><img src="<?php echo e(asset('/')); ?>images/ambuja-cement.jpg" alt="" width="70"></td>
									<td>RB3102</td>
									<td>Ambuja Cement</td>
									<td>CommodityGroup3</td>
									<td>Warehouse</td>
									<td>Inventory</td>
									<td>Kilograms</td>
									<td>500.00</td>
									<td>0.00</td>
									<td>0.5</td>
									<td>pendding</td>
									<td class="text-center">
										<div class="btn-group">
										  <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										  <a href="<?php echo e(Route('item_view')); ?>" class="dropdown-item">View</a>
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
 <!-- Modal -->
	<div class="modal right fade" id="add_item" tabindex="-1" role="dialog" aria-modal="true">
		<div class="modal-dialog" role="document">
			<button type="button" class="close md-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="modal-content">

				<div class="modal-header">
                    <h4 class="modal-title text-center">Add item</h4>
                    <button type="button" class="close xs-close" data-dismiss="modal">×</button>
                  </div>

				<div class="modal-body">
					<div class="row">
				        <div class="col-md-12">
				        	<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
									<li class="nav-item"><a class="nav-link active" href="#bottom-tab1" data-toggle="tab"><i class="fal fa-bars mr-1"></i>General infor</a></li>
									<li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab"><i class="fas fa-users mr-1"></i>Properties</a></li>
								</ul>

								<div class="tab-content">
									<div class="tab-pane show active" id="bottom-tab1">
										<div class="row">
											<div class="form-group col-sm-6">
												<label class="col-form-label">Commodity Code<span class="text-danger">*</span></label>
					                            <input type="text" class="form-control"  name="title" placeholder="Commodity Code">
											</div>
											<div class="form-group col-sm-6">
												<label class="col-form-label">Commodity Name</label>
				            					<input type="text" class="form-control"  name="title" placeholder="Commodity Name">
											</div>
										
				                           
				                            <div class="form-group col-md-4">
				                            	<label class="col-form-label"> Commodity Barcode <span class="text-danger">*</span></label>
				                                <input class="form-control" type="text" placeholder="Commodity Barcode" name="Commodity Barcode"readonly="readonly">
				                            </div>
				                            <div class="form-group col-md-4">
				                            	<label class="col-form-label">Sku Code</label>
				                                <input class="form-control" type="text" placeholder="First name" name="prefix-name" disabled="disabled">
				                            </div>
				                            <div class="form-group col-md-4">
				                            	<label class="col-form-label">Sku Name</label>
				                                <input class="form-control" type="text" placeholder="Last name" name="last-name">
				                            </div>
				                       
											<div class="form-group col-sm-12">
												<label>Description</label>
												<textarea rows="5" cols="5" class="form-control" placeholder="Enter message"></textarea>
											</div>
									
											<div class="form-group col-sm-6">
												<label class="col-form-label">Commodity Type<span class="text-danger">*</span></label>
					                            <select class="select">
													<option>Commodity Type1</option>
													<option value="1">Commodity Type2</option>
													<option value="2">Commodity Type3</option>
												</select>
											</div>
										



											<div class="form-group col-sm-6">
												<label class="col-form-label">Units<span class="text-danger">*</span></label>
					                            <select class="select">
													<option>Units1</option>
													<option value="1">Units2</option>
													<option value="2">Units3</option>
												</select>
											</div>
											
										
											<div class="form-group col-sm-6">
												<label class="col-form-label">Commodity Group</label>
					                            <select class="form-control">
					                                <option>Commodity form-group</option>
					                            </select>
											</div>
											<div class="form-group col-sm-6">
												<label class="col-form-label">Sub Group</label>
					                           <select class="select">
													<option>Sub Group1</option>
													<option value="1">Sub Group2</option>
													<option value="2">Sub Group3</option>
													
												</select>
											</div>
										
											<div class="form-group col-sm-6">
												<label class="col-form-label">Rate<span class="text-danger">*</span></label>
				            					<input type="text" class="form-control"  name="rate" placeholder="rate">
											</div>
										
											<div class="form-group col-sm-6">
												<label class="col-form-label">Purchase Price</label>
				            					<input type="text" class="form-control"  name="Purchase Price" placeholder="Purchase Price">
											</div>
										
											<div class="form-group col-sm-6">
												<label class="col-form-label">Taxes</label>
					                            <select class="form-control">
					                                <option>Vat</option>
					                            </select>
											</div>
											
										</div>

										<div class="user-box user-box-upload-section">
									       
									            <div class="main-abt-title">
									                <label class="name-labell">Attach Receipt<span class="busine-span-smll"> ( Maximum 5 Images ) </span></label>
									            </div>
									       
									      
									            <div class="add-busine-multi">
									                <span data-multiupload="3">
									                    <span data-multiupload-holder></span>
									                    <span class="upload-photo">
									                        <img src="plus-img.jpg" alt="plus img">
									                        <input data-multiupload-src class="upload_pic_btn" type="file" multiple="" data-rule-required="false"> 
									                        <span data-multiupload-fileinputs></span>
									                    </span>
									                </span>
									                <div class="clerfix"></div>
									            </div>
									     
									        <div class="clearfix"></div>            
									    </div>
									</div>
									<div class="tab-pane" id="bottom-tab2">
										<div class="row">
											<div class="form-group col-sm-6">
												<label class="col-form-label">Origin</label>
				            					<input type="text" class="form-control"  name="Purchase Price" placeholder="Purchase Price">
											</div>
										
											<div class="form-group col-sm-6">
												<label class="col-form-label">Styles</label>
					                            <select class="form-control">
					                                <option>Non select</option>
					                            </select>
											</div>
											<div class="form-group col-sm-6">
												<label class="col-form-label">Model</label>
					                            <select class="form-control">
					                                <option>Non select</option>
					                            </select>
											</div>
											<div class="form-group col-sm-6">
												<label class="col-form-label">Sizes</label>
					                            <select class="form-control">
					                                <option>Non select</option>
					                            </select>
											</div>
											<div class="form-group col-sm-6">
												<label class="col-form-label">Color</label>
					                            <select class="form-control">
					                                <option>Non select</option>
					                            </select>
											</div>
										</div>	
									</div>
								</div>

				        


				                <div class="text-center py-3">
				                	<button type="button" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
				                	<button type="button" class="btn btn-secondary btn-rounded">Cancel</button>
				                </div>
				           
				        </div>
					</div>

				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div>
<!-- modal -->
<!-- multiselect CSS -->
         <link rel="stylesheet" type="text/css" href="<?php echo e(asset('/')); ?>css/jquery.multiselect.css"/>


	<!-- multiselect -->
	<script src="<?php echo e(asset('/')); ?>js/jquery.multiselect.js"></script>
    <script>
	    $('.multiselect').multiselect({
	        columns: 1,
	        // placeholder: 'Select Languages',
	        search: true,
	        selectAll: true
	    });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\wamp64\www\readymix-new\resources\views/sample_pages/item_index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('main_content'); ?>

<h4 class="card-title mt-0 mb-2">Commodity List View</h4>
	<div class="row">
		<div class="col-sm-12">
			<!-- <div class="card mb-0">
				<div class="card-body"> -->
					<div class="row">
						<div class="col-md-6 d-flex">
							<div class="card profile-box flex-fill">
								<div class="card-body">
									<h3 class="card-title border-bottom pb-2 mt-0 mb-3">General infor <!-- <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a> --></h3>
									<ul class="personal-info border rounded">
										<li>
											<div class="title">Commodity Code</div>
											<div class="text">2523</div>
										</li>
										<li>
											<div class="title">Commodity Name</div>
											<div class="text">UltraTech Cement</div>
										</li>
										<li>
											<div class="title">Commodity Group</div>
											<div class="text">CommodityGroup1</div>
										</li>
										<li>
											<div class="title">Commodity Barcode</div>
											<div class="text">53468586006</div>
										</li>
										<li>
											<div class="title">Sku Code</div>
											<div class="text">SKU123</div>
										</li>
										<li>
											<div class="title">Sku Name</div>
											<div class="text">ULTRATC</div>
										</li>
										
									</ul>
									<div class="photo-gallery mt-4">
									 	<div class="row photos">
								            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?php echo e(asset('/')); ?>images/desk.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="<?php echo e(asset('/')); ?>images/desk.jpg"></a></div>
								            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?php echo e(asset('/')); ?>images/building.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="<?php echo e(asset('/')); ?>images/building.jpg"></a></div>
								            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?php echo e(asset('/')); ?>images/loft.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="<?php echo e(asset('/')); ?>images/loft.jpg"></a></div>
								            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?php echo e(asset('/')); ?>images/building.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="<?php echo e(asset('/')); ?>images/building.jpg"></a></div>
								            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?php echo e(asset('/')); ?>images/loft.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="<?php echo e(asset('/')); ?>images/loft.jpg"></a></div>
								            <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="<?php echo e(asset('/')); ?>images/desk.jpg" data-lightbox="photos"><img class="img-fluid border rounded p-1" src="<?php echo e(asset('/')); ?>images/desk.jpg"></a></div>
								        </div>
								    </div>
								</div>
							</div>
						</div>

						<div class="col-md-6 d-flex">
							<div class="card profile-box flex-fill">
								<div class="card-body">
									<h3 class="card-title border-bottom pb-2 mt-0 mb-3">Details <!-- <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a> --></h3>
									<ul class="personal-info border rounded">
										<li>
											<div class="title">Origin</div>
											<div class="text">mater</div>
										</li>
										<li>
											<div class="title">Origin</div>
											<div class="text">Ultr Tech </div>
										</li>
										<li>
											<div class="title">Colors</div>
											<div class="text">Red</div>
										</li>
										<li>
											<div class="title">Size</div>
											<div class="text">534</div>
										</li>
										<li>
											<div class="title">Style</div>
											<div class="text">SKU</div>
										</li>
										<li>
											<div class="title">Unit</div>
											<div class="text">Kilograms</div>
										</li>
										<li>
											<div class="title">Rate</div>
											<div class="text">500.00</div>
										</li>
										<li>
											<div class="title">Purchase Price</div>
											<div class="text">500.00</div>
										</li>
										
									</ul>
									
								</div>
							</div>
						</div>

						<div class="col-md-12 d-flex">
							<div class="card profile-box flex-fill">
								<div class="card-body">
									<h3 class="card-title border-bottom pb-2 mt-0 mb-3">Description <!-- <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a> --></h3>
									
									<p>UltraTech Cement Limited is the largest manufacturer of cement in India and ranks among the world’s leading cement makers. UltraTech’s vision is to be ‘The Leader’ in Building Solutions. The company has a consolidated capacity* of 102.75 million tonnes per annum (MTPA) of grey cement. UltraTech has a strong presence in international markets such as Bangladesh, UAE, Sri Lanka and Bahrain. UltraTech is a founding member of the Global Cement &amp; Concrete Association.</p>
								</div>
							</div>
						</div>

						<div class="col-md-12 d-flex">
							<div class="card profile-box flex-fill">
								<div class="card-body">
									<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
										<li class="nav-item"><a class="nav-link active" href="#inventory-stock" data-toggle="tab">Inventory stock</a></li>
										<li class="nav-item"><a class="nav-link" href="#expiry-date" data-toggle="tab">Expiry Date</a></li>
										<li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">history</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active show" id="inventory-stock">
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
																    <button class="dropdown-item" type="button">Delete</button>
																  </div>
																</div>
															</td>
														</tr>

													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane" id="expiry-date">
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
																    <button class="dropdown-item" type="button">Delete</button>
																  </div>
																</div>
															</td>
														</tr>

													</tbody>
												</table>
											</div>
										</div>
										<div class="tab-pane" id="history">
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
																    <button class="dropdown-item" type="button">View</button>
																    <button class="dropdown-item" type="button">Edit</button>
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
						</div>
						
					</div>
				<!-- </div>
			</div> -->
		</div>
	</div>
<link rel="stylesheet" href="<?php echo e(asset('/')); ?>css/lightbox.min.css">
<script src="<?php echo e(asset('/')); ?>js/lightbox.min.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/sample_pages/item_view.blade.php ENDPATH**/ ?>
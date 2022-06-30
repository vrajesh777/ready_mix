@extends('layout.master')
@section('main_content')

	<div class="row align-items-center">
		<h4 class="col-md-8 card-title mt-0 mb-2">Inventory Setting</h4>
		<div class="col-md-4 justify-content-end d-flex">
			<a href="javascript:void(0)" class="border-0 btn btn-primary btn-gradient-primary btn-rounde mb-2" data-toggle="modal" data-target="#add_item">Add commodity type</a>
			<!-- <a class="btn btn-primary">Add</a> -->
		</div>
	</div>


	<div class="row all-reports m-0">
        <div class="col-md-3 p-0">
            <ul class="nav nav-tabs card p-0 mb-0" id="reports" role="tablist">
                <li class="nav-item w-100">
                  <a href="" class="nav-link border-bottom text-body active"><i class="fal fa-database mr-2"></i>Commodity Type</a>
                </li>
                <li class="nav-item w-100">
                  <a href="" class="nav-link border-bottom text-body"><i class="fal fa-users mr-2"></i>Commodity Group</a>
                </li>
                <li class="nav-item w-100">
                  <a  href=""class="nav-link border-bottom text-body"><i class="fal fa-draw-square mr-2"></i>Units</a>
                </li>
                <li class="nav-item w-100">
                  <a href="" class="nav-link border-bottom text-body"><i class="fal fa-warehouse mr-2"></i>Warehouse</a>
                </li>
                <li class="nav-item w-100">
                  <a href="" class="nav-link border-bottom text-body"><i class="fal fa-compress-wide mr-2"></i>Minimum inventory</a>
                </li>

            </ul>
        </div>
        <div class="col-md-9 pr-0 Reports">
                <div class="card">
                <div class="card-body">
					<div class="table-responsive">
						<table class="table table-stripped mb-0 datatables">
							<thead>
								<tr>
									<th>ID</th>
									<th>Commodity type code</th>
									<th>Commodity type name</th>
									<th>Order</th>
									<th>Display</th>
									<th>Note</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>01</td>
									<td>DE#95237</td>
									<td>Aditya Birla</td>
									<td>500</td>
									<td>Display</td>
									<td>Studio 103. The Business Centre</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
										    <button class="dropdown-item" type="button" data-toggle="modal" data-target="#add_item">Edit</button>
										    <button class="dropdown-item" type="button">Delete</button>
										  </div>
										</div>
									</td>
								</tr>
								<tr>
									<td>01</td>
									<td>DE#95237</td>
									<td>Aditya Birla</td>
									<td>500</td>
									<td>Display</td>
									<td>Studio 103. The Business Centre</td>
									<td class="text-center">
										<div class="btn-group">
										 <a href="javascript:void(0)" data-toggle="dropdown" class="action">
										   <i class="fas fa-ellipsis-v"></i>
										  </a>
										  <div class="dropdown-menu dropdown-menu-right">
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


		<script type="text/javascript">
			$(document).ready(function() {
    		$('.datatables').DataTable({searching: true, paging: true, info: true});
			});
		</script>

@endsection
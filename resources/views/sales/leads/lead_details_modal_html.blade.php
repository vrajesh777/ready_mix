<div class="modal-header">
	<button type="button" class="close xs-close" data-dismiss="modal">×</button>
	<div class="row w-100">
		<div class="col-md-7 account d-flex">
			<div class="company_img">
				<img src="{{ asset('images/system-user.png') }}" alt="User" class="user-image" class="img-fluid" />
			</div>
			<div>
				<p class="mb-0">{{ trans('admin.lead') }} {{ trans('admin.user') }}</p>
				<span class="modal-title">{{ $arr_lead['name'] ?? '' }}</span>
			</div>

		</div>

		<div class="col-md-4 text-right">
			<div class="dropdown dropdown-action">
				<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ trans('admin.actions') }} <i class="fa fa-angle-down"></i></a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item action-convert-cust cnvrt-to-cust-btn" data-enc-id="{{ base64_encode($arr_lead['id']) }}" href="javascript:void(0);">{{ trans('admin.convert') }} {{ trans('admin.to') }} {{ trans('admin.customer') }}</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card due-dates">
	<div class="card-body">
		<div class="row">
			<div class="col">
				<span>{{ trans('admin.lead') }} {{ trans('admin.status') }}</span>
				<p>{{ strtoupper($arr_lead['status']) }}</p>
			</div>
			<div class="col">
				<span>{{ trans('admin.name') }}</span>
				<p>{{ $arr_lead['name'] ?? 'N/A' }}</p>
			</div>
			<div class="col">
				<span>{{ trans('admin.lead') }} {{ trans('admin.source') }}</span>
				<p>{{ strtoupper($arr_lead['source']) }}</p>
			</div>
			<div class="col">
				<span>{{ trans('admin.lead') }} {{ trans('admin.owner') }}</span>
				<p>{{ $arr_lead['assigned_to']['name'] ?? 'N/A' }}</p>
			</div>
		</div>
	</div>
</div>

<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<ul class="cd-breadcrumb triangle nav nav-tabs w-100 crms-steps" role="tablist">
				<li role="presentation">
					<a href="#not-contacted" class="active" aria-controls="not-contacted" role="tab" data-toggle="tab" aria-expanded="true">
						<span class="octicon octicon-light-bulb"></span>{{ trans('admin.not_contacted') }}
					</a>
				</li>
				<li role="presentation" class="">
					<a href="#attempted-contact" aria-controls="attempted-contact" role="tab" data-toggle="tab" aria-expanded="false">
						<span class="octicon octicon-diff-added"></span>{{ trans('admin.attempted') }}
					</a>
				</li>
				<li role="presentation" class="">
					<a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" aria-expanded="false">
						<span class="octicon octicon-comment-discussion"></span>{{ trans('admin.contact') }}
					</a>
				</li>
				<li role="presentation" class="">
					<a href="#converted" aria-controls="contact" role="tab" data-toggle="tab" aria-expanded="false">
						<span class="octicon octicon-comment-discussion"></span>{{ trans('admin.converted') }}
					</a>
				</li>
				<li role="presentation" class="d-none">
					<a href="#converted" aria-controls="converted" role="tab" data-toggle="tab" aria-expanded="false">
						<span class="octicon octicon-verified"></span>{{ trans('admin.converted') }}
					</a>
				</li>

			</ul>
		</div>
	</div>

	<div class="tab-content pipeline-tabs border-0">
		<div role="tabpanel" class="tab-pane active p-0" id="not-contacted">
			<div class="">
				<div class="task-infos">
					<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
						<li class="nav-item"><a class="nav-link active" href="#not-contact-task-details" data-toggle="tab">{{ trans('admin.details') }}</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane show active p-0" id="not-contact-task-details">
							<div class="crms-tasks">
								<div class="tasks__item crms-task-item active">
									<div class="accordion-header js-accordion-header">{{ trans('admin.lead') }} {{ trans('admin.information') }}</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>{{ trans('admin.name') }}</td>
														<td>{{ $arr_lead['name'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.organization') }}</td>
														<td>{{ $arr_lead['company'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.lead') }} {{ trans('admin.status') }}</td>
														<td>{{ strtoupper($arr_lead['status']) }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.link_email_address') }} </td>
														<td>{{ $arr_lead['email'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.lead_owner') }}</td>
														<td>{{ $arr_lead['assigned_to']['name'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.lead_created_at') }}</td>
														<td>{{ date('d-M-y h:i A', strtotime($arr_lead['created_at'])) }}03-Jun-20 1:14 AM</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">{{ trans('admin.additional') }}  {{ trans('admin.information') }}</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>{{ trans('admin.email_id') }}</td>
														<td>{{ $arr_lead['email'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.email_id') }} {{ trans('admin.opted_on') }}</td>
														<td>Lorem</td>
													</tr>
													<tr>
														<td>{{ trans('admin.mobile_no') }}</td>
														<td>{{ $arr_lead['phone'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.website') }}</td>
														<td>{{ $arr_lead['website'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.lead_source') }}</td>
														<td>{{ strtoupper($arr_lead['source']) ?? 'N/A' }}</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">{{ trans('admin.address') }} {{ trans('admin.information') }}</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td> {{ trans('admin.address') }}</td>
														<td>{{ $arr_lead['address'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td>{{ trans('admin.zip_code') }}</td>
														<td>{{ $arr_lead['zip_code'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td> {{ trans('admin.city') }}</td>
														<td>{{ $arr_lead['city'] ?? 'N/A' }}</td>
													</tr>
													<tr>
														<td> {{ trans('admin.state') }}</td>
														<td>{{ $arr_lead['state'] ?? 'N/A' }}</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">{{ trans('admin.description') }} {{ trans('admin.information') }}</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>{{ trans('admin.description') }}</td>
														<td>{!! $arr_lead['description'] ?? 'N/A' !!}</td>
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
			</div>
		</div>
		<div role="tabpanel" class="tab-pane p-0" id="attempted-contact">
			<div>
				<div class="task-infos">
					<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
						<li class="nav-item"><a class="nav-link active" href="#attempted-task-details" data-toggle="tab">Details</a></li>
						<li class="nav-item"><a class="nav-link" href="#attempted-task-related" data-toggle="tab">Related</a></li>
						<li class="nav-item"><a class="nav-link" href="#attempted-task-activity" data-toggle="tab">Activity</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane show active p-0" id="attempted-task-details">
							<div class="crms-tasks">
								<div class="tasks__item crms-task-item active">
									<div class="accordion-header js-accordion-header">Lead Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Record ID</td>
														<td>124192692</td>
													</tr>
													<tr>
														<td>Name</td>
														<td>Anny Lench</td>
													</tr>
													<tr>
														<td>Title</td>
														<td>VP of Sales</td>
													</tr>
													<tr>
														<td>Organization</td>
														<td>Howe-Blanda LLC</td>
													</tr>
													<tr>
														<td>Lead Status</td>
														<td>OPEN - NotContacted</td>
													</tr>
													<tr>
														<td>User Responsible</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Link Email Address</td>
														<td>abc@gmail.com</td>
													</tr>
													<tr>
														<td>Lead Owner</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Lead Created</td>
														<td>03-Jun-20 1:14 AM</td>
													</tr>
													<tr>
														<td>Date of Last Activity</td>
														<td>09/03/2000</td>
													</tr>
													<tr>
														<td>Date of Next Activity</td>
														<td>10/03/2000</td>
													</tr>
													<tr>
														<td>Lead Rating</td>
														<td>0</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Additional Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Email Address</td>
														<td>abc@gmail.com</td>
													</tr>
													<tr>
														<td>Email Opted Out</td>
														<td>Lorem</td>
													</tr>
													<tr>
														<td>Phone</td>
														<td>(406) 653-3860</td>
													</tr>
													<tr>
														<td>Mobile Phone</td>
														<td>9867656756</td>
													</tr>
													<tr>
														<td>Fax</td>
														<td>1234</td>
													</tr>
													<tr>
														<td>Website</td>
														<td>Lorem ipsum</td>
													</tr>
													<tr>
														<td>Industry</td>
														<td>lorem ipsum</td>
													</tr>
													<tr>
														<td>Number of Employees</td>
														<td>2</td>
													</tr>
													<tr>
														<td>Lead Source</td>
														<td>Phone Enquiry</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Address Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td> Address</td>
														<td>1000 Escalon Street, Palo Alto, CA, 94020, United States map</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Description Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Description</td>
														<td>Interested in model: Whirlygig T950 </td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>

								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Tag Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td class="border-0">Tag List</td>
														<td class="border-0">Lorem Ipsum</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Lead Conversion Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Converted Contact</td>
														<td>John Smith</td>
													</tr>
													<tr>
														<td>Converted Organization</td>
														<td>Claimpett Corp</td>
													</tr>
													<tr>
														<td>Converted Opportunity</td>
														<td>Lorem ipsum</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane task-related p-0" id="attempted-task-related">
							<div class="row">

								<div class="col-md-4">
									<div class="card bg-gradient-danger card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Notes</h4>
											<span>2</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card bg-gradient-info card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Files</h4>
											<span>2</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="crms-tasks  p-2">
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Notes </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Name</th>
																<th>Size</th>
																<th>Category</th>
																<th>Date Added</th>
																<th>Added by</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Document
																</td>
																<td>50KB</td>
																<td>Phone Call</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>John Doe</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Finance
																</td>
																<td>100KB</td>
																<td>Email</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>Smith</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

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
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Files </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Name</th>
																<th>Size</th>
																<th>Category</th>
																<th>Date Added</th>
																<th>Added by</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Document
																</td>
																<td>50KB</td>
																<td>Enquiry</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>John Doe</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Finance
																</td>
																<td>100KB</td>
																<td>Email</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>Smith</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

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
						<div class="tab-pane p-0" id="attempted-task-activity">
							<div class="row">
								<div class="col-md-4">
									<div class="card bg-gradient-danger card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Total Activities</h4>
											<span>2</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card bg-gradient-success card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Last Activity</h4>
											<span>1</span>
										</div>
									</div>
								</div>

							</div>

							<div class="row">
								<div class="crms-tasks  p-2">
									<div class="tasks__item crms-task-item active">
										<div class="accordion-header js-accordion-header">Upcoming Activity </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Activity Name</th>
																<th>Assigned To</th>
																<th>Due Date</th>
																<th>Status</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Call Enquiry</td>
																<td>John Doe</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Phone Enquiry</td>
																<td>David</td>
																<td>13-Jul-20 11:37 PM</td>

																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

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
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Past Activity </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Activity Name</th>
																<th>Assigned To</th>
																<th>Due Date</th>
																<th>Status</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Call Enquiry</td>
																<td>John Doe</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

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
					</div>

				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane p-0" id="contact">
			<div>
				<div class="task-infos">
					<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
						<li class="nav-item"><a class="nav-link active" href="#contact-task-details" data-toggle="tab">Details</a></li>
						<li class="nav-item"><a class="nav-link" href="#contact-task-related" data-toggle="tab">Related</a></li>
						<li class="nav-item"><a class="nav-link" href="#contact-task-activity" data-toggle="tab">Activity</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane show active p-0" id="contact-task-details">
							<div class="crms-tasks">
								<div class="tasks__item crms-task-item active">
									<div class="accordion-header js-accordion-header">Lead Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Record ID</td>
														<td>124192692</td>
													</tr>
													<tr>
														<td>Name</td>
														<td>Anny Lench</td>
													</tr>
													<tr>
														<td>Title</td>
														<td>VP of Sales</td>
													</tr>
													<tr>
														<td>Organization</td>
														<td>Howe-Blanda LLC</td>
													</tr>
													<tr>
														<td>Lead Status</td>
														<td>OPEN - NotContacted</td>
													</tr>
													<tr>
														<td>User Responsible</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Link Email Address</td>
														<td>abc@gmail.com</td>
													</tr>
													<tr>
														<td>Lead Owner</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Lead Created</td>
														<td>03-Jun-20 1:14 AM</td>
													</tr>
													<tr>
														<td>Date of Last Activity</td>
														<td>09/02/2000</td>
													</tr>
													<tr>
														<td>Date of Next Activity</td>
														<td>07/02/2010</td>
													</tr>
													<tr>
														<td>Lead Rating</td>
														<td>0</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Additional Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Email Address</td>
														<td>abc@gmail.com</td>
													</tr>
													<tr>
														<td>Email Opted Out</td>
														<td>Lorem</td>
													</tr>
													<tr>
														<td>Phone</td>
														<td>(406) 653-3860</td>
													</tr>
													<tr>
														<td>Mobile Phone</td>
														<td>8987454554</td>
													</tr>
													<tr>
														<td>Fax</td>
														<td>1234</td>
													</tr>
													<tr>
														<td>Website</td>
														<td>google.com</td>
													</tr>
													<tr>
														<td>Industry</td>
														<td>IT</td>
													</tr>
													<tr>
														<td>Number of Employees</td>
														<td>2</td>
													</tr>
													<tr>
														<td>Lead Source</td>
														<td>Phone Enquiry</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Address Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td> Address</td>
														<td>1000 Escalon Street, Palo Alto, CA, 94020, United States map</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Description Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Description</td>
														<td>Interested in model: Whirlygig T950 </td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>

								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Tag Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td class="border-0">Tag List</td>
														<td class="border-0">Lorem Ipsum</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Lead Conversion Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Converted Contact</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Converted Organization</td>
														<td>Claimpett corp</td>
													</tr>
													<tr>
														<td>Converted Opportunity</td>
														<td>Lorem ipsum</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane task-related p-0" id="contact-task-related">
							<div class="row">

								<div class="col-md-4">
									<div class="card bg-gradient-danger card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Notes</h4>
											<span>2</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card bg-gradient-info card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Files</h4>
											<span>2</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="crms-tasks  p-2">
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Notes</div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Name</th>
																<th>Size</th>
																<th>Category</th>
																<th>Date Added</th>
																<th>Added by</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Document
																</td>
																<td>50KB</td>
																<td>Phone Call</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>John Doe</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Finance
																</td>
																<td>100KB</td>
																<td>Email</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>Smith</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

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
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Files </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Name</th>
																<th>Size</th>
																<th>Category</th>
																<th>Date Added</th>
																<th>Added by</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Document
																</td>
																<td>50KB</td>
																<td>Enquiry</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>John Doe</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Finance
																</td>
																<td>100KB</td>
																<td>Phone Call</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>Smith</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

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
						<div class="tab-pane p-0" id="contact-task-activity">
							<div class="row">
								<div class="col-md-4">
									<div class="card bg-gradient-danger card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Total Activities</h4>
											<span>2</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card bg-gradient-success card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Last Activity</h4>
											<span>1</span>
										</div>
									</div>
								</div>

							</div>

							<div class="row">
								<div class="crms-tasks  p-2">
									<div class="tasks__item crms-task-item active">
										<div class="accordion-header js-accordion-header">Upcoming Activity </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Activity Name</th>
																<th>Assigned To</th>
																<th>Due Date</th>
																<th>Status</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Call Enquiry</td>
																<td>John Doe</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Phone Enquiry</td>
																<td>David</td>
																<td>13-Jul-20 11:37 PM</td>

																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

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
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Past Activity</div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Activity Name</th>
																<th>Assigned To</th>
																<th>Due Date</th>
																<th>Status</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Call Enquiry</td>
																<td>John Doe</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

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
					</div>

				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane p-0" id="converted">
			<div>
				<div class="task-infos">
					<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
						<li class="nav-item"><a class="nav-link active" href="#converted-task-details" data-toggle="tab">Details</a></li>
						<li class="nav-item"><a class="nav-link" href="#converted-task-related" data-toggle="tab">Related</a></li>
						<li class="nav-item"><a class="nav-link" href="#converted-task-activity" data-toggle="tab">Activity</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane show active p-0" id="converted-task-details">
							<div class="crms-tasks">
								<div class="tasks__item crms-task-item active">
									<div class="accordion-header js-accordion-header">Lead Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Record ID</td>
														<td>124192692</td>
													</tr>
													<tr>
														<td>Name</td>
														<td>Anny Lench</td>
													</tr>
													<tr>
														<td>Title</td>
														<td>VP of Sales</td>
													</tr>
													<tr>
														<td>Organization</td>
														<td>Howe-Blanda LLC</td>
													</tr>
													<tr>
														<td>Lead Status</td>
														<td>OPEN - NotContacted</td>
													</tr>
													<tr>
														<td>User Responsible</td>
														<td>Williams</td>
													</tr>
													<tr>
														<td>Link Email Address</td>
														<td>abc@gmail.com</td>
													</tr>
													<tr>
														<td>Lead Owner</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Lead Created</td>
														<td>03-Jun-20 1:14 AM</td>
													</tr>
													<tr>
														<td>Date of Last Activity</td>
														<td>09/01/2020</td>
													</tr>
													<tr>
														<td>Date of Next Activity</td>
														<td>09/01/2020</td>
													</tr>
													<tr>
														<td>Lead Rating</td>
														<td>0</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Additional Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Email Address</td>
														<td>abc@gmail.com</td>
													</tr>
													<tr>
														<td>Email Opted Out</td>
														<td>-</td>
													</tr>
													<tr>
														<td>Phone</td>
														<td>(406) 653-3860</td>
													</tr>
													<tr>
														<td>Mobile Phone</td>
														<td>9867657655</td>
													</tr>
													<tr>
														<td>Fax</td>
														<td>1234</td>
													</tr>
													<tr>
														<td>Website</td>
														<td>googlee.com</td>
													</tr>
													<tr>
														<td>Industry</td>
														<td>IT</td>
													</tr>
													<tr>
														<td>Number of Employees</td>
														<td>2</td>
													</tr>
													<tr>
														<td>Lead Source</td>
														<td>Phone Enquiry</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Address Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td> Address</td>
														<td>1000 Escalon Street, Palo Alto, CA, 94020, United States map</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Description Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Description</td>
														<td>Interested in model: Whirlygig T950 </td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>

								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Tag Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td class="border-0">Tag List</td>
														<td class="border-0">Lorem Ipsum</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
								<div class="tasks__item crms-task-item">
									<div class="accordion-header js-accordion-header">Lead Conversion Information</div> 
									<div class="accordion-body js-accordion-body">
										<div class="accordion-body__contents">
											<table class="table">
												<tbody>
													<tr>
														<td>Converted Contact</td>
														<td>John Doe</td>
													</tr>
													<tr>
														<td>Converted Organization</td>
														<td>Solemen corp</td>
													</tr>
													<tr>
														<td>Converted Opportunity</td>
														<td>Lorem Ipsum</td>
													</tr>
												</tbody>
											</table>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane task-related p-0" id="converted-task-related">
							<div class="row">

								<div class="col-md-4">
									<div class="card bg-gradient-danger card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Notes</h4>
											<span>2</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card bg-gradient-info card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Files</h4>
											<span>2</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="crms-tasks  p-2">
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Notes </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Name</th>
																<th>Size</th>
																<th>Category</th>
																<th>Date Added</th>
																<th>Added by</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Document
																</td>
																<td>50KB</td>
																<td>Phone call</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>John Doe</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Finance
																</td>
																<td>100KB</td>
																<td>Call Enquiry</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>Smith</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

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
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Files </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Name</th>
																<th>Size</th>
																<th>Category</th>
																<th>Date Added</th>
																<th>Added by</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Document
																</td>
																<td>50KB</td>
																<td>Email</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>John Doe</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Finance
																</td>
																<td>100KB</td>
																<td>Phone Call</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>Smith</td>
																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Edit Link</a>
																			<a class="dropdown-item" href="#">Delete Link</a>

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
						<div class="tab-pane p-0" id="converted-task-activity">
							<div class="row">
								<div class="col-md-4">
									<div class="card bg-gradient-danger card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Total Activities</h4>
											<span>2</span>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="card bg-gradient-success card-img-holder text-white h-100">
										<div class="card-body">
											<img src="images/circle.png" class="card-img-absolute" alt="circle-image">
											<h4 class="font-weight-normal mb-3">Last Activity</h4>
											<span>1</span>
										</div>
									</div>
								</div>

							</div>

							<div class="row">
								<div class="crms-tasks  p-2">
									<div class="tasks__item crms-task-item active">
										<div class="accordion-header js-accordion-header">Upcoming Activity </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Activity Name</th>
																<th>Assigned To</th>
																<th>Due Date</th>
																<th>Status</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Call Enquiry</td>
																<td>John Doe</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

																		</div>
																	</div>
																</td>
															</tr>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Phone Enquiry</td>
																<td>David</td>
																<td>13-Jul-20 11:37 PM</td>

																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

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
									<div class="tasks__item crms-task-item">
										<div class="accordion-header js-accordion-header">Past Activity </div> 
										<div class="accordion-body js-accordion-body">
											<div class="accordion-body__contents">
												<div class="table-responsive">
													<table class="table table-striped table-nowrap custom-table mb-0 datatable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Activity Name</th>
																<th>Assigned To</th>
																<th>Due Date</th>
																<th>Status</th>
																<th class="text-right">Actions</th>
															</tr>
														</thead>
														<tbody>
															<tr>

																<td>
																	Meeting
																</td>
																<td>Call Enquiry</td>
																<td>John Doe</td>
																<td>13-Jul-20 11:37 PM</td>
																<td>
																	<label class="container-checkbox">
																		<input type="checkbox" checked>
																		<span class="checkmark"></span>
																	</label>
																</td>

																<td class="text-center">
																	<div class="dropdown dropdown-action">
																		<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
																		<div class="dropdown-menu dropdown-menu-right">
																			<a class="dropdown-item" href="#">Add New Task</a>
																			<a class="dropdown-item" href="#">Add New Event</a>

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
					</div>

				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">

	accordion_declare();

	accordion.init({
        speed: 300,
        oneOpen: true
    });

</script>
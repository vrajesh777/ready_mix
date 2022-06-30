<div class="col-md-9 pr-0">
	<div class="card">
		<div class="card-body">
			<h4 class="pb-1">Profile</h4>

			<ul class="cd-breadcrumb triangle nav nav-tabs profile-tabs ">
				<li><a data-toggle="tab" href="#cust-details">{{  trans('admin.customer') }} {{  trans('admin.details') }} </a></li>
				<li><a data-toggle="tab" href="#bill-shipp">{{  trans('admin.billing_&_shipping') }}</a></li>
				<li><a data-toggle="tab" href="#purchase-orders">{{  trans('admin.purchase_orders') }}</a></li>
			</ul>

			<div class="tab-content">
				<div id="cust-details" class="tab-pane fade">
					<form method="post" action="{{ Route('update_customer',$enc_id) }}" id="frmAddCustomer">

		            	{{ csrf_field() }}

						<div class="form-group row">
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.first_name') }} <span class="text-danger">*</span></label>
		    					<input type="text" name="u_first_name" id="u_first_name" class="form-control" placeholder="{{  trans('admin.first_name') }}" data-rule-required="true" value="{{ $arr_cust['first_name']??'' }}">
		    					<label class="error" id="u_first_name_error"></label>
							</div>
							<div class="col-sm-6">
								<label class="col-form-label">{{ trans('admin.last_name') }} <span class="text-danger">*</span></label>
		    					<input type="text" name="u_last_name" id="u_last_name" class="form-control" placeholder="{{ trans('admin.last_name') }}" data-rule-required="true" value="{{ $arr_cust['last_name']??'' }}">
		    					<label class="error" id="u_last_name_error"></label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.email') }} <span class="text-danger">*</span></label>
		    					<input type="text" class="form-control" name="u_email" id="u_email" placeholder="{{  trans('admin.email') }}" data-rule-required="true" data-rule-email="true" value="{{ $arr_cust['email']??'' }}" >
		    					<label class="error" id="u_email_error"></label>
							</div>
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.phone') }}</label>
		    					<input type="text" class="form-control" name="u_phone" id="u_phone" placeholder="{{  trans('admin.phone') }}" value="{{ $arr_cust['mobile_no']??'' }}">
		    					<label class="error" id="u_phone_error"></label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.address') }}</label>
		    					<input type="text" name="u_address" id="u_address" class="form-control" placeholder="{{  trans('admin.address') }}" value="{{ $arr_cust['address']??'' }}">
		    					<label class="error" id="u_address_error"></label>
							</div>
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.city') }}</label>
		    					<input type="text" name="u_city" id="u_city" class="form-control" placeholder="{{  trans('admin.city') }}" value="{{ $arr_cust['city']??'' }}">
		    					<label class="error" id="u_city_error"></label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.state') }}</label>
		    					<input type="text" name="u_state" id="u_state" class="form-control" placeholder="{{  trans('admin.state') }}" value="{{ $arr_cust['state']??'' }}">
		    					<label class="error" id="u_state_error"></label>
							</div>
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.zip_code') }}</label>
		    					<input type="text" name="u_zip_code" id="u_zip_code" class="form-control" placeholder="{{  trans('admin.zip_code') }}" value="{{ $arr_cust['postal_code']??'' }}">
		    					<label class="error" id="u_zip_code_error"></label>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.website') }}</label>
		    					<input type="url" name="u_website" id="u_website" class="form-control" placeholder="{{  trans('admin.website') }}" value="{{ $arr_cust['website']??'' }}">
		    					<label class="error" id="u_website_error"></label>
							</div>

							<div class="col-sm-6">
								<label class="col-form-label">{{  trans('admin.company') }} <span class="text-danger">*</span></label>
		    					<input type="text" name="u_company" id="u_company" class="form-control" placeholder="{{  trans('admin.company') }}" data-rule-required="true" value="{{ $arr_cust['company']??'' }}">
		    					<label class="error" id="u_company_error"></label>
							</div>
						</div>

						<div class="form-group row cust-pass-wrapp">
							<div class="col-sm-12">
								<label class="col-form-label">{{ trans('admin.password') }} </label>

		    					<div class="input-group">
									<input type="password" name="u_password" id="u_password" class="form-control password" placeholder="{{ trans('admin.password') }}">
									<div class="input-group-append">
										<span class="input-group-text toggle_pass"><i class="fa fa-eye" aria-hidden="true"></i></span>
									</div>
									<div class="input-group-append">
										<span class="input-group-text generate_pass"><i class="fa fa-retweet" aria-hidden="true"></i></span>
									</div>
								</div>
								<label id="u_password-error" class="error" for="u_password"></label>
		    					<label class="error" id="u_password_error"></label>
							</div>
						</div>

						<div class="form-group row">

							<div class="col-sm-12">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="u_send_set_pass_mail" id="u_send_set_pass_mail" value="" >{{  trans('admin.send_set_password_email') }} 
									</label>
									<label class="error" id="u_send_set_pass_mail_error"></label>
								</div>
							</div>

						</div>

		                <div class="text-center py-3">
		                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{  trans('admin.save') }}</button>
		                </div>

		            </form>
				</div>
				<div id="bill-shipp" class="tab-pane fade">
					<form method="POST" action="{{ Route('update_address', $enc_id) }}" class="row" id="billShippAddrForm">
						{{ csrf_field() }}
						<div class="col-sm-6">
							<h4 class="pb-1">{{  trans('admin.billing_address') }}</h4>
							<hr>
							<div id="billing_details">
	                            <div class="form-group" app-field-wrapper="billing_street">
	                            	<label for="billing_street" class="control-label">{{  trans('admin.street') }}</label>
	                            	<textarea id="billing_street" name="billing_street" class="form-control" rows="4">{{ $arr_cust['billing_street']??'' }}</textarea>
	                            </div>
	                            <div class="form-group" app-field-wrapper="billing_city">
	                            	<label for="billing_city" class="control-label">{{  trans('admin.city') }}</label>
	                            	<input type="text" id="billing_city" name="billing_city" class="form-control" value="{{ $arr_cust['billing_city']??'' }}">
	                            </div>
	                            <div class="form-group" app-field-wrapper="billing_state">
	                            	<label for="billing_state" class="control-label">{{  trans('admin.state') }}</label>
	                            	<input type="text" id="billing_state" name="billing_state" class="form-control" value="{{ $arr_cust['billing_state']??'' }}">
	                            </div>
	                            <div class="form-group" app-field-wrapper="billing_zip">
	                            	<label for="billing_zip" class="control-label">{{  trans('admin.zip_code') }}</label>
	                            	<input type="text" id="billing_zip" name="billing_zip" class="form-control" value="{{ $arr_cust['billing_zip']??'' }}">
	                            </div>
	                        </div>
						</div>
						<div class="col-sm-6">

							<h4 class="pb-1">{{  trans('admin.shipping_address') }}
								<small style="float: right;"><a href="javascript:void(0)" class="copy-bill_addr">Copy Billing Address</a></small>
							</h4>
							<hr>

							<div id="shipping_details">
	                            <div class="form-group" app-field-wrapper="shipping_street">
	                            	<label for="shipping_street" class="control-label">{{  trans('admin.street') }}</label>
	                            	<textarea id="shipping_street" name="shipping_street" class="form-control" rows="4">{{ $arr_cust['shipping_street']??'' }}</textarea>
	                            </div>
	                            <div class="form-group" app-field-wrapper="shipping_city">
	                            	<label for="shipping_city" class="control-label">{{  trans('admin.city') }}</label>
	                            	<input type="text" id="shipping_city" name="shipping_city" class="form-control" value="{{ $arr_cust['shipping_city']??'' }}">
	                            </div>
	                            <div class="form-group" app-field-wrapper="shipping_state">
	                            	<label for="shipping_state" class="control-label">{{  trans('admin.state') }}</label>
	                            	<input type="text" id="shipping_state" name="shipping_state" class="form-control" value="{{ $arr_cust['shipping_state']??'' }}">
	                            </div>
	                            <div class="form-group" app-field-wrapper="shipping_zip">
	                            	<label for="shipping_zip" class="control-label">{{  trans('admin.zip_code') }}</label>
	                            	<input type="text" id="shipping_zip" name="shipping_zip" class="form-control" value="{{ $arr_cust['shipping_zip']??'' }}">
	                            </div>
	                        </div>
						</div>
						<div class="col-sm-12">
							<div class="text-center py-3">
			                	<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">{{  trans('admin.save') }}</button>
			                </div>
		            	</div>
					</form>
				</div>
				<div id="purchase-orders" class="tab-pane fade">
					<div class="mb-0">
						<div class="">
							<div class="table-responsive">
								<table class="table table-striped table-nowrap custom-table mb-0" id="leadsTable">
									<thead>
										<tr>
											<th>{{  trans('admin.order') }} #</th>
											<th>{{  trans('admin.amount') }}</th>
											<th>{{  trans('admin.total_tax') }}</th>
											<th>{{  trans('admin.delivery') }} {{  trans('admin.date') }}</th>
											<th>{{  trans('admin.status') }}</th>
											<th class="text-right notexport">{{  trans('admin.actions') }}</th>
										</tr>
									</thead>
									<tbody>

										@if(isset($arr_orders) && !empty($arr_orders))

										@foreach($arr_orders as $order)

										<?php
											$enc_id = base64_encode($order['id']);
											$tax_amnt = 0;

											$invoice = $order['invoice'] ?? [];

											foreach($order['ord_details'] as $row) {
												$tot_price = $row['quantity']*$row['rate'];
												$tax_rate = $row['tax_rate'];
												$tax_amnt += ( $tax_rate / 100 ) * $tot_price;
											}
										?>

										<tr>
											<td>
												<a href="{{ Route('view_invoice', $enc_id) }}" target="_blank">{{ format_order_number($order['id']) ?? 'N/A' }}</a>
											</td>
											<td>{{ number_format($invoice['net_total'],2) ?? 'N/A' }}</td>
											<td>{{ number_format($tax_amnt,2) ?? 'N/A' }}</td>
											<td>{{ $order['delivery_date'] ?? 'N/A' }}</td>
											<td>{{ ucfirst($order['order_status']) ?? 'N/A' }}</td>
				                            <td class="text-center">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item action-edit" href="{{ Route('edit_order', $enc_id) }}">Edit</a>
														<a class="dropdown-item action-edit" href="{{ Route('view_order', $enc_id) }}">View</a>
													</div>
												</div>
											</td>
										</tr>

										@endforeach

										@else

										<h3 align="center">No Records Found!</h3>

										@endif
										
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

<script type="text/javascript">

	$(document).ready(function() {

		$('#frmAddCustomer').validate({
			ignore: [],
			errorPlacement: function (error, element) {
			    if(element.hasClass('select2') && element.next('.select2-container').length) {
			        error.insertAfter(element.next('.select2-container'));
			    }else if (element.parent('.input-group').length) {
		            error.insertAfter(element.parent());
		        }
		        else {
		            error.insertAfter(element);
		        }
			}
		});

		$("#frmAddCustomer").submit(function(e) {

			e.preventDefault();

			if($(this).valid()) {

				actionUrl = $(this).attr('action');

				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
      				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

		$('.toggle_pass').click(function(){
			$('.password').attr('type', function(index, attr){
			    return attr == 'password' ? 'text' : 'password';
			});
		});

		$('.generate_pass').click(function() {

			// Password Generator Ref Link : https://jsfiddle.net/RaviMakwana/tq6xwea2/

			// find elements
			var pwd = $("#pwd")
			var button = $("button")
			var len = $('#Length')
			var A_Z = $('#A-Z')
			var a_z = $('#a-z')
			var num = $('#0-1')
			var sc = $('#SpecialChars')

			// CreateRandomPassword( len.val() ,A_Z.is(":checked"),a_z.is(":checked"),num.is(":checked"),sc.val());
			var randPass = CreateRandomPassword( 8 , true, true, true, '@#$%');

			$('input[name=u_password]').val(randPass);

		});

		$(".copy-bill_addr").click(function(){
			$('textarea[name="shipping_street"]').val($('textarea[name="billing_street"]').val());
			$('input[name="shipping_city"]').val($('input[name="billing_city"]').val());
			$('input[name="shipping_state"]').val($('input[name="billing_state"]').val());
			$('input[name="shipping_zip"]').val($('input[name="billing_zip"]').val());
		});

		$("#billShippAddrForm").submit(function(e) {
			e.preventDefault();
			if($(this).valid()) {
				actionUrl = $(this).attr('action');
				$.ajax({
					url: actionUrl,
      				type:'POST',
      				data : $(this).serialize(),
      				dataType:'json',
      				beforeSend: function() {
				        showProcessingOverlay();
				    },
      				success:function(response)
      				{
      					hideProcessingOverlay();
      					common_ajax_store_action(response);
      				},
      				error:function(){
	  					hideProcessingOverlay();
	  				}
				});
			}
		});

	});
	
</script>
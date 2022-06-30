<!-- Address modal -->
<div class="modal fade" id="billing_and_shipping_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="billing_details">
                            <div class="form-group" app-field-wrapper="billing_street">
                            	<label for="billing_street" class="control-label">Street</label>
                            	<textarea id="billing_street" name="billing_street" class="form-control" rows="4">{{ $arr_invoice['billing_street']??'' }}</textarea>
                            </div>
                            <div class="form-group" app-field-wrapper="billing_city">
                            	<label for="billing_city" class="control-label">City</label>
                            	<input type="text" id="billing_city" name="billing_city" class="form-control" value="{{ $arr_invoice['billing_city']??'' }}">
                            </div>
                            <div class="form-group" app-field-wrapper="billing_state">
                            	<label for="billing_state" class="control-label">State</label>
                            	<input type="text" id="billing_state" name="billing_state" class="form-control" value="{{ $arr_invoice['billing_state']??'' }}">
                            </div>
                            <div class="form-group" app-field-wrapper="billing_zip">
                            	<label for="billing_zip" class="control-label">Zip Code</label>
                            	<input type="text" id="billing_zip" name="billing_zip" class="form-control" value="{{ $arr_invoice['billing_zip']??'' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="clearfix"></div>
                        <div class="form-group no-mbot">
                            <div class="checkbox checkbox-primary checkbox-inline">
                                <input type="checkbox" id="include_shipping" name="include_shipping" value="1" {{ $arr_invoice['include_shipping']=='1'?'checked':'' }}>
                                <label for="include_shipping">Shipping Address</label>
                            </div>
                        </div>
                        <div id="shipping_details" style="display: {{ $arr_invoice['include_shipping'] == '1'?'block':'none' }};">
                            <div class="form-group">
                                <div class="checkbox checkbox-primary checkbox-inline">
                                    <input type="checkbox" id="show_shipping_on_estimate" name="show_shipping_on_estimate" checked="">
                                    <label for="show_shipping_on_estimate">Show shipping details in estimate</label>
                                </div>
                            </div>
                            <div class="form-group" app-field-wrapper="shipping_street">
                            	<label for="shipping_street" class="control-label">Street</label>
                            	<textarea id="shipping_street" name="shipping_street" class="form-control" rows="4">{{ $arr_invoice['shipping_street']??'' }}</textarea>
                            </div>
                            <div class="form-group" app-field-wrapper="shipping_city">
                            	<label for="shipping_city" class="control-label">City</label>
                            	<input type="text" id="shipping_city" name="shipping_city" class="form-control" value="{{ $arr_invoice['shipping_city']??'' }}">
                            </div>
                            <div class="form-group" app-field-wrapper="shipping_state">
                            	<label for="shipping_state" class="control-label">State</label>
                            	<input type="text" id="shipping_state" name="shipping_state" class="form-control" value="{{ $arr_invoice['shipping_state']??'' }}">
                            </div>
                            <div class="form-group" app-field-wrapper="shipping_zip">
                            	<label for="shipping_zip" class="control-label">Zip Code</label>
                            	<input type="text" id="shipping_zip" name="shipping_zip" class="form-control" value="{{ $arr_invoice['shipping_zip']??'' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-not-full-width">
                <a href="javascript:void(0);" id="apply_address" class="btn btn-info save-shipping-billing waves-effect waves-effect waves-light waves-ripple">Apply</a>
            </div>
        </div>
    </div>
</div>
<!-- Address modal -->
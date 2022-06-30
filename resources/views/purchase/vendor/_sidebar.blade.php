@php
	$module_segment       = Request::segment(2);
    $current_page_segment = Request::segment(3);
@endphp
<div class="col-md-3 p-0">
	<ul class="nav nav-tabs card p-0 mb-0" id="reports" role="tablist">
		<li class="nav-item w-100">
			<a  href="{{ Route('contact_view',$enc_id) }}" class="nav-link border-bottom text-body @if($module_segment == 'contact') active @endif"><i class="fal fa-address-card mr-2"></i>Contacts</a>
		</li>
		<li class="nav-item w-100">
			<a href="{{ Route('vend_contract',$enc_id) }}" class="nav-link border-bottom text-body @if($module_segment == 'contract') active @endif"><i class="fal fa-handshake mr-2"></i>Contract</a>
		</li>
		<li class="nav-item w-100">
			<a href="{{ Route('purchase_orders',$enc_id) }}" class="nav-link border-bottom text-body @if($module_segment == 'purchase_orders') active @endif"><i class="fal fa-shopping-cart mr-2"></i>Purchase order</a>
		</li>
		<li class="nav-item w-100">
			<a href="{{ Route('vendor_payment',$enc_id) }}" class="nav-link border-bottom text-body @if($module_segment == 'vendor_payment') active @endif"><i class="fal fa-credit-card mr-2"></i>Payments</a>
		</li>
		<li class="nav-item w-100">
			<a href="{{ Route('note_view',$enc_id) }}" class="nav-link border-bottom text-body @if($module_segment == 'note') active @endif"><i class="fal fa-clipboard mr-2"></i>Notes</a>
		</li>
		<li class="nav-item w-100">
			<a href="{{ Route('attachment_view',$enc_id) }}" class="nav-link border-bottom text-body @if($module_segment == 'attachment') active @endif"><i class="fal fa-paperclip mr-2"></i>Attachments</a>
		</li>
	</ul>
</div>
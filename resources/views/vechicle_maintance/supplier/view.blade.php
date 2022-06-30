@extends('layout.master')
@section('main_content')

<div class="row align-items-center">
	<h4 class="col-md-8 card-title mt-0 mb-2">#{{ $arr_cust['id']??'' }} {{ $arr_cust['first_name']??'' }} {{ $arr_cust['last_name']??'' }}</h4>
</div>

@php
	$module_segment       = Request::get('page', 'payments');
@endphp

<div class="row all-reports m-0">

	@include('vechicle_maintance.supplier._sidebar')


	@include("vechicle_maintance.supplier.$module_segment")

</div>


<script type="text/javascript">
	$(document).ready(function() {
		$('.datatables').DataTable({searching: true, paging: true, info: true});

		$(".profile-tabs > li:first-child a").trigger('click');
	});
</script>

@endsection
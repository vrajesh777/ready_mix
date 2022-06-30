@extends('layout.master')
@section('main_content')

<body>
<div class="row no-print">
<div class="col-md-12">
<div class="card mb-0">
<div class="card-body">

<div class="page-header pt-3 mb-0 ">
	<div class="row">
    <div class="col-md-12">
       @include('layout._operation_status')
    </div>
		<!-- <div class="col"> -->
      <input type="hidden" name="report_type" id="report_type" value="{{ $type??'' }}">
			<div class="col-sm-4 delivery-list">
			<select class="form-control" onchange="displayReport(this.value)" id="delivery_type" name="delivery_type">
          <option value="">Select Type</option>
          <option value="cube">Cube</option>
          <option value="cylinder">Cylinder</option>
      </select>
			</div>
       
		<!-- </div> -->
	</div>
</div>

</div>
</div>
</div>

</body>
<script type="text/javascript">
  function displayReport(delivery_type)
  {
    var url = "{{ url('/') }}";
    var report_type = $('#report_type').val();
    if(delivery_type=='cube')
    {
      module_url_path = url+'/cube/'+report_type;
    }
    else
    {
        module_url_path = url+'/cylinder/'+report_type;
    }
    window.location.href = module_url_path;
  }
</script>
@endsection
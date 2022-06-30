@extends('layout.master')
@section('main_content')
<style type="text/css">
 /*CSS to print receipts*/
    .print_section{
        display: none;
    }
    @media print{
        .print_section{
            display: block !important;
        }
    }
    
</style>
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

			<div class="col-sm-4 delivery-list">
			
				<input type="text" name="delivery_no" onkeyup="getDeliveryNoSuggestion(this.value)" id="delivery_no" class="form-control" placeholder="Delivery No" value="{{ old('delivery_no') }}" data-rule-required="true">
				<div id="deliveryNoList">
    			</div>
				<label class="error" id="delivery_no_error"></label>
        <input type="hidden" name="delivery_id" id="delivery_id">

			</div>
        <div class="col-sm-8 text-right">
         <button type="button" style="display: none" id="cube_print_btn" onclick="printInvoice()" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Print</button>
			 </div>
		<!-- </div> -->
	</div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;text-align:center;">
	<tr><td style="line-height:20px"><img src="logo.png" alt="" width="250"> </td></tr>
	<tr><td style="line-height:20px;">&nbsp;</td></tr>
	<tr><td style="line-height:35px;"><h2 style="text-align:center;margin:0">{{ trans('admin.report_cube_title') }}</h2></td></tr>
	<tr><td style="line-height:20px;">&nbsp;</td></tr>
</table>

<div id="delivery_report_html"></div>

</div>
</div>
</div>
</div>

</body>
<section class="invoice print_section" id="receipt_section">
</section>

<script type="text/javascript">
  
  $(document).ready(function(){
    var exist_delivery_id = "{{ old('delivery_id') }}";
    if(exist_delivery_id!="")
    {
      getDeliveryDetails(exist_delivery_id)
    } 
  })
	function getDeliveryNoSuggestion(term)
    {
      var apiUrl  = "{{ $module_url_path }}/get_delivery_no_suggestion";
    	 var _token = $('input[name="_token"]').val();

         $.ajax({
          url:apiUrl,
          method:"GET",
          data:{term:term},
          success:function(data){
           $('#deliveryNoList').fadeIn();  
           $('#deliveryNoList').html(data);
          }
         });
    }
    function getDeliveryDetails(delivery_id)
    {
        var apiUrl  = "{{ $module_url_path }}/get_delivery_details";
      
    	 $.ajax({
          url:apiUrl,
          method:"GET",
          data:{delivery_id:delivery_id},
          success:function(data){
           $('#delivery_id').val(delivery_id);
           $('#delivery_no').val(data.delivery_no);
           $('#delivery_report_html').html(data.html);
           $('#deliveryNoList').fadeOut();  
            $('#cube_print_btn').show();
          }
         });
    }
    function printInvoice()
    {
       var delivery_id = $('#delivery_id').val();
       var apiUrl  = "{{ $module_url_path }}/get_delivery_details";
      
       if(delivery_id!="")
       {
          $.ajax({
                    type: "GET",
                    url: apiUrl,
                    data:{delivery_id:delivery_id},
                    success: function(data){
                      if (data.html != '') {

                        $('#receipt_section').html(data.html);
                         __print_receipt(data.html);
                      }
                    }
            }); 

       }
        
    }
    function __print_receipt(html_content) {
            
        setTimeout(function() {
                window.print();
            }, 1000);
       
    }
</script>
@endsection
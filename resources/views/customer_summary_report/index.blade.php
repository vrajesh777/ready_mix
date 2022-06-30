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
			 <input type="hidden" name="customer_id" id="customer_id">
				<input type="text" name="customer_id" onkeyup="getCustomerSuggestion(this.value)" id="customer_id" class="form-control" placeholder="Enter Customer Id" value="{{ old('customer_id') }}" data-rule-required="true">
				<div id="customerList">
    			</div>

			</div>
        <div class="col-sm-8 text-right">
         <button type="button" style="display: none" id="customer_print_btn" onclick="printInvoice()" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Print</button>
			 </div>
		<!-- </div> -->
	</div>
</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;text-align:center;">
	<tr><td style="line-height:20px"><img src="logo.png" alt="" width="250"> </td></tr>
	<tr><td style="line-height:20px;">&nbsp;</td></tr>
	<tr><td style="line-height:35px;"><h2 style="text-align:center;margin:0">Summary Report <div id="customer_name_id"></div></h2></td></tr>
	<tr><td style="line-height:20px;">&nbsp;</td></tr>
</table>

<div id="customer_delivery_report"></div>

</div>
</div>
</div>
</div>

</body>
<section class="invoice print_section" id="receipt_section">
</section>

<script type="text/javascript">
  
	function getCustomerSuggestion(term)
  {
    	 var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ $module_url_path }}/get_customer_suggestion",
          method:"GET",
          data:{term:term},
          success:function(data){
           $('#customerList').fadeIn();  
           $('#customerList').html(data);
          }
         });
  }
  function getCustomerDetails(customer_id)
  {
  	 $.ajax({

        url:"{{ $module_url_path }}/get_customer_details",
        method:"GET",
        data:{customer_id:customer_id},
        success:function(data){
          $('#customer_id').val(customer_id);
          $('#customer_name_id').html(data.cust_name);
          $('#customer_delivery_report').html(data.html);
          $('#customerList').fadeOut();  
          $('#customer_print_btn').show();
        } 
    });
  }
  function printInvoice()
  {
     var customer_id = $('#customer_id').val();
     if(customer_id!="")
     {
        $.ajax({
                  type: "GET",
                  url: "{{ $module_url_path }}/get_customer_details",
                  data:{customer_id:customer_id},
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
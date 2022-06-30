<!DOCTYPE html>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />

<head>
	<title>Invoice</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
</head>
<style type="text/css">
	body { font-family:DejaVu Sans, sans-serif; }
	@page {
		margin: 0mm;
	}
	.top-ar{font-family:DejaVu Sans, sans-serif;line-height:12px;font-size:8px;font-weight:700}
	.table tr th{background-color:#323a45;color:#fff;line-height:12px;border-right:1px solid #ccc;text-align:center;}
	.ar-text{}
</style>
<body>

<?php

	$grand_tot = $net_tot = $tot_tax = 0;

	$order = $arr_invoice['order']??[];
	$order_details = $order['ord_details']??[];
	$cust_details = $order['cust_details']??[];
	$cust_meta = $cust_details['user_meta']??[];

	$cust_company = search_in_user_meta($cust_meta,'company');
	$cust_name = $cust_details['first_name'];
	$cust_name .= ' '.$cust_details['last_name'];

?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;text-align:center;">
		<tr><td style=""><img src="{{ asset('/') }}images/logo1.png" alt="" width="250"> </td></tr>
		<tr><td style="line-height:10px;border-bottom:3px solid #456f0a;"></td></tr>
		<tr><td style="line-height:10px;">&nbsp;</td></tr>
		<tr><td class="pur-order" style="text-align:center;font-family:DejaVu Sans, sans-serif;">فــــاتــــــورة  <br><strong style="border-bottom:1px solid #456f0a;">INVOICE</strong></td></tr>
		<tr><td style="line-height:20px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:14px; font-family:'Arial', sans-serif;border:none;">
		<tr>
			<td style="line-height:20px;text-align:center;width:21.2%"><strong style="font-family:DejaVu Sans, sans-serif;font-size:8px"> رقم حسـاب العمیـل  <br>ACCOUNT NO.</strong></td>
			<td style="line-height:20px;width:5%">&nbsp;</td>
			<td style="line-height:20px;text-align:center;width:21.2%"><strong style="font-family:DejaVu Sans, sans-serif;font-size:8px">نوع الفاتورة  <br>INVOICE KIND</strong></td>
			<td style="line-height:20px;width:5%">&nbsp;</td>
			<td style="line-height:20px;text-align:center;width:21.2%"><strong style="font-family:DejaVu Sans, sans-serif;font-size:8px">تاريخ الفاتورة <br>INVOICE DATE</strong></td>
			<td style="line-height:20px;width:5%">&nbsp;</td>
			<td style="line-height:20px;text-align:center;width:21.2%"><strong style="font-family:DejaVu Sans, sans-serif;font-size:8px"> رقم الفاتورة <br>INVOICE NO.</strong></td>
		</tr>
		<tr>
			<td style="line-height:30px;text-align:center;border:1px solid #ccc;width:21.2%">{{ $order['cust_id']??'N/A' }}</td>
			<td style="line-height:20px;width:5%">&nbsp;</td>
			<td style="line-height:30px;text-align:center;border:1px solid #ccc;width:21.2%">FINAL</td>
			<td style="line-height:20px;width:5%">&nbsp;</td>
			<td style="line-height:30px;text-align:center;border:1px solid #ccc;width:21.2%">{{ $arr_invoice['invoice_date']??'' }}</td>
			<td style="line-height:20px;width:5%">&nbsp;</td>
			<td style="line-height:30px;text-align:center;border:1px solid #ccc;width:21.2%">{{ $arr_invoice['invoice_number']??'' }}</td>
		</tr>
		<tr><td colspan="7" style="line-height:10px;">&nbsp;</td></tr>
	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px; font-family:'Arial', sans-serif;text-align: center;">

		<tr><td colspan="5" style="line-height:25px;text-align: left;">CUSTOMER NAME : {{ $cust_company??'' }} ( {{$cust_name??''}} )</td></tr>
		<tr>
			<th style="width:30%;"><h5 class="top-ar">التفـــــــاصیـــــل <br>DESCRIPTION</h5></th>
			<th style="width:15%;"><h5 class="top-ar"> اس. استـــــ  <br>DELIVERY</h5></th>
			<th style="width:10%;"><h5 class="top-ar"> الكمیة   <br>QTY.</h5></th>
			<th style="width:15%;"><h5 class="top-ar"> اسعـر الوحـدة   <br>UNIT PRICE</h5></th>
			<th style="width:13%;"><h5 class="top-ar">ضريبة <br>TAX</h5></th>
			<th style="width:17%;"><h5 class="top-ar"> الإجمـــــالــي  <br>AMOUNT</h5></th>
		</tr>

		@if(isset($order_details) && !empty($order_details))
		@foreach($order_details as $row)
		<?php
			$product = $row['product_details']??[];
			$tax_det = $product['tax_detail']??[];
			$unit_price = $row['rate']??0;
			$quantity = $row['quantity']??0;
			$tot_price = ($unit_price*$quantity);
			$net_tot += $tot_price;

			$tax_amnt = round($tax_det['tax_rate'] * ($tot_price / 100),2);
			$tot_tax += $tax_amnt;

			$grand_tot += ($tot_price+$tax_amnt);
		?>
		<tr>
			<td style="line-height:30px;border-left:1px solid #ccc;border-right:1px solid #ccc;">
				{{ $product['name']??'' }}&nbsp;({{ $product['mix_code']??'' }})
			</td>
			<td style="line-height:30px;border-left:1px solid #ccc;border-right:1px solid #ccc;">
				{{ $order['delivery_date']??'N/A' }}</td>
			<td style="line-height:30px;border-left:1px solid #ccc;border-right:1px solid #ccc;">
				{{ $row['quantity']??'N/A' }}
			</td>
			<td style="line-height:30px;border-left:1px solid #ccc;border-right:1px solid #ccc;">
				{{ format_price($row['rate']??0) }}
			</td>
			<td style="line-height:30px;border-left:1px solid #ccc;border-right:1px solid #ccc;">
				{{ $tax_det['tax_rate']??0 }}% ({{ $tax_det['name']??'' }})
			</td>
			<td style="line-height:30px;border-left:1px solid #ccc;border-right:1px solid #ccc;">
				{{ format_price($tot_price) }}
			</td>
		</tr>
		@endforeach
		@endif

		<tr>
			<td colspan="4" style="line-height:30px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:30px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">NET TOTAL</td>
			<td style="line-height:30px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong></strong>{{ format_price($net_tot) }}</td>
		</tr>
		<tr>
			<td colspan="4" style="line-height:30px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:30px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">TOTAL TAXES</td>
			<td style="line-height:30px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong></strong>{{ format_price($tot_tax) }}</td>
		</tr>
		<tr>
			<td colspan="5" style="line-height:8px;">&nbsp;</td>
		</tr> 
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px; font-family:'Arial', sans-serif;">
		<tr>
			<td style="width:34%;line-height:15px;border:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="width:3%;line-height:15px;">&nbsp;</td>
			<td style="width:43%;line-height:15px;border:1px solid #ccc;text-align:center;font-family:DejaVu Sans, sans-serif;font-size:8px">دركة العالم المثالي للمنتوجات الاسمنتی <br><strong>Issued Checks As\ ALALEM ALMETHALI CO</strong>
			</td>
			<td style="line-height:15px;width:3%">&nbsp;</td>
			<td style="width:17%;line-height:15px;border:1px solid #ccc;text-align:center;font-family:DejaVu Sans, sans-serif;font-size:8px">الرصیــــد الكلــــي  <br>
				<strong>TOTAL BALANCE</strong>
			</td>
		</tr>
		<tr>
			<td style="width:34%;line-height:30px;">&nbsp;&nbsp;</td>
			<td style="width:3%;line-height:30px;">&nbsp;</td>
			<td style="width:43%;line-height:30px;"></td>
			<td style="line-height:30px;width:3%">&nbsp;</td>
			<td style="width:17%;line-height:30px;border:1px solid #ccc;text-align:center;font-size:8px">
				{{ format_price($grand_tot) }}
			</td>
		</tr>  	 
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px; font-family:'Arial', sans-serif;">
		<tr><td colspan="4" style="line-height:20px;">&nbsp;</td></tr> 
		<tr><td colspan="4" style="text-align:right;"><h5 class="top-ar">لقد استلمت الكمية الكاملة كاملة <br><strong>I RECEIVED WHOLE QUANTITY COMPLETE</strong></h5></td></tr> 
		<tr><td colspan="4" style="line-height:10px;">&nbsp;</td></tr> 
		<tr>
			<td style="width:20%;"><h5 class="top-ar"> مدیر المبیعات <br><strong>SALES MAN.</strong></h5></td>
			<td style="width:20%;"><h5 class="top-ar">المالية م. <br><strong>FINANCIAL M.</strong></h5></td>
			<td style="width:20%;"><h5 class="top-ar">أعدت بواسطة <br><strong>PERPARED BY</strong></h5></td>
			<td style="width:40%;text-align: right;"><h5 class="top-ar">استلمت من قبل <br><strong>RECEIVED BY</strong></h5></td>
		</tr>
		<tr><td colspan="4" style="line-height:10px;">&nbsp;</td></tr> 
		<tr><td colspan="4" style="text-align:right;"><h5 class="top-ar">التوقيع <br><strong>SIGNATURE</strong></h5></td></tr>
	</table>


	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px; font-family:'Arial', sans-serif;">
		<tr><td colspan="6" style="line-height:30px;">&nbsp;</td></tr>
		<tr>
			<td colspan="4" style="line-height:20px;"></td>
			<td colspan="2" style="line-height:20px;text-align:right;">&nbsp;&nbsp;<img src="footer-logo.png" alt="" width="200">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td style="line-height:20px;border-top:1px solid #ccc;">&nbsp;&nbsp;4058796314&nbsp;&nbsp;|</td>
			<td style="line-height:20px;border-top:1px solid #ccc;">&nbsp;&nbsp;info@demo.com&nbsp;&nbsp;|</td>
			<td style="line-height:20px;border-top:1px solid #ccc;">&nbsp;&nbsp;4058796314&nbsp;&nbsp;|</td>
			<td style="line-height:20px;border-top:1px solid #ccc;">&nbsp;&nbsp;info@demo.com&nbsp;&nbsp;|</td>
			<td style="line-height:20px;border-top:1px solid #ccc;">&nbsp;&nbsp;4058796314&nbsp;&nbsp;|</td>
			<td style="line-height:20px;border-top:1px solid #ccc;">&nbsp;&nbsp;info@demo.com&nbsp;&nbsp;|</td>
		</tr>
	</table>	

</body>
</html>

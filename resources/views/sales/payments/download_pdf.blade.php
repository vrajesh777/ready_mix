<?php
$grand_tot = 0;
$invoice = $arr_payment['invoice']??[];
?>
<!DOCTYPE html>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<head>
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
</head>

<body>

<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="font-size:9px; font-family:'Arial', sans-serif;text-align:right;">
	<tr><td style="line-height:18px;"><strong style="">{{ $arr_payment['to'] ?? '' }}</strong></td></tr>
	<tr><td style="line-height:18px;font-size:10px;"><strong>{{ $invoice['cust_details']['first_name'] ?? '' }}&nbsp;
				 	{{ $invoice['cust_details']['last_name'] ?? '' }}</strong></td></tr>
	<tr><td style="line-height:18px">{{ $invoice['billing_street']??'' }}</td></tr>
	<tr><td style="line-height:18px">{{ $invoice['billing_city']??'' }}</td></tr>
	<tr><td style="line-height:18px">{{ $invoice['billing_state']??'' }}</td></tr>
	<tr><td style="line-height:18px">{{ $invoice['billing_zip']??'' }}</td></tr>
</table>

<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="font-size:9px; font-family:'Arial', sans-serif;text-align:right;">
	<tr><td style="line-height:10px;">&nbsp;</td></tr>
	<tr align="center">
		<td style="font-size: 18px">Payment Receipt</td>
	</tr>
	<tr><td style="line-height:20px;">&nbsp;</td></tr>
</table>

<table width="35%" border="0" cellpadding="0" cellspacing="0" style="font-size:9px; font-family:'Arial', sans-serif;border:none;">
	<tr><td style="line-height:25px;border:1px solid #ccc;border-bottom:none;"><strong style="">&nbsp;&nbsp;Payment Date&nbsp;&nbsp; </strong>{{ $arr_payment['pay_date'] ?? 'N/A' }}</td> </tr>
	<tr><td style="line-height:25px;border:1px solid #ccc;border-bottom:none;"><strong style="">&nbsp;&nbsp;Payment Mode&nbsp;&nbsp;</strong>{{ $arr_payment['pay_method_details']['name'] ?? 'N/A' }}</td></tr>
	<tr><td style="line-height:25px;border:1px solid #ccc;border-bottom:none;"><strong style="">&nbsp;&nbsp;Transaction ID:&nbsp;&nbsp;</strong>{{ $arr_payment['trans_id'] ?? '' }}</td></tr>
	<tr><td style="line-height:28px;background-color:#84c529;color:#fff"><strong style="">&nbsp;&nbsp;Total Amount:&nbsp;&nbsp;</strong>{{ format_price($arr_payment['amount'] ?? 00) }}</td></tr>
	<tr><td style="line-height:10px;">&nbsp;</td></tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;font-size:9px; font-family:'Arial', sans-serif;">

	<tr align="center">
		<th style="width:34%;background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;">Invoice Number</th>
		<th style="width:11%;background-color:#323a45;color:#fff;line-height:16px;height:22px;">Invoice Date</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">Invoice Amount</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">Payment Amount</th>
	</tr>

	<tr><td style="line-height:5px;">&nbsp;</td></tr>

	<tr align="center">
		<td class="alLeft" style="color:#444;font-family:'Arial', sans-serif;">
			{{ $invoice['invoice_number'] ?? 'N/A' }}
		</td>
		<td style="">{{ $invoice['invoice_date'] ?? 'N/A' }}</td>
		<td style="">{{ format_price($invoice['grand_tot'] ?? 00) }}</td>
		<td style="">{{ format_price($arr_payment['amount'] ?? 00) }}</td>
	</tr>

	<tr><td style="line-height:5px;">&nbsp;</td></tr>


</table>

	


</body>
</html>

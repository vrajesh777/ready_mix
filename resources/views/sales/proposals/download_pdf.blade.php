<?php
$grand_tot = 0;
?>
<!DOCTYPE html>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<head>
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<style type="text/css">
	@media print {
	.alLeft{margin-left:5em}
	}
</style>
<body>

<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:11px; font-family:'Arial', sans-serif;">
	<tr>
		<td>
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
			<tr><td style="line-height:15px"><strong style=""># {{ format_proposal_number($arr_estimation['id']) }}</strong></td></tr>
			<tr><td style="line-height:15px">{{ $arr_estimation['subject'] ?? '' }}</td></tr>
			<tr><td style="line-height:15px">Date: {{ $arr_estimation['date'] ?? '' }}</td></tr>
			<tr><td style="line-height:15px">Expiry Date: {{ $arr_estimation['expiry_date'] ?? '' }}</td></tr>
		</table>	
		</td>
		<td>
		<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
			<tr><td style="line-height:15px"><strong style="">To</strong></td></tr>
			<tr><td style="line-height:15px"><strong style="">{{ $arr_estimation['to'] ?? '' }}</strong></td></tr>
			<tr>
				<td style="line-height:15px">
					<b>
				 	{{ $arr_estimation['cust_details']['first_name'] ?? '' }}&nbsp;
				 	{{ $arr_estimation['cust_details']['last_name'] ?? '' }}
				 	</b><br>
					<span class="billing_street">{{ $arr_estimation['billing_street']??'' }}</span><br>
					<span class="billing_city">{{ $arr_estimation['billing_city']??'' }}</span>,
					<span class="billing_state">{{ $arr_estimation['billing_state']??'' }}</span>
					<br>
					<span class="billing_zip">{{ $arr_estimation['billing_zip']??'' }}</span>
		        </td>
		    </tr>
		    @if($arr_estimation['include_shipping'] == '1')
		    <tr><td style="line-height:15px;padding-bottom: 16px;"></td></tr>
			<tr><td style="line-height:15px"><strong style="">Ship To</strong></td></tr>
			<tr>
				<td style="">
					<span class="shipping_street">{{ $arr_estimation['shipping_street']??'' }}</span><br>
					<span class="shipping_city">{{ $arr_estimation['shipping_city']??'' }}</span>,
					<span class="shipping_state">{{ $arr_estimation['shipping_state']??'' }}</span>
					<br>
					<span class="shipping_zip">{{ $arr_estimation['shipping_zip']??'' }}</span>
		        </td>
		    </tr>
		    @endif
		</table>
		</td>
	</tr>
	<tr>
		<td style="line-height:5px;">&nbsp;</td>
	</tr>	
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;font-size:10px; font-family:'Arial', sans-serif;">
		
	<tr>
		<th style="width:5%;background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;">&nbsp;&nbsp;#</th>
		<th style="width:34%;background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;">&nbsp;&nbsp;Item</th>
		<th style="width:11%;background-color:#323a45;color:#fff;line-height:16px;height:22px;">&nbsp;&nbsp;Qty</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">&nbsp;&nbsp;Rate</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">&nbsp;&nbsp;Tax</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">&nbsp;&nbsp;Amount</th>
	</tr>

	<tr><td style="line-height:5px;">&nbsp;</td></tr>

	@if(isset($arr_estimation['est_details']) && !empty($arr_estimation['est_details']))
	@foreach($arr_estimation['est_details'] as $key => $row)
	<?php
		$prod_det = $row['product_details'] ?? [];
		$tax_det = $prod_det['tax_detail'] ?? [];

		$sub_tot = $row['rate']*$row['quantity'];

		$tax_amnt = round($tax_det['tax_rate'] * ($sub_tot / 100),2);

		$sub_tot += $tax_amnt;

		$grand_tot += $sub_tot;
	?>
	<tr>
		<td style="font-size:11px;font-family:'Arial', sans-serif;">&nbsp;&nbsp;{{ ++$key }}</td>
		<td class="alLeft" style="color:#444;font-family:'Arial', sans-serif;"><strong style="color:#000;">{{ $prod_det['name'] ?? '' }}</strong><br>{{ $prod_det['description'] }}
		</td>
		<td style="">{{ $row['quantity'] ?? '' }}</td>
		<td style="">{{ isset($row['rate'])?number_format($row['rate'],2):'' }}</td>
		<td style="">{{ $tax_det['name'] ?? '' }} {{ $tax_det['tax_rate'] }}%</td>
		<td style="">{{ number_format($sub_tot,2) }}</td>
	</tr>
	@endforeach
	@endif

	<tr><td style="line-height:5px;">&nbsp;</td></tr>

	{{-- <tr>
		<td style="border-top:1px solid #ddd;line-height:20px;height:20px;" colspan="4"> </td>
		<td style="border-top:1px solid #ddd;line-height:20px;height:20px;" colspan="1"><strong>Sub Total</strong></td>
		<td style="border-top:1px solid #ddd;line-height:20px;height:20px;">$875.00</td>
	</tr>
	<tr>
		<td colspan="4" style="line-height:20px;height:20px;"> </td>
		<td colspan="1" style="line-height:20px;height:20px;"><strong>VAT (5.00%)</strong></td>
		<td style="line-height:20px;height:20px;">$0.00</td>
	</tr> --}}
	<tr>
		<td colspan="4" style="line-height:20px;height:20px;background-color:#f0f0f0;">&nbsp;&nbsp;S.R. </td>
		<td colspan="1" style="line-height:20px;height:20px;background-color:#f0f0f0;"><strong>Total</strong></td>
		<td style="line-height:22px;height:22px;background-color:#f0f0f0;"><strong>{{ format_price($grand_tot) }}</strong></td>
	</tr>

</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
	<tr><td style="line-height:50px;">&nbsp;</td></tr>
	<tr>
		<td style="width:20%;line-height:20px;height:20px;">Authorized Signature</td>
		<td style="width:30%;line-height:20px;height:20px;border-bottom:1px solid #ccc;"></td>
	</tr>
</table>	


</body>
</html>

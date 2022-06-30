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
			<tr><td style="line-height:15px"><strong style=""># {{ format_sales_estimation_number($arr_proposal['id']) }}</strong></td></tr>
			<tr><td style="line-height:15px">{{ $arr_proposal['subject'] ?? '' }}</td></tr>
			<tr><td style="line-height:15px">Date: {{ $arr_proposal['date'] ?? '' }}</td></tr>
			<tr><td style="line-height:15px">Open Till: {{ $arr_proposal['open_till'] ?? '' }}</td></tr>
		</table>	
		</td>
		<td>
		<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
			<tr><td style="line-height:15px"><strong style="">To</strong></td></tr>
			<tr><td style="line-height:15px"><strong style="">{{ $arr_proposal['to'] ?? '' }}</strong></td></tr>
			<tr><td style="line-height:15px">{{ $arr_proposal['address'] ?? '' }}</td></tr>
			<tr>
				<td style="line-height:15px">
					{{ $arr_proposal['city'] ?? '' }}&nbsp;
		            {{ $arr_proposal['state'] ?? '' }}&nbsp;
		            {{ $arr_proposal['postal_code'] ?? '' }}&nbsp;
		        </td>
		    </tr>
			<tr><td style="line-height:15px">{{ $arr_proposal['email'] ?? '' }}</td></tr>
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
		<th style="width:34%;background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;">Item</th>
		<th style="width:11%;background-color:#323a45;color:#fff;line-height:16px;height:22px;">Qty</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">Rate</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">tax</th>
		<th style="background-color:#323a45;color:#fff;line-height:18px;height:22px;">Amount</th>
	</tr>

	<tr><td style="line-height:5px;">&nbsp;</td></tr>

	@if(isset($arr_proposal['product_quantity']) && !empty($arr_proposal['product_quantity']))
	@foreach($arr_proposal['product_quantity'] as $key => $row)
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

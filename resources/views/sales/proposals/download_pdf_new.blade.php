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
	.table tr th{background-color:#d9d9d9;font-weight:bold;line-height:15px;height:20px;border:1px solid #b0b0b0;border-left:none;text-align:center;vertical-align:middle;}
	.ar-text{}
</style>
<body>

	<?php

		$grand_tot = 0;

		$cust_details = $arr_proposal['cust_details']??[];
		$cust_meta = $cust_details['user_meta']??[];

		$cust_company = search_in_user_meta($cust_meta,'company');
		$cust_name = $cust_details['first_name'];
		$cust_name .= ' '.$cust_details['last_name'];

	?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;text-align:center;">
		<tr><td colspan="3" style=""><img src="{{ asset('/') }}images/logo1.png" alt="" width="250"> </td></tr>
		<tr><td colspan="3" style="line-height:10px;border-bottom:3px solid #456f0a;"></td></tr>
		<tr><td colspan="3" style="line-height:15px;text-align:left;">{{ trans('admin.date') }}: {{ $arr_proposal['date'] ?? '' }}</td></tr>
		<tr>
			<td style="line-height:22px;width:40%">&nbsp;</td>
			<td style="line-height:22px;text-align:center;width:20%"><h5 style="border:1px solid #456f0a;font-size:11px;">Quotation</h5></td>
			<td style="line-height:22px;width:40%">&nbsp;</td>
		</tr>
		<tr><td colspan="3" style="line-height:20px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:9px; font-family:'Arial', sans-serif;">
		<tr>
			<td style="width:45%">
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
					<tr><td style="line-height:15px;background-color:#ccc;"><strong style="">&nbsp;&nbsp;From&nbsp;&nbsp;</strong></td></tr>
					<tr><td style="line-height:16px"><strong style="font-weight:100;">Perfect World Readymix Co.</strong></td></tr>
					<tr><td style="line-height:16px"><strong>Attn:</strong> Eng.Nedal Abdulrahman</td></tr>
					<tr><td style="line-height:16px"><strong>Mob:</strong> 0555689479</td></tr>
				</table>	
			</td>
			<td style="width:10%">
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
					<tr><td style="line-height:15px;">&nbsp;</td></tr>	
				</table>	
			</td>
			<td style="width:45%">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
					<tr><td style="line-height:15px;background-color:#ccc;"><strong style="">&nbsp;&nbsp;To&nbsp;&nbsp;</strong></td></tr>
					<tr><td style="line-height:16px"><strong style="">
						{{$arr_proposal['to']??''}}&nbsp;{{$cust_company??''}}
					</strong></td></tr>
					<tr><td style="line-height:16px"><strong style="">{{ trans('admin.ref') }}:</strong>{{$arr_proposal['ref_num']??''}}</td></tr>
					<tr><td style="line-height:16px"><strong style="">{{ trans('admin.project') }}:</strong>N/A</td></tr>
				</table>
			</td>
		</tr>
		<tr><td colspan="3" style="line-height:10px;">&nbsp;</td> </tr>	
		<tr>
			<td colspan="3" style="line-height:15px;font-size:11px;">Dear Customer,<br>We are grateful her in <strong>Perfect World Readymix Co.</strong> that you give us the opportunity to offer you our
				services and concrete products, where we are keen here to earn your satisfaction by providing your
				projects with the finest concrete products and best service.<br>
				So we are pleased to offer you the prices for ready-mix concrete including delivery and service as follows:

			</td> 
		</tr>	
		<tr><td colspan="3" style="line-height:7px;">&nbsp;</td> </tr>
	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px; font-family:'Arial', sans-serif;text-align: center;">
		<tr>
			<th rowspan="2" style="width:10%;">S</th>
			<th rowspan="2" style="width:50%;">Strength</th>
			<th colspan="2" style="width:40%;border-bottom:1px solid #b0b0b0;">Prices/M³</th>
		</tr>
		<tr>
			<th>{{ trans('admin.opc_1') }}</th>
			<th>{{ trans('admin.src_1') }}</th>
		</tr>
		@if(isset($arr_proposal['prop_details']) && !empty($arr_proposal['prop_details']))
		@foreach($arr_proposal['prop_details'] as $key => $row)
			<?php
				$prod_det = $row['product_details'] ?? [];
				$tax_det = $prod_det['tax_detail'] ?? [];

				$sub_tot = $row['rate']*$row['quantity'];

				$tax_amnt = round($tax_det['tax_rate'] * ($sub_tot / 100),2);

				$sub_tot += $tax_amnt;

				$grand_tot += $sub_tot;
			?>
			<tr>
				<td style="line-height:22px;border:1px solid #ccc;border-top:none;">{{ ++$key }}</td>
				<td style="line-height:22px;border:1px solid #ccc;border-top:none;">
					{{ $prod_det['name'] ?? '' }}
				</td>
				<td style="line-height:22px;border:1px solid #ccc;border-top:none;">{{ format_price($row['opc_1_rate']??0) }}</td>
				<td style="line-height:22px;border:1px solid #ccc;border-top:none;">{{ format_price($row['src_5_rate']??0) }}</td>
			</tr>
		@endforeach
		@endif

		<tr>
			<td colspan="4" style="line-height:8px;">&nbsp;</td>
		</tr>
	</table>

	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">

		<tr><td style="line-height:18px;">TERMS & CONDITIONS:</td> </tr>	
		<tr><td style="line-height:18px;">• Payment: as our agreement.</td> </tr>	
		<tr><td style="line-height:18px;">• The above prices do not include value-added tax (VAT).</td> </tr>	
		<tr><td style="line-height:18px;">• For screed concrete, an additional charge of 10 SR/M³ to be added.</td> </tr>	
		<tr><td style="line-height:18px;">• The above pricesIn the case of the installation of the Bathing Plantsat the site,include operating and supply</td> </tr>
		<tr><td style="line-height:18px;">• The prices are subjected to change upon the fluctuation in raw materials cost.</td> </tr>
		<tr><td style="line-height:18px;">• Quotation validity is one month.</td> </tr>
		<tr><td style="line-height:7px;">&nbsp;</td> </tr>
		<tr><td style="line-height:18px;">For further inquiries, please contact us at (0553382286)</td> </tr>	
		<tr><td style="line-height:18px;">Or toll free 92009536,Ext 200.</td> </tr>	
		<tr><td style="line-height:7px;">&nbsp;</td> </tr>
		<tr><td style="line-height:18px;"><strong>Sales & Marketing Manager</strong></td>
			<td></td>
		</tr>
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

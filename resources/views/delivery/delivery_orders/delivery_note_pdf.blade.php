<!DOCTYPE html>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<head>
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
</head>
<style type="text/css">
	.table tr th{background-color:#fff;line-height:12px;font-size:10px; border:0px solid #fff;border-left:none;text-align:center;vertical-align: middle;}
	.p{border:0px solid #fff;}
	
	body {
  background-color: #fff;
}
</style>
<body>
	 <?php
	 
	 $prod_attrs       = $arr_del_note['order_details']['product_details']['attr_values']??'';
	 $contract         = $arr_del_note['order_details']['order']['contract']??'';
	 $user_data        = $arr_del_note['order_details']['order']['cust_details']['user_meta']??'';
	 $shipping_address = $user_data['5']['meta_value']??'';
	 $city             = $user_data['6']['meta_value']??'';
	 $state            = $user_data['7']['meta_value']??'';
	 $zip              = $user_data['8']['meta_value']??'';

	 $max_loadable_quant = $arr_del_note['quantity']??0;
	
	  $progressive_cbm = round(($max_loadable_quant)*100, 2);

	 $cement = $cement_type=$slamp=$air_content=$other=$w_c_ratio=$sp=$rp=$wp='';
	 if(isset($prod_attrs) && count($prod_attrs)>0)
	 {
			foreach($prod_attrs as $key => $value) 
			{
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='cement')
				{
					$cement = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='cement_type')
				{
					$cement_type = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='slamp')
				{
					$slamp = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='air_content')
				{
					$air_content = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='other')
				{
					$other = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='w_c_ratio')
				{
					$w_c_ratio = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='sp')
				{
					$sp = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='rp')
				{
					$rp = $value['value']??'';
				}
				if(isset($value['attribute']['slug']) && $value['attribute']['slug']=='wp')
				{
					$wp = $value['value']??'';
				}
				
			}
	 }
	?>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;font-size:10px; font-family:'Arial', sans-serif;text-align:center;">
		<tr><td style="line-height:63px"> <!-- <img src="{{ asset('/') }}images/logo1.png" alt="" width="250"> --> </td></tr>
		<tr><td style="line-height:70px;"></td></tr> 
		<tr><td style="line-height:70px;">&nbsp;</td></tr>
		<tr>
			<td style="width:42%;line-height:15px;">&nbsp;</td>
			<td style="width:16%;line-height:15px;border-bottom:0px solid #fff;">
				<strong style="text-transform:uppercase;"> </strong>
			</td>
			<td style="width:42%;line-height:15px;">&nbsp;</td>
		</tr>
		<tr><td style="line-height:10px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;font-size:12px; font-family:'Arial', sans-serif;border:none">
		<tr>
			<td style="line-height:26px;border-bottom:0px solid #fff;"><strong style="font-size:12px; color: red; ">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    </strong>{{ $arr_del_note['delivery_no'] ?? '' }}</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;">&nbsp;&nbsp;<strong style="font-size:12px;">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    </strong>{{ date('d-m-Y',strtotime($arr_del_note['created_at'])) ?? '' }}</td> 
		</tr>
		<tr>
			<td style="line-height:25px;border-right:0px solid #fff;border-left:0px solid #fff;"><strong style="font-size:12px;">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    </strong>{{ $arr_del_note['order_details']['order']['cust_id'] ?? '' }}
			</td>
			<td style="line-height:25px;border-right:0px solid #fff;"><strong style="font-size:9px;">
		    	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    	</strong>{{ $arr_del_note['order_details']['order']['contract']['site_location'] ?? '' }}
		    </td> 
		</tr>

		<tr>
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff;border-right:0px solid #fff;"><strong style="font-size:9px;">
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <!-- </strong>{{ $arr_del_note['order_details']['order']['cust_details']['first_name'] ?? '' }} {{ $arr_del_note['order_details']['order']['cust_details']['last_name'] ?? '' }}</td> -->
				</strong>
				<!-- {{ $arr_del_note['order_details']['order']['cust_details']['last_name'] ?? '' }} -->
	 			<?php $sentence = $arr_del_note['order_details']['order']['cust_details']['last_name'] ?? '';
				  echo (mb_strlen($sentence)>33) ? mb_substr($sentence,0,33).".." : $sentence;?>
			</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-right:0px solid #fff;">&nbsp;&nbsp;<strong style="font-size:9px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			{{ $contract['structure_element']??'' }}</strong></td> 
		</tr>
		<tr><td colspan="6" style="line-height:6px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr><td style="line-height:23px;"></td></tr>
	</table>

	<table class="table" width="110%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;border:none;font-size:9px; font-family:'Arial', sans-serif;">
		<!-- <tr><td style="line-height:30px;"><strong style="">CONCREATE DETAILS:</strong></td></tr> -->
		<!--<tr>-->
		<!--	<th style="width:27%">&nbsp;&nbsp;MIX DESIGN / MIX CLASS</th>-->
		<!--	<th style="width:11%">MIX Code</th>-->
		<!--	<th style="width:10%">CEMENT CONTENT</th>-->
		<!--	<th style="width:10%">CEMENT TYPE</th>-->
		<!--	<th style="width:10%">CEMENT SOURCE</th>-->
		<!--	<th style="width:10%">SLUMP (mm)</th>-->
		<!--	<th style="width:11%">AIR CONTENT (%)</th>-->
		<!--	<th style="width:11%">TEMP.MAX. ALLOWED C°</th>-->
		<!--</tr>-->
        <tr>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:35%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:20%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:14%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12%"></th>
			<!--<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:11%"></th>-->
			<!--<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:11%"></th>-->
		</tr>
		
		<tr>
			<td style="line-height:155px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $arr_del_note['order_details']['product_details']['name'] ?? '' }}</td>
			<td style="line-height:130px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $arr_del_note['order_details']['product_details']['mix_code'] ?? '' }}</td>
			<td style="line-height:130px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $slamp??'' }}</td>
			<td style="line-height:130px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $cement??'' }}</td>
			<td style="line-height:130px;border-left:0px solid #fff;">       </td>
			<!--<td style="line-height:25px;border-left:0px solid #fff;">{{ $air_content??'' }}</td>-->
			<td style="line-height:130px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $cement_type??'' }}</td>
			<!--<td style="line-height:25px;border-left:0px solid #fff;">{{ 'YNB' }}</td>-->
			<!--<td style="line-height:25px;border-left:0px solid #fff;border-right:0px solid #fff;">{{ $contract['concrete_temp']??'' }}</td>-->
		</tr>

	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;border:none;font-size:10px; font-family:'Arial', sans-serif;">

		<!--<tr>-->
		<!--	<th style="width:9%;">&nbsp;&nbsp;W/C RATIO</th>-->
		<!--	<th style="width:9%;">FREE WTER QYT.</th>-->
		<!--	<th style="width:20%;">ADDITIVE TYPE (Lit./m³)</th>-->
		<!--	<th style="width:20%;">ADDITIVE TYPE (Lit./m³)</th>-->
		<!--	<th style="width:20%;">ADDITIVE ADDED ON SITE</th>-->
		<!--	<th style="width:11%;">WATER ADDED ON SITE (Lit.)</th>-->
		<!--	<th style="width:11%;">CONCRET TEMP ON SITE</th>-->
		<!--</tr>-->
		<tr>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:27px;width:11%"></th>
		</tr>
		<tr>
		    <td style="line-height:20px;border-left:0px solid #fff; font-size:12px;">{{ $air_content??'' }}</td>
		    <td style="line-height:20px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $contract['concrete_temp']??'' }}</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">{{ $w_c_ratio??'' }}</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;{{ $rp }}/{{ $sp }}</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sp??'' }}</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff; ">      </td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff;">&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:0px solid #fff;border-left:0px solid #fff;border-right:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
		</tr>

		<tr><td colspan="8" style="line-height:50px;">&nbsp;</td></tr>

	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr><td style="line-height:37px;"> &nbsp;&nbsp;  </td></tr>
	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<!-- <tr><td style="line-height:30px;"><strong style="">DELIVERY DETAILS:</strong></td></tr> -->
		<!--<tr>-->
		<!--	<th style="">&nbsp;&nbsp;TOTAL ORDER (m³)</th>-->
		<!--	<th style="">PROGRESSIVE (m³)</th>-->
		<!--	<th style="">LOAD (m³)</th>-->
		<!--	<th style="">LOAD NO.</th>-->
		<!--	<th style="">TRUCK NO.</th>-->
		<!--	<th style="">PLATE NO.</th>-->
		<!--	<th style="">ROTATION NO. ALLOWED</th>-->
		<!--	<th style="">MIXING TIME ALLOWED</th>-->
		<!--</tr>-->
		<tr>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;"></th>
		</tr>

		<tr>
			<td style="line-height:15px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;{{ $arr_del_note['order_details']['quantity'] ?? '' }}</td>
			<td style="line-height:15px;border-left:0px solid #fff; font-size:12px;">{{ $arr_del_note['order_details']['quantity_delivered']??0  }}</td>
			<td style="line-height:15px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;{{ $arr_del_note['quantity'] ?? '' }}</td>
			<td style="line-height:15px;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;{{ $arr_del_note['load_no'] ?? '' }}</td>
			<td style="line-height:15px;border-left:0px solid #fff; font-size:12px; width:10%x;">&nbsp;{{ $arr_del_note['vehicle']['name'] ?? '' }}</td>
			<!--<td style="line-height:15px;border-left:0px solid #fff; font-size:12px; width:10%x;">&nbsp;{{ $arr_del_note['vehicle']['plate_no'] ?? '' }}</td>-->
			<td style="line-height:15px;border-left:0px solid #fff; font-size:12px; width:10%x;">&nbsp;&nbsp;&nbsp;{{ $arr_del_note['vehicle']['plate_no'] ?? '' }}&nbsp;{{ $arr_del_note['vehicle']['plate_letter'] ?? '' }} </td>
			<td style="line-height:15px;border-left:0px solid #fff;">&nbsp;&nbsp;</td>
			<td style="line-height:15px;border-left:0px solid #fff;border-right:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
		</tr>

	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff;border:none;font-size:10px; font-family:'Arial', sans-serif;">

		<!--<tr>-->
		<!--	<th style="width:12.5%">&nbsp;&nbsp;PUMP NO.</th>-->
		<!--	<th style="width:12.5%">PUMPED (m³)</th>-->
		<!--	<th style="width:12.5%">TIME LEAVE PLANT.</th>-->
		<!--	<th style="width:12.5%">TIME ARRIVE SITE.</th>-->
		<!--	<th style="width:12.5%">DISCHARGE START TIME</th>-->
		<!--	<th style="width:12.5%">TIME LEAVE SITE</th>-->
		<!--	<th style="width:25%">TRUCK MIXER DRIVER</th>-->
		<!--</tr>-->
		<tr>
			<th style="background-color:#fff;border:1px solid #fff;line-height:26px;width:12.5%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12.5%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12.5%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12.5%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12.5%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:12.5%"></th>
			<th style="background-color:#fff;border:1px solid #fff;line-height:24px;width:25%"></th>
		</tr>

		<tr>
			<td style="line-height:115px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;{{ $arr_del_note['pump']??'' }}</td>
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;{{\Carbon\Carbon::now()->format('g:i a')}}</td>
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff; font-size:12px;">&nbsp;&nbsp;</td>
			<!-- <td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff;border-right:0px solid #fff;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $arr_del_note['driver']['first_name'] ?? '' }} {{ $arr_del_note['driver']['last_name'] ?? '' }}</td> -->
			<td style="line-height:22px;border-bottom:0px solid #fff;border-left:0px solid #fff;border-right:0px solid #fff; font-size:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $arr_del_note['driver']['last_name'] ?? '' }}</td>
		</tr>

		<tr><td colspan="8" style="line-height:20px;">&nbsp;</td></tr>

	</table>

	

</body>
</html>

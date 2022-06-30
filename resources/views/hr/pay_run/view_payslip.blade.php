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
		<!-- <td style="border:none;font-size:12px;padding:5px;"><img id="image" src="logo.png" alt="logo" width="200" /> -->
		<strong style="display: block;font-size:18px;color:#444; margin-bottom:2px;">{{ config('app.project.title') }}</strong><!-- Pune Pune Pune Maharashtra 789456 India -->
		</td>
		<!-- <td style="border:none;text-align:right;font-size:12px;color:#777;padding:5px;">
			<strong style="display: block;font-size:18px;color:#444; margin-bottom:2px;">Tax Invoice</strong>
		<strong style="display: block;font-size:18px;color:#444; margin-bottom:2px;">Balance Due SAR 0</strong>Email:-info@email.com</td> -->
	</tr>
	<tr>
	  <td colspan="2" style="line-height:10px;">&nbsp;</td>
	</tr>
	<tr>	
		<td colspan="2" style="border:none;text-align:center;">
		<strong style="display: block;font-size:18px;color:#444; margin-bottom:2px;">{{ trans('admin.payslip_for_the_month_of') }} {{ isset($arr_salary['payment_date'])?date('M',strtotime($arr_salary['payment_date'])):'' }} {{ isset($arr_salary['payment_date'])?date('Y',strtotime($arr_salary['payment_date'])):'' }}</strong>
		</td>
	</tr>
	<tr>
	  <td colspan="2" style="line-height:20px;">&nbsp;</td>
	</tr>	
	<tr>
		<td>
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;">
			<tr><td style="line-height:15px"><strong style="font-size:13px">{{ trans('admin.employee_pay_summary') }}</strong></td></tr>
			<tr><td style="line-height:15px"><strong style="width:90px;display:inline-block;">{{ trans('admin.employee_name') }}:</strong>{{ $arr_salary['user_details']['first_name'] ?? '' }} {{ $arr_salary['user_details']['last_name'] ?? '' }}</td></tr>
			<!-- <tr><td style="line-height:15px"><strong style="width:90px;display:inline-block;">Designation:</strong>Manger</td></tr> -->
			<tr><td style="line-height:15px"><strong style="width:90px;display:inline-block;">{{ trans('admin.date_of_joining') }}:</strong>{{ isset($arr_salary['user_details']['join_date'])?date('d/m/Y',strtotime($arr_salary['user_details']['join_date'])):'' }}</td></tr>
			<tr><td style="line-height:15px"><strong style="width:90px;display:inline-block;">{{ trans('admin.pay_period') }}:</strong>{{ isset($arr_salary['payment_date'])?date('M',strtotime($arr_salary['payment_date'])):'' }} {{ isset($arr_salary['payment_date'])?date('Y',strtotime($arr_salary['payment_date'])):'' }}</td></tr>
			<tr><td style="line-height:15px"><strong style="width:90px;display:inline-block;">{{ trans('admin.pay_date') }}:</strong>{{ isset($arr_salary['payment_date'])?date('d/m/Y',strtotime($arr_salary['payment_date'])):'' }}</td></tr>
		</table>	
		</td>
		<td>
		<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0" style="padding-bottom:4px;font-size:10px; font-family:'Arial', sans-serif;max-width:500px;border: 1px solid #ccc;text-align:center;padding:10px">
			<tr><td style="line-height:15px"><strong style="">{{ trans('admin.employee_net_pay') }}</strong></td></tr>
			<tr><td style="line-height:15px"><strong style="font-size:14px;color:#477503">{{ trans('admin.sar') }} {{ isset($arr_salary['monthly_total'])?number_format($arr_salary['monthly_total'],2):0.00 }}</strong></td></tr>
			<tr><td style="line-height:15px">{{ trans('admin.paid_days') }} : {{ $arr_salary['paid_days'] ?? 0 }} | {{ trans('admin.lop_days') }} : {{ $arr_salary['unpaid_days'] ?? 0 }}</td></tr>
		</table>
		</td>
	</tr>
	<tr>
	  <td style="line-height:5px;">&nbsp;</td>
	</tr>	
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #ddd;font-size:10px; font-family:'Arial', sans-serif;text-align:left;">
		
		  <tr>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;padding:4px">&nbsp;&nbsp;{{ trans('admin.earnings') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;font-family:'Arial', sans-serif;padding:4px">{{ trans('admin.amount') }}</th>
		      <th style="background-color:#323a45;color:#fff;line-height:16px;height:22px;padding:4px">{{ trans('admin.ytd') }}</th>
		  </tr>

		  <tr><td style="line-height:5px;">&nbsp;</td></tr>
		  	<tr>
                <td style="padding:4px">Basic</td>
                <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($arr_salary['basic'])?number_format($arr_salary['basic'],2):0.00 }}</td>
                <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($arr_salary['basic'])?number_format($arr_salary['basic'],2):0.00 }}</td>
            </tr>
		  	@if(isset($arr_salary['emp_salary_details']) && sizeof($arr_salary['emp_salary_details'])>0)
                @foreach($arr_salary['emp_salary_details'] as $earn)
                    <tr>
                        <td style="padding:4px">{{ $earn['earning_details']['name_payslip'] ?? '' }}</td>
                        <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($earn['monthly_amt'])?number_format($earn['monthly_amt'],2):0.00 }}</td>
                        <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($earn['monthly_amt'])?number_format($earn['monthly_amt'],2):0.00 }}</td>
                    </tr>
                @endforeach
            @endif

            @if(isset($arr_salary['lac_pay']) && $arr_salary['overtime_pay'] > 0)
	            <tr>
	                <td style="padding:4px">Overtime (+)</td>
	                <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($arr_salary['overtime_pay'])?number_format($arr_salary['overtime_pay'],2):0.00 }}</td>
	                <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($arr_salary['overtime_pay'])?number_format($arr_salary['overtime_pay'],2):0.00 }}</td>
	            </tr>
            @endif

            @if(isset($arr_salary['lac_pay']) && $arr_salary['lac_pay'] > 0)
	            <tr>
	                <td style="padding:4px">Lac (-)</td>
	                <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($arr_salary['lac_pay'])?number_format($arr_salary['lac_pay'],2):0.00 }}</td>
	                <td style="padding:4px">{{ trans('admin.sar') }} {{ isset($arr_salary['lac_pay'])?number_format($arr_salary['lac_pay'],2):0.00 }}</td>
	            </tr>
            @endif

		  	<tr><td style="line-height:5px;">&nbsp;</td></tr>
		  	<tr>
		      	<td style="line-height:20px;height:20px;background-color:#f0f0f0;">&nbsp;&nbsp;{{ trans('admin.gross_earnings') }}</td>
		      	<td style="line-height:20px;height:20px;background-color:#f0f0f0;"><strong>{{ trans('admin.sar') }}  {{ isset($arr_salary['monthly_total'])?number_format($arr_salary['monthly_total'],2):0.00 }}</strong></td>
		      	<td style="line-height:22px;height:22px;background-color:#f0f0f0;"></td>
		  	</tr>
		 
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
	 <tr><td style="line-height:20px;">&nbsp;</td></tr>
	 <tr><td style="font-size:14px;color:#477503">| {{ trans('admin.total_net_payable') }}<strong> {{ trans('admin.sar') }} {{ isset($arr_salary['monthly_total'])?number_format($arr_salary['monthly_total'],2):0.00 }}</strong> <!-- (Indian Rupee Fourteen Thousand Eight Hundred Only) --></td></tr>
	 <tr><td style="line-height:10px;">&nbsp;</td></tr>
	<tr>
		<td style="width:20%;line-height:20px;height:20px;"><a href="javascript:void(0);" onclick="window.print()">{{ trans('admin.print') }}</a></td>
	</tr>
</table>	


</body>
</html>

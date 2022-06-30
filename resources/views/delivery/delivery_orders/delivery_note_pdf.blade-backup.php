<!DOCTYPE html>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<head>
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">

</head>
<style type="text/css">
		
@media print{
   .noprint{
       display:none;
   }
}
	//.table tr th{background-color:#e6e7e9;line-height:12px;font-size:8px;border:1px solid #ccc;border-left:none;text-align:center;vertical-align: middle;}
	//.p{border:1px solid #555;}

	.table tr th{background-color:#e6e7e9;line-height:12px;font-size:8px;border:1px solid #ccc;border-left:none;text-align:center;vertical-align: middle;}
	.p{border:1px solid #555;}
	
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

	<table   width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;text-align:center;">
		<tr><td style="line-height:20px"><img src="{{ asset('/') }}images/logo1.png" alt="" width="250" > </td></tr>
		<!-- <tr><td style="line-height:20px;"></td></tr> 
		<tr><td style="line-height:20px;">&nbsp;</td></tr>-->
		<tr>
			<td style="width:42%;line-height:15px;">&nbsp;</td>
			<td style="width:16%;line-height:15px;border-bottom:1px solid #333;">
				<strong style="text-transform:uppercase;">Delivery Note</strong>
			</td>
			<td style="width:42%;line-height:15px;">&nbsp;</td>
		</tr>
		<tr><td style="line-height:10px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;border:none">
		<tr>
			<td style="line-height:20px;border-bottom:1px solid #ccc;"><strong style="font-size:9px;">DELIVERY NUMBER:&nbsp;&nbsp;</strong>{{ $arr_del_note['delivery_no'] ?? '' }}</td>
			<td style="line-height:20px;border-bottom:1px solid #ccc;">&nbsp;&nbsp;<strong style="font-size:9px;">DATE:&nbsp;&nbsp;</strong>{{ date('Y-m-d',strtotime($arr_del_note['created_at'])) ?? '' }}</td> 
		</tr>
		<tr>
			<td style="line-height:20px;border-right:1px solid #ccc;border-left:1px solid #ccc;"><strong style="font-size:9px;">&nbsp;&nbsp;CUSTOMER NO:&nbsp;&nbsp;</strong>{{ $arr_del_note['order_details']['order']['cust_id'] ?? '' }}</td>
			<td style="line-height:20px;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="font-size:9px;">DELIVERED TO:</strong>{{ $shipping_address }},{{ $city }},{{ $state }},{{ $zip }}</td> 
		</tr>

		<tr>
			<td style="line-height:20px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;"><strong style="font-size:9px;">&nbsp;&nbsp;CUSTOMER NAME:&nbsp;&nbsp;</strong>{{ $arr_del_note['order_details']['order']['cust_details']['first_name'] ?? '' }} {{ $arr_del_note['order_details']['order']['cust_details']['last_name'] ?? '' }}</td>
			<td style="line-height:20px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;<strong style="font-size:9px;">STRUCTURE:{{ $contract['structure_element']??'' }}</strong></td> 
		</tr>
		<tr><td colspan="6" style="line-height:6px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr><td style="line-height:20px;">CONCREATE DETAILS:</td></tr>
	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px; font-family:'Arial', sans-serif;">
		<!-- <tr><td style="line-height:30px;"><strong style="">CONCREATE DETAILS:</strong></td></tr> -->
		<tr>
			<th style="width:27%">&nbsp;&nbsp;MIX DESIGN / MIX CLASS</th>
			<th style="width:11%">MIX Code</th>
			<th style="width:10%">CEMENT CONTENT</th>
			<th style="width:10%">CEMENT TYPE</th>
			<th style="width:10%">CEMENT SOURCE</th>
			<th style="width:10%">SLUMP (mm)</th>
			<th style="width:11%">AIR CONTENT (%)</th>
			<th style="width:11%">TEMP.MAX. ALLOWED C°</th>
		</tr>

		<tr>
			<td style="line-height:25px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['order_details']['product_details']['name'] ?? '' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['order_details']['product_details']['mix_code'] ?? '' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;">{{ $cement??'' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;">{{ $cement_type??'' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;">{{ 'YNB' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;">{{ $slamp??'' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;">{{ $air_content??'' }}</td>
			<td style="line-height:25px;border-left:1px solid #ccc;border-right:1px solid #ccc;">{{ $contract['concrete_temp']??'' }}</td>
		</tr>

	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">

		<tr>
			<th style="width:9%;">&nbsp;&nbsp;W/C RATIO</th>
			<th style="width:9%;">FREE WTER QYT.</th>
			<th style="width:20%;">ADDITIVE TYPE (Lit./m³)</th>
			<th style="width:20%;">ADDITIVE TYPE (Lit./m³)</th>
			<th style="width:20%;">ADDITIVE ADDED ON SITE</th>
			<th style="width:11%;">WATER ADDED ON SITE (Lit.)</th>
			<th style="width:11%;">CONCRET TEMP ON SITE</th>
		</tr>
		<tr>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">{{ $w_c_ratio??'' }}</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">
			{{ $rp }}/{{ $sp }}</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">{{ $sp??'' }}</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;"></td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;</td>
		</tr>

		<tr><td colspan="8" style="line-height:10px;">&nbsp;</td></tr>

	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr><td style="line-height:20px;">CONCREATE DETAILS:</td></tr>
	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<!-- <tr><td style="line-height:30px;"><strong style="">DELIVERY DETAILS:</strong></td></tr> -->
		<tr>
			<th style="">&nbsp;&nbsp;TOTAL ORDER (m³)</th>
			<th style="">PROGRESSIVE (m³)</th>
			<th style="">LOAD (m³)</th>
			<th style="">LOAD NO.</th>
			<th style="">TRUCK NO.</th>
			<th style="">PLATE NO.</th>
			<th style="">ROTATION NO. ALLOWED</th>
			<th style="">MIXING TIME ALLOWED</th>
		</tr>

		<tr>
			<td style="line-height:22px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['order_details']['quantity'] ?? '' }}</td>
			<td style="line-height:22px;border-left:1px solid #ccc;">{{ $progressive_cbm??'' }}</td>
			<td style="line-height:22px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['quantity'] ?? '' }}</td>
			<td style="line-height:22px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['load_no'] ?? '' }}</td>
			<td style="line-height:22px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['vehicle']['id'] ?? '' }}</td>
			<td style="line-height:22px;border-left:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['vehicle']['plate_no'] ?? '' }}</td>
			<td style="line-height:22px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;</td>
		</tr>

	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">

		<tr>
			<th style="width:12.5%">&nbsp;&nbsp;PUMP NO.</th>
			<th style="width:12.5%">PUMPED (m³)</th>
			<th style="width:12.5%">TIME LEAVE PLANT.</th>
			<th style="width:12.5%">TIME ARRIVE SITE.</th>
			<th style="width:12.5%">DISCHARGE START TIME</th>
			<th style="width:12.5%">TIME LEAVE SITE</th>
			<th style="width:25%">TRUCK MIXER DRIVER</th>
		</tr>

		<tr>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">{{ $arr_del_note['pump']??'' }}</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td style="line-height:22px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;&nbsp;{{ $arr_del_note['driver']['first_name'] ?? '' }} {{ $arr_del_note['driver']['last_name'] ?? '' }}</td>
		</tr>

		<tr><td colspan="8" style="line-height:20px;">&nbsp;</td></tr>

	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;border:1px solid #ccc">
		<tr>
			<td style="line-height:30px;text-align:center;background-color:#ccc"><strong style="">Batch Receipt:</strong></td>
		</tr>
		<tr><td colspan="6" style="line-height:100px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;border:none">	
		<tr><td colspan="3" style="line-height:20px;">&nbsp;</td></tr>
		<tr>
			<td style="width:45%;line-height:20px;border-top:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;text-align:center;"><strong style="">DISPATCHING OFFICER</strong></td>
			<td style="width:10%;line-height:20px;">&nbsp;</td>
			<td style="width:45%;line-height:20px;border-top:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;text-align:center;"><strong style="">RECEIVED / CUSTOMER</strong></td>
		</tr>
		
		<tr>
			<td style="line-height:70px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;</td>
			<td style="line-height:70px;">&nbsp;</td>
			<td style="line-height:70px;border-bottom:1px solid #ccc;border-left:1px solid #ccc;border-right:1px solid #ccc;">&nbsp;</td>
		</tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr><td colspan="6" style="line-height:30px;">&nbsp;</td></tr>
		<tr>
			<td colspan="4" style="line-height:8px;"></td>
			<td colspan="2" style="line-height:8px;text-align:right;">&nbsp;&nbsp;<img src="{{ asset('/') }}images/footer-logo.png" alt="" width="200">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;4030593010&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;info@pwr.com&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;www.pwr.sa&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;920009536&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;4058796314&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;info@pwr.com&nbsp;&nbsp;|</td>
		</tr>
		<tr><td colspan="6" style="line-height:10px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px;line-height:14px; font-family:'Arial', sans-serif;">
		<tr>
			<td style="width:48%;text-align: justify;"><strong>Terms of Sale</strong><br> - These terms are an integral part of the sales contract.<br>
				- The load is delivered to the nearest point that can be reached, as determined by the driver or the seller's representative, and the buyer or his representative must sign the Delivery Note and the entire load is charged to the buyer.
				Ready-mix concrete is supplied according to the specified specifications and agreed upon between the two parties, and if specific specifications are not agreed upon, the supply will be according to the Saudi Building Code (SBC).<br>
				- The delivery of the materials atyour site shall be by signing the Delivery Note prepared for this purpose by you or by your delegate authorized to receive, either in the absence of you oryour authorized representative at the site at the time of the arrival of the materials, the delivery is made to any of your workers or with the contractor at the site and it is considered this is considered delivering the materials to you, and our responsibility is end, and in the case that none of the aforementioned on the site is present to receive the materials upon their arrival or any of your workers refuses to sign the this Delivery Note, then we will pour at the place site of work and this is considered a final delivery byyou and we are exempt from any are responsibility for this and you bear responsibility for the loss, damage, or destruction of the materials, and you have declared thatyou are committed to the presence ofyour authorized representative for the receiving at the work site during the process of delivery and the receiving and protection of the materials and with your unconditional consent as this is a final receiving from you and you have no right to object to it or to the delivered goods In the case thatyou or whoever acts on your behalf are not present at the site, and the materials arrive to the site and sign receiving them or considering them delivered in the quantities and specifications required according to the aforementioned, then our responsibilities will end.<br>
				- In the case of adding water to the concrete at the site, this addition is considered under the buyer responsibility and the quality of the poured concrete is under his responsibility, while following the general principles of caring for the concrete mix during and after pouring.<br>
					-Step 1: The concrete should be carefully covered immediately after the initial finishing with a polythene sheet.<br>
					-Step 2: After 4 to 8 hours, depending on the initial setting time of the concrete, the plastic or polythene cover is removed and immediately covered with wet slices of burlap and sprayed with water. And dampen the burlap completely with water, immediately replace the plastic cover from the bottom of the burlap to the top and fix it on the edges of the pouring well. So that the moisture keeped inside the concrete due to the effect of water evaporating from it.<br>
				- During the high air temperature and the increase in wind speed, it is preferable to use a helicopter fan to smooth the surface well, noting that this step is started after the concrete hardens in a way that it is possible to walk on it, and this is considered as a first step for treatment. Then, proceed with step 2 as shown above.</td>
			<td style="width:4%">&nbsp;</td>
			<td style="width:48%;font-family:DejaVu Sans, sans-serif;text-align:right;"><strong>شروط البيع</strong><br>- هذه الشروط جزء لا يتجزأ من عقد البيع. <br>
				- يتم تسليم الحمولة إلى أقرب نقطة يمكن الوصول إليها ، على النحو الذي يحدده السائق أو مندوب البائع ، ويجب على المشتري أو من ينوب عنه التوقيع على مذكرة التسليم ويتم تحميل الحمولة بالكامل على المشتري
				يتم توريد الخرسانة الجاهزة حسب المواصفات المحددة والمتفق عليها بين الطرفين ، وإذا لم يتم الاتفاق على مواصفات محددة ، فسيكون التوريد وفقًا لكود البناء السعودي (SBC). <br>
				- يتم تسليم المواد في موقعك عن طريق التوقيع على مذكرة التسليم المعدة لهذا الغرض من قبلك أو من قبل مفوضك المخول باستلامها ، إما في حالة عدم وجودك أو غياب ممثلك المفوض في الموقع وقت وصول المواد يتم التسليم لأي من العاملين لديك أو مع المقاول في الموقع ويعتبر هذا يعتبر تسليم المواد لك وتنتهي مسؤوليتنا وفي حالة عدم وجود أي مما سبق ذكره في الموقع لاستلام المواد عند وصولها أو رفض أي من العاملين لديك التوقيع على مذكرة التسليم هذه ، فسنقوم بالتدفق في موقع مكان العمل وهذا يعتبر تسليمًا نهائيًا بواسطتك ونحن معفون من أي مسؤولية عن ذلك وأنت تتحمل المسؤولية عن ضياع المواد أو تلفها أو إتلافها ، وأعلنت أنك ملتزم بحضور ممثلك المعتمد للاستلام في موقع العمل أثناء عملية تسليم المواد واستلامها وحمايتها وبموافقتك غير المشروطة لأن هذا استلام نهائي منك وليس لك الحق في الاعتراض عليه أو على البضائع المسلمة في حال كنت أنت أو من يتصرف نيابة عنك غير موجودة بالموقع ، وتصل المواد إلى الموقع وتوقع استلامها أو اعتبارها مسلمة بالكميات والمواصفات المطلوبة حسب ما سبق ، ثم تنتهي مسؤولياتنا. <br>
				- في حالة إضافة الماء إلى الخرسانة في الموقع ، تعتبر هذه الإضافة تحت مسؤولية المشتري وتكون جودة الخرسانة المصبوبة على مسؤوليته ، مع اتباع المبادئ العامة للعناية بالخلطة الخرسانية أثناء وبعد الصب. <br>
				-الخطوة 1: يجب تغطية الخرسانة بحرص فور التشطيب الأولي بورقة البوليثين <br>
				- الخطوة 2: بعد 4 إلى 8 ساعات ، اعتمادًا على وقت التثبيت الأولي للخرسانة ، تتم إزالة الغطاء البلاستيكي أو البولي إيثيلين وتغطيته على الفور بشرائح من الخيش مبللة ورشها بالماء. وبلل الخيش تمامًا بالماء ، استبدل الغطاء البلاستيكي على الفور من أسفل الخيش إلى الأعلى وثبته على حواف بئر الصب. بحيث تبقى الرطوبة داخل الخرسانة نتيجة تأثير تبخر الماء منها. <br>
				- أثناء ارتفاع درجة حرارة الهواء وزيادة سرعة الرياح يفضل استخدام مروحة هليكوبتر لتنعيم السطح جيداً مع ملاحظة أن هذه الخطوة تبدأ بعد تصلب الخرسانة بطريقة يمكن السير عليها ، و يعتبر هذا كخطوة أولى للعلاج. ثم تابع مع الخطوة 2 كما هو موضح أعلاه.</td>
		</tr>
		<tr><td colspan="2" style="line-height:10px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px;line-height:14px; font-family:'Arial', sans-serif;">
		<tr>
			<td style="width:50%;border-top:1px solid #ccc;border-left:1px solid #ccc;"><strong>&nbsp;&nbsp;Dear Valued Customer<br>&nbsp;&nbsp;Please help Perfect World Ready-Mix Co. maintain the <br>&nbsp;&nbsp;finset Quality and Services by checking the box below.</strong></td>
			<td style="width:5%;border-top:1px solid #ccc;">&nbsp;</td>
			<td style="width:45%;font-family:DejaVu Sans, sans-serif;text-align:right;border-top:1px solid #ccc;border-right:1px solid #ccc;"><strong>&nbsp;&nbsp;عزيزي العميل المحترم <br>&nbsp;&nbsp;الرجاء مساعدة شركة بيرفكت وورلد للخرسانة الجاهزة في الحفاظ على <br>&nbsp;&nbsp; الجودة والخدمات النهائية عن طريق تحديد المربع أدناه.</strong></td>
		</tr>
		<tr><td colspan="2" style="line-height:5px;border-left:1px solid #ccc;border-right:1px solid #ccc;width:100%">&nbsp;</td></tr>
	</table>

	<table class="table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">

		<tr>
			<th colspan="1" style="width:29%">Customer Survey</th>
			<th colspan="1" style="width:14%;font-family:DejaVu Sans, sans-serif;">ممتاز  <br>Excellent</th>
			<th colspan="1" style="width:14%;font-family:DejaVu Sans, sans-serif;">حسن  <br>Good</th>
			<th colspan="1" style="width:14%;font-family:DejaVu Sans, sans-serif;">مسكين<br>Poor</th>
			<th colspan="1" style="width:29%"></th>
		</tr>
		<tr>
			<td style="width:29%;border-left:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:29%;border-left:1px solid #ccc;border-right:1px solid #ccc;line-height:6px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;1. Mixer Driver Performance.</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;font-family:DejaVu Sans, sans-serif;">&nbsp;&nbsp;1. أداء مشغل الخلاط.</td>
		</tr>
		<tr>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-right:1px solid #ccc;line-height:6px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;2. Pump Operator Performance.</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;font-family:DejaVu Sans, sans-serif;">&nbsp;&nbsp;2. أداء مشغل المضخة.</td>
		</tr>
		<tr>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-right:1px solid #ccc;line-height:6px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;3. Satisfy with the Concrete Quality.</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;font-family:DejaVu Sans, sans-serif;">&nbsp;&nbsp;3. إرضاء جودة الخرسانة.</td>
		</tr>
		<tr>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-right:1px solid #ccc;line-height:6px">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;4. Satisfy with Perfect World RMC Services.</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="line-height:5px;height:5px;width:5.5%;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:3%;">&nbsp;&nbsp;</td>
			<td style="width:5.5%;line-height:15px;border-left:1px solid #ccc;">&nbsp;&nbsp;</td>

			<td style="width:29%;line-height:15px;border-left:1px solid #ccc;border-right:1px solid #ccc;font-family:DejaVu Sans, sans-serif;">&nbsp;&nbsp;4. إرضاء خدمات rmc العالم المثالي.</td>
		</tr>
		<tr>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:14%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;line-height:6px">&nbsp;</td>
			<td style="width:29%;border-left:1px solid #ccc;border-bottom:1px solid #ccc;border-right:1px solid #ccc;line-height:6px">&nbsp;</td>
		</tr>

		
	</table>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:9px;line-height:14px; font-family:'Arial', sans-serif;">
		<tr>
			<td style="width:45%;border-left:1px solid #ccc;">&nbsp;&nbsp;Your Comments and Suggestion:</td>
			<td style="width:10%;">&nbsp;</td>
			<td style="width:45%;font-family:DejaVu Sans, sans-serif;text-align:right;border-right:1px solid #ccc;"> &nbsp;&nbsp;تعليقاتك واقتراحك: &nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td style="width:45%;border-bottom:1px solid #ccc;border-left:1px solid #ccc;line-height:50px">&nbsp;&nbsp;</td>
			<td style="width:10%;border-bottom:1px solid #ccc;line-height:50px">&nbsp;</td>
			<td style="width:45%;font-family:DejaVu Sans, sans-serif;text-align:right;border-bottom:1px solid #ccc;border-right:1px solid #ccc;line-height:50px"> &nbsp;&nbsp;</td>
		</tr>
		<!-- <tr><td colspan="2" style="line-height:5px;border-left:1px solid #ccc;border-right:1px solid #ccc;width:100%">&nbsp;</td></tr> -->
	</table>		

</body>
</html>

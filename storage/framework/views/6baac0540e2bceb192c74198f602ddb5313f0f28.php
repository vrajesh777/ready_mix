<!DOCTYPE html>

<html>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<head>
	<title></title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
</head>
<style type="text/css">
	@page  {
       margin: 0mm;
    }
    .pur-order{border-radius:50px;width:150px;line-height:28px;border:1px solid #456f0a;border-radius:50px;display:inline-block;margin:auto;text-align:center;}
    .p{border:1px solid #555;}
</style>
<body>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;text-align:center;">
		<tr><td colspan="3" style=""><img src="<?php echo e(asset('/')); ?>images/logo1.png" alt="" width="250"> </td></tr>
		<tr><td colspan="3" style="line-height:10px;border-bottom:3px solid #456f0a;"></td></tr>
		<tr><td colspan="3" style="line-height:10px;">&nbsp;</td></tr>
		<tr>
			<td style="line-height:10px;">&nbsp;</td>
			<td class="pur-order" style="">Purchase Order</td>
			<td style="line-height:10px;">&nbsp;</td>
		</tr>
		<tr><td colspan="3" style="line-height:20px;">&nbsp;</td></tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:10px; font-family:'Arial', sans-serif;border:none">
		<tr>
			<td colspan="2" style="line-height:20px;border:1px solid #555;"><strong style="">&nbsp;&nbsp;To:&nbsp;&nbsp;</strong><?php echo e($arr_po['user_meta'][0]['meta_value'] ?? ''); ?></td>
			<td style="line-height:20px;border:1px solid #555;border-bottom:1px solid #555;">&nbsp;&nbsp;<strong style="">P.O No.:</strong>&nbsp;&nbsp;<?php echo e($arr_po['order_number'] ?? ''); ?></td> 
		</tr>
		<tr>
			<td style="line-height:20px;border-bottom:1px solid #555;border-right:1px solid #555;border-left:1px solid #555;"><strong style="">&nbsp;&nbsp;Attention:&nbsp;&nbsp;</strong></td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<strong style="">Location:&nbsp;&nbsp;</strong>JEDDAH</td> 
			<td style="line-height:20px;border-bottom:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<strong style="">Date:&nbsp;&nbsp;</strong><?php echo e($arr_po['order_date'] ?? ''); ?></td> 
		</tr>
		<tr>
			<td colspan="2" style="line-height:20px;border-bottom:1px solid #555;border-right:1px solid #555;border-left:1px solid #555;"><strong style="">&nbsp;&nbsp;Tel\Fax:&nbsp;&nbsp;</strong></td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<strong style="">Page No:&nbsp;&nbsp;</strong>1</td> 
		</tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr>
		  	<td colspan="6" style="line-height:2px;"></td>
		</tr>
		<tr>
			<th style="background-color:#d0cece;line-height:16px;height:22px;border-right:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;SN&nbsp;&nbsp;</th>
			<th style="background-color:#d0cece;line-height:18px;height:22px;border-right:1px solid #555;">&nbsp;&nbsp;Item Code&nbsp;&nbsp;</th>
			<th style="background-color:#d0cece;line-height:16px;height:22px;border-right:1px solid #555;">&nbsp;&nbsp;Description&nbsp;&nbsp;</th>
			<th style="background-color:#d0cece;line-height:16px;height:22px;border-right:1px solid #555;">&nbsp;&nbsp;Qty&nbsp;&nbsp;</th>
			<th style="background-color:#d0cece;line-height:18px;height:22px;border-right:1px solid #555;">&nbsp;&nbsp;Unit Price&nbsp;&nbsp;</th>
			<th style="background-color:#d0cece;line-height:18px;height:22px;border-right:1px solid #555;">&nbsp;&nbsp;Total Price&nbsp;&nbsp;</th>
		</tr>

		<?php if(isset($arr_po['purchase_order_details']) && sizeof($arr_po['purchase_order_details'])>0): ?>
			<?php $__currentLoopData = $arr_po['purchase_order_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<?php echo e($key+1); ?></td>
					<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<?php echo e($order['item_detail']['commodity_code'] ?? ''); ?></td>
					<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<?php echo e($order['item_detail']['description'] ?? ''); ?></td>
					<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<?php echo e($order['quantity'] ?? ''); ?></td>
					<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<?php echo e($order['unit_price'] ?? ''); ?></td>
					<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<?php echo e(number_format($order['total'],2) ?? ''); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<tr>
			<td colspan="4" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;text-align:right;">&nbsp;&nbsp;<strong>SubTotal</strong>&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<?php echo e(number_format($arr_po['sub_total'],2) ?? 0); ?></td>
		</tr>
		<tr>
			<td colspan="4" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;text-align:right;">&nbsp;&nbsp;<strong>Discount</strong>&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<?php echo e(number_format($arr_po['dc_total'],2) ?? 0); ?></td>
		</tr>
		<tr>
			<td colspan="2" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<strong>Total Amount</strong></td>
			<td colspan="2" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;<?php echo $amount_in_worrd ?? ''; ?></td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;text-align:right;">&nbsp;&nbsp;<strong>Total</strong>&nbsp;&nbsp;</td>
			<td style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<?php echo e(number_format($arr_po['total'],2) ?? 0); ?></td>
		</tr>

		<tr>
		  	<td colspan="6" style="line-height:15px;border-left:1px solid #555;border-right:1px solid #555;border-bottom:1px solid #555;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;text-align:right;">&nbsp;&nbsp;<strong>Payment Term</strong>&nbsp;&nbsp;</td>
			<td colspan="1" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;">&nbsp;&nbsp;</td>

			<td colspan="2" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;text-align:right;">&nbsp;&nbsp;<strong>Delivery</strong>&nbsp;&nbsp;</td>
			<td colspan="1" style="line-height:20px;border-bottom:1px solid #555;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;&nbsp;<?php echo e($arr_po['delivery_Date'] ?? ''); ?></td>
		</tr>
		<tr>
			<td colspan="6" style="line-height:15px;border-left:1px solid #555;border-right:1px solid #555;border-bottom:1px solid #555;">&nbsp;</td>
		</tr>



	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">	
		<tr>
			<td colspan="7" style="line-height:8px;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:20%;line-height:12px;border-left:1px solid #555;">&nbsp;&nbsp;<strong>Pament Method: </strong></td>
			<td class="p" style="line-height:5px;height:5px;width:2.3%;">&nbsp;&nbsp;</td>
			<td style="line-height:12px;width:24.37%;">&nbsp;&nbsp;Cash&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:2.3%;"></td>
			<td style="line-height:12px;width:24.37%;">&nbsp;&nbsp;Check&nbsp;&nbsp;</td>
			<td class="p" style="line-height:5px;height:5px;width:2.3%;vertical-align:middle;"></td>
			<td style="line-height:12px;width:24.37%;border-right:1px solid #555;">&nbsp;&nbsp;Bank Transfer&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td colspan="7" style="line-height:15px;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:10%;line-height:10px;border-left:1px solid #555;">&nbsp;&nbsp;Warranty&nbsp;&nbsp;</td>
			<td colspan="6" style="width:90%;line-height:2px;height:2px;border-bottom:1px solid #555;border-right:1px solid #555;"></td>
		</tr>
		<tr>
			<td colspan="7" style="line-height:15px;border-left:1px solid #555;border-right:1px solid #555;">&nbsp;</td>
		</tr>
		<tr>
			<td style="width:10%;line-height:10px;border-left:1px solid #555;">&nbsp;&nbsp;Remarks&nbsp;&nbsp;</td>
			<td colspan="6" style="width:90%;line-height:10px;border-right:1px solid #555;border-bottom:1px solid #555;"></td>
		</tr>
		<tr>
			<td colspan="7" style="line-height:20px;border-left:1px solid #555;border-right:1px solid #555;border-bottom:1px solid #555;">&nbsp;</td>
		</tr>
		<tr><td colspan="7" style="line-height:30px;">&nbsp;</td></tr>
		<tr>
			<td colspan="2" style="line-height:20px;text-align:center;">&nbsp;&nbsp;<strong>Operating Mgr.</strong>&nbsp;&nbsp;</td>
			<td colspan="3" style="line-height:20px;text-align:center;">&nbsp;&nbsp;<strong>Chief Accountant</strong>&nbsp;&nbsp;</td>
			<td colspan="2" style="line-height:20px;text-align:center;">&nbsp;&nbsp;<strong>Purchase Dept.</strong>&nbsp;&nbsp;</td>
		</tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:none;font-size:10px; font-family:'Arial', sans-serif;">
		<tr><td colspan="6" style="line-height:50px;">&nbsp;</td></tr>
		<tr>
			<td colspan="4" style=""></td>
			<td colspan="2" style="text-align:right;">&nbsp;&nbsp;<img src="<?php echo e(asset('/')); ?>images/footer-logo.png" alt="" width="200">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;4030593010&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;info@pwr.com&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;www.pwr.sa&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;920009536&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;4058796314&nbsp;&nbsp;|</td>
			<td style="line-height:15px;border-top:1px solid #555;">&nbsp;&nbsp;info@pwr.com&nbsp;&nbsp;|</td>
		</tr>
	</table>	

</body>
</html>
<?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/purchase/purchase_order/download_pdf.blade.php ENDPATH**/ ?>
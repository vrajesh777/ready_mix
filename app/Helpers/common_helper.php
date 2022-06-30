<?php
use App\Models\SalesContractModel;
use App\Models\TransactionsModel;
use App\Models\VechicleYearModel;
use App\Models\User;
use App\Models\DepartmentsModel;

function format_proposal_number($id)
{
    return 'PRO-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_purchase_request_number($id)
{
    return 'PR-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_purchase_estimate_number($id)
{
	return 'EST-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_purchase_order_number($id)
{
	return 'PO-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_purchase_contract_number($id)
{
	return 'CONT-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_sales_estimation_number($id)
{
    return 'EST-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_sales_invoice_number($id)
{
    return 'INV-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_supply_order_number($id)
{
    return 'SUP-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_order_number($id)
{
    return 'ORD-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_sales_contract_number($id)
{
    return 'SCO-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_purchase_delivery_no($id)
{
    return 'DLN-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}

function format_item_commodity_code($id)
{
    return 'CDT-' . str_pad($id, 5, '0', STR_PAD_LEFT);
}
function genrate_transaction_unique_number()
{
        $secure = TRUE;    
        $bytes = openssl_random_pseudo_bytes(6, $secure);
        $transcation_id = bin2hex($bytes);
        return strtoupper($transcation_id);   
}
function search_in_user_meta($meta_arr, $meta) {

	$ret = '';

	if(!empty($meta_arr)) {
		array_unshift($meta_arr, "");
		unset($meta_arr[0]);
		$key = array_search($meta, array_column($meta_arr, 'meta_key'))+1;
		if(!$key === false && isset($meta_arr[$key]) && !empty($meta_arr[$key])) {
			$ret = $meta_arr[$key]['meta_value']??'';
		}
	}

	return $ret;
}

function format_price($price) {
	if(is_numeric($price))
	{
		$price = number_format($price,2);
	}
	
	return 'SAR '.$price;
}

function checkPermission($permissions){
	$userAccess = auth()->user()->role_id;
	foreach ($permissions as $key => $value) {
	  if($value == $userAccess){
	    return true;
	  }
	}
	return false;
}

function calculate_customer_payment($user_id)
{
	$credit_amt = TransactionsModel::where('user_id',$user_id)
									//->whereNull('order_id')
									->where('type','credit')
									->sum('amount');

	$debit_amt = TransactionsModel::where('user_id',$user_id)
									->where('type','debit')
									->sum('amount');

	$arr_payment['credit_amt'] = $credit_amt ?? 0;
	$arr_payment['debit_amt'] = $debit_amt ?? 0;

	return $arr_payment;
}

function get_cust_latest_adavnce_payment($user_id)
{
	$arr_data = [];
	$obj_data = TransactionsModel::where('user_id',$user_id)
									->where('type','credit')
									->where('is_show','0')
									->whereNull('order_id')
									->select('id','amount')
									->get();
	if($obj_data)
	{
		$arr_data = $obj_data->toArray();
	}
	return $arr_data;
}

function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function sum_time($arr_time) {
    $i = 0;
    foreach ($arr_time as $time) {
        sscanf($time, '%d:%d', $hour, $min);
        $i += $hour * 60 + $min;
    }
    if ($h = floor($i / 60)) {
        $i %= 60;
    }
    return sprintf('%02d:%02d', $h, $i);
}

function get_year_from_model_make($make_id,$model_id)
{
	$year = '';
	$obj_year = VechicleYearModel::where('make_id',$make_id)
								  ->where('model_id',$model_id)
								  ->where('is_active','1')
								  ->first();

	$year = $obj_year->year ?? '';
	return $year;
}

function date_format_dd_mm_yy($date)
{
	return date('d-m-Y',strtotime($date));
}
function dateDifference($start_date,$end_date)
{
    // calulating the difference in timestamps 
    $diff = strtotime($start_date) - strtotime($end_date);
     
    // 1 day = 24 hours 
    // 24 * 60 * 60 = 86400 seconds
    return ceil(abs($diff / 86400));
}

function get_dept_name($dept_id){
	$dept_name = '';
	$obj_depart = DepartmentsModel::where('id',$dept_id)->first();
	if($obj_depart){
		$dept_name = $obj_depart->name ?? '';
	}

	return $dept_name;
}

?>
<?php

namespace App\Common\Services;

use \Session;
use \Mail;
use App\Models\TransactionsModel;
use Exception;

class TranscationService
{
	public function __construct() 
	{
		$this->TransactionsModel = new TransactionsModel();
	}

	public function store_payment($arr_pay_data, $ret_obj=false) {

		if($obj_data = $this->TransactionsModel->create($arr_pay_data)) {
			if($ret_obj) {
				return $obj_data;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}

	public function get_contract_bal($id) {

		$rem_bal = 0;

		$obj_trans = $this->TransactionsModel->where('contract_id', $id)->get();

		if($obj_trans->count() > 0 ) {

			$arr_data = $obj_trans->toArray();

			$cr_amnt = $dr_amnt = 0;

			foreach($arr_data as $trans) {
				if($trans['type'] == 'credit') {
					$cr_amnt += $trans['amount']??0;
				}elseif($trans['type'] == 'debit') {
					$dr_amnt += $trans['amount']??0;
				}
			}
			$rem_bal = ($cr_amnt-$dr_amnt);
		}
		return $rem_bal;
	}

	public function get_customer_bal($id) {

		$rem_bal = 0;

		$obj_trans = $this->TransactionsModel->where('user_id', $id)->get();

		if($obj_trans->count() > 0 ) {

			$arr_data = $obj_trans->toArray();

			$cr_amnt = $dr_amnt = 0;

			foreach($arr_data as $trans) {
				if($trans['type'] == 'credit') {
					$cr_amnt += $trans['amount']??0;
				}elseif($trans['type'] == 'debit') {
					$dr_amnt += $trans['amount']??0;
				}
			}
			$rem_bal = ($cr_amnt-$dr_amnt);
		}
		return $rem_bal;
	}
}

?>
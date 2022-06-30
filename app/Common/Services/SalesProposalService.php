<?php
namespace App\Common\Services;

use Illuminate\Http\Request;
use App\Models\SalesEstimateModel;
use App\Models\SiteSettingModel;
use App\Models\SalesProposalModel;

class SalesProposalService
{
	public function get_sales_workflow()
	{
		$workflow = 0;
		$obj_workflow = SiteSettingModel::where('id',1)
										->select('sales_with_workflow')
										->first();
		if($obj_workflow)
		{
			$workflow = $obj_workflow->sales_with_workflow ?? 0;
		}

		return $workflow;
	}

	public function get_proposals()
	{
		$obj_proposals = SalesEstimateModel::where('')->get();
	}

	public function get_all_proposal()
	{
		$workflow = $this->get_sales_workflow();
		$arr_props = [];
		$obj_proposals = SalesProposalModel::whereHas('prop_details', function(){})
                                    ->whereHas('cust_details', function(){})
                                    ->with(['prop_details','cust_details']);

        if(\Auth::user()->role_id != config('app.roles_id.admin')) {
        	$obj_proposals = $obj_proposals->where('assigned_to', \Auth::user()->id);
        }

        if(\Request::has('status') && \Request::get('status') != '') {
        	$obj_proposals = $obj_proposals->where('status', \Request::get('status'));
        }

        if($workflow == '1'){
        	$obj_proposals = $obj_proposals->whereNotNull('proposal_id');
        }
        else{
        	$obj_proposals = $obj_proposals->whereNull('proposal_id');
        }

        $obj_proposals = $obj_proposals->orderBy('id', 'DESC')->get();

        if($obj_proposals->count() > 0) {
            $arr_props = $obj_proposals->toArray();
        }
        return $arr_props;
	}
}


?>
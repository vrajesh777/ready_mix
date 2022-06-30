<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseOrderModel;
use App\Models\BarcodesModel;

class PrintLabelsController extends Controller
{
    public function __construct()
	{
        $this->PurchaseOrderModel = new PurchaseOrderModel();
        $this->BarcodesModel      = new BarcodesModel();

		$this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = "Purchase Parts";
        $this->module_view_folder   = "vechicle_maintance.print_labels";
        $this->module_url_path      = url('/print_labels');

        $this->department_id      = config('app.dept_id.vechicle_maintance'); 
	}

	public function index(Request $request)
    {
    	$arr_parts = $arr_parts_data = $arr_barcodes = [];

    	$obj_data = $this->PurchaseOrderModel->with(['part'=>function($qry){
    	    											$qry->select('id','commodity_name');
    	    										 }])
    										 ->select('id','part_id','part_no')
    										 ->groupBy('part_no')
    										 ->get();
    	if($obj_data)
    	{
    		$arr_parts = $obj_data->toArray();
    	}

        $obj_barcodes = $this->BarcodesModel->select('id','name')->get();
        if($obj_barcodes)
        {
            $arr_barcodes = $obj_barcodes->toArray();
        }

        $this->arr_view_data['arr_barcodes'] = $arr_barcodes;
        $this->arr_view_data['arr_parts']    = $arr_parts;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
    	return view($this->module_view_folder.'.index',$this->arr_view_data);
    }

    public function print_labels_row(Request $request)
    {
    	if ($request->ajax()) {
            $part_id = $request->input('part_id');
            $part_no = $request->input('part_no');

            if (!empty($part_id)) {
                $index = $request->input('row_count');
                $products = $this->PurchaseOrderModel->with(['part'=>function($qry){
                                                        $qry->select('id','commodity_name');
                                                     }])
                                             ->select('id','part_id','part_no')
                                             ->where('part_no',$part_no)
                                             ->where('part_id',$part_id)
                                             ->groupBy('part_no')
                                             ->get();
                if($products)
                {
                    $arr_parts_data = $products->toArray();
                }

                $this->arr_view_data['arr_parts_data'] = $arr_parts_data ?? [];
                $this->arr_view_data['index'] = $index ?? [];
                return view($this->module_view_folder.'.show_table_rows',$this->arr_view_data);
            }
        }
    }

    public function print_labels_preview(Request $request)
    {
    	try {

            $products = $request->get('products');
            $print = $request->get('print');
            $barcode_setting = $request->get('barcode_setting');
            //$business_id = $request->session()->get('user.business_id');
            $barcode_details = $this->BarcodesModel->find($barcode_setting);
            //$business_name = $request->session()->get('business.name');

            $product_details = [];
            $total_qty = 0;
        
            foreach ($products as $value) {
                $details = [];
                $details = $this->PurchaseOrderModel->with(['part'=>function($qry){
                                                        $qry->select('id','commodity_name');
                                                     }])
                                             ->select('id','part_id','part_no','buy_price')
                                             ->where('part_no',$value['part_no'])
                                             ->where('part_id',$value['part_id'])
                                             ->groupBy('part_no')
                                             ->first();

                $product_details[] = ['details' => $details, 'qty' => $value['quantity']];
                $total_qty += $value['quantity'];
            }

            $page_height = null;
            if ($barcode_details->is_continuous) {
                $rows = ceil($total_qty/$barcode_details->stickers_in_one_row) + 0.4;
                $barcode_details->paper_height = $barcode_details->top_margin + ($rows*$barcode_details->height) + ($rows*$barcode_details->row_distance);
            }
            //dd($product_details);
            $output = view('vechicle_maintance.print_labels.preview')
                ->with(compact('print', 'product_details', 'barcode_details', 'page_height'))->render();

            // $output = ['html' => $html,
            //                 'success' => true,
            //                 'msg' => ''
            //             ];
        } catch (\Exception $e) {
            
        }

        return $output;
    }

}

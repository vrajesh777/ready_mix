<?php

namespace App\Http\Controllers\Vechicle_Maintance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VechicleRepairModel;
use App\Models\VhcPartSupplyDetailModel;
use App\Models\VehicleModel;
use App\Models\VechicleMakeModel;
use App\Models\VechicleModelModel;
use App\Models\VechicleYearModel;
use App\Models\VechiclePurchasePartsDetailsModel;
use App\Models\User;
use App\Models\ItemModel;
use Validator;
use Session;
use Auth;

class VechicleRepairController extends Controller
{
    public function __construct()
    {
        $this->VechicleRepairModel               = new VechicleRepairModel;
        $this->VhcPartSupplyDetailModel          = new VhcPartSupplyDetailModel;
        $this->VehicleModel                      = new VehicleModel;
        $this->VechicleMakeModel                 = new VechicleMakeModel;
        $this->VechicleModelModel                = new VechicleModelModel;
        $this->VechicleYearModel                 = new VechicleYearModel;
        $this->VechiclePurchasePartsDetailsModel = new VechiclePurchasePartsDetailsModel;
        $this->UserModel                         = new User;
        $this->ItemModel                         = new ItemModel;
        $this->auth                 = auth();
        $this->arr_view_data        = [];
        $this->module_title         = trans('admin.repair');
        $this->module_view_folder   = "vechicle_maintance.repair";
        $this->module_url_path      = url('/vhc_repair');

        $this->department_id      = config('app.dept_id.vechicle_maintance');
    }

    public function index(Request $request)
    {
        $vechicle_id = $status = '';
        $arr_data = $arr_vechicle = $arr_make = $arr_model = $arr_year = [];
        $obj_data = $this->VechicleRepairModel->with([
            'vechicle_details.make',
            'vechicle_details.model',
            'vechicle_details'
        ]);

        if ($request->has('vechicle_id') && $request->input('vechicle_id') != '') {
            $vechicle_id = $request->input('vechicle_id');
            $obj_data = $obj_data->where('vechicle_id', $vechicle_id);
        }

        if ($request->has('status') && $request->input('status') != '') {
            $status = $request->input('status');
            $obj_data = $obj_data->where('status', $status);
        }

        $obj_data = $obj_data->get();
        if ($obj_data) {
            $arr_data = $obj_data->toArray();
        }

        $obj_vechicle = $this->VehicleModel->get();
        if ($obj_vechicle) {
            $arr_vechicle = $obj_vechicle->toArray();
        }

        $this->arr_view_data['arr_data']     = $arr_data;
        $this->arr_view_data['arr_vechicle'] = $arr_vechicle;
        $this->arr_view_data['vechicle_id']  = $vechicle_id;
        $this->arr_view_data['status']       = $status;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        return view($this->module_view_folder . '.index', $this->arr_view_data);
    }

    public function create()
    {
        $arr_vechicle = $arr_make = [];
        $obj_vechicle = $this->VehicleModel->get();
        if ($obj_vechicle) {
            $arr_vechicle = $obj_vechicle->toArray();
        }

        $obj_make = $this->VechicleMakeModel->where('is_active', '1')->get();
        if ($obj_make) {
            $arr_make = $obj_make->toArray();
        }

        $obj_mechanic = $this->UserModel->where('role_id', config('app.roles_id.mechanic'))
            ->where('is_active', '1')
            ->get();
        if ($obj_mechanic) {
            $arr_mechanics = $obj_mechanic->toArray();
        }


        $this->arr_view_data['arr_vechicle']  = $arr_vechicle;
        $this->arr_view_data['arr_mechanics'] = $arr_mechanics;
        $this->arr_view_data['arr_make']      = $arr_make;

        $objItems = $this->ItemModel->get();

        if($objItems) {
            $arr_items = $objItems->toArray();
        }

        $this->arr_view_data['arr_items']       = $arr_items;

        $this->arr_view_data['module_title']    = $this->module_title;
        $this->arr_view_data['page_title']      = $this->module_title;
        $this->arr_view_data['module_url_path'] = $this->module_url_path;
        return view($this->module_view_folder . '.create', $this->arr_view_data);
    }

    public function store(Request $request)
    {
        $arr_rules = [];
        // $arr_rules['delivery_date'] = 'required';
        $arr_rules['vechicle_id']    = 'required';
        //$arr_rules['partsfilter'] = 'required';

        $validator = Validator::make($request->All(), $arr_rules);
        if ($validator->fails()) {
            Session::flash('error', trans('admin.all_fields_required'));
            return redirect()->back()->withErrors($validator)->withInputs($request->all());
        }

        $input   = $request->input();
        $arr_data['dept_id']       = $this->department_id;
        $arr_data['created_date'] = date('Y-m-d');
        $arr_data['vechicle_id']   = $input['vechicle_id'];
        $arr_data['note']          = $input['note'];
        // jobcard data
        $arr_data['jobcard_no']    = rand(1000, 9999);
        $arr_data['door_no']       = $input['door_no'];
        $arr_data['km_count']      = $input['km_count'];
        $arr_data['time']          = $input['time'];
        $arr_data['complaint']     = $input['complaint'];
        $arr_data['diagnosis']     = $input['diagnosis'];
        $arr_data['action']        = $input['action'];

        // dd($arr_data);

        $status = $this->VechicleRepairModel->create($arr_data);
        if ($status) {
            $status->order_no = format_supply_order_number($status->id);
            $status->save();

            $id = $status->id;

            if ($request->has('item') && count($request->input('item')) > 0 ) {
                foreach ($request->input('item') as $key => $item_row) {
                    $arr_parts['supply_order_id'] = $id;
                    $arr_parts['item_id']   = $item_row['quantity'] ?? 0;
                    $arr_parts['quantity']  = $request->input('quantity')[$key] ?? 0;

                    $this->VhcPartSupplyDetailModel->create($arr_parts);
                }
            }
            Session::flash('success', trans('admin.supply_parts') . ' ' . trans('admin.added_successfully'));
        } else {
            Session::flash('error', trans('admin.error_msg'));
        }

        return redirect()->back();
    }

    public function edit($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->VechicleRepairModel->with('vechicle_details', 'vhc_parts','vhc_parts.item')->where('id', $id)->first();
        if ($obj_data) {
            $arr_vechicle = $arr_make = [];
            $arr_data = $obj_data->toArray();

            $obj_vechicle = $this->VehicleModel->get();
            if ($obj_vechicle) {
                $arr_vechicle = $obj_vechicle->toArray();
            }

            $obj_make = $this->VechicleMakeModel->where('is_active', '1')->get();
            if ($obj_make) {
                $arr_make = $obj_make->toArray();
            }
            $obj_mechanic = $this->UserModel->where('role_id', config('app.roles_id.mechanic'))
                ->where('is_active', '1')
                ->get();
            if ($obj_mechanic) {
                $arr_mechanics = $obj_mechanic->toArray();
            }

            $obj_model = $this->VechicleModelModel->where('is_active', '1')->with('make')->get();
            if ($obj_model) {
                $arr_model = $obj_model->toArray();
            }

            $obj_year = $this->VechicleYearModel->where('is_active', '1')->with(['make', 'model'])->get();
            if ($obj_year) {
                $arr_year = $obj_year->toArray();
            }

            $obj_parts = $this->VhcPartSupplyDetailModel->with(['item','item.unit_detail'])->where('supply_order_id', $id)->get();
            $arr_parts = [];
            if($obj_parts) {
                $arr_parts = $obj_parts->toArray();
            }

            $objItems = $this->ItemModel->get();

            if($objItems) {
                $arr_items = $objItems->toArray();
            }

            $this->arr_view_data['arr_items']       = $arr_items;
            $this->arr_view_data['arr_vechicle']    = $arr_vechicle;
            $this->arr_view_data['arr_mechanics']   = $arr_mechanics;
            $this->arr_view_data['arr_make']        = $arr_make;
            $this->arr_view_data['arr_model']       = $arr_model;
            $this->arr_view_data['arr_year']        = $arr_year;
            $this->arr_view_data['arr_parts']       = $arr_parts;
            $this->arr_view_data['arr_data']        = $arr_data;
            $this->arr_view_data['enc_id']          = $enc_id;

            $this->arr_view_data['module_title']    = $this->module_title;
            $this->arr_view_data['page_title']      = $this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;

            return view($this->module_view_folder . '.edit', $this->arr_view_data);
        } else {
            Session::flash('error', trans('admin.invalid_request'));
        }
        return redirect()->back();
    }

    public function update($enc_id, Request $request)
    {
        if ($enc_id != '') {
            $id = base64_decode($enc_id);

            $arr_rules                  = [];
            // $arr_rules['delivery_date'] = 'required';
            $arr_rules['vechicle_id']   = 'required';

            $validator = Validator::make($request->All(), $arr_rules);
            if ($validator->fails()) {
                Session::flash('error', trans('admin.all_fields_required'));
                return redirect()->back()->withErrors($validator)->withInputs($request->all());
            }

            $arr_data['delivery_date'] = date('Y-m-d', strtotime($request->input('delivery_date')));
            $input = $request->input();
            // dd($input);

            // $arr_data['note']          = $input['note'];
            // $arr_data['assignee_id']   = $input['assignee_id'];
            // $arr_data['door_no']       = $input['door_no'];
            // $arr_data['km_count']      = $input['km_count'];
            // $arr_data['complaint']     = $input['complaint'];
            // $arr_data['diagnosis']     = $input['diagnosis'];
            // $arr_data['action']        = $input['action'];

            $arr_data['delivery_date'] = $input['delivery_date'];
            $arr_data['time']          = $input['time'];
            $arr_data['hours_meter']   = $input['hours_meter'];
            $arr_data['remark']        = $input['remark'];
            // dd($arr_data);
            $status = $this->VechicleRepairModel->where('id', $id)->update($arr_data);
            if ($status) {
                if ($request->has('partsfilter')) {
                    $partsfilter = array_values($request->input('partsfilter'));
                    if (sizeof($partsfilter) && count($partsfilter) > 0) {
                        $this->VhcPartSupplyDetailModel->where('supply_order_id', $id)->delete();

                        foreach ($partsfilter as $part_key => $part_value) {

                            $arr_parts['supply_order_id'] = $id;
                            $arr_parts['part_id']     = $part_value['part'] ?? 0;
                            $arr_parts['make_id']     = $part_value['make'] ?? 0;
                            $arr_parts['model_id']    = $part_value['model'] ?? 0;
                            $arr_parts['year_id']     = $part_value['year'] ?? 0;
                            $arr_parts['quantity']    = $part_value['quantity'] ?? 0;

                            $this->VhcPartSupplyDetailModel->create($arr_parts);
                        }
                    }
                }
                Session::flash('success', trans('admin.supply_parts') . ' ' . trans('admin.updated_successfully'));
            } else {
                Session::flash('error', trans('admin.error_msg'));
            }
        } else {
            Session::flash('error', trans('admin.invalid_request'));
        }


        return redirect()->back();
    }

    public function show($enc_id)
    {
        $id = base64_decode($enc_id);
        $obj_data = $this->VechicleRepairModel->with('vechicle_details', 'vhc_part_detail')->where('id', $id)->first();
        if ($obj_data) {
            $arr_vechicle = $arr_make = [];
            $arr_data = $obj_data->toArray();

            $obj_vechicle = $this->VehicleModel->get();
            if ($obj_vechicle) {
                $arr_vechicle = $obj_vechicle->toArray();
            }

            $obj_make = $this->VechicleMakeModel->where('is_active', '1')->get();
            if ($obj_make) {
                $arr_make = $obj_make->toArray();
            }
            $obj_mechanic = $this->UserModel->where('role_id', config('app.roles_id.mechanic'))
                ->where('is_active', '1')
                ->get();
            if ($obj_mechanic) {
                $arr_mechanics = $obj_mechanic->toArray();
            }

            $obj_model = $this->VechicleModelModel->where('is_active', '1')->with('make')->get();
            if ($obj_model) {
                $arr_model = $obj_model->toArray();
            }

            $obj_year = $this->VechicleYearModel->where('is_active', '1')->with(['make', 'model'])->get();
            if ($obj_year) {
                $arr_year = $obj_year->toArray();
            }

            $obj_parts = $this->VhcPartSupplyDetailModel->with(['item','item.unit_detail'])->where('supply_order_id', $id)->get();
            if($obj_parts) {
                $arr_parts = $obj_parts->toArray();
            }

            $this->arr_view_data['arr_vechicle']  = $arr_vechicle;
            $this->arr_view_data['arr_mechanics'] = $arr_mechanics;
            $this->arr_view_data['arr_make']     = $arr_make;
            $this->arr_view_data['arr_model']    = $arr_model;
            $this->arr_view_data['arr_year']     = $arr_year;
            $this->arr_view_data['arr_parts']    = $arr_parts;
            $this->arr_view_data['arr_data']     = $arr_data;
            $this->arr_view_data['enc_id']       = $enc_id;

            $this->arr_view_data['module_title']    = $this->module_title;
            $this->arr_view_data['page_title']      = $this->module_title;
            $this->arr_view_data['module_url_path'] = $this->module_url_path;
            // dd($arr_data);
            return view($this->module_view_folder . '.show', $this->arr_view_data);
        } else {
            Session::flash('error', trans('admin.invalid_request'));
        }
        return redirect()->back();
    }

    public function change_status($enc_id)
    {
        $id = base64_decode($enc_id);
        if (!$id) {
            return redirect()->back();
        }

        $obj_data = $this->VechicleRepairModel->where('id', $id)->first();

        if ($obj_data) {
            $status =  $obj_data->update(['status' => 'Delivered']);
            if ($status) {
                Session::flash('success', trans('admin.updated_successfully'));
            } else {
                Session::flash('error', trans('admin.error_msg'));
            }
        }

        return redirect()->back();
    }

    public function decrementRepairStock($enc_id, Request $request)
    {
        $isChecked = $request->get('isChecked');
        // dd($isChecked);
        $arr_data['message'] = '';
        if($isChecked){
            $params['status'] = '2';
        }
        else{
            $params['status'] = '1';
        }
        $id = base64_decode($enc_id);
        // $arr_data = array();
        $obj_data = $this->VhcPartSupplyDetailModel->where('id', $id)->first();
        if ($obj_data) {
            $arr_data = $obj_data->toArray();

            if ($arr_data && count($arr_data) > 0) {
                $updatedRes = $this->VhcPartSupplyDetailModel->where('id', $id)->update($params);
                if($updatedRes){
                        $arr_data['message'] = 'Stock updated successfully';
                }
            }
        }
        return response()->json($arr_data);
    }
}

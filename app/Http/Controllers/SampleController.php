<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SampleController extends Controller
{
	public function __construct()
	{
        $this->arr_view_data        = [];
        $this->module_view_folder   = "sample_pages";
        $this->module_url_path      = url('/inventory');
	}

    public function item_index()
    {
    	return view($this->module_view_folder.'.item_index',$this->arr_view_data);
    }

    public function item_view()
    {
    	return view($this->module_view_folder.'.item_view',$this->arr_view_data);
    }

    public function stock_import_list()
    {
        return view($this->module_view_folder.'.stock_import_list',$this->arr_view_data);
    }

    public function stock_import_create()
    {
        return view($this->module_view_folder.'.stock_import_create',$this->arr_view_data);
    }

     public function stock_import_view()
    {
        return view($this->module_view_folder.'.stock_import_view',$this->arr_view_data);
    }

    public function stock_export()
    {
        return view($this->module_view_folder.'.stock_export',$this->arr_view_data);
    }

    public function stock_export_create()
    {
        return view($this->module_view_folder.'.stock_export_create',$this->arr_view_data);
    }

    public function stock_export_view()
    {
        return view($this->module_view_folder.'.stock_export_view',$this->arr_view_data);
    }

     public function vendor_setting()
    {
        return view($this->module_view_folder.'.vendor_setting',$this->arr_view_data);
    }

     public function loss_adjustment()
    {
        return view($this->module_view_folder.'.loss_adjustment',$this->arr_view_data);
    }

     public function loss_adjustment_create()
    {
        return view($this->module_view_folder.'.loss_adjustment_create',$this->arr_view_data);
    }

      public function warehouse_history()
    {
        return view($this->module_view_folder.'.warehouse_history',$this->arr_view_data);
    }

     public function inventory_report()
    {
        return view($this->module_view_folder.'.inventory_report',$this->arr_view_data);
    }

     public function inventory_setting()
    {
        return view($this->module_view_folder.'.inventory_setting',$this->arr_view_data);
    }

    public function trak_list()
    {
        return view($this->module_view_folder.'.trak_list',$this->arr_view_data);
    }

    public function cube_index()
    {// dd(1230);
        return view($this->module_view_folder.'.cube_index',$this->arr_view_data);
    }

    public function payroll(){
        return view($this->module_view_folder.'.payroll',$this->arr_view_data);
    }
    
    public function payroll1(){
        return view($this->module_view_folder.'.payroll1',$this->arr_view_data);
    }
    
    public function payroll2(){
        return view($this->module_view_folder.'.payroll2',$this->arr_view_data);
    }
    
    public function payroll3(){
        return view($this->module_view_folder.'.payroll3',$this->arr_view_data);
    }
    
    public function payroll4(){
        return view($this->module_view_folder.'.payroll4',$this->arr_view_data);
    }
    


}

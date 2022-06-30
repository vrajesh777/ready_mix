<?php 

namespace App\Common\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Validator;

trait MultiActionTrait
{
    public function multi_action(Request $request)
    {
        $arr_rules                   = [];
        $arr_rules['multi_action']   = "required";
        $arr_rules['checked_record'] = "required";

        $validator = Validator::make($request->all(),$arr_rules);

        if($validator->fails())
        {
            Session::flash('error','Please select '.$this->module_title.' to perform multi actions.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $multi_action   = $request->input('multi_action');
        $checked_record = $request->input('checked_record');

        /* Check if array is supplied*/
        if(is_array($checked_record) && sizeof($checked_record)<=0)
        {
            Session::flash('error','Problem occurred, while doing multi action.');
            return redirect()->back();
        }
        
        $success_cnt = 0;
        foreach ($checked_record as $key => $record_id) 
        {  
            if($multi_action=="delete" && $this->perform_delete(base64_decode($record_id)))
            {
                $success_cnt++;    
            } 
            elseif($multi_action=="activate" && $this->perform_activate(base64_decode($record_id)))
            {
               $success_cnt++;  
            }
            elseif($multi_action=="deactivate" && $this->perform_deactivate(base64_decode($record_id)))
            {
               $success_cnt++;
            }
        }

        if($success_cnt>0) {
            if($multi_action=="delete")
            {
               Session::flash('success',$this->module_title.' deleted successfully.'); 
            } 
            elseif($multi_action=="activate")
            {
               Session::flash('success',$this->module_title.' activated successfully.'); 
            }
            elseif($multi_action=="deactivate")
            {
               Session::flash('success',$this->module_title.' deactivated successfully.');  
            }
        }
        else{
            if($multi_action=="delete")
            {
               Session::flash('error','Problem occured while '.$this->module_title.' '.trans('admin.deletion')); 
            } 
            elseif($multi_action=="activate")
            {
               Session::flash('error','Problem occured while '.$this->module_title.' '.trans('admin.activation'));
            }
            elseif($multi_action=="deactivate")
            {
               Session::flash('error','Problem occured while '.$this->module_title.' '.trans('admin.deactivation'));
            }
        }
        return redirect()->back();
    }

    public function activate($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_activate(base64_decode($enc_id)))
        {
            Session::flash('success',$this->module_title.' activated successfully.');
        }
        else
        {
            Session::flash('error','Problem occured while '.$this->module_title.' activation');
        }

        return redirect()->back();
    }

    public function deactivate($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_deactivate(base64_decode($enc_id)))
        {
            Session::flash('success',$this->module_title.' deactivated successfully.');
        }
        else
        {
            Session::flash('error','Problem occured while '.$this->module_title.' deactivation');
        }

        return redirect()->back();
    }

    public function delete($enc_id = FALSE)
    {
        if(!$enc_id)
        {
            return redirect()->back();
        }

        if($this->perform_delete(base64_decode($enc_id)))
        {
            Session::flash('success',$this->module_title.' deleted successfully.');
        }
        else
        {
            Session::flash('error','Problem occured while '.$this->module_title.' deletion.');
        }

        return redirect()->back();
    }

    public function perform_activate($id)
    {  
        $obj_data = $this->BaseModel->where('id',$id)->first();
        
        if($obj_data)
        {

            return $obj_data->update(['is_active'=>'1']);
        }

        return FALSE;
    }

    public function perform_deactivate($id)
    {
        $obj_data = $this->BaseModel->where('id',$id)->first();
        
        if($obj_data)
        {
            return $obj_data->update(['is_active'=>'0']);
        }
        return FALSE;
    }

    public function perform_delete($id)
    {

        $delete= $this->BaseModel->where('id',$id)->delete();
        
        if($delete)
        {
            return TRUE;
        }

        return FALSE;
    }
}
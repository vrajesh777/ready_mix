<?php

namespace App\Common\Services;

use \Session;
use \Mail;
//use App\Models\SiteSettingModel;
use Exception;
use Illuminate\Support\Facades\Storage;

class EmailService
{
	public function __construct() 
	{
		//$this->SiteSettingModel = new SiteSettingModel();
	}

	public function send_mail($arr_mail_data = FALSE,$attachments=[])
	{
		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{   
			//$obj_site_setting = $this->SiteSettingModel->where('option_id',3)->first();
			$from_email = 'test.techallysolutions@gmail.com';//isset($obj_site_setting->option_value) ? $obj_site_setting->option_value:'';
        	$content    = view($arr_mail_data['email_template'],$arr_mail_data)->render();
        	$content    = html_entity_decode($content);

        	try {
        		if( isset($arr_mail_data['email']) && $arr_mail_data['email']!='' )
	        	{ 
	        		$send_mail = Mail::send(array(),array(),function($message) use($arr_mail_data,$content,$from_email,$attachments)
	        		{
				        $message->from($from_email,$arr_mail_data['template_from']);
				        $message->to($arr_mail_data['email']??'', $arr_mail_data['username'])
				                ->subject($arr_mail_data['subject'])
						        ->setBody($content,'text/html');
						if(!empty($attachments)) {
							foreach($attachments as $attach) {
								$message->attach($attach, [
									            'as' => basename($attach), 
									            'mime' => \Storage::mimeType(basename($attach))
									        ]);
							}
						}
			        });
	        		return true;
	        	}
        	} catch (Exception $e) {
        		return false;	
        	}
        	return false;
	    }
	    return false;    
	}

	public function send_mail_with_cc($arr_mail_data = FALSE)
	{ 
		if(isset($arr_mail_data) && sizeof($arr_mail_data)>0)
		{   
			//$obj_site_setting = $this->SiteSettingModel->first();
			$from_email = 'test.techallysolutions@gmail.com';//isset($obj_site_setting->option_value) ? $obj_site_setting->option_value:'';
			//$from_email       = isset($obj_site_setting->site_email_address) ? $obj_site_setting->site_email_address:'';
        	
        	$content  = view($arr_mail_data['email_template'],$arr_mail_data)->render();  	
        	
        	$content  = html_entity_decode($content);
        	
        	try {
        		if( isset($arr_mail_data['arr_email']) && sizeof($arr_mail_data['arr_email'])>=0 )
	        	{
	        		$send_mail = Mail::send(array(),array(),function($message) use($arr_mail_data,$content,$from_email)
		        		{
					        $message = $message->from($from_email,$arr_mail_data['template_from']);
					        $message = $message->to($arr_mail_data['arr_email']['email'], $arr_mail_data['username']);
							if ( isset($arr_mail_data['arr_email']['cc_email']) && sizeof( $arr_mail_data['arr_email']['cc_email'] ) > 0 ) {
								
								$message = $message->cc($arr_mail_data['arr_email']['cc_email']);	
							}						        
				            
				            $message->subject($arr_mail_data['subject'])
						    		->setBody($content,'text/html');
				        });

	        		return true;
	        	}
        	} catch (Exception $e) {
        		return false;	
        	}
        	return false;
	    }
	    return false;    
	}
}

?>
<?php

namespace App\Common\Services\ERP;

use Session;
use DB;

class ApiService
{
    public function __construct()
    {
      $this->endpoint   = "https://readymixerp.webtech.sa/accounts/modules/api/";
      //$this->endpoint = "http://localhost/accounts/modules/api/";
    }
    public function execute_curl($curl_url,$build_param)
    {
   
        $url = $this->endpoint.$curl_url;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => http_build_query($build_param),
          CURLOPT_HTTPHEADER =>  array(
          )
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
?> 
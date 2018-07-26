<?php
 

namespace App\Logging;
 
use Illuminate\Http\Request;


class LogService  
{
      
    private static $retriableErrorCodes = array(
        CURLE_COULDNT_RESOLVE_HOST,
        CURLE_COULDNT_CONNECT,
        CURLE_HTTP_NOT_FOUND,
        CURLE_READ_ERROR,
        CURLE_OPERATION_TIMEOUTED,
        CURLE_HTTP_POST_ERROR,
        CURLE_SSL_CONNECT_ERROR,
    );

 


    public function enviar(Request $request , array $record )
    {
        
        $record['ip'] = $request->server('REMOTE_ADDR');
        $record['host'] = $request->header('host');


        $postString = json_encode( $record );

 
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => env('LOG_SLACK_URL'), 
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => $postString
        );
        if (defined('CURLOPT_SAFE_UPLOAD')) {
            $options[CURLOPT_SAFE_UPLOAD] = true;
        }

        curl_setopt_array($ch, $options); 
        $this->execute($ch);
    }







    
    public function execute($ch)
    { 
        curl_exec($ch); 
        curl_close($ch); 
    }

   

 
}

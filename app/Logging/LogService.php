<?php
 

namespace App\Logging;
 
use Illuminate\Http\Request;
use Log;

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

 


    public static function enviar(Request $request , array $record )
    {
        
        $record['ip'] = $request->server('REMOTE_ADDR');
        $record['host'] = $request->header('host');


        $postString = json_encode( $record );
        Log::info('log service  jason ' .  $postString );
 
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
        curl_exec($ch); 
        curl_close($ch); 
    }





    public static function enviarQueue(  array $record )
    {

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
 
        
        // if (curl_exec($ch) === false) {
        //     $curlErrno = curl_errno($ch); 
        //     $curlError = curl_error($ch); 
        //     Log::info( sprintf('Curl error (code %s): %s', $curlErrno, $curlError) );
            
        //     curl_close($ch); 
        //     throw new \RuntimeException(sprintf('Curl error (code %s): %s', $curlErrno, $curlError));
        // }  else{ 
        //     curl_close($ch);  
        // }

 
        curl_exec($ch); 
        curl_close($ch); 


       
    }






    
    public static function execute($ch)
    { 
        curl_exec($ch); 
        curl_close($ch); 
    }

   

 
}

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

 


    public static function enviar(  array $record )
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

        $result = curl_exec($ch) ;
        if ( $result === false) {
            $curlErrno = curl_errno($ch); 
            $curlError = curl_error($ch); 
            Log::error( sprintf('Curl error (code %s): %s', $curlErrno, $curlError) );
            curl_close($ch); 
        }  else{ 
            $resultJson = json_decode( $result );  
            if( isset($resultJson->error)  ){
                Log::warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
        }

    }


 
}

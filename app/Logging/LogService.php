<?php
 

namespace App\Logging;

// use Monolog\Formatter\FormatterInterface;
// use Monolog\Logger;
// use Monolog\Handler\Slack\SlackRecord;
 
class LogService  
{
     
    //private $webhookUrl;
 
    //private $slackRecord;

    private static $retriableErrorCodes = array(
        CURLE_COULDNT_RESOLVE_HOST,
        CURLE_COULDNT_CONNECT,
        CURLE_HTTP_NOT_FOUND,
        CURLE_READ_ERROR,
        CURLE_OPERATION_TIMEOUTED,
        CURLE_HTTP_POST_ERROR,
        CURLE_SSL_CONNECT_ERROR,
    );


    // public function __construct( $webhookUrl )
    // {  
    //     $this->webhookUrl = $webhookUrl; 
    // }


    public function enviar(array $record)
    {
        // $postData = $this->slackRecord->getSlackData($record);
        // $postString = json_encode($postData);
        $postString = json_encode( $record );

 
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => env('LOG_SLACK_URL'),
            //CURLOPT_URL => $this->webhookUrl,
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

 
    public function execute_ori($ch, $retries = 1, $closeAfterDone = true)
    {
        while ($retries--) {
            if (curl_exec($ch) === false) {
                $curlErrno = curl_errno($ch);

                if (false === in_array($curlErrno, self::$retriableErrorCodes, true) || !$retries) {
                    $curlError = curl_error($ch);

                    if ($closeAfterDone) {
                        curl_close($ch);
                    }

                    throw new \RuntimeException(sprintf('Curl error (code %s): %s', $curlErrno, $curlError));
                }

                continue;
            }

            if ($closeAfterDone) {
                curl_close($ch);
            }
            break;
        }
    }


 
 


 

 
}

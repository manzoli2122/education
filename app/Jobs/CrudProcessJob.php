<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log; 



class CrudProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $model ;
    protected $dados ; 
    protected $acao ; 
    protected $info ; 
    protected $data ; 


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(  string $model , string $acao ,  $dados  ,  $info , $data )  
    {
        $this->model = $model; 
        $this->dados = $dados; 
        $this->info = $info; 
        $this->acao = $acao;  
        $this->data = $data;   
    }





    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->enviarLogParaElasticSearch(   
            [ 
                'acao' => $this->acao , 
                'model' => $this->model ,     
                'dados' => $this->dados ,     
                'info' =>  $this->info, 
                'data' => $this->data ,     
            ] 
        )  ;
    }




    public static function enviarLogParaElasticSearch(  array $record )
    { 
        $postString = json_encode( $record );  
        $ch = curl_init();
        $options = array(
            CURLOPT_URL => env('LOG_ELASTIC_SEARCH_URL'), 
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
            Log::channel('elastic')->error( sprintf('Curl error (code %s): %s', $curlErrno, $curlError) ); 
            curl_close($ch); 
        }  else{ 
            $resultJson = json_decode( $result );  
            if( isset($resultJson->error)  ){
                Log::channel('elastic')->warning( 'Error de inserção de dados no elastic -> ' .  $result . ' Dados -> ' .  $postString );
            }
            curl_close($ch);  
        } 
    }


    
}

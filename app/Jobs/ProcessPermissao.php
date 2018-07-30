<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Security\Permissao ;
use App\Logging\LogService;
use Log;


class ProcessPermissao implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $permissao ;
    protected $logservice ; 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( Permissao $permissao  , LogService $servicelog )
    {
        $this->permissao = $permissao;  
        $this->logservice = $servicelog; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       // $str = implode("", $this->permissao->toArray() );
        //Log::info( $str );
        $this->logservice->enviarQueue(   
                    [ 
                         'acao' => 'Criar', 
                         'teste' => $this->permissao ,  
                         
                    ] 
                )  ;

         



        // $record =   [ 
        //                 'acao' => 'Criar', 
        //                 'model' => $this->permissao ,  
        //                 'id3' => 'manza'
        //             ] ;


 

        // $postString = json_encode( $record );
        //  Log::info('record  jason ' .  $postString );
 
        // $ch = curl_init();
        // $options = array(
        //     CURLOPT_URL => env('LOG_SLACK_URL'), 
        //     CURLOPT_POST => true,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_HTTPHEADER => array('Content-type: application/json'),
        //     CURLOPT_POSTFIELDS => $postString
        // );
        // if (defined('CURLOPT_SAFE_UPLOAD')) {
        //     $options[CURLOPT_SAFE_UPLOAD] = true;
        // }

        // curl_setopt_array($ch, $options);  
        // curl_exec($ch); 
        // curl_close($ch); 
        // Log::info('teste log curl permissao');

        // foreach ($this->permissao as $key => $value) {
        //    Log::info('teste log curl permissao ' . $value );
        // }
        



       
 

    }
}

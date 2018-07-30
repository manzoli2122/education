<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Logging\LogService;

class CrudProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $model ;
    protected $dados ;
    protected $logservice ; 
    protected $acao ; 
    protected $info ; 
    protected $data ; 


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( LogService $servicelog ,  string $model , string $acao ,  $dados  ,  $info , $data )
    {
        $this->model = $model; 
        $this->dados = $dados; 
        $this->info = $info; 
        $this->acao = $acao;  
        $this->data = $data;  
        $this->logservice = $servicelog;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->logservice->enviarQueue(   
            [ 
                'acao' => $this->acao , 
                'model' => $this->model ,     
                'dados' => $this->dados ,     
                'info' =>  $this->info, 
                'data' => $this->data ,    
                'criado' => now() ,    
            ] 
        )  ;
    }
}

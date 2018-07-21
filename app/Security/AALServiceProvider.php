<?php 

namespace App\Security;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AALServiceProvider extends ServiceProvider
{
    
    protected $defer = false;

    //protected $namespace = 'Manzoli2122\AAL\Http\Controllers'  ;
    
    public function boot()
    { 
        //$this->mapWebRoutes(); 
        // Register blade directives
        $this->bladeDirectives(); 
    }

   
    /* 
    private function mapWebRoutes()
    {        
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(__DIR__.'/Http/routes.php');
    } 
    */


    public function register()
    {
        $this->registerAAL();  
    }

    


    private function bladeDirectives()
    {
        if (!class_exists('\Blade')) return;

       
        \Blade::directive('perfil', function($expression) {
            return "<?php if (\\AAL::hasPerfil({$expression})) : ?>";
        });

        \Blade::directive('endperfil', function($expression) {
            return "<?php endif; // AAL::hasPerfil ?>";
        });

         
        \Blade::directive('permissao', function($expression) {
            return "<?php if (\\AAL::can({$expression})) : ?>";
        });

        \Blade::directive('endpermissao', function($expression) {
            return "<?php endif; // AAL::can ?>";
        });
 
/*
        \Blade::directive('ability', function($expression) {
            return "<?php if (\\AAL::ability({$expression})) : ?>";
        });

        \Blade::directive('endability', function($expression) {
            return "<?php endif; // AAL::ability ?>";
        });

*/ 
    }
 


    private function registerAAL()
    {
        $this->app->bind('aal', function ($app) {
            return new AAL($app);
        }); 
        $this->app->alias('aal', 'App\Security\AAL');
    }

    

}

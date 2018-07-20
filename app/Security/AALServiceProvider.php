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
        // Publish config files
        //$this->publishes([
        //    __DIR__.'/../config/config.php' =>  config_path('aal.php'), 
        //], 'autorizacao_config');

        //$this->mapWebRoutes();
        
        // Register commands
        //$this->commands('command.aal.migration');

        // Register blade directives
        $this->bladeDirectives();


       // $this->publishes([
       //     __DIR__.'/Views/Assets' => public_path('vendor/autorizacao'),
       // ], 'autorizacao_public');



       // $this->loadViewsFrom(__DIR__.'/Views', 'autorizacao');

/*
        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/autorizacao'),
        ]);
*/

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

        //$this->registerCommands();

        //$this->mergeConfig();
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

   




/*
    private function registerCommands()
    {
        $this->app->singleton('command.aal.migration', function ($app) {
            return new MigrationCommand();
        });
    }
*/
   



/*
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'aal'
        );
    }
*/
   


/*
    public function provides()
    {
        return [
            'command.aal.migration'
        ];
    }
*/

}

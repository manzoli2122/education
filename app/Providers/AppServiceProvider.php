<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Service\VueServiceInterface',
            'App\Service\VueService'
        );
  
        $this->app->bind(
            'App\Service\Seguranca\PermissaoServiceInterface',
            'App\Service\Seguranca\PermissaoService'
        );

        $this->app->bind(
            'App\Service\Seguranca\PerfilServiceInterface',
            'App\Service\Seguranca\PerfilService'
        );

        $this->app->bind(
            'App\Service\Seguranca\UsuarioServiceInterface',
            'App\Service\Seguranca\UsuarioService'
        );

    }
}

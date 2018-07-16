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
            'App\Service\DisciplinaServiceInterface',
            'App\Service\DisciplinaService'
        );

        $this->app->bind(
            'App\Service\Security\PermissaoServiceInterface',
            'App\Service\Security\PermissaoService'
        );

        $this->app->bind(
            'App\Service\Security\PerfilServiceInterface',
            'App\Service\Security\PerfilService'
        );



    }
}

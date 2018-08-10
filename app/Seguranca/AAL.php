<?php 

namespace App\Seguranca;

class AAL
{
   
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
  


    public function hasPerfil($perfil, $requireAll = false)
    {
        if ($usuario = $this->usuario()) {
            return $usuario->hasPerfil($perfil, $requireAll);
        }
        return false;
    }




    public function can($permissao, $requireAll = false)
    {
        if ($usuario = $this->usuario()) {
            return $usuario->can($permissao, $requireAll);
        }
        return false;
    }

    

 



    public function usuario()
    {
        return $this->app->auth->user();
    }

       




    public function routeNeedsPerfil($route, $perfis, $result = null, $requireAll = true)
    {
        $filterName  = is_array($perfis) ? implode('_', $perfis) : $perfis;
        $filterName .= '_'.substr(md5($route), 0, 6); 
        $closure = function () use ($perfis, $result, $requireAll) {
            $hasPerfil = $this->hasPerfil($perfis, $requireAll); 
            if (!$hasPerfil) {
                return empty($result) ? $this->app->abort(403) : $result;
            }
        }; 
        // Same as Route::filter, registers a new filter
        $this->app->router->filter($filterName, $closure); 
        // Same as Route::when, assigns a route pattern to the
        // previously created filter.
        $this->app->router->when($route, $filterName);
    }

    





    public function routeNeedsPermissao($route, $permissoes, $result = null, $requireAll = true)
    {
        $filterName  = is_array($permissoes) ? implode('_', $permissoes) : $permissoes;
        $filterName .= '_'.substr(md5($route), 0, 6); 
        $closure = function () use ($permissoes, $result, $requireAll) {
            $hasPerm = $this->can($permissoes, $requireAll); 
            if (!$hasPerm) {
                return empty($result) ? $this->app->abort(403) : $result;
            }
        }; 
        // Same as Route::filter, registers a new filter
        $this->app->router->filter($filterName, $closure); 
        // Same as Route::when, assigns a route pattern to the
        // previously created filter.
        $this->app->router->when($route, $filterName);
    }

  
    



    public function routeNeedsPerfilOrPermissao($route, $perfis, $permissoes, $result = null, $requireAll = false)
    {
        $filterName  =      is_array($perfis)       ? implode('_', $perfis)       : $perfis;
        $filterName .= '_'.(is_array($permissoes) ? implode('_', $permissoes) : $permissoes);
        $filterName .= '_'.substr(md5($route), 0, 6); 
        $closure = function () use ($perfis, $permissoes, $result, $requireAll) {
            $hasPerfil  = $this->hasPerfil($perfis, $requireAll);
            $hasPermissao = $this->can($permissoes, $requireAll); 
            if ($requireAll) {
                $hasPerfilPerm = $hasPerfil && $hasPermissao;
            } else {
                $hasPerfilPerm = $hasPerfil || $hasPermissao;
            } 
            if (!$hasPerfilPerm) {
                return empty($result) ? $this->app->abort(403) : $result;
            }
        }; 
        // Same as Route::filter, registers a new filter
        $this->app->router->filter($filterName, $closure); 
        // Same as Route::when, assigns a route pattern to the
        // previously created filter.
        $this->app->router->when($route, $filterName);
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use InvalidArgumentException;
use Cache;  

class User extends Authenticatable
{

    use Notifiable;


    private $cacheKey = 'todos_perfis_para_usuario_' ;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',   'deleted_at' ,  'updated_at' ,  'created_at' , 'pivot'
    ];
 

    public function log( )
    {
        return [
            'usuario' => [ 
                'id' => $this->id,
                 'name' => $this->name , 
                 'email' => $this->email , 
            ]       
        ];
    }

    /**
    * Busca os perfis do usuario no banco de dados
    * 
    * @return Query $query
    */
    public function perfis()
    {
        return $this->belongsToMany('App\Models\Security\Perfil','perfils_users', 'user_id', 'perfil_id');
    }





    /**
     * Buscar os usuarios para exibir na datatable
     * 
     * @return Query $query
     */
    public function getDatatable()
    {
        return $this->select(['id', 'name', 'email'  ]);        
    }

 

 
 
     /**
     * Save  
     *
     * @param mixed $inputPermissions
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($usuario) {
            if (!method_exists( 'App\User' , 'bootSoftDeletes')) {
                $usuario->perfis()->sync([]);
            }
            return true;
        });
    }



     /**
     * Busca os perfis do usuario na cache ou 
     * caso ainda não tenha no banco de dados e salva na Cache
     * 
     * @return Json $perfis
     */
    public function cachedPerfis()
    {

        $cacheKey = $this->cacheKey . $this->id; 
        $value = Cache::rememberForever(  $cacheKey , function () {
            return collect(['perfis' => $this->perfis()->select('nome')->get()->pluck('nome')])->toJson() ;        
        }); 
        return $value ;
    }




    /**
     * Atualizar a cache com os perfis do usuario
     * 
     * @return void
     */
    public function cachedPerfisAtualizar()
    {
        $cacheKey = $this->cacheKey . $this->id;
        Cache::forget($cacheKey);
        $this->cachedPerfis();
    }
    

 
    




    /**
    * Verifica se um usuario tem deternmindo perfil  
    *
    * @param array/String   $name
    *
    * @param boolean  $requireAll
    *
    * @return boolean 
    */
    public function hasPerfil($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $perfilName) {
                $hasPerfil = $this->hasPerfil($perfilName);

                if ($hasPerfil && !$requireAll) {
                    return true;
                } elseif (!$hasPerfil && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            $perfis  = json_decode($this->cachedPerfis())->perfis;            
            foreach ($perfis as $perfil) {
                if ( str_is( $perfil, $name )  ) {
                    return true;
                }
            }
        }
        return false;
    }

   
    




    /**
    * Verifica se um usuario possui uma ou um conjunto de permissoes 
    * Caso tenha o perfil Admin retorna true
    *  
    * @param array/String   $name
    *
    * @param boolean  $requireAll
    * 
    * @return boolean
    */
    public function can($permissao, $requireAll = false)
    {   
        if($this->hasPerfil('Admin')){
            return true;
        } 
        if (is_array($permissao)) {
            foreach ($permissao as $permName) {
                $hasPerm = $this->can($permName); 
                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->perfis as $perfil) { 
                if($perfil->hasPermissao($permissao) ){
                    return true;
                }
            }
        }
        return false;
    }

    


    

    /**
    * Atrela um perfil a um usuario e atualiza a cache
    *
    * @param int/object $perfil
    *
    * @return void
    */
    public function attachPerfil($perfil)
    {
        if(is_object($perfil)) {
            $perfil = $perfil->getKey();
        }
        $this->perfis()->attach($perfil);
        $this->cachedPerfisAtualizar();
    }

    
    
    



    /**
    * Save  
    *
    * @param mixed $inputPermissions
    *
    * @return void
    */
    public function detachPerfil($perfil)
    {
        if (is_object($perfil)) {
            $perfil = $perfil->getKey();
        }
        $this->perfis()->detach($perfil);
        $this->cachedPerfisAtualizar();
    }

    
}

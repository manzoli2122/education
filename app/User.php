<?php

namespace App;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Cache\TaggableStore;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;
use Cache;  
use Log;
use DB;
 

class User extends Authenticatable  implements JWTSubject
{

    use Notifiable;

    public static $cacheTag = 'usuario';

    private $cacheKey = 'todos_perfis_para_usuario_' ;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id', 'rg', 'nf', 'quadro_dsc', 'post_grad_dsc', 'ome_qdi_id', 
        'ome_qdi_dsc', 'ome_qdi_lft', 'ome_qdi_rgt', 'status','obs',
        

    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',   'deleted_at' ,  'updated_at' ,  'created_at' , 'pivot'
    ];

    protected $casts = [
        'id' => 'string' ,
    ];


    



   




    public function log( )
    {
        return [
            'usuario' => [ 
                'cpf' => $this->id,
                'name' => $this->name , 
                'rg' => $this->rg , 
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
    * 
    * @return Query $query
    */
    public function mailable()
    {
        return $this->belongsToMany('App\Models\Mailable','users_mailable', 'user_id', 'mailable_id');
    }


    /**
     * FIX-ME ADICIONAR CACHE
    * Verifica se um usuario tem deternmindo perfil  
    *
    * @param array/String   $name
    *
    * @param boolean  $requireAll
    *
    * @return boolean 
    */
    public function hasMailable($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $mailName) {
                $hasMailable = $this->hasMailable($mailName);

                if ($hasMailable && !$requireAll) {
                    return true;
                } elseif (!$hasMailable && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            $mailables  = json_decode(collect(['mailable' => $this->mailable()->select('nome')->get()->pluck('nome')])->toJson())->mailable; 
            foreach ($mailables as $mailable) {
                if ( str_is( $mailable, $name )  ) {
                    return true;
                }
            }
        }
        return false;
    }



     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    

    /**
     * Buscar os usuarios para exibir na datatable
     * 
     * @return Query $query
     */
    public function getDatatable()
    {
        return $this->withoutGlobalScope('ativo')
                    ->select([
                        'id', 'name' ,'rg' , 'post_grad_dsc' , 'ome_qdi_dsc' , 
                        //DB::raw('status AS status'),
                        DB::raw("CASE status      
                                     WHEN 'A' THEN 'Ativo'      
                                     WHEN 'I' THEN 'Inativo' 
                                  END AS status "),
                        //'status' 
                    ]);        
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

        static::addGlobalScope('ativo', function (Builder $builder) {
            $builder->where('status', 'A');
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
        if(Cache::getStore() instanceof TaggableStore){ 
            $value = Cache::tags( User::$cacheTag )->rememberForever(  $cacheKey , function () {
                return collect(['perfis' => $this->perfis()->select('nome')->get()->pluck('nome')])->toJson() ;        
            }); 
        }
        else{
            $value = Cache::rememberForever(  $cacheKey , function () {
                return collect(['perfis' => $this->perfis()->select('nome')->get()->pluck('nome')])->toJson() ;        
            });  
        }  
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
        if(Cache::getStore() instanceof TaggableStore){
            Cache::tags( User::$cacheTag )->forget($cacheKey);
        }
        else{
            Cache::forget($cacheKey);
        }   
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

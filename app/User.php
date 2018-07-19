<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Config;
use InvalidArgumentException;
use Cache;

use DB;

class User extends Authenticatable
{
    use Notifiable;

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
        'password', 'remember_token',   'deleted_at' ,     'updated_at' ,  'created_at' , 'pivot'
    ];
 




    
    //====================================================================================
    
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




    public function cachedPerfis()
    {
        $usuarioPrimaryKey = $this->primaryKey;
        $cacheKey = 'todos_perfis_para_usuario_'.$this->$usuarioPrimaryKey;

        $value = Cache::rememberForever(  $cacheKey , function () {
            return    collect([ 'perfis' => $this->perfis()->select('nome')->get()->pluck('nome')  ]) ->toJson() ;            
        });
        return $value ;
    }

    


    public function getDatatable()
    {
        return $this->select(['id', 'name', 'email'  ]);        
    }
    


    public function save(array $options = [])
    {   //both inserts and updates
        /*if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.perfil_usuario_table'))->flush();
        }*/
        return parent::save($options);
    }

  
    




    public function delete(array $options = [])
    {   //soft or hard
        $result = parent::delete($options);
       /* if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.perfil_usuario_table'))->flush();
        }*/
        return $result;
    }

    
    





    public function restore()
    {   //soft delete undo's
        $result = parent::restore();
        /*if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.perfil_usuario_table'))->flush();
        }*/
        return $result;
    }

    
   
    





    public function perfis()
    {
        return $this->belongsToMany('App\Models\Perfil','perfils_users', 'user_id', 'perfil_id');
    }


    
    
    public function getPerfilDatatable($id)
    { 
        return DB::table('perfils')->join('perfils_users', 'perfils.id', '=', 'perfils_users.perfil_id')
                ->where('perfils_users.user_id' , $id )
                ->select([ 'perfils.id', 'perfils.nome', 'perfils.descricao' ]); 
    }
    




   
    public function usuarios_sem_perfil($perfil_id)
    {
        return $this->whereNotIn('id', function($query) use ($perfil_id){
            $query->select("perfils_users.user_id");
            $query->from("perfils_users");
            $query->whereRaw("perfils_users.perfil_id = {$perfil_id} ");
        } )
        ->orderBy('name')
        ->get();       
        
    }
    



    
    
    





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

   
    

 
    
    



    public function attachPerfil($perfil)
    {
        if(is_object($perfil)) {
            $perfil = $perfil->getKey();
        }
        $this->perfis()->attach($perfil);
    }

    
    



    public function detachPerfil($perfil)
    {
        if (is_object($perfil)) {
            $perfil = $perfil->getKey();
        }
        $this->perfis()->detach($perfil);
    }

   
    





    public function attachPerfis($perfis)
    {
        foreach ($perfis as $perfil) {
            $this->attachPerfil($perfil);
        }
    }

   
    




    public function detachPerfis($perfis=null)
    {
        if (!$perfis) $perfis = $this->perfis()->get();

        foreach ($perfis as $perfil) {
            $this->detachPerfil($perfil);
        }
    }

    
    



    public function scopeWithPerfil($query, $perfil)
    {
        return $query->whereHas('perfis', function ($query) use ($perfil)
        {
            $query->where('name', $perfil);
        });
    }

}

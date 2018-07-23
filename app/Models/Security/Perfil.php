<?php

namespace App\Models\Security;

use Cache; 
use Illuminate\Database\Eloquent\Model; 

class Perfil extends Model
{    
    
    private $cacheKey = 'todas_permissoes_para_perfil_' ;


    protected $table = 'perfils'; 
 

    
    protected $fillable = [
            'nome', 'descricao', 
    ];


    protected $hidden = [
        'deleted_at' ,     'updated_at' ,  
    ];
        

    public function rules($id = '')
    {
            return [
                'nome' => 'required|min:3|max:100',
                'descricao' => "required|min:1|max:150",     
            ];
    }
 

    public function permissoes()
    {
        return $this->belongsToMany( 'App\Models\Security\Permissao', 'permissao_perfils', 'perfil_id', 'permissao_id');
    }

    
    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'perfils_users', 'perfil_id', 'user_id' );
    }


    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }
    

 


     
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($perfil) {
            if (!method_exists( 'App\Models\Security\Perfil' , 'bootSoftDeletes')) {
                $perfil->usuarios()->sync([]);
                $perfil->permissoes()->sync([]);
            }
            return true;
        });
    }
    
   
    
    public function cachedPermissoes()
    { 
        $cacheKey = $this->cacheKey . $this->id;                    
        $value = Cache::rememberForever(  $cacheKey , function () {
            return collect(['permissoes' => $this->permissoes()->select('nome')->get()->pluck('nome')])->toJson(); 
        });
        return $value ;
    }





     /**
     * Atualizar a cache com os perfis do usuario
     * 
     * @return void
     */
    public function cachedPermissoesAtualizar()
    {
        $cacheKey = $this->cacheKey . $this->id;
        Cache::forget($cacheKey);
        $this->cachedPermissoes();
    }
    
  
 


    public function perfisParaAdicionarAoUsuario( $usuario_id, $isAdmin = false)
    {
        if($isAdmin){
            return $this->whereNotIn('id', function($query) use ($usuario_id){
                $query->select("perfils_users.perfil_id");
                $query->from("perfils_users");
                $query->whereRaw("perfils_users.user_id = {$usuario_id} ");
            })
            ->orderBy('nome')->get();  
        } 

        return $this->whereNotIn('id', function($query) use ($usuario_id){
                    $query->select("perfils_users.perfil_id");
                    $query->from("perfils_users");
                    $query->whereRaw("perfils_users.user_id = {$usuario_id} ");
                })
                ->where('nome', '<>' , 'Admin')
                ->orderBy('nome')->get(); 
    }




    

    public function hasPermissao($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $permissaoName) {
                $hasPermissao = $this->hasPermissao($permissaoName);
                if ($hasPermissao && !$requireAll) {
                    return true;
                } elseif (!$hasPermissao && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            $permissoes  = json_decode($this->cachedPermissoes())->permissoes;            
            foreach ($permissoes as $permissao) {
                if ( str_is( $permissao, $name )  ) {
                    return true;
                }
            }
        }
        return false;
    }

    

    



    public function attachPermissao($permissao)
    {
        if (is_object($permissao)) {
            $permissao = $permissao->getKey();
        }
        $this->permissoes()->attach($permissao);
        $this->cachedPermissoesAtualizar();
    }

    



    public function detachPermissao($permissao)
    {
        if (is_object($permissao)) {
            $permissao = $permissao->getKey();
        }
        $this->permissoes()->detach($permissao);
        $this->cachedPermissoesAtualizar();
    }

   

 




  /*
   
    public function attachPermissoes($permissoes)
    {
        foreach ($permissoes as $permissao) {
            $this->attachPermission($permissao);
        }
    }
   
    public function detachPermissoes($permissoes = null)
    {
        if (!$permissoes) $permissoes = $this->permissoes()->get();
        foreach ($permissoes as $permissao) {
            $this->detachPermissao($permissao);
        }
    }
 
    public function savePermissoes($inputPermissoes)
    {
        if (!empty($inputPermissoes)) {
            $this->permissoes()->sync($inputPermissoes);
        } else {
            $this->permissoes()->detach();
        } 
    }
 
    public function perfils_sem_permissao($permissao_id)
    {
        return $this->whereNotIn('id', function($query) use ($permissao_id){
            $query->select("permissao_perfils.perfil_id");
            $query->from("permissao_perfils");
            $query->whereRaw("permissao_perfils.permissao_id = {$permissao_id} ");
        } )
        ->orderBy('nome')
        ->get();   
    }
  
    public function attachUsuario($usuario)
    {
        if (is_object($usuario)) {
            $usuario = $usuario->getKey();
        }
        $this->usuarios()->attach($usuario);
    }
 
    public function detachUsuario($usuario)
    {
        if (is_object($usuario)) {
            $usuario = $usuario->getKey();
        }
        $this->usuarios()->detach($usuario);
    }

    public function attachUsuarios($usuarioa)
    {
        foreach ($usuarios as $usuario) {
            $this->attachUsuario($usuario);
        }
    }
 
    public function detachUsuarios($usuarios = null)
    {
        if (!$usuarios) $usuarios = $this->permissoes()->get();
        foreach ($usuarios as $usuario) {
            $this->detachUsuario($usuario);
        }
    }

*/
 


}

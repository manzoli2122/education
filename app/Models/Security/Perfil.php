<?php

namespace App\Models\Security;

use Cache; 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Cache\TaggableStore; 


class Perfil extends Model
{    

    public static $cacheTag = 'perfis';



    
    private $cacheKey = 'todas_permissoes_para_perfil_' ;


    protected $table = 'perfils'; 
 

    
    protected $fillable = [
            'nome', 'descricao', 
    ];


    protected $hidden = [
        'deleted_at' ,     'updated_at' ,  
    ];
        

    public function log( )
    {
        return [
            'perfil' => [ 
                'id' => $this->id,
                 'nome' => $this->nome , 
                // 'descricao' => $this->descricao , 
            ]       
        ];
    }


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
        if(Cache::getStore() instanceof TaggableStore){
            $value = Cache::tags( Perfil::$cacheTag )->rememberForever(  $cacheKey , function () {
                return collect(['permissoes' => $this->permissoes()->select('nome')->get()->pluck('nome')])->toJson(); 
            });
        }
        else{
            $value = Cache::rememberForever(  $cacheKey , function () {
                return collect(['permissoes' => $this->permissoes()->select('nome')->get()->pluck('nome')])->toJson(); 
            });
        } 
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
        if(Cache::getStore() instanceof TaggableStore){
            Cache::tags(Perfil::$cacheTag)->forget($cacheKey);
        }
        else{
            Cache::forget($cacheKey);
        }         
        $this->cachedPermissoes();
    }
    
  
 


    public function perfisParaAdicionarAoUsuario( string $usuario_id, $isAdmin = false)
    {
        if($isAdmin){
            return $this->whereNotIn('id', function($query) use ($usuario_id){
                $query->select("perfils_users.perfil_id");
                $query->from("perfils_users");
                $query->whereRaw("perfils_users.user_id = '{$usuario_id}' ");
            })
            ->orderBy('nome')->get();  
        } 

        return $this->whereNotIn('id', function($query) use ($usuario_id){
                    $query->select("perfils_users.perfil_id");
                    $query->from("perfils_users");
                    $query->whereRaw("perfils_users.user_id = '{$usuario_id}' ");
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
 
 

}

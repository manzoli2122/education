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
        




    /**
     * retorna um array dos dados para gravar em log
     *
     * @return $array
     */
    public function log( )
    {
        return [
            'perfil' => [ 
                'id' => $this->id,
                 'nome' => $this->nome , 
                 'descricao' => $this->descricao , 
            ]       
        ];
    }





    /**
     * Retorna as regras de validações para cadastro e atualização
     *
     * @return $rules
     */
    public function rules($id = '')
    {
            return [
                'nome' => 'required|min:3|max:100',
                'descricao' => "required|min:1|max:150",     
            ];
    }
 




    /**
     * Retorna as permissoes de um perfil.
     *
     * @return $permissoes
     */
    public function permissoes()
    {
        return $this->belongsToMany( 'App\Models\Security\Permissao', 'permissao_perfils', 'perfil_id', 'permissao_id');
    }






    /**
     * Retorna os usuarios que possui o perfil.
     *
     * @return $usuarios
     */
    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'perfils_users', 'perfil_id', 'user_id' );
    }






    /**
     * Funcao para auxiliar o datatable de listar os perfis.
     *
     * @return $perfis
     */
    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }
    



 

    /**
     * Exclui a cache do perfil no caso de exclusão do mesmo  
     */
    public function delete()
    {
        $cacheKey = $this->cacheKey . $this->id;
        if(Cache::getStore() instanceof TaggableStore){
            Cache::tags(Perfil::$cacheTag)->forget($cacheKey);
        }
        else{
            Cache::forget($cacheKey);
        }  
        return parent::delete();      
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
    
   





    /**
     * Busca as permissoes de um perfil
     * primeiramente na cache, caso não tenha no banco de dados e salva na cache.
     *
     * @return $permissoes
     */
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
    
  
 



    /**
     * Busca os perfis que um usuario não possui.
     *
     * @return $perfis
     */
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






    
    /**
     * Verifica se um perfil possui uma permissão ou um conjunto delas 
     *
     * @return $bool
     */
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

    

    


    /**
     * Atrela uma permissao ao perfil.
     *
     * @return void
     */
    public function attachPermissao($permissao)
    {
        if (is_object($permissao)) {
            $permissao = $permissao->getKey();
        }
        $this->permissoes()->attach($permissao);
        $this->cachedPermissoesAtualizar();
    }

    





    /**
     * remove uma permissao de um perfil.
     *
     * @return $permissoes
     */
    public function detachPermissao($permissao)
    {
        if (is_object($permissao)) {
            $permissao = $permissao->getKey();
        }
        $this->permissoes()->detach($permissao);
        $this->cachedPermissoesAtualizar();
    }
 
 

}

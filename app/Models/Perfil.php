<?php

namespace App\Models;

use Cache;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use DB;

class Perfil extends Model
{    

     

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
                'descricao' => "required|min:0|max:150",     
            ];
    }


    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }
    


    
    public function getPermissaoDatatable($id)
    { 
        return DB::table('permissoes')->join('permissao_perfils', 'permissoes.id', '=', 'permissao_perfils.permissao_id')
                ->where('permissao_perfils.perfil_id' , $id )
                ->select([ "permissoes.id", "permissoes.nome", "permissoes.descricao" ]); 
    }



    /**
    *  Busca Os perfis de unm determinado usuario para exibir no datatable
    *
    * @param int $user_Id
    *
    * @return void
   
    public function getPerfilDatatable($user_Id)
    { 
        return $this->with('usuarios')->selectRaw('distinct perfils.*') 
                ->where('users.id' , $user_Id );
                //->select([ "{$this->table}.id", "{$this->table}.nome", "{$this->table}.descricao" ]);   
        

        return $this->join('perfils_users', 'perfils.id', '=', 'perfils_users.perfil_id')
                ->where('perfils_users.user_id' , $user_Id )
                ->select([ "{$this->table}.id", "{$this->table}.nome", "{$this->table}.descricao" ]); 
    }
    

     public function getPerfilDatatable_ori($user_Id)
    { 
        return $this->join('perfils_users', 'perfils.id', '=', 'perfils_users.perfil_id')
                ->where('perfils_users.user_id' , $user_Id )
                ->select([ "{$this->table}.id", "{$this->table}.nome", "{$this->table}.descricao" ]); 
    }

 */


    //===========================================================================
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($perfil) {
            if (!method_exists( 'App\Models\Perfil' , 'bootSoftDeletes')) {
                $perfil->usuarios()->sync([]);
                $perfil->permissoes()->sync([]);
            }
            return true;
        });
    }
    
   
    
    public function cachedPermissoes()
    {
        $perfilPrimaryKey = $this->primaryKey;
        $cacheKey = 'todas_permissoes_para_perfil_' . $this->$perfilPrimaryKey;   
                  
        $value = Cache::rememberForever(  $cacheKey , function () {
            return    collect([ 'permissoes' => $this->permissoes()->select('nome')->get()->pluck('nome')  ]) ->toJson() ;            
            //return json_encode(array('permissoes' => array_pluck( json_decode( $this->permissoes()->select('nome')->get() ) , 'nome'  ))) ;
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
        $perfilPrimaryKey = $this->primaryKey;
        $cacheKey = 'todas_permissoes_para_perfil_' . $this->$perfilPrimaryKey;
        Cache::forget($cacheKey);
        $this->cachedPermissoes();
    }
    





    public function save(array $options = [])
    {   //both inserts and updates
        if (!parent::save($options)) {
            return false;
        }
        /*if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.permissao_perfil_table'))->flush();
        }*/
        return true;
    }

    public function delete(array $options = [])
    {   //soft or hard
        if (!parent::delete($options)) {
            return false;
        }
        /*
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.permissao_perfil_table'))->flush();
        }
        */
        return true;
    }

    public function restore()
    {   //soft delete undo's
        if (!parent::restore()) {
            return false;
        }
        /*
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.permissao_perfil_table'))->flush();
        }
        */
        return true;
    }

   



    public function usuarios()
    {
        return $this->belongsToMany('App\User', 'perfils_users', 'perfil_id', 'user_id' );
    }


    public function permissoes()
    {
        return $this->belongsToMany( 'App\Models\Permissao', 'permissao_perfils', 'perfil_id', 'permissao_id');
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

    


    public function savePermissoes($inputPermissoes)
    {
        if (!empty($inputPermissoes)) {
            $this->permissoes()->sync($inputPermissoes);
        } else {
            $this->permissoes()->detach();
        }
        /*
        if (Cache::getStore() instanceof TaggableStore) {
            Cache::tags(Config::get('aal.permissao_perfil_table'))->flush();
        }*/
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




}

<?php

namespace App\Models;


//use Manzoli2122\AAL\Interfaces\AALPermissaoInterface; 


use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model //implements AALPermissaoInterface
{
     
      
    protected $table = 'permissoes';
     

    protected $fillable = [
            'nome', 'descricao', 
    ];

    protected $hidden = [
        'deleted_at' ,     'updated_at' ,  'created_at' , 'pivot'
    ];

    
        
    public function rules($id = '')
    {
            return [
                'nome' => 'required|min:3|max:100',
                'descricao' => "required|min:0|max:100",     
            ];
    }


    public function getDatatable()
    {
        return $this->select(['id', 'nome', 'descricao'  ]);        
    }


    //===================================================================================
    
     public function perfis()
    {
        return $this->belongsToMany('App\Models\Perfil' , 'permissao_perfils', 'permissao_id', 'perfil_id');
    }

   



    public static function boot()
    {
        parent::boot();
        static::deleting(function($permissao) {
            if (!method_exists('App\Models\Permissao' , 'bootSoftDeletes')) {
                $permissao->perfis()->sync([]);
            }
            return true;
        });
    }

    

    public  function permissaoParaAdicionarAoPerfil($perfil_id)
    {
        return $this->whereNotIn('id', function($query) use ($perfil_id){
            $query->select("permissao_perfils.permissao_id");
            $query->from("permissao_perfils");
            $query->whereRaw("permissao_perfils.perfil_id = {$perfil_id} ");
        } )
        ->orderBy('nome')->get();  
    }

    /*

    public  function permissos_sem_perfil($perfil_id)
    {
        return $this->whereNotIn('id', function($query) use ($perfil_id){
            $query->select("permissao_perfils.permissao_id");
            $query->from("permissao_perfils");
            $query->whereRaw("permissao_perfils.perfil_id = {$perfil_id} ");
        } )
        ->orderBy('nome')
        ->get();            
        
    }
*/

    

    public function attachPerfil($perfil){
        
        if(is_object($perfil)) {
            $perfil = $perfil->getKey();
        }
        $this->perfis()->attach($perfil);

    }
    
       
    public function detachPerfil($perfil){
        if (is_object($perfil)) {
            $perfil = $perfil->getKey();
        }
        $this->perfis()->detach($perfil);
    }
    




        
    public function attachPerfis($perfis){
        foreach ($perfis as $perfil) {
            $this->attachPerfil($perfil);
        }
    }
    
       
    public function detachPerfis($perfis=null){
        if (!$perfis) $perfis = $this->perfis()->get();
        foreach ($perfis as $perfil) {
            $this->detachRole($perfil);
        }
    }



}
